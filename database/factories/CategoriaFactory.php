<?php

namespace Database\Factories;

use App\Models\Categoria;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Categoria>
 */
class CategoriaFactory extends Factory
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
            'tipo' => fake()->randomElement([Categoria::TIPO_INGRESO, Categoria::TIPO_GASTO]),
            'descripcion' => fake()->sentence(),
        ];
    }

    /**
     * Categoría de ingreso.
     */
    public function ingreso(): static
    {
        return $this->state(fn (array $attributes): array => [
            'tipo' => Categoria::TIPO_INGRESO,
        ]);
    }

    /**
     * Categoría de gasto.
     */
    public function gasto(): static
    {
        return $this->state(fn (array $attributes): array => [
            'tipo' => Categoria::TIPO_GASTO,
        ]);
    }
}
