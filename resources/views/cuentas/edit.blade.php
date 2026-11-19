<x-app-layout>
    <x-slot name="header">
        <x-page-header
            eyebrow="Cuentas"
            title="Editar cuenta"
            description="Actualiza la información de «{{ $cuenta->nombre }}».">
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
        <div class="space-y-5">
            @if ($cuenta->tieneTransacciones())
                <div class="flex items-start gap-2.5 rounded-lg border border-warning-200/80 bg-warning-50/70 px-4 py-3 dark:border-warning-500/20 dark:bg-warning-500/10">
                    <svg class="mt-0.5 h-4 w-4 shrink-0 text-warning-700 dark:text-warning-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-[0.8125rem] leading-relaxed text-warning-800 dark:text-warning-200">
                        Esta cuenta tiene {{ $cuenta->transacciones()->count() }} {{ $cuenta->transacciones()->count() === 1 ? 'movimiento' : 'movimientos' }}. El saldo y la moneda están bloqueados para proteger la integridad de los datos.
                    </p>
                </div>
            @endif

            <form method="POST" action="{{ route('cuentas.update', $cuenta) }}" class="card" novalidate data-loading>
                @csrf
                @method('PUT')

                <div class="card-body">
                    @include('cuentas.partials.formulario')
                </div>

                <div class="flex flex-col-reverse gap-2 border-t border-neutral-200 bg-neutral-50/60 px-5 py-4 sm:flex-row sm:justify-end dark:border-neutral-800 dark:bg-neutral-900/40">
                    <a href="{{ route('cuentas.index') }}" class="btn-secondary btn-md w-full sm:w-auto">Cancelar</a>
                    <button type="submit" class="btn-primary btn-md w-full sm:w-auto" data-loading-text="Guardando…">
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Guardar cambios
                    </button>
                </div>
            </form>
        </div>

        <aside class="card p-5">
            <p class="eyebrow">Estado de la cuenta</p>
            <dl class="mt-4 space-y-3 text-[0.8125rem]">
                <div>
                    <dt class="text-neutral-500 dark:text-neutral-400">Saldo actual</dt>
                    <dd class="mt-1 font-mono text-[1.0625rem] font-medium tabular-nums {{ (float) $cuenta->saldo < 0 ? 'text-expense-700 dark:text-expense-300' : 'text-neutral-900 dark:text-neutral-50' }}">
                        {{ $cuenta->saldoFormateado() }}
                    </dd>
                </div>
                <div class="flex items-center justify-between gap-3 border-t border-neutral-200 pt-3 dark:border-neutral-800">
                    <dt class="text-neutral-500 dark:text-neutral-400">Movimientos</dt>
                    <dd class="font-mono tabular-nums text-neutral-800 dark:text-neutral-200">{{ $cuenta->transacciones()->count() }}</dd>
                </div>
                <div class="flex items-center justify-between gap-3">
                    <dt class="text-neutral-500 dark:text-neutral-400">Creada</dt>
                    <dd class="text-neutral-800 dark:text-neutral-200">{{ $cuenta->created_at?->format('d/m/Y') ?? '—' }}</dd>
                </div>
            </dl>
            <div class="mt-4 border-t border-neutral-200 pt-4 dark:border-neutral-800">
                <a href="{{ route('transacciones.index', ['cuenta_id' => $cuenta->id]) }}" class="btn-secondary btn-sm w-full">
                    Ver movimientos
                </a>
            </div>
        </aside>
    </div>
</x-app-layout>