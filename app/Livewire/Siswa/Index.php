<?php

namespace App\Livewire\Siswa;

use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Jurusan;
use App\Models\User;
use App\Models\ActivityLog;
use App\Imports\SiswaImport;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class Index extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $file;
    public $target_kelas_id;
    public $showImportModal = false;
    public $name, $email, $nis, $kelas_id, $jurusan_id, $jenis_kelamin, $no_hp, $alamat;
    public $siswa_id;
    public $selectedSiswa;
    public $isEdit = false;

    // Fungsi Luluskan Angkatan
    public function luluskanAngkatan($kelas_id)
    {
        Siswa::where('kelas_id', $kelas_id)
             ->where('status', 'aktif')
             ->update(['status' => 'lulus']);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'description' => "meluluskan seluruh siswa di kelas ID: {$kelas_id}",
            'type' => 'success'
        ]);

        $this->dispatch('notify', message: 'Seluruh siswa di kelas tersebut berhasil diluluskan.', type: 'success');
    }

    // Fungsi Naikkan Kelas
    public function naikkanKelas($kelas_asal_id, $kelas_tujuan_id)
    {
        if ($kelas_asal_id == $kelas_tujuan_id) {
            $this->dispatch('notify', message: 'Kelas asal dan tujuan tidak boleh sama.', type: 'error');
            return;
        }

        Siswa::where('kelas_id', $kelas_asal_id)
             ->where('status', 'aktif')
             ->update(['kelas_id' => $kelas_tujuan_id]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'description' => "menaikkan kelas seluruh siswa dari {$kelas_asal_id} ke {$kelas_tujuan_id}",
            'type' => 'success'
        ]);

        $this->dispatch('notify', message: 'Seluruh siswa berhasil naik kelas.', type: 'success');
    }

    protected $updatesQueryString = ['search'];
    
    public function resetForm()
    {
        $this->reset(['name', 'email', 'nis', 'kelas_id', 'jurusan_id', 'jenis_kelamin', 'no_hp', 'alamat', 'foto', 'siswa_id', 'isEdit']);
    }

    public function create()
    {
        $this->resetForm();
        $this->dispatch('open-modal', 'modal-siswa');
    }

    public function render()
    {
        $query = Siswa::with(['user', 'kelas', 'jurusan'])->where('status', 'aktif');

        if (!empty($this->search)) {
            $query->where(function($q) {
                $q->where('nis', 'like', '%' . $this->search . '%')
                  ->orWhereHas('user', function($userQuery) {
                      $userQuery->where('name', 'like', '%' . $this->search . '%');
                  });
            });
        }

        if (!empty($this->target_kelas_id)) {
            $query->where('kelas_id', $this->target_kelas_id);
        }
        
        $siswas = $query->latest()->paginate(10);
        
        return view('livewire.siswa.index', [
            'siswas' => $siswas,
            'kelases' => Kelas::all(),
            'jurusans' => Jurusan::all(),
        ])->layout('layouts.app');
    }

    public function show($id)
    {
        $this->selectedSiswa = Siswa::with(['user', 'kelas', 'jurusan'])->find($id);
        $this->dispatch('open-modal', 'modal-view-siswa');
    }

    public $foto;

    public function store()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . ($this->siswa_id ? Siswa::find($this->siswa_id)->user_id : 'NULL'),
            'nis' => 'required|unique:siswas,nis,' . ($this->siswa_id ?? 'NULL'),
            'kelas_id' => 'required',
            'jurusan_id' => 'required',
            'jenis_kelamin' => 'required',
            'foto' => 'nullable|image|max:1024',
        ]);

        $fotoPath = $this->foto ? $this->foto->store('siswa', 'public') : null;

        if ($this->siswa_id) {
            $siswa = Siswa::find($this->siswa_id);
            $user = User::find($siswa->user_id);
            $user->update(['name' => $this->name, 'email' => $this->email]);
            $data = [
                'nis' => $this->nis,
                'kelas_id' => $this->kelas_id,
                'jurusan_id' => $this->jurusan_id,
                'jenis_kelamin' => $this->jenis_kelamin,
                'no_hp' => $this->no_hp,
                'alamat' => $this->alamat,
            ];
            if ($fotoPath) $data['foto_profil'] = $fotoPath;
            $siswa->update($data);

            ActivityLog::create([
                'user_id' => auth()->id(),
                'description' => "memperbarui data siswa: {$this->name}",
                'type' => 'info'
            ]);

            $this->dispatch('notify', message: 'Data siswa berhasil diperbarui.', type: 'success');
        } else {
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make('Tr1Bhakt1'),
                'role' => 'siswa',
            ]);
            Siswa::create([
                'user_id' => $user->id,
                'nis' => $this->nis,
                'kelas_id' => $this->kelas_id,
                'jurusan_id' => $this->jurusan_id,
                'jenis_kelamin' => $this->jenis_kelamin,
                'no_hp' => $this->no_hp,
                'alamat' => $this->alamat,
                'foto_profil' => $fotoPath,
            ]);

            ActivityLog::create([
                'user_id' => auth()->id(),
                'description' => "menambahkan siswa baru: {$this->name}",
                'type' => 'success'
            ]);

            $this->dispatch('notify', message: 'Data siswa berhasil ditambahkan.', type: 'success');
        }

        $this->reset(['name', 'email', 'nis', 'kelas_id', 'jurusan_id', 'jenis_kelamin', 'no_hp', 'alamat', 'foto', 'siswa_id']);
        $this->dispatch('close-modal', 'modal-siswa');
    }

    public function edit($id)
    {
        $siswa = Siswa::with('user')->find($id);
        $this->siswa_id = $id;
        $this->name = $siswa->user->name;
        $this->email = $siswa->user->email;
        $this->nis = $siswa->nis;
        $this->kelas_id = $siswa->kelas_id;
        $this->jurusan_id = $siswa->jurusan_id;
        $this->jenis_kelamin = $siswa->jenis_kelamin;
        $this->no_hp = $siswa->no_hp;
        $this->alamat = $siswa->alamat;
        $this->isEdit = true;
        $this->dispatch('open-modal', 'modal-siswa');
    }

    public function confirmDelete($id)
    {
        $this->siswa_id = $id;
        $this->dispatch('open-modal', 'confirm-siswa-deletion');
    }

    public function deleteConfirmed()
    {
        if ($this->siswa_id) {
            $siswa = Siswa::with('user')->find($this->siswa_id);
            if ($siswa) {
                $nama = $siswa->user->name;
                User::find($siswa->user_id)?->delete();
                $siswa->delete();

                ActivityLog::create([
                    'user_id' => auth()->id(),
                    'description' => "menghapus data siswa: {$nama}",
                    'type' => 'danger'
                ]);

                $this->dispatch('notify', message: 'Data siswa berhasil dihapus.', type: 'success');
            }
            $this->siswa_id = null;
        }
        $this->dispatch('close-modal', 'confirm-siswa-deletion');
    }

    public function resetPasswordConfirmed()
    {
        if ($this->siswa_id) {
            $siswa = Siswa::find($this->siswa_id);
            if ($siswa) {
                $user = User::find($siswa->user_id);
                $user->update(['password' => Hash::make('Tr1Bhakt1')]);

                ActivityLog::create([
                    'user_id' => auth()->id(),
                    'description' => "mereset password untuk user: {$user->name}",
                    'type' => 'info'
                ]);

                $this->dispatch('notify', message: 'Password berhasil direset ke "Tr1Bhakt1".', type: 'success');
            }
        }
        $this->dispatch('close-modal', 'confirm-reset-password');
    }

    public function import()
    {
        $this->validate(['file' => 'required|mimes:csv,txt,xlsx,xls|max:30720']);

        try {
            Excel::import(new SiswaImport, $this->file);
            
            ActivityLog::create([
                'user_id' => auth()->id(),
                'description' => "mengimport data siswa masal (via Excel/CSV)",
                'type' => 'success'
            ]);

            $this->showImportModal = false;
            $this->file = null;
            $this->dispatch('notify', message: "Import data berhasil.", type: 'success');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Import Gagal: " . $e->getMessage());
            $this->dispatch('notify', message: "Terjadi kesalahan saat import: " . $e->getMessage(), type: 'error');
        }
    }
}
