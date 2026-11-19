<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-heading-lg text-neutral-900 dark:text-neutral-50">Cuentas</h2>
                <p class="text-body text-neutral-600 dark:text-neutral-400 mt-1">Gestiona tus cuentas de efectivo y bancarias</p>
            </div>
            <a href="{{ route('cuentas.create') }}" class="btn-primary btn-md">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Nueva cuenta
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- Filters -->
        <div class="card p-4 animate-in">
            <form method="GET" action="{{ route('cuentas.index') }}" class="flex flex-col sm:flex-row gap-4">
                <div class="flex-1">
                    <label for="filter_search" class="sr-only">Buscar</label>
                    <input type="search"
                           name="search"
                           id="filter_search"
                           value="{{ request('search') }}"
                           placeholder="Buscar por nombre..."
                           class="input"
                           onkeydown="if(event.key==='Enter') this.form.submit()">
                </div>
            </form>
        </div>

        <!-- Accounts Grid -->
        <div class="animate-in stagger-1">
            @if ($cuentas->isEmpty())
                <div class="card text-center py-12">
                    <svg class="w-12 h-12 mx-auto text-neutral-300 dark:text-neutral-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <p class="text-body text-neutral-600 dark:text-neutral-400 mb-2">No hay cuentas registradas</p>
                    <p class="text-caption text-neutral-500 dark:text-neutral-400 mb-4">Crea tu primera cuenta para empezar a registrar movimientos</p>
                    <a href="{{ route('cuentas.create') }}" class="btn-primary btn-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Crear cuenta
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5" role="list" aria-label="Cuentas">
                    @foreach ($cuentas as $index => $cuenta)
                        <article class="card card-hover p-6 animate-in stagger-{{ min($index + 1, 6) }}" role="listitem">
                            <div class="flex items-start justify-between gap-4 mb-4">
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-heading-sm text-neutral-900 dark:text-neutral-50 truncate">{{ $cuenta->nombre }}</h3>
                                    @if ($cuenta->descripcion)
                                        <p class="text-caption text-neutral-500 dark:text-neutral-400 mt-1 truncate">{{ $cuenta->descripcion }}</p>
                                    @endif
                                </div>
                                <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0
                                    {{ $cuenta->saldo >= 0 ? 'bg-income-100 dark:bg-income-900/30' : 'bg-expense-100 dark:bg-expense-900/30' }}">
                                    @if ($cuenta->saldo >= 0)
                                        <svg class="w-5 h-5 text-income-600 dark:text-income-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5 text-expense-600 dark:text-expense-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                        </svg>
                                    @endif
                                </div>
                            </div>

                            <!-- Saldo principal -->
                            <div class="mb-4">
                                <p class="text-caption font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider mb-1">Saldo actual</p>
                                <p class="text-display-sm font-bold {{ $cuenta->saldo >= 0 ? 'text-neutral-900 dark:text-neutral-50' : 'text-expense-600 dark:text-expense-400' }} tabular-nums">
                                    {{ $cuenta->saldoFormateado() }}
                                </p>
                            </div>

                            <!-- Meta info -->
                            <div class="flex flex-wrap items-center gap-4 text-caption text-neutral-500 dark:text-neutral-400 border-t border-neutral-100 dark:border-neutral-800 pt-4 mb-4">
                                <span class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $cuenta->moneda }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                    </svg>
                                    {{ $cuenta->transacciones_count }} movimiento{{ $cuenta->transacciones_count !== 1 ? 's' : '' }}
                                </span>
                            </div>

                            <!-- Actions -->
                            <div class="flex items-center gap-2">
                                <a href="{{ route('cuentas.edit', $cuenta) }}"
                                   class="btn-ghost btn-sm btn-icon flex-1 sm:flex-none"
                                   aria-label="Editar {{ $cuenta->nombre }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M11 5a2 2 0 10-4 0v3.586a1 1 0 00.293.707l3 3a1 1 0 001.414 0l1.586-1.586a1 1 0 000-1.414L12.414 8.999A1 1 0 0012.121 8.28L10.707 6.872A1 1 0 0010 6.586V5z"/>
                                    </svg>
                                </a>
                                @if ($cuenta->transacciones_count > 0)
                                    <button type="button"
                                            class="btn-ghost btn-sm btn-icon text-neutral-400 dark:text-neutral-500 cursor-not-allowed flex-1 sm:flex-none"
                                            disabled
                                            aria-label="Eliminar {{ $cuenta->nombre }} (no disponible: tiene movimientos)"
                                            title="No se puede eliminar: tiene {{ $cuenta->transacciones_count }} movimiento{{ $cuenta->transacciones_count !== 1 ? 's' : '' }} asociado{{ $cuenta->transacciones_count !== 1 ? 's' : '' }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                @else
                                    <form method="POST"
                                          action="{{ route('cuentas.destroy', $cuenta) }}"
                                          class="inline flex-1 sm:flex-none"
                                          onsubmit="return confirm('¿Seguro que deseas eliminar la cuenta \"{{ $cuenta->nombre }}\"? Esta acción no se puede deshacer.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn-ghost btn-sm btn-icon text-expense-600 dark:text-expense-400 hover:bg-expense-50 dark:hover:bg-expense-900/20 w-full"
                                                aria-label="Eliminar {{ $cuenta->nombre }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="card mt-6">
                    <div class="card-footer flex items-center justify-between">
                        <p class="text-body-sm text-neutral-600 dark:text-neutral-400">
                            Mostrando {{ $cuentas->firstItem() }} a {{ $cuentas->lastItem() }} de {{ $cuentas->total() }} cuenta{{ $cuentas->total() !== 1 ? 's' : '' }}
                        </p>
                        {{ $cuentas->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>