<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar cuenta</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <x-errores-validacion />

                    @if ($cuenta->tieneTransacciones())
                        <div class="mb-6 rounded-md border border-yellow-300 bg-yellow-50 px-4 py-3 text-sm text-yellow-800">
                            Esta cuenta tiene movimientos asociados: su saldo se calcula automáticamente y no puede editarse a mano.
                        </div>
                    @endif

                    <form method="POST" action="{{ route('cuentas.update', $cuenta) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        @include('cuentas.partials.formulario', ['cuenta' => $cuenta])

                        <div class="flex items-center gap-3">
                            <x-primary-button>Actualizar cuenta</x-primary-button>
                            <a href="{{ route('cuentas.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>