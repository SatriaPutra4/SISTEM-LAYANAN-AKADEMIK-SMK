<?php

namespace App\Livewire\Kelas;

use App\Models\Kelas;
use App\Models\ActivityLog;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $nama_kelas, $jurusan_id, $kelas_id;
    public $search = '';
    public $showModal = false;

    public function resetFields()
    {
        $this->reset(['nama_kelas', 'jurusan_id', 'kelas_id', 'showModal', 'search']);
    }

    public function save()
    {
        $this->validate([
            'nama_kelas' => 'required|unique:kelas,nama_kelas,' . ($this->kelas_id ?? 'NULL'),
            'jurusan_id' => 'required',
        ]);

        $action = $this->kelas_id ? 'memperbarui' : 'menambahkan';
        Kelas::updateOrCreate(['id' => $this->kelas_id], [
            'nama_kelas' => $this->nama_kelas,
            'jurusan_id' => $this->jurusan_id,
        ]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'description' => "{$action} data kelas: {$this->nama_kelas}",
            'type' => 'success'
        ]);

        $this->dispatch('notify', message: 'Data kelas berhasil disimpan.', type: 'success');
        $this->resetFields();
        $this->dispatch('close-modal', 'modal-kelas');
    }

    public function edit($id)
    {
        $kelas = Kelas::find($id);
        $this->kelas_id = $id;
        $this->nama_kelas = $kelas->nama_kelas;
        $this->jurusan_id = $kelas->jurusan_id;
        $this->dispatch('open-modal', 'modal-kelas');
    }

    public function confirmDelete($id)
    {
        $this->kelas_id = $id;
        $this->dispatch('open-modal', 'confirm-kelas-deletion');
    }

    public function deleteConfirmed()
    {
        $kelas = Kelas::find($this->kelas_id);
        $nama = $kelas->nama_kelas;
        $kelas->delete();

        ActivityLog::create([
            'user_id' => auth()->id(),
            'description' => "menghapus data kelas: {$nama}",
            'type' => 'danger'
        ]);

        $this->dispatch('notify', message: 'Data kelas berhasil dihapus.', type: 'success');
        $this->dispatch('close-modal', 'confirm-kelas-deletion');
    }

    public function render()
    {
        $kelases = Kelas::with('jurusan')
            ->where('nama_kelas', 'like', '%' . $this->search . '%')
            ->paginate(10);

        return view('livewire.kelas.index', [
            'kelases' => $kelases,
            'jurusans' => \App\Models\Jurusan::all()
        ])->layout('layouts.app');
    }
}
