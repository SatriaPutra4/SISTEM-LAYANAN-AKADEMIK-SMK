<div class="space-y-6">
    <!-- Stats Row -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">IP Semester</p>
            <h4 class="text-3xl font-black text-primary-600">{{ number_format($stats['rata_rata'], 1) }}</h4>
        </div>
        <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Nilai Tertinggi</p>
            <h4 class="text-3xl font-black text-emerald-600">{{ $stats['tertinggi'] }}</h4>
        </div>
        <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Nilai Terendah</p>
            <h4 class="text-3xl font-black text-rose-600">{{ $stats['terendah'] }}</h4>
        </div>
        <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Total Matpel</p>
            <h4 class="text-3xl font-black text-indigo-600">{{ $stats['total_mapel'] }}</h4>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <!-- Nilai Table -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="p-8 border-b border-gray-50 dark:border-gray-700 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <h3 class="text-xl font-black text-gray-800 dark:text-white flex items-center gap-3">
                        <div class="w-1.5 h-6 bg-primary-600 rounded-full"></div>
                        Rincian Nilai Akademik
                    </h3>
                    <div class="flex gap-3">
                        <select wire:model.live="semester" class="bg-gray-50 dark:bg-gray-900 border-none text-xs font-bold rounded-xl focus:ring-primary-500">
                            <option value="Ganjil">Semester Ganjil</option>
                            <option value="Genap">Semester Genap</option>
                        </select>
                        <select wire:model.live="tahun_ajaran" class="bg-gray-50 dark:bg-gray-900 border-none text-xs font-bold rounded-xl focus:ring-primary-500">
                            <option value="2025/2026">2025/2026</option>
                            <option value="2024/2025">2024/2025</option>
                        </select>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-900/50">
                                <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Mata Pelajaran</th>
                                <th class="px-4 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Tugas</th>
                                <th class="px-4 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">UTS</th>
                                <th class="px-4 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">UAS</th>
                                <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Nilai Akhir</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 dark:divide-gray-700" wire:loading.class="opacity-50">
                            {{-- Skeleton Loading --}}
                            <tr wire:loading.table>
                                <td colspan="5" class="px-8 py-5">
                                    <div class="flex animate-pulse space-x-4">
                                        <div class="flex-1 space-y-4 py-1">
                                            <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded w-3/4"></div>
                                            <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded"></div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            
                            @forelse($nilais as $n)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/30 transition-colors" wire:loading.remove>
                                <td class="px-8 py-5">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-black text-gray-800 dark:text-white">{{ $n->mataPelajaran->nama_mapel }}</span>
                                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter">{{ $n->mataPelajaran->kode_mapel }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-5 text-center text-sm font-bold text-gray-600 dark:text-gray-400">{{ $n->tugas }}</td>
                                <td class="px-4 py-5 text-center text-sm font-bold text-gray-600 dark:text-gray-400">{{ $n->uts }}</td>
                                <td class="px-4 py-5 text-center text-sm font-bold text-gray-600 dark:text-gray-400">{{ $n->uas }}</td>
                                <td class="px-8 py-5 text-center">
                                    <span class="px-4 py-1.5 rounded-xl text-xs font-black {{ $n->nilai_akhir >= 75 ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }}">
                                        {{ $n->nilai_akhir }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-8 py-20 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="w-16 h-16 bg-gray-50 dark:bg-gray-900 rounded-full flex items-center justify-center mb-4 text-gray-300">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                        </div>
                                        <p class="text-gray-400 font-bold uppercase tracking-widest text-xs">Belum ada data nilai</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <!-- Analytics Chart -->
            <div class="bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700">
                <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-8">Grafik Performa</h3>
                <div class="h-64" x-data="{
                    chart: null,
                    init() {
                        this.chart = new Chart(this.$refs.canvas, {
                            type: 'radar',
                            data: {
                                labels: @js($chart_data['labels']),
                                datasets: [{
                                    label: 'Nilai',
                                    data: @js($chart_data['values']),
                                    backgroundColor: 'rgba(79, 70, 229, 0.2)',
                                    borderColor: '#4f46e5',
                                    borderWidth: 2,
                                    pointBackgroundColor: '#4f46e5'
                                }]
                            },
                            options: {
                                scales: {
                                    r: {
                                        beginAtZero: true,
                                        max: 100,
                                        ticks: { display: false }
                                    }
                                },
                                plugins: { legend: { display: false } }
                            }
                        });
                        
                        this.$watch('$wire.chart_data', (value) => {
                            this.chart.data.labels = value.labels;
                            this.chart.data.datasets[0].data = value.values;
                            this.chart.update();
                        });
                    }
                }">
                    <canvas x-ref="canvas"></canvas>
                </div>
                <div class="mt-8 space-y-4">
                    <div class="flex justify-between items-center text-xs">
                        <span class="font-bold text-gray-400 uppercase tracking-widest">Target Kelulusan (KKM)</span>
                        <span class="font-black text-primary-600">75.0</span>
                    </div>
                    <div class="w-full h-2 bg-gray-50 dark:bg-gray-900 rounded-full overflow-hidden">
                        <div class="h-full bg-primary-600 rounded-full" style="width: 75%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js Script -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</div>
