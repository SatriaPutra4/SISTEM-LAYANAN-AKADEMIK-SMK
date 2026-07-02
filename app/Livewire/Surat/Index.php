<?php

namespace App\Livewire\Surat;

use App\Models\SuratPengajuan;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.surat.index', [
            'surats' => SuratPengajuan::where('siswa_id', auth()->user()->siswa->id)->latest()->paginate(10)
        ])->layout('layouts.app');
    }
}
