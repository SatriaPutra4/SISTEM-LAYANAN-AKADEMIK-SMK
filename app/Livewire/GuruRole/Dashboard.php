<?php

namespace App\Livewire\GuruRole;

use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Jadwal;
use App\Models\Nilai;
use App\Models\Pengumuman;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Dashboard extends Component
{
    public function render()
    {
        $user = Auth::user();
        $guru = $user->guru;

        if (!$guru) {
            return <<<'HTML'
                <div>Profile Guru tidak ditemukan. Silahkan hubungi admin.</div>
            HTML;
        }

        $totalKelas = Jadwal::where('guru_id', $guru->id)->distinct('kelas_id')->count('kelas_id');
        $totalMapel = Jadwal::where('guru_id', $guru->id)->distinct('mata_pelajaran_id')->count('mata_pelajaran_id');
        
        $kelasIds = Jadwal::where('guru_id', $guru->id)->pluck('kelas_id')->unique();
        $totalSiswa = Siswa::whereIn('kelas_id', $kelasIds)->count();

        $hariIni = Carbon::now()->translatedFormat('l');
        // Map English day to Indonesian if necessary, but Carbon translatedFormat should handle it if locale is set.
        // Let's assume the database uses Indonesian days since it's "hari".
        $jadwalHariIni = Jadwal::with(['kelas', 'mataPelajaran'])
            ->where('guru_id', $guru->id)
            ->where('hari', $hariIni)
            ->orderBy('jam_mulai')
            ->get();

        $pengumumanTerbaru = Pengumuman::where('status_publish', true)
            ->where(function($q) {
                $q->where('target_role', 'all')
                  ->orWhere('target_role', 'guru');
            })
            ->latest()
            ->take(5)
            ->get();

        // Statistics for Chart.js
        $statsNilai = Nilai::where('guru_id', $guru->id)
            ->selectRaw('AVG(nilai_akhir) as average, mata_pelajaran_id')
            ->groupBy('mata_pelajaran_id')
            ->with('mataPelajaran')
            ->get();

        return view('livewire.guru-role.dashboard', [
            'totalSiswa' => $totalSiswa,
            'totalKelas' => $totalKelas,
            'totalMapel' => $totalMapel,
            'jadwalHariIni' => $jadwalHariIni,
            'pengumumanTerbaru' => $pengumumanTerbaru,
            'statsNilai' => $statsNilai
        ])->layout('layouts.app');
    }
}
