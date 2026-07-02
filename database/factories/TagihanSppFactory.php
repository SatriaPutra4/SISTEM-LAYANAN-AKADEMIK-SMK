<?php

namespace Database\Factories;

use App\Models\TagihanSpp;
use Illuminate\Database\Eloquent\Factories\Factory;

class TagihanSppFactory extends Factory
{
    protected $model = TagihanSpp::class;

    public function definition(): array
    {
        return [
            'tahun_ajaran' => '2025/2026',
            'nominal' => 1000000,
            'status' => 'Belum Lunas',
            'keterangan' => 'SPP Bulan Januari',
        ];
    }
}
