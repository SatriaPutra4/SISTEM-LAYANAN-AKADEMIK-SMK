<?php

namespace App\Livewire\GuruRole;

use App\Models\Siswa as SiswaModel;
use App\Models\Kelas;
use App\Models\Jadwal;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Siswa extends Component
{
    use WithPagination;

    public $search = '';
    public $filterKelas = '';
    public $selectedSiswa = null;

    protected $queryString = ['search', 'filterKelas'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterKelas()
    {
        $this->resetPage();
    }

    public function showDetail($id)
    {
        $this->selectedSiswa = SiswaModel::with(['user', 'kelas', 'jurusan'])->find($id);
        $this->dispatch('open-modal', 'modal-detail-siswa');
    }

    public function render()
    {
        $guru = Auth::user()->guru;
        
        // Get classes taught by this teacher
        $kelasIds = Jadwal::where('guru_id', $guru->id)->pluck('kelas_id')->unique();
        
        $query = SiswaModel::with(['user', 'kelas', 'jurusan'])
            ->whereIn('kelas_id', $kelasIds);

        if ($this->search) {
            $query->where(function($q) {
                $q->whereHas('user', function($qu) {
                    $qu->where('name', 'like', '%' . $this->search . '%');
                })->orWhere('nis', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filterKelas) {
            $query->where('kelas_id', $this->filterKelas);
        }

        $siswas = $query->paginate(10);
        $kelases = Kelas::whereIn('id', $kelasIds)->get();

        return view('livewire.guru-role.siswa', [
            'siswas' => $siswas,
            'kelases' => $kelases
        ])->layout('layouts.app');
    }
}
