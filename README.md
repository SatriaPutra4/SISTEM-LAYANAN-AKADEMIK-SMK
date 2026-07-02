# Sistem Layanan Akademik SMK

Aplikasi ini adalah sistem manajemen akademik terpadu yang dirancang khusus untuk memenuhi kebutuhan administrasi dan operasional di lingkungan SMK (Sekolah Menengah Kejuruan).

## Fitur Utama

Sistem ini mencakup berbagai modul untuk mendukung kegiatan belajar mengajar dan administrasi sekolah:

- **Manajemen Akademik:** Pengelolaan data Siswa, Guru, Mata Pelajaran, Kelas, dan Jadwal Pelajaran.
- **Nilai:** Sistem penilaian terpadu untuk memantau perkembangan akademik siswa.
- **Pengumuman:** Sarana informasi resmi untuk warga sekolah.
- **Administrasi SPP:** Pengelolaan tagihan dan pembayaran SPP siswa yang terintegrasi dengan sistem notifikasi.
- **Surat Pengajuan:** Manajemen pengajuan surat (seperti surat keterangan, surat izin, dll) dengan status yang dapat dipantau.
- **Log Aktivitas:** Pelacakan aktivitas sistem untuk keperluan audit dan keamanan.

## Teknologi yang Digunakan

Aplikasi ini dibangun menggunakan framework modern dan alat pendukung berikut:

- **Framework:** Laravel 11
- **Frontend:** Livewire (untuk interaksi dinamis), Tailwind CSS
- **Database:** SQLite (untuk pengembangan)
- **Fitur Khusus:**
  - Sistem notifikasi untuk pembayaran SPP dan pengajuan surat.
  - Manajemen peran pengguna (Admin, Guru, Siswa).
  - Integrasi dengan sistem manajemen file untuk dokumen pengajuan.

## Instalasi

1. Pastikan sistem Anda telah menginstal PHP dan Composer.
2. Clone repositori ini.
3. Salin file `.env.example` menjadi `.env`.
4. Jalankan perintah berikut untuk menginstal dependensi:
   ```bash
   composer install
   npm install
   ```
5. Jalankan migrasi database:
   ```bash
   php artisan migrate --seed
   ```
6. Jalankan aplikasi:
   ```bash
   php artisan serve
   ```

## Lisensi

Aplikasi ini dikembangkan sebagai solusi internal layanan akademik sekolah.

