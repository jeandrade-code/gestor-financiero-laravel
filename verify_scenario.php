<?php

use App\Models\Categoria;
use App\Models\Cuenta;
use App\Models\Transaccion;

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== PRUEBA DEL ESCENARIO DEL PDF ===\n";
// Crear cuenta de prueba con 200.000
$cuenta = Cuenta::firstOrCreate(
    ['nombre' => 'Cuenta PDF Test'],
    ['descripcion' => 'Prueba del caso PDF', 'saldo' => 200000.00, 'moneda' => 'COP']
);
echo 'Saldo inicial: '.$cuenta->saldoFormateado()."\n";

// Ingreso 150.000
$catIngreso = Categoria::where('tipo', 'ingreso')->first();
$t1 = Transaccion::create([
    'cuenta_id' => $cuenta->id,
    'categoria_id' => $catIngreso->id,
    'tipo' => 'ingreso',
    'monto' => 150000.00,
    'fecha' => now()->toDateString(),
    'descripcion' => 'Ingreso prueba PDF',
    'creado_por' => 'Test',
]);
$cuenta->refresh();
echo 'Tras ingreso 150.000: '.$cuenta->saldoFormateado()."\n";

// Gasto 20.000
$catGasto = Categoria::where('tipo', 'gasto')->first();
$t2 = Transaccion::create([
    'cuenta_id' => $cuenta->id,
    'categoria_id' => $catGasto->id,
    'tipo' => 'gasto',
    'monto' => 20000.00,
    'fecha' => now()->toDateString(),
    'descripcion' => 'Gasto prueba PDF',
    'creado_por' => 'Test',
]);
$cuenta->refresh();
echo 'Tras gasto 20.000: '.$cuenta->saldoFormateado()."\n";

echo "\nESPERADO: 330.000 COP\n";
echo 'OK: '.($cuenta->saldo == 330000.00 ? 'SÍ' : 'NO')."\n";

// Limpieza
$t1->delete();
$t2->delete();
$cuenta->delete();
