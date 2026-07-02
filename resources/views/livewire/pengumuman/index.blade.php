<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Manajemen Pengumuman</h2>
            <p class="text-sm text-gray-500 mt-1">Kelola informasi dan pengumuman sekolah</p>
        </div>
        <div>
            <button wire:click="create" class="bg-primary-600 hover:bg-primary-700 text-white px-5 py-2.5 rounded-xl font-bold transition-all shadow-sm flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Buat Pengumuman
            </button>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 p-4 mb-4 rounded-r-xl shadow-sm animate-fade-in" role="alert">
            <p>{{ session('message') }}</p>
        </div>
    @endif

    <!-- Search -->
    <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
        <div class="relative max-w-md">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </span>
            <input wire:model.live="search" type="text" placeholder="Cari pengumuman..." class="block w-full pl-10 pr-3 py-2.5 bg-gray-50 dark:bg-gray-900 border-none rounded-xl focus:ring-2 focus:ring-primary-500 text-sm">
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 dark:bg-gray-700/50">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Judul & Konten</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Target</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Penulis</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($pengumumans as $p)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-gray-800 dark:text-gray-200 line-clamp-1">{{ $p->judul }}</div>
                            <div class="text-xs text-gray-400 font-medium line-clamp-1 mt-1">{{ Str::limit(strip_tags($p->konten), 50) }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-[10px] font-bold uppercase rounded-lg {{ $p->target_role == 'all' ? 'bg-purple-100 text-purple-700' : ($p->target_role == 'guru' ? 'bg-amber-100 text-amber-700' : 'bg-blue-100 text-blue-700') }}">
                                {{ $p->target_role }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="flex items-center">
                                <span class="w-2 h-2 rounded-full mr-2 {{ $p->status_publish == 'Published' ? 'bg-emerald-500' : 'bg-gray-400' }}"></span>
                                <span class="text-sm font-medium {{ $p->status_publish == 'Published' ? 'text-emerald-600' : 'text-gray-500' }}">
                                    {{ $p->status_publish }}
                                </span>
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                            {{ $p->author->name }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center space-x-2">
                                <button wire:click="edit({{ $p->id }})" class="p-2 text-gray-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                <button wire:click="confirmDelete({{ $p->id }})" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-400 italic">Data pengumuman tidak ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700">
            {{ $pengumumans->links() }}
        </div>
    </div>

    <!-- Modal Form -->
    <x-modal name="modal-pengumuman" focusable maxWidth="2xl">
        <form wire:submit.prevent="store" class="p-6">
            <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-6 border-b pb-4">
                {{ $isEdit ? 'Edit Pengumuman' : 'Buat Pengumuman Baru' }}
            </h2>

            <div class="space-y-4">
                <div class="space-y-2">
                    <x-input-label for="judul" value="Judul Pengumuman" />
                    <x-text-input wire:model="judul" id="judul" type="text" class="block w-full" placeholder="Masukkan judul pengumuman" />
                    <x-input-error :messages="$errors->get('judul')" class="mt-2" />
                </div>

                <div class="space-y-2">
                    <x-input-label for="konten" value="Konten / Isi" />
                    <textarea wire:model="konten" id="konten" rows="5" class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm" placeholder="Tulis isi pengumuman di sini..."></textarea>
                    <x-input-error :messages="$errors->get('konten')" class="mt-2" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <x-input-label for="target_role" value="Target Audiens" />
                        <select wire:model="target_role" id="target_role" class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm">
                            <option value="all">Semua (Guru & Siswa)</option>
                            <option value="guru">Hanya Guru</option>
                            <option value="siswa">Hanya Siswa</option>
                        </select>
                        <x-input-error :messages="$errors->get('target_role')" class="mt-2" />
                    </div>
                    <div class="space-y-2">
                        <x-input-label for="status_publish" value="Status" />
                        <select wire:model="status_publish" id="status_publish" class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm">
                            <option value="Draft">Draft</option>
                            <option value="Published">Published</option>
                        </select>
                        <x-input-error :messages="$errors->get('status_publish')" class="mt-2" />
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3 border-t pt-6">
                <x-secondary-button x-on:click="$dispatch('close')">
                    Batal
                </x-secondary-button>
                <x-primary-button class="bg-primary-600 hover:bg-primary-700">
                    Simpan Pengumuman
                </x-primary-button>
            </div>
        </form>
    </x-modal>

    <!-- Delete Confirmation Modal -->
    <x-modal name="confirm-pengumuman-deletion" focusable>
        <div class="p-6">
            <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                Konfirmasi Hapus Pengumuman
            </h2>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                Apakah Anda yakin ingin menghapus pengumuman ini? Tindakan ini akan menghapus data secara permanen.
            </p>
            <div class="mt-6 flex justify-end space-x-3">
                <x-secondary-button x-on:click="$dispatch('close')">Batal</x-secondary-button>
                <x-danger-button wire:click="deleteConfirmed" class="bg-red-600 hover:bg-red-700">Hapus</x-danger-button>
            </div>
        </div>
    </x-modal>
</div>
