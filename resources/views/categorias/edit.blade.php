<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar categoría</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <x-errores-validacion />

                    <form method="POST" action="{{ route('categorias.update', $categoria) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        @include('categorias.partials.formulario', ['categoria' => $categoria, 'tipos' => $tipos])

                        <div class="flex items-center gap-3">
                            <x-primary-button>Actualizar categoría</x-primary-button>
                            <a href="{{ route('categorias.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>