<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Categorías</h2>
            <a href="{{ route('categorias.create') }}"
               class="inline-flex items-center rounded-md bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white hover:bg-gray-700">
                Nueva categoría
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if ($categorias->isEmpty())
                        <p class="text-gray-600">Todavía no hay categorías registradas.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 text-sm">
                                <thead>
                                    <tr class="text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                        <th class="px-3 py-3">Nombre</th>
                                        <th class="px-3 py-3">Tipo</th>
                                        <th class="px-3 py-3">Descripción</th>
                                        <th class="px-3 py-3">Movimientos</th>
                                        <th class="px-3 py-3 text-right">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach ($categorias as $categoria)
                                        <tr>
                                            <td class="px-3 py-3 font-medium text-gray-900">{{ $categoria->nombre }}</td>
                                            <td class="px-3 py-3">
                                                @if ($categoria->tipo === \App\Models\Categoria::TIPO_INGRESO)
                                                    <span class="inline-flex rounded-full bg-green-100 px-2 py-1 text-xs font-semibold text-green-800">Ingreso</span>
                                                @else
                                                    <span class="inline-flex rounded-full bg-red-100 px-2 py-1 text-xs font-semibold text-red-800">Gasto</span>
                                                @endif
                                            </td>
                                            <td class="px-3 py-3 text-gray-600">{{ $categoria->descripcion ?? '—' }}</td>
                                            <td class="px-3 py-3 text-gray-600">{{ $categoria->transacciones_count }}</td>
                                            <td class="px-3 py-3">
                                                <div class="flex items-center justify-end gap-3">
                                                    <a href="{{ route('categorias.edit', $categoria) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">Editar</a>

                                                    @if ($categoria->transacciones_count > 0)
                                                        <span class="text-gray-400 cursor-not-allowed" title="Tiene transacciones asociadas">Eliminar</span>
                                                    @else
                                                        <form method="POST" action="{{ route('categorias.destroy', $categoria) }}"
                                                              onsubmit="return confirm('¿Seguro que deseas eliminar la categoría {{ $categoria->nombre }}?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-red-600 hover:text-red-900 font-medium">Eliminar</button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-6">
                            {{ $categorias->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>