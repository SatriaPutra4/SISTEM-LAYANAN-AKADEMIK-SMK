<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Data Alumni</h2>
            <p class="text-sm text-gray-500 mt-1">Daftar siswa yang telah menyelesaikan masa studi</p>
        </div>
    </div>

    <!-- Search & Filter -->
    <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 flex gap-4">
        <div class="relative flex-1">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </span>
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari nama atau NIS alumni..." class="block w-full pl-10 pr-3 py-2.5 bg-gray-50 dark:bg-gray-900 border-none rounded-xl focus:ring-2 focus:ring-primary-500 text-sm">
        </div>
        <div class="w-48">
            <select wire:model.live="tahun_lulus" class="block w-full py-2.5 bg-gray-50 dark:bg-gray-900 border-none rounded-xl focus:ring-2 focus:ring-primary-500 text-sm">
                <option value="">Semua Tahun</option>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $tahunList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tahun): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <option value="<?php echo e($tahun); ?>"><?php echo e($tahun); ?></option>
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
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Nama / NIS</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Kelas Terakhir</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Tahun Lulus</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Kontak</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $alumnis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <img class="w-10 h-10 rounded-xl mr-3" src="https://ui-avatars.com/api/?name=<?php echo e(urlencode($s->user->name)); ?>&color=6366f1&background=e0e7ff" alt="">
                                <div>
                                    <div class="text-sm font-bold text-gray-800 dark:text-gray-200"><?php echo e($s->user->name); ?></div>
                                    <div class="text-xs text-gray-400 font-medium"><?php echo e($s->nis); ?></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-700 dark:text-gray-300"><?php echo e($s->kelas->nama_kelas); ?></div>
                            <div class="text-xs text-primary-600 font-bold uppercase"><?php echo e($s->jurusan->nama_jurusan); ?></div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500 font-medium">
                            <?php echo e($s->tahun_lulus ?? '-'); ?>

                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            <?php echo e($s->no_hp ?? '-'); ?>

                        </td>
                        <td class="px-6 py-4 text-center">
                            <button wire:click="show(<?php echo e($s->id); ?>)" class="p-2 text-gray-400 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-400 italic">Belum ada data alumni.</td>
                    </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700">
            <?php echo e($alumnis->links()); ?>

        </div>
    </div>

                <!-- Alumni Profile Modal -->
                <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['name' => 'modal-view-alumni','focusable' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'modal-view-alumni','focusable' => true]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedSiswa): ?>
                <div class="p-6">
                <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100 border-b pb-4 mb-4">Profil Alumni</h2>
                <div class="space-y-4">
                <div class="flex items-center space-x-4">
                    <img class="w-20 h-20 rounded-xl" src="https://ui-avatars.com/api/?name=<?php echo e(urlencode($selectedSiswa->user->name)); ?>&color=6366f1&background=e0e7ff" alt="">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900"><?php echo e($selectedSiswa->user->name); ?></h3>
                        <p class="text-gray-500"><?php echo e($selectedSiswa->nis); ?></p>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-gray-400 uppercase">Email</p>
                        <p class="text-sm font-medium"><?php echo e($selectedSiswa->user->email); ?></p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase">Jenis Kelamin</p>
                        <p class="text-sm font-medium"><?php echo e($selectedSiswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan'); ?></p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase">Kelas Terakhir</p>
                        <p class="text-sm font-medium"><?php echo e($selectedSiswa->kelas->nama_kelas); ?></p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase">Jurusan</p>
                        <p class="text-sm font-medium"><?php echo e($selectedSiswa->jurusan->nama_jurusan); ?></p>
                    </div>
                </div>
                </div>
                <div class="mt-6 flex justify-end">
                <?php if (isset($component)) { $__componentOriginal3b0e04e43cf890250cc4d85cff4d94af = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3b0e04e43cf890250cc4d85cff4d94af = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.secondary-button','data' => ['xOn:click' => '$dispatch(\'close\')']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('secondary-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['x-on:click' => '$dispatch(\'close\')']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>
Tutup <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3b0e04e43cf890250cc4d85cff4d94af)): ?>
<?php $attributes = $__attributesOriginal3b0e04e43cf890250cc4d85cff4d94af; ?>
<?php unset($__attributesOriginal3b0e04e43cf890250cc4d85cff4d94af); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3b0e04e43cf890250cc4d85cff4d94af)): ?>
<?php $component = $__componentOriginal3b0e04e43cf890250cc4d85cff4d94af; ?>
<?php unset($__componentOriginal3b0e04e43cf890250cc4d85cff4d94af); ?>
<?php endif; ?>
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
<?php /**PATH C:\laragon\www\SISTEM-LAYANAN-AKADEMIK-SMK\resources\views/livewire/alumni/index.blade.php ENDPATH**/ ?>