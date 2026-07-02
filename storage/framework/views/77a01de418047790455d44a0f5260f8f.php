<div class="space-y-6">
    <div class="bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-8">
            <div>
                <h3 class="text-2xl font-black text-gray-800 dark:text-white flex items-center gap-3">
                    <div class="w-1.5 h-8 bg-primary-600 rounded-full"></div>
                    Jadwal Pelajaran
                </h3>
                <p class="text-gray-500 mt-1">Lihat jadwal pelajaran harianmu di sini.</p>
            </div>
            
            <div class="flex bg-gray-50 dark:bg-gray-900 p-1 rounded-2xl border border-gray-100 dark:border-gray-700 overflow-x-auto max-w-full">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $daftar_hari; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hari): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <button 
                    wire:click="setHari('<?php echo e($hari); ?>')"
                    class="px-6 py-2.5 rounded-xl text-sm font-bold transition-all whitespace-nowrap <?php echo e($hari_dipilih === $hari ? 'bg-white dark:bg-gray-800 text-primary-600 shadow-sm' : 'text-gray-400 hover:text-gray-600'); ?>"
                >
                    <?php echo e($hari); ?>

                </button>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        </div>

        <div class="relative">
            <div wire:loading wire:target="setHari" class="absolute inset-0 bg-white/50 dark:bg-gray-800/50 backdrop-blur-sm z-10 rounded-2xl flex items-center justify-center">
                <div class="w-10 h-10 border-4 border-primary-600 border-t-transparent rounded-full animate-spin"></div>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($jadwals->count() > 0): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $jadwals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $j): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <div class="group p-6 bg-gray-50 dark:bg-gray-900 rounded-3xl border border-gray-100 dark:border-gray-700 hover:border-primary-200 hover:shadow-xl hover:shadow-primary-900/5 transition-all">
                    <div class="flex justify-between items-start mb-6">
                        <div class="flex flex-col">
                            <span class="text-[10px] font-black text-primary-600 uppercase tracking-widest bg-primary-50 dark:bg-primary-900/20 px-3 py-1 rounded-lg self-start mb-2">
                                Waktu
                            </span>
                            <span class="text-lg font-black text-gray-800 dark:text-white">
                                <?php echo e(\Carbon\Carbon::parse($j->jam_mulai)->format('H:i')); ?> - <?php echo e(\Carbon\Carbon::parse($j->jam_selesai)->format('H:i')); ?>

                            </span>
                        </div>
                        <div class="w-12 h-12 bg-white dark:bg-gray-800 rounded-2xl shadow-sm flex items-center justify-center text-primary-600 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                        </div>
                    </div>
                    
                    <h4 class="text-xl font-black text-gray-800 dark:text-white mb-2 leading-tight group-hover:text-primary-600 transition-colors">
                        <?php echo e($j->mataPelajaran->nama_mapel); ?>

                    </h4>
                    
                    <div class="flex items-center gap-3 mt-6 pt-6 border-t border-gray-100 dark:border-gray-800">
                        <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 overflow-hidden">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($j->guru->user->siswa?->foto_profil): ?>
                                <img src="<?php echo e(Storage::url($j->guru->user->siswa->foto_profil)); ?>" class="w-full h-full object-cover">
                            <?php else: ?>
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" /></svg>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Guru Pengampu</p>
                            <p class="text-sm font-bold text-gray-700 dark:text-gray-300"><?php echo e($j->guru->user->name); ?></p>
                        </div>
                    </div>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
            <?php else: ?>
            <div class="py-20 flex flex-col items-center justify-center text-center">
                <div class="w-32 h-32 bg-gray-50 dark:bg-gray-900 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-16 h-16 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                </div>
                <h4 class="text-xl font-black text-gray-400 uppercase tracking-widest">Tidak Ada Jadwal</h4>
                <p class="text-gray-400 mt-2">Sepertinya hari ini kamu tidak memiliki jam pelajaran.</p>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
</div>
<?php /**PATH C:\laragon\www\SISTEM-LAYANAN-AKADEMIK-SMK\resources\views/livewire/siswa-role/jadwal.blade.php ENDPATH**/ ?>