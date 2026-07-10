<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Pengumuman Sekolah</h1>
            <p class="text-gray-600 dark:text-gray-400">Informasi terbaru seputar kegiatan dan kebijakan sekolah.</p>
        </div>
        <div class="relative w-full md:w-64">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
            </span>
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari pengumuman..." class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 dark:text-white text-sm focus:ring-primary-500 focus:border-primary-500">
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $pengumumans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden hover:shadow-md transition-shadow">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <span class="px-2 py-1 bg-primary-50 dark:bg-primary-900/20 text-primary-600 text-[10px] font-bold rounded uppercase tracking-wider">
                            <?php echo e($p->target_role === 'all' ? 'Untuk Umum' : 'Khusus Guru'); ?>

                        </span>
                        <span class="text-xs text-gray-400 font-medium"><?php echo e($p->created_at->translatedFormat('d F Y')); ?></span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-2"><?php echo e($p->judul); ?></h3>
                    <div class="prose prose-sm dark:prose-invert text-gray-600 dark:text-gray-400 line-clamp-3">
                        <?php echo $p->konten; ?>

                    </div>
                    <div class="mt-6 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-6 h-6 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-[10px] font-bold text-gray-500">
                                <?php echo e(substr($p->author->name ?? 'A', 0, 1)); ?>

                            </div>
                            <span class="text-xs font-medium text-gray-500"><?php echo e($p->author->name ?? 'Admin'); ?></span>
                        </div>
                        <button class="text-primary-600 hover:text-primary-700 text-sm font-bold transition-colors">Baca Selengkapnya</button>
                    </div>
                </div>
            </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            <div class="col-span-full bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-12 text-center">
                <div class="w-16 h-16 bg-gray-50 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" /></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800 dark:text-white">Tidak ada pengumuman</h3>
                <p class="text-gray-500 dark:text-gray-400">Saat ini belum ada pengumuman yang diterbitkan.</p>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($pengumumans->hasPages()): ?>
        <div class="mt-6">
            <?php echo e($pengumumans->links()); ?>

        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php /**PATH C:\laragon\www\SISTEM-LAYANAN-AKADEMIK-SMK\resources\views/livewire/guru-role/pengumuman.blade.php ENDPATH**/ ?>