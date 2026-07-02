<?php

namespace App\Livewire\GuruRole\Nilai;

use App\Models\Nilai;
use App\Models\Jadwal;
use App\Models\MataPelajaran;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Riwayat extends Component
{
    use WithPagination;

    public $filterTahun = '';
    public $filterSemester = '';
    public $filterMapel = '';

    protected $queryString = ['filterTahun', 'filterSemester', 'filterMapel'];

    public function updatingFilterTahun() { $this->resetPage(); }
    public function updatingFilterSemester() { $this->resetPage(); }
    public function updatingFilterMapel() { $this->resetPage(); }

    public function render()
    {
        $guru = Auth::user()->guru;
        $mapelIds = Jadwal::where('guru_id', $guru->id)->pluck('mata_pelajaran_id')->unique();

        $query = Nilai::with(['siswa.user', 'mataPelajaran'])
            ->where('guru_id', $guru->id);

        if ($this->filterTahun) {
            $query->where('tahun_ajaran', $this->filterTahun);
        }

        if ($this->filterSemester) {
            $query->where('semester', $this->filterSemester);
        }

        if ($this->filterMapel) {
            $query->where('mata_pelajaran_id', $this->filterMapel);
        }

        $nilais = $query->latest()->paginate(15);
        $mapels = MataPelajaran::whereIn('id', $mapelIds)->get();
        
        $tahunAjarans = Nilai::where('guru_id', $guru->id)->distinct()->pluck('tahun_ajaran');

        return view('livewire.guru-role.nilai.riwayat', [
            'nilais' => $nilais,
            'mapels' => $mapels,
            'tahunAjarans' => $tahunAjarans
        ])->layout('layouts.app');
    }
}
