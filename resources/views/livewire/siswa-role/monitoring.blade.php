<div class="space-y-6">
    <div class="bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700">
        <h3 class="text-2xl font-black text-gray-800 dark:text-white mb-8 flex items-center gap-3">
            <div class="w-1.5 h-8 bg-primary-600 rounded-full"></div>
            Analisis Performa Akademik
        </h3>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Summary Stats -->
            <div class="space-y-6">
                <div class="p-6 bg-primary-50 dark:bg-primary-900/20 rounded-3xl border border-primary-100 dark:border-primary-800">
                    <h4 class="text-sm font-black text-primary-700 dark:text-primary-300 uppercase tracking-widest mb-4">Indeks Performa Kumulatif</h4>
                    <div class="flex items-end gap-3">
                        <span class="text-5xl font-black text-primary-800 dark:text-white">{{ number_format($avg_akhir, 1) }}</span>
                        <span class="text-sm font-bold text-primary-600 mb-2">/ 100.0</span>
                    </div>
                    <p class="text-xs text-primary-600 mt-4 leading-relaxed font-medium">Nilai rata-rata dari seluruh mata pelajaran yang telah ditempuh pada semester ini.</p>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div class="p-6 bg-gray-50 dark:bg-gray-900 rounded-3xl border border-gray-100 dark:border-gray-700">
                        <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-1">Mata Pelajaran</span>
                        <span class="text-2xl font-black text-gray-800 dark:text-white">{{ $total_mapel }}</span>
                    </div>
                    <div class="p-6 bg-gray-50 dark:bg-gray-900 rounded-3xl border border-gray-100 dark:border-gray-700">
                        <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-1">Predikat</span>
                        <span class="text-2xl font-black text-emerald-600">{{ $avg_akhir >= 85 ? 'Sangat Baik' : ($avg_akhir >= 75 ? 'Baik' : 'Cukup') }}</span>
                    </div>
                </div>
            </div>
            
            <!-- Chart Container -->
            <div class="bg-gray-50 dark:bg-gray-900 p-6 rounded-3xl border border-gray-100 dark:border-gray-700">
                <h4 class="text-sm font-black text-gray-800 dark:text-white uppercase tracking-widest mb-6 text-center">Distribusi Nilai</h4>
                <div class="h-64" x-data="{
                    init() {
                        new Chart(this.$refs.canvas, {
                            type: 'bar',
                            data: {
                                labels: @js($performance_data['labels']),
                                datasets: [
                                    {
                                        label: 'Tugas',
                                        data: @js($performance_data['tugas']),
                                        backgroundColor: '#818cf8',
                                        borderRadius: 8
                                    },
                                    {
                                        label: 'UTS',
                                        data: @js($performance_data['uts']),
                                        backgroundColor: '#fbbf24',
                                        borderRadius: 8
                                    },
                                    {
                                        label: 'UAS',
                                        data: @js($performance_data['uas']),
                                        backgroundColor: '#f87171',
                                        borderRadius: 8
                                    }
                                ]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: { position: 'bottom', labels: { usePointStyle: true, font: { weight: 'bold', size: 10 } } }
                                },
                                scales: {
                                    y: { beginAtZero: true, max: 100, grid: { display: false } },
                                    x: { grid: { display: false } }
                                }
                            }
                        });
                    }
                }">
                    <canvas x-ref="canvas"></canvas>
                </div>
            </div>
        </div>

        <!-- Progress List -->
        <div class="mt-12">
            <h4 class="text-sm font-black text-gray-800 dark:text-white uppercase tracking-widest mb-8">Detail Performa per Mata Pelajaran</h4>
            <div class="space-y-6">
                @foreach($performance_data['labels'] as $index => $label)
                <div class="space-y-2">
                    <div class="flex justify-between items-end">
                        <span class="text-sm font-bold text-gray-700 dark:text-gray-300">{{ $label }}</span>
                        <span class="text-xs font-black text-primary-600">{{ $performance_data['akhir'][$index] }}%</span>
                    </div>
                    <div class="w-full h-3 bg-gray-50 dark:bg-gray-900 rounded-full overflow-hidden border border-gray-100 dark:border-gray-800">
                        <div class="h-full bg-gradient-to-r from-primary-500 to-indigo-600 rounded-full transition-all duration-1000" style="width: {{ $performance_data['akhir'][$index] }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Chart.js Script -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('livewire:navigated', () => {
            if (typeof Chart !== 'undefined') {
                // Alpine.js will re-initialize the chart when the component is rendered
            }
        });
    </script>
</div>
