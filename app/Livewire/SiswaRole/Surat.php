<?php

namespace App\Livewire\SiswaRole;

use App\Models\SuratPengajuan;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Surat extends Component
{
    use WithFileUploads, WithPagination;

    public $jenis_surat = '';
    public $keperluan = '';
    public $deskripsi = '';
    public $dokumen_pendukung;

    public $is_modal_open = false;
    public $confirm_cancel_id = null;

    public function openModal()
    {
        $this->reset(['jenis_surat', 'keperluan', 'deskripsi', 'dokumen_pendukung']);
        $this->is_modal_open = true;
    }

    public function closeModal()
    {
        $this->is_modal_open = false;
    }

    public function batalkanPengajuan($id)
    {
        $surat = SuratPengajuan::where('siswa_id', auth()->user()->siswa->id)
            ->where('id', $id)
            ->where('status', 'Diproses')
            ->first();

        if ($surat) {
            $surat->delete();
            $this->dispatch('notify', message: 'Pengajuan surat berhasil dibatalkan!', type: 'success');
        } else {
            $this->dispatch('notify', message: 'Pengajuan tidak dapat dibatalkan.', type: 'error');
        }
        
        $this->confirm_cancel_id = null;
    }

    public function ajukanSurat()
    {
        try {
            $this->validate([
                'jenis_surat' => 'required',
                'keperluan' => 'required|string|min:10',
                'deskripsi' => 'nullable|string',
                'dokumen_pendukung' => 'nullable|file|max:2048|mimes:pdf,jpg,png',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatch('notify', message: 'Validasi gagal, pastikan data terisi dengan benar.', type: 'error');
            throw $e;
        }

        $data = [
            'siswa_id' => auth()->user()->siswa->id,
            'jenis_surat' => $this->jenis_surat,
            'keperluan' => $this->keperluan,
            'deskripsi' => $this->deskripsi,
            'status' => 'Diproses',
        ];

        if ($this->dokumen_pendukung) {
            $data['dokumen_pendukung'] = $this->dokumen_pendukung->store('surat-pendukung', 'public');
        }

        $surat = SuratPengajuan::create($data);

        $admins = \App\Models\User::where('role', 'admin')->get();
        \Illuminate\Support\Facades\Notification::send($admins, new \App\Notifications\SuratPengajuanNotification($surat, auth()->user()->siswa));

        $this->closeModal();
        $this->dispatch('notify', message: 'Pengajuan surat berhasil dikirim!', type: 'success');
    }

    public function render()
    {
        $pengajuans = SuratPengajuan::where('siswa_id', auth()->user()->siswa->id)
            ->latest()
            ->paginate(10);

        return view('livewire.siswa-role.surat', [
            'pengajuans' => $pengajuans,
            'daftar_jenis' => ['Surat Izin', 'Surat Keterangan Siswa', 'Surat PKL']
        ]);
    }
}

