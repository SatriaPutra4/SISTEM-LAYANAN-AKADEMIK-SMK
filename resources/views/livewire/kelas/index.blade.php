<div class="space-y-6" x-data="{ open: false, message: '' }" @notify.window="message = $event.detail.message; open = true; setTimeout(() => open = false, 3000)">
    <!-- Notification Toast -->
    <div x-show="open" x-transition class="fixed top-20 right-5 z-50 bg-emerald-600 text-white px-6 py-3 rounded-xl shadow-lg flex items-center">
        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
        <span x-text="message"></span>
    </div>

    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Manajemen Data Kelas</h2>
            <p class="text-sm text-gray-500 mt-1">Kelola data kelas SMK Tri Bhakti Al Husna</p>
        </div>
        <button x-data @click="$dispatch('open-modal', 'modal-kelas')" class="bg-primary-600 hover:bg-primary-700 text-white px-5 py-2.5 rounded-xl font-bold transition-all shadow-sm flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Kelas
        </button>
    </div>

    <!-- Filter & Search -->
    <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
        <div class="relative max-w-md">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </span>
            <input wire:model.live="search" type="text" placeholder="Cari nama kelas..." class="block w-full pl-10 pr-3 py-2.5 bg-gray-50 dark:bg-gray-900 border-none rounded-xl focus:ring-2 focus:ring-primary-500 text-sm">
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 dark:bg-gray-700/50">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Nama Kelas</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Jurusan</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($kelases as $k)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                        <td class="px-6 py-4 text-sm font-bold text-gray-800 dark:text-gray-200">{{ $k->nama_kelas }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">{{ $k->jurusan->nama_jurusan ?? '-' }}</td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center space-x-2">
                                <button wire:click="edit({{ $k->id }})" class="p-2 text-gray-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                </button>
                                <button wire:click="confirmDelete({{ $k->id }})" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                                </div>
                                </td>
                                </tr>
                                @empty
                                <tr>
                                <td colspan="3" class="px-6 py-12 text-center text-gray-400 italic">Data kelas tidak ditemukan.</td>
                                </tr>
                                @endforelse
                                </tbody>
                                </table>
                                </div>
                                </div>

                                <!-- Confirm Deletion Modal -->
                                <x-modal name="confirm-kelas-deletion" focusable>
                                <div class="p-6">
                                <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">Konfirmasi Hapus Data</h2>
                                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Anda yakin ingin menghapus data kelas ini? Tindakan ini tidak dapat dibatalkan.</p>
                                <div class="mt-6 flex justify-end space-x-3">
                                <x-secondary-button x-on:click="$dispatch('close')">Batal</x-secondary-button>
                                <x-danger-button wire:click="deleteConfirmed" class="bg-red-600 hover:bg-red-700">Hapus</x-danger-button>
                                </div>
                                </div>
                                </x-modal>

                                <!-- Modal Form -->
    <x-modal name="modal-kelas" focusable>
        <form wire:submit="save" class="p-6">
            <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-6 border-b pb-4">
                Formulir Kelas
            </h2>
            <div class="space-y-4">
                <x-input-label for="nama_kelas" value="Nama Kelas" />
                <x-text-input wire:model="nama_kelas" id="nama_kelas" type="text" class="block w-full" placeholder="Contoh: X RPL 1" />
                <x-input-error :messages="$errors->get('nama_kelas')" class="mt-2" />
                
                <x-input-label for="jurusan_id" value="Jurusan" />
                <select wire:model="jurusan_id" id="jurusan_id" class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm">
                    <option value="">Pilih Jurusan</option>
                    @foreach($jurusans as $j)
                        <option value="{{ $j->id }}">{{ $j->nama_jurusan }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('jurusan_id')" class="mt-2" />
            </div>
            <div class="mt-6 flex justify-end space-x-3 border-t pt-6">
                <x-secondary-button x-on:click="$dispatch('close')">Batal</x-secondary-button>
                <x-primary-button type="submit" class="bg-primary-600">Simpan Data</x-primary-button>
            </div>
        </form>
    </x-modal>
</div>
