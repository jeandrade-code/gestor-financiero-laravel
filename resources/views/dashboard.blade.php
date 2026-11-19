<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-heading-lg text-neutral-900 dark:text-neutral-50">Panel general</h2>
                <p class="text-body text-neutral-600 dark:text-neutral-400 mt-1">Bienvenido de nuevo, {{ auth()->user()->name }}</p>
            </div>
            <a href="{{ route('transacciones.create') }}" class="btn-primary btn-md">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Nueva transacción
            </a>
        </div>
    </x-slot>

    <div class="space-y-8">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5" role="region" aria-label="Resumen financiero">
            <!-- Total Balance -->
            <article class="card card-hover p-6 animate-in stagger-1">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex-1 min-w-0">
                        <p class="text-caption font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider mb-2">Saldo total</p>
                        <p class="text-display-sm font-bold text-neutral-900 dark:text-neutral-50 tabular-nums">
                            {{ number_format((float) $saldoTotal, 2, ',', '.') }} COP
                        </p>
                        <p class="text-caption text-neutral-500 dark:text-neutral-400 mt-1">{{ $totalCuentas }} cuenta{{ $totalCuentas !== 1 ? 's' : '' }} registrada{{ $totalCuentas !== 1 ? 's' : '' }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-brand-100 dark:bg-brand-900/30 flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-brand-600 dark:text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </article>

            <!-- Total Income -->
            <article class="card card-hover p-6 animate-in stagger-2">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex-1 min-w-0">
                        <p class="text-caption font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider mb-2">Ingresos totales</p>
                        <p class="text-display-sm font-bold text-income-600 dark:text-income-400 tabular-nums">
                            +{{ number_format((float) $totalIngresos, 2, ',', '.') }} COP
                        </p>
                        <p class="text-caption text-neutral-500 dark:text-neutral-400 mt-1">{{ $cantidadIngresos }} movimiento{{ $cantidadIngresos !== 1 ? 's' : '' }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-income-100 dark:bg-income-900/30 flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-income-600 dark:text-income-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                        </svg>
                    </div>
                </div>
            </article>

            <!-- Total Expenses -->
            <article class="card card-hover p-6 animate-in stagger-3">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex-1 min-w-0">
                        <p class="text-caption font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider mb-2">Gastos totales</p>
                        <p class="text-display-sm font-bold text-expense-600 dark:text-expense-400 tabular-nums">
                            -{{ number_format((float) $totalGastos, 2, ',', '.') }} COP
                        </p>
                        <p class="text-caption text-neutral-500 dark:text-neutral-400 mt-1">{{ $cantidadGastos }} movimiento{{ $cantidadGastos !== 1 ? 's' : '' }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-expense-100 dark:bg-expense-900/30 flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-expense-600 dark:text-expense-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 10l-7 7m0 0l-7-7m7-7v18"/>
                        </svg>
                    </div>
                </div>
            </article>

            <!-- Net Balance -->
            <article class="card card-hover p-6 animate-in stagger-4">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex-1 min-w-0">
                        <p class="text-caption font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider mb-2">Balance neto</p>
                        <p class="text-display-sm font-bold {{ $totalIngresos - $totalGastos >= 0 ? 'text-income-600 dark:text-income-400' : 'text-expense-600 dark:text-expense-400' }} tabular-nums">
                            {{ $totalIngresos - $totalGastos >= 0 ? '+' : '' }}{{ number_format((float) ($totalIngresos - $totalGastos), 2, ',', '.') }} COP
                        </p>
                        <p class="text-caption text-neutral-500 dark:text-neutral-400 mt-1">Ingresos menos gastos</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl {{ $totalIngresos - $totalGastos >= 0 ? 'bg-income-100 dark:bg-income-900/30' : 'bg-expense-100 dark:bg-expense-900/30' }} flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 {{ $totalIngresos - $totalGastos >= 0 ? 'text-income-600 dark:text-income-400' : 'text-expense-600 dark:text-expense-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                </div>
            </article>
        </div>

        <!-- Quick Actions & Recent Transactions -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Quick Actions -->
            <aside class="lg:col-span-1 space-y-4 animate-in stagger-1">
                <h3 class="text-heading-sm text-neutral-900 dark:text-neutral-50">Acciones rápidas</h3>
                <nav class="space-y-2" aria-label="Acciones rápidas">
                    <a href="{{ route('transacciones.create') }}"
                       class="card-hover card p-4 flex items-center gap-4 group">
                        <div class="w-10 h-10 rounded-lg bg-brand-100 dark:bg-brand-900/30 flex items-center justify-center group-hover:scale-105 transition-transform duration-200">
                            <svg class="w-5 h-5 text-brand-600 dark:text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-body font-medium text-neutral-900 dark:text-neutral-50">Registrar movimiento</p>
                            <p class="text-caption text-neutral-500 dark:text-neutral-400">Ingreso o gasto</p>
                        </div>
                    </a>

                    <a href="{{ route('cuentas.create') }}"
                       class="card-hover card p-4 flex items-center gap-4 group">
                        <div class="w-10 h-10 rounded-lg bg-income-100 dark:bg-income-900/30 flex items-center justify-center group-hover:scale-105 transition-transform duration-200">
                            <svg class="w-5 h-5 text-income-600 dark:text-income-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-body font-medium text-neutral-900 dark:text-neutral-50">Añadir cuenta</p>
                            <p class="text-caption text-neutral-500 dark:text-neutral-400">Efectivo, banco, tarjeta</p>
                        </div>
                    </a>

                    <a href="{{ route('categorias.create') }}"
                       class="card-hover card p-4 flex items-center gap-4 group">
                        <div class="w-10 h-10 rounded-lg bg-warning-100 dark:bg-warning-900/30 flex items-center justify-center group-hover:scale-105 transition-transform duration-200">
                            <svg class="w-5 h-5 text-warning-600 dark:text-warning-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-body font-medium text-neutral-900 dark:text-neutral-50">Crear categoría</p>
                            <p class="text-caption text-neutral-500 dark:text-neutral-400">Organiza tus movimientos</p>
                        </div>
                    </a>

                    <a href="{{ route('cuentas.index') }}"
                       class="card-hover card p-4 flex items-center gap-4 group">
                        <div class="w-10 h-10 rounded-lg bg-neutral-100 dark:bg-neutral-800 flex items-center justify-center group-hover:scale-105 transition-transform duration-200">
                            <svg class="w-5 h-5 text-neutral-600 dark:text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-body font-medium text-neutral-900 dark:text-neutral-50">Ver todas las cuentas</p>
                            <p class="text-caption text-neutral-500 dark:text-neutral-400">Saldos y movimientos</p>
                        </div>
                    </a>
                </nav>
            </aside>

            <!-- Recent Transactions -->
            <section class="lg:col-span-2 animate-in stagger-2">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-4">
                    <h3 class="text-heading-sm text-neutral-900 dark:text-neutral-50">Últimos movimientos</h3>
                    <a href="{{ route('transacciones.index') }}"
                       class="btn-ghost btn-sm self-start">
                        Ver todos
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>

                <div class="card overflow-hidden">
                    @if ($ultimasTransacciones->isEmpty())
                        <div class="card-body text-center py-12">
                            <svg class="w-12 h-12 mx-auto text-neutral-300 dark:text-neutral-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                            </svg>
                            <p class="text-body text-neutral-600 dark:text-neutral-400 mb-2">No hay movimientos registrados</p>
                            <p class="text-caption text-neutral-500 dark:text-neutral-400 mb-4">Registra tu primera transacción para comenzar</p>
                            <a href="{{ route('transacciones.create') }}" class="btn-primary btn-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Registrar transacción
                            </a>
                        </div>
                    @else
                        <div class="table-container">
                            <table class="table" role="table">
                                <thead>
                                    <tr>
                                        <th scope="col" class="w-24">Fecha</th>
                                        <th scope="col">Cuenta</th>
                                        <th scope="col">Categoría</th>
                                        <th scope="col" class="w-28">Tipo</th>
                                        <th scope="col" class="w-36 text-right">Monto</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-neutral-100 dark:divide-neutral-800">
                                    @foreach ($ultimasTransacciones as $index => $transaccion)
                                        <tr class="animate-in stagger-{{ min($index + 1, 6) }}">
                                            <td class="text-body-sm text-neutral-600 dark:text-neutral-400 whitespace-nowrap">
                                                {{ $transaccion->fecha->format('d/m/Y') }}
                                            </td>
                                            <td class="text-body-sm font-medium text-neutral-900 dark:text-neutral-50">
                                                {{ $transaccion->cuenta->nombre }}
                                            </td>
                                            <td class="text-body-sm text-neutral-600 dark:text-neutral-400">
                                                {{ $transaccion->categoria->nombre }}
                                            </td>
                                            <td>
                                                @if ($transaccion->esIngreso())
                                                    <span class="badge badge-success">Ingreso</span>
                                                @else
                                                    <span class="badge badge-destructive">Gasto</span>
                                                @endif
                                            </td>
                                            <td class="text-right font-mono text-body-sm tabular-nums {{ $transaccion->esIngreso() ? 'text-income-600 dark:text-income-400' : 'text-expense-600 dark:text-expense-400' }} font-semibold">
                                                {{ $transaccion->esIngreso() ? '+' : '−' }}{{ number_format((float) $transaccion->monto, 2, ',', '.') }} {{ $transaccion->cuenta->moneda }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </section>
        </div>
    </div>
</x-app-layout>