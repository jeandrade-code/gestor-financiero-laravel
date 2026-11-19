@php
    $section = match (true) {
        request()->routeIs('dashboard') => 'Panel',
        request()->routeIs('transacciones.*') => 'Transacciones',
        request()->routeIs('cuentas.*') => 'Cuentas',
        request()->routeIs('categorias.*') => 'Categorías',
        request()->routeIs('profile.*') => 'Mi perfil',
        default => 'Gestor Financiero',
    };
@endphp

<header class="sticky top-0 z-30 border-b border-neutral-200 bg-neutral-50/85 backdrop-blur-md dark:border-neutral-800 dark:bg-neutral-950/80">
    <div class="flex h-14 items-center gap-3 px-4 sm:h-16 sm:px-6 lg:px-8">
        <!-- Mobile: drawer trigger -->
        <button type="button"
                @click="sidebar = true"
                class="-ml-1 rounded-md p-2 text-neutral-600 transition-colors hover:bg-neutral-100 hover:text-neutral-900 dark:text-neutral-400 dark:hover:bg-neutral-800 dark:hover:text-neutral-100 lg:hidden"
                aria-label="Abrir menú de navegación"
                aria-controls="app-sidebar">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M4 7h16M4 12h16M4 17h16" />
            </svg>
        </button>

        <!-- Mobile: brand -->
        <div class="flex min-w-0 items-center gap-2 lg:hidden">
            <x-brand-mark class="h-6 w-6" />
            <span class="truncate text-[0.8125rem] font-semibold tracking-tight text-neutral-900 dark:text-neutral-50">Gestor Financiero</span>
        </div>

        <!-- Desktop: collapse the sidebar -->
        <button type="button"
                @click="toggleCollapsed()"
                :aria-pressed="collapsed"
                :aria-label="collapsed ? 'Expandir menú lateral' : 'Minimizar menú lateral'"
                :title="collapsed ? 'Expandir menú lateral' : 'Minimizar menú lateral'"
                class="-ml-1 hidden rounded-md p-2 text-neutral-500 transition-colors hover:bg-neutral-100 hover:text-neutral-900 dark:text-neutral-400 dark:hover:bg-neutral-800 dark:hover:text-neutral-100 lg:inline-flex">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" :d="collapsed ? 'M13 7l5 5-5 5m-6-10l5 5-5 5' : 'M11 7l-5 5 5 5m6-10l-5 5 5 5'" />
            </svg>
        </button>

        <!-- Desktop: breadcrumb -->
        <div class="hidden min-w-0 items-center gap-2 lg:flex">
            <span class="text-[0.8125rem] text-neutral-400 dark:text-neutral-500">Espacio de trabajo</span>
            <svg class="h-3.5 w-3.5 text-neutral-300 dark:text-neutral-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <span class="truncate text-[0.8125rem] font-medium text-neutral-800 dark:text-neutral-200">{{ $section }}</span>
        </div>

        <div class="ml-auto flex items-center gap-1 sm:gap-2">
            <button type="button"
                    @click="document.documentElement.classList.toggle('dark'); localStorage.setItem('theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light')"
                    class="rounded-md p-2 text-neutral-500 transition-colors hover:bg-neutral-100 hover:text-neutral-800 dark:text-neutral-400 dark:hover:bg-neutral-800 dark:hover:text-neutral-100"
                    aria-label="Cambiar entre tema claro y oscuro">
                <svg class="h-4 w-4 dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                </svg>
                <svg class="hidden h-4 w-4 dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </button>

            <div x-data="{ open: false }"
                 @click.outside="open = false"
                 @keydown.escape.window="open = false"
                 class="relative">
                <button type="button"
                        @click="open = !open"
                        :aria-expanded="open"
                        class="flex items-center gap-2 rounded-md p-1 transition-colors hover:bg-neutral-100 dark:hover:bg-neutral-800"
                        aria-haspopup="menu"
                        aria-label="Abrir menú de usuario">
                    <span class="flex h-8 w-8 items-center justify-center rounded-full border border-neutral-200 bg-white text-[0.75rem] font-semibold text-neutral-700 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-200">
                        {{ auth()->user() ? strtoupper(mb_substr(auth()->user()->name, 0, 1)) : 'U' }}
                    </span>
                    <svg class="hidden h-3.5 w-3.5 text-neutral-400 sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div x-show="open"
                     x-cloak
                     x-transition:enter="transition ease-out duration-150"
                     x-transition:enter-start="opacity-0 translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-100"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 translate-y-1"
                     class="absolute right-0 z-50 mt-2 w-56 origin-top-right overflow-hidden rounded-lg border border-neutral-200 bg-white shadow-menu dark:border-neutral-700 dark:bg-neutral-900"
                     role="menu">
                    <div class="border-b border-neutral-200 px-3.5 py-3 dark:border-neutral-800">
                        <p class="truncate text-[0.8125rem] font-medium text-neutral-900 dark:text-neutral-100">{{ auth()->user()->name }}</p>
                        <p class="mt-0.5 truncate text-[0.6875rem] text-neutral-500 dark:text-neutral-400">{{ auth()->user()->email }}</p>
                    </div>
                    <div class="p-1">
                        <a href="{{ route('profile.edit') }}"
                           class="flex items-center gap-2.5 rounded-md px-2.5 py-2 text-[0.8125rem] text-neutral-600 transition-colors hover:bg-neutral-100 hover:text-neutral-900 dark:text-neutral-300 dark:hover:bg-neutral-800 dark:hover:text-white"
                           role="menuitem">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Mi perfil
                        </a>
                        <a href="{{ route('cuentas.index') }}"
                           class="flex items-center gap-2.5 rounded-md px-2.5 py-2 text-[0.8125rem] text-neutral-600 transition-colors hover:bg-neutral-100 hover:text-neutral-900 dark:text-neutral-300 dark:hover:bg-neutral-800 dark:hover:text-white"
                           role="menuitem">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 10h18M5 6h14a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2z" />
                            </svg>
                            Cuentas
                        </a>
                    </div>
                    <div class="border-t border-neutral-200 p-1 dark:border-neutral-800">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="flex w-full items-center gap-2.5 rounded-md px-2.5 py-2 text-left text-[0.8125rem] text-neutral-600 transition-colors hover:bg-neutral-100 hover:text-expense-700 dark:text-neutral-300 dark:hover:bg-neutral-800 dark:hover:text-expense-400"
                                    role="menuitem">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M17 16l4-4m0 0l-4-4m4 4H8m5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Cerrar sesión
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>