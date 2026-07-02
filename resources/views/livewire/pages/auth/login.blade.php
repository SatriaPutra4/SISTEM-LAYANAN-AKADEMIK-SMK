<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use function Livewire\Volt\form;
use function Livewire\Volt\layout;

layout('layouts.guest');
form(LoginForm::class);

$login = function () {
    $this->validate();
    $this->form->authenticate();
    Session::regenerate();
    
    return redirect()->to(route('dashboard'));
};
?>

<div>
    <div class="flex flex-col items-center mb-8">
        <div class="w-20 h-20 mb-4">
            <img alt="SMK Tri Bhakti Al Husna Logo" class="w-full h-full object-contain" src="{{ asset('images/logo_smk.png') }}"/>
        </div>
        <h2 class="text-2xl font-semibold text-gray-900">Masuk ke Akun</h2>
        <p class="text-sm text-gray-500 mt-1">Portal SMK Tri Bhakti Al Husna</p>
    </div>

    <form wire:submit="login" class="space-y-6">
        <!-- Username -->
        <div class="space-y-2">
            <label class="block text-sm font-medium text-gray-700 ml-1" for="username">Username</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <span class="material-symbols-outlined text-gray-400">person</span>
                </div>
                <input wire:model="form.username" id="username" class="w-full pl-10 pr-4 py-3 bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-primary-500" type="text" placeholder="Masukkan Email, NIP, atau NISN" required autofocus/>
            </div>
            <x-input-error :messages="$errors->get('form.username')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="space-y-2" x-data="{ show: false }">
            <div class="flex justify-between items-center px-1">
                <label class="block text-sm font-medium text-gray-700" for="password">Kata Sandi</label>
                <a class="text-sm text-primary-600 font-semibold hover:underline" href="{{ route('password.request') }}" wire:navigate>Lupa Password?</a>
            </div>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <span class="material-symbols-outlined text-gray-400">lock</span>
                </div>
                <input wire:model="form.password" :type="show ? 'text' : 'password'" id="password" class="w-full pl-10 pr-12 py-3 bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-primary-500" placeholder="••••••••" required/>
                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                    <span class="material-symbols-outlined" x-text="show ? 'visibility_off' : 'visibility'">visibility</span>
                </button>
            </div>
            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center space-x-2 px-1">
            <input wire:model="form.remember" id="remember" type="checkbox" class="w-5 h-5 rounded border-gray-300 text-primary-600 focus:ring-primary-500 cursor-pointer"/>
            <label class="text-sm text-gray-600 cursor-pointer select-none" for="remember">Ingat Saya</label>
        </div>

        <!-- Submit Button -->
        <button class="w-full py-3 bg-primary-600 text-white font-semibold rounded-xl shadow-lg hover:bg-primary-700 transition-all flex items-center justify-center space-x-2" type="submit">
            <span>Masuk Sekarang</span>
            <span class="material-symbols-outlined text-sm">login</span>
        </button>
    </form>
</div>
