<x-app-layout>
    <x-slot name="header">
        <x-page-header
            eyebrow="Movimientos"
            title="Transacciones"
            description="{{ $totalTransacciones }} {{ $totalTransacciones === 1 ? 'movimiento registrado' : 'movimientos registrados' }} entre ingresos y gastos.">
            <x-slot:actions>
                <a href="{{ route('transacciones.create') }}" class="btn-primary btn-md">
                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14M5 12h14" />
                    </svg>
                    Nueva transacción
                </a>
            </x-slot:actions>
        </x-page-header>
    </x-slot>

    <div class="card overflow-hidden">
        <form method="GET" action="{{ route('transacciones.index') }}" class="toolbar lg:flex-row lg:items-center">
            <div class="toolbar-field">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z" />
                </svg>
                <label for="filter_search" class="sr-only">Buscar transacciones</label>
                <input type="search"
                       name="search"
                       id="filter_search"
                       value="{{ request('search') }}"
                       placeholder="Buscar por descripción"
                       class="toolbar-input"
                       onkeydown="if(event.key==='Enter') this.form.submit()">
            </div>

            <div class="grid grid-cols-2 gap-2 sm:flex sm:items-center">
                <div class="sm:w-36">
                    <label for="filter_tipo" class="sr-only">Filtrar por tipo</label>
                    <select name="tipo" id="filter_tipo" class="input py-2" onchange="this.form.submit()">
                        <option value="">Todos los tipos</option>
                        <option value="ingreso" @selected(request('tipo') === 'ingreso')>Ingresos</option>
                        <option value="gasto" @selected(request('tipo') === 'gasto')>Gastos</option>
                    </select>
                </div>

                <div class="sm:w-44">
                    <label for="filter_cuenta" class="sr-only">Filtrar por cuenta</label>
                    <select name="cuenta_id" id="filter_cuenta" class="input py-2" onchange="this.form.submit()">
                        <option value="">Todas las cuentas</option>
                        @foreach ($cuentas as $cuenta)
                            <option value="{{ $cuenta->id }}" @selected((string) request('cuenta_id') === (string) $cuenta->id)>
                                {{ $cuenta->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <button type="submit" class="btn-secondary btn-sm">Filtrar</button>
                @if (request()->filled('search') || request()->filled('tipo') || request()->filled('cuenta_id'))
                    <a href="{{ route('transacciones.index') }}" class="btn-ghost btn-sm">Limpiar</a>
                @endif
            </div>
        </form>

        @if ($transacciones->isEmpty())
            @if (request()->filled('search') || request()->filled('tipo') || request()->filled('cuenta_id'))
                <x-empty-state
                    title="Sin resultados"
                    description="No hay movimientos que coincidan con los filtros seleccionados."
                    icon="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z">
                    <a href="{{ route('transacciones.index') }}" class="btn-secondary btn-sm">Quitar filtros</a>
                </x-empty-state>
            @else
                <x-empty-state
                    title="Aún no hay transacciones"
                    description="Registra tu primer ingreso o gasto para empezar a ver el historial y el efecto en los saldos."
                    icon="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                    <a href="{{ route('transacciones.create') }}" class="btn-primary btn-sm">Registrar transacción</a>
                </x-empty-state>
            @endif
        @else
            <div class="table-container">
                <table class="table table-stack">
                    <thead>
                        <tr>
                            <th scope="col">Movimiento</th>
                            <th scope="col" class="w-28">Fecha</th>
                            <th scope="col" class="w-28">Tipo</th>
                            <th scope="col" class="w-40 text-right">Monto</th>
                            <th scope="col" class="w-36">Registrado por</th>
                            <th scope="col" class="w-24 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transacciones as $transaccion)
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
                                            <p class="line-clamp-2 text-[0.6875rem] text-neutral-500 sm:line-clamp-1 dark:text-neutral-400">
                                                {{ $transaccion->categoria->nombre }}
                                                @if ($transaccion->descripcion)
                                                    <span class="mx-1 text-neutral-300 dark:text-neutral-600">·</span>
                                                    {{ $transaccion->descripcion }}
                                                @endif
                                            </p>
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
                                <td class="cell-muted text-[0.75rem]" data-label="Registrado por">
                                    {{ $transaccion->creado_por ?: '—' }}
                                </td>
                                <td class="table-stack-actions" data-label="">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('transacciones.edit', $transaccion) }}"
                                           class="btn-ghost btn-sm btn-icon text-neutral-500 hover:text-neutral-900 dark:text-neutral-400 dark:hover:text-neutral-100"
                                           aria-label="Editar transacción de {{ $transaccion->montoFormateado() }}"
                                           title="Editar transacción">
                                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M11 5a2 2 0 10-4 0v3.586a1 1 0 00.293.707l3 3a1 1 0 001.414 0l1.586-1.586a1 1 0 000-1.414L12.414 8.999A1 1 0 0012.121 8.28L10.707 6.872A1 1 0 0010 6.586V5z" />
                                            </svg>
                                        </a>
                                        <form method="POST"
                                              action="{{ route('transacciones.destroy', $transaccion) }}"
                                              class="inline"
                                              onsubmit="return confirm('¿Eliminar esta transacción? El saldo de la cuenta se revertirá automáticamente.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn-ghost btn-sm btn-icon text-neutral-400 hover:bg-expense-50 hover:text-expense-600 dark:text-neutral-500 dark:hover:bg-expense-500/10 dark:hover:text-expense-400"
                                                    aria-label="Eliminar transacción de {{ $transaccion->montoFormateado() }}"
                                                    title="Eliminar transacción">
                                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="flex flex-col gap-3 border-t border-neutral-200 px-4 py-3 sm:flex-row sm:items-center sm:justify-between dark:border-neutral-800">
                <p class="text-[0.75rem] text-neutral-500 dark:text-neutral-400">
                    Mostrando {{ $transacciones->firstItem() }}–{{ $transacciones->lastItem() }} de {{ $transacciones->total() }}
                </p>
                {{ $transacciones->links() }}
            </div>
        @endif
    </div>
</x-app-layout>