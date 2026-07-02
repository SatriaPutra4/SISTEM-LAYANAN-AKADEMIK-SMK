<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Data Siswa</h1>
            <p class="text-gray-600 dark:text-gray-400">Daftar siswa di kelas yang Anda ajar.</p>
        </div>
    </div>

    <!-- Filter & Search -->
    <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 flex flex-col md:flex-row gap-4">
        <div class="flex-1 relative">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
            </span>
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari nama atau NIS siswa..." class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-xl leading-5 bg-white dark:bg-gray-700 dark:text-white placeholder-gray-500 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm transition duration-150 ease-in-out">
        </div>
        <div class="w-full md:w-64">
            <select wire:model.live="filterKelas" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm rounded-xl transition duration-150 ease-in-out">
                <option value="">Semua Kelas</option>
                @foreach($kelases as $kelas)
                    <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Student Table -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 dark:bg-gray-700/50">
                    <tr>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Siswa</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">NIS</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Kelas</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Jenis Kelamin</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($siswas as $siswa)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 flex-shrink-0">
                                        @if($siswa->foto_profil)
                                            <img class="h-10 w-10 rounded-full object-cover border-2 border-primary-50" src="{{ asset('storage/' . $siswa->foto_profil) }}" alt="">
                                        @else
                                            <div class="h-10 w-10 rounded-full bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center text-primary-600 font-bold">
                                                {{ substr($siswa->user->name, 0, 1) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-bold text-gray-900 dark:text-white">{{ $siswa->user->name }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $siswa->user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                                {{ $siswa->nis }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-white font-medium">{{ $siswa->kelas->nama_kelas }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ $siswa->jurusan->nama_jurusan }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $siswa->jenis_kelamin === 'L' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400' : 'bg-pink-100 text-pink-800 dark:bg-pink-900/30 dark:text-pink-400' }}">
                                    {{ $siswa->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button wire:click="showDetail({{ $siswa->id }})" class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300 transition-colors">
                                    Detail
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400 italic">
                                Tidak ada data siswa ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($siswas->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700">
                {{ $siswas->links() }}
            </div>
        @endif
    </div>

    <!-- Modal Detail Siswa -->
    <x-modal name="modal-detail-siswa" :show="false">
        <div class="p-6">
            @if($selectedSiswa)
                <div class="flex items-center gap-6 mb-6">
                    <div class="h-24 w-24 flex-shrink-0">
                        @if($selectedSiswa->foto_profil)
                            <img class="h-24 w-24 rounded-2xl object-cover border-4 border-primary-50 shadow-sm" src="{{ asset('storage/' . $selectedSiswa->foto_profil) }}" alt="">
                        @else
                            <div class="h-24 w-24 rounded-2xl bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center text-primary-600 text-3xl font-bold">
                                {{ substr($selectedSiswa->user->name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $selectedSiswa->user->name }}</h2>
                        <p class="text-gray-500 dark:text-gray-400">NIS: {{ $selectedSiswa->nis }}</p>
                        <div class="flex gap-2 mt-2">
                            <span class="px-2 py-1 bg-primary-50 dark:bg-primary-900/20 text-primary-600 rounded text-xs font-bold">{{ $selectedSiswa->kelas->nama_kelas }}</span>
                            <span class="px-2 py-1 bg-gray-50 dark:bg-gray-700 text-gray-600 dark:text-gray-400 rounded text-xs font-bold">{{ $selectedSiswa->jurusan->nama_jurusan }}</span>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <label class="text-xs font-semibold text-gray-400 uppercase">Email</label>
                            <p class="text-sm font-medium text-gray-800 dark:text-white">{{ $selectedSiswa->user->email }}</p>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-400 uppercase">Nomor HP</label>
                            <p class="text-sm font-medium text-gray-800 dark:text-white">{{ $selectedSiswa->no_hp ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="text-xs font-semibold text-gray-400 uppercase">Jenis Kelamin</label>
                            <p class="text-sm font-medium text-gray-800 dark:text-white">{{ $selectedSiswa->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-400 uppercase">Alamat</label>
                            <p class="text-sm font-medium text-gray-800 dark:text-white">{{ $selectedSiswa->alamat ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex justify-end">
                    <x-secondary-button x-on:click="$dispatch('close-modal', 'modal-detail-siswa')">
                        Tutup
                    </x-secondary-button>
                </div>
            @endif
        </div>
    </x-modal>
</div>
