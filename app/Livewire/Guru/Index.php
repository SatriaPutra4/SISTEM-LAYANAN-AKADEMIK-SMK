<?php

namespace App\Livewire\Guru;

use App\Models\Guru;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;

use Livewire\WithFileUploads;

class Index extends Component
{
    use WithPagination, WithFileUploads;

    public $name, $email, $password, $nip, $no_hp, $alamat, $guru_id, $foto;
    public $showModal = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'nip' => 'nullable|string',
        'no_hp' => 'nullable|string',
        'alamat' => 'nullable|string',
        'foto' => 'nullable|image|max:1024',
    ];

    public function resetFields()
    {
        $this->reset(['name', 'email', 'password', 'nip', 'no_hp', 'alamat', 'guru_id', 'showModal', 'foto']);
    }

    public function save()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . ($this->guru_id ? Guru::find($this->guru_id)->user_id : 'NULL'),
            'nip' => 'required',
            'no_hp' => 'required',
            'alamat' => 'required',
            'foto' => 'nullable|image|max:1024',
        ]);

        $fotoPath = $this->foto ? $this->foto->store('guru', 'public') : null;

        if ($this->guru_id) {
            $guru = Guru::find($this->guru_id);
            $user = User::find($guru->user_id);
            $user->update(['name' => $this->name, 'email' => $this->email]);
            $data = [
                'nip' => $this->nip,
                'no_hp' => $this->no_hp,
                'alamat' => $this->alamat,
            ];
            if ($fotoPath) $data['foto_profil'] = $fotoPath;
            $guru->update($data);

            ActivityLog::create([
                'user_id' => auth()->id(),
                'description' => "memperbarui data guru: {$this->name}",
                'type' => 'info'
            ]);

            $this->dispatch('notify', message: 'Data guru berhasil diperbarui.', type: 'success');
        } else {
            $this->validate(['password' => 'required|min:6']);
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'role' => 'guru',
            ]);
            Guru::create([
                'user_id' => $user->id,
                'nip' => $this->nip,
                'no_hp' => $this->no_hp,
                'alamat' => $this->alamat,
                'foto_profil' => $fotoPath,
            ]);

            ActivityLog::create([
                'user_id' => auth()->id(),
                'description' => "menambahkan guru baru: {$this->name}",
                'type' => 'success'
            ]);

            $this->dispatch('notify', message: 'Data guru berhasil ditambahkan.', type: 'success');
        }
        $this->resetFields();
        $this->dispatch('close-modal', 'modal-guru');
    }

    public function edit($id)
    {
        $guru = Guru::with('user')->find($id);
        $this->guru_id = $id;
        $this->name = $guru->user->name;
        $this->email = $guru->user->email;
        $this->nip = $guru->nip;
        $this->no_hp = $guru->no_hp;
        $this->alamat = $guru->alamat;
        $this->dispatch('open-modal', 'modal-guru');
    }

    public function confirmDelete($id)
    {
        $this->guru_id = $id;
        $this->dispatch('open-modal', 'confirm-guru-deletion');
    }

    public function deleteConfirmed()
    {
        $guru = Guru::with('user')->find($this->guru_id);
        $nama = $guru->user->name;
        User::find($guru->user_id)?->delete();
        $guru?->delete();

        ActivityLog::create([
            'user_id' => auth()->id(),
            'description' => "menghapus data guru: {$nama}",
            'type' => 'danger'
        ]);

        $this->dispatch('notify', message: 'Data guru berhasil dihapus.', type: 'success');
        $this->dispatch('close-modal', 'confirm-guru-deletion');
    }

    public function resetPasswordConfirmed()
    {
        if ($this->guru_id) {
            $guru = Guru::find($this->guru_id);
            if ($guru) {
                $user = User::find($guru->user_id);
                $user->update(['password' => Hash::make('password')]);

                ActivityLog::create([
                    'user_id' => auth()->id(),
                    'description' => "mereset password untuk guru: {$user->name}",
                    'type' => 'info'
                ]);

                $this->dispatch('notify', message: 'Password berhasil direset ke "password".', type: 'success');
            }
        }
        $this->dispatch('close-modal', 'confirm-reset-password');
    }

    public function render()
    {
        return view('livewire.guru.index', [
            'gurus' => Guru::with('user')->paginate(10)
        ])->layout('layouts.app');
    }
}
