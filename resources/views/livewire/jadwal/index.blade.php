<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Manajemen Jadwal Pelajaran</h2>
            <p class="text-sm text-gray-500 mt-1">Atur jadwal kegiatan belajar mengajar</p>
        </div>
        <div>
            <button wire:click="create" class="bg-primary-600 hover:bg-primary-700 text-white px-5 py-2.5 rounded-xl font-bold transition-all shadow-sm flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Jadwal
            </button>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 p-4 mb-4 rounded-r-xl shadow-sm animate-fade-in" role="alert">
            <p>{{ session('message') }}</p>
        </div>
    @endif

    <!-- Filter & Search -->
    <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="relative flex-1 max-w-md">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </span>
            <input wire:model.live="search" type="text" placeholder="Cari mata pelajaran..." class="block w-full pl-10 pr-3 py-2.5 bg-gray-50 dark:bg-gray-900 border-none rounded-xl focus:ring-2 focus:ring-primary-500 text-sm">
        </div>
        <div class="flex items-center space-x-2">
            <select wire:model.live="filterKelas" class="bg-gray-50 dark:bg-gray-900 border-none rounded-xl focus:ring-2 focus:ring-primary-500 text-sm py-2.5 px-4">
                <option value="">Semua Kelas</option>
                @foreach($kelases as $k)
                    <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                @endforeach
            </select>
            <select wire:model.live="filterGuru" class="bg-gray-50 dark:bg-gray-900 border-none rounded-xl focus:ring-2 focus:ring-primary-500 text-sm py-2.5 px-4">
                <option value="">Semua Guru</option>
                @foreach($gurus as $g)
                    <option value="{{ $g->id }}">{{ $g->user->name }}</option>
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
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Hari</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Waktu</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Mata Pelajaran</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Guru</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Kelas</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($jadwals as $j)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-bold rounded-lg bg-primary-100 text-primary-700">
                                {{ $j->hari }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') }}
                        </td>
                        <td class="px-6 py-4 text-sm font-bold text-gray-800 dark:text-gray-200">
                            {{ $j->mataPelajaran->nama_pelajaran }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                            {{ $j->guru->user->name }}
                        </td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ $j->kelas->nama_kelas }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center space-x-2">
                                <button wire:click="edit({{ $j->id }})" class="p-2 text-gray-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                <button wire:click="confirmDelete({{ $j->id }})" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-400 italic">Data jadwal tidak ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700">
            {{ $jadwals->links() }}
        </div>
    </div>

    <!-- Modal Form -->
    <x-modal name="modal-jadwal" focusable>
        <form wire:submit.prevent="store" class="p-6">
            <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-6 border-b pb-4">
                {{ $isEdit ? 'Edit Jadwal Pelajaran' : 'Tambah Jadwal Pelajaran' }}
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <x-input-label for="hari" value="Hari" />
                    <select wire:model="hari" id="hari" class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm">
                        <option value="">Pilih Hari</option>
                        @foreach($haris as $h)
                            <option value="{{ $h }}">{{ $h }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('hari')" class="mt-2" />
                </div>
                <div class="space-y-2">
                    <x-input-label for="kelas_id" value="Kelas" />
                    <select wire:model="kelas_id" id="kelas_id" class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm">
                        <option value="">Pilih Kelas</option>
                        @foreach($kelases as $k)
                            <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('kelas_id')" class="mt-2" />
                </div>
                <div class="space-y-2">
                    <x-input-label for="mata_pelajaran_id" value="Mata Pelajaran" />
                    <select wire:model="mata_pelajaran_id" id="mata_pelajaran_id" class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm">
                        <option value="">Pilih Mata Pelajaran</option>
                        @foreach($mataPelajarans as $mp)
                            <option value="{{ $mp->id }}">{{ $mp->nama_mapel }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('mata_pelajaran_id')" class="mt-2" />
                </div>
                <div class="space-y-2">
                    <x-input-label for="guru_id" value="Guru Pengampu" />
                    <select wire:model="guru_id" id="guru_id" class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm">
                        <option value="">Pilih Guru</option>
                        @foreach($gurus as $g)
                            <option value="{{ $g->id }}">{{ $g->user->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('guru_id')" class="mt-2" />
                </div>
                <div class="space-y-2">
                    <x-input-label for="jam_mulai" value="Jam Mulai" />
                    <x-text-input wire:model="jam_mulai" id="jam_mulai" type="time" class="block w-full" />
                    <x-input-error :messages="$errors->get('jam_mulai')" class="mt-2" />
                </div>
                <div class="space-y-2">
                    <x-input-label for="jam_selesai" value="Jam Selesai" />
                    <x-text-input wire:model="jam_selesai" id="jam_selesai" type="time" class="block w-full" />
                    <x-input-error :messages="$errors->get('jam_selesai')" class="mt-2" />
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3 border-t pt-6">
                <x-secondary-button x-on:click="$dispatch('close')">
                    Batal
                </x-secondary-button>
                <x-primary-button class="bg-primary-600 hover:bg-primary-700">
                    Simpan Jadwal
                </x-primary-button>
            </div>
        </form>
    </x-modal>

    <!-- Delete Confirmation Modal -->
    <x-modal name="confirm-jadwal-deletion" focusable>
        <div class="p-6">
            <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                Konfirmasi Hapus Jadwal
            </h2>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                Apakah Anda yakin ingin menghapus jadwal ini? Data yang dihapus tidak dapat dikembalikan.
            </p>
            <div class="mt-6 flex justify-end space-x-3">
                <x-secondary-button x-on:click="$dispatch('close')">Batal</x-secondary-button>
                <x-danger-button wire:click="deleteConfirmed" class="bg-red-600 hover:bg-red-700">Hapus</x-danger-button>
            </div>
        </div>
    </x-modal>
</div>
