<div class="space-y-6">
    <div class="bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-8">
            <div>
                <h3 class="text-2xl font-black text-gray-800 dark:text-white flex items-center gap-3">
                    <div class="w-1.5 h-8 bg-amber-500 rounded-full"></div>
                    Pengumuman Sekolah
                </h3>
                <p class="text-gray-500 mt-1">Dapatkan informasi terbaru seputar kegiatan sekolah.</p>
            </div>
            
            <div class="relative w-full md:w-72">
                <input type="text" wire:model.live="search" placeholder="Cari pengumuman..." class="w-full bg-gray-50 dark:bg-gray-900 border-none rounded-2xl focus:ring-2 focus:ring-amber-500 pl-12 font-medium">
                <svg class="w-5 h-5 text-gray-400 absolute left-4 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $pengumumans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <div class="group bg-gray-50 dark:bg-gray-900 rounded-3xl border border-gray-100 dark:border-gray-700 p-6 hover:shadow-2xl hover:shadow-amber-900/5 transition-all flex flex-col h-full">
                <div class="flex justify-between items-start mb-4">
                    <span class="px-3 py-1 bg-amber-100 text-amber-700 text-[10px] font-black rounded-lg uppercase tracking-widest">
                        Penting
                    </span>
                    <span class="text-[10px] font-bold text-gray-400 uppercase">
                        <?php echo e($p->created_at->format('d M Y')); ?>

                    </span>
                </div>
                
                <h4 class="text-lg font-black text-gray-800 dark:text-white mb-3 group-hover:text-amber-600 transition-colors">
                    <?php echo e($p->judul); ?>

                </h4>
                
                <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed line-clamp-4 mb-6 flex-grow">
                    <?php echo e($p->konten); ?>

                </p>
                
                <div class="flex items-center justify-between mt-auto pt-6 border-t border-gray-200/50 dark:border-gray-800">
                    <div class="flex items-center gap-2">
                        <div class="w-6 h-6 rounded-full bg-amber-100 flex items-center justify-center text-amber-600">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" /></svg>
                        </div>
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Administrator</span>
                    </div>
                    <button wire:click="showDetail(<?php echo e($p->id); ?>)" class="text-amber-600 text-[10px] font-black uppercase tracking-widest hover:underline">
                        Baca Selengkapnya
                    </button>
                </div>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            <div class="col-span-full py-20 flex flex-col items-center justify-center text-center">
                <div class="w-32 h-32 bg-gray-50 dark:bg-gray-900 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-16 h-16 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" /></svg>
                </div>
                <h4 class="text-xl font-black text-gray-400 uppercase tracking-widest">Tidak Ada Pengumuman</h4>
                <p class="text-gray-400 mt-2">Belum ada informasi baru yang dibagikan.</p>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <div class="mt-8">
            <?php echo e($pengumumans->links()); ?>

        </div>
    </div>

    <!-- Detail Modal -->
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($is_modal_open && $selected_pengumuman): ?>
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-gray-900/75 backdrop-blur-sm" wire:click="closeModal"></div>
            
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            
            <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                <div class="relative">
                    <div class="absolute top-4 right-4">
                        <button wire:click="closeModal" class="p-2 bg-gray-50 dark:bg-gray-900 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 rounded-xl transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>
                    
                    <div class="p-8 md:p-12">
                        <div class="flex items-center gap-3 mb-6">
                            <span class="px-3 py-1 bg-amber-100 text-amber-700 text-[10px] font-black rounded-lg uppercase tracking-widest">Penting</span>
                            <span class="text-[10px] font-bold text-gray-400 uppercase"><?php echo e($selected_pengumuman->created_at->format('d F Y')); ?></span>
                        </div>
                        
                        <h3 class="text-3xl font-black text-gray-800 dark:text-white mb-6 leading-tight">
                            <?php echo e($selected_pengumuman->judul); ?>

                        </h3>
                        
                        <div class="prose dark:prose-invert max-w-none">
                            <p class="text-gray-600 dark:text-gray-400 leading-relaxed text-lg whitespace-pre-wrap">
                                <?php echo e($selected_pengumuman->konten); ?>

                            </p>
                        </div>
                        
                        <div class="mt-12 pt-8 border-t border-gray-100 dark:border-gray-800 flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-primary-50 dark:bg-primary-900/20 flex items-center justify-center text-primary-600">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" /></svg>
                                </div>
                                <div>
                                    <p class="text-xs font-black text-gray-800 dark:text-white uppercase tracking-widest">Administrator</p>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase mt-0.5 tracking-tighter">SMK Tri Bhakti</p>
                                </div>
                            </div>
                            
                            <button wire:click="closeModal" class="px-8 py-3 bg-gray-900 dark:bg-white text-white dark:text-gray-900 text-sm font-black rounded-2xl hover:opacity-90 transition-opacity">
                                Tutup
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php /**PATH C:\laragon\www\SISTEM-LAYANAN-AKADEMIK-SMK\resources\views/livewire/siswa-role/pengumuman.blade.php ENDPATH**/ ?>