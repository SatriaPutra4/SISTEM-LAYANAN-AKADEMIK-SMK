<?php

use App\Livewire\Actions\Logout;

$logout = function (Logout $logout) {
    $logout();
    $this->redirect('/', navigate: true);
};

?>

<div :class="sidebarOpen ? 'w-64 translate-x-0' : 'w-20 -translate-x-full lg:translate-x-0'" class="fixed inset-y-0 left-0 z-50 flex flex-col transition-all duration-300 bg-white dark:bg-gray-800 border-r border-gray-100 dark:border-gray-700 lg:static lg:inset-0" @click.away="if(window.innerWidth < 1024) sidebarOpen = false">
    <div class="flex items-center justify-between px-4 h-20 bg-primary-700">
        <div class="flex items-center space-x-3">
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-3" wire:navigate>
                <div class="flex items-center justify-center w-10 h-10 bg-white rounded-lg shadow-sm">
                    <img src="{{ asset('images/logo_smk.png') }}" alt="Logo" class="w-8 h-8 object-contain">
                </div>
                <span x-show="sidebarOpen" class="text-lg font-bold text-white transition-opacity duration-300">SMK TBH</span>
            </a>
            <!-- Toggle Button -->
            <button @click="sidebarOpen = !sidebarOpen" class="hidden lg:block text-white hover:text-gray-200 focus:outline-none ml-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" x-show="sidebarOpen" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" x-show="!sidebarOpen" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                </svg>
            </button>
        </div>
        <button @click="sidebarOpen = !sidebarOpen" class="p-1 text-white hover:bg-primary-600 rounded-lg lg:hidden">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <div class="flex flex-col flex-1 overflow-y-auto">
        <nav class="flex-1 px-3 mt-4 space-y-1">
            <!-- Dashboard -->
            <x-sidebar-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" icon="home" title="Dashboard" />

            @if(auth()->user()->isAdmin())
                <div x-show="sidebarOpen" class="px-4 py-2 mt-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Manajemen Data</div>
                <x-sidebar-link :href="route('siswa.index')" :active="request()->routeIs('siswa.index')" icon="users" title="Data Siswa" />
                <x-sidebar-link :href="route('alumni.index')" :active="request()->routeIs('alumni.index')" icon="users" title="Data Alumni" />
                <x-sidebar-link :href="route('guru.index')" :active="request()->routeIs('guru.index')" icon="user-group" title="Data Guru" />
                
                <div x-data="{ open: {{ request()->routeIs('jurusan.index') || request()->routeIs('kelas.index') ? 'true' : 'false' }} }">
                    <button @click="open = !open" class="flex items-center justify-between w-full px-4 py-3 text-gray-600 dark:text-gray-300 transition-colors rounded-xl hover:bg-gray-100 dark:hover:bg-gray-700/50">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 mr-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                            <span x-show="sidebarOpen" class="font-medium text-sm">Akademik Master</span>
                        </div>
                        <svg x-show="sidebarOpen" class="w-4 h-4 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <div x-show="open && sidebarOpen" x-transition class="pl-10 pr-2 space-y-1">
                        <x-sidebar-link :href="route('jurusan.index')" :active="request()->routeIs('jurusan.index')" icon="academic" title="Jurusan" />
                        <x-sidebar-link :href="route('kelas.index')" :active="request()->routeIs('kelas.index')" icon="library" title="Kelas" />
                        <x-sidebar-link :href="route('mata-pelajaran.index')" :active="request()->routeIs('mata-pelajaran.index')" icon="book-open" title="Mata Pelajaran" />
                        <x-sidebar-link :href="route('jadwal.index')" :active="request()->routeIs('jadwal.index')" icon="calendar" title="Jadwal Pelajaran" />
                    </div>
                </div>

                <div x-show="sidebarOpen" class="px-4 py-2 mt-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Layanan & Keuangan</div>
                <x-sidebar-link :href="route('surat.admin')" :active="request()->routeIs('surat.admin')" icon="mail" title="Pengajuan Surat" />
                <x-sidebar-link :href="route('spp.index')" :active="request()->routeIs('spp.index')" icon="cash" title="Pembayaran SPP" />
                <x-sidebar-link :href="route('pengaturan-pembayaran.index')" :active="request()->routeIs('pengaturan-pembayaran.index')" icon="cog" title="Pengaturan Pembayaran" />
            @endif

            @if(auth()->user()->isGuru())
                <div x-show="sidebarOpen" class="px-4 py-2 mt-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Akademik</div>
                <x-sidebar-link :href="route('guru-role.jadwal')" :active="request()->routeIs('guru-role.jadwal')" icon="calendar" title="Jadwal Mengajar" />
                <x-sidebar-link :href="route('guru-role.siswa')" :active="request()->routeIs('guru-role.siswa')" icon="users" title="Data Siswa" />
                
                <div x-data="{ open: {{ request()->routeIs('guru-role.nilai.*') || request()->routeIs('guru-role.monitoring') ? 'true' : 'false' }} }">
                    <button @click="open = !open" class="flex items-center justify-between w-full px-4 py-3 text-gray-600 dark:text-gray-300 transition-colors rounded-xl hover:bg-gray-100 dark:hover:bg-gray-700/50">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 mr-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                            <span x-show="sidebarOpen" class="font-medium text-sm">Manajemen Nilai</span>
                        </div>
                        <svg x-show="sidebarOpen" class="w-4 h-4 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <div x-show="open && sidebarOpen" x-transition class="pl-10 pr-2 space-y-1">
                        <x-sidebar-link :href="route('guru-role.nilai.index')" :active="request()->routeIs('guru-role.nilai.index')" icon="pencil-alt" title="Input Nilai" />
                        <x-sidebar-link :href="route('guru-role.nilai.riwayat')" :active="request()->routeIs('guru-role.nilai.riwayat')" icon="book-open" title="Riwayat Nilai" />
                        <x-sidebar-link :href="route('guru-role.monitoring')" :active="request()->routeIs('guru-role.monitoring')" icon="chart-bar" title="Monitoring" />
                    </div>
                </div>
            @endif

            @if(auth()->user()->isSiswa())
                <div x-show="sidebarOpen" class="px-4 py-2 mt-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Layanan Akademik</div>
                <x-sidebar-link :href="route('siswa-role.jadwal')" :active="request()->routeIs('siswa-role.jadwal')" icon="calendar" title="Jadwal Pelajaran" />
                <x-sidebar-link :href="route('siswa-role.nilai')" :active="request()->routeIs('siswa-role.nilai')" icon="document-text" title="Nilai Saya" />
                <x-sidebar-link :href="route('siswa-role.monitoring')" :active="request()->routeIs('siswa-role.monitoring')" icon="chart-bar" title="Monitoring" />
                
                <div x-show="sidebarOpen" class="px-4 py-2 mt-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Layanan & Keuangan</div>
                <x-sidebar-link :href="route('siswa-role.surat')" :active="request()->routeIs('siswa-role.surat')" icon="mail" title="Pengajuan Surat" />
                <x-sidebar-link :href="route('siswa-role.spp')" :active="request()->routeIs('siswa-role.spp')" icon="cash" title="Pembayaran SPP" />
            @endif

            <div x-show="sidebarOpen" class="px-4 py-2 mt-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Sistem</div>
            <x-sidebar-link :href="auth()->user()->isSiswa() ? route('siswa-role.pengumuman') : (auth()->user()->isGuru() ? route('guru-role.pengumuman') : route('pengumuman.index'))" 
                :active="request()->routeIs('pengumuman.index') || request()->routeIs('guru-role.pengumuman') || request()->routeIs('siswa-role.pengumuman')" 
                icon="bell" title="Pengumuman" />
            
            @if(auth()->user()->isGuru())
                <x-sidebar-link :href="route('guru-role.profil')" :active="request()->routeIs('guru-role.profil')" icon="user-circle" title="Profil Saya" />
                <x-sidebar-link :href="route('guru-role.settings')" :active="request()->routeIs('guru-role.settings')" icon="cog" title="Pengaturan" />
            @endif

            @if(auth()->user()->isSiswa())
                <x-sidebar-link :href="route('siswa-role.profil')" :active="request()->routeIs('siswa-role.profil')" icon="user-circle" title="Profil Saya" />
                <x-sidebar-link :href="route('siswa-role.settings')" :active="request()->routeIs('siswa-role.settings')" icon="cog" title="Pengaturan" />
            @endif
        </nav>

        <div class="p-4 border-t border-gray-100 dark:border-gray-700">
            <button wire:click="logout" class="flex items-center w-full px-4 py-3 text-red-600 transition-colors rounded-xl hover:bg-red-50 dark:hover:bg-red-900/20 group">
                <svg class="w-6 h-6 mr-3 text-red-500 group-hover:text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span x-show="sidebarOpen" class="font-medium">Keluar</span>
            </button>
        </div>
    </div>
</div>
