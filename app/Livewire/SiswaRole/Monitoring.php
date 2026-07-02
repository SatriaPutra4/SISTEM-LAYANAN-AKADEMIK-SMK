<?php

namespace App\Livewire\SiswaRole;

use App\Models\Nilai;
use Livewire\Component;

class Monitoring extends Component
{
    public function render()
    {
        $siswa = auth()->user()->siswa;

        $nilais = Nilai::where('siswa_id', $siswa->id)
            ->with('mataPelajaran')
            ->get();

        $performance_data = [
            'labels' => $nilais->pluck('mataPelajaran.nama_mapel')->toArray(),
            'tugas' => $nilais->pluck('tugas')->toArray(),
            'uts' => $nilais->pluck('uts')->toArray(),
            'uas' => $nilais->pluck('uas')->toArray(),
            'akhir' => $nilais->pluck('nilai_akhir')->toArray(),
        ];

        return view('livewire.siswa-role.monitoring', [
            'performance_data' => $performance_data,
            'avg_akhir' => $nilais->avg('nilai_akhir') ?? 0,
            'total_mapel' => $nilais->count(),
        ]);
    }
}

