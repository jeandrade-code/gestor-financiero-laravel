<?php

namespace Database\Seeders;

use App\Models\Cuenta;
use Illuminate\Database\Seeder;

class CuentaSeeder extends Seeder
{
    /**
     * Cuentas de prueba. La cuenta "Caja" arranca con 200.000 para el caso de validación.
     */
    public function run(): void
    {
        $cuentas = [
            [
                'nombre' => 'Caja',
                'descripcion' => 'Efectivo disponible en caja menor.',
                'saldo' => 200000.00,
                'moneda' => 'COP',
            ],
            [
                'nombre' => 'Bancolombia',
                'descripcion' => 'Cuenta corriente principal de la empresa.',
                'saldo' => 1500000.00,
                'moneda' => 'COP',
            ],
            [
                'nombre' => 'Ahorros',
                'descripcion' => 'Cuenta de ahorros para imprevistos.',
                'saldo' => 800000.00,
                'moneda' => 'COP',
            ],
        ];

        foreach ($cuentas as $cuenta) {
            Cuenta::query()->firstOrCreate(
                ['nombre' => $cuenta['nombre']],
                [
                    'descripcion' => $cuenta['descripcion'],
                    'saldo' => $cuenta['saldo'],
                    'moneda' => $cuenta['moneda'],
                ]
            );
        }
    }
}
