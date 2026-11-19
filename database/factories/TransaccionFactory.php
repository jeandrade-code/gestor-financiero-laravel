<?php

namespace Database\Factories;

use App\Models\Categoria;
use App\Models\Cuenta;
use App\Models\Transaccion;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Transaccion>
 */
class TransaccionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tipo = fake()->randomElement([Transaccion::TIPO_INGRESO, Transaccion::TIPO_GASTO]);

        return [
            'cuenta_id' => Cuenta::factory(),
            'categoria_id' => Categoria::factory()->state(['tipo' => $tipo]),
            'tipo' => $tipo,
            'monto' => fake()->randomFloat(2, 1000, 500000),
            'fecha' => fake()->dateTimeBetween('-6 months')->format('Y-m-d'),
            'descripcion' => fake()->sentence(),
            'creado_por' => User::factory()->make()->name,
        ];
    }

    /**
     * Movimiento de ingreso.
     */
    public function ingreso(): static
    {
        return $this->state(fn (array $attributes): array => [
            'tipo' => Transaccion::TIPO_INGRESO,
            'categoria_id' => Categoria::factory()->ingreso(),
        ]);
    }

    /**
     * Movimiento de gasto.
     */
    public function gasto(): static
    {
        return $this->state(fn (array $attributes): array => [
            'tipo' => Transaccion::TIPO_GASTO,
            'categoria_id' => Categoria::factory()->gasto(),
        ]);
    }
}