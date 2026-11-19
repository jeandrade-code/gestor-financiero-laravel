@props(['title' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="theme-color" media="(prefers-color-scheme: light)" content="#ffffff">
        <meta name="theme-color" media="(prefers-color-scheme: dark)" content="#0c110e">
        <meta name="color-scheme" content="light dark">
        <meta name="robots" content="noindex">

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
    <body class="h-full bg-white font-sans text-neutral-900 antialiased dark:bg-neutral-950 dark:text-neutral-100">
        <div class="min-h-screen lg:grid lg:grid-cols-[1.08fr_1fr]">
            <!-- Brand panel -->
            <aside class="relative hidden overflow-hidden bg-neutral-950 text-neutral-100 lg:flex lg:flex-col lg:justify-between lg:p-12 xl:p-16" aria-hidden="true">
                <div class="pointer-events-none absolute inset-0 opacity-[0.06]"
                     style="background-image: linear-gradient(to right, #fff 1px, transparent 1px), linear-gradient(to bottom, #fff 1px, transparent 1px); background-size: 56px 56px;"></div>
                <div class="pointer-events-none absolute -right-40 -top-40 h-[28rem] w-[28rem] rounded-full bg-brand-500/10 blur-3xl"></div>

                <a href="{{ route('home') }}" class="relative z-10 inline-flex items-center gap-2.5">
                    <x-brand-mark class="h-8 w-8" />
                    <span class="flex flex-col leading-none">
                        <span class="text-[0.8125rem] font-semibold tracking-tight text-white">Gestor Financiero</span>
                        <span class="mt-1 text-[0.625rem] font-medium uppercase tracking-[0.14em] text-neutral-500">Control de saldos</span>
                    </span>
                </a>

                <div class="relative z-10 max-w-md">
                    <p class="text-[0.6875rem] font-medium uppercase tracking-[0.14em] text-brand-300">Claridad financiera</p>
                    <h1 class="mt-4 font-display text-[2.75rem] leading-[1.06] tracking-tight text-white xl:text-[3.25rem]">
                        Cada peso,<br />
                        <span class="italic text-brand-300">en su lugar.</span>
                    </h1>
                    <p class="mt-5 max-w-sm text-[0.875rem] leading-relaxed text-neutral-400">
                        Registra de dónde viene tu dinero, en qué lo gastas y cuánto queda. Un solo lugar para tus cuentas y tus decisiones.
                    </p>

                    <div class="mt-10 rounded-lg border border-white/10 bg-white/[0.03] p-4 backdrop-blur-sm">
                        <div class="flex items-center justify-between border-b border-white/10 pb-3">
                            <span class="text-[0.625rem] font-medium uppercase tracking-[0.12em] text-neutral-500">Cuenta Caja · COP</span>
                            <span class="rounded border border-white/10 px-1.5 py-0.5 text-[0.5625rem] font-medium uppercase tracking-[0.1em] text-neutral-400">Ejemplo</span>
                        </div>
                        <dl class="mt-3 space-y-2 text-[0.75rem]">
                            <div class="flex items-center justify-between">
                                <dt class="text-neutral-400">Saldo inicial</dt>
                                <dd class="font-mono tabular-nums text-neutral-200">$200.000,00</dd>
                            </div>
                            <div class="flex items-center justify-between">
                                <dt class="text-neutral-400">Ingreso · Salario</dt>
                                <dd class="font-mono tabular-nums text-income-300">+$150.000,00</dd>
                            </div>
                            <div class="flex items-center justify-between">
                                <dt class="text-neutral-400">Gasto · Servicios</dt>
                                <dd class="font-mono tabular-nums text-expense-300">−$20.000,00</dd>
                            </div>
                        </dl>
                        <div class="mt-3 flex items-baseline justify-between border-t border-white/10 pt-3">
                            <span class="text-[0.6875rem] font-medium uppercase tracking-[0.1em] text-neutral-400">Saldo final</span>
                            <span class="font-mono text-[1.0625rem] font-medium tabular-nums text-white">$330.000,00</span>
                        </div>
                    </div>
                </div>

                <p class="relative z-10 text-[0.6875rem] leading-relaxed text-neutral-500">
                    Los saldos se actualizan al registrar, editar o eliminar un movimiento.
                </p>
            </aside>

            <!-- Form panel -->
            <main class="flex min-h-screen flex-col">
                <div class="flex items-center justify-between px-5 py-5 sm:px-8 lg:justify-end">
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-2.5 lg:hidden">
                        <x-brand-mark class="h-7 w-7" />
                        <span class="text-[0.8125rem] font-semibold tracking-tight text-neutral-900 dark:text-neutral-50">Gestor Financiero</span>
                    </a>
                    <div class="flex items-center gap-1">
                        <a href="{{ route('home') }}" class="hidden rounded-md px-2.5 py-1.5 text-[0.75rem] font-medium text-neutral-500 transition-colors hover:bg-neutral-100 hover:text-neutral-800 sm:block dark:text-neutral-400 dark:hover:bg-neutral-800 dark:hover:text-neutral-100">
                            Volver al inicio
                        </a>
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
                    </div>
                </div>

                <div class="flex flex-1 items-center justify-center px-5 pb-10 pt-2 sm:px-8">
                    <div class="w-full max-w-[25rem]">
                        {{ $slot }}
                    </div>
                </div>

                <div class="flex flex-col items-center gap-2 px-6 pb-6 text-center text-[0.6875rem] text-neutral-400 sm:flex-row sm:justify-between dark:text-neutral-500">
                    <p>&copy; {{ date('Y') }} Gestor Financiero</p>
                    <p>Datos protegidos con cifrado de Laravel</p>
                </div>
            </main>
        </div>
    </body>
</html>