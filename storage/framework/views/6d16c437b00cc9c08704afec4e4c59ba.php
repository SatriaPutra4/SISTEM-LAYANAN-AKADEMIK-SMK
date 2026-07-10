<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Tagihan & Pembayaran SPP</h2>
            <p class="text-sm text-gray-500 mt-1">Kelola tagihan bulanan dan verifikasi pembayaran siswa</p>
        </div>
        <div class="flex gap-2">
            <button wire:click="export" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-xl text-sm font-bold transition-all shadow-sm flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                Export Excel
            </button>
            <button x-on:click="$dispatch('open-modal', 'modal-tagihan')" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-xl text-sm font-bold transition-all shadow-sm flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Buat Tagihan
            </button>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                </span>
                <input wire:model.live="search" type="text" placeholder="Cari nama siswa..." class="w-full pl-10 pr-4 py-2 rounded-xl border-gray-200 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-900 dark:border-gray-700 dark:text-white text-sm">
            </div>
            <select wire:model.live="filterStatus" class="rounded-xl border-gray-200 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-900 dark:border-gray-700 dark:text-white text-sm">
                <option value="">Semua Status</option>
                <option value="Belum Bayar">Belum Bayar</option>
                <option value="Menunggu Verifikasi">Menunggu Verifikasi</option>
                <option value="Lunas">Lunas</option>
            </select>
            <select wire:model.live="filterKelas" class="rounded-xl border-gray-200 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-900 dark:border-gray-700 dark:text-white text-sm">
                <option value="">Semua Kelas</option>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $kelases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <option value="<?php echo e($k->id); ?>"><?php echo e($k->nama_kelas); ?></option>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </select>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 dark:bg-gray-700/50">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Siswa</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Tahun Ajaran</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Nominal</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $tagihans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full bg-primary-100 text-primary-600 flex items-center justify-center font-bold mr-3">
                                    <?php echo e(substr($t->siswa->user->name, 0, 1)); ?>

                                </div>
                                <div>
                                    <div class="text-sm font-bold text-gray-800 dark:text-gray-200"><?php echo e($t->siswa->user->name); ?></div>
                                    <div class="text-xs text-gray-500">NIS: <?php echo e($t->siswa->nis); ?> | <?php echo e($t->siswa->kelas->nama_kelas); ?></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-800 dark:text-gray-200 font-medium"><?php echo e($t->tahun_ajaran); ?></div>
                        </td>
                        <td class="px-6 py-4 text-sm font-bold text-gray-800 dark:text-gray-200">
                            Rp <?php echo e(number_format($t->nominal, 0, ',', '.')); ?>

                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-1 text-xs font-bold rounded-full 
                                <?php echo e($t->status === 'Lunas' ? 'bg-green-100 text-green-700' : ($t->status === 'Menunggu Verifikasi' ? 'bg-amber-100 text-amber-700' : 'bg-red-100 text-red-700')); ?>">
                                <?php echo e($t->status); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <a href="<?php echo e(route('spp.detail', $t->id)); ?>" wire:navigate class="text-primary-600 hover:text-primary-700 font-bold text-sm">
                                Detail & Verifikasi
                            </a>
                        </td>
                    </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <svg class="w-12 h-12 text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                <p class="text-gray-500 font-medium">Tidak ada data tagihan ditemukan</p>
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="p-6 border-t border-gray-100 dark:border-gray-700">
            <?php echo e($tagihans->links()); ?>

        </div>
    </div>

    <!-- Modal Buat Tagihan -->
    <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['name' => 'modal-tagihan','title' => 'Buat Tagihan Baru']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'modal-tagihan','title' => 'Buat Tagihan Baru']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

        <form wire:submit.prevent="createTagihan" class="p-6 space-y-4">
            <div class="flex items-center mb-4">
                <input wire:model.live="isBatch" type="checkbox" id="isBatch" class="rounded text-primary-600 focus:ring-primary-500">
                <label for="isBatch" class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">Buat Massal untuk Semua Siswa</label>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$isBatch): ?>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Siswa</label>
                <select wire:model="siswa_id" class="w-full rounded-xl border-gray-200 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                    <option value="">Pilih Siswa</option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $siswas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <option value="<?php echo e($s->id); ?>"><?php echo e($s->user->name); ?> (<?php echo e($s->nis); ?>)</option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </select>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['siswa_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-500 mt-1"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tahun Ajaran</label>
                    <input wire:model="tahun_ajaran" type="text" placeholder="e.g. 2025/2026" class="w-full rounded-xl border-gray-200 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['tahun_ajaran'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-500 mt-1"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nominal (Rp)</label>
                <div x-data="{ 
                    formattedValue: '<?php echo e(number_format($nominal ?? 0, 0, ',', '.')); ?>',
                    format(val) {
                        let num = val.replace(/\D/g, '');
                        $wire.set('nominal', num);
                        this.formattedValue = new Intl.NumberFormat('id-ID').format(num);
                    }
                }">
                    <input type="text" 
                        x-model="formattedValue" 
                        @input="format($event.target.value)"
                        class="w-full rounded-xl border-gray-200 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-900 dark:border-gray-700 dark:text-white"
                        placeholder="Contoh: 100.000">
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['nominal'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-500 mt-1"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <div class="flex justify-end pt-4 space-x-3">
                <button type="button" x-on:click="$dispatch('close')" class="px-4 py-2 text-sm font-bold text-gray-500 hover:text-gray-700">Batal</button>
                <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-2 rounded-xl text-sm font-bold shadow-sm">Simpan Tagihan</button>
            </div>
        </form>
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

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedTagihan): ?>
        <div class="p-6 space-y-4">
            <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-xl border border-gray-100 dark:border-gray-700">
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-gray-500">Siswa:</span>
                        <div class="font-bold text-gray-800 dark:text-white"><?php echo e($selectedTagihan->siswa->user->name); ?></div>
                    </div>
                    <div>
                        <span class="text-gray-500">Tagihan:</span>
                        <div class="font-bold text-gray-800 dark:text-white"><?php echo e($selectedTagihan->bulan); ?> <?php echo e($selectedTagihan->tahun_ajaran); ?></div>
                    </div>
                    <div>
                        <span class="text-gray-500">Nominal:</span>
                        <div class="font-bold text-primary-600">Rp <?php echo e(number_format($selectedTagihan->nominal, 0, ',', '.')); ?></div>
                    </div>
                </div>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedTagihan->bukti_pembayaran): ?>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Bukti Pembayaran</label>
                <a href="<?php echo e(asset('storage/' . $selectedTagihan->bukti_pembayaran)); ?>" target="_blank" class="block rounded-xl overflow-hidden border border-gray-200">
                    <img src="<?php echo e(asset('storage/' . $selectedTagihan->bukti_pembayaran)); ?>" class="w-full h-auto max-h-64 object-cover">
                </a>
            </div>
            <?php else: ?>
            <div class="text-sm text-amber-600 bg-amber-50 p-3 rounded-xl border border-amber-100 italic">
                Siswa belum mengunggah bukti pembayaran.
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Catatan Admin (Opsional)</label>
                <textarea wire:model="keterangan_admin" class="w-full rounded-xl border-gray-200 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-900 dark:border-gray-700 dark:text-white" rows="3"></textarea>
            </div>

            <div class="flex justify-between pt-4">
                <button wire:click="verifikasi('tolak')" class="bg-red-50 text-red-600 px-6 py-2 rounded-xl text-sm font-bold hover:bg-red-100">Tolak</button>
                <button wire:click="verifikasi('setuju')" class="bg-emerald-600 hover:bg-emerald-700 text-white px-8 py-2 rounded-xl text-sm font-bold shadow-md">Setujui & Tandai Lunas</button>
            </div>
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
<?php /**PATH C:\laragon\www\SISTEM-LAYANAN-AKADEMIK-SMK\resources\views/livewire/spp/index.blade.php ENDPATH**/ ?>