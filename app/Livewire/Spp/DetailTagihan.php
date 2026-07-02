<?php

namespace App\Livewire\Spp;

use App\Models\TagihanSpp;
use App\Models\PembayaranSpp;
use Livewire\Component;
use Livewire\WithPagination;

class DetailTagihan extends Component
{
    use WithPagination;

    public $tagihan_id;
    public $tagihan;
    public $selectedPembayaran;
    public $keterangan_admin;
    
    public function mount($id)
    {
        $this->tagihan_id = $id;
        $this->tagihan = TagihanSpp::with('siswa.user', 'siswa.kelas')->findOrFail($id);
    }

    public function showVerifikasi($id)
    {
        $this->selectedPembayaran = PembayaranSpp::findOrFail($id);
        $this->keterangan_admin = $this->selectedPembayaran->catatan;
        $this->dispatch('open-modal', 'modal-verifikasi');
    }

    public function verifikasi($status)
    {
        $this->selectedPembayaran->update([
            'status' => $status === 'setuju' ? 'Disetujui' : 'Ditolak',
            'catatan' => $this->keterangan_admin,
        ]);

        // Cek total dibayar jika disetujui
        if ($status === 'setuju') {
            $total_dibayar = PembayaranSpp::where('tagihan_spp_id', $this->tagihan_id)
                ->where('status', 'Disetujui')
                ->sum('nominal_bayar');

            if ($total_dibayar >= $this->tagihan->nominal) {
                $this->tagihan->update(['status' => 'Lunas']);
            }
        }

        $user = $this->tagihan->siswa->user;
        $statusStr = $status === 'setuju' ? 'Disetujui' : 'Ditolak';
        $user->notify(new \App\Notifications\StatusPembayaranNotification($this->selectedPembayaran, $statusStr, $this->keterangan_admin));

        \App\Models\ActivityLog::create([
            'user_id' => auth()->id(),
            'description' => ($status === 'setuju' ? 'Menyetujui' : 'Menolak') . " pembayaran SPP {$user->name} untuk Tahun Ajaran {$this->tagihan->tahun_ajaran}",
            'type' => $status === 'setuju' ? 'success' : 'danger'
        ]);

        $this->dispatch('notify', message: 'Status pembayaran berhasil diperbarui.', type: 'success');
        $this->dispatch('close-modal', 'modal-verifikasi');
        $this->reset(['selectedPembayaran', 'keterangan_admin']);
    }

    public function render()
    {
        $pembayarans = PembayaranSpp::where('tagihan_spp_id', $this->tagihan_id)
            ->latest()
            ->paginate(10);

        return view('livewire.spp.detail-tagihan', [
            'pembayarans' => $pembayarans
        ])->layout('layouts.app');
    }
}
