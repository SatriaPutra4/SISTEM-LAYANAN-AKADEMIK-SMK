<div class="space-y-6">
    <!-- Hero Section -->
    <div class="relative bg-gradient-to-br from-primary-800 to-primary-600 rounded-3xl p-8 overflow-hidden shadow-2xl text-white">
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div>
                <h2 class="text-3xl font-black mb-2 tracking-tight">Selamat Datang, {{ auth()->user()->name }}! 👋</h2>
                <p class="text-primary-100 text-lg opacity-90">Hari ini adalah hari yang luar biasa untuk belajar hal baru.</p>
                <div class="flex flex-wrap gap-3 mt-6">
                    <div class="bg-white/10 backdrop-blur-md px-5 py-2.5 rounded-2xl border border-white/20 flex items-center gap-3">
                        <div class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></div>
                        <span class="text-sm font-bold">{{ $siswa->kelas->nama_kelas }}</span>
                    </div>
                    <div class="bg-white/10 backdrop-blur-md px-5 py-2.5 rounded-2xl border border-white/20 flex items-center gap-3">
                        <svg class="w-4 h-4 text-primary-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" /></svg>
                        <span class="text-sm font-bold">{{ $siswa->jurusan->nama_jurusan }}</span>
                    </div>
                </div>
            </div>
            <div class="hidden lg:flex gap-4">
                <a href="{{ route('siswa-role.surat') }}" wire:navigate class="bg-white text-primary-700 px-6 py-3 rounded-2xl font-bold shadow-lg hover:bg-primary-50 transition-all flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" /></svg>
                    Ajukan Surat
                </a>
            </div>
        </div>
        <div class="absolute -right-20 -bottom-20 opacity-10 rotate-12 scale-150">
            <svg class="w-96 h-96" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L1 21h22L12 2zm0 3.45l8.1 14.1H3.9L12 5.45zM11 11h2v4h-2v-4zm0 6h2v2h-2v-2z" /></svg>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center gap-5">
            <div class="w-14 h-14 bg-indigo-50 dark:bg-indigo-900/20 rounded-2xl flex items-center justify-center text-indigo-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Rata-rata Nilai</p>
                <h4 class="text-2xl font-black text-gray-800 dark:text-white">{{ number_format($stats['rata_rata_nilai'], 1) }}</h4>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center gap-5">
            <div class="w-14 h-14 bg-emerald-50 dark:bg-emerald-900/20 rounded-2xl flex items-center justify-center text-emerald-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">SPP Lunas</p>
                <h4 class="text-2xl font-black text-gray-800 dark:text-white">{{ $stats['spp_lunas'] }} <span class="text-sm font-medium text-gray-400">Bulan</span></h4>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center gap-5">
            <div class="w-14 h-14 bg-amber-50 dark:bg-amber-900/20 rounded-2xl flex items-center justify-center text-amber-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Total Pengajuan</p>
                <h4 class="text-2xl font-black text-gray-800 dark:text-white">{{ $stats['total_surat'] }}</h4>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center gap-5">
            <div class="w-14 h-14 bg-rose-50 dark:bg-rose-900/20 rounded-2xl flex items-center justify-center text-rose-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Kehadiran</p>
                <h4 class="text-2xl font-black text-gray-800 dark:text-white">98%</h4>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Column -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Academic Chart -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="flex justify-between items-center mb-8">
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white flex items-center gap-3">
                        <div class="w-1.5 h-6 bg-primary-600 rounded-full"></div>
                        Perkembangan Nilai
                    </h3>
                    <select class="bg-gray-50 dark:bg-gray-900 border-none text-xs font-bold rounded-xl focus:ring-primary-500">
                        <option>Semester Ganjil 2025/2026</option>
                    </select>
                </div>
                <div class="h-80" x-data="{
                    init() {
                        new Chart(this.$refs.canvas, {
                            type: 'line',
                            data: {
                                labels: @js($chart_data['labels']),
                                datasets: [{
                                    label: 'Nilai Akhir',
                                    data: @js($chart_data['values']),
                                    borderColor: '#4f46e5',
                                    backgroundColor: 'rgba(79, 70, 229, 0.1)',
                                    fill: true,
                                    tension: 0.4,
                                    borderWidth: 4,
                                    pointBackgroundColor: '#fff',
                                    pointBorderColor: '#4f46e5',
                                    pointBorderWidth: 2,
                                    pointRadius: 6,
                                    pointHoverRadius: 8
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: { display: false },
                                    tooltip: {
                                        backgroundColor: '#1e293b',
                                        padding: 12,
                                        titleFont: { size: 14, weight: 'bold' },
                                        bodyFont: { size: 13 },
                                        cornerRadius: 12,
                                        displayColors: false
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        max: 100,
                                        grid: { borderDash: [5, 5], color: '#e2e8f0' },
                                        ticks: { font: { weight: 'bold' } }
                                    },
                                    x: {
                                        grid: { display: false },
                                        ticks: { font: { weight: 'bold' } }
                                    }
                                }
                            }
                        });
                    }
                }">
                    <canvas x-ref="canvas"></canvas>
                </div>
            </div>

            <!-- Today's Schedule -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white flex items-center gap-3">
                        <div class="w-1.5 h-6 bg-emerald-600 rounded-full"></div>
                        Jadwal Pelajaran Hari Ini
                    </h3>
                    <span class="text-xs font-bold text-emerald-600 px-3 py-1 bg-emerald-50 rounded-lg">{{ $this->getHariIni() }}</span>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @forelse($jadwal_hari_ini as $j)
                    <div class="p-5 bg-gray-50 dark:bg-gray-900 rounded-3xl border border-gray-100 dark:border-gray-700 hover:border-primary-200 transition-colors group">
                        <div class="flex justify-between items-start mb-4">
                            <div class="px-3 py-1 bg-white dark:bg-gray-800 shadow-sm text-primary-600 text-[10px] font-black rounded-xl uppercase tracking-widest border border-primary-100">
                                {{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }}
                            </div>
                            <span class="text-[10px] font-bold text-gray-400">s/d {{ \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') }}</span>
                        </div>
                        <h4 class="font-black text-gray-800 dark:text-white text-lg group-hover:text-primary-600 transition-colors">{{ $j->mataPelajaran->nama_mapel }}</h4>
                        <div class="flex items-center gap-2 mt-3">
                            <div class="w-6 h-6 rounded-full bg-primary-100 flex items-center justify-center">
                                <svg class="w-3.5 h-3.5 text-primary-600" fill="currentColor" viewBox="0 0 20 20"><path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" /></svg>
                            </div>
                            <p class="text-xs font-bold text-gray-500">{{ $j->guru->user->name }}</p>
                        </div>
                    </div>
                    @empty
                    <div class="md:col-span-2 py-12 flex flex-col items-center justify-center text-center">
                        <div class="w-20 h-20 bg-gray-50 dark:bg-gray-900 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        </div>
                        <h5 class="text-gray-400 font-bold uppercase tracking-widest text-xs">Tidak ada jadwal hari ini</h5>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Recent Grades -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white flex items-center gap-3">
                        <div class="w-1.5 h-6 bg-indigo-600 rounded-full"></div>
                        Nilai Akademik Terbaru
                    </h3>
                    <a href="{{ route('siswa-role.nilai') }}" wire:navigate class="text-xs font-bold text-primary-600 hover:underline">Lihat Semua</a>
                </div>
                <div class="space-y-4">
                    @forelse($ringkasan_nilai as $n)
                    <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-700">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-white dark:bg-gray-800 rounded-xl flex items-center justify-center text-indigo-600 shadow-sm font-black text-xs">
                                {{ $n->mataPelajaran->kode_mapel }}
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-gray-800 dark:text-white">{{ $n->mataPelajaran->nama_mapel }}</h4>
                                <p class="text-[10px] font-bold text-gray-400 uppercase">{{ $n->semester }} • {{ $n->tahun_ajaran }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="text-lg font-black text-indigo-600">{{ $n->nilai_akhir }}</span>
                            <div class="flex gap-1 mt-1">
                                <div class="w-1 h-1 rounded-full bg-indigo-400"></div>
                                <div class="w-1 h-1 rounded-full bg-indigo-400"></div>
                                <div class="w-1 h-1 rounded-full bg-indigo-400 opacity-30"></div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <p class="text-center py-8 text-gray-400 text-xs font-bold uppercase tracking-widest">Belum ada data nilai</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Sidebar Column -->
        <div class="space-y-6">
            <!-- Latest Announcement -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700">
                <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-6">Pengumuman Terbaru</h3>
                <div class="space-y-4">
                    @foreach($pengumuman_terbaru as $p)
                    <div class="p-5 bg-amber-50 dark:bg-amber-900/20 rounded-2xl border border-amber-100 dark:border-amber-800 relative overflow-hidden group">
                        <div class="absolute top-0 right-0 p-2 opacity-10 group-hover:rotate-12 transition-transform">
                            <svg class="w-12 h-12 text-amber-600" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" /></svg>
                        </div>
                        <h4 class="text-sm font-black text-amber-800 dark:text-amber-200 mb-2">{{ $p->judul }}</h4>
                        <p class="text-xs text-amber-700 dark:text-amber-300/70 line-clamp-2 leading-relaxed">{{ $p->konten }}</p>
                        <div class="flex items-center gap-2 mt-4 text-[10px] font-bold text-amber-600/60 uppercase">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            {{ $p->created_at->diffForHumans() }}
                        </div>
                    </div>
                    @endforeach
                </div>
                <a href="{{ route('siswa-role.pengumuman') }}" wire:navigate class="mt-6 block text-center py-3 bg-gray-50 dark:bg-gray-900 rounded-2xl text-xs font-bold text-gray-500 hover:text-primary-600 transition-colors">Lihat Semua Pengumuman</a>
            </div>

            <!-- Finance Status -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700">
                <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-6">Status Keuangan</h3>
                @if($status_spp)
                <div class="p-5 bg-rose-50 dark:bg-rose-900/20 rounded-2xl border border-rose-100 dark:border-rose-800">
                    <div class="flex justify-between items-start mb-4">
                        <span class="px-2 py-1 bg-rose-100 text-rose-700 text-[10px] font-black rounded-lg uppercase tracking-tighter">Tertunggak</span>
                        <span class="text-xs font-black text-rose-700">{{ $status_spp->bulan }}</span>
                    </div>
                    <p class="text-xs font-bold text-gray-500 mb-1 uppercase tracking-widest">Tagihan SPP</p>
                    <h4 class="text-xl font-black text-rose-800 dark:text-rose-200">Rp {{ number_format($status_spp->nominal, 0, ',', '.') }}</h4>
                    <a href="{{ route('siswa-role.spp') }}" wire:navigate class="mt-4 flex items-center justify-center w-full py-2 bg-rose-600 text-white rounded-xl text-xs font-bold shadow-lg shadow-rose-200 dark:shadow-none hover:bg-rose-700 transition-all">Bayar Sekarang</a>
                </div>
                @else
                <div class="p-5 bg-emerald-50 dark:bg-emerald-900/20 rounded-2xl border border-emerald-100 dark:border-emerald-800">
                    <div class="flex items-center gap-3 text-emerald-700">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <div>
                            <h4 class="text-sm font-black">Lunas</h4>
                            <p class="text-[10px] font-bold opacity-75">Semua tagihan SPP sudah dibayar.</p>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Recent Activity -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700">
                <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-6">Aktivitas Terakhir</h3>
                <div class="space-y-6">
                    @if($pengajuan_terakhir)
                    <div class="flex gap-4">
                        <div class="relative flex-shrink-0">
                            <div class="w-10 h-10 bg-indigo-50 dark:bg-indigo-900/20 rounded-full flex items-center justify-center text-indigo-600 z-10 relative">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                            </div>
                            <div class="absolute top-10 left-1/2 w-0.5 h-full bg-gray-100 -translate-x-1/2"></div>
                        </div>
                        <div>
                            <h5 class="text-sm font-bold text-gray-800 dark:text-white">Pengajuan {{ $pengajuan_terakhir->jenis_surat }}</h5>
                            <p class="text-xs text-gray-500 mt-1">Status: <span class="text-primary-600 font-bold">{{ $pengajuan_terakhir->status }}</span></p>
                            <span class="text-[10px] font-bold text-gray-400 uppercase mt-2 block">{{ $pengajuan_terakhir->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js Script -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</div>
