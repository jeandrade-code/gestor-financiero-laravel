<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar transacción</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <x-errores-validacion />

                    <div class="mb-6 rounded-md border border-blue-200 bg-blue-50 px-4 py-3 text-sm text-blue-800">
                        Al guardar se revierte el efecto anterior de este movimiento y se aplica el nuevo sobre el saldo de la cuenta.
                    </div>

                    <form method="POST" action="{{ route('transacciones.update', $transaccion) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        @include('transacciones.partials.formulario', [
                            'transaccion' => $transaccion,
                            'cuentas' => $cuentas,
                            'categorias' => $categorias,
                            'tipos' => $tipos,
                        ])

                        <div class="flex items-center gap-3">
                            <x-primary-button>Actualizar transacción</x-primary-button>
                            <a href="{{ route('transacciones.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>