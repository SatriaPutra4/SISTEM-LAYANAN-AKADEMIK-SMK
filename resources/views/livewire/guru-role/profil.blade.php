<div class="max-w-4xl mx-auto space-y-6">
    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <!-- Header Profile -->
        <div class="h-32 bg-primary-600"></div>
        <div class="px-8 pb-8">
            <div class="relative flex justify-between items-end -mt-12 mb-6">
                <div class="relative">
                    <div class="h-32 w-32 rounded-3xl border-4 border-white dark:border-gray-800 overflow-hidden bg-gray-100 shadow-lg">
                        @if($foto)
                            <img src="{{ $foto->temporaryUrl() }}" class="h-full w-full object-cover">
                        @elseif($currentFoto)
                            <img src="{{ asset('storage/' . $currentFoto) }}" class="h-full w-full object-cover">
                        @else
                            <div class="h-full w-full flex items-center justify-center text-primary-600 text-4xl font-bold bg-primary-50">
                                {{ substr($name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <label class="absolute bottom-0 right-0 p-2 bg-white dark:bg-gray-700 rounded-xl shadow-md cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors border border-gray-100 dark:border-gray-600">
                        <svg class="w-5 h-5 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        <input type="file" wire:model="foto" class="hidden">
                    </label>
                </div>
                <div class="flex-1 ml-6 mb-2">
                    <h1 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $name }}</h1>
                    <p class="text-gray-500 font-medium">Guru SMK Tri Bhakti</p>
                </div>
                <div class="mb-2">
                    <span class="px-4 py-1.5 bg-primary-50 dark:bg-primary-900/20 text-primary-600 text-sm font-bold rounded-full">Active</span>
                </div>
            </div>

            <form wire:submit.prevent="updateProfil" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <x-input-label for="name" value="Nama Lengkap" />
                        <x-text-input wire:model="name" id="name" type="text" class="block w-full" />
                        <x-input-error :messages="$errors->get('name')" />
                    </div>
                    <div class="space-y-2">
                        <x-input-label for="email" value="Alamat Email" />
                        <x-text-input wire:model="email" id="email" type="email" class="block w-full" />
                        <x-input-error :messages="$errors->get('email')" />
                    </div>
                    <div class="space-y-2">
                        <x-input-label for="nip" value="NIP" />
                        <x-text-input wire:model="nip" id="nip" type="text" class="block w-full" />
                        <x-input-error :messages="$errors->get('nip')" />
                    </div>
                    <div class="space-y-2">
                        <x-input-label for="no_hp" value="Nomor HP" />
                        <x-text-input wire:model="no_hp" id="no_hp" type="text" class="block w-full" />
                        <x-input-error :messages="$errors->get('no_hp')" />
                    </div>
                    <div class="col-span-1 md:col-span-2 space-y-2">
                        <x-input-label for="alamat" value="Alamat Lengkap" />
                        <textarea wire:model="alamat" id="alamat" rows="3" class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm"></textarea>
                        <x-input-error :messages="$errors->get('alamat')" />
                    </div>
                </div>

                <div class="flex justify-end mt-8">
                    <button type="submit" class="px-6 py-2.5 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-primary-500/30 flex items-center gap-2">
                        <span wire:loading.remove wire:target="updateProfil">Simpan Perubahan</span>
                        <span wire:loading wire:target="updateProfil">Menyimpan...</span>
                        <svg wire:loading.remove wire:target="updateProfil" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
