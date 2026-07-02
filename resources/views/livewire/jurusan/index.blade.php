<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Manajemen Data Jurusan</h2>
            <p class="text-sm text-gray-500 mt-1">Kelola data jurusan SMK Tri Bhakti Al Husna</p>
        </div>
        <button x-data @click="$dispatch('open-modal', 'modal-jurusan')" class="bg-primary-600 hover:bg-primary-700 text-white px-5 py-2.5 rounded-xl font-bold transition-all shadow-sm flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Jurusan
        </button>
    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 dark:bg-gray-700/50">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Nama Jurusan</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Kode</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($jurusans as $j)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                        <td class="px-6 py-4 text-sm font-bold text-gray-800 dark:text-gray-200">{{ $j->nama_jurusan }}</td>
                        <td class="px-6 py-4 text-sm text-primary-600 font-bold uppercase">{{ $j->kode_jurusan }}</td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center space-x-2">
                                <button wire:click="edit({{ $j->id }})" class="p-2 text-gray-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                </button>
                                <button wire:click="confirmDelete({{ $j->id }})" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-12 text-center text-gray-400 italic">Data jurusan tidak ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Confirm Deletion Modal -->
    <x-modal name="confirm-jurusan-deletion" focusable>
        <div class="p-6">
            <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">Konfirmasi Hapus Data</h2>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Anda yakin ingin menghapus data jurusan ini? Tindakan ini tidak dapat dibatalkan.</p>
            <div class="mt-6 flex justify-end space-x-3">
                <x-secondary-button x-on:click="$dispatch('close')">Batal</x-secondary-button>
                <x-danger-button wire:click="deleteConfirmed" class="bg-red-600 hover:bg-red-700">Hapus</x-danger-button>
            </div>
        </div>
    </x-modal>

    <!-- Modal Form -->
    <x-modal name="modal-jurusan" focusable>
        <form wire:submit.prevent="save" class="p-6">
            <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-6 border-b pb-4">
                Formulir Jurusan
            </h2>
            <div class="space-y-4">
                <x-input-label for="nama_jurusan" value="Nama Jurusan" />
                <x-text-input wire:model="nama_jurusan" id="nama_jurusan" type="text" class="block w-full" placeholder="Contoh: Rekayasa Perangkat Lunak" />
                <x-input-error :messages="$errors->get('nama_jurusan')" class="mt-2" />
                
                <x-input-label for="kode_jurusan" value="Kode Jurusan" />
                <x-text-input wire:model="kode_jurusan" id="kode_jurusan" type="text" class="block w-full" placeholder="Contoh: RPL" />
                <x-input-error :messages="$errors->get('kode_jurusan')" class="mt-2" />
            </div>
            <div class="mt-6 flex justify-end space-x-3 border-t pt-6">
                <x-secondary-button x-on:click="$dispatch('close')">Batal</x-secondary-button>
                <x-primary-button class="bg-primary-600">Simpan Data</x-primary-button>
            </div>
        </form>
    </x-modal>
</div>
