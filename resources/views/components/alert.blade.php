@props(['type' => 'info', 'message', 'dismissible' => true])

@php
    $classes = match($type) {
        'success' => 'bg-income-50 border-income-200 text-income-800 dark:bg-income-900/20 dark:border-income-800 dark:text-income-300',
        'error' => 'bg-expense-50 border-expense-200 text-expense-800 dark:bg-expense-900/20 dark:border-expense-800 dark:text-expense-300',
        'warning' => 'bg-warning-50 border-warning-200 text-warning-800 dark:bg-warning-900/20 dark:border-warning-800 dark:text-warning-300',
        default => 'bg-brand-50 border-brand-200 text-brand-800 dark:bg-brand-900/20 dark:border-brand-800 dark:text-brand-300',
    };

    $icon = match($type) {
        'success' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
        'error' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
        'warning' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>',
        default => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
    };
@endphp

<div class="flex items-start gap-3 p-4 rounded-xl border {{ $classes }} animate-in" role="alert">
    <div class="flex-shrink-0 mt-0.5 text-current">
        {!! $icon !!}
    </div>
    <div class="flex-1 min-w-0">
        <p class="text-body">{{ $message }}</p>
    </div>
    @if ($dismissible)
        <button type="button"
                class="flex-shrink-0 p-1 rounded-lg hover:bg-black/5 dark:hover:bg-white/5 transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-current"
                aria-label="Cerrar"
                onclick="this.parentElement.style.animation='fadeOut 150ms ease-in forwards'; setTimeout(() => this.parentElement.remove(), 150)">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    @endif
</div>