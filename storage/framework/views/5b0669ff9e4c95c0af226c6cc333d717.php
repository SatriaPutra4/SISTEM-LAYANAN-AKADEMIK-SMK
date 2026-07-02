<div class="space-y-6">
    <div class="flex items-center space-x-3 mb-6">
        <a href="<?php echo e(route('spp.index')); ?>" wire:navigate class="p-2 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
            <svg class="w-5 h-5 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
        </a>
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Detail Pembayaran SPP</h2>
            <p class="text-sm text-gray-500 mt-1">Verifikasi cicilan/pembayaran siswa</p>
        </div>
    </div>

    <!-- Tagihan Info -->
    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div>
                <span class="text-gray-500 dark:text-gray-400 text-sm">Siswa:</span>
                <div class="font-bold text-gray-800 dark:text-white mt-1"><?php echo e($tagihan->siswa->user->name); ?></div>
                <div class="text-xs text-gray-500">NIS: <?php echo e($tagihan->siswa->nis); ?> | <?php echo e($tagihan->siswa->kelas->nama_kelas); ?></div>
            </div>
            <div>
                <span class="text-gray-500 dark:text-gray-400 text-sm">Tahun Ajaran:</span>
                <div class="font-bold text-gray-800 dark:text-white mt-1"><?php echo e($tagihan->tahun_ajaran); ?></div>
            </div>
            <div>
                <span class="text-gray-500 dark:text-gray-400 text-sm">Total Tagihan:</span>
                <div class="font-bold text-primary-600 mt-1">Rp <?php echo e(number_format($tagihan->nominal, 0, ',', '.')); ?></div>
            </div>
            <div>
                <span class="text-gray-500 dark:text-gray-400 text-sm">Status Tagihan:</span>
                <div class="mt-1">
                    <span class="px-2.5 py-1 text-xs font-bold rounded-full 
                        <?php echo e($tagihan->status === 'Lunas' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'); ?>">
                        <?php echo e($tagihan->status); ?>

                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Riwayat Pembayaran -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
            <h3 class="text-lg font-bold text-gray-800 dark:text-white">Riwayat Cicilan & Pembayaran</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 dark:bg-gray-700/50">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Tanggal</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Nominal</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Catatan</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $pembayarans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-800 dark:text-gray-200">
                                <?php echo e($p->tanggal_bayar->translatedFormat('d M Y, H:i')); ?>

                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm font-bold text-gray-800 dark:text-gray-200">
                            Rp <?php echo e(number_format($p->nominal_bayar, 0, ',', '.')); ?>

                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-1 text-xs font-bold rounded-full 
                                <?php echo e($p->status === 'Disetujui' ? 'bg-green-100 text-green-700' : ($p->status === 'Menunggu Verifikasi' ? 'bg-amber-100 text-amber-700' : 'bg-red-100 text-red-700')); ?>">
                                <?php echo e($p->status); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2" title="<?php echo e($p->catatan); ?>">
                                <?php echo e($p->catatan ?? '-'); ?>

                            </div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button wire:click="showVerifikasi(<?php echo e($p->id); ?>)" class="text-primary-600 hover:text-primary-700 font-bold text-sm">
                                <?php echo e($p->status === 'Menunggu Verifikasi' ? 'Verifikasi' : 'Lihat Bukti'); ?>

                            </button>
                        </td>
                    </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <svg class="w-12 h-12 text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z" /></svg>
                                <p class="text-gray-500 font-medium">Belum ada riwayat pembayaran untuk tagihan ini.</p>
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="p-6 border-t border-gray-100 dark:border-gray-700">
            <?php echo e($pembayarans->links()); ?>

        </div>
    </div>

    <!-- Modal Verifikasi -->
    <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['name' => 'modal-verifikasi','title' => 'Verifikasi Pembayaran']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'modal-verifikasi','title' => 'Verifikasi Pembayaran']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedPembayaran): ?>
        <div class="p-6 space-y-4">
            <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-xl border border-gray-100 dark:border-gray-700">
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-gray-500">Nominal Transfer:</span>
                        <div class="font-bold text-primary-600 text-lg">Rp <?php echo e(number_format($selectedPembayaran->nominal_bayar, 0, ',', '.')); ?></div>
                    </div>
                    <div>
                        <span class="text-gray-500">Tanggal Transfer:</span>
                        <div class="font-bold text-gray-800 dark:text-white"><?php echo e($selectedPembayaran->tanggal_bayar->translatedFormat('d M Y, H:i')); ?></div>
                    </div>
                </div>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedPembayaran->bukti_pembayaran): ?>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Bukti Pembayaran</label>
                <a href="<?php echo e(asset('storage/' . $selectedPembayaran->bukti_pembayaran)); ?>" target="_blank" class="block rounded-xl overflow-hidden border border-gray-200">
                    <img src="<?php echo e(asset('storage/' . $selectedPembayaran->bukti_pembayaran)); ?>" class="w-full h-auto max-h-64 object-cover">
                </a>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Catatan Admin (Opsional)</label>
                <textarea wire:model="keterangan_admin" class="w-full rounded-xl border-gray-200 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-900 dark:border-gray-700 dark:text-white" rows="3"></textarea>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedPembayaran->status === 'Menunggu Verifikasi'): ?>
            <div class="flex justify-between pt-4">
                <button wire:click="verifikasi('tolak')" class="bg-red-50 text-red-600 px-6 py-2 rounded-xl text-sm font-bold hover:bg-red-100">Tolak</button>
                <button wire:click="verifikasi('setuju')" class="bg-emerald-600 hover:bg-emerald-700 text-white px-8 py-2 rounded-xl text-sm font-bold shadow-md">Setujui Pembayaran</button>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9f64f32e90b9102968f2bc548315018c)): ?>
<?php $attributes = $__attributesOriginal9f64f32e90b9102968f2bc548315018c; ?>
<?php unset($__attributesOriginal9f64f32e90b9102968f2bc548315018c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9f64f32e90b9102968f2bc548315018c)): ?>
<?php $component = $__componentOriginal9f64f32e90b9102968f2bc548315018c; ?>
<?php unset($__componentOriginal9f64f32e90b9102968f2bc548315018c); ?>
<?php endif; ?>
</div>
<?php /**PATH C:\laragon\www\SISTEM-LAYANAN-AKADEMIK-SMK\resources\views/livewire/spp/detail-tagihan.blade.php ENDPATH**/ ?>