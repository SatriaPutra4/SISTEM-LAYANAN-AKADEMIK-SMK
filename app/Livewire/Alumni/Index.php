<?php

namespace App\Livewire\Alumni;

use App\Models\Siswa;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $tahun_lulus = '';
    public $selectedSiswa;

    public function show($id)
    {
        $this->selectedSiswa = Siswa::with(['user', 'kelas', 'jurusan'])->find($id);
        $this->dispatch('open-modal', 'modal-view-alumni');
    }

    public function render()
    {
        $query = Siswa::with(['user', 'kelas', 'jurusan'])
            ->where('status', 'lulus');

        if (!empty($this->search)) {
            $query->where(function($q) {
                $q->where('nis', 'like', '%' . $this->search . '%')
                  ->orWhereHas('user', function($userQuery) {
                      $userQuery->where('name', 'like', '%' . $this->search . '%');
                  });
            });
        }

        if (!empty($this->tahun_lulus)) {
            $query->where('tahun_lulus', $this->tahun_lulus);
        }
        
        return view('livewire.alumni.index', [
            'alumnis' => $query->latest()->paginate(10),
            'tahunList' => Siswa::where('status', 'lulus')->distinct()->pluck('tahun_lulus')->filter()->sortDesc()
        ])->layout('layouts.app');
    }
}
