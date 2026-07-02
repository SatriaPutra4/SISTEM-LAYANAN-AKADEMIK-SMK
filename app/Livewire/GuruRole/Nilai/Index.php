<?php

namespace App\Livewire\GuruRole\Nilai;

use App\Models\Nilai;
use App\Models\Siswa;
use App\Models\Jadwal;
use App\Models\MataPelajaran;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $filterKelas = '';
    public $filterMapel = '';
    
    // Form fields
    public $siswa_id, $mata_pelajaran_id, $tugas = 0, $uts = 0, $uas = 0, $nilai_id;
    public $semester = 'Ganjil', $tahun_ajaran = '2025/2026';

    public $showModal = false;

    protected $queryString = ['search', 'filterKelas', 'filterMapel'];

    public function updatingSearch() { $this->resetPage(); }
    public function updatingFilterKelas() { $this->resetPage(); }
    public function updatingFilterMapel() { $this->resetPage(); }

    public function resetFields()
    {
        $this->reset(['siswa_id', 'mata_pelajaran_id', 'tugas', 'uts', 'uas', 'nilai_id', 'showModal']);
    }

    public function create()
    {
        $this->resetFields();
        $this->showModal = true;
        $this->dispatch('open-modal', 'modal-nilai');
    }

    public function edit($id)
    {
        $nilai = Nilai::find($id);
        $this->nilai_id = $id;
        $this->siswa_id = $nilai->siswa_id;
        $this->mata_pelajaran_id = $nilai->mata_pelajaran_id;
        $this->tugas = $nilai->tugas;
        $this->uts = $nilai->uts;
        $this->uas = $nilai->uas;
        $this->semester = $nilai->semester;
        $this->tahun_ajaran = $nilai->tahun_ajaran;
        $this->showModal = true;
        $this->dispatch('open-modal', 'modal-nilai');
    }

    public $deleteId;

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->dispatch('open-modal', 'confirm-nilai-deletion');
    }

    public function deleteConfirmed()
    {
        $nilai = Nilai::find($this->deleteId);
        if ($nilai) {
            $siswaName = $nilai->siswa->user->name;
            $nilai->delete();

            ActivityLog::create([
                'user_id' => Auth::id(),
                'description' => "menghapus nilai siswa: {$siswaName}",
                'type' => 'danger'
            ]);

            $this->dispatch('notify', message: 'Nilai berhasil dihapus.', type: 'success');
        }
        $this->dispatch('close-modal', 'confirm-nilai-deletion');
        $this->deleteId = null;
    }

    public function save()
    {
        $this->validate([
            'siswa_id' => 'required',
            'mata_pelajaran_id' => 'required',
            'tugas' => 'required|numeric|min:0|max:100',
            'uts' => 'required|numeric|min:0|max:100',
            'uas' => 'required|numeric|min:0|max:100',
            'semester' => 'required',
            'tahun_ajaran' => 'required',
        ]);

        $nilaiAkhir = ($this->tugas * 0.3) + ($this->uts * 0.3) + ($this->uas * 0.4);

        $data = [
            'siswa_id' => $this->siswa_id,
            'mata_pelajaran_id' => $this->mata_pelajaran_id,
            'guru_id' => Auth::user()->guru->id,
            'tugas' => $this->tugas,
            'uts' => $this->uts,
            'uas' => $this->uas,
            'nilai_akhir' => $nilaiAkhir,
            'semester' => $this->semester,
            'tahun_ajaran' => $this->tahun_ajaran,
        ];

        if ($this->nilai_id) {
            Nilai::find($this->nilai_id)->update($data);
            $message = 'Nilai berhasil diperbarui.';
        } else {
            Nilai::create($data);
            $message = 'Nilai berhasil disimpan.';
        }

        ActivityLog::create([
            'user_id' => Auth::id(),
            'description' => "mengelola nilai siswa ID: {$this->siswa_id}",
            'type' => 'info'
        ]);

        $this->dispatch('notify', message: $message, type: 'success');
        $this->dispatch('close-modal', 'modal-nilai');
        $this->resetFields();
    }

    public function render()
    {
        $guru = Auth::user()->guru;
        $kelasIds = Jadwal::where('guru_id', $guru->id)->pluck('kelas_id')->unique();
        $mapelIds = Jadwal::where('guru_id', $guru->id)->pluck('mata_pelajaran_id')->unique();

        $query = Nilai::with(['siswa.user', 'mataPelajaran'])
            ->where('guru_id', $guru->id);

        if ($this->search) {
            $query->whereHas('siswa.user', function($q) {
                $q->where('name', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filterKelas) {
            $query->whereHas('siswa', function($q) {
                $q->where('kelas_id', $this->filterKelas);
            });
        }

        if ($this->filterMapel) {
            $query->where('mata_pelajaran_id', $this->filterMapel);
        }

        $nilais = $query->latest()->paginate(10);
        
        $kelases = \App\Models\Kelas::whereIn('id', $kelasIds)->get();
        $mapels = MataPelajaran::whereIn('id', $mapelIds)->get();
        
        // For the form
        $allSiswas = Siswa::whereIn('kelas_id', $kelasIds)->with('user')->get();

        return view('livewire.guru-role.nilai.index', [
            'nilais' => $nilais,
            'kelases' => $kelases,
            'mapels' => $mapels,
            'allSiswas' => $allSiswas
        ])->layout('layouts.app');
    }
}
