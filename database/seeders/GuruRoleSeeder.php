<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Jurusan;
use App\Models\MataPelajaran;
use App\Models\Jadwal;
use App\Models\Nilai;
use App\Models\Pengumuman;
use Illuminate\Support\Facades\Hash;

class GuruRoleSeeder extends Seeder
{
    public function run(): void
    {
        // Create a test Guru
        $userGuru = User::create([
            'name' => 'Guru Demo',
            'email' => 'guru@demo.com',
            'password' => Hash::make('password'),
            'role' => 'guru',
        ]);

        $guru = Guru::create([
            'user_id' => $userGuru->id,
            'nip' => '1234567890',
            'no_hp' => '08123456789',
            'alamat' => 'Jl. Pendidikan No. 123',
        ]);

        // Ensure we have some data
        $jurusan = Jurusan::first() ?? Jurusan::create(['nama_jurusan' => 'RPL', 'kode_jurusan' => 'RPL']);
        $kelas = Kelas::first() ?? Kelas::create(['nama_kelas' => 'X RPL 1', 'jurusan_id' => $jurusan->id]);
        $mapel = MataPelajaran::first() ?? MataPelajaran::create(['nama_mapel' => 'Matematika', 'kode_mapel' => 'MTK']);

        // Create Jadwal
        Jadwal::create([
            'guru_id' => $guru->id,
            'kelas_id' => $kelas->id,
            'mata_pelajaran_id' => $mapel->id,
            'hari' => 'Senin',
            'jam_mulai' => '07:00:00',
            'jam_selesai' => '09:00:00',
        ]);

        // Create some Siswas in that class
        for ($i = 1; $i <= 5; $i++) {
            $userSiswa = User::create([
                'name' => "Siswa Demo $i",
                'email' => "siswa$i@demo.com",
                'password' => Hash::make('password'),
                'role' => 'siswa',
            ]);

            Siswa::create([
                'user_id' => $userSiswa->id,
                'nis' => "1000$i",
                'kelas_id' => $kelas->id,
                'jurusan_id' => $jurusan->id,
                'jenis_kelamin' => $i % 2 == 0 ? 'L' : 'P',
            ]);
        }

        // Create some Pengumumans
        Pengumuman::create([
            'judul' => 'Rapat Guru Semester Ganjil',
            'konten' => 'Diharapkan seluruh guru hadir pada rapat koordinasi besok pagi.',
            'status_publish' => true,
            'target_role' => 'guru',
            'author_id' => 1, // Assuming admin is 1
        ]);

        Pengumuman::create([
            'judul' => 'Libur Nasional',
            'konten' => 'Sekolah diliburkan sehubungan dengan hari raya nasional.',
            'status_publish' => true,
            'target_role' => 'all',
            'author_id' => 1,
        ]);
    }
}
