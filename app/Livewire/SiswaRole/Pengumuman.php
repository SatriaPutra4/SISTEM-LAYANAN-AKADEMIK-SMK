<?php

namespace App\Livewire\SiswaRole;

use App\Models\Pengumuman as PengumumanModel;
use Livewire\Component;
use Livewire\WithPagination;

class Pengumuman extends Component
{
    use WithPagination;

    public $search = '';
    public $selected_pengumuman = null;
    public $is_modal_open = false;

    public function showDetail($id)
    {
        $this->selected_pengumuman = PengumumanModel::find($id);
        $this->is_modal_open = true;
    }

    public function closeModal()
    {
        $this->is_modal_open = false;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $pengumumans = PengumumanModel::whereIn('target_role', ['all', 'siswa'])
            ->where('status_publish', 'Published')
            ->where(function($query) {
                $query->where('judul', 'like', '%' . $this->search . '%')
                      ->orWhere('konten', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(6);

        return view('livewire.siswa-role.pengumuman', [
            'pengumumans' => $pengumumans
        ]);
    }
}

