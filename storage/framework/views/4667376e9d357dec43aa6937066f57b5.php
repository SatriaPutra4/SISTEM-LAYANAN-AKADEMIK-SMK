<?php

use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Jurusan;
use App\Models\Pengumuman;
use App\Models\SuratPengajuan;
use App\Models\TagihanSpp;
use App\Models\ActivityLog;
use Livewire\Volt\Component;

?>

<div class="space-y-6" x-data="{ 
    initChart() {
        const ctx = document.getElementById('paymentChart');
        if (!ctx) return;
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [{
                    label: 'Pembayaran SPP',
                    data: [12, 19, 3, 5, 2, 3, 15, 22, 10, 8, 12, 18],
                    borderColor: '#4f46e5',
                    backgroundColor: 'rgba(79, 70, 229, 0.1)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true },
                    x: { grid: { display: false } }
                }
            }
        });
    }
}" x-init="initChart()">
    <!-- Breadcrumb -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Dashboard Admin</h2>
            <p class="text-sm text-gray-500 mt-1">Selamat datang kembali, <?php echo e(auth()->user()->name); ?></p>
        </div>
        <div class="flex items-center space-x-3">
            <div class="bg-white dark:bg-gray-800 px-4 py-2 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center">
                <span class="w-3 h-3 bg-green-500 rounded-full mr-2"></span>
                <span class="text-sm font-medium text-gray-600 dark:text-gray-300">Sistem Online</span>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Siswa -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Siswa</p>
                    <h3 class="text-3xl font-bold text-gray-800 dark:text-white mt-1"><?php echo e($totalSiswa); ?></h3>
                </div>
                <div class="p-3 bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 rounded-xl">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center justify-between text-sm">
                <span class="text-emerald-600 font-medium">Aktif</span>
                <span class="text-gray-400">Terdaftar di <?php echo e($totalKelas); ?> Kelas</span>
            </div>
        </div>

        <!-- Total Guru -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Guru</p>
                    <h3 class="text-3xl font-bold text-gray-800 dark:text-white mt-1"><?php echo e($totalGuru); ?></h3>
                </div>
                <div class="p-3 bg-blue-50 dark:bg-blue-900/20 text-blue-600 rounded-xl">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center justify-between text-sm">
                <span class="text-blue-600 font-medium">Tenaga Pengajar</span>
                <span class="text-gray-400"><?php echo e($totalJurusan); ?> Jurusan</span>
            </div>
        </div>

        <!-- Pengajuan Surat -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Antrian Surat</p>
                    <h3 class="text-3xl font-bold text-gray-800 dark:text-white mt-1"><?php echo e($totalSurat); ?></h3>
                </div>
                <div class="p-3 bg-amber-50 dark:bg-amber-900/20 text-amber-600 rounded-xl">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center justify-between text-sm">
                <span class="text-amber-600 font-medium">Perlu Verifikasi</span>
                <a href="<?php echo e(route('surat.index')); ?>" class="text-primary-600 hover:underline">Lihat Detail</a>
            </div>
        </div>

        <!-- SPP Pending -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Konfirmasi SPP</p>
                    <h3 class="text-3xl font-bold text-gray-800 dark:text-white mt-1"><?php echo e($totalSppPending); ?></h3>
                </div>
                <div class="p-3 bg-purple-50 dark:bg-purple-900/20 text-purple-600 rounded-xl">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center justify-between text-sm">
                <span class="text-purple-600 font-medium">Verifikasi Bayar</span>
                <span class="text-gray-400">Bulan Ini</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Charts / Tables -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Analytics -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white">Statistik Pembayaran SPP</h3>
                    <select class="text-sm border-gray-200 rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option>Tahun 2026</option>
                        <option>Tahun 2025</option>
                    </select>
                </div>
                <div class="h-80 relative">
                    <canvas id="paymentChart"></canvas>
                </div>
            </div>

            <!-- Recent Data Table -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white">Pengumuman Terbaru</h3>
                    <a href="<?php echo e(route('pengumuman.index')); ?>" class="text-primary-600 hover:text-primary-700 text-sm font-semibold">Lihat Semua</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-50 dark:bg-gray-700/50">
                            <tr>
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Judul</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Target</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $pengumumans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                                <td class="px-6 py-4">
                                    <span class="text-sm font-medium text-gray-800 dark:text-gray-200"><?php echo e($p->judul); ?></span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-0.5 text-xs font-semibold rounded-full bg-blue-100 text-blue-700 capitalize"><?php echo e($p->target_role); ?></span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-0.5 text-xs font-semibold rounded-full <?php echo e($p->status_publish === 'Published' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700'); ?>">
                                        <?php echo e($p->status_publish); ?>

                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    <?php echo e($p->created_at->format('d M Y')); ?>

                                </td>
                            </tr>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-gray-500">Tidak ada pengumuman</td>
                            </tr>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Sidebar Widgets -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Layanan Cepat</h3>
                <div class="grid grid-cols-2 gap-3">
                    <a href="<?php echo e(route('siswa.index')); ?>" class="flex flex-col items-center justify-center p-4 rounded-xl bg-gray-50 dark:bg-gray-900 hover:bg-primary-50 dark:hover:bg-primary-900/20 group transition-all">
                        <div class="p-2 bg-white dark:bg-gray-800 rounded-lg shadow-sm mb-2 group-hover:text-primary-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>
                        </div>
                        <span class="text-xs font-bold text-gray-600 dark:text-gray-400 group-hover:text-primary-700 text-center">Siswa Baru</span>
                    </a>
                    <a href="<?php echo e(route('guru.index')); ?>" class="flex flex-col items-center justify-center p-4 rounded-xl bg-gray-50 dark:bg-gray-900 hover:bg-primary-50 dark:hover:bg-primary-900/20 group transition-all">
                        <div class="p-2 bg-white dark:bg-gray-800 rounded-lg shadow-sm mb-2 group-hover:text-primary-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                        </div>
                        <span class="text-xs font-bold text-gray-600 dark:text-gray-400 group-hover:text-primary-700 text-center">Tambah Guru</span>
                    </a>
                    <a href="<?php echo e(route('pengumuman.index')); ?>" class="flex flex-col items-center justify-center p-4 rounded-xl bg-gray-50 dark:bg-gray-900 hover:bg-primary-50 dark:hover:bg-primary-900/20 group transition-all">
                        <div class="p-2 bg-white dark:bg-gray-800 rounded-lg shadow-sm mb-2 group-hover:text-primary-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                        </div>
                        <span class="text-xs font-bold text-gray-600 dark:text-gray-400 group-hover:text-primary-700 text-center">Pengumuman</span>
                    </a>
                    <a href="<?php echo e(route('spp.index')); ?>" class="flex flex-col items-center justify-center p-4 rounded-xl bg-gray-50 dark:bg-gray-900 hover:bg-primary-50 dark:hover:bg-primary-900/20 group transition-all">
                        <div class="p-2 bg-white dark:bg-gray-800 rounded-lg shadow-sm mb-2 group-hover:text-primary-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        </div>
                        <span class="text-xs font-bold text-gray-600 dark:text-gray-400 group-hover:text-primary-700 text-center">Laporan SPP</span>
                    </a>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Aktivitas Terbaru</h3>
                <div class="space-y-4">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $activities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <div class="flex items-start space-x-3">
                        <div class="mt-1 w-2 h-2 rounded-full 
                            <?php echo e($activity->type === 'success' ? 'bg-emerald-500' : 
                               ($activity->type === 'danger' ? 'bg-red-500' : 
                               ($activity->type === 'warning' ? 'bg-amber-500' : 'bg-primary-600'))); ?>">
                        </div>
                        <div>
                            <p class="text-sm text-gray-800 dark:text-gray-200">
                                <span class="font-bold"><?php echo e($activity->user->name); ?></span> <?php echo e($activity->description); ?>

                            </p>
                            <span class="text-xs text-gray-400"><?php echo e($activity->created_at->diffForHumans()); ?></span>
                        </div>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <div class="text-center py-4">
                        <p class="text-sm text-gray-400 italic">Belum ada aktivitas</p>
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script><?php /**PATH C:\laragon\www\SISTEM-LAYANAN-AKADEMIK-SMK\resources\views\livewire/dashboard/admin.blade.php ENDPATH**/ ?>