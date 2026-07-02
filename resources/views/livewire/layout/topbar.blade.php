<?php

use App\Livewire\Actions\Logout;

$logout = function (Logout $logout) {
    $logout();
    $this->redirect('/', navigate: true);
};

?>

<header class="sticky top-0 z-30 bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 shadow-sm">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20 -mb-px">
            <!-- Left side -->
            <div class="flex items-center">
                <!-- Hamburger button -->
                <button @click.stop="sidebarOpen = !sidebarOpen" class="text-gray-500 hover:text-gray-600 lg:hidden">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24">
                        <path d="M4 6h16v2H4zM4 11h16v2H4zM4 16h16v2H4z" />
                    </svg>
                </button>
                
                <div class="hidden lg:block ml-2">
                    <h1 class="text-xl font-bold text-gray-800 dark:text-white">Dashboard <span class="text-primary-600 capitalize">| {{ auth()->user()->role }}</span></h1>
                </div>
            </div>

            <!-- Right side -->
            <div class="flex items-center space-x-3">
                <livewire:layout.notification-bell />

                <!-- Divider -->
                <hr class="w-px h-6 bg-gray-200 dark:bg-gray-700 border-none mx-3" />

                <!-- User button -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center group">
                            <img class="w-10 h-10 rounded-xl object-cover border-2 border-primary-100 group-hover:border-primary-300 transition-all" src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&color=047857&background=ecfdf5" alt="{{ auth()->user()->name }}" />
                            <div class="hidden md:flex flex-col items-start ml-3 text-left">
                                <span class="text-sm font-bold text-gray-800 dark:text-gray-100 leading-none">{{ auth()->user()->name }}</span>
                                <span class="text-xs font-medium text-gray-400 mt-1 uppercase tracking-wider">{{ auth()->user()->role }}</span>
                            </div>
                            <svg class="w-4 h-4 ml-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        @if(auth()->user()->isGuru())
                            <x-dropdown-link :href="route('guru-role.profil')" wire:navigate>
                                {{ __('Profile') }}
                            </x-dropdown-link>
                        @elseif(auth()->user()->isAdmin())
                            <x-dropdown-link :href="route('admin-profil')" wire:navigate>
                                {{ __('Profile') }}
                            </x-dropdown-link>
                        @else
                            <x-dropdown-link :href="route('siswa-role.profil')" wire:navigate>
                                {{ __('Profile') }}
                            </x-dropdown-link>
                        @endif

                        <!-- Authentication -->
                        <button wire:click="logout" class="w-full text-start">
                            <x-dropdown-link>
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </button>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>
</header>
