<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\MataPelajaran;
use App\Models\Jadwal;
use App\Models\Pengumuman;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\Models\TagihanSpp;
use App\Models\SuratPengajuan;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            InitialUserSeeder::class,
        ]);

        // 1. Admin
        $admin = User::create([
            'name' => 'Admin SMK Tri Bhakti',
            'email' => 'admin@smktribhakti.sch.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // 2. Jurusan
        $rpl = Jurusan::create(['nama_jurusan' => 'Rekayasa Perangkat Lunak', 'kode_jurusan' => 'RPL']);
        $tkj = Jurusan::create(['nama_jurusan' => 'Teknik Komputer dan Jaringan', 'kode_jurusan' => 'TKJ']);

        // 3. Kelas
        $kelas10 = Kelas::create(['nama_kelas' => 'X RPL 1', 'jurusan_id' => $rpl->id]);
        $kelas11 = Kelas::create(['nama_kelas' => 'XI RPL 1', 'jurusan_id' => $rpl->id]);

        // 4. Guru
        $userGuru = User::create([
            'name' => 'Budi Santoso, S.Kom',
            'email' => 'budi@guru.com',
            'password' => Hash::make('password'),
            'role' => 'guru',
        ]);
        $guru = Guru::create([
            'user_id' => $userGuru->id,
            'nip' => '1234567890',
            'no_hp' => '081234567890',
            'alamat' => 'Jl. Merdeka No. 1',
        ]);

        // 5. Siswa
        $userSiswa = User::create([
            'name' => 'Ahmad Fauzi',
            'email' => 'ahmad@siswa.com',
            'password' => Hash::make('password'),
            'role' => 'siswa',
        ]);
        $siswa = Siswa::create([
            'user_id' => $userSiswa->id,
            'nis' => '20240001',
            'kelas_id' => $kelas10->id,
            'jurusan_id' => $rpl->id,
            'jenis_kelamin' => 'L',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '2008-05-15',
            'no_hp' => '089876543210',
            'alamat' => 'Jl. Kenanga No. 5',
        ]);

        // 6. Mata Pelajaran
        $mapel1 = MataPelajaran::create(['nama_mapel' => 'Pemrograman Web', 'kode_mapel' => 'PW']);
        $mapel2 = MataPelajaran::create(['nama_mapel' => 'Basis Data', 'kode_mapel' => 'BD']);
        $mapel3 = MataPelajaran::create(['nama_mapel' => 'Bahasa Inggris', 'kode_mapel' => 'ING']);

        // 7. Jadwal
        Jadwal::create([
            'kelas_id' => $kelas10->id,
            'mata_pelajaran_id' => $mapel1->id,
            'guru_id' => $guru->id,
            'hari' => 'Senin',
            'jam_mulai' => '08:00:00',
            'jam_selesai' => '10:00:00',
        ]);
        Jadwal::create([
            'kelas_id' => $kelas10->id,
            'mata_pelajaran_id' => $mapel2->id,
            'guru_id' => $guru->id,
            'hari' => 'Selasa',
            'jam_mulai' => '08:00:00',
            'jam_selesai' => '10:00:00',
        ]);

        // 8. Pengumuman
        Pengumuman::create([
            'judul' => 'Ujian Tengah Semester',
            'konten' => 'Diberitahukan kepada seluruh siswa bahwa UTS akan dilaksanakan minggu depan.',
            'target_role' => 'all',
            'status_publish' => 'Published',
            'author_id' => $admin->id,
        ]);

        // 9. Tagihan SPP
        TagihanSpp::create([
            'siswa_id' => $siswa->id,
            'tahun_ajaran' => '2025/2026',
            'nominal' => 250000,
            'status' => 'Belum Lunas',
            'keterangan' => 'SPP Mei',
        ]);

        TagihanSpp::create([
            'siswa_id' => $siswa->id,
            'tahun_ajaran' => '2025/2026',
            'nominal' => 250000,
            'status' => 'Lunas',
            'keterangan' => 'SPP April',
        ]);

        // 10. Surat Pengajuan
        SuratPengajuan::create([
            'siswa_id' => $siswa->id,
            'jenis_surat' => 'Surat Keterangan Siswa',
            'keperluan' => 'Pendaftaran Lomba FLS2N',
            'deskripsi' => 'Saya memerlukan surat ini untuk syarat pendaftaran lomba tingkat nasional.',
            'status' => 'Diproses',
        ]);

        // 11. Nilai
        \App\Models\Nilai::create([
            'siswa_id' => $siswa->id,
            'mata_pelajaran_id' => $mapel1->id,
            'guru_id' => $guru->id,
            'tugas' => 85,
            'uts' => 80,
            'uas' => 90,
            'nilai_akhir' => 86,
            'semester' => 'Ganjil',
            'tahun_ajaran' => '2025/2026'
        ]);
        \App\Models\Nilai::create([
            'siswa_id' => $siswa->id,
            'mata_pelajaran_id' => $mapel2->id,
            'guru_id' => $guru->id,
            'tugas' => 90,
            'uts' => 85,
            'uas' => 88,
            'nilai_akhir' => 88,
            'semester' => 'Ganjil',
            'tahun_ajaran' => '2025/2026'
        ]);
    }
}
