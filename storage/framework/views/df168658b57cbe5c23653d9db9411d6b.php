<div class="space-y-6" x-data="{ errorModal: false, confirmSubmit: false, confirmCancel: false }" @notify.window="if($event.detail.type === 'error') errorModal = true">
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
        <div x-show="confirmSubmit" class="fixed inset-0 z-[100] flex items-center justify-center px-4" style="display: none;">
            <div class="fixed inset-0 bg-gray-900/75 backdrop-blur-sm" @click="confirmSubmit = false"></div>
            <div class="bg-white dark:bg-gray-800 rounded-3xl p-8 max-w-sm w-full shadow-2xl relative z-10 text-center">
                <h3 class="text-xl font-black text-gray-800 dark:text-white mb-2">Konfirmasi Pengajuan</h3>
                <p class="text-gray-500 dark:text-gray-400 mb-6">Apakah Anda yakin ingin mengirim pengajuan surat ini?</p>
                <div class="flex gap-4">
                    <button @click="confirmSubmit = false" class="flex-1 px-4 py-3 bg-gray-100 dark:bg-gray-700 font-bold rounded-2xl">Batal</button>
                    <button @click="confirmSubmit = false; $wire.ajukanSurat()" class="flex-1 px-4 py-3 bg-indigo-600 text-white font-bold rounded-2xl">Kirim</button>
                </div>
            </div>
        </div>
    </template>

    <template x-teleport="body">
        <div x-show="confirmCancel" class="fixed inset-0 z-[100] flex items-center justify-center px-4" style="display: none;">
            <div class="fixed inset-0 bg-gray-900/75 backdrop-blur-sm" @click="confirmCancel = false"></div>
            <div class="bg-white dark:bg-gray-800 rounded-3xl p-8 max-w-sm w-full shadow-2xl relative z-10 text-center">
                <h3 class="text-xl font-black text-gray-800 dark:text-white mb-2">Batalkan Pengajuan?</h3>
                <p class="text-gray-500 dark:text-gray-400 mb-6">Tindakan ini tidak dapat dibatalkan. Yakin ingin membatalkan pengajuan ini?</p>
                <div class="flex gap-4">
                    <button @click="confirmCancel = false" class="flex-1 px-4 py-3 bg-gray-100 dark:bg-gray-700 font-bold rounded-2xl">Tidak</button>
                    <button @click="confirmCancel = false; $wire.batalkanPengajuan(<?php echo \Illuminate\Support\Js::from($confirm_cancel_id)->toHtml() ?>)" class="flex-1 px-4 py-3 bg-rose-600 text-white font-bold rounded-2xl">Ya, Batalkan</button>
                </div>
            </div>
        </div>
    </template>

    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="p-8 border-b border-gray-50 dark:border-gray-700 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div>
                <h3 class="text-2xl font-black text-gray-800 dark:text-white flex items-center gap-3">
                    <div class="w-1.5 h-8 bg-indigo-600 rounded-full"></div>
                    Layanan Pengajuan Surat
                </h3>
                <p class="text-gray-500 mt-1">Ajukan surat keterangan atau perizinan secara online.</p>
            </div>
            
            <button wire:click="openModal" class="bg-indigo-600 text-white px-6 py-3 rounded-2xl font-bold shadow-lg shadow-indigo-200 dark:shadow-none hover:bg-indigo-700 transition-all flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Buat Pengajuan
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-900/50">
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Jenis Surat</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Keperluan</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Tanggal</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Status</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-gray-700">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $pengajuans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/30 transition-colors">
                        <td class="px-8 py-5 font-black text-gray-700 dark:text-gray-300"><?php echo e($p->jenis_surat); ?></td>
                        <td class="px-8 py-5">
                            <p class="text-sm font-bold text-gray-600 dark:text-gray-400 line-clamp-1"><?php echo e($p->keperluan); ?></p>
                        </td>
                        <td class="px-8 py-5 text-center text-xs font-bold text-gray-400">
                            <?php echo e($p->created_at->format('d/m/Y')); ?>

                        </td>
                        <td class="px-8 py-5 text-center">
                            <span class="px-4 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest
                                <?php echo e($p->status === 'Diproses' ? 'bg-amber-50 text-amber-600' : ''); ?>

                                <?php echo e($p->status === 'Disetujui' ? 'bg-emerald-50 text-emerald-600' : ''); ?>

                                <?php echo e($p->status === 'Ditolak' ? 'bg-rose-50 text-rose-600' : ''); ?>

                            ">
                                <?php echo e($p->status); ?>

                            </span>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($p->status === 'Disetujui' && $p->file_url): ?>
                                <a href="<?php echo e(Storage::url($p->file_url)); ?>" target="_blank" class="block mt-2 text-indigo-600 hover:text-indigo-800 font-bold text-[10px] uppercase">
                                    Unduh PDF
                                </a>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </td>
                        <td class="px-8 py-5 text-center">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($p->status === 'Diproses'): ?>
                                <button type="button" @click="$wire.set('confirm_cancel_id', <?php echo e($p->id); ?>); confirmCancel = true" class="text-rose-600 hover:text-rose-700 font-bold text-xs uppercase tracking-widest">
                                    Batalkan
                                </button>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </td>
                    </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <tr>
                        <td colspan="5" class="px-8 py-20 text-center text-gray-400 font-bold uppercase tracking-widest text-xs">Belum ada riwayat pengajuan</td>
                    </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <div class="p-8 border-t border-gray-50 dark:border-gray-700">
            <?php echo e($pengajuans->links()); ?>

        </div>
    </div>

    <!-- Modal Pengajuan -->
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($is_modal_open): ?>
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-gray-900/75 backdrop-blur-sm" wire:click="closeModal"></div>
            
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            
            <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full">
                <div class="p-8">
                    <h3 class="text-2xl font-black text-gray-800 dark:text-white mb-6">Buat Pengajuan Surat</h3>
                    
                    <form wire:submit.prevent class="space-y-5">
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-gray-600 dark:text-gray-400">Jenis Surat</label>
                            <select wire:model="jenis_surat" class="w-full bg-gray-50 dark:bg-gray-900 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 font-medium">
                                <option value="">Pilih Jenis Surat</option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $daftar_jenis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jenis): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <option value="<?php echo e($jenis); ?>"><?php echo e($jenis); ?></option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </select>
                            <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->get('jenis_surat')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('jenis_surat'))]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                        </div>
                        
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-gray-600 dark:text-gray-400">Keperluan</label>
                            <input type="text" wire:model="keperluan" placeholder="Contoh: Pendaftaran Lomba" class="w-full bg-gray-50 dark:bg-gray-900 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 font-medium">
                            <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->get('keperluan')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('keperluan'))]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                        </div>
                        
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-gray-600 dark:text-gray-400">Deskripsi Detail</label>
                            <textarea wire:model="deskripsi" rows="3" placeholder="Jelaskan secara detail keperluan Anda..." class="w-full bg-gray-50 dark:bg-gray-900 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 font-medium"></textarea>
                            <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->get('deskripsi')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('deskripsi'))]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                        </div>
                        
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-gray-600 dark:text-gray-400">Dokumen Pendukung (Opsional)</label>
                            <div class="relative group">
                                <div class="w-full h-32 bg-gray-50 dark:bg-gray-900 border-2 border-dashed border-gray-200 dark:border-gray-700 rounded-2xl flex flex-col items-center justify-center gap-2 group-hover:border-indigo-400 transition-colors">
                                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" /></svg>
                                    <span class="text-xs font-bold text-gray-400">Klik untuk upload file (PDF/JPG/PNG)</span>
                                </div>
                                <input type="file" wire:model="dokumen_pendukung" class="absolute inset-0 opacity-0 cursor-pointer">
                            </div>
                            <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->get('dokumen_pendukung')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('dokumen_pendukung'))]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                        </div>
                        
                        <div class="flex gap-4 pt-6">
                            <button type="button" wire:click="closeModal" class="flex-1 px-6 py-3 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 font-bold rounded-2xl hover:bg-gray-200 transition-all">Batal</button>
                            <button type="button" @click="confirmSubmit = true" class="flex-1 px-6 py-3 bg-indigo-600 text-white font-bold rounded-2xl shadow-lg shadow-indigo-200 dark:shadow-none hover:bg-indigo-700 transition-all flex items-center justify-center gap-2">
                                <div wire:loading wire:target="ajukanSurat" class="w-4 h-4 border-2 border-white/30 border-t-white rounded-full animate-spin"></div>
                                Kirim Pengajuan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div><?php /**PATH C:\laragon\www\SISTEM-LAYANAN-AKADEMIK-SMK\resources\views/livewire/siswa-role/surat.blade.php ENDPATH**/ ?>