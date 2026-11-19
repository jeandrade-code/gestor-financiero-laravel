@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Paginación" class="flex items-center gap-1">
        {{-- Previous --}}
        @if ($paginator->onFirstPage())
            <span class="btn-ghost btn-sm btn-icon cursor-not-allowed text-neutral-300 dark:text-neutral-600" aria-disabled="true" aria-label="Página anterior">
                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 19l-7-7 7-7" />
                </svg>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="btn-ghost btn-sm btn-icon" aria-label="Página anterior">
                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
        @endif

        {{-- Pages --}}
        <div class="hidden items-center gap-1 sm:flex">
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="px-1.5 text-[0.75rem] text-neutral-400">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span aria-current="page" class="inline-flex h-8 min-w-8 items-center justify-center rounded-md bg-neutral-900 px-2 text-[0.75rem] font-medium tabular-nums text-white dark:bg-neutral-100 dark:text-neutral-900">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="inline-flex h-8 min-w-8 items-center justify-center rounded-md px-2 text-[0.75rem] tabular-nums text-neutral-500 transition-colors hover:bg-neutral-100 hover:text-neutral-900 dark:text-neutral-400 dark:hover:bg-neutral-800 dark:hover:text-neutral-100">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>

        <span class="px-1 text-[0.75rem] text-neutral-500 sm:hidden dark:text-neutral-400">
            Página {{ $paginator->currentPage() }} de {{ $paginator->lastPage() }}
        </span>

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="btn-ghost btn-sm btn-icon" aria-label="Página siguiente">
                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        @else
            <span class="btn-ghost btn-sm btn-icon cursor-not-allowed text-neutral-300 dark:text-neutral-600" aria-disabled="true" aria-label="Página siguiente">
                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 5l7 7-7 7" />
                </svg>
            </span>
        @endif
    </nav>
@endif