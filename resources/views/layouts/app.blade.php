<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover, interactive-widget=resizes-content">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="theme-color" media="(prefers-color-scheme: light)" content="#fafaf8">
        <meta name="theme-color" media="(prefers-color-scheme: dark)" content="#0c110e">
        <meta name="color-scheme" content="light dark">
        <meta name="description" content="Gestor Financiero: registra ingresos, controla gastos y consulta el saldo real de cada cuenta.">

        <title>{{ config('app.name', 'Gestor Financiero') }}{{ isset($title) ? ' · '.$title : '' }}</title>

        <script>
            (function () {
                try {
                    var theme = localStorage.getItem('theme');
                    if (theme === 'dark' || (! theme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                        document.documentElement.classList.add('dark');
                    }
                    if (localStorage.getItem('sidebar') === 'collapsed') {
                        document.documentElement.classList.add('sidebar-collapsed');
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

        <div x-data="{
                 sidebar: false,
                 collapsed: document.documentElement.classList.contains('sidebar-collapsed'),
                 toggleCollapsed() {
                     this.collapsed = ! this.collapsed;
                     document.documentElement.classList.toggle('sidebar-collapsed', this.collapsed);
                     try {
                         localStorage.setItem('sidebar', this.collapsed ? 'collapsed' : 'expanded');
                     } catch (error) {}
                 }
             }"
             @keydown.escape.window="sidebar = false"
             class="min-h-screen">
            <!-- Mobile overlay -->
            <div x-show="sidebar"
                 x-cloak
                 x-transition.opacity
                 @click="sidebar = false"
                 class="fixed inset-0 z-40 bg-neutral-950/40 backdrop-blur-sm lg:hidden"
                 aria-hidden="true"></div>

            <!-- Sidebar -->
            <aside id="app-sidebar"
                   class="fixed inset-y-0 left-0 z-50 w-[15.5rem] -translate-x-full border-r border-neutral-200 bg-white transition-transform duration-200 ease-out lg:translate-x-0 dark:border-neutral-800 dark:bg-neutral-900"
                   :class="sidebar ? '!translate-x-0' : ''"
                   aria-label="Navegación lateral">
                @include('layouts.partials.sidebar')
            </aside>

            <div id="app-shell" class="flex min-h-screen flex-col lg:pl-[15.5rem]">
                @include('layouts.partials.topbar')

                <main id="main-content" class="flex-1">
                    <div class="mx-auto w-full max-w-[80rem] px-4 py-6 sm:px-6 sm:py-8 lg:px-8">
                        @if (session('estado'))
                            <div class="mb-5" role="status" aria-live="polite">
                                <x-alert type="success" :message="session('estado')" />
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="mb-5" role="alert" aria-live="assertive">
                                <x-alert type="error" :message="session('error')" />
                            </div>
                        @endif

                        {{ $header ?? '' }}

                        {{ $slot }}
                    </div>
                </main>

                @include('layouts.partials.footer')
            </div>
        </div>

        @stack('modals')
        @stack('scripts')
    </body>
</html>