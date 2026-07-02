<div class="space-y-6">
    <!-- Rekening Sekolah -->
    @if($rekenings->isNotEmpty())
        @php $rek = $rekenings->first(); @endphp
        <div class="bg-gradient-to-r from-primary-600 to-primary-800 p-8 rounded-3xl shadow-xl flex items-center justify-between text-white">
            <div class="flex items-center gap-6">
                <div class="bg-white/10 p-4 rounded-2xl">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-2m-2 0H5m2 0H3m6 2H7m5 0h2m5 0h2m-2 0h-2M5 19h14" /></svg>
                </div>
                <div>
                    <h3 class="text-lg font-black tracking-wide uppercase">{{ $rek->nama_bank }}</h3>
                    <p class="text-3xl font-mono font-bold my-1">{{ $rek->nomor_rekening }}</p>
                    <p class="text-sm font-medium text-primary-100">a.n {{ $rek->nama_pemilik }}</p>
                </div>
            </div>
            <div class="hidden md:block text-right">
                <p class="text-xs font-bold uppercase tracking-widest text-primary-200">Informasi Pembayaran</p>
            </div>
        </div>
    @endif

    <!-- SPP Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 flex flex-col justify-center">
            <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Total Tagihan</p>
            <h4 class="text-2xl font-black text-gray-800 dark:text-white">Rp {{ number_format($stats['total_tagihan'], 0, ',', '.') }}</h4>
        </div>
        <div class="bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 flex flex-col justify-center">
            <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Total Dibayar</p>
            <h4 class="text-2xl font-black text-emerald-600">Rp {{ number_format($stats['total_dibayar'], 0, ',', '.') }}</h4>
        </div>
        <div class="bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 flex flex-col justify-center">
            <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Sisa Tagihan</p>
            <h4 class="text-2xl font-black text-rose-600">Rp {{ number_format($stats['sisa_tagihan'], 0, ',', '.') }}</h4>
        </div>
        <div class="bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 flex flex-col justify-center">
            <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Progress Pembayaran</p>
            <div class="flex items-center gap-4">
                <div class="flex-1 h-3 bg-gray-100 dark:bg-gray-700 rounded-full overflow-hidden">
                    <div class="h-full bg-emerald-500 rounded-full" style="width: {{ $stats['persentase'] }}%"></div>
                </div>
                <span class="text-lg font-black text-emerald-600">{{ $stats['persentase'] }}%</span>
            </div>
        </div>
    </div>

    <!-- Tagihan List -->
    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="p-8 border-b border-gray-50 dark:border-gray-700">
            <h3 class="text-2xl font-black text-gray-800 dark:text-white flex items-center gap-3">
                <div class="w-1.5 h-8 bg-emerald-600 rounded-full"></div>
                Riwayat Tagihan & Pembayaran SPP
            </h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-900/50">
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Tahun Ajaran</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">Tagihan</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">Dibayar</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Status</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-gray-700">
                    @forelse($tagihans as $t)
                        @php
                            $dibayar = $t->pembayaranSpps->where('status', 'Disetujui')->sum('nominal_bayar');
                            $persen = $t->nominal > 0 ? min(100, round(($dibayar / $t->nominal) * 100)) : 0;
                            $status_color = $t->status === 'Lunas' ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600';
                        @endphp
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/30 transition-colors">
                        <td class="px-8 py-5">
                            <span class="text-sm font-black text-gray-800 dark:text-white">{{ $t->tahun_ajaran }}</span>
                        </td>
                        <td class="px-8 py-5 text-right font-black text-gray-700 dark:text-gray-300">
                            Rp {{ number_format($t->nominal, 0, ',', '.') }}
                        </td>
                        <td class="px-8 py-5 text-right">
                            <div class="font-black text-emerald-600">Rp {{ number_format($dibayar, 0, ',', '.') }}</div>
                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-1.5 mt-1">
                                <div class="bg-emerald-500 h-1.5 rounded-full" style="width: {{ $persen }}%"></div>
                            </div>
                        </td>
                        <td class="px-8 py-5 text-center">
                            <span class="px-4 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest {{ $status_color }}">
                                {{ $t->status }}
                            </span>
                        </td>
                        <td class="px-8 py-5 text-center">
                            @if($t->status !== 'Lunas')
                            <button wire:click="openModal({{ $t->id }})" class="bg-primary-600 text-white px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest shadow-lg shadow-primary-200 dark:shadow-none hover:bg-primary-700 transition-all">
                                Bayar
                            </button>
                            @else
                            <div class="flex flex-col items-center">
                                <span class="text-[10px] font-bold text-emerald-500 uppercase tracking-widest">Lunas</span>
                            </div>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-8 py-20 text-center text-gray-400 font-bold uppercase tracking-widest text-xs">Tidak ada data tagihan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-8 border-t border-gray-50 dark:border-gray-700">
            {{ $tagihans->links() }}
        </div>
    </div>

    <!-- Modal Pembayaran -->
    @if($is_modal_open)
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-gray-900/75 backdrop-blur-sm" wire:click="closeModal"></div>
            
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            
            <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full">
                <div class="p-8">
                    <h3 class="text-2xl font-black text-gray-800 dark:text-white mb-2">Upload Bukti Pembayaran</h3>
                    <p class="text-sm text-gray-500 mb-8 tracking-tight leading-relaxed">Pastikan foto bukti pembayaran terlihat jelas dan terbaca oleh sistem.</p>
                    
                    <form wire:submit="uploadBukti" class="space-y-6">
                        @if ($errors->any())
                            <div class="p-4 bg-rose-50 text-rose-700 rounded-xl text-sm">
                                <ul class="list-disc pl-5">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="space-y-4">
                            <div class="relative w-full h-48">
                                <input type="file" wire:model="bukti_pembayaran" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20">
                                @if($bukti_pembayaran)
                                    <div class="relative w-full h-48 rounded-2xl overflow-hidden border-2 border-primary-500 shadow-xl">
                                        <img src="{{ $bukti_pembayaran->temporaryUrl() }}" class="w-full h-full object-cover">
                                        <button type="button" wire:click="$reset('bukti_pembayaran')" class="absolute top-2 right-2 p-2 bg-rose-600 text-white rounded-xl shadow-lg z-30">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                        </button>
                                    </div>
                                @else
                                    <div class="w-full h-48 bg-gray-50 dark:bg-gray-900 border-2 border-dashed border-gray-200 dark:border-gray-700 rounded-3xl flex flex-col items-center justify-center gap-4">
                                        <div class="p-4 bg-white dark:bg-gray-800 rounded-2xl shadow-sm text-primary-600">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" /></svg>
                                        </div>
                                        <span class="text-sm font-black text-gray-700 dark:text-gray-300">Pilih Foto Bukti</span>
                                    </div>
                                @endif
                            </div>
                            <x-input-error :messages="$errors->get('bukti_pembayaran')" />

                            <input type="number" wire:model="nominal_transfer" placeholder="Nominal Transfer" class="w-full p-3 rounded-xl border border-gray-200 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                            <x-input-error :messages="$errors->get('nominal_transfer')" />

                            <input type="datetime-local" wire:model="tanggal_transfer" class="w-full p-3 rounded-xl border border-gray-200 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                            <x-input-error :messages="$errors->get('tanggal_transfer')" />

                            <textarea wire:model="catatan" placeholder="Catatan (opsional)" class="w-full p-3 rounded-xl border border-gray-200 dark:bg-gray-900 dark:border-gray-700 dark:text-white"></textarea>
                            <x-input-error :messages="$errors->get('catatan')" />
                        </div>
                        
                        <div class="flex gap-4 pt-4">
                            <button type="button" wire:click="closeModal" class="flex-1 px-6 py-3 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 font-bold rounded-2xl hover:bg-gray-200 transition-all">Batal</button>
                            <button type="submit" class="flex-1 px-6 py-3 bg-primary-600 text-white font-bold rounded-2xl shadow-xl shadow-primary-200 dark:shadow-none hover:bg-primary-700 transition-all flex items-center justify-center gap-2">
                                <div wire:loading wire:target="uploadBukti" class="w-4 h-4 border-2 border-white/30 border-t-white rounded-full animate-spin"></div>
                                Kirim Bukti
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
