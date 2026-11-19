@props(['class' => 'h-8 w-8'])

<svg {{ $attributes->merge(['class' => $class, 'viewBox' => '0 0 32 32', 'fill' => 'none', 'aria-hidden' => 'true']) }}>
    <rect width="32" height="32" rx="8" class="fill-neutral-900 dark:fill-neutral-100" />
    <path d="M9.5 21.5V15.75M15 21.5V11M20.5 21.5V18" class="stroke-white dark:stroke-neutral-900" stroke-width="2.25" stroke-linecap="round" />
    <circle cx="23.75" cy="9.25" r="1.75" class="fill-brand-400 dark:fill-neutral-500" />
</svg>