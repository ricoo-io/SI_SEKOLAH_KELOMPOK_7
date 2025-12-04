<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    protected static ?string $password = null;

    public function definition(): array
    {
        return [
            'nama' => fake()->name(),
            'nip' => fake()->unique()->numerify('##########'), // 10 digit NIP
            'password' => static::$password ??= Hash::make('password'),
            'role' => fake()->randomElement(['admin', 'guru']),
            'wali_kelas' => 'False',
        ];
    }

    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
            'nip' => 'ADM' . fake()->unique()->numerify('#####'),
            'wali_kelas' => 'False',
        ]);
    }

    public function guru(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'guru',
            'nip' => 'GRU' . fake()->unique()->numerify('#####'),
        ]);
    }

    public function waliKelas(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'guru',
            'wali_kelas' => 'True',
        ]);
    }
}
