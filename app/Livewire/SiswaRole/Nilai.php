<?php

namespace App\Livewire\SiswaRole;

use App\Models\Nilai as NilaiModel;
use Livewire\Component;

class Nilai extends Component
{
    public $semester = 'Ganjil';
    public $tahun_ajaran = '2025/2026';

    public function render()
    {
        $siswa = auth()->user()->siswa;

        $nilais = NilaiModel::where('siswa_id', $siswa->id)
            ->where('semester', $this->semester)
            ->where('tahun_ajaran', $this->tahun_ajaran)
            ->with('mataPelajaran')
            ->get();

        $stats = [
            'rata_rata' => $nilais->avg('nilai_akhir') ?? 0,
            'tertinggi' => $nilais->max('nilai_akhir') ?? 0,
            'terendah' => $nilais->min('nilai_akhir') ?? 0,
            'total_mapel' => $nilais->count(),
        ];

        return view('livewire.siswa-role.nilai', [
            'nilais' => $nilais,
            'stats' => $stats,
            'chart_data' => [
                'labels' => $nilais->pluck('mataPelajaran.nama_mapel')->toArray(),
                'values' => $nilais->pluck('nilai_akhir')->toArray(),
            ]
        ]);
    }
}

