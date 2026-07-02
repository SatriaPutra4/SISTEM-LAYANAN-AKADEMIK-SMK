<?php

namespace App\Livewire\SiswaRole;

use App\Models\TagihanSpp;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Spp extends Component
{
    use WithFileUploads, WithPagination;

    public $selected_tagihan_id;
    public $bukti_pembayaran;
    public $nominal_transfer;
    public $tanggal_transfer;
    public $catatan;
    public $is_modal_open = false;

    public function openModal($id)
    {
        $this->selected_tagihan_id = $id;
        $this->reset(['bukti_pembayaran', 'nominal_transfer', 'tanggal_transfer', 'catatan']);
        $this->tanggal_transfer = date('Y-m-d\TH:i');
        $this->is_modal_open = true;
    }

    public function closeModal()
    {
        $this->is_modal_open = false;
    }

    public function uploadBukti()
    {
        $this->validate([
            'bukti_pembayaran' => 'required|file|max:30720|mimes:jpg,jpeg,png,pdf',
            'nominal_transfer' => 'required|numeric|min:1',
            'tanggal_transfer' => 'required|date',
            'catatan' => 'nullable|string',
        ]);

        $tagihan = TagihanSpp::findOrFail($this->selected_tagihan_id);
        $path = $this->bukti_pembayaran->store('bukti-spp', 'public');

        $pembayaran = \App\Models\PembayaranSpp::create([
            'tagihan_spp_id' => $tagihan->id,
            'nominal_bayar' => $this->nominal_transfer,
            'tanggal_bayar' => $this->tanggal_transfer,
            'bukti_pembayaran' => $path,
            'status' => 'Menunggu Verifikasi',
            'catatan' => $this->catatan,
        ]);

        $admins = \App\Models\User::where('role', 'admin')->get();
        \Illuminate\Support\Facades\Notification::send($admins, new \App\Notifications\PembayaranSppNotification($pembayaran, auth()->user()->siswa));

        $this->closeModal();
        $this->dispatch('notify', message: 'Bukti pembayaran berhasil diunggah! Menunggu verifikasi Admin.', type: 'success');
    }

    public function render()
    {
        $siswa = auth()->user()->siswa;

        $tagihans = TagihanSpp::with(['pembayaranSpps' => function($q) {
            $q->orderBy('created_at', 'desc');
        }])->where('siswa_id', $siswa->id)
            ->latest()
            ->paginate(12);

        $total_tagihan = TagihanSpp::where('siswa_id', $siswa->id)->sum('nominal');
        $total_dibayar = TagihanSpp::where('siswa_id', $siswa->id)
            ->join('pembayaran_spps', 'tagihan_spps.id', '=', 'pembayaran_spps.tagihan_spp_id')
            ->where('pembayaran_spps.status', 'Disetujui')
            ->sum('pembayaran_spps.nominal_bayar');
        
        $sisa_tagihan = max(0, $total_tagihan - $total_dibayar);

        $stats = [
            'total_tagihan' => $total_tagihan,
            'total_dibayar' => $total_dibayar,
            'sisa_tagihan' => $sisa_tagihan,
            'persentase' => $total_tagihan > 0 ? min(100, round(($total_dibayar / $total_tagihan) * 100)) : 0,
        ];

        return view('livewire.siswa-role.spp', [
            'tagihans' => $tagihans,
            'stats' => $stats,
            'rekenings' => \App\Models\RekeningSekolah::all(),
        ]);
    }
}

