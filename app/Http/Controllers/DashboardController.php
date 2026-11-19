<?php

namespace App\Http\Controllers;

use App\Models\Cuenta;
use App\Models\Transaccion;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Panel general con el resumen financiero.
     */
    public function __invoke(): View
    {
        $saldoTotal = (float) Cuenta::query()->sum('saldo');
        $totalCuentas = Cuenta::query()->count();

        $totalIngresos = (float) Transaccion::query()->where('tipo', Transaccion::TIPO_INGRESO)->sum('monto');
        $totalGastos = (float) Transaccion::query()->where('tipo', Transaccion::TIPO_GASTO)->sum('monto');

        $cantidadIngresos = Transaccion::query()->where('tipo', Transaccion::TIPO_INGRESO)->count();
        $cantidadGastos = Transaccion::query()->where('tipo', Transaccion::TIPO_GASTO)->count();

        $ultimasTransacciones = Transaccion::query()
            ->with(['cuenta', 'categoria'])
            ->orderByDesc('fecha')
            ->orderByDesc('id')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'saldoTotal',
            'totalCuentas',
            'totalIngresos',
            'totalGastos',
            'cantidadIngresos',
            'cantidadGastos',
            'ultimasTransacciones',
        ));
    }
}
