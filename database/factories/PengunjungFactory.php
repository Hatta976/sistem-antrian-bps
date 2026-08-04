<?php

namespace Database\Factories;

use App\Models\Pengunjung;
use Illuminate\Database\Eloquent\Factories\Factory;

class PengunjungFactory extends Factory
{
    protected $model = Pengunjung::class;

    public function definition(): array
    {
        return [
            'nama' => $this->faker->name(),
            'instansi' => $this->faker->company(),
            'no_hp' => $this->faker->phoneNumber(),
        ];
    }
}