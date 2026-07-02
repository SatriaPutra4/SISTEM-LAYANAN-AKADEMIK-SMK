<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Riwayat Nilai</h1>
            <p class="text-gray-600 dark:text-gray-400">Arsip data nilai siswa dari semester sebelumnya.</p>
        </div>
    </div>

    <!-- Filter -->
    <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label class="block text-xs font-semibold text-gray-500 uppercase mb-1 ml-1">Tahun Ajaran</label>
            <select wire:model.live="filterTahun" class="block w-full pl-3 pr-10 py-2 text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-primary-500 focus:border-primary-500">
                <option value="">Semua Tahun</option>
                @foreach($tahunAjarans as $tahun)
                    <option value="{{ $tahun }}">{{ $tahun }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-500 uppercase mb-1 ml-1">Semester</label>
            <select wire:model.live="filterSemester" class="block w-full pl-3 pr-10 py-2 text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-primary-500 focus:border-primary-500">
                <option value="">Semua Semester</option>
                <option value="Ganjil">Ganjil</option>
                <option value="Genap">Genap</option>
            </select>
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-500 uppercase mb-1 ml-1">Mata Pelajaran</label>
            <select wire:model.live="filterMapel" class="block w-full pl-3 pr-10 py-2 text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-primary-500 focus:border-primary-500">
                <option value="">Semua Mata Pelajaran</option>
                @foreach($mapels as $mapel)
                    <option value="{{ $mapel->id }}">{{ $mapel->nama_mapel }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Results -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 dark:bg-gray-700/50">
                    <tr>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Siswa</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Mata Pelajaran</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Periode</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase text-center">Nilai Akhir</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($nilais as $nilai)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-gray-900 dark:text-white">{{ $nilai->siswa->user->name }}</div>
                                <div class="text-xs text-gray-500">{{ $nilai->siswa->nis }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-800 dark:text-gray-300">{{ $nilai->mataPelajaran->nama_mapel }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-800 dark:text-gray-300">{{ $nilai->semester }}</div>
                                <div class="text-xs text-gray-500">{{ $nilai->tahun_ajaran }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center font-bold text-gray-900 dark:text-white">
                                {{ number_format($nilai->nilai_akhir, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($nilai->nilai_akhir >= 75)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400">
                                        Tuntas
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                                        Perlu Remedial
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400 italic">
                                Tidak ada data riwayat nilai ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($nilais->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700">
                {{ $nilais->links() }}
            </div>
        @endif
    </div>
</div>
