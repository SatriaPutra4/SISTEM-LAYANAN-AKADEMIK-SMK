<?php

namespace App\Livewire\GuruRole;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class Settings extends Component
{
    public $current_password, $password, $password_confirmation;

    public function updatePassword()
    {
        $this->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        Auth::user()->update([
            'password' => Hash::make($this->password),
        ]);

        $this->reset(['current_password', 'password', 'password_confirmation']);
        $this->dispatch('close-modal', 'confirm-password-update');
        $this->dispatch('notify', message: 'Kata sandi berhasil diperbarui.', type: 'success');
    }

    public function render()
    {
        return view('livewire.guru-role.settings')->layout('layouts.app');
    }
}
