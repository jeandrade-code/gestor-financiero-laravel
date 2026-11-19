<?php

use App\Models\Categoria;
use App\Models\Cuenta;
use App\Models\Transaccion;

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== ESTRUCTURA DE TABLAS ===\n";
$cols = DB::select('SHOW COLUMNS FROM categorias');
foreach ($cols as $c) {
    echo "categorias: {$c->Field} | {$c->Type} | {$c->Null} | {$c->Key} | {$c->Default}\n";
}

$cols = DB::select('SHOW COLUMNS FROM cuentas');
foreach ($cols as $c) {
    echo "cuentas: {$c->Field} | {$c->Type} | {$c->Null} | {$c->Key} | {$c->Default}\n";
}

$cols = DB::select('SHOW COLUMNS FROM transacciones');
foreach ($cols as $c) {
    echo "transacciones: {$c->Field} | {$c->Type} | {$c->Null} | {$c->Key} | {$c->Default}\n";
}

echo "\n=== FOREIGN KEYS ===\n";
$fks = DB::select("
    SELECT kcu.TABLE_NAME, kcu.COLUMN_NAME, kcu.REFERENCED_TABLE_NAME, kcu.REFERENCED_COLUMN_NAME, rc.DELETE_RULE
    FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE kcu
    JOIN INFORMATION_SCHEMA.REFERENTIAL_CONSTRAINTS rc ON kcu.CONSTRAINT_NAME = rc.CONSTRAINT_NAME
    WHERE kcu.REFERENCED_TABLE_SCHEMA = 'gestor_financiero' AND kcu.REFERENCED_TABLE_NAME IS NOT NULL
");
foreach ($fks as $fk) {
    echo "{$fk->TABLE_NAME}.{$fk->COLUMN_NAME} -> {$fk->REFERENCED_TABLE_NAME}.{$fk->REFERENCED_COLUMN_NAME} | ON DELETE {$fk->DELETE_RULE}\n";
}

echo "\n=== DATOS DE PRUEBA ===\n";
echo 'Categorías: '.Categoria::count()."\n";
foreach (Categoria::all() as $c) {
    echo "  - {$c->nombre} ({$c->tipo})\n";
}
echo 'Cuentas: '.Cuenta::count()."\n";
foreach (Cuenta::all() as $c) {
    echo "  - {$c->nombre}: {$c->saldoFormateado()}\n";
}
echo 'Transacciones: '.Transaccion::count()."\n";
foreach (Transaccion::with(['cuenta', 'categoria'])->get() as $t) {
    echo "  - {$t->cuenta->nombre} / {$t->categoria->nombre} / {$t->tipo} / {$t->montoFormateado()} / {$t->fecha}\n";
}
