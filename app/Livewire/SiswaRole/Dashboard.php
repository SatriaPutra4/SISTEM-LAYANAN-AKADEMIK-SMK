<?php

namespace App\Livewire\SiswaRole;

use App\Models\Jadwal;
use App\Models\Nilai;
use App\Models\Pengumuman;
use App\Models\SuratPengajuan;
use App\Models\TagihanSpp;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $siswa = auth()->user()->siswa;

        $data = [
            'siswa' => $siswa,
            'jadwal_hari_ini' => Jadwal::where('kelas_id', $siswa->kelas_id)
                ->where('hari', $this->getHariIni())
                ->with(['mataPelajaran', 'guru.user'])
                ->get(),
            'ringkasan_nilai' => Nilai::where('siswa_id', $siswa->id)
                ->with('mataPelajaran')
                ->latest()
                ->take(5)
                ->get(),
            'status_spp' => TagihanSpp::where('siswa_id', $siswa->id)
                ->where('status', '!=', 'Lunas')
                ->first(),
            'pengajuan_terakhir' => SuratPengajuan::where('siswa_id', $siswa->id)
                ->latest()
                ->first(),
            'pengumuman_terbaru' => Pengumuman::whereIn('target_role', ['all', 'siswa'])
                ->where('status_publish', 'Published')
                ->latest()
                ->take(3)
                ->get(),
            'stats' => [
                'rata_rata_nilai' => Nilai::where('siswa_id', $siswa->id)->avg('nilai_akhir') ?? 0,
                'total_surat' => SuratPengajuan::where('siswa_id', $siswa->id)->count(),
                'spp_lunas' => TagihanSpp::where('siswa_id', $siswa->id)->where('status', 'Lunas')->count(),
            ],
            'chart_data' => $this->getChartData($siswa->id),
        ];

        return view('livewire.siswa-role.dashboard', $data);
    }

    private function getHariIni()
    {
        $hari = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu'
        ];
        return $hari[date('l')];
    }

    private function getChartData($siswaId)
    {
        $nilais = Nilai::where('siswa_id', $siswaId)
            ->with('mataPelajaran')
            ->latest()
            ->take(6)
            ->get()
            ->reverse();

        return [
            'labels' => $nilais->pluck('mataPelajaran.nama_mapel')->toArray(),
            'values' => $nilais->pluck('nilai_akhir')->toArray(),
        ];
    }
}

