<?php

use App\Models\Jadwal;
use App\Models\Nilai;
use App\Models\Pengumuman;
use Livewire\Volt\Component;

new class extends Component {
    public function with(): array
    {
        $siswa = auth()->user()->siswa;
        
        if (!$siswa) {
            return [
                'siswa' => null,
                'jadwals' => [],
                'nilais' => [],
                'pengumumans' => [],
            ];
        }

        return [
            'siswa' => $siswa,
            'jadwals' => Jadwal::where('kelas_id', $siswa->kelas_id)->with(['mataPelajaran', 'guru.user'])->get(),
            'nilais' => Nilai::where('siswa_id', $siswa->id)->with('mataPelajaran')->latest()->take(3)->get(),
            'pengumumans' => Pengumuman::whereIn('target_role', ['all', 'siswa'])->latest()->take(3)->get(),
        ];
    }
}; ?>

<div class="space-y-6">
    @if($siswa)
    <div class="relative bg-primary-800 rounded-3xl p-8 overflow-hidden shadow-xl text-white">
        <div class="relative z-10">
            <h2 class="text-3xl font-black mb-2">Halo, {{ auth()->user()->name }}! 👋</h2>
            <p class="text-primary-100 mb-6">Kamu terdaftar di Kelas <span class="font-bold underline">{{ $siswa->kelas->nama_kelas }}</span> Jurusan <span class="font-bold underline">{{ $siswa->jurusan->nama_jurusan }}</span></p>
            <div class="flex flex-wrap gap-4">
                <div class="bg-white/10 backdrop-blur-md px-4 py-2 rounded-xl border border-white/20">
                    <span class="text-xs text-primary-200 block uppercase font-bold tracking-widest">NIS</span>
                    <span class="font-bold">{{ $siswa->nis }}</span>
                </div>
                <div class="bg-white/10 backdrop-blur-md px-4 py-2 rounded-xl border border-white/20">
                    <span class="text-xs text-primary-200 block uppercase font-bold tracking-widest">Status</span>
                    <span class="font-bold italic">Siswa Aktif</span>
                </div>
            </div>
        </div>
        <div class="absolute -right-10 -bottom-10 opacity-10 rotate-12">
            <svg class="w-64 h-64" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2L1 21h22L12 2zm0 3.45l8.1 14.1H3.9L12 5.45zM11 11h2v4h-2v-4zm0 6h2v2h-2v-2z" />
            </svg>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700">
                <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-6">Jadwal Pelajaran Hari Ini</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @forelse($jadwals as $j)
                    <div class="p-4 bg-gray-50 dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-700">
                        <div class="flex justify-between items-start mb-2">
                            <span class="px-2 py-1 bg-primary-100 text-primary-700 text-[10px] font-bold rounded-lg uppercase tracking-tighter">{{ $j->hari }}</span>
                            <span class="text-xs font-bold text-gray-400">{{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') }}</span>
                        </div>
                        <h4 class="font-bold text-gray-800 dark:text-white">{{ $j->mataPelajaran->nama_mapel }}</h4>
                        <p class="text-xs text-gray-500 mt-1">{{ $j->guru->user->name }}</p>
                    </div>
                    @empty
                    <p class="text-gray-400">Jadwal belum tersedia.</p>
                    @endforelse
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700">
                <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-6">Nilai Terakhir</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-xs text-gray-400 uppercase tracking-widest">
                                <th class="pb-4 font-bold">Mata Pelajaran</th>
                                <th class="pb-4 font-bold text-center">Tugas</th>
                                <th class="pb-4 font-bold text-center">UTS</th>
                                <th class="pb-4 font-bold text-center">UAS</th>
                                <th class="pb-4 font-bold text-center">Akhir</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 dark:divide-gray-700">
                            @foreach($nilais as $n)
                            <tr>
                                <td class="py-4 text-sm font-bold text-gray-700 dark:text-gray-300">{{ $n->mataPelajaran->nama_mapel }}</td>
                                <td class="py-4 text-center text-sm font-medium">{{ $n->tugas }}</td>
                                <td class="py-4 text-center text-sm font-medium">{{ $n->uts }}</td>
                                <td class="py-4 text-center text-sm font-medium">{{ $n->uas }}</td>
                                <td class="py-4 text-center">
                                    <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-lg text-xs font-black">{{ $n->nilai_akhir }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700">
                <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-6">Pengumuman Terbaru</h3>
                <div class="space-y-4">
                    @foreach($pengumumans as $p)
                    <div class="p-4 bg-amber-50 dark:bg-amber-900/20 rounded-2xl border border-amber-100 dark:border-amber-800">
                        <h4 class="text-sm font-bold text-amber-800 dark:text-amber-200">{{ $p->judul }}</h4>
                        <p class="text-xs text-amber-700 dark:text-amber-300/70 mt-1 line-clamp-2">{{ $p->konten }}</p>
                        <span class="text-[10px] text-amber-500 mt-2 block">{{ $p->created_at->diffForHumans() }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700">
                <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-6">Layanan Administrasi</h3>
                <div class="grid grid-cols-1 gap-3">
                    <button class="flex items-center p-4 bg-gray-50 dark:bg-gray-900 rounded-2xl hover:bg-primary-50 dark:hover:bg-primary-900/20 group transition-all text-left">
                        <div class="p-2 bg-white dark:bg-gray-800 rounded-lg shadow-sm text-primary-600 mr-4">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <span class="text-sm font-bold text-gray-700 dark:text-gray-300 group-hover:text-primary-700">Ajukan Surat Keterangan</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="p-8 bg-white dark:bg-gray-800 rounded-3xl text-center">
        <p class="text-gray-500">Profil siswa tidak ditemukan untuk akun ini.</p>
    </div>
    @endif
</div>
