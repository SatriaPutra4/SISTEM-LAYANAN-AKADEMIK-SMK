<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class Profil extends Component
{
    use WithFileUploads;

    public $name;
    public $email;
    public $foto_profil;
    public $new_foto;

    public $current_password;
    public $password;
    public $password_confirmation;

    public function mount()
    {
        $user = auth()->user();

        $this->name = $user->name;
        $this->email = $user->email;
        $this->foto_profil = $user->foto_profil;
    }

    public function updateProfile()
    {
        try {
            $this->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . auth()->id(),
                'new_foto' => 'nullable|image|max:1024',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatch('notify', message: 'Validasi gagal, periksa input Anda.', type: 'error');
            throw $e;
        }

        $user = auth()->user();
        $data = [
            'name' => $this->name,
            'email' => $this->email,
        ];

        if ($this->new_foto) {
            if ($user->foto_profil) {
                Storage::disk('public')->delete($user->foto_profil);
            }
            $data['foto_profil'] = $this->new_foto->store('foto-profil', 'public');
            $this->foto_profil = $data['foto_profil'];
            $this->new_foto = null;
        }

        $user->update($data);

        $this->dispatch('notify', message: 'Profil berhasil diperbarui!', type: 'success');
    }

    public function updatePassword()
    {
        try {
            $this->validate([
                'current_password' => ['required', 'current_password'],
                'password' => ['required', 'confirmed', Password::defaults()],
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatch('notify', message: 'Password tidak valid, periksa kembali.', type: 'error');
            throw $e;
        }

        auth()->user()->update([
            'password' => Hash::make($this->password),
        ]);

        $this->reset(['current_password', 'password', 'password_confirmation']);
        $this->dispatch('notify', message: 'Password berhasil diperbarui!', type: 'success');
    }

    public function render()
    {
        return view('livewire.admin.profil');
    }
}
