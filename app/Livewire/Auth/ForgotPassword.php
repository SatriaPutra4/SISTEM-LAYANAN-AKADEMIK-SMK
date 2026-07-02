<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class ForgotPassword extends Component
{
    public $email = '';

    public function sendPasswordResetLink()
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        $status = Password::sendResetLink(
            ['email' => $this->email]
        );

        if ($status != Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));

            return;
        }

        $this->reset('email');

        Session::flash('status', __($status));
    }

    public function render()
    {
        return view('livewire.auth.forgot-password')
            ->layout('layouts.guest');
    }
}
