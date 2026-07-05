<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Data Alumni</h2>
            <p class="text-sm text-gray-500 mt-1">Daftar siswa yang telah menyelesaikan masa studi</p>
        </div>
    </div>

    <!-- Search & Filter -->
    <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 flex gap-4">
        <div class="relative flex-1">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </span>
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari nama atau NIS alumni..." class="block w-full pl-10 pr-3 py-2.5 bg-gray-50 dark:bg-gray-900 border-none rounded-xl focus:ring-2 focus:ring-primary-500 text-sm">
        </div>
        <div class="w-48">
            <select wire:model.live="tahun_lulus" class="block w-full py-2.5 bg-gray-50 dark:bg-gray-900 border-none rounded-xl focus:ring-2 focus:ring-primary-500 text-sm">
                <option value="">Semua Tahun</option>
                @foreach($tahunList as $tahun)
                    <option value="{{ $tahun }}">{{ $tahun }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 dark:bg-gray-700/50">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Nama / NIS</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Kelas Terakhir</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Tahun Lulus</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Kontak</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($alumnis as $s)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <img class="w-10 h-10 rounded-xl mr-3" src="https://ui-avatars.com/api/?name={{ urlencode($s->user->name) }}&color=6366f1&background=e0e7ff" alt="">
                                <div>
                                    <div class="text-sm font-bold text-gray-800 dark:text-gray-200">{{ $s->user->name }}</div>
                                    <div class="text-xs text-gray-400 font-medium">{{ $s->nis }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $s->kelas->nama_kelas }}</div>
                            <div class="text-xs text-primary-600 font-bold uppercase">{{ $s->jurusan->nama_jurusan }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500 font-medium">
                            {{ $s->tahun_lulus ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $s->no_hp ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <button wire:click="show({{ $s->id }})" class="p-2 text-gray-400 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-400 italic">Belum ada data alumni.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700">
            {{ $alumnis->links() }}
        </div>
    </div>

                <!-- Alumni Profile Modal -->
                <x-modal name="modal-view-alumni" focusable>
                @if($selectedSiswa)
                <div class="p-6">
                <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100 border-b pb-4 mb-4">Profil Alumni</h2>
                <div class="space-y-4">
                <div class="flex items-center space-x-4">
                    <img class="w-20 h-20 rounded-xl" src="https://ui-avatars.com/api/?name={{ urlencode($selectedSiswa->user->name) }}&color=6366f1&background=e0e7ff" alt="">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">{{ $selectedSiswa->user->name }}</h3>
                        <p class="text-gray-500">{{ $selectedSiswa->nis }}</p>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-gray-400 uppercase">Email</p>
                        <p class="text-sm font-medium">{{ $selectedSiswa->user->email }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase">Jenis Kelamin</p>
                        <p class="text-sm font-medium">{{ $selectedSiswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase">Kelas Terakhir</p>
                        <p class="text-sm font-medium">{{ $selectedSiswa->kelas->nama_kelas }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase">Jurusan</p>
                        <p class="text-sm font-medium">{{ $selectedSiswa->jurusan->nama_jurusan }}</p>
                    </div>
                </div>
                </div>
                <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">Tutup</x-secondary-button>
                </div>
                </div>
                @endif
                </x-modal>
                </div>
