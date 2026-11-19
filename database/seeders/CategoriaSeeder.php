<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    /**
     * Categorías de prueba: 2 de ingreso y 3 de gasto.
     */
    public function run(): void
    {
        $categorias = [
            [
                'nombre' => 'Salario',
                'tipo' => Categoria::TIPO_INGRESO,
                'descripcion' => 'Ingresos por nómina o sueldo mensual.',
            ],
            [
                'nombre' => 'Ventas',
                'tipo' => Categoria::TIPO_INGRESO,
                'descripcion' => 'Ingresos por ventas de productos o servicios.',
            ],
            [
                'nombre' => 'Arriendo',
                'tipo' => Categoria::TIPO_GASTO,
                'descripcion' => 'Pago mensual de arriendo del local u oficina.',
            ],
            [
                'nombre' => 'Servicios públicos',
                'tipo' => Categoria::TIPO_GASTO,
                'descripcion' => 'Energía, agua e internet.',
            ],
            [
                'nombre' => 'Papelería',
                'tipo' => Categoria::TIPO_GASTO,
                'descripcion' => 'Compra de insumos y materiales de oficina.',
            ],
        ];

        foreach ($categorias as $categoria) {
            Categoria::query()->firstOrCreate(
                ['nombre' => $categoria['nombre'], 'tipo' => $categoria['tipo']],
                ['descripcion' => $categoria['descripcion']]
            );
        }
    }
}