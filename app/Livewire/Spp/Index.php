<?php

namespace App\Livewire\Spp;

use App\Models\TagihanSpp;
use App\Models\Siswa;
use App\Models\Kelas;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\ActivityLog;
use App\Exports\SppExport;
use Maatwebsite\Excel\Facades\Excel;

class Index extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $filterStatus = '';
    public $filterKelas = '';
    
    // Form fields for creating tagihan
    public $siswa_id, $tahun_ajaran, $nominal, $keterangan;
    public $isBatch = false;
    
    // For verification
    public $selectedTagihan;
    public $keterangan_admin;

    public function render()
    {
        $query = TagihanSpp::with(['siswa.user', 'siswa.kelas'])
            ->whereHas('siswa.user', function($q) {
                $q->where('name', 'like', '%' . $this->search . '%');
            });

        if ($this->filterStatus) {
            if ($this->filterStatus === 'Menunggu Verifikasi') {
                $query->whereHas('pembayaranSpps', function($q) {
                    $q->where('status', 'Menunggu Verifikasi');
                });
            } elseif ($this->filterStatus === 'Belum Bayar') {
                $query->where('status', 'Belum Lunas');
            } else {
                $query->where('status', $this->filterStatus);
            }
        }

        if ($this->filterKelas) {
            $query->whereHas('siswa', function($q) {
                $q->where('kelas_id', $this->filterKelas);
            });
        }

        return view('livewire.spp.index', [
            'tagihans' => $query->latest()->paginate(10),
            'siswas' => Siswa::with('user')->get(),
            'kelases' => Kelas::all(),
        ])->layout('layouts.app');
    }

    public function export()
    {
        ActivityLog::create([
            'user_id' => auth()->id(),
            'description' => "mengekspor data tagihan SPP ke Excel",
            'type' => 'info'
        ]);

        return Excel::download(new SppExport, 'data-spp-' . now()->format('Y-m-d') . '.xlsx');
    }

    public function createTagihan()
    {
        $this->validate([
            'tahun_ajaran' => 'required',
            'nominal' => 'required|numeric',
        ]);

        if ($this->isBatch) {
            $siswas = Siswa::all();
            foreach ($siswas as $siswa) {
                TagihanSpp::create([
                    'siswa_id' => $siswa->id,
                    'tahun_ajaran' => $this->tahun_ajaran,
                    'nominal' => $this->nominal,
                    'status' => 'Belum Lunas',
                ]);
            }

            ActivityLog::create([
                'user_id' => auth()->id(),
                'description' => "membuat tagihan SPP massal untuk Tahun Ajaran {$this->tahun_ajaran}",
                'type' => 'success'
            ]);

            $this->dispatch('notify', message: 'Tagihan batch berhasil dibuat untuk semua siswa.', type: 'success');
        } else {
            $this->validate(['siswa_id' => 'required']);
            $tagihan = TagihanSpp::create([
                'siswa_id' => $this->siswa_id,
                'tahun_ajaran' => $this->tahun_ajaran,
                'nominal' => $this->nominal,
                'status' => 'Belum Lunas',
                'keterangan' => $this->keterangan,
            ]);

            $nama = Siswa::with('user')->find($this->siswa_id)->user->name;
            ActivityLog::create([
                'user_id' => auth()->id(),
                'description' => "membuat tagihan SPP untuk {$nama} ({$this->tahun_ajaran})",
                'type' => 'success'
            ]);

            $this->dispatch('notify', message: 'Tagihan berhasil dibuat.', type: 'success');
        }

        $this->reset(['siswa_id', 'tahun_ajaran', 'nominal', 'keterangan', 'isBatch']);
        $this->dispatch('close-modal', 'modal-tagihan');
    }

    public function showVerifikasi($id)
    {
        $this->selectedTagihan = TagihanSpp::with('siswa.user')->find($id);
        $this->dispatch('open-modal', 'modal-verifikasi');
    }

    public function verifikasi($status)
    {
        $this->selectedTagihan->update([
            'status' => $status === 'setuju' ? 'Lunas' : 'Belum Lunas',
            'keterangan' => $this->keterangan_admin,
            'tanggal_pembayaran' => $status === 'setuju' ? now() : null,
        ]);

        $nama = $this->selectedTagihan->siswa->user->name;
        $statusTeks = $status === 'setuju' ? 'menyetujui' : 'menolak';
        
        ActivityLog::create([
            'user_id' => auth()->id(),
            'description' => "{$statusTeks} pembayaran SPP {$nama} ({$this->selectedTagihan->bulan})",
            'type' => $status === 'setuju' ? 'success' : 'danger'
        ]);

        $this->dispatch('notify', message: 'Status pembayaran berhasil diperbarui.', type: 'success');
        $this->dispatch('close-modal', 'modal-verifikasi');
        $this->reset(['selectedTagihan', 'keterangan_admin']);
    }
}
