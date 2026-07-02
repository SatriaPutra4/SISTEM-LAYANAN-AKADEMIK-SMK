<div class="p-6" x-data="{ showModal: false, message: '' }" @flash-message.window="message = $event.detail.message; showModal = true; setTimeout(() => showModal = false, 3000)">
    <h2 class="text-2xl font-bold mb-4">Data Mata Pelajaran</h2>

    <!-- Success Modal -->
    <div x-show="showModal" x-cloak class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h3 class="text-lg font-bold mb-2">Berhasil!</h3>
            <p x-text="message"></p>
            <button @click="showModal = false" class="mt-4 bg-primary-600 text-white px-4 py-2 rounded">Tutup</button>
        </div>
    </div>
    
    <div class="bg-white p-6 shadow rounded-lg mb-6">
        <h3 class="text-lg font-semibold mb-4">Tambah Mata Pelajaran</h3>
        <form wire:submit.prevent="store" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <input wire:model="nama_mapel" type="text" placeholder="Nama Mata Pelajaran" class="border p-2 rounded w-full">
                @error('nama_mapel') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <div>
                <input wire:model="kode_mapel" type="text" placeholder="Kode Mata Pelajaran" class="border p-2 rounded w-full">
                @error('kode_mapel') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <button type="submit" class="bg-primary-600 text-white p-2 rounded hover:bg-primary-700">Simpan</button>
        </form>
    </div>

    <div class="bg-white p-6 shadow rounded-lg">
        <input wire:model.live="search" type="text" placeholder="Cari mata pelajaran..." class="border p-2 rounded w-full mb-4">
        
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b">
                    <th class="p-3">Nama Mata Pelajaran</th>
                    <th class="p-3">Kode</th>
                    <th class="p-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($mataPelajarans as $mapel)
                    <tr class="border-b">
                        <td class="p-3">{{ $mapel->nama_mapel }}</td>
                        <td class="p-3">{{ $mapel->kode_mapel }}</td>
                        <td class="p-3">
                            <button wire:click="delete({{ $mapel->id }})" wire:confirm="Anda yakin ingin menghapus data ini?" class="text-red-600 hover:text-red-900">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="mt-4">
            {{ $mataPelajarans->links() }}
        </div>
    </div>
</div>
