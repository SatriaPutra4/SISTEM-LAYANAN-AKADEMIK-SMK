<div class="max-w-2xl mx-auto space-y-6">
    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 p-8">
        <div class="flex items-center gap-4 mb-8">
            <div class="p-3 bg-primary-50 dark:bg-primary-900/20 rounded-2xl">
                <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-800 dark:text-white">Pengaturan Keamanan</h2>
                <p class="text-sm text-gray-500">Perbarui kata sandi akun Anda secara berkala.</p>
            </div>
        </div>

        <form wire:submit.prevent="updatePassword" class="space-y-6">
            <div class="space-y-2">
                <x-input-label for="current_password" value="Kata Sandi Saat Ini" />
                <x-text-input wire:model="current_password" id="current_password" type="password" class="block w-full" />
                <x-input-error :messages="$errors->get('current_password')" />
            </div>

            <div class="space-y-2">
                <x-input-label for="password" value="Kata Sandi Baru" />
                <x-text-input wire:model="password" id="password" type="password" class="block w-full" />
                <x-input-error :messages="$errors->get('password')" />
            </div>

            <div class="space-y-2">
                <x-input-label for="password_confirmation" value="Konfirmasi Kata Sandi Baru" />
                <x-text-input wire:model="password_confirmation" id="password_confirmation" type="password" class="block w-full" />
                <x-input-error :messages="$errors->get('password_confirmation')" />
            </div>

            <div class="flex justify-end pt-4">
                <button type="button" wire:click="dispatch('open-modal', 'confirm-password-update')" class="px-6 py-2.5 bg-gray-800 dark:bg-gray-200 dark:text-gray-800 text-white font-bold rounded-xl hover:bg-gray-700 dark:hover:bg-white transition-all shadow-lg">
                    Perbarui Kata Sandi
                </button>
            </div>
        </form>
    </div>

    <!-- Confirm Password Update Modal -->
    <x-modal name="confirm-password-update" focusable>
        <div class="p-6">
            <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                Konfirmasi Perubahan Password
            </h2>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                Anda yakin ingin mengubah kata sandi Anda?
            </p>
            <div class="mt-6 flex justify-end space-x-3">
                <x-secondary-button x-on:click="$dispatch('close')">Batal</x-secondary-button>
                <x-primary-button wire:click="updatePassword" class="bg-indigo-600 hover:bg-indigo-700">Ya, Perbarui</x-primary-button>
            </div>
        </div>
    </x-modal>
</div>
