<?php

namespace App\Livewire\Pengumuman;

use App\Models\Pengumuman;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

use App\Models\ActivityLog;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $pengumuman_id;
    public $judul, $konten, $status_publish, $target_role;
    public $isEdit = false;

    protected $queryString = ['search'];

    public function render()
    {
        $pengumumans = Pengumuman::with('author')
            ->when($this->search, function($q) {
                $q->where('judul', 'like', '%' . $this->search . '%')
                  ->orWhere('konten', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.pengumuman.index', [
            'pengumumans' => $pengumumans,
        ])->layout('layouts.app');
    }

    public function updatingSearch() { $this->resetPage(); }

    public function resetFields()
    {
        $this->pengumuman_id = null;
        $this->judul = '';
        $this->konten = '';
        $this->status_publish = 'Draft';
        $this->target_role = 'all';
        $this->isEdit = false;
    }

    public function create()
    {
        $this->resetFields();
        $this->dispatch('open-modal', 'modal-pengumuman');
    }

    public function store()
    {
        $this->validate([
            'judul' => 'required|min:5',
            'konten' => 'required',
            'status_publish' => 'required|in:Draft,Published',
            'target_role' => 'required|in:all,guru,siswa',
        ]);

        $p = Pengumuman::updateOrCreate(['id' => $this->pengumuman_id], [
            'judul' => $this->judul,
            'konten' => $this->konten,
            'status_publish' => $this->status_publish,
            'target_role' => $this->target_role,
            'author_id' => auth()->id(),
        ]);

        $action = $this->pengumuman_id ? 'memperbarui' : 'menerbitkan';
        ActivityLog::create([
            'user_id' => auth()->id(),
            'description' => "{$action} pengumuman: {$this->judul}",
            'type' => 'success'
        ]);

        $this->dispatch('notify', message: $this->pengumuman_id ? 'Pengumuman berhasil diupdate.' : 'Pengumuman berhasil diterbitkan.', type: 'success');
        
        $this->resetFields();
        $this->dispatch('close-modal', 'modal-pengumuman');
    }

    public function edit($id)
    {
        $p = Pengumuman::findOrFail($id);
        $this->pengumuman_id = $id;
        $this->judul = $p->judul;
        $this->konten = $p->konten;
        $this->status_publish = $p->status_publish;
        $this->target_role = $p->target_role;
        $this->isEdit = true;
        $this->dispatch('open-modal', 'modal-pengumuman');
    }

    public function confirmDelete($id)
    {
        $this->pengumuman_id = $id;
        $this->dispatch('open-modal', 'confirm-pengumuman-deletion');
    }

    public function deleteConfirmed()
    {
        $p = Pengumuman::findOrFail($this->pengumuman_id);
        $judul = $p->judul;
        $p->delete();

        ActivityLog::create([
            'user_id' => auth()->id(),
            'description' => "menghapus pengumuman: {$judul}",
            'type' => 'danger'
        ]);

        $this->dispatch('notify', message: 'Pengumuman berhasil dihapus.', type: 'success');
        $this->dispatch('close-modal', 'confirm-pengumuman-deletion');
        $this->resetFields();
    }
}
