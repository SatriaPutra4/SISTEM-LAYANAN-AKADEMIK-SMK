<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Manajemen Nilai</h1>
            <p class="text-gray-600 dark:text-gray-400">Kelola nilai akademik siswa Anda.</p>
        </div>
        <div>
            <button wire:click="create" class="inline-flex items-center px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium rounded-xl transition-colors shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Input Nilai
            </button>
        </div>
    </div>

    <!-- Filter & Search -->
    <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="relative">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
            </span>
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari nama siswa..." class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 dark:text-white text-sm focus:ring-primary-500 focus:border-primary-500">
        </div>
        <div>
            <select wire:model.live="filterKelas" class="block w-full pl-3 pr-10 py-2 text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-primary-500 focus:border-primary-500">
                <option value="">Semua Kelas</option>
                @foreach($kelases as $kelas)
                    <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <select wire:model.live="filterMapel" class="block w-full pl-3 pr-10 py-2 text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-primary-500 focus:border-primary-500">
                <option value="">Semua Mata Pelajaran</option>
                @foreach($mapels as $mapel)
                    <option value="{{ $mapel->id }}">{{ $mapel->nama_mapel }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Nilai Table -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 dark:bg-gray-700/50">
                    <tr>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Siswa</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Mata Pelajaran</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Tugas (30%)</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">UTS (30%)</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">UAS (40%)</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center font-bold text-primary-600">Nilai Akhir</th>
                        <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($nilais as $nilai)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-gray-900 dark:text-white">{{ $nilai->siswa->user->name }}</div>
                                <div class="text-xs text-gray-500">{{ $nilai->semester }} | {{ $nilai->tahun_ajaran }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-800 dark:text-gray-300">{{ $nilai->mataPelajaran->nama_mapel }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium text-gray-600 dark:text-gray-400">
                                {{ $nilai->tugas }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium text-gray-600 dark:text-gray-400">
                                {{ $nilai->uts }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium text-gray-600 dark:text-gray-400">
                                {{ $nilai->uas }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold {{ $nilai->nilai_akhir >= 75 ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' }}">
                                    {{ number_format($nilai->nilai_akhir, 2) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button wire:click="edit({{ $nilai->id }})" class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300 p-2 rounded-lg hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                </button>
                                <button wire:click="confirmDelete({{ $nilai->id }})" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 p-2 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20 transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                            </td>
                            </tr>
                            @empty
                            <tr>
                            <td colspan="7" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400 italic">
                                Belum ada data nilai yang diinput.
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

                            <!-- Confirm Deletion Modal -->
                            <x-modal name="confirm-nilai-deletion" focusable>
                            <div class="p-6">
                            <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">Konfirmasi Hapus Data</h2>
                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Anda yakin ingin menghapus data nilai ini? Tindakan ini tidak dapat dibatalkan.</p>
                            <div class="mt-6 flex justify-end space-x-3">
                            <x-secondary-button x-on:click="$dispatch('close')">Batal</x-secondary-button>
                            <x-danger-button wire:click="deleteConfirmed" class="bg-red-600 hover:bg-red-700">Hapus</x-danger-button>
                            </div>
                            </div>
                            </x-modal>

                            <!-- Modal Form Nilai -->
                            <x-modal name="modal-nilai" :show="$showModal">
        <form wire:submit.prevent="save" class="p-6">
            <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-6">
                {{ $nilai_id ? 'Edit Nilai Siswa' : 'Input Nilai Siswa' }}
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div class="col-span-1 md:col-span-2">
                    <x-input-label for="siswa_id" value="Siswa" />
                    <select wire:model="siswa_id" id="siswa_id" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                        <option value="">Pilih Siswa</option>
                        @foreach($allSiswas as $s)
                            <option value="{{ $s->id }}">{{ $s->user->name }} ({{ $s->nis }}) - {{ $s->kelas->nama_kelas }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('siswa_id')" class="mt-2" />
                </div>

                <div class="col-span-1 md:col-span-2">
                    <x-input-label for="mata_pelajaran_id" value="Mata Pelajaran" />
                    <select wire:model="mata_pelajaran_id" id="mata_pelajaran_id" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                        <option value="">Pilih Mata Pelajaran</option>
                        @foreach($mapels as $m)
                            <option value="{{ $m->id }}">{{ $m->nama_mapel }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('mata_pelajaran_id')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="semester" value="Semester" />
                    <select wire:model="semester" id="semester" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm">
                        <option value="Ganjil">Ganjil</option>
                        <option value="Genap">Genap</option>
                    </select>
                    <x-input-error :messages="$errors->get('semester')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="tahun_ajaran" value="Tahun Ajaran" />
                    <x-text-input wire:model="tahun_ajaran" id="tahun_ajaran" type="text" class="mt-1 block w-full" placeholder="e.g. 2025/2026" />
                    <x-input-error :messages="$errors->get('tahun_ajaran')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="tugas" value="Nilai Tugas (30%)" />
                    <x-text-input wire:model="tugas" id="tugas" type="number" step="0.01" class="mt-1 block w-full" />
                    <x-input-error :messages="$errors->get('tugas')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="uts" value="Nilai UTS (30%)" />
                    <x-text-input wire:model="uts" id="uts" type="number" step="0.01" class="mt-1 block w-full" />
                    <x-input-error :messages="$errors->get('uts')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="uas" value="Nilai UAS (40%)" />
                    <x-text-input wire:model="uas" id="uas" type="number" step="0.01" class="mt-1 block w-full" />
                    <x-input-error :messages="$errors->get('uas')" class="mt-2" />
                </div>

                <div class="flex items-end">
                    <div class="w-full p-2 bg-primary-50 dark:bg-primary-900/20 rounded-xl border border-primary-100 dark:border-primary-800">
                        <span class="text-xs font-semibold text-primary-600 block uppercase">Estimasi Nilai Akhir</span>
                        <span class="text-xl font-bold text-primary-700 dark:text-primary-400">
                            {{ number_format(($tugas * 0.3) + ($uts * 0.3) + ($uas * 0.4), 2) }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close-modal', 'modal-nilai')">
                    Batal
                </x-secondary-button>
                <x-primary-button type="submit">
                    Simpan Nilai
                </x-primary-button>
            </div>
        </form>
    </x-modal>
</div>
