<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-heading-lg text-neutral-900 dark:text-neutral-50">Categorías</h2>
                <p class="text-body text-neutral-600 dark:text-neutral-400 mt-1">Organiza tus ingresos y gastos</p>
            </div>
            <a href="{{ route('categorias.create') }}" class="btn-primary btn-md">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Nueva categoría
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- Filters -->
        <div class="card p-4 animate-in">
            <form method="GET" action="{{ route('categorias.index') }}" class="flex flex-col sm:flex-row gap-4">
                <div class="flex-1">
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

        <!-- Categories Table -->
        <div class="card overflow-hidden animate-in stagger-1">
            @if ($categorias->isEmpty())
                <div class="card-body text-center py-12">
                    <svg class="w-12 h-12 mx-auto text-neutral-300 dark:text-neutral-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    <p class="text-body text-neutral-600 dark:text-neutral-400 mb-2">No hay categorías registradas</p>
                    <p class="text-caption text-neutral-500 dark:text-neutral-400 mb-4">Crea tu primera categoría para organizar tus movimientos</p>
                    <a href="{{ route('categorias.create') }}" class="btn-primary btn-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Crear categoría
                    </a>
                </div>
            @else
                <div class="table-container">
                    <table class="table" role="table">
                        <thead>
                            <tr>
                                <th scope="col">Nombre</th>
                                <th scope="col">Tipo</th>
                                <th scope="col">Descripción</th>
                                <th scope="col" class="w-24">Movimientos</th>
                                <th scope="col" class="w-36 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-100 dark:divide-neutral-800">
                            @foreach ($categorias as $index => $categoria)
                                <tr class="animate-in stagger-{{ min($index + 1, 6) }}">
                                    <td class="font-medium text-neutral-900 dark:text-neutral-50">{{ $categoria->nombre }}</td>
                                    <td>
                                        @if ($categoria->tipo === 'ingreso')
                                            <span class="badge badge-success">Ingreso</span>
                                        @else
                                            <span class="badge badge-destructive">Gasto</span>
                                        @endif
                                    </td>
                                    <td class="text-neutral-600 dark:text-neutral-400 max-w-xs truncate">{{ $categoria->descripcion ?? '—' }}</td>
                                    <td class="text-center font-mono tabular-nums text-body-sm text-neutral-600 dark:text-neutral-400">{{ $categoria->transacciones_count }}</td>
                                    <td class="text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('categorias.edit', $categoria) }}"
                                               class="btn-ghost btn-sm btn-icon"
                                               aria-label="Editar {{ $categoria->nombre }}">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M11 5a2 2 0 10-4 0v3.586a1 1 0 00.293.707l3 3a1 1 0 001.414 0l1.586-1.586a1 1 0 000-1.414L12.414 8.999A1 1 0 0012.121 8.28L10.707 6.872A1 1 0 0010 6.586V5z"/>
                                                </svg>
                                            </a>
                                            @if ($categoria->transacciones_count > 0)
                                                <button type="button"
                                                        class="btn-ghost btn-sm btn-icon text-neutral-400 dark:text-neutral-500 cursor-not-allowed"
                                                        disabled
                                                        aria-label="Eliminar {{ $categoria->nombre }} (no disponible: tiene movimientos)"
                                                        title="No se puede eliminar: tiene {{ $categoria->transacciones_count }} movimiento{{ $categoria->transacciones_count !== 1 ? 's' : '' }} asociado{{ $categoria->transacciones_count !== 1 ? 's' : '' }}">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            @else
                                                <form method="POST"
                                                      action="{{ route('categorias.destroy', $categoria) }}"
                                                      class="inline"
                                                      onsubmit="return confirm('¿Seguro que deseas eliminar la categoría \"{{ $categoria->nombre }}\"? Esta acción no se puede deshacer.')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="btn-ghost btn-sm btn-icon text-expense-600 dark:text-expense-400 hover:bg-expense-50 dark:hover:bg-expense-900/20"
                                                            aria-label="Eliminar {{ $categoria->nombre }}">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endif
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
                        Mostrando {{ $categorias->firstItem() }} a {{ $categorias->lastItem() }} de {{ $categorias->total() }} categor{{ $categorias->total() !== 1 ? 'ías' : 'ía' }}
                    </p>
                    {{ $categorias->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>