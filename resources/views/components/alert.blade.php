@props(['type' => 'info', 'message', 'dismissible' => true])

@php
    $classes = match ($type) {
        'success' => 'border-income-200/80 bg-income-50/70 text-income-800 dark:border-neutral-700 dark:bg-neutral-800/70 dark:text-neutral-200',
        'error' => 'border-expense-200/80 bg-expense-50/70 text-expense-800 dark:border-expense-500/20 dark:bg-expense-500/10 dark:text-expense-200',
        'warning' => 'border-warning-200/80 bg-warning-50/70 text-warning-800 dark:border-warning-500/20 dark:bg-warning-500/10 dark:text-warning-200',
        default => 'border-brand-200/80 bg-brand-50/70 text-brand-800 dark:border-neutral-700 dark:bg-neutral-800/70 dark:text-neutral-200',
    };

    $icons = [
        'success' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
        'error' => 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z',
        'warning' => 'M12 9v3.75m0 3.75h.008v.008H12v-.008zM10.34 3.94l-8.22 14.25A1.5 1.5 0 003.42 20.5h17.16a1.5 1.5 0 001.3-2.31L13.66 3.94a1.5 1.5 0 00-2.6 0z',
        'info' => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
    ];
@endphp

<div class="animate-in flex items-start gap-3 rounded-lg border px-4 py-3 {{ $classes }}" role="alert">
    <svg class="mt-0.5 h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="{{ $icons[$type] ?? $icons['info'] }}" />
    </svg>
    <p class="min-w-0 flex-1 text-[0.8125rem] leading-relaxed">{{ $message }}</p>
    @if ($dismissible)
        <button type="button"
                class="-mr-1 shrink-0 rounded p-1 opacity-60 transition-opacity hover:opacity-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-current"
                aria-label="Cerrar mensaje"
                onclick="this.parentElement.remove()">
            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    @endif
</div>