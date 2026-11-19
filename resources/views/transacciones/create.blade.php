<x-app-layout>
    <x-slot name="header">
        <x-page-header
            eyebrow="Transacciones"
            title="Nueva transacción"
            description="Registra un ingreso o un gasto y el saldo se actualizará automáticamente.">
            <x-slot:actions>
                <a href="{{ route('transacciones.index') }}" class="btn-secondary btn-md">
                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Volver
                </a>
            </x-slot:actions>
        </x-page-header>
    </x-slot>

    <div class="grid gap-5 lg:grid-cols-[minmax(0,1fr)_18rem] lg:items-start">
        <form method="POST" action="{{ route('transacciones.store') }}" class="card" novalidate id="transaccion-form" data-loading>
            @csrf

            <div class="card-body">
                @include('transacciones.partials.formulario')
            </div>

            <div class="flex flex-col-reverse gap-2 border-t border-neutral-200 bg-neutral-50/60 px-5 py-4 sm:flex-row sm:justify-end dark:border-neutral-800 dark:bg-neutral-900/40">
                <a href="{{ route('transacciones.index') }}" class="btn-secondary btn-md w-full sm:w-auto">Cancelar</a>
                <button type="submit" class="btn-primary btn-md w-full sm:w-auto" data-loading-text="Registrando…">
                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14M5 12h14" />
                    </svg>
                    Registrar transacción
                </button>
            </div>
        </form>

        <aside class="lg:sticky lg:top-24">
            <div class="card p-5">
                <p class="eyebrow">Reglas del movimiento</p>
                <ul class="mt-4 space-y-3 text-[0.8125rem] leading-relaxed text-neutral-600 dark:text-neutral-400">
                    <li class="flex items-start gap-2.5">
                        <x-type-badge tipo="ingreso" />
                        <span>Aumenta el saldo de la cuenta.</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <x-type-badge tipo="gasto" />
                        <span>Disminuye el saldo y no puede superarlo.</span>
                    </li>
                </ul>
                <p class="mt-4 border-t border-neutral-200 pt-4 text-[0.75rem] leading-relaxed text-neutral-500 dark:border-neutral-800 dark:text-neutral-400">
                    La categoría debe coincidir con el tipo elegido.
                </p>
            </div>
        </aside>
    </div>

    @push('scripts')
        @include('transacciones.partials.script')
    @endpush
</x-app-layout>