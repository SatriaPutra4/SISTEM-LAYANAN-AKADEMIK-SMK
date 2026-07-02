<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Layanan Pengajuan Surat</h2>
            <p class="text-sm text-gray-500 mt-1">Verifikasi dan kelola pengajuan surat dari siswa</p>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                </span>
                <input wire:model.live="search" type="text" placeholder="Cari nama siswa..." class="w-full pl-10 pr-4 py-2 rounded-xl border-gray-200 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-900 dark:border-gray-700 dark:text-white text-sm">
            </div>
            <select wire:model.live="filterStatus" class="rounded-xl border-gray-200 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-900 dark:border-gray-700 dark:text-white text-sm">
                <option value="">Semua Status</option>
                <option value="Diproses">Diproses</option>
                <option value="Disetujui">Disetujui</option>
                <option value="Ditolak">Ditolak</option>
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
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Jenis Surat</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Tanggal</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $surats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold mr-3">
                                    <?php echo e(substr($s->siswa->user->name, 0, 1)); ?>

                                </div>
                                <div>
                                    <div class="text-sm font-bold text-gray-800 dark:text-gray-200"><?php echo e($s->siswa->user->name); ?></div>
                                    <div class="text-xs text-gray-500">NIS: <?php echo e($s->siswa->nis); ?></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-800 dark:text-gray-200">
                            <?php echo e($s->jenis_surat); ?>

                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            <?php echo e($s->created_at->format('d M Y')); ?>

                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-1 text-xs font-bold rounded-full 
                                <?php echo e($s->status === 'Disetujui' ? 'bg-green-100 text-green-700' : ($s->status === 'Diproses' ? 'bg-amber-100 text-amber-700' : 'bg-red-100 text-red-700')); ?>">
                                <?php echo e($s->status); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <button wire:click="showVerifikasi(<?php echo e($s->id); ?>)" class="text-primary-600 hover:text-primary-700 font-bold text-sm flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                Detail
                            </button>
                        </td>
                    </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">Tidak ada pengajuan surat</td>
                    </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="p-6 border-t border-gray-100 dark:border-gray-700">
            <?php echo e($surats->links()); ?>

        </div>
    </div>

    <!-- Modal Verifikasi -->
    <?php if (isset($component)) { $__componentOriginal9f64f32e90b9102968f2bc548315018c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f64f32e90b9102968f2bc548315018c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal','data' => ['name' => 'modal-verifikasi-surat','title' => 'Detail & Verifikasi Surat']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'modal-verifikasi-surat','title' => 'Detail & Verifikasi Surat']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedSurat): ?>
        <div class="p-6 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h4 class="text-xs font-bold text-gray-400 uppercase mb-2">Informasi Siswa</h4>
                    <div class="space-y-1">
                        <p class="text-sm font-bold text-gray-800 dark:text-white"><?php echo e($selectedSurat->siswa->user->name); ?></p>
                        <p class="text-xs text-gray-500">NIS: <?php echo e($selectedSurat->siswa->nis); ?></p>
                        <p class="text-xs text-gray-500"><?php echo e($selectedSurat->siswa->kelas->nama_kelas); ?> - <?php echo e($selectedSurat->siswa->jurusan->nama_jurusan); ?></p>
                    </div>
                </div>
                <div>
                    <h4 class="text-xs font-bold text-gray-400 uppercase mb-2">Detail Pengajuan</h4>
                    <div class="space-y-1">
                        <p class="text-sm font-bold text-gray-800 dark:text-white"><?php echo e($selectedSurat->jenis_surat); ?></p>
                        <p class="text-xs text-gray-500">Diajukan: <?php echo e($selectedSurat->created_at->format('d M Y, H:i')); ?></p>
                    </div>
                </div>
            </div>

            <div>
                <h4 class="text-xs font-bold text-gray-400 uppercase mb-2">Keperluan</h4>
                <div class="p-4 bg-gray-50 dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-700 text-sm text-gray-700 dark:text-gray-300">
                    <?php echo e($selectedSurat->keperluan); ?>

                </div>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedSurat->dokumen_pendukung): ?>
            <div>
                <h4 class="text-xs font-bold text-gray-400 uppercase mb-2">Dokumen Pendukung</h4>
                <a href="<?php echo e(asset('storage/' . $selectedSurat->dokumen_pendukung)); ?>" target="_blank" class="inline-flex items-center text-primary-600 hover:underline text-sm font-medium">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    Lihat Dokumen
                </a>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Catatan Admin</label>
                <textarea wire:model="keterangan_admin" rows="3" class="w-full rounded-xl border-gray-200 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-900 dark:border-gray-700 dark:text-white text-sm" placeholder="Tambahkan catatan jika diperlukan..."></textarea>
            </div>

            <!-- Upload File -->
            <div x-data="{ showUpload: false }">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Upload PDF Hasil Surat</label>
                <input type="file" wire:model="file_surat" accept="application/pdf" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedSurat->file_url): ?>
                    <p class="mt-2 text-xs text-green-600 font-bold">File saat ini: Tersedia</p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <div class="flex justify-between pt-4 gap-4">
                <button wire:click="updateStatus('Ditolak')" class="flex-1 bg-red-50 text-red-600 px-6 py-3 rounded-xl text-sm font-bold hover:bg-red-100 transition-colors">Tolak Pengajuan</button>
                <button wire:click="updateStatus('Disetujui')" class="flex-1 bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-xl text-sm font-bold shadow-md transition-all">Setujui Pengajuan</button>
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
<?php /**PATH C:\laragon\www\SISTEM-LAYANAN-AKADEMIK-SMK\resources\views/livewire/surat/admin.blade.php ENDPATH**/ ?>