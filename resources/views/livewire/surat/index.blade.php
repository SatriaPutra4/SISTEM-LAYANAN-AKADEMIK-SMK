<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Pengajuan Surat</h2>
            <p class="text-sm text-gray-500 mt-1">Ajukan dan pantau status surat administrasi kamu</p>
        </div>
        <button class="bg-primary-600 hover:bg-primary-700 text-white px-5 py-2.5 rounded-xl font-bold transition-all shadow-sm">
            Ajukan Surat Baru
        </button>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 dark:bg-gray-700/50">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Jenis Surat</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Keperluan</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($surats as $s)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                        <td class="px-6 py-4 font-bold text-gray-800 dark:text-gray-200">{{ $s->jenis_surat }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $s->keperluan }}</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs font-bold rounded-full {{ $s->status == 'Diproses' ? 'bg-amber-100 text-amber-700' : ($s->status == 'Disetujui' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700') }}">
                                {{ $s->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $s->created_at->format('d M Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-gray-400 italic">Belum ada pengajuan surat.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
