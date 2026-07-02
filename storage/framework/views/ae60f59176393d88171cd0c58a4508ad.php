<div class="space-y-6" x-data="{ errorModal: false, confirmProfile: false, confirmPassword: false }" @notify.window="if($event.detail.type === 'error') errorModal = true">
    <!-- Validation Error Modal -->
    <div x-show="errorModal" class="fixed inset-0 z-[100] overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-gray-900/75 backdrop-blur-sm" @click="errorModal = false"></div>
            <div class="bg-white dark:bg-gray-800 rounded-3xl p-8 max-w-sm w-full shadow-2xl relative z-10 text-center">
                <div class="w-16 h-16 bg-rose-50 dark:bg-rose-900/20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                </div>
                <h3 class="text-xl font-black text-gray-800 dark:text-white mb-2">Terjadi Kesalahan</h3>
                <p class="text-gray-500 dark:text-gray-400 mb-6">Mohon periksa kembali formulir Anda. Pastikan semua field sudah diisi dengan benar.</p>
                <button @click="errorModal = false" class="w-full px-6 py-3 bg-gray-900 dark:bg-white text-white dark:text-gray-900 font-bold rounded-2xl">Mengerti</button>
            </div>
        </div>
    </div>

    <!-- Confirmation Modals -->
    <template x-teleport="body">
        <div x-show="confirmProfile" class="fixed inset-0 z-[100] flex items-center justify-center px-4" style="display: none;">
            <div class="fixed inset-0 bg-gray-900/75 backdrop-blur-sm" @click="confirmProfile = false"></div>
            <div class="bg-white dark:bg-gray-800 rounded-3xl p-8 max-w-sm w-full shadow-2xl relative z-10 text-center">
                <h3 class="text-xl font-black text-gray-800 dark:text-white mb-2">Konfirmasi Perubahan</h3>
                <p class="text-gray-500 dark:text-gray-400 mb-6">Apakah Anda yakin ingin menyimpan perubahan profil Anda?</p>
                <div class="flex gap-4">
                    <button @click="confirmProfile = false" class="flex-1 px-4 py-3 bg-gray-100 dark:bg-gray-700 font-bold rounded-2xl">Batal</button>
                    <button @click="confirmProfile = false; $wire.updateProfile()" class="flex-1 px-4 py-3 bg-primary-600 text-white font-bold rounded-2xl">Simpan</button>
                </div>
            </div>
        </div>
    </template>

    <template x-teleport="body">
        <div x-show="confirmPassword" class="fixed inset-0 z-[100] flex items-center justify-center px-4" style="display: none;">
            <div class="fixed inset-0 bg-gray-900/75 backdrop-blur-sm" @click="confirmPassword = false"></div>
            <div class="bg-white dark:bg-gray-800 rounded-3xl p-8 max-w-sm w-full shadow-2xl relative z-10 text-center">
                <h3 class="text-xl font-black text-gray-800 dark:text-white mb-2">Konfirmasi Password</h3>
                <p class="text-gray-500 dark:text-gray-400 mb-6">Apakah Anda yakin ingin memperbarui password Anda?</p>
                <div class="flex gap-4">
                    <button @click="confirmPassword = false" class="flex-1 px-4 py-3 bg-gray-100 dark:bg-gray-700 font-bold rounded-2xl">Batal</button>
                    <button @click="confirmPassword = false; $wire.updatePassword()" class="flex-1 px-4 py-3 bg-rose-600 text-white font-bold rounded-2xl">Perbarui</button>
                </div>
            </div>
        </div>
    </template>

    <div class="flex flex-col md:flex-row gap-6">
        <!-- Sidebar Info -->
        <div class="w-full md:w-1/3 space-y-6">
            <div class="bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 text-center">
                <div class="relative inline-block group">
                    <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-primary-50 dark:border-primary-900/20 shadow-xl mx-auto">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($new_foto): ?>
                            <img src="<?php echo e($new_foto->temporaryUrl()); ?>" class="w-full h-full object-cover">
                        <?php elseif($foto_profil): ?>
                            <img src="<?php echo e(Storage::url($foto_profil)); ?>" class="w-full h-full object-cover">
                        <?php else: ?>
                            <div class="w-full h-full bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center text-primary-600">
                                <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 20 20"><path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" /></svg>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <label class="absolute bottom-0 right-0 p-2 bg-primary-600 text-white rounded-full shadow-lg cursor-pointer hover:bg-primary-700 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        <input type="file" wire:model="new_foto" class="hidden">
                    </label>
                </div>
                <h3 class="mt-6 text-xl font-black text-gray-800 dark:text-white"><?php echo e($name); ?></h3>
                <p class="text-xs font-bold text-primary-600 uppercase tracking-widest mt-1">Administrator</p>
            </div>
        </div>

        <!-- Edit Form -->
        <div class="w-full md:w-2/3 space-y-6">
            <div class="bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700">
                <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-8 flex items-center gap-3">
                    <div class="w-1.5 h-6 bg-primary-600 rounded-full"></div>
                    Informasi Profil
                </h3>
                
                <form wire:submit.prevent class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-gray-600 dark:text-gray-400">Nama Lengkap</label>
                            <input type="text" wire:model="name" class="w-full bg-gray-50 dark:bg-gray-900 border-none rounded-2xl focus:ring-2 focus:ring-primary-500 font-medium">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-500"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-gray-600 dark:text-gray-400">Email</label>
                            <input type="email" wire:model="email" class="w-full bg-gray-50 dark:bg-gray-900 border-none rounded-2xl focus:ring-2 focus:ring-primary-500 font-medium">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-500"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="flex justify-end pt-4">
                        <button type="button" @click="confirmProfile = true" class="bg-primary-600 text-white px-8 py-3 rounded-2xl font-bold shadow-lg shadow-primary-200 dark:shadow-none hover:bg-primary-700 transition-all flex items-center gap-2">
                            <div wire:loading wire:target="updateProfile" class="w-4 h-4 border-2 border-white/30 border-t-white rounded-full animate-spin"></div>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700">
                <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-8 flex items-center gap-3">
                    <div class="w-1.5 h-6 bg-rose-600 rounded-full"></div>
                    Keamanan Akun
                </h3>
                
                <form wire:submit.prevent class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-gray-600 dark:text-gray-400">Password Sekarang</label>
                            <input type="password" wire:model="current_password" class="w-full bg-gray-50 dark:bg-gray-900 border-none rounded-2xl focus:ring-2 focus:ring-rose-500 font-medium">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-500"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div class="space-y-2 md:col-start-1">
                            <label class="text-sm font-bold text-gray-600 dark:text-gray-400">Password Baru</label>
                            <input type="password" wire:model="password" class="w-full bg-gray-50 dark:bg-gray-900 border-none rounded-2xl focus:ring-2 focus:ring-rose-500 font-medium">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-500"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-gray-600 dark:text-gray-400">Konfirmasi Password</label>
                            <input type="password" wire:model="password_confirmation" class="w-full bg-gray-50 dark:bg-gray-900 border-none rounded-2xl focus:ring-2 focus:ring-rose-500 font-medium">
                        </div>
                    </div>
                    
                    <div class="flex justify-end pt-4">
                        <button type="button" @click="confirmPassword = true" class="bg-rose-600 text-white px-8 py-3 rounded-2xl font-bold shadow-lg shadow-rose-200 dark:shadow-none hover:bg-rose-700 transition-all">
                            Perbarui Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\laragon\www\SISTEM-LAYANAN-AKADEMIK-SMK\resources\views/livewire/admin/profil.blade.php ENDPATH**/ ?>