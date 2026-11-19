<x-app-layout>
    <x-slot name="header">
        <x-page-header
            eyebrow="Transacciones"
            title="Editar transacción"
            description="Movimiento del {{ $transaccion->fecha->format('d/m/Y') }}. Al guardar, el saldo se recalcula.">
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
        <form method="POST" action="{{ route('transacciones.update', $transaccion) }}" class="card" novalidate id="transaccion-form" data-loading>
            @csrf
            @method('PUT')

            <div class="card-body">
                @include('transacciones.partials.formulario')
            </div>

            <div class="flex flex-col-reverse gap-2 border-t border-neutral-200 bg-neutral-50/60 px-5 py-4 sm:flex-row sm:justify-end dark:border-neutral-800 dark:bg-neutral-900/40">
                <a href="{{ route('transacciones.index') }}" class="btn-secondary btn-md w-full sm:w-auto">Cancelar</a>
                <button type="submit" class="btn-primary btn-md w-full sm:w-auto" data-loading-text="Guardando…">
                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Guardar cambios
                </button>
            </div>
        </form>

        <aside class="space-y-4">
            <div class="card p-5">
                <p class="eyebrow">Movimiento actual</p>
                <div class="mt-4 flex items-center justify-between gap-3">
                    <x-type-badge :tipo="$transaccion->tipo" />
                    <span class="font-mono text-[1.0625rem] font-medium tabular-nums {{ $transaccion->esIngreso() ? 'text-income-700 dark:text-neutral-300' : 'text-expense-700 dark:text-expense-300' }}">
                        {{ $transaccion->esIngreso() ? '+' : '−' }}{{ number_format((float) $transaccion->monto, 2, ',', '.') }}
                    </span>
                </div>
                <dl class="mt-4 space-y-2.5 border-t border-neutral-200 pt-4 text-[0.8125rem] dark:border-neutral-800">
                    <div class="flex justify-between gap-3">
                        <dt class="text-neutral-500 dark:text-neutral-400">Cuenta</dt>
                        <dd class="text-right font-medium text-neutral-800 dark:text-neutral-200">{{ $transaccion->cuenta->nombre }}</dd>
                    </div>
                    <div class="flex justify-between gap-3">
                        <dt class="text-neutral-500 dark:text-neutral-400">Categoría</dt>
                        <dd class="text-right font-medium text-neutral-800 dark:text-neutral-200">{{ $transaccion->categoria->nombre }}</dd>
                    </div>
                    <div class="flex justify-between gap-3">
                        <dt class="text-neutral-500 dark:text-neutral-400">Registrado por</dt>
                        <dd class="text-right text-neutral-800 dark:text-neutral-200">{{ $transaccion->creado_por ?: '—' }}</dd>
                    </div>
                </dl>
            </div>

            <div class="rounded-xl border border-warning-200/70 bg-warning-50/60 p-4 dark:border-warning-500/20 dark:bg-warning-500/5">
                <div class="flex items-start gap-2.5">
                    <svg class="mt-0.5 h-4 w-4 shrink-0 text-warning-700 dark:text-warning-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 9v3.75m0 3.75h.008v.008H12v-.008zM10.34 3.94l-8.22 14.25A1.5 1.5 0 003.42 20.5h17.16a1.5 1.5 0 001.3-2.31L13.66 3.94a1.5 1.5 0 00-2.6 0z" />
                    </svg>
                    <p class="text-[0.75rem] leading-relaxed text-warning-800/90 dark:text-warning-200/90">
                        Al guardar se revierte el efecto anterior y se aplica el nuevo, incluso si cambias de cuenta o de tipo.
                    </p>
                </div>
            </div>
        </aside>
    </div>

    @push('scripts')
        @include('transacciones.partials.script')
    @endpush
</x-app-layout>