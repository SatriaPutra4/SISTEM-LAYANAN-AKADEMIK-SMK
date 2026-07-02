<?php

namespace App\Livewire\Jurusan;

use App\Models\Jurusan;
use App\Models\ActivityLog;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $nama_jurusan, $kode_jurusan, $jurusan_id;
    public $showModal = false;

    public function resetFields()
    {
        $this->reset(['nama_jurusan', 'kode_jurusan', 'jurusan_id', 'showModal']);
    }

    public function save()
    {
        $this->validate([
            'nama_jurusan' => 'required',
            'kode_jurusan' => 'required',
        ]);

        $action = $this->jurusan_id ? 'memperbarui' : 'menambahkan';
        Jurusan::updateOrCreate(['id' => $this->jurusan_id], [
            'nama_jurusan' => $this->nama_jurusan,
            'kode_jurusan' => $this->kode_jurusan,
        ]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'description' => "{$action} data jurusan: {$this->nama_jurusan}",
            'type' => 'success'
        ]);

        $this->dispatch('notify', message: 'Data jurusan berhasil disimpan.', type: 'success');
        $this->resetFields();
        $this->dispatch('close-modal', 'modal-jurusan');
    }

    public function edit($id)
    {
        $jurusan = Jurusan::find($id);
        $this->jurusan_id = $id;
        $this->nama_jurusan = $jurusan->nama_jurusan;
        $this->kode_jurusan = $jurusan->kode_jurusan;
        $this->dispatch('open-modal', 'modal-jurusan');
    }

    public function confirmDelete($id)
    {
        $this->jurusan_id = $id;
        $this->dispatch('open-modal', 'confirm-jurusan-deletion');
    }

    public function deleteConfirmed()
    {
        $jurusan = Jurusan::find($this->jurusan_id);
        $nama = $jurusan->nama_jurusan;
        $jurusan->delete();

        ActivityLog::create([
            'user_id' => auth()->id(),
            'description' => "menghapus data jurusan: {$nama}",
            'type' => 'danger'
        ]);

        $this->dispatch('notify', message: 'Data jurusan berhasil dihapus.', type: 'success');
        $this->dispatch('close-modal', 'confirm-jurusan-deletion');
    }

    public function render()
    {
        return view('livewire.jurusan.index', [
            'jurusans' => Jurusan::paginate(10)
        ])->layout('layouts.app');
    }
}
