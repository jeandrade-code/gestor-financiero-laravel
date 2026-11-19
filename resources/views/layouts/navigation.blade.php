<nav class="bg-white dark:bg-neutral-900 border-b border-neutral-200 dark:border-neutral-700 sticky top-0 z-40 safe-top" aria-label="Navegación principal">
    <div class="container-app">
        <div class="flex h-16 items-center justify-between">
            <!-- Logo & Brand -->
            <div class="flex items-center gap-8">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2" aria-label="{{ config('app.name') }} - Inicio">
                    <svg class="w-8 h-8 text-brand-600 dark:text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-heading-sm font-semibold text-neutral-900 dark:text-neutral-50 hidden sm:block">{{ config('app.name') }}</span>
                </a>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center gap-1">
                    <a href="{{ route('dashboard') }}"
                       class="px-3 py-2 rounded-lg text-body-sm font-medium text-neutral-600 dark:text-neutral-400 hover:bg-neutral-100 dark:hover:bg-neutral-800 hover:text-neutral-900 dark:hover:text-neutral-100 transition-colors {{ request()->routeIs('dashboard') ? 'bg-brand-50 text-brand-700 dark:bg-neutral-800/70 dark:text-neutral-300' : '' }}"
                       aria-current="{{ request()->routeIs('dashboard') ? 'page' : 'false' }}">
                        <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Inicio
                    </a>

                    <a href="{{ route('categorias.index') }}"
                       class="px-3 py-2 rounded-lg text-body-sm font-medium text-neutral-600 dark:text-neutral-400 hover:bg-neutral-100 dark:hover:bg-neutral-800 hover:text-neutral-900 dark:hover:text-neutral-100 transition-colors {{ request()->routeIs('categorias.*') ? 'bg-brand-50 text-brand-700 dark:bg-neutral-800/70 dark:text-neutral-300' : '' }}"
                       aria-current="{{ request()->routeIs('categorias.*') ? 'page' : 'false' }}">
                        <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                        Categorías
                    </a>

                    <a href="{{ route('cuentas.index') }}"
                       class="px-3 py-2 rounded-lg text-body-sm font-medium text-neutral-600 dark:text-neutral-400 hover:bg-neutral-100 dark:hover:bg-neutral-800 hover:text-neutral-900 dark:hover:text-neutral-100 transition-colors {{ request()->routeIs('cuentas.*') ? 'bg-brand-50 text-brand-700 dark:bg-neutral-800/70 dark:text-neutral-300' : '' }}"
                       aria-current="{{ request()->routeIs('cuentas.*') ? 'page' : 'false' }}">
                        <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        Cuentas
                    </a>

                    <a href="{{ route('transacciones.index') }}"
                       class="px-3 py-2 rounded-lg text-body-sm font-medium text-neutral-600 dark:text-neutral-400 hover:bg-neutral-100 dark:hover:bg-neutral-800 hover:text-neutral-900 dark:hover:text-neutral-100 transition-colors {{ request()->routeIs('transacciones.*') ? 'bg-brand-50 text-brand-700 dark:bg-neutral-800/70 dark:text-neutral-300' : '' }}"
                       aria-current="{{ request()->routeIs('transacciones.*') ? 'page' : 'false' }}">
                        <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Transacciones
                    </a>
                </div>
            </div>

            <!-- User Menu & Actions -->
            <div class="flex items-center gap-3">
                <!-- Theme Toggle -->
                <button type="button"
                        id="theme-toggle"
                        class="p-2 rounded-lg text-neutral-600 dark:text-neutral-400 hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-500"
                        aria-label="Cambiar tema"
                        aria-pressed="false">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true" data-sun>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    <svg class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true" data-moon>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                    </svg>
                </button>

                <!-- User Dropdown -->
                <div class="relative" id="user-menu">
                    <button type="button"
                            class="flex items-center gap-2 p-1.5 rounded-lg text-neutral-700 dark:text-neutral-300 hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-500"
                            aria-expanded="false"
                            aria-haspopup="true"
                            aria-label="Menú de usuario"
                            onclick="toggleUserMenu()">
                        <div class="w-8 h-8 rounded-full bg-brand-100 dark:bg-neutral-800/70 flex items-center justify-center">
                            <span class="text-body-sm font-semibold text-brand-700 dark:text-neutral-300">{{ auth()->user() ? strtoupper(auth()->user()->name[0]) : 'U' }}</span>
                        </div>
                        <span class="hidden sm:block text-body-sm font-medium">{{ auth()->user()->name }}</span>
                        <svg class="w-4 h-4 hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div class="absolute right-0 mt-2 w-48 bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-700 rounded-xl shadow-lg py-1 opacity-0 invisible transform translate-y-1 transition-all duration-150 ease-out" id="user-dropdown" role="menu" aria-orientation="vertical">
                        <div class="px-4 py-3 border-b border-neutral-200 dark:border-neutral-700">
                            <p class="text-body-sm font-semibold text-neutral-900 dark:text-neutral-50">{{ auth()->user()->name }}</p>
                            <p class="text-caption text-neutral-500 dark:text-neutral-400 truncate">{{ auth()->user()->email }}</p>
                        </div>
                        <a href="{{ route('profile.edit') }}"
                           class="flex items-center gap-3 px-4 py-2.5 text-body-sm text-neutral-700 dark:text-neutral-300 hover:bg-neutral-50 dark:hover:bg-neutral-800 transition-colors"
                           role="menuitem">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Mi perfil
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <button type="submit"
                                    class="flex items-center gap-3 w-full px-4 py-2.5 text-body-sm text-expense-600 dark:text-expense-400 hover:bg-neutral-50 dark:hover:bg-neutral-800 transition-colors text-left"
                                    role="menuitem">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                Cerrar sesión
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Mobile menu button -->
                <button type="button"
                        class="md:hidden p-2 rounded-lg text-neutral-600 dark:text-neutral-400 hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-500"
                        aria-label="Abrir menú"
                        aria-expanded="false"
                        aria-controls="mobile-menu"
                        onclick="toggleMobileMenu()">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true" data-open>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true" data-close>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation -->
        <div class="md:hidden hidden border-t border-neutral-200 dark:border-neutral-700 py-4" id="mobile-menu" role="navigation" aria-label="Navegación móvil">
            <nav class="flex flex-col gap-1">
                <a href="{{ route('dashboard') }}"
                   class="px-3 py-2.5 rounded-lg text-body font-medium text-neutral-600 dark:text-neutral-400 hover:bg-neutral-100 dark:hover:bg-neutral-800 hover:text-neutral-900 dark:hover:text-neutral-100 transition-colors {{ request()->routeIs('dashboard') ? 'bg-brand-50 text-brand-700 dark:bg-neutral-800/70 dark:text-neutral-300' : '' }}"
                   aria-current="{{ request()->routeIs('dashboard') ? 'page' : 'false' }}">
                    Inicio
                </a>
                <a href="{{ route('categorias.index') }}"
                   class="px-3 py-2.5 rounded-lg text-body font-medium text-neutral-600 dark:text-neutral-400 hover:bg-neutral-100 dark:hover:bg-neutral-800 hover:text-neutral-900 dark:hover:text-neutral-100 transition-colors {{ request()->routeIs('categorias.*') ? 'bg-brand-50 text-brand-700 dark:bg-neutral-800/70 dark:text-neutral-300' : '' }}"
                   aria-current="{{ request()->routeIs('categorias.*') ? 'page' : 'false' }}">
                    Categorías
                </a>
                <a href="{{ route('cuentas.index') }}"
                   class="px-3 py-2.5 rounded-lg text-body font-medium text-neutral-600 dark:text-neutral-400 hover:bg-neutral-100 dark:hover:bg-neutral-800 hover:text-neutral-900 dark:hover:text-neutral-100 transition-colors {{ request()->routeIs('cuentas.*') ? 'bg-brand-50 text-brand-700 dark:bg-neutral-800/70 dark:text-neutral-300' : '' }}"
                   aria-current="{{ request()->routeIs('cuentas.*') ? 'page' : 'false' }}">
                    Cuentas
                </a>
                <a href="{{ route('transacciones.index') }}"
                   class="px-3 py-2.5 rounded-lg text-body font-medium text-neutral-600 dark:text-neutral-400 hover:bg-neutral-100 dark:hover:bg-neutral-800 hover:text-neutral-900 dark:hover:text-neutral-100 transition-colors {{ request()->routeIs('transacciones.*') ? 'bg-brand-50 text-brand-700 dark:bg-neutral-800/70 dark:text-neutral-300' : '' }}"
                   aria-current="{{ request()->routeIs('transacciones.*') ? 'page' : 'false' }}">
                    Transacciones
                </a>
            </nav>
        </div>
    </div>
</nav>

<script>
    // Theme toggle
    const themeToggle = document.getElementById('theme-toggle');
    const sunIcon = themeToggle.querySelector('[data-sun]');
    const moonIcon = themeToggle.querySelector('[data-moon]');

    function updateThemeIcons() {
        if (document.documentElement.classList.contains('dark')) {
            sunIcon.classList.add('hidden');
            moonIcon.classList.remove('hidden');
            themeToggle.setAttribute('aria-pressed', 'true');
        } else {
            sunIcon.classList.remove('hidden');
            moonIcon.classList.add('hidden');
            themeToggle.setAttribute('aria-pressed', 'false');
        }
    }

    themeToggle.addEventListener('click', () => {
        document.documentElement.classList.toggle('dark');
        localStorage.setItem('theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light');
        updateThemeIcons();
    });

    // Initialize theme from localStorage or system preference
    if (localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark');
    }
    updateThemeIcons();

    // User dropdown
    let userDropdownOpen = false;
    const userMenu = document.getElementById('user-menu');
    const userDropdown = document.getElementById('user-dropdown');
    const userMenuButton = userMenu?.querySelector('button');

    function toggleUserMenu() {
        userDropdownOpen = !userDropdownOpen;
        if (userDropdownOpen) {
            userDropdown.classList.remove('opacity-0', 'invisible', 'translate-y-1');
            userDropdown.classList.add('opacity-100', 'visible', 'translate-y-0');
            userMenuButton?.setAttribute('aria-expanded', 'true');
        } else {
            userDropdown.classList.add('opacity-0', 'invisible', 'translate-y-1');
            userDropdown.classList.remove('opacity-100', 'visible', 'translate-y-0');
            userMenuButton?.setAttribute('aria-expanded', 'false');
        }
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', (e) => {
        if (userDropdownOpen && !userMenu.contains(e.target)) {
            toggleUserMenu();
        }
    });

    // Mobile menu
    let mobileMenuOpen = false;
    const mobileMenu = document.getElementById('mobile-menu');
    const mobileMenuButton = document.querySelector('[aria-controls="mobile-menu"]');
    const mobileMenuOpenIcon = mobileMenuButton?.querySelector('[data-open]');
    const mobileMenuCloseIcon = mobileMenuButton?.querySelector('[data-close]');

    function toggleMobileMenu() {
        mobileMenuOpen = !mobileMenuOpen;
        if (mobileMenuOpen) {
            mobileMenu.classList.remove('hidden');
            mobileMenuOpenIcon?.classList.add('hidden');
            mobileMenuCloseIcon?.classList.remove('hidden');
            mobileMenuButton?.setAttribute('aria-expanded', 'true');
            document.body.style.overflow = 'hidden';
        } else {
            mobileMenu.classList.add('hidden');
            mobileMenuOpenIcon?.classList.remove('hidden');
            mobileMenuCloseIcon?.classList.add('hidden');
            mobileMenuButton?.setAttribute('aria-expanded', 'false');
            document.body.style.overflow = '';
        }
    }

    // Close mobile menu on link click
    mobileMenu?.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => {
            if (mobileMenuOpen) toggleMobileMenu();
        });
    });

    // Close dropdowns on Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            if (userDropdownOpen) toggleUserMenu();
            if (mobileMenuOpen) toggleMobileMenu();
        }
    });
</script>