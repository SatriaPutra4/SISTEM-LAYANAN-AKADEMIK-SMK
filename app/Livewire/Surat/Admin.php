<?php

namespace App\Livewire\Surat;

use App\Models\SuratPengajuan;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Admin extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $filterStatus = '';
    public $selectedSurat;
    public $keterangan_admin;
    public $file_surat;

    public function render()
    {
        $query = SuratPengajuan::with('siswa.user');

        if ($this->filterStatus) {
            $query->where('status', $this->filterStatus);
        }

        if ($this->search) {
            $query->whereHas('siswa.user', function($q) {
                $q->where('name', 'like', '%' . $this->search . '%');
            });
        }

        return view('livewire.surat.admin', [
            'surats' => $query->latest()->paginate(10)
        ])->layout('layouts.app');
    }

    public function showVerifikasi($id)
    {
        $this->selectedSurat = SuratPengajuan::with('siswa.user')->find($id);
        $this->keterangan_admin = $this->selectedSurat->keterangan_admin;
        $this->file_surat = null;
        $this->dispatch('open-modal', 'modal-verifikasi-surat');
    }

    public function updateStatus($status)
    {
        $data = [
            'status' => $status,
            'keterangan_admin' => $this->keterangan_admin
        ];

        if ($status === 'Disetujui' && $this->file_surat) {
            if ($this->selectedSurat->file_url) {
                Storage::disk('public')->delete($this->selectedSurat->file_url);
            }
            $data['file_url'] = $this->file_surat->store('surat-final', 'public');
        }

        $this->selectedSurat->update($data);

        if (in_array($status, ['Disetujui', 'Ditolak'])) {
            $user = $this->selectedSurat->siswa->user;
            $user->notify(new \App\Notifications\StatusSuratNotification($this->selectedSurat, $status, $this->keterangan_admin));
        }

        $this->dispatch('notify', message: 'Status surat berhasil diperbarui.', type: 'success');
        $this->dispatch('close-modal', 'modal-verifikasi-surat');
    }
}
