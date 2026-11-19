<x-app-layout>
    <x-slot name="header">
        <x-page-header
            eyebrow="Configuración"
            title="Categorías"
            description="{{ $resumen['total'] }} categorías en total · {{ $resumen['ingresos'] }} de ingreso · {{ $resumen['gastos'] }} de gasto.">
            <x-slot:actions>
                <a href="{{ route('categorias.create') }}" class="btn-primary btn-md">
                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14M5 12h14" />
                    </svg>
                    Nueva categoría
                </a>
            </x-slot:actions>
        </x-page-header>
    </x-slot>

    <div class="card overflow-hidden">
        <form method="GET" action="{{ route('categorias.index') }}" class="toolbar">
            <div class="toolbar-field">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z" />
                </svg>
                <label for="filter_search" class="sr-only">Buscar categorías</label>
                <input type="search"
                       name="search"
                       id="filter_search"
                       value="{{ request('search') }}"
                       placeholder="Buscar por nombre o descripción"
                       class="toolbar-input"
                       onkeydown="if(event.key==='Enter') this.form.submit()">
            </div>

            <div class="sm:w-40">
                <label for="filter_tipo" class="sr-only">Filtrar por tipo</label>
                <select name="tipo" id="filter_tipo" class="input py-2" onchange="this.form.submit()">
                    <option value="">Todos los tipos</option>
                    <option value="ingreso" @selected(request('tipo') === 'ingreso')>Ingresos</option>
                    <option value="gasto" @selected(request('tipo') === 'gasto')>Gastos</option>
                </select>
            </div>

            <div class="flex items-center gap-2">
                <button type="submit" class="btn-secondary btn-sm">Filtrar</button>
                @if (request()->filled('search') || request()->filled('tipo'))
                    <a href="{{ route('categorias.index') }}" class="btn-ghost btn-sm">Limpiar</a>
                @endif
            </div>
        </form>

        @if ($categorias->isEmpty())
            @if (request()->filled('search') || request()->filled('tipo'))
                <x-empty-state
                    title="Sin resultados"
                    description="No encontramos categorías con esos filtros. Prueba con otro nombre o tipo."
                    icon="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z">
                    <a href="{{ route('categorias.index') }}" class="btn-secondary btn-sm">Quitar filtros</a>
                </x-empty-state>
            @else
                <x-empty-state
                    title="Aún no hay categorías"
                    description="Crea categorías de ingreso y de gasto para clasificar cada movimiento."
                    icon="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                    <a href="{{ route('categorias.create') }}" class="btn-primary btn-sm">Crear categoría</a>
                </x-empty-state>
            @endif
        @else
            <div class="table-container">
                <table class="table table-stack">
                    <thead>
                        <tr>
                            <th scope="col">Categoría</th>
                            <th scope="col" class="w-28">Tipo</th>
                            <th scope="col" class="w-32">Movimientos</th>
                            <th scope="col" class="w-24 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categorias as $categoria)
                            <tr>
                                <td class="table-stack-primary" data-label="">
                                    <div class="min-w-0">
                                        <p class="text-[0.8125rem] font-medium text-neutral-900 dark:text-neutral-50">{{ $categoria->nombre }}</p>
                                        <p class="line-clamp-2 max-w-md text-[0.6875rem] text-neutral-500 sm:line-clamp-1 dark:text-neutral-400">
                                            {{ $categoria->descripcion ?: 'Sin descripción' }}
                                        </p>
                                    </div>
                                </td>
                                <td data-label="Tipo">
                                    <x-type-badge :tipo="$categoria->tipo" />
                                </td>
                                <td class="text-[0.75rem] tabular-nums text-neutral-500 dark:text-neutral-400" data-label="Movimientos">
                                    {{ $categoria->transacciones_count }}
                                </td>
                                <td class="table-stack-actions" data-label="">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('categorias.edit', $categoria) }}"
                                           class="btn-ghost btn-sm btn-icon text-neutral-500 hover:text-neutral-900 dark:text-neutral-400 dark:hover:text-neutral-100"
                                           aria-label="Editar {{ $categoria->nombre }}"
                                           title="Editar categoría">
                                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M11 5a2 2 0 10-4 0v3.586a1 1 0 00.293.707l3 3a1 1 0 001.414 0l1.586-1.586a1 1 0 000-1.414L12.414 8.999A1 1 0 0012.121 8.28L10.707 6.872A1 1 0 0010 6.586V5z" />
                                            </svg>
                                        </a>

                                        @if ($categoria->transacciones_count > 0)
                                            <button type="button"
                                                    class="btn-ghost btn-sm btn-icon cursor-not-allowed text-neutral-300 dark:text-neutral-600"
                                                    disabled
                                                    aria-label="Eliminar {{ $categoria->nombre }} (no disponible: tiene movimientos)"
                                                    title="No se puede eliminar: tiene {{ $categoria->transacciones_count }} {{ $categoria->transacciones_count === 1 ? 'movimiento asociado' : 'movimientos asociados' }}">
                                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        @else
                                            <form method="POST"
                                                  action="{{ route('categorias.destroy', $categoria) }}"
                                                  class="inline"
                                                  onsubmit="return confirm('¿Eliminar la categoría «{{ $categoria->nombre }}»? Esta acción no se puede deshacer.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="btn-ghost btn-sm btn-icon text-neutral-400 hover:bg-expense-50 hover:text-expense-600 dark:text-neutral-500 dark:hover:bg-expense-500/10 dark:hover:text-expense-400"
                                                        aria-label="Eliminar {{ $categoria->nombre }}"
                                                        title="Eliminar categoría">
                                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
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

            <div class="flex flex-col gap-3 border-t border-neutral-200 px-4 py-3 sm:flex-row sm:items-center sm:justify-between dark:border-neutral-800">
                <p class="text-[0.75rem] text-neutral-500 dark:text-neutral-400">
                    Mostrando {{ $categorias->firstItem() }}–{{ $categorias->lastItem() }} de {{ $categorias->total() }}
                </p>
                {{ $categorias->links() }}
            </div>
        @endif
    </div>
</x-app-layout>