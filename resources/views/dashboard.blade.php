<x-app-layout>
    <x-slot name="header">
        <x-page-header
            eyebrow="Resumen · {{ now()->format('d/m/Y') }}"
            title="Panel general"
            description="El estado de tus cuentas y tus últimos movimientos, en una sola vista.">
            <x-slot:actions>
                <a href="{{ route('transacciones.index') }}" class="btn-secondary btn-md">
                    Ver transacciones
                </a>
                <a href="{{ route('transacciones.create') }}" class="btn-primary btn-md">
                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14M5 12h14" />
                    </svg>
                    Nuevo movimiento
                </a>
            </x-slot:actions>
        </x-page-header>
    </x-slot>

    <div class="space-y-5">
        {{-- KPI strip --}}
        <section class="grid overflow-hidden rounded-xl border border-neutral-200 bg-neutral-200 sm:grid-cols-2 lg:grid-cols-4 dark:border-neutral-800 dark:bg-neutral-800" aria-label="Resumen financiero">
            <div class="bg-white p-4 sm:p-5 dark:bg-neutral-900">
                <p class="stat-label">Saldo total</p>
                <div class="mt-2 flex items-baseline gap-1.5">
                    <span class="font-mono text-[1.5rem] font-semibold tabular-nums tracking-tight text-neutral-900 dark:text-neutral-50">
                        {{ number_format((float) $saldoTotal, 2, ',', '.') }}
                    </span>
                    <span class="text-[0.6875rem] font-medium uppercase tracking-[0.08em] text-neutral-400">COP</span>
                </div>
                <p class="mt-1 text-[0.75rem] text-neutral-500 dark:text-neutral-400">
                    En {{ $totalCuentas }} {{ $totalCuentas === 1 ? 'cuenta registrada' : 'cuentas registradas' }}
                </p>
            </div>

            <div class="bg-white p-4 sm:p-5 dark:bg-neutral-900">
                <p class="stat-label">Ingresos totales</p>
                <div class="mt-2 flex items-baseline gap-1.5">
                    <span class="font-mono text-[1.25rem] sm:text-kpi-sm font-semibold tabular-nums tracking-tight text-income-700 dark:text-neutral-300">
                        +{{ number_format((float) $totalIngresos, 2, ',', '.') }}
                    </span>
                    <span class="text-[0.6875rem] font-medium uppercase tracking-[0.08em] text-neutral-400">COP</span>
                </div>
                <p class="mt-1 text-[0.75rem] text-neutral-500 dark:text-neutral-400">
                    {{ $cantidadIngresos }} {{ $cantidadIngresos === 1 ? 'movimiento' : 'movimientos' }}
                </p>
            </div>

            <div class="bg-white p-4 sm:p-5 dark:bg-neutral-900">
                <p class="stat-label">Gastos totales</p>
                <div class="mt-2 flex items-baseline gap-1.5">
                    <span class="font-mono text-[1.25rem] sm:text-kpi-sm font-semibold tabular-nums tracking-tight text-expense-700 dark:text-expense-300">
                        −{{ number_format((float) $totalGastos, 2, ',', '.') }}
                    </span>
                    <span class="text-[0.6875rem] font-medium uppercase tracking-[0.08em] text-neutral-400">COP</span>
                </div>
                <p class="mt-1 text-[0.75rem] text-neutral-500 dark:text-neutral-400">
                    {{ $cantidadGastos }} {{ $cantidadGastos === 1 ? 'movimiento' : 'movimientos' }}
                </p>
            </div>

            @php($neto = (float) $totalIngresos - (float) $totalGastos)
            <div class="bg-white p-4 sm:p-5 dark:bg-neutral-900">
                <p class="stat-label">Balance neto</p>
                <div class="mt-2 flex items-baseline gap-1.5">
                    <span class="font-mono text-[1.25rem] sm:text-kpi-sm font-semibold tabular-nums tracking-tight {{ $neto >= 0 ? 'text-neutral-900 dark:text-neutral-50' : 'text-expense-700 dark:text-expense-300' }}">
                        {{ $neto >= 0 ? '+' : '−' }}{{ number_format(abs($neto), 2, ',', '.') }}
                    </span>
                    <span class="text-[0.6875rem] font-medium uppercase tracking-[0.08em] text-neutral-400">COP</span>
                </div>
                <p class="mt-1 text-[0.75rem] text-neutral-500 dark:text-neutral-400">Ingresos menos gastos</p>
            </div>
        </section>

        {{-- Cashflow chart --}}
        <section class="card overflow-hidden">
            <div class="flex flex-wrap items-start justify-between gap-4 border-b border-neutral-200 px-5 py-4 dark:border-neutral-800">
                <div>
                    <h2 class="section-title">Flujo de efectivo</h2>
                    <p class="mt-0.5 text-[0.75rem] text-neutral-500 dark:text-neutral-400">Ingresos y gastos de los últimos seis meses.</p>
                </div>
                <div class="flex items-center gap-4 text-[0.6875rem] text-neutral-500 dark:text-neutral-400">
                    <span class="inline-flex items-center gap-1.5">
                        <span class="h-1.5 w-4 rounded-full bg-income-600 dark:bg-[#55705f]"></span>
                        Ingresos
                    </span>
                    <span class="inline-flex items-center gap-1.5">
                        <span class="h-1.5 w-4 rounded-full bg-expense-600"></span>
                        Gastos
                    </span>
                </div>
            </div>
            <div class="h-56 px-3 pb-2 pt-4 sm:h-64 sm:px-5">
                <div data-cashflow-chart
                     data-series="{{ json_encode($grafica, JSON_UNESCAPED_UNICODE) }}"
                     class="h-full w-full"></div>
            </div>
        </section>

        <div class="grid gap-5 lg:grid-cols-[minmax(0,1.7fr)_minmax(0,1fr)]">
            {{-- Recent transactions --}}
            <section class="card overflow-hidden">
                <div class="flex items-center justify-between gap-4 border-b border-neutral-200 px-5 py-4 dark:border-neutral-800">
                    <h2 class="section-title">Últimos movimientos</h2>
                    <a href="{{ route('transacciones.index') }}" class="group inline-flex items-center gap-1 text-[0.75rem] font-medium text-neutral-600 transition-colors hover:text-brand-700 dark:text-neutral-400 dark:hover:text-neutral-100">
                        Ver todas
                        <svg class="h-3.5 w-3.5 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>

                @if ($ultimasTransacciones->isEmpty())
                    <x-empty-state
                        title="Todavía no hay movimientos"
                        description="Registra tu primer ingreso o gasto para ver el historial y el efecto en tus saldos."
                        icon="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        <a href="{{ route('transacciones.create') }}" class="btn-primary btn-sm">Registrar movimiento</a>
                    </x-empty-state>
                @else
                    <div class="table-container">
                        <table class="table table-stack">
                            <thead>
                                <tr>
                                    <th scope="col">Movimiento</th>
                                    <th scope="col" class="w-28">Fecha</th>
                                    <th scope="col" class="w-28">Tipo</th>
                                    <th scope="col" class="w-40 text-right">Monto</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ultimasTransacciones as $transaccion)
                                    <tr>
                                        <td class="table-stack-primary" data-label="">
                                            <div class="flex items-center gap-2.5">
                                                <span class="icon-chip {{ $transaccion->esIngreso() ? 'icon-chip-income' : 'icon-chip-expense' }}">
                                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="{{ $transaccion->esIngreso() ? 'M5 10l7-7m0 0l7 7m-7-7v18' : 'M19 10l-7 7m0 0l-7-7m7-7v18' }}" />
                                                    </svg>
                                                </span>
                                                <div class="min-w-0">
                                                    <p class="truncate text-[0.8125rem] font-medium text-neutral-900 dark:text-neutral-50">{{ $transaccion->cuenta->nombre }}</p>
                                                    <p class="truncate text-[0.6875rem] text-neutral-500 dark:text-neutral-400">{{ $transaccion->categoria->nombre }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="cell-muted whitespace-nowrap text-[0.75rem]" data-label="Fecha">
                                            {{ $transaccion->fecha->format('d/m/Y') }}
                                        </td>
                                        <td data-label="Tipo">
                                            <x-type-badge :tipo="$transaccion->tipo" />
                                        </td>
                                        <td class="cell-amount font-medium {{ $transaccion->esIngreso() ? '!text-income-700 dark:!text-neutral-300' : '!text-expense-700 dark:!text-expense-300' }}" data-label="Monto">
                                            {{ $transaccion->esIngreso() ? '+' : '−' }}{{ number_format((float) $transaccion->monto, 2, ',', '.') }}
                                            <span class="ml-0.5 text-[0.625rem] font-normal text-neutral-400">{{ $transaccion->cuenta->moneda }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </section>

            {{-- Accounts --}}
            <aside class="space-y-4">
                <section class="card overflow-hidden">
                    <div class="flex items-center justify-between gap-3 border-b border-neutral-200 px-5 py-4 dark:border-neutral-800">
                        <h2 class="section-title">Cuentas</h2>
                        <a href="{{ route('cuentas.index') }}" class="text-[0.75rem] font-medium text-neutral-600 transition-colors hover:text-brand-700 dark:text-neutral-400 dark:hover:text-neutral-100">
                            Gestionar
                        </a>
                    </div>

                    @if ($cuentas->isEmpty())
                        <x-empty-state
                            title="Sin cuentas"
                            description="Crea una cuenta para empezar a registrar movimientos."
                            icon="M3 10h18M5 6h14a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2z">
                            <a href="{{ route('cuentas.create') }}" class="btn-primary btn-sm">Crear cuenta</a>
                        </x-empty-state>
                    @else
                        <ul class="divide-y divide-neutral-100 dark:divide-neutral-800">
                            @foreach ($cuentas as $cuenta)
                                <li class="flex items-center justify-between gap-3 px-5 py-3">
                                    <div class="flex min-w-0 items-center gap-2.5">
                                        <span class="icon-chip">
                                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 10h18M5 6h14a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2z" />
                                            </svg>
                                        </span>
                                        <div class="min-w-0">
                                            <p class="truncate text-[0.8125rem] font-medium text-neutral-900 dark:text-neutral-50">{{ $cuenta->nombre }}</p>
                                            <p class="text-[0.6875rem] text-neutral-500 dark:text-neutral-400">
                                                {{ $cuenta->transacciones_count }} {{ $cuenta->transacciones_count === 1 ? 'movimiento' : 'movimientos' }}
                                                <span class="mx-1 text-neutral-300 dark:text-neutral-600">·</span>
                                                {{ $cuenta->moneda }}
                                            </p>
                                        </div>
                                    </div>
                                    <span class="shrink-0 font-mono text-[0.75rem] tabular-nums {{ (float) $cuenta->saldo < 0 ? 'text-expense-700 dark:text-expense-300' : 'text-neutral-700 dark:text-neutral-300' }}">
                                        {{ $cuenta->saldoFormateado() }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>

                        <div class="border-t border-neutral-200 p-3 dark:border-neutral-800">
                            <a href="{{ route('cuentas.create') }}" class="btn-secondary btn-sm w-full">
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14M5 12h14" />
                                </svg>
                                Añadir cuenta
                            </a>
                        </div>
                    @endif
                </section>
            </aside>
        </div>
    </div>
</x-app-layout>