<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Monitoring Akademik</h1>
            <p class="text-gray-600 dark:text-gray-400">Analisis perkembangan nilai dan performa siswa.</p>
        </div>
        <div class="w-full md:w-64">
            <select wire:model.live="filterKelas" class="block w-full pl-3 pr-10 py-2 text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-primary-500 focus:border-primary-500">
                <option value="">Semua Kelas</option>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $kelases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kelas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <option value="<?php echo e($kelas->id); ?>"><?php echo e($kelas->nama_kelas); ?></option>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </select>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Rata-rata Nilai Kelas</p>
            <p class="text-3xl font-bold text-primary-600 mt-1"><?php echo e(number_format($avgNilai, 2)); ?></p>
            <div class="mt-4 flex items-center text-xs text-gray-400">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                Berdasarkan data nilai yang masuk
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 border-l-4 border-l-emerald-500">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Siswa Tuntas (>=75)</p>
            <p class="text-3xl font-bold text-emerald-600 mt-1"><?php echo e($tuntasCount); ?></p>
            <div class="mt-4 h-2 bg-gray-100 dark:bg-gray-700 rounded-full overflow-hidden">
                <div class="h-full bg-emerald-500" style="width: <?php echo e(($tuntasCount + $remedialCount) > 0 ? ($tuntasCount / ($tuntasCount + $remedialCount) * 100) : 0); ?>%"></div>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 border-l-4 border-l-red-500">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Siswa Remedial (<75)</p>
            <p class="text-3xl font-bold text-red-600 mt-1"><?php echo e($remedialCount); ?></p>
            <div class="mt-4 h-2 bg-gray-100 dark:bg-gray-700 rounded-full overflow-hidden">
                <div class="h-full bg-red-500" style="width: <?php echo e(($tuntasCount + $remedialCount) > 0 ? ($remedialCount / ($tuntasCount + $remedialCount) * 100) : 0); ?>%"></div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Chart -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
            <h3 class="font-bold text-gray-800 dark:text-white mb-6">Performa Nilai per Mata Pelajaran</h3>
            <div class="h-80">
                <canvas id="monitoringChart"></canvas>
            </div>
        </div>

        <!-- Alert Siswa Nilai Rendah -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
                <h3 class="font-bold text-gray-800 dark:text-white">Peringatan Nilai Rendah</h3>
                <span class="px-2 py-1 bg-red-100 text-red-800 text-[10px] font-bold rounded uppercase">Perlu Perhatian</span>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $siswaBermasalah; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nilai): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <div class="flex items-center justify-between p-3 bg-red-50/50 dark:bg-red-900/10 rounded-xl border border-red-100 dark:border-red-900/30">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-red-100 dark:bg-red-900/40 flex items-center justify-center text-red-600 font-bold text-xs">
                                    <?php echo e(substr($nilai->siswa->user->name, 0, 1)); ?>

                                </div>
                                <div>
                                    <p class="text-sm font-bold text-gray-800 dark:text-white"><?php echo e($nilai->siswa->user->name); ?></p>
                                    <p class="text-[10px] text-gray-500 uppercase"><?php echo e($nilai->siswa->kelas->nama_kelas); ?> | <?php echo e($nilai->mataPelajaran->nama_mapel); ?></p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-black text-red-600"><?php echo e(number_format($nilai->nilai_akhir, 2)); ?></p>
                            </div>
                        </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <div class="text-center py-8">
                            <div class="w-16 h-16 bg-emerald-50 dark:bg-emerald-900/20 rounded-full flex items-center justify-center text-emerald-500 mx-auto mb-4">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                            </div>
                            <p class="text-sm text-gray-500">Semua siswa mencapai target nilai.</p>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('livewire:navigated', () => {
            const ctx = document.getElementById('monitoringChart');
            if (ctx) {
                new Chart(ctx, {
                    type: 'radar',
                    data: {
                        labels: <?php echo json_encode($chartData->keys(), 15, 512) ?>,
                        datasets: [{
                            label: 'Rata-rata Nilai',
                            data: <?php echo json_encode($chartData->values(), 15, 512) ?>,
                            backgroundColor: 'rgba(59, 130, 246, 0.2)',
                            borderColor: 'rgb(59, 130, 246)',
                            pointBackgroundColor: 'rgb(59, 130, 246)',
                            pointBorderColor: '#fff',
                            pointHoverBackgroundColor: '#fff',
                            pointHoverBorderColor: 'rgb(59, 130, 246)'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            r: {
                                angleLines: {
                                    display: false
                                },
                                suggestedMin: 0,
                                suggestedMax: 100
                            }
                        }
                    }
                });
            }
        });
    </script>
    <?php $__env->stopPush(); ?>
</div>
<?php /**PATH C:\laragon\www\SISTEM-LAYANAN-AKADEMIK-SMK\resources\views/livewire/guru-role/monitoring.blade.php ENDPATH**/ ?>