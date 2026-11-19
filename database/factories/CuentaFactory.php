<?php

namespace Database\Factories;

use App\Models\Cuenta;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Cuenta>
 */
class CuentaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => fake()->unique()->words(2, true),
            'descripcion' => fake()->sentence(),
            'saldo' => fake()->randomFloat(2, 0, 5000000),
            'moneda' => 'COP',
        ];
    }

    /**
     * Cuenta sin saldo inicial.
     */
    public function sinSaldo(): static
    {
        return $this->state(fn (array $attributes): array => [
            'saldo' => 0,
        ]);
    }
}