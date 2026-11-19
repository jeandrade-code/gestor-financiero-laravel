@props(['title', 'description' => null, 'eyebrow' => null])

<div {{ $attributes->merge(['class' => 'page-header']) }}>
    <div class="min-w-0">
        @if ($eyebrow)
            <p class="eyebrow mb-2">{{ $eyebrow }}</p>
        @endif
        <h1 class="page-title">{{ $title }}</h1>
        @if ($description)
            <p class="page-description">{{ $description }}</p>
        @endif
    </div>

    @if (isset($actions) || ! $slot->isEmpty())
        <div class="page-actions">
            {{ $actions ?? $slot }}
        </div>
    @endif
</div>