<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="theme-color" media="(prefers-color-scheme: light)" content="#fafaf8">
        <meta name="theme-color" media="(prefers-color-scheme: dark)" content="#0c110e">
        <meta name="color-scheme" content="light dark">
        <meta name="description" content="Gestor Financiero: una forma clara de registrar ingresos, controlar gastos y conocer el saldo de cada cuenta.">

        <title>{{ $title ?? config('app.name', 'Gestor Financiero') }}</title>

        <script>
            (function () {
                try {
                    var theme = localStorage.getItem('theme');
                    if (theme === 'dark' || (! theme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                        document.documentElement.classList.add('dark');
                    }
                } catch (error) {}
            })();
        </script>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Instrument+Serif:ital@0;1&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="h-full bg-neutral-50 font-sans text-neutral-900 antialiased dark:bg-neutral-950 dark:text-neutral-100">
        <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-[100] focus:rounded-md focus:bg-brand-700 focus:px-3 focus:py-2 focus:text-[0.8125rem] focus:font-medium focus:text-white">
            Saltar al contenido principal
        </a>

        <div class="flex min-h-screen flex-col">
            <header class="sticky top-0 z-40 border-b border-neutral-200/80 bg-neutral-50/85 backdrop-blur-md dark:border-neutral-800/80 dark:bg-neutral-950/80">
                <div class="container-app flex h-16 items-center justify-between gap-4">
                    <a href="{{ route('home') }}" class="flex items-center gap-2.5" aria-label="{{ config('app.name') }} — Inicio">
                        <x-brand-mark class="h-7 w-7" />
                        <span class="hidden text-[0.8125rem] font-semibold tracking-tight text-neutral-900 sm:block dark:text-neutral-50">Gestor Financiero</span>
                    </a>

                    <nav class="hidden items-center gap-7 md:flex" aria-label="Secciones del sitio">
                        <a href="#producto" class="text-[0.8125rem] text-neutral-500 transition-colors hover:text-neutral-900 dark:text-neutral-400 dark:hover:text-neutral-100">Producto</a>
                        <a href="#reglas" class="text-[0.8125rem] text-neutral-500 transition-colors hover:text-neutral-900 dark:text-neutral-400 dark:hover:text-neutral-100">Reglas del saldo</a>
                        <a href="#seguridad" class="text-[0.8125rem] text-neutral-500 transition-colors hover:text-neutral-900 dark:text-neutral-400 dark:hover:text-neutral-100">Seguridad</a>
                    </nav>

                    <div class="flex items-center gap-1.5 sm:gap-2">
                        <button type="button"
                                x-data
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

                        @auth
                            <a href="{{ route('dashboard') }}" class="btn-primary btn-sm">Ir al panel</a>
                        @else
                            <a href="{{ route('login') }}" class="btn-ghost btn-sm">Entrar</a>
                            <a href="{{ route('register') }}" class="btn-primary btn-sm">Crear cuenta</a>
                        @endauth
                    </div>
                </div>
            </header>

            <main id="main-content" class="flex-1">
                {{ $slot }}
            </main>

            <footer class="border-t border-neutral-200 bg-white dark:border-neutral-800 dark:bg-neutral-900">
                <div class="container-app py-12 lg:py-16">
                    <div class="grid grid-cols-2 gap-10 lg:grid-cols-[1.5fr_1fr_1fr_1fr]">
                        <div class="col-span-2 max-w-xs lg:col-span-1">
                            <a href="{{ route('home') }}" class="inline-flex items-center gap-2.5" aria-label="{{ config('app.name') }} — Inicio">
                                <x-brand-mark class="h-8 w-8" />
                                <span class="text-[0.875rem] font-semibold tracking-tight text-neutral-900 dark:text-neutral-50">Gestor Financiero</span>
                            </a>
                            <p class="mt-4 text-[0.8125rem] leading-relaxed text-neutral-500 dark:text-neutral-400">
                                Registra de dónde viene tu dinero, en qué lo gastas y cuánto queda en cada cuenta. Sin hojas de cálculo.
                            </p>
                            <p class="mt-5 font-mono text-[0.6875rem] uppercase tracking-[0.12em] text-neutral-400 dark:text-neutral-500">Laravel 13 · MySQL · ES</p>
                        </div>

                        <div>
                            <p class="eyebrow">Producto</p>
                            <ul class="mt-4 space-y-2.5 text-[0.8125rem]">
                                <li><a href="{{ route('login') }}" class="text-neutral-500 transition-colors hover:text-neutral-900 dark:text-neutral-400 dark:hover:text-neutral-100">Panel general</a></li>
                                <li><a href="#producto" class="text-neutral-500 transition-colors hover:text-neutral-900 dark:text-neutral-400 dark:hover:text-neutral-100">Cuentas y saldos</a></li>
                                <li><a href="#producto" class="text-neutral-500 transition-colors hover:text-neutral-900 dark:text-neutral-400 dark:hover:text-neutral-100">Ingresos y gastos</a></li>
                                <li><a href="#reglas" class="text-neutral-500 transition-colors hover:text-neutral-900 dark:text-neutral-400 dark:hover:text-neutral-100">Reglas del saldo</a></li>
                            </ul>
                        </div>

                        <div>
                            <p class="eyebrow">Acceso</p>
                            <ul class="mt-4 space-y-2.5 text-[0.8125rem]">
                                <li><a href="{{ route('login') }}" class="text-neutral-500 transition-colors hover:text-neutral-900 dark:text-neutral-400 dark:hover:text-neutral-100">Iniciar sesión</a></li>
                                <li><a href="{{ route('register') }}" class="text-neutral-500 transition-colors hover:text-neutral-900 dark:text-neutral-400 dark:hover:text-neutral-100">Crear una cuenta</a></li>
                                <li><a href="{{ route('password.request') }}" class="text-neutral-500 transition-colors hover:text-neutral-900 dark:text-neutral-400 dark:hover:text-neutral-100">Recuperar contraseña</a></li>
                            </ul>
                        </div>

                        <div>
                            <p class="eyebrow">Contacto</p>
                            <ul class="mt-4 space-y-2.5 text-[0.8125rem]">
                                <li><a href="mailto:soporte@gestorfinanciero.test" class="text-neutral-500 transition-colors hover:text-neutral-900 dark:text-neutral-400 dark:hover:text-neutral-100">Soporte</a></li>
                                <li><a href="#seguridad" class="text-neutral-500 transition-colors hover:text-neutral-900 dark:text-neutral-400 dark:hover:text-neutral-100">Privacidad</a></li>
                                <li><a href="{{ route('login') }}" class="text-neutral-500 transition-colors hover:text-neutral-900 dark:text-neutral-400 dark:hover:text-neutral-100">Términos de uso</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="mt-12 flex flex-col gap-3 border-t border-neutral-200 pt-5 text-[0.6875rem] text-neutral-400 sm:flex-row sm:items-center sm:justify-between dark:border-neutral-800 dark:text-neutral-500">
                        <p>&copy; {{ date('Y') }} Gestor Financiero. Todos los derechos reservados.</p>
                        <div class="flex flex-wrap items-center gap-x-5 gap-y-1">
                            <span>Proyecto académico — Programación III</span>
                            <span class="hidden h-3 w-px bg-neutral-200 sm:block dark:bg-neutral-700"></span>
                            <span>Interfaz en español</span>
                        </div>
                    </div>
                </div>
            </footer>
        </div>

        @stack('modals')
    </body>
</html>