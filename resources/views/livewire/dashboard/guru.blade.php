<?php

use App\Models\Jadwal;
use App\Models\Siswa;
use Livewire\Volt\Component;

new class extends Component {
    public function with(): array
    {
        $guruId = auth()->user()->guru->id;
        return [
            'jadwals' => Jadwal::where('guru_id', $guruId)->with(['kelas', 'mataPelajaran'])->get(),
            'totalSiswaAjar' => Siswa::whereIn('kelas_id', Jadwal::where('guru_id', $guruId)->pluck('kelas_id'))->count(),
        ];
    }
}; ?>

<div class="space-y-6">
    <div class="bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 flex flex-col md:flex-row items-center justify-between">
        <div class="flex items-center space-x-6">
            <div class="relative">
                <img class="w-24 h-24 rounded-2xl object-cover" src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&color=047857&background=ecfdf5" alt="">
                <div class="absolute -bottom-2 -right-2 bg-primary-600 text-white p-1 rounded-lg border-2 border-white">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Selamat Datang, {{ auth()->user()->name }}</h2>
                <p class="text-gray-500 mt-1">NIP: {{ auth()->user()->guru->nip ?? '-' }} | Guru Mata Pelajaran</p>
                <div class="flex mt-3 space-x-2">
                    <span class="px-3 py-1 bg-primary-50 text-primary-700 rounded-full text-xs font-bold border border-primary-100">Aktif Mengajar</span>
                </div>
            </div>
        </div>
        <div class="mt-6 md:mt-0 text-right">
            <p class="text-sm text-gray-400 font-medium uppercase tracking-widest">Total Siswa Diajar</p>
            <h3 class="text-4xl font-black text-primary-600 mt-1">{{ $totalSiswaAjar }} <span class="text-lg font-medium text-gray-400">Siswa</span></h3>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700">
            <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-6">Jadwal Mengajar Hari Ini</h3>
            <div class="space-y-4">
                @forelse($jadwals as $j)
                <div class="flex items-center p-4 bg-gray-50 dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-700 hover:border-primary-300 transition-all group">
                    <div class="w-16 flex flex-col items-center justify-center border-r border-gray-200 dark:border-gray-700 mr-4">
                        <span class="text-sm font-bold text-primary-600">{{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }}</span>
                        <span class="text-xs text-gray-400 mt-1">Mulai</span>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-bold text-gray-800 dark:text-white group-hover:text-primary-600 transition-colors">{{ $j->mataPelajaran->nama_mapel }}</h4>
                        <p class="text-sm text-gray-500 mt-1">{{ $j->kelas->nama_kelas }} | {{ $j->hari }}</p>
                    </div>
                    <button class="bg-white dark:bg-gray-800 p-2 rounded-xl border border-gray-200 dark:border-gray-700 text-gray-400 hover:text-primary-600 hover:border-primary-300 transition-all shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </button>
                </div>
                @empty
                <div class="text-center py-12">
                    <p class="text-gray-400">Tidak ada jadwal mengajar.</p>
                </div>
                @endforelse
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700">
            <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-6">Aksi Cepat Guru</h3>
            <div class="grid grid-cols-2 gap-4">
                <button class="flex flex-col items-center p-6 bg-emerald-50 dark:bg-emerald-900/20 rounded-3xl border border-emerald-100 dark:border-emerald-800 hover:scale-105 transition-all">
                    <div class="p-3 bg-white dark:bg-emerald-900 rounded-2xl shadow-sm text-emerald-600 mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <span class="text-sm font-bold text-emerald-800 dark:text-emerald-200">Input Nilai</span>
                </button>
                <button class="flex flex-col items-center p-6 bg-blue-50 dark:bg-blue-900/20 rounded-3xl border border-blue-100 dark:border-blue-800 hover:scale-105 transition-all">
                    <div class="p-3 bg-white dark:bg-blue-900 rounded-2xl shadow-sm text-blue-600 mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <span class="text-sm font-bold text-blue-800 dark:text-blue-200">Data Siswa</span>
                </button>
            </div>
        </div>
    </div>
</div>
