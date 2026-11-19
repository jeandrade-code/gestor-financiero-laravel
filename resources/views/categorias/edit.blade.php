<x-app-layout>
    <x-slot name="header">
        <x-page-header
            eyebrow="Categorías"
            title="Editar categoría"
            description="Actualiza la información de «{{ $categoria->nombre }}».">
            <x-slot:actions>
                <a href="{{ route('categorias.index') }}" class="btn-secondary btn-md">
                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Volver
                </a>
            </x-slot:actions>
        </x-page-header>
    </x-slot>

    <div class="grid gap-5 lg:grid-cols-[minmax(0,1fr)_18rem] lg:items-start">
        <form method="POST" action="{{ route('categorias.update', $categoria) }}" class="card" novalidate data-loading>
            @csrf
            @method('PUT')

            <div class="card-body">
                @include('categorias.partials.formulario', ['tipoBloqueado' => $categoria->tieneTransacciones()])
            </div>

            <div class="flex flex-col-reverse gap-2 border-t border-neutral-200 bg-neutral-50/60 px-5 py-4 sm:flex-row sm:justify-end dark:border-neutral-800 dark:bg-neutral-900/40">
                <a href="{{ route('categorias.index') }}" class="btn-secondary btn-md w-full sm:w-auto">Cancelar</a>
                <button type="submit" class="btn-primary btn-md w-full sm:w-auto" data-loading-text="Guardando…">
                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Guardar cambios
                </button>
            </div>
        </form>

        <aside class="card p-5">
            <p class="eyebrow">Información</p>
            <dl class="mt-4 space-y-3 text-[0.8125rem]">
                <div class="flex items-center justify-between gap-3">
                    <dt class="text-neutral-500 dark:text-neutral-400">Movimientos</dt>
                    <dd class="font-mono tabular-nums text-neutral-800 dark:text-neutral-200">{{ $categoria->transacciones()->count() }}</dd>
                </div>
                <div class="flex items-center justify-between gap-3">
                    <dt class="text-neutral-500 dark:text-neutral-400">Creada</dt>
                    <dd class="text-neutral-800 dark:text-neutral-200">{{ $categoria->created_at?->format('d/m/Y') ?? '—' }}</dd>
                </div>
                <div class="flex items-center justify-between gap-3">
                    <dt class="text-neutral-500 dark:text-neutral-400">Actualizada</dt>
                    <dd class="text-neutral-800 dark:text-neutral-200">{{ $categoria->updated_at?->format('d/m/Y') ?? '—' }}</dd>
                </div>
            </dl>
            @if ($categoria->tieneTransacciones())
                <div class="mt-4 border-t border-neutral-200 pt-4 text-[0.75rem] leading-relaxed text-neutral-500 dark:border-neutral-800 dark:text-neutral-400">
                    Esta categoría está en uso. Para conservar la coherencia de los saldos, su tipo permanece bloqueado.
                </div>
            @endif
        </aside>
    </div>
</x-app-layout>