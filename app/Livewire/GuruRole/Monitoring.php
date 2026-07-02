<?php

namespace App\Livewire\GuruRole;

use App\Models\Nilai;
use App\Models\Jadwal;
use App\Models\Kelas;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Monitoring extends Component
{
    public $filterKelas = '';

    public function render()
    {
        $guru = Auth::user()->guru;
        $kelasIds = Jadwal::where('guru_id', $guru->id)->pluck('kelas_id')->unique();
        
        $query = Nilai::with(['siswa.user', 'mataPelajaran', 'siswa.kelas'])
            ->where('guru_id', $guru->id);

        if ($this->filterKelas) {
            $query->whereHas('siswa', function($q) {
                $q->where('kelas_id', $this->filterKelas);
            });
        }

        $allNilais = $query->get();

        // Statistics
        $avgNilai = $allNilais->avg('nilai_akhir') ?? 0;
        $tuntasCount = $allNilais->where('nilai_akhir', '>=', 75)->count();
        $remedialCount = $allNilais->where('nilai_akhir', '<', 75)->count();
        
        $siswaBermasalah = $allNilais->where('nilai_akhir', '<', 75)->sortBy('nilai_akhir')->take(10);

        // Chart Data
        $chartData = $allNilais->groupBy('mataPelajaran.nama_mapel')->map(function($group) {
            return $group->avg('nilai_akhir');
        });

        $kelases = Kelas::whereIn('id', $kelasIds)->get();

        return view('livewire.guru-role.monitoring', [
            'avgNilai' => $avgNilai,
            'tuntasCount' => $tuntasCount,
            'remedialCount' => $remedialCount,
            'siswaBermasalah' => $siswaBermasalah,
            'chartData' => $chartData,
            'kelases' => $kelases
        ])->layout('layouts.app');
    }
}
