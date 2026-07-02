<?php

namespace App\Livewire\Jadwal;

use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\Guru;
use App\Models\MataPelajaran;
use App\Models\ActivityLog;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $filterKelas = '';
    public $filterGuru = '';
    
    public $jadwal_id;
    public $kelas_id, $mata_pelajaran_id, $guru_id, $hari, $jam_mulai, $jam_selesai;
    public $isEdit = false;

    protected $queryString = ['search', 'filterKelas', 'filterGuru'];

    public function render()
    {
        $jadwals = Jadwal::with(['kelas', 'guru', 'mataPelajaran'])
            ->when($this->search, function($q) {
                $q->whereHas('mataPelajaran', function($query) {
                    $query->where('nama_mapel', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterKelas, function($q) {
                $q->where('kelas_id', $this->filterKelas);
            })
            ->when($this->filterGuru, function($q) {
                $q->where('guru_id', $this->filterGuru);
            })
            ->orderBy('hari')
            ->orderBy('jam_mulai')
            ->paginate(10);

        return view('livewire.jadwal.index', [
            'jadwals' => $jadwals,
            'kelases' => Kelas::all(),
            'gurus' => Guru::all(),
            'mataPelajarans' => MataPelajaran::all(),
            'haris' => ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu']
        ])->layout('layouts.app');
    }

    public function updatingSearch() { $this->resetPage(); }
    public function updatingFilterKelas() { $this->resetPage(); }
    public function updatingFilterGuru() { $this->resetPage(); }

    public function resetFields()
    {
        $this->jadwal_id = null;
        $this->kelas_id = '';
        $this->mata_pelajaran_id = '';
        $this->guru_id = '';
        $this->hari = '';
        $this->jam_mulai = '';
        $this->jam_selesai = '';
        $this->isEdit = false;
    }

    public function create()
    {
        $this->resetFields();
        $this->dispatch('open-modal', 'modal-jadwal');
    }

    public function store()
    {
        $this->validate([
            'kelas_id' => 'required',
            'mata_pelajaran_id' => 'required',
            'guru_id' => 'required',
            'hari' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ]);

        $action = $this->jadwal_id ? 'memperbarui' : 'menambahkan';
        Jadwal::updateOrCreate(['id' => $this->jadwal_id], [
            'kelas_id' => $this->kelas_id,
            'mata_pelajaran_id' => $this->mata_pelajaran_id,
            'guru_id' => $this->guru_id,
            'hari' => $this->hari,
            'jam_mulai' => $this->jam_mulai,
            'jam_selesai' => $this->jam_selesai,
        ]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'description' => "{$action} jadwal pelajaran untuk kelas " . Kelas::find($this->kelas_id)->nama_kelas,
            'type' => 'success'
        ]);

        $this->dispatch('notify', message: 'Jadwal berhasil disimpan.', type: 'success');
        
        $this->resetFields();
        $this->dispatch('close-modal', 'modal-jadwal');
    }

    public function edit($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $this->jadwal_id = $id;
        $this->kelas_id = $jadwal->kelas_id;
        $this->mata_pelajaran_id = $jadwal->mata_pelajaran_id;
        $this->guru_id = $jadwal->guru_id;
        $this->hari = $jadwal->hari;
        $this->jam_mulai = $jadwal->jam_mulai;
        $this->jam_selesai = $jadwal->jam_selesai;
        $this->isEdit = true;
        $this->dispatch('open-modal', 'modal-jadwal');
    }

    public function confirmDelete($id)
    {
        $this->jadwal_id = $id;
        $this->dispatch('open-modal', 'confirm-jadwal-deletion');
    }

    public function deleteConfirmed()
    {
        $jadwal = Jadwal::with('kelas')->findOrFail($this->jadwal_id);
        $kelas = $jadwal->kelas->nama_kelas;
        $jadwal->delete();

        ActivityLog::create([
            'user_id' => auth()->id(),
            'description' => "menghapus jadwal pelajaran kelas {$kelas}",
            'type' => 'danger'
        ]);

        $this->dispatch('notify', message: 'Jadwal berhasil dihapus.', type: 'success');
        $this->dispatch('close-modal', 'confirm-jadwal-deletion');
        $this->resetFields();
    }
}
