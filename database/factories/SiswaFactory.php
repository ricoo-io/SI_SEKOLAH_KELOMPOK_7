<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Siswa>
 */
class SiswaFactory extends Factory
{
    public function definition(): array
    {
        $namaIbu = fake()->firstName('female') . ' ' . fake()->lastName();
        $namaAyah = fake()->firstName('male') . ' ' . fake()->lastName();
        
        return [
            'nis' => fake()->unique()->numerify('##########'),
            'nama' => fake()->name(),
            'alamat' => fake()->address(),
            'ibu' => $namaIbu,
            'ayah' => $namaAyah,
            'wali' => fake()->randomElement([$namaIbu, $namaAyah, fake()->name()]),
            'kontak_wali' => fake()->phoneNumber(),
        ];
    }

}
