<?php

namespace App\Livewire\GuruRole;

use App\Models\Jadwal as JadwalModel;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Jadwal extends Component
{
    public $filterHari = '';

    public function render()
    {
        $guru = Auth::user()->guru;
        
        $query = JadwalModel::with(['kelas.jurusan', 'mataPelajaran'])
            ->where('guru_id', $guru->id);

        if ($this->filterHari) {
            $query->where('hari', $this->filterHari);
        }

        $jadwals = $query->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu')")
            ->orderBy('jam_mulai')
            ->get()
            ->groupBy('hari');

        return view('livewire.guru-role.jadwal', [
            'jadwals' => $jadwals
        ])->layout('layouts.app');
    }
}
