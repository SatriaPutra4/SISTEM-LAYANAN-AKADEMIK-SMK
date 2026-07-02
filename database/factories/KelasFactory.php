<?php

namespace Database\Factories;

use App\Models\Kelas;
use App\Models\Jurusan;
use Illuminate\Database\Eloquent\Factories\Factory;

class KelasFactory extends Factory
{
    protected $model = Kelas::class;

    public function definition(): array
    {
        return [
            'nama_kelas' => 'X-RPL',
            'jurusan_id' => Jurusan::factory(),
        ];
    }
}
