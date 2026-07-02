<?php

namespace App\Livewire\GuruRole;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use App\Models\Guru;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class Profil extends Component
{
    use WithFileUploads;

    public $name, $email, $nip, $no_hp, $alamat, $foto;
    public $currentFoto;

    public function mount()
    {
        $user = Auth::user();
        $guru = $user->guru;

        $this->name = $user->name;
        $this->email = $user->email;
        $this->nip = $guru->nip;
        $this->no_hp = $guru->no_hp;
        $this->alamat = $guru->alamat;
        $this->currentFoto = $guru->foto_profil;
    }

    public function updateProfil()
    {
        $user = Auth::user();
        $guru = $user->guru;

        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'nip' => 'required|string',
            'no_hp' => 'nullable|string',
            'alamat' => 'nullable|string',
            'foto' => 'nullable|image|max:1024',
        ]);

        $user->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        $data = [
            'nip' => $this->nip,
            'no_hp' => $this->no_hp,
            'alamat' => $this->alamat,
        ];

        if ($this->foto) {
            if ($guru->foto_profil) {
                Storage::disk('public')->delete($guru->foto_profil);
            }
            $data['foto_profil'] = $this->foto->store('guru', 'public');
            $this->currentFoto = $data['foto_profil'];
        }

        $guru->update($data);

        $this->dispatch('notify', message: 'Profil berhasil diperbarui.', type: 'success');
    }

    public function render()
    {
        return view('livewire.guru-role.profil')->layout('layouts.app');
    }
}
