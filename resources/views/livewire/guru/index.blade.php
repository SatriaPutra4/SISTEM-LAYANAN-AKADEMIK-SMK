<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Manajemen Data Guru</h2>
            <p class="text-sm text-gray-500 mt-1">Kelola data tenaga pengajar SMK Tri Bhakti Al Husna</p>
        </div>
        <button x-on:click="$dispatch('open-modal', 'modal-guru')" wire:click="resetFields" class="bg-primary-600 hover:bg-primary-700 text-white px-5 py-2.5 rounded-xl font-bold transition-all shadow-sm flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
            Tambah Guru
        </button>
    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 dark:bg-gray-700/50">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Guru</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Kontak</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Alamat</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($gurus as $g)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                @if($g->foto_profil)
                                    <img class="w-10 h-10 rounded-xl mr-3 object-cover" src="{{ asset('storage/' . $g->foto_profil) }}" alt="">
                                @else
                                    <div class="w-10 h-10 rounded-xl bg-primary-100 text-primary-600 flex items-center justify-center font-bold mr-3">
                                        {{ substr($g->user->name, 0, 1) }}
                                    </div>
                                @endif
                                <div>
                                    <div class="text-sm font-bold text-gray-800 dark:text-gray-200">{{ $g->user->name }}</div>
                                    <div class="text-xs text-gray-400 font-medium">NIP: {{ $g->nip ?? '-' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-700 dark:text-gray-300">{{ $g->no_hp ?? '-' }}</div>
                            <div class="text-xs text-gray-500">{{ $g->user->email }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500 truncate max-w-xs">
                            {{ $g->alamat ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center space-x-2">
                                <button wire:click="edit({{ $g->id }})" x-on:click="$dispatch('open-modal', 'modal-guru')" class="p-2 text-gray-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                </button>
                                <button wire:click="confirmDelete({{ $g->id }})" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-gray-400 italic">Data guru tidak ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700">
            {{ $gurus->links() }}
        </div>
    </div>

    <!-- Confirm Deletion Modal -->
    <x-modal name="confirm-guru-deletion" focusable>
        <div class="p-6">
            <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">Konfirmasi Hapus Data</h2>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Anda yakin ingin menghapus data guru ini? Tindakan ini tidak dapat dibatalkan.</p>
            <div class="mt-6 flex justify-end space-x-3">
                <x-secondary-button x-on:click="$dispatch('close')">Batal</x-secondary-button>
                <x-danger-button wire:click="deleteConfirmed" class="bg-red-600 hover:bg-red-700">Hapus</x-danger-button>
            </div>
        </div>
    </x-modal>

    <!-- Modal Form -->
    <x-modal name="modal-guru" :show="$showModal" focusable>
        <form wire:submit.prevent="save" class="p-6">
            <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-6 border-b pb-4">
                {{ $guru_id ? 'Edit Data Guru' : 'Tambah Guru Baru' }}
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <x-input-label for="name" value="Nama Lengkap" />
                    <x-text-input wire:model="name" id="name" type="text" class="block w-full" placeholder="Masukkan nama lengkap" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                <div class="space-y-2">
                    <x-input-label for="email" value="Email" />
                    <x-text-input wire:model="email" id="email" type="email" class="block w-full" placeholder="email@guru.com" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
                
                @if(!$guru_id)
                <div class="space-y-2">
                    <x-input-label for="password" value="Password" />
                    <x-text-input wire:model="password" id="password" type="password" class="block w-full" placeholder="••••••••" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
                @endif

                <div class="space-y-2">
                    <x-input-label for="nip" value="NIP" />
                    <x-text-input wire:model="nip" id="nip" type="text" class="block w-full" placeholder="Masukkan NIP" />
                    <x-input-error :messages="$errors->get('nip')" class="mt-2" />
                </div>
                <div class="space-y-2">
                    <x-input-label for="no_hp" value="Nomor HP" />
                    <x-text-input wire:model="no_hp" id="no_hp" type="text" class="block w-full" placeholder="08xxxxxxxxxx" />
                    <x-input-error :messages="$errors->get('no_hp')" class="mt-2" />
                </div>
                <div class="space-y-2 md:col-span-2">
                    <x-input-label for="alamat" value="Alamat" />
                    <textarea wire:model="alamat" id="alamat" class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm" rows="3" placeholder="Masukkan alamat lengkap"></textarea>
                    <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                </div>
                <div class="space-y-2 md:col-span-2">
                    <x-input-label for="foto" value="Foto Profil" />
                    <input type="file" wire:model="foto" id="foto" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100" />
                    <x-input-error :messages="$errors->get('foto')" class="mt-2" />
                </div>
            </div>

            <div class="mt-6 flex justify-between space-x-3 border-t pt-6">
                @if($guru_id)
                    <button type="button" wire:click="dispatch('open-modal', 'confirm-reset-password')" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-semibold hover:bg-indigo-700">
                        Reset Password
                    </button>
                @else
                    <div></div>
                @endif
                <div class="flex space-x-3">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        Batal
                    </x-secondary-button>
                    <x-primary-button class="bg-primary-600 hover:bg-primary-700">
                        Simpan Data
                    </x-primary-button>
                </div>
            </div>
        </form>
    </x-modal>

    <!-- Reset Password Confirmation Modal -->
    <x-modal name="confirm-reset-password" focusable>
        <div class="p-6">
            <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                Konfirmasi Reset Password
            </h2>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                Anda yakin ingin mereset password guru ini ke "password"?
            </p>
            <div class="mt-6 flex justify-end space-x-3">
                <x-secondary-button x-on:click="$dispatch('close')">Batal</x-secondary-button>
                <x-primary-button wire:click="resetPasswordConfirmed" class="bg-indigo-600 hover:bg-indigo-700">Ya, Reset</x-primary-button>
            </div>
        </div>
    </x-modal>
