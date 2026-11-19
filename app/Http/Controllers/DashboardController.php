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
            ->limit(6)
            ->get();

        $cuentas = Cuenta::query()
            ->withCount('transacciones')
            ->orderByDesc('saldo')
            ->get();

        $grafica = $this->flujoMensual();

        return view('dashboard', compact(
            'saldoTotal',
            'totalCuentas',
            'totalIngresos',
            'totalGastos',
            'cantidadIngresos',
            'cantidadGastos',
            'ultimasTransacciones',
            'cuentas',
            'grafica',
        ));
    }

    /**
     * Ingresos y gastos de los últimos seis meses para la gráfica del panel.
     *
     * @return array<int, array{etiqueta: string, ingresos: float, gastos: float}>
     */
    private function flujoMensual(): array
    {
        $meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];

        $movimientos = Transaccion::query()
            ->where('fecha', '>=', now()->startOfMonth()->subMonths(5)->toDateString())
            ->get(['fecha', 'tipo', 'monto']);

        return collect(range(5, 0))
            ->map(function (int $offset) use ($meses, $movimientos): array {
                $mes = now()->startOfMonth()->subMonths($offset);
                $clave = $mes->format('Y-m');
                $delMes = $movimientos->filter(
                    fn (Transaccion $transaccion): bool => $transaccion->fecha->format('Y-m') === $clave
                );

                return [
                    'etiqueta' => $meses[$mes->month - 1],
                    'ingresos' => (float) $delMes->where('tipo', Transaccion::TIPO_INGRESO)->sum('monto'),
                    'gastos' => (float) $delMes->where('tipo', Transaccion::TIPO_GASTO)->sum('monto'),
                ];
            })
            ->all();
    }
}
