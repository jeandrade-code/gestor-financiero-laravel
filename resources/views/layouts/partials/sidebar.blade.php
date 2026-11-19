@php
    $navItems = [
        ['route' => 'dashboard', 'pattern' => 'dashboard', 'label' => 'Panel', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
        ['route' => 'transacciones.index', 'pattern' => 'transacciones.*', 'label' => 'Transacciones', 'icon' => 'M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4'],
        ['route' => 'cuentas.index', 'pattern' => 'cuentas.*', 'label' => 'Cuentas', 'icon' => 'M3 10h18M5 6h14a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2zm2 3h4'],
    ];

    $setupItems = [
        ['route' => 'categorias.index', 'pattern' => 'categorias.*', 'label' => 'Categorías', 'icon' => 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z'],
    ];
@endphp

<div class="flex h-full flex-col">
    <div class="flex h-16 items-center border-b border-neutral-200 px-4 dark:border-neutral-800">
        <a href="{{ route('dashboard') }}" class="sidebar-brand flex items-center gap-2.5" aria-label="{{ config('app.name') }} — Inicio">
            <x-brand-mark class="h-8 w-8 shrink-0" />
            <span class="sidebar-label flex flex-col leading-none">
                <span class="text-[0.8125rem] font-semibold tracking-tight text-neutral-900 dark:text-neutral-50">Gestor Financiero</span>
                <span class="mt-1 text-[0.625rem] font-medium uppercase tracking-[0.14em] text-neutral-400 dark:text-neutral-500">Control de saldos</span>
            </span>
        </a>
    </div>

    <div class="flex-1 overflow-y-auto px-3 pb-4">
        <p class="nav-section">Espacio de trabajo</p>
        <nav class="space-y-0.5" aria-label="Módulos principales">
            @foreach ($navItems as $item)
                @php($active = request()->routeIs($item['pattern']))
                <a href="{{ route($item['route']) }}"
                   class="nav-item {{ $active ? 'nav-item-active' : '' }}"
                   title="{{ $item['label'] }}"
                   aria-label="{{ $item['label'] }}"
                   @if ($active) aria-current="page" @endif>
                    <svg class="h-[1.125rem] w-[1.125rem] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="{{ $item['icon'] }}" />
                    </svg>
                    <span class="sidebar-label">{{ $item['label'] }}</span>
                </a>
            @endforeach
        </nav>

        <p class="nav-section">Configuración</p>
        <nav class="space-y-0.5" aria-label="Configuración">
            @foreach ($setupItems as $item)
                @php($active = request()->routeIs($item['pattern']))
                <a href="{{ route($item['route']) }}"
                   class="nav-item {{ $active ? 'nav-item-active' : '' }}"
                   title="{{ $item['label'] }}"
                   aria-label="{{ $item['label'] }}"
                   @if ($active) aria-current="page" @endif>
                    <svg class="h-[1.125rem] w-[1.125rem] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="{{ $item['icon'] }}" />
                    </svg>
                    <span class="sidebar-label">{{ $item['label'] }}</span>
                </a>
            @endforeach
            <a href="{{ route('profile.edit') }}"
               class="nav-item {{ request()->routeIs('profile.*') ? 'nav-item-active' : '' }}"
               title="Mi perfil"
               aria-label="Mi perfil">
                <svg class="h-[1.125rem] w-[1.125rem] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <span class="sidebar-label">Mi perfil</span>
            </a>
        </nav>

    </div>

    <div class="border-t border-neutral-200 p-3 dark:border-neutral-800">
        <div class="sidebar-user-row flex items-center gap-2.5 rounded-md px-2 py-1.5">
            <span class="sidebar-user-avatar flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-brand-50 text-[0.75rem] font-semibold text-brand-700 dark:bg-neutral-800/70 dark:text-neutral-300">
                {{ auth()->user() ? strtoupper(mb_substr(auth()->user()->name, 0, 1)) : 'U' }}
            </span>
            <div class="sidebar-user-details min-w-0 flex-1">
                <p class="truncate text-[0.8125rem] font-medium text-neutral-900 dark:text-neutral-100">{{ auth()->user()->name }}</p>
                <p class="truncate text-[0.6875rem] text-neutral-500 dark:text-neutral-400">{{ auth()->user()->email }}</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="rounded-md p-1.5 text-neutral-400 transition-colors hover:bg-neutral-100 hover:text-neutral-700 dark:hover:bg-neutral-800 dark:hover:text-neutral-200"
                        aria-label="Cerrar sesión"
                        title="Cerrar sesión">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M17 16l4-4m0 0l-4-4m4 4H8m5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </button>
            </form>
        </div>
    </div>
</div>