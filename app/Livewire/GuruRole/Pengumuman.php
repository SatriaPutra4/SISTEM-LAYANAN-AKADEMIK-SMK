<?php

namespace App\Livewire\GuruRole;

use App\Models\Pengumuman as PengumumanModel;
use Livewire\Component;
use Livewire\WithPagination;

class Pengumuman extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        $pengumumans = PengumumanModel::where('status_publish', true)
            ->where(function($q) {
                $q->where('target_role', 'all')
                  ->orWhere('target_role', 'guru');
            })
            ->where(function($q) {
                $q->where('judul', 'like', '%' . $this->search . '%')
                  ->orWhere('konten', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.guru-role.pengumuman', [
            'pengumumans' => $pengumumans
        ])->layout('layouts.app');
    }
}
