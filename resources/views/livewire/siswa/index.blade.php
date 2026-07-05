<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Manajemen Data Siswa</h2>
            <p class="text-sm text-gray-500 mt-1">Kelola data siswa SMK Tri Bhakti Al Husna</p>
        </div>
        <div class="flex space-x-2">
            <button wire:click="$set('showImportModal', true)" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-xl font-bold transition-all shadow-sm flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                </svg>
                Import Excel
            </button>
            <button wire:click="create" class="bg-primary-600 hover:bg-primary-700 text-white px-5 py-2.5 rounded-xl font-bold transition-all shadow-sm flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Siswa
            </button>
        </div>
    </div>

    @if($showImportModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm" wire:click="$set('showImportModal', false)"></div>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl w-full max-w-lg p-6 relative z-10 animate-fade-in">
            <h3 class="text-xl font-bold mb-2">Import Data Siswa</h3>
            <p class="text-sm text-gray-500 mb-6">Pilih file CSV untuk melakukan import data masal.</p>
            
            <form wire:submit.prevent="import" class="space-y-4">
                <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-emerald-500 transition-colors" x-data="{ fileName: 'Klik untuk pilih file' }">
                    <input type="file" wire:model="file" class="hidden" id="file-upload" @change="fileName = $event.target.files[0].name">
                    <label for="file-upload" class="cursor-pointer">
                        <div class="flex flex-col items-center">
                            <template x-if="fileName !== 'Klik untuk pilih file'">
                                <svg class="w-12 h-12 text-emerald-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                            </template>
                            <template x-if="fileName === 'Klik untuk pilih file'">
                                <svg class="w-10 h-10 text-emerald-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" /></svg>
                            </template>
                            <span class="block text-sm font-semibold truncate max-w-[200px]" x-text="fileName"></span>
                            <span class="block text-xs text-gray-400 mt-1">CSV (Maks 5MB)</span>
                        </div>
                    </label>
                </div>
                @error('file') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" wire:click="$set('showImportModal', false)" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">Batal</button>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 flex items-center gap-2">
                        <div wire:loading wire:target="import" class="w-4 h-4 border-2 border-white/30 border-t-white rounded-full animate-spin"></div>
                        <span wire:loading.remove wire:target="import">Import Sekarang</span>
                        <span wire:loading wire:target="import">Sedang mengimpor...</span>
                    </button>
                </div>
            </form>
        </div>
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
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari berdasarkan nama atau NIS..." class="block w-full pl-10 pr-3 py-2.5 bg-gray-50 dark:bg-gray-900 border-none rounded-xl focus:ring-2 focus:ring-primary-500 text-sm">
        </div>
        <div class="flex items-center space-x-2">
            <select wire:model.live="target_kelas_id" class="bg-gray-50 dark:bg-gray-900 border-none rounded-xl focus:ring-2 focus:ring-primary-500 text-sm py-2.5 px-4">
                <option value="">Semua Kelas</option>
                @foreach($kelases as $k)
                    <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                @endforeach
            </select>
            @if($target_kelas_id)
                <button x-data x-on:click="$dispatch('open-modal', 'modal-luluskan')" class="bg-amber-600 hover:bg-amber-700 text-white px-4 py-2.5 rounded-xl font-bold transition-all shadow-sm text-sm">
                    Luluskan Angkatan
                </button>
                <button x-data x-on:click="$dispatch('open-modal', 'modal-naikkan-kelas')" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-xl font-bold transition-all shadow-sm text-sm">
                    Naikkan Kelas
                </button>
            @endif
        </div>
    </div>

    <!-- Modals Aksi Massal -->
    <x-modal name="modal-luluskan" focusable>
        <div class="p-6">
            <h2 class="text-lg font-bold text-gray-900">Konfirmasi Kelulusan Massal</h2>
            <p class="mt-2 text-sm text-gray-600">Yakin ingin meluluskan seluruh siswa di kelas ini?</p>
            <div class="mt-6 flex justify-end space-x-3">
                <x-secondary-button x-on:click="$dispatch('close')">Batal</x-secondary-button>
                <x-primary-button wire:click="luluskanAngkatan({{ $target_kelas_id ?? 0 }})" x-on:click="$dispatch('close')" class="bg-amber-600 hover:bg-amber-700">Ya, Luluskan</x-primary-button>
            </div>
        </div>
    </x-modal>

    <x-modal name="modal-naikkan-kelas" focusable>
        <div class="p-6" x-data="{ tujuan_id: '' }">
            <h2 class="text-lg font-bold text-gray-900">Konfirmasi Kenaikan Kelas</h2>
            <div class="mt-4 space-y-2">
                <label class="text-sm text-gray-600">Pilih kelas tujuan:</label>
                <select x-model="tujuan_id" class="w-full rounded-lg border-gray-300">
                    <option value="">Pilih Kelas</option>
                    @foreach($kelases as $k)
                        <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mt-6 flex justify-end space-x-3">
                <x-secondary-button x-on:click="$dispatch('close')">Batal</x-secondary-button>
                <x-primary-button x-on:click="$wire.naikkanKelas({{ $target_kelas_id ?? 0 }}, tujuan_id); $dispatch('close')" class="bg-blue-600 hover:bg-blue-700">Naikkan Kelas</x-primary-button>
            </div>
        </div>
    </x-modal>

    <!-- Table -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 dark:bg-gray-700/50">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Nama / NIS</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Kelas & Jurusan</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">L/P</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Kontak</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($siswas as $s)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <img class="w-10 h-10 rounded-xl mr-3" src="https://ui-avatars.com/api/?name={{ urlencode($s->user->name) }}&color=047857&background=ecfdf5" alt="">
                                <div>
                                    <div class="text-sm font-bold text-gray-800 dark:text-gray-200">{{ $s->user->name }}</div>
                                    <div class="text-xs text-gray-400 font-medium">{{ $s->nis }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $s->kelas->nama_kelas }}</div>
                            <div class="text-xs text-primary-600 font-bold uppercase">{{ $s->jurusan->kode_jurusan }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-bold rounded-lg {{ $s->jenis_kelamin == 'L' ? 'bg-blue-100 text-blue-700' : 'bg-pink-100 text-pink-700' }}">
                                {{ $s->jenis_kelamin }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $s->no_hp ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center space-x-2">
                                <button wire:click="show({{ $s->id }})" class="p-2 text-gray-400 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                                <button wire:click="edit({{ $s->id }})" class="p-2 text-gray-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                <button wire:click="confirmDelete({{ $s->id }})" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-400 italic">Data siswa tidak ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700">
            {{ $siswas->links() }}
        </div>
    </div>

    <!-- Student Profile Modal -->
    <x-modal name="modal-view-siswa" focusable>
        @if($selectedSiswa)
        <div class="p-6">
            <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100 border-b pb-4 mb-4">Profil Siswa</h2>
            <div class="space-y-4">
                <div class="flex items-center space-x-4">
                    <img class="w-20 h-20 rounded-xl" src="https://ui-avatars.com/api/?name={{ urlencode($selectedSiswa->user->name) }}&color=047857&background=ecfdf5" alt="">
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
                        <p class="text-xs text-gray-400 uppercase">Kelas</p>
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

    <!-- Delete Confirmation Modal -->

    <x-modal name="confirm-siswa-deletion" focusable>
        <div class="p-6">
            <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                Konfirmasi Hapus Data
            </h2>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                Anda yakin ingin menghapus data siswa ini? Tindakan ini tidak dapat dibatalkan.
            </p>
            <div class="mt-6 flex justify-end space-x-3">
                <x-secondary-button x-on:click="$dispatch('close')">Batal</x-secondary-button>
                <x-danger-button wire:click="deleteConfirmed" class="bg-red-600 hover:bg-red-700">Hapus</x-danger-button>
            </div>
        </div>
    </x-modal>


    <!-- Modal Form -->
    <x-modal name="modal-siswa" :show="false" focusable>
        <form wire:submit.prevent="store" class="p-6">
            <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-6 border-b pb-4">
                Formulir Data Siswa
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <x-input-label for="name" value="Nama Lengkap" />
                    <x-text-input wire:model="name" id="name" type="text" class="block w-full" placeholder="Masukkan nama lengkap" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                <div class="space-y-2">
                    <x-input-label for="email" value="Email" />
                    <x-text-input wire:model="email" id="email" type="email" class="block w-full" placeholder="email@siswa.com" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
                <div class="space-y-2">
                    <x-input-label for="nis" value="NIS" />
                    <x-text-input wire:model="nis" id="nis" type="text" class="block w-full" placeholder="Contoh: 20240001" />
                    <x-input-error :messages="$errors->get('nis')" class="mt-2" />
                </div>
                <div class="space-y-2">
                    <x-input-label for="jenis_kelamin" value="Jenis Kelamin" />
                    <select wire:model="jenis_kelamin" id="jenis_kelamin" class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm">
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                    <x-input-error :messages="$errors->get('jenis_kelamin')" class="mt-2" />
                </div>
                <div class="space-y-2">
                    <x-input-label for="jurusan_id" value="Jurusan" />
                    <select wire:model="jurusan_id" id="jurusan_id" class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm">
                        <option value="">Pilih Jurusan</option>
                        @foreach($jurusans as $j)
                            <option value="{{ $j->id }}">{{ $j->nama_jurusan }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('jurusan_id')" class="mt-2" />
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
                @if($isEdit)
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
                Anda yakin ingin mereset password siswa ini ke "password"?
            </p>
            <div class="mt-6 flex justify-end space-x-3">
                <x-secondary-button x-on:click="$dispatch('close')">Batal</x-secondary-button>
                <x-primary-button wire:click="resetPasswordConfirmed" class="bg-indigo-600 hover:bg-indigo-700">Ya, Reset</x-primary-button>
            </div>
        </div>
    </x-modal>
