<?php

namespace App\Imports;

use App\Models\Siswa;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Jurusan;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SiswaImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Cek apakah email sudah ada
        $email = trim($row['email']);
        $user = User::where('email', $email)->first();
        if (!$user) {
            $user = User::create([
                'name' => trim($row['nama_lengkap']),
                'email' => $email,
                'password' => Hash::make('Tr1Bhakt1'),
                'role' => 'siswa',
            ]);
        }

        $namaKelas = trim($row['kelas']);
        $namaJurusan = trim($row['jurusan']);

        // Cari Kelas (case-insensitive)
        $kelas = Kelas::whereRaw('LOWER(nama_kelas) = ?', [strtolower($namaKelas)])->first();
        
        // Cari Jurusan (case-insensitive, partial match jika perlu)
        $jurusan = Jurusan::whereRaw('LOWER(nama_jurusan) LIKE ?', ['%' . strtolower($namaJurusan) . '%'])->first();

        if (!$kelas || !$jurusan) {
            \Illuminate\Support\Facades\Log::warning('Kelas or Jurusan not found for row:', ['nama' => $row['nama_lengkap'], 'kelas' => $namaKelas, 'jurusan' => $namaJurusan]);
            return null;
        }

        // Validasi NIS: Skip jika NIS kosong
        if (empty($row['nis'])) {
            \Illuminate\Support\Facades\Log::warning('Import skipped: NIS is null for student:', ['nama' => $row['nama_lengkap']]);
            return null;
        }

        $siswa = Siswa::create([
            'user_id' => $user->id,
            'nis' => $row['nis'],
            'kelas_id' => $kelas->id,
            'jurusan_id' => $jurusan->id,
            'jenis_kelamin' => in_array($row['jenis_kelamin'], ['L', 'P']) ? $row['jenis_kelamin'] : 'L',
            'no_hp' => (string) $row['no_hp'],
            'alamat' => $row['alamat'],
        ]);

        return $siswa;
    }
}
