<?php

namespace App\Livewire\MataPelajaran;

use Livewire\Component;
use App\Models\MataPelajaran;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $nama_mapel;
    public $kode_mapel;

    protected $rules = [
        'nama_mapel' => 'required|min:3',
        'kode_mapel' => 'required|unique:mata_pelajarans,kode_mapel',
    ];

    public function store()
    {
        $this->validate();

        MataPelajaran::create([
            'nama_mapel' => $this->nama_mapel,
            'kode_mapel' => $this->kode_mapel,
        ]);

        $this->dispatch('flash-message', message: 'Mata Pelajaran berhasil ditambahkan.');
        $this->reset(['nama_mapel', 'kode_mapel']);
    }

    public function delete($id)
    {
        MataPelajaran::findOrFail($id)->delete();
        $this->dispatch('flash-message', message: 'Mata Pelajaran berhasil dihapus.');
    }

    public function render()
    {
        $mataPelajarans = MataPelajaran::where('nama_mapel', 'like', '%' . $this->search . '%')
            ->paginate(10);

        return view('livewire.mata-pelajaran.index', [
            'mataPelajarans' => $mataPelajarans
        ]);
    }
}
