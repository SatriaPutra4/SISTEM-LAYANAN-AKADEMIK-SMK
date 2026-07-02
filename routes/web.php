<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/notifications', \App\Livewire\NotificationHistory::class)->name('notifications.index');
    Route::get('pengaturan-pembayaran', \App\Livewire\Admin\PengaturanPembayaran::class)->name('pengaturan-pembayaran.index')->middleware('role:admin');
    Route::get('siswa', \App\Livewire\Siswa\Index::class)->name('siswa.index')->middleware('role:admin');
    Route::get('guru', \App\Livewire\Guru\Index::class)->name('guru.index')->middleware('role:admin');
    Route::get('jurusan', \App\Livewire\Jurusan\Index::class)->name('jurusan.index')->middleware('role:admin');
    Route::get('kelas', \App\Livewire\Kelas\Index::class)->name('kelas.index')->middleware('role:admin');
    Route::get('mata-pelajaran', \App\Livewire\MataPelajaran\Index::class)->name('mata-pelajaran.index')->middleware('role:admin');
    Route::get('jadwal', \App\Livewire\Jadwal\Index::class)->name('jadwal.index')->middleware('role:admin');
    Route::get('pengumuman', \App\Livewire\Pengumuman\Index::class)->name('pengumuman.index')->middleware('role:admin');
    Route::get('spp', \App\Livewire\Spp\Index::class)->name('spp.index')->middleware('role:admin');
    Route::get('spp/{id}', \App\Livewire\Spp\DetailTagihan::class)->name('spp.detail')->middleware('role:admin');
    Route::get('surat-admin', \App\Livewire\Surat\Admin::class)->name('surat.admin')->middleware('role:admin');
    Route::get('surat-pengajuan', \App\Livewire\Surat\Index::class)->name('surat.index')->middleware('role:siswa');

    // Guru Routes
    Route::prefix('guru-role')->name('guru-role.')->middleware('role:guru')->group(function () {
        Route::get('/dashboard', \App\Livewire\GuruRole\Dashboard::class)->name('dashboard');
        Route::get('/jadwal', \App\Livewire\GuruRole\Jadwal::class)->name('jadwal');
        Route::get('/siswa', \App\Livewire\GuruRole\Siswa::class)->name('siswa');
        Route::get('/nilai', \App\Livewire\GuruRole\Nilai\Index::class)->name('nilai.index');
        Route::get('/nilai/riwayat', \App\Livewire\GuruRole\Nilai\Riwayat::class)->name('nilai.riwayat');
        Route::get('/monitoring', \App\Livewire\GuruRole\Monitoring::class)->name('monitoring');
        Route::get('/pengumuman', \App\Livewire\GuruRole\Pengumuman::class)->name('pengumuman');
        Route::get('/profil', \App\Livewire\GuruRole\Profil::class)->name('profil');
        Route::get('/settings', \App\Livewire\GuruRole\Settings::class)->name('settings');
    });

    // Siswa Routes
    Route::prefix('siswa-role')->name('siswa-role.')->middleware('role:siswa')->group(function () {
        Route::get('/dashboard', \App\Livewire\SiswaRole\Dashboard::class)->name('dashboard');
        Route::get('/profil', \App\Livewire\SiswaRole\Profil::class)->name('profil');
        Route::get('/jadwal', \App\Livewire\SiswaRole\Jadwal::class)->name('jadwal');
        Route::get('/nilai', \App\Livewire\SiswaRole\Nilai::class)->name('nilai');
        Route::get('/pengumuman', \App\Livewire\SiswaRole\Pengumuman::class)->name('pengumuman');
        Route::get('/surat', \App\Livewire\SiswaRole\Surat::class)->name('surat');
        Route::get('/spp', \App\Livewire\SiswaRole\Spp::class)->name('spp');
        Route::get('/monitoring', \App\Livewire\SiswaRole\Monitoring::class)->name('monitoring');
        Route::get('/settings', \App\Livewire\SiswaRole\Settings::class)->name('settings');
    });
});
    // Admin Routes
    Route::get('profil', \App\Livewire\Admin\Profil::class)->name('admin-profil')->middleware('role:admin');

require __DIR__.'/auth.php';
