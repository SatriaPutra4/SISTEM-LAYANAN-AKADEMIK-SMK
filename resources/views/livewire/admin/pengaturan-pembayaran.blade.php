<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Pengaturan Pembayaran</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Kelola daftar rekening bank sekolah untuk pembayaran siswa.</p>
        </div>
        <button wire:click="openModal" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 font-medium text-sm transition-colors shadow-sm flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Tambah Rekening
        </button>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 dark:bg-gray-900/50 border-b border-gray-100 dark:border-gray-700">
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nama Bank</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nomor Rekening</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Atas Nama</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($rekenings as $rek)
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/50 transition-colors">
                            <td class="px-6 py-4">
                                <span class="font-medium text-gray-900 dark:text-gray-100">{{ $rek->nama_bank }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-mono text-gray-700 dark:text-gray-300">{{ $rek->nomor_rekening }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-gray-700 dark:text-gray-300">{{ $rek->nama_pemilik }}</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end space-x-3">
                                    <button wire:click="edit({{ $rek->id }})" class="text-primary-600 hover:text-primary-900 dark:hover:text-primary-400 font-medium text-sm transition-colors">
                                        Edit
                                    </button>
                                    <button wire:click="delete({{ $rek->id }})" wire:confirm="Yakin ingin menghapus rekening ini?" class="text-red-600 hover:text-red-900 dark:hover:text-red-400 font-medium text-sm transition-colors">
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                <p class="mt-2 text-sm font-medium">Belum ada data rekening sekolah.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Form -->
    <x-modal name="modal-rekening" maxWidth="md">
        <div class="p-6">
            <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">
                {{ $rekening_id ? 'Edit Rekening' : 'Tambah Rekening Baru' }}
            </h2>

            <div class="space-y-4">
                <div>
                    <x-input-label for="nama_bank" :value="__('Nama Bank')" />
                    <x-text-input wire:model="nama_bank" id="nama_bank" class="block mt-1 w-full" type="text" placeholder="Cth: Bank BRI" />
                    <x-input-error :messages="$errors->get('nama_bank')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="nomor_rekening" :value="__('Nomor Rekening')" />
                    <x-text-input wire:model="nomor_rekening" id="nomor_rekening" class="block mt-1 w-full font-mono" type="text" placeholder="Cth: 1234567890" />
                    <x-input-error :messages="$errors->get('nomor_rekening')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="nama_pemilik" :value="__('Atas Nama')" />
                    <x-text-input wire:model="nama_pemilik" id="nama_pemilik" class="block mt-1 w-full" type="text" placeholder="Cth: SMK Tri Bhakti Al Husna" />
                    <x-input-error :messages="$errors->get('nama_pemilik')" class="mt-2" />
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <x-secondary-button wire:click="$dispatch('close-modal', 'modal-rekening')">
                    {{ __('Batal') }}
                </x-secondary-button>
                <x-primary-button wire:click="store">
                    {{ __('Simpan') }}
                </x-primary-button>
            </div>
        </div>
    </x-modal>
</div>
