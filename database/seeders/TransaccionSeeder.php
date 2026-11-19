<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Cuenta;
use App\Models\Transaccion;
use App\Models\User;
use App\Services\GestorSaldo;
use Illuminate\Database\Seeder;

class TransaccionSeeder extends Seeder
{
    /**
     * Movimientos de prueba: 2 ingresos y 3 gastos.
     *
     * Incluye el caso de validación sobre la cuenta "Caja":
     * 200.000 (saldo inicial) + 150.000 (ingreso) - 20.000 (gasto) = 330.000.
     */
    public function run(GestorSaldo $gestorSaldo): void
    {
        if (Transaccion::query()->exists()) {
            return;
        }

        $usuario = User::query()->orderBy('id')->first();
        $creadoPor = $usuario?->name ?? 'Sistema';

        $cuentaCaja = Cuenta::query()->where('nombre', 'Caja')->firstOrFail();
        $cuentaBanco = Cuenta::query()->where('nombre', 'Bancolombia')->firstOrFail();
        $cuentaAhorros = Cuenta::query()->where('nombre', 'Ahorros')->firstOrFail();

        $movimientos = [
            [
                'cuenta' => $cuentaCaja,
                'categoria' => 'Salario',
                'tipo' => Transaccion::TIPO_INGRESO,
                'monto' => 150000.00,
                'fecha' => now()->subDays(10)->toDateString(),
                'descripcion' => 'Ingreso de prueba sobre la cuenta Caja.',
            ],
            [
                'cuenta' => $cuentaCaja,
                'categoria' => 'Servicios públicos',
                'tipo' => Transaccion::TIPO_GASTO,
                'monto' => 20000.00,
                'fecha' => now()->subDays(5)->toDateString(),
                'descripcion' => 'Pago de servicios públicos desde la cuenta Caja.',
            ],
            [
                'cuenta' => $cuentaBanco,
                'categoria' => 'Ventas',
                'tipo' => Transaccion::TIPO_INGRESO,
                'monto' => 450000.00,
                'fecha' => now()->subDays(8)->toDateString(),
                'descripcion' => 'Venta de servicios facturados del mes.',
            ],
            [
                'cuenta' => $cuentaBanco,
                'categoria' => 'Arriendo',
                'tipo' => Transaccion::TIPO_GASTO,
                'monto' => 300000.00,
                'fecha' => now()->subDays(3)->toDateString(),
                'descripcion' => 'Arriendo de la oficina.',
            ],
            [
                'cuenta' => $cuentaAhorros,
                'categoria' => 'Papelería',
                'tipo' => Transaccion::TIPO_GASTO,
                'monto' => 45000.00,
                'fecha' => now()->subDay()->toDateString(),
                'descripcion' => 'Compra de insumos de oficina.',
            ],
        ];

        foreach ($movimientos as $movimiento) {
            /** @var Categoria $categoria */
            $categoria = Categoria::query()
                ->where('nombre', $movimiento['categoria'])
                ->where('tipo', $movimiento['tipo'])
                ->firstOrFail();

            $gestorSaldo->registrar([
                'cuenta_id' => $movimiento['cuenta']->getKey(),
                'categoria_id' => $categoria->getKey(),
                'tipo' => $movimiento['tipo'],
                'monto' => $movimiento['monto'],
                'fecha' => $movimiento['fecha'],
                'descripcion' => $movimiento['descripcion'],
                'creado_por' => $creadoPor,
            ]);
        }
    }
}
