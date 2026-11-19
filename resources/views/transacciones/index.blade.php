<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Transacciones</h2>
            <a href="{{ route('transacciones.create') }}"
               class="inline-flex items-center rounded-md bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white hover:bg-gray-700">
                Nueva transacción
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="GET" action="{{ route('transacciones.index') }}" class="mb-6 flex flex-wrap items-end gap-4">
                        <div>
                            <x-input-label for="filtro_tipo" value="Tipo" />
                            <select id="filtro_tipo" name="tipo"
                                    class="mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Todos</option>
                                <option value="ingreso" @selected($filtros['tipo'] === 'ingreso')>Ingreso</option>
                                <option value="gasto" @selected($filtros['tipo'] === 'gasto')>Gasto</option>
                            </select>
                        </div>

                        <div>
                            <x-input-label for="filtro_cuenta" value="Cuenta" />
                            <select id="filtro_cuenta" name="cuenta_id"
                                    class="mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Todas</option>
                                @foreach ($cuentas as $cuenta)
                                    <option value="{{ $cuenta->id }}" @selected((string) $filtros['cuenta_id'] === (string) $cuenta->id)>{{ $cuenta->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex items-center gap-3">
                            <x-primary-button>Filtrar</x-primary-button>
                            <a href="{{ route('transacciones.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Limpiar</a>
                        </div>
                    </form>

                    @if ($transacciones->isEmpty())
                        <p class="text-gray-600">Todavía no hay transacciones registradas.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 text-sm">
                                <thead>
                                    <tr class="text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                        <th class="px-3 py-3">Fecha</th>
                                        <th class="px-3 py-3">Cuenta</th>
                                        <th class="px-3 py-3">Categoría</th>
                                        <th class="px-3 py-3">Tipo</th>
                                        <th class="px-3 py-3 text-right">Monto</th>
                                        <th class="px-3 py-3">Descripción</th>
                                        <th class="px-3 py-3">Registrado por</th>
                                        <th class="px-3 py-3 text-right">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach ($transacciones as $transaccion)
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
                                            <td class="px-3 py-3 text-gray-600">{{ $transaccion->descripcion ?? '—' }}</td>
                                            <td class="px-3 py-3 text-gray-600">{{ $transaccion->creado_por ?? '—' }}</td>
                                            <td class="px-3 py-3">
                                                <div class="flex items-center justify-end gap-3">
                                                    <a href="{{ route('transacciones.edit', $transaccion) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">Editar</a>

                                                    <form method="POST" action="{{ route('transacciones.destroy', $transaccion) }}"
                                                          onsubmit="return confirm('¿Seguro que deseas eliminar esta transacción? El saldo de la cuenta se revertirá.');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900 font-medium">Eliminar</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-6">
                            {{ $transacciones->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>