<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Jadwal Mengajar</h1>
            <p class="text-gray-600 dark:text-gray-400">Lihat seluruh jadwal mengajar Anda dalam satu minggu.</p>
        </div>
        <div class="flex items-center gap-2">
            <select wire:model.live="filterHari" class="rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-sm focus:ring-primary-500 focus:border-primary-500">
                <option value="">Semua Hari</option>
                <option value="Senin">Senin</option>
                <option value="Selasa">Selasa</option>
                <option value="Rabu">Rabu</option>
                <option value="Kamis">Kamis</option>
                <option value="Jumat">Jumat</option>
                <option value="Sabtu">Sabtu</option>
            </select>
        </div>
    </div>

    @forelse($jadwals as $hari => $items)
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="px-6 py-4 bg-primary-50 dark:bg-primary-900/10 border-b border-gray-100 dark:border-gray-700 flex items-center gap-2">
                <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                <h3 class="font-bold text-gray-800 dark:text-white">{{ $hari }}</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50/50 dark:bg-gray-700/30">
                        <tr>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Waktu</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Mata Pelajaran</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Kelas</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Jurusan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @foreach($items as $jadwal)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="text-sm font-semibold text-primary-600 bg-primary-50 dark:bg-primary-900/30 px-2 py-1 rounded-md">
                                            {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $jadwal->mataPelajaran->nama_mapel }}</div>
                                    <div class="text-xs text-gray-500 uppercase tracking-tighter">{{ $jadwal->mataPelajaran->kode_mapel }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                        {{ $jadwal->kelas->nama_kelas }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-600 dark:text-gray-400">{{ $jadwal->kelas->jurusan->nama_jurusan }}</div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @empty
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-12 text-center">
            <div class="flex flex-col items-center">
                <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-full mb-4">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-1">Tidak ada jadwal ditemukan</h3>
                <p class="text-gray-500 dark:text-gray-400 max-w-xs mx-auto">Anda belum memiliki jadwal mengajar yang terdaftar dalam sistem.</p>
            </div>
        </div>
    @endforelse
</div>
