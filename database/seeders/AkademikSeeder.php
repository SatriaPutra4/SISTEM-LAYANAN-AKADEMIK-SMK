<?php

namespace Database\Seeders;

use App\Models\Kelas;
use App\Models\Jurusan;
use Illuminate\Database\Seeder;

class AkademikSeeder extends Seeder
{
    public function run(): void
    {
        $dkv = Jurusan::updateOrCreate(['kode_jurusan' => 'DKV'], ['nama_jurusan' => 'Desain Komunikasi Visual (DKV)']);
        $lpkc = Jurusan::updateOrCreate(['kode_jurusan' => 'LPKC'], ['nama_jurusan' => 'Layanan Penunjang Keperawatan dan Caregiving (LPKC)']);

        $kelases = [
            ['nama_kelas' => 'X LPKC 1', 'jurusan_id' => $lpkc->id],
            ['nama_kelas' => 'X LPKC 2', 'jurusan_id' => $lpkc->id],
            ['nama_kelas' => 'XI LPKC 1', 'jurusan_id' => $lpkc->id],
            ['nama_kelas' => 'XI LPKC 2', 'jurusan_id' => $lpkc->id],
            ['nama_kelas' => 'XI DKV', 'jurusan_id' => $dkv->id],
        ];

        foreach ($kelases as $data) {
            Kelas::updateOrCreate(['nama_kelas' => $data['nama_kelas']], $data);
        }
    }
}
