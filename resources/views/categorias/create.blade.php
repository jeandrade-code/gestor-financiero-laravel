<x-app-layout>
    <x-slot name="header">
        <x-page-header
            eyebrow="Categorías"
            title="Nueva categoría"
            description="Define cómo quieres clasificar tus ingresos y gastos.">
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
        <form method="POST" action="{{ route('categorias.store') }}" class="card" novalidate data-loading>
            @csrf

            <div class="card-body">
                @include('categorias.partials.formulario')
            </div>

            <div class="flex flex-col-reverse gap-2 border-t border-neutral-200 bg-neutral-50/60 px-5 py-4 sm:flex-row sm:justify-end dark:border-neutral-800 dark:bg-neutral-900/40">
                <a href="{{ route('categorias.index') }}" class="btn-secondary btn-md w-full sm:w-auto">Cancelar</a>
                <button type="submit" class="btn-primary btn-md w-full sm:w-auto" data-loading-text="Creando…">
                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14M5 12h14" />
                    </svg>
                    Crear categoría
                </button>
            </div>
        </form>

        <aside class="card p-5">
            <p class="eyebrow">Antes de crearla</p>
            <ul class="mt-4 space-y-3 text-[0.8125rem] leading-relaxed text-neutral-600 dark:text-neutral-400">
                <li class="flex gap-2.5">
                    <span class="mt-1.5 h-1 w-1 shrink-0 rounded-full bg-brand-500"></span>
                    El tipo define qué movimientos acepta la categoría y no podrá cambiarse una vez tenga transacciones.
                </li>
                <li class="flex gap-2.5">
                    <span class="mt-1.5 h-1 w-1 shrink-0 rounded-full bg-brand-500"></span>
                    Usa nombres claros: «Salario», «Arrendamiento» o «Servicios públicos» funcionan mejor que abreviaturas.
                </li>
                <li class="flex gap-2.5">
                    <span class="mt-1.5 h-1 w-1 shrink-0 rounded-full bg-brand-500"></span>
                    La descripción es opcional, pero ayuda a recordar qué incluye cada categoría.
                </li>
            </ul>
        </aside>
    </div>
</x-app-layout>