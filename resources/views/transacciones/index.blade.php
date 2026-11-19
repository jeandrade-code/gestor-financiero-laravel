<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-heading-lg text-neutral-900 dark:text-neutral-50">Transacciones</h2>
                <p class="text-body text-neutral-600 dark:text-neutral-400 mt-1">Historial de ingresos y gastos</p>
            </div>
            <a href="{{ route('transacciones.create') }}" class="btn-primary btn-md">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Nueva transacción
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- Filters -->
        <div class="card p-4 animate-in">
            <form method="GET" action="{{ route('transacciones.index') }}" class="flex flex-col sm:flex-row gap-4">
                <div class="sm:w-48">
                    <label for="filter_tipo" class="sr-only">Filtrar por tipo</label>
                    <select name="tipo"
                            id="filter_tipo"
                            class="input"
                            onchange="this.form.submit()">
                        <option value="">Todos los tipos</option>
                        <option value="ingreso" {{ request('tipo') === 'ingreso' ? 'selected' : '' }}>Ingresos</option>
                        <option value="gasto" {{ request('tipo') === 'gasto' ? 'selected' : '' }}>Gastos</option>
                    </select>
                </div>
                <div class="sm:w-64">
                    <label for="filter_cuenta" class="sr-only">Filtrar por cuenta</label>
                    <select name="cuenta_id"
                            id="filter_cuenta"
                            class="input"
                            onchange="this.form.submit()">
                        <option value="">Todas las cuentas</option>
                        @foreach ($cuentas as $cuenta)
                            <option value="{{ $cuenta->id }}" {{ request('cuenta_id') == $cuenta->id ? 'selected' : '' }}>
                                {{ $cuenta->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex-1">
                    <label for="filter_search" class="sr-only">Buscar</label>
                    <input type="search"
                           name="search"
                           id="filter_search"
                           value="{{ request('search') }}"
                           placeholder="Buscar por descripción..."
                           class="input"
                           onkeydown="if(event.key==='Enter') this.form.submit()">
                </div>
            </form>
        </div>

        <!-- Transactions Table -->
        <div class="card overflow-hidden animate-in stagger-1">
            @if ($transacciones->isEmpty())
                <div class="card-body text-center py-12">
                    <svg class="w-12 h-12 mx-auto text-neutral-300 dark:text-neutral-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                    <p class="text-body text-neutral-600 dark:text-neutral-400 mb-2">No hay transacciones registradas</p>
                    <p class="text-caption text-neutral-500 dark:text-neutral-400 mb-4">Registra tu primer movimiento para comenzar</p>
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
                                <th scope="col" class="w-28">Fecha</th>
                                <th scope="col">Cuenta</th>
                                <th scope="col">Categoría</th>
                                <th scope="col" class="w-28">Tipo</th>
                                <th scope="col" class="w-40 text-right">Monto</th>
                                <th scope="col">Descripción</th>
                                <th scope="col" class="w-36">Registrado por</th>
                                <th scope="col" class="w-28 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-100 dark:divide-neutral-800">
                            @foreach ($transacciones as $index => $transaccion)
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
                                    <td class="text-body-sm text-neutral-600 dark:text-neutral-400 max-w-xs truncate">{{ $transaccion->descripcion ?? '—' }}</td>
                                    <td class="text-body-sm text-neutral-600 dark:text-neutral-400">{{ $transaccion->creado_por ?? '—' }}</td>
                                    <td class="text-right">
                                        <div class="flex items-center justify-end gap-1">
                                            <a href="{{ route('transacciones.edit', $transaccion) }}"
                                               class="btn-ghost btn-sm btn-icon"
                                               aria-label="Editar transacción de {{ $transaccion->montoFormateado() }}">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M11 5a2 2 0 10-4 0v3.586a1 1 0 00.293.707l3 3a1 1 0 001.414 0l1.586-1.586a1 1 0 000-1.414L12.414 8.999A1 1 0 0012.121 8.28L10.707 6.872A1 1 0 0010 6.586V5z"/>
                                                </svg>
                                            </a>
                                            <form method="POST"
                                                  action="{{ route('transacciones.destroy', $transaccion) }}"
                                                  class="inline"
                                                  onsubmit="return confirm('¿Seguro que deseas eliminar esta transacción? El saldo de la cuenta se revertirá automáticamente.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="btn-ghost btn-sm btn-icon text-expense-600 dark:text-expense-400 hover:bg-expense-50 dark:hover:bg-expense-900/20"
                                                        aria-label="Eliminar transacción de {{ $transaccion->montoFormateado() }}">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
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

                <!-- Pagination -->
                <div class="card-footer flex items-center justify-between">
                    <p class="text-body-sm text-neutral-600 dark:text-neutral-400">
                        Mostrando {{ $transacciones->firstItem() }} a {{ $transacciones->lastItem() }} de {{ $transacciones->total() }} transacción{{ $transacciones->total() !== 1 ? 'es' : '' }}
                    </p>
                    {{ $transacciones->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>