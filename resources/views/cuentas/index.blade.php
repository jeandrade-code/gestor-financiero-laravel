<x-app-layout>
    <x-slot name="header">
        <x-page-header
            eyebrow="Patrimonio"
            title="Cuentas"
            description="{{ $totalCuentas }} {{ $totalCuentas === 1 ? 'cuenta registrada' : 'cuentas registradas' }} · saldo total {{ number_format($saldoTotal, 2, ',', '.') }} COP.">
            <x-slot:actions>
                <a href="{{ route('cuentas.create') }}" class="btn-primary btn-md">
                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14M5 12h14" />
                    </svg>
                    Nueva cuenta
                </a>
            </x-slot:actions>
        </x-page-header>
    </x-slot>

    <div class="space-y-5">
        <form method="GET" action="{{ route('cuentas.index') }}" class="flex flex-col gap-2 sm:flex-row sm:items-center">
            <div class="relative w-full sm:max-w-xs">
                <svg class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z" />
                </svg>
                <label for="filter_search" class="sr-only">Buscar cuentas</label>
                <input type="search"
                       name="search"
                       id="filter_search"
                       value="{{ request('search') }}"
                       placeholder="Buscar por nombre"
                       class="input py-2 pl-9"
                       onkeydown="if(event.key==='Enter') this.form.submit()">
            </div>
            <button type="submit" class="btn-secondary btn-sm self-start sm:self-auto">Buscar</button>
            @if (request()->filled('search'))
                <a href="{{ route('cuentas.index') }}" class="btn-ghost btn-sm self-start sm:self-auto">Limpiar</a>
            @endif
        </form>

        @if ($cuentas->isEmpty())
            <div class="card">
                @if (request()->filled('search'))
                    <x-empty-state
                        title="Sin resultados"
                        description="No encontramos cuentas que coincidan con «{{ request('search') }}»."
                        icon="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z">
                        <a href="{{ route('cuentas.index') }}" class="btn-secondary btn-sm">Quitar búsqueda</a>
                    </x-empty-state>
                @else
                    <x-empty-state
                        title="Aún no hay cuentas"
                        description="Crea tu primera cuenta de efectivo, banco o ahorros para empezar a registrar movimientos."
                        icon="M3 10h18M5 6h14a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2z">
                        <a href="{{ route('cuentas.create') }}" class="btn-primary btn-sm">Crear cuenta</a>
                    </x-empty-state>
                @endif
            </div>
        @else
            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3" role="list" aria-label="Cuentas">
                @foreach ($cuentas as $cuenta)
                    @php($saldoNegativo = (float) $cuenta->saldo < 0)
                    <article class="card p-5 transition-shadow duration-200 hover:shadow-card-hover" role="listitem">
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex min-w-0 items-center gap-2.5">
                                <span class="icon-chip {{ $saldoNegativo ? 'icon-chip-expense' : 'icon-chip-income' }}">
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 10h18M5 6h14a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2z" />
                                    </svg>
                                </span>
                                <div class="min-w-0">
                                    <h2 class="truncate text-[0.9375rem] font-medium text-neutral-900 dark:text-neutral-50">{{ $cuenta->nombre }}</h2>
                                    <p class="truncate text-[0.6875rem] text-neutral-500 dark:text-neutral-400">
                                        {{ $cuenta->descripcion ?: 'Cuenta en '.$cuenta->moneda }}
                                    </p>
                                </div>
                            </div>

                            <div class="-mr-1 flex items-center gap-0.5">
                                <a href="{{ route('cuentas.edit', $cuenta) }}"
                                   class="btn-ghost btn-sm btn-icon text-neutral-400 hover:text-neutral-900 dark:text-neutral-500 dark:hover:text-neutral-100"
                                   aria-label="Editar {{ $cuenta->nombre }}"
                                   title="Editar cuenta">
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M11 5a2 2 0 10-4 0v3.586a1 1 0 00.293.707l3 3a1 1 0 001.414 0l1.586-1.586a1 1 0 000-1.414L12.414 8.999A1 1 0 0012.121 8.28L10.707 6.872A1 1 0 0010 6.586V5z" />
                                    </svg>
                                </a>

                                @if ($cuenta->transacciones_count > 0)
                                    <button type="button"
                                            class="btn-ghost btn-sm btn-icon cursor-not-allowed text-neutral-300 dark:text-neutral-600"
                                            disabled
                                            aria-label="Eliminar {{ $cuenta->nombre }} (no disponible: tiene movimientos)"
                                            title="No se puede eliminar: tiene {{ $cuenta->transacciones_count }} {{ $cuenta->transacciones_count === 1 ? 'movimiento asociado' : 'movimientos asociados' }}">
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                @else
                                    <form method="POST"
                                          action="{{ route('cuentas.destroy', $cuenta) }}"
                                          class="inline"
                                          onsubmit="return confirm('¿Eliminar la cuenta «{{ $cuenta->nombre }}»? Esta acción no se puede deshacer.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn-ghost btn-sm btn-icon text-neutral-400 hover:bg-expense-50 hover:text-expense-600 dark:text-neutral-500 dark:hover:bg-expense-500/10 dark:hover:text-expense-400"
                                                aria-label="Eliminar {{ $cuenta->nombre }}"
                                                title="Eliminar cuenta">
                                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>

                        <div class="mt-5">
                            <p class="stat-label">Saldo actual</p>
                            <p class="mt-1.5 font-mono text-[1.375rem] font-semibold tabular-nums tracking-tight {{ $saldoNegativo ? 'text-expense-700 dark:text-expense-300' : 'text-neutral-900 dark:text-neutral-50' }}">
                                {{ $cuenta->saldoFormateado() }}
                            </p>
                        </div>

                        <div class="mt-4 flex items-center justify-between border-t border-neutral-100 pt-3 text-[0.6875rem] text-neutral-500 dark:border-neutral-800 dark:text-neutral-400">
                            <span class="inline-flex items-center gap-1.5">
                                <span class="h-1.5 w-1.5 rounded-full {{ $saldoNegativo ? 'bg-expense-500' : 'bg-income-500' }}"></span>
                                {{ $cuenta->moneda }}
                            </span>
                            <span>{{ $cuenta->transacciones_count }} {{ $cuenta->transacciones_count === 1 ? 'movimiento' : 'movimientos' }}</span>
                        </div>
                    </article>
                @endforeach
            </div>

            @if ($cuentas->hasPages())
                <div class="flex flex-col gap-3 border-t border-neutral-200 pt-4 sm:flex-row sm:items-center sm:justify-between dark:border-neutral-800">
                    <p class="text-[0.75rem] text-neutral-500 dark:text-neutral-400">
                        Mostrando {{ $cuentas->firstItem() }}–{{ $cuentas->lastItem() }} de {{ $cuentas->total() }}
                    </p>
                    {{ $cuentas->links() }}
                </div>
            @endif
        @endif
    </div>
</x-app-layout>