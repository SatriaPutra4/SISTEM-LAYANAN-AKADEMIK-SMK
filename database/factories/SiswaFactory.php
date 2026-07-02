<?php

namespace Database\Factories;

use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Jurusan;
use Illuminate\Database\Eloquent\Factories\Factory;

class SiswaFactory extends Factory
{
    protected $model = Siswa::class;

    public function definition(): array
    {
        return [
            'nis' => $this->faker->unique()->numerify('##########'),
            'kelas_id' => Kelas::factory(),
            'jurusan_id' => Jurusan::factory(),
            'jenis_kelamin' => 'L',
            'tempat_lahir' => $this->faker->city,
            'tanggal_lahir' => $this->faker->date,
            'no_hp' => $this->faker->phoneNumber,
            'alamat' => $this->faker->address,
        ];
    }
}
