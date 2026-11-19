@props([
    'title',
    'description' => null,
    'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2',
])

<div {{ $attributes->merge(['class' => 'empty-state']) }}>
    <span class="empty-state-icon">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $icon }}" />
        </svg>
    </span>
    <p class="text-[0.9375rem] font-medium text-neutral-900 dark:text-neutral-100">{{ $title }}</p>
    @if ($description)
        <p class="mt-1 max-w-sm text-[0.8125rem] leading-relaxed text-neutral-500 dark:text-neutral-400">{{ $description }}</p>
    @endif
    @if (! $slot->isEmpty())
        <div class="mt-5">{{ $slot }}</div>
    @endif
</div>