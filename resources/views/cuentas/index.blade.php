<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Cuentas</h2>
            <a href="{{ route('cuentas.create') }}"
               class="inline-flex items-center rounded-md bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white hover:bg-gray-700">
                Nueva cuenta
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if ($cuentas->isEmpty())
                        <p class="text-gray-600">Todavía no hay cuentas registradas.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 text-sm">
                                <thead>
                                    <tr class="text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                        <th class="px-3 py-3">Nombre</th>
                                        <th class="px-3 py-3">Descripción</th>
                                        <th class="px-3 py-3">Moneda</th>
                                        <th class="px-3 py-3 text-right">Saldo actual</th>
                                        <th class="px-3 py-3 text-right">Movimientos</th>
                                        <th class="px-3 py-3 text-right">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach ($cuentas as $cuenta)
                                        <tr>
                                            <td class="px-3 py-3 font-medium text-gray-900">{{ $cuenta->nombre }}</td>
                                            <td class="px-3 py-3 text-gray-600">{{ $cuenta->descripcion ?? '—' }}</td>
                                            <td class="px-3 py-3 text-gray-600">{{ $cuenta->moneda }}</td>
                                            <td class="px-3 py-3 text-right font-semibold text-gray-900">{{ $cuenta->saldoFormateado() }}</td>
                                            <td class="px-3 py-3 text-right text-gray-600">{{ $cuenta->transacciones_count }}</td>
                                            <td class="px-3 py-3">
                                                <div class="flex items-center justify-end gap-3">
                                                    <a href="{{ route('cuentas.edit', $cuenta) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">Editar</a>

                                                    @if ($cuenta->transacciones_count > 0)
                                                        <span class="text-gray-400 cursor-not-allowed" title="Tiene movimientos asociados">Eliminar</span>
                                                    @else
                                                        <form method="POST" action="{{ route('cuentas.destroy', $cuenta) }}"
                                                              onsubmit="return confirm('¿Seguro que deseas eliminar la cuenta {{ $cuenta->nombre }}?');">
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
                            {{ $cuentas->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>