<?php

namespace App\Livewire\SiswaRole;

use App\Models\Jadwal as JadwalModel;
use Livewire\Component;

class Jadwal extends Component
{
    public $hari_dipilih = '';

    public function mount()
    {
        $this->hari_dipilih = $this->getHariIni();
    }

    public function setHari($hari)
    {
        $this->hari_dipilih = $hari;
    }

    public function render()
    {
        $siswa = auth()->user()->siswa;

        $jadwals = JadwalModel::where('kelas_id', $siswa->kelas_id)
            ->where('hari', $this->hari_dipilih)
            ->with(['mataPelajaran', 'guru.user'])
            ->orderBy('jam_mulai')
            ->get();

        return view('livewire.siswa-role.jadwal', [
            'jadwals' => $jadwals,
            'daftar_hari' => ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu']
        ]);
    }

    private function getHariIni()
    {
        $hari = [
            'Sunday' => 'Senin', // Default to Senin if Sunday
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu'
        ];
        return $hari[date('l')];
    }
}

