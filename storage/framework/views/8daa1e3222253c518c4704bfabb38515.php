<div class="space-y-6">
    <div class="bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700">
        <h3 class="text-2xl font-black text-gray-800 dark:text-white mb-8 flex items-center gap-3">
            <div class="w-1.5 h-8 bg-primary-600 rounded-full"></div>
            Pengaturan Akun
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Appearance -->
            <div class="p-6 bg-gray-50 dark:bg-gray-900 rounded-3xl border border-gray-100 dark:border-gray-700">
                <h4 class="text-sm font-black text-gray-800 dark:text-white uppercase tracking-widest mb-4">Tampilan</h4>
                <div class="flex justify-between items-center">
                    <p class="text-sm font-bold text-gray-600 dark:text-gray-400">Mode Gelap (Dark Mode)</p>
                    <button class="w-12 h-6 bg-gray-200 dark:bg-primary-600 rounded-full relative transition-colors">
                        <div class="w-4 h-4 bg-white rounded-full absolute top-1 left-1 dark:translate-x-6 transition-transform"></div>
                    </button>
                </div>
            </div>

            <!-- Notifications -->
            <div class="p-6 bg-gray-50 dark:bg-gray-900 rounded-3xl border border-gray-100 dark:border-gray-700">
                <h4 class="text-sm font-black text-gray-800 dark:text-white uppercase tracking-widest mb-4">Notifikasi</h4>
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <p class="text-sm font-bold text-gray-600 dark:text-gray-400">Pengumuman Baru</p>
                        <input type="checkbox" checked class="rounded-lg text-primary-600">
                    </div>
                    <div class="flex justify-between items-center">
                        <p class="text-sm font-bold text-gray-600 dark:text-gray-400">Status Surat</p>
                        <input type="checkbox" checked class="rounded-lg text-primary-600">
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-8 pt-8 border-t border-gray-100 dark:border-gray-700">
            <h4 class="text-sm font-black text-rose-600 uppercase tracking-widest mb-4">Zona Berbahaya</h4>
            <button class="px-6 py-3 bg-rose-50 text-rose-600 font-black rounded-2xl text-sm hover:bg-rose-100 transition-colors">
                Hapus Akun Permanen
            </button>
        </div>
    </div>
</div>
<?php /**PATH C:\laragon\www\SISTEM-LAYANAN-AKADEMIK-SMK\resources\views/livewire/siswa-role/settings.blade.php ENDPATH**/ ?>