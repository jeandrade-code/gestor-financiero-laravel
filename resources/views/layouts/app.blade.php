<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover, interactive-widget=resizes-content">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="theme-color" media="(prefers-color-scheme: light)" content="#ffffff">
        <meta name="theme-color" media="(prefers-color-scheme: dark)" content="#0f172a">
        <meta name="color-scheme" content="light dark">

        <title>{{ config('app.name', 'Gestor Financiero') }} {{ isset($title) ? '| ' . $title : '' }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&family=Plus+Jakarta+Sans:wght@500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts & Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased h-full bg-neutral-50 dark:bg-neutral-950 text-neutral-900 dark:text-neutral-50 flex flex-col">
        <!-- Skip link for accessibility -->
        <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 z-50 bg-brand-600 text-white px-4 py-2 rounded-lg">
            Saltar al contenido principal
        </a>

        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white dark:bg-neutral-900 border-b border-neutral-200 dark:border-neutral-700 sticky top-0 z-20 safe-top">
                <div class="container-app py-4">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main id="main-content" class="flex-1 w-full">
            <div class="container-app py-6 sm:py-8">
                @if (session('estado'))
                    <div class="mb-6 animate-in" role="status" aria-live="polite">
                        <x-alert type="success" :message="session('estado')" />
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 animate-in" role="alert" aria-live="assertive">
                        <x-alert type="error" :message="session('error')" />
                    </div>
                @endif

                {{ $slot }}
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white dark:bg-neutral-900 border-t border-neutral-200 dark:border-neutral-700 safe-bottom">
            <div class="container-app py-4">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4 text-body-sm text-neutral-500 dark:text-neutral-400">
                    <p>{{ config('app.name') }} &copy; {{ date('Y') }}</p>
                    <div class="flex items-center gap-4">
                        <a href="#" class="hover:text-brand-600 dark:hover:text-brand-400 transition-colors">Privacidad</a>
                        <a href="#" class="hover:text-brand-600 dark:hover:text-brand-400 transition-colors">Términos</a>
                        <a href="#" class="hover:text-brand-600 dark:hover:text-brand-400 transition-colors">Soporte</a>
                    </div>
                </div>
            </div>
        </footer>

        @stack('modals')
    </body>
</html>