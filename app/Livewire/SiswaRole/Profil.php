<?php

namespace App\Livewire\SiswaRole;

use App\Models\User;
use App\Models\Siswa;
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
    public $nis;
    public $jenis_kelamin;
    public $tempat_lahir;
    public $tanggal_lahir;
    public $no_hp;
    public $alamat;
    public $foto_profil;
    public $new_foto;

    public $current_password;
    public $password;
    public $password_confirmation;

    public function mount()
    {
        $user = auth()->user();
        $siswa = $user->siswa;

        $this->name = $user->name;
        $this->email = $user->email;
        $this->nis = $siswa->nis;
        $this->jenis_kelamin = $siswa->jenis_kelamin;
        $this->tempat_lahir = $siswa->tempat_lahir;
        $this->tanggal_lahir = $siswa->tanggal_lahir;
        $this->no_hp = $siswa->no_hp;
        $this->alamat = $siswa->alamat;
        $this->foto_profil = $siswa->foto_profil;
    }

    public function updateProfile()
    {
        try {
            $this->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . auth()->id(),
                'no_hp' => 'nullable|string|max:20',
                'alamat' => 'nullable|string',
                'tempat_lahir' => 'nullable|string|max:255',
                'tanggal_lahir' => 'nullable|date',
                'new_foto' => 'nullable|image|max:1024',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->dispatch('notify', message: 'Validasi gagal, periksa input Anda.', type: 'error');
            throw $e;
        }

        $user = auth()->user();
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        $siswa = $user->siswa;
        $data = [
            'no_hp' => $this->no_hp,
            'alamat' => $this->alamat,
            'tempat_lahir' => $this->tempat_lahir,
            'tanggal_lahir' => $this->tanggal_lahir,
        ];

        if ($this->new_foto) {
            if ($siswa->foto_profil) {
                Storage::disk('public')->delete($siswa->foto_profil);
            }
            $data['foto_profil'] = $this->new_foto->store('foto-profil', 'public');
            $this->foto_profil = $data['foto_profil'];
            $this->new_foto = null;
        }

        $siswa->update($data);

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
        return view('livewire.siswa-role.profil', [
            'siswa' => auth()->user()->siswa
        ]);
    }
}

