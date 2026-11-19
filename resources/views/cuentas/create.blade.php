<x-app-layout>
    <x-slot name="header">
        <x-page-header
            eyebrow="Cuentas"
            title="Nueva cuenta"
            description="Añade una cuenta de efectivo, bancaria o de ahorros.">
            <x-slot:actions>
                <a href="{{ route('cuentas.index') }}" class="btn-secondary btn-md">
                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Volver
                </a>
            </x-slot:actions>
        </x-page-header>
    </x-slot>

    <div class="grid gap-5 lg:grid-cols-[minmax(0,1fr)_18rem] lg:items-start">
        <form method="POST" action="{{ route('cuentas.store') }}" class="card" novalidate data-loading>
            @csrf

            <div class="card-body">
                @include('cuentas.partials.formulario')
            </div>

            <div class="flex flex-col-reverse gap-2 border-t border-neutral-200 bg-neutral-50/60 px-5 py-4 sm:flex-row sm:justify-end dark:border-neutral-800 dark:bg-neutral-900/40">
                <a href="{{ route('cuentas.index') }}" class="btn-secondary btn-md w-full sm:w-auto">Cancelar</a>
                <button type="submit" class="btn-primary btn-md w-full sm:w-auto" data-loading-text="Creando…">
                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14M5 12h14" />
                    </svg>
                    Crear cuenta
                </button>
            </div>
        </form>

        <aside class="card p-5">
            <p class="eyebrow">Cómo funciona</p>
            <ul class="mt-4 space-y-3 text-[0.8125rem] leading-relaxed text-neutral-600 dark:text-neutral-400">
                <li class="flex gap-2.5">
                    <span class="mt-1.5 h-1 w-1 shrink-0 rounded-full bg-brand-500"></span>
                    El saldo inicial puede ser cero. A partir de ahí, cada movimiento lo actualiza automáticamente.
                </li>
                <li class="flex gap-2.5">
                    <span class="mt-1.5 h-1 w-1 shrink-0 rounded-full bg-brand-500"></span>
                    La moneda se fija al registrar el primer movimiento para mantener los saldos coherentes.
                </li>
                <li class="flex gap-2.5">
                    <span class="mt-1.5 h-1 w-1 shrink-0 rounded-full bg-brand-500"></span>
                    No podrás eliminar la cuenta mientras tenga transacciones asociadas.
                </li>
            </ul>
        </aside>
    </div>
</x-app-layout>