<?php

namespace App\Livewire\Admin;

use App\Models\RekeningSekolah;
use Livewire\Component;

class PengaturanPembayaran extends Component
{
    public $rekenings;
    public $rekening_id, $nama_bank, $nomor_rekening, $nama_pemilik;
    public $is_modal_open = false;

    public function mount()
    {
        $this->loadRekenings();
    }

    public function loadRekenings()
    {
        $this->rekenings = RekeningSekolah::all();
    }

    public function openModal()
    {
        $this->resetInputFields();
        $this->dispatch('open-modal', 'modal-rekening');
    }

    public function closeModal()
    {
        $this->dispatch('close-modal', 'modal-rekening');
        $this->resetInputFields();
    }

    private function resetInputFields()
    {
        $this->rekening_id = '';
        $this->nama_bank = '';
        $this->nomor_rekening = '';
        $this->nama_pemilik = '';
    }

    public function store()
    {
        $this->validate([
            'nama_bank' => 'required|string|max:255',
            'nomor_rekening' => 'required|string|max:255',
            'nama_pemilik' => 'required|string|max:255',
        ]);

        RekeningSekolah::updateOrCreate(
            ['id' => $this->rekening_id],
            [
                'nama_bank' => $this->nama_bank,
                'nomor_rekening' => $this->nomor_rekening,
                'nama_pemilik' => $this->nama_pemilik,
            ]
        );

        $this->dispatch('notify', message: $this->rekening_id ? 'Rekening berhasil diupdate.' : 'Rekening berhasil ditambahkan.', type: 'success');
        $this->closeModal();
        $this->loadRekenings();
    }

    public function edit($id)
    {
        $rekening = RekeningSekolah::findOrFail($id);
        $this->rekening_id = $id;
        $this->nama_bank = $rekening->nama_bank;
        $this->nomor_rekening = $rekening->nomor_rekening;
        $this->nama_pemilik = $rekening->nama_pemilik;

        $this->dispatch('open-modal', 'modal-rekening');
    }

    public function delete($id)
    {
        RekeningSekolah::findOrFail($id)->delete();
        $this->dispatch('notify', message: 'Rekening berhasil dihapus.', type: 'success');
        $this->loadRekenings();
    }

    public function render()
    {
        return view('livewire.admin.pengaturan-pembayaran')->layout('layouts.app');
    }
}
