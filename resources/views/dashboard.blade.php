<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Panel general</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm font-medium text-gray-500">Saldo total de cuentas</p>
                    <p class="mt-2 text-2xl font-semibold text-gray-900">
                        {{ number_format((float) $saldoTotal, 2, ',', '.') }} COP
                    </p>
                    <p class="mt-1 text-xs text-gray-500">{{ $totalCuentas }} cuenta(s) registrada(s)</p>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm font-medium text-gray-500">Ingresos registrados</p>
                    <p class="mt-2 text-2xl font-semibold text-green-700">
                        {{ number_format((float) $totalIngresos, 2, ',', '.') }} COP
                    </p>
                    <p class="mt-1 text-xs text-gray-500">{{ $cantidadIngresos }} movimiento(s)</p>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm font-medium text-gray-500">Gastos registrados</p>
                    <p class="mt-2 text-2xl font-semibold text-red-700">
                        {{ number_format((float) $totalGastos, 2, ',', '.') }} COP
                    </p>
                    <p class="mt-1 text-xs text-gray-500">{{ $cantidadGastos }} movimiento(s)</p>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="font-semibold text-gray-900">Últimos movimientos</h3>

                    @if ($ultimasTransacciones->isEmpty())
                        <p class="mt-3 text-sm text-gray-600">Todavía no hay movimientos registrados.</p>
                    @else
                        <div class="mt-4 overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 text-sm">
                                <thead>
                                    <tr class="text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                        <th class="px-3 py-3">Fecha</th>
                                        <th class="px-3 py-3">Cuenta</th>
                                        <th class="px-3 py-3">Categoría</th>
                                        <th class="px-3 py-3">Tipo</th>
                                        <th class="px-3 py-3 text-right">Monto</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach ($ultimasTransacciones as $transaccion)
                                        <tr>
                                            <td class="px-3 py-3 text-gray-700">{{ $transaccion->fecha->format('d/m/Y') }}</td>
                                            <td class="px-3 py-3 font-medium text-gray-900">{{ $transaccion->cuenta->nombre }}</td>
                                            <td class="px-3 py-3 text-gray-700">{{ $transaccion->categoria->nombre }}</td>
                                            <td class="px-3 py-3">
                                                @if ($transaccion->esIngreso())
                                                    <span class="inline-flex rounded-full bg-green-100 px-2 py-1 text-xs font-semibold text-green-800">Ingreso</span>
                                                @else
                                                    <span class="inline-flex rounded-full bg-red-100 px-2 py-1 text-xs font-semibold text-red-800">Gasto</span>
                                                @endif
                                            </td>
                                            <td class="px-3 py-3 text-right font-semibold {{ $transaccion->esIngreso() ? 'text-green-700' : 'text-red-700' }}">
                                                {{ $transaccion->esIngreso() ? '+' : '−' }}{{ number_format((float) $transaccion->monto, 2, ',', '.') }} {{ $transaccion->cuenta->moneda }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            <div class="flex flex-wrap gap-3">
                <a href="{{ route('transacciones.create') }}"
                   class="inline-flex items-center rounded-md bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white hover:bg-gray-700">
                    Registrar transacción
                </a>
                <a href="{{ route('cuentas.index') }}"
                   class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 hover:bg-gray-50">
                    Ver cuentas
                </a>
                <a href="{{ route('categorias.index') }}"
                   class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 hover:bg-gray-50">
                    Ver categorías
                </a>
            </div>
        </div>
    </div>
</x-app-layout>