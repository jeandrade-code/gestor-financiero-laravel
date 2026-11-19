<x-guest-layout title="Gestor Financiero — Cada peso, en su lugar">
    {{-- Hero --}}
    <section class="relative overflow-hidden border-b border-neutral-200 dark:border-neutral-800">
        <div class="pointer-events-none absolute inset-x-0 top-0 h-[28rem] bg-[radial-gradient(60%_60%_at_50%_0%,rgba(63,139,110,0.08),transparent)] dark:bg-[radial-gradient(60%_60%_at_50%_0%,rgba(63,139,110,0.10),transparent)]"></div>

        <div class="container-app relative grid gap-14 py-14 sm:py-20 lg:grid-cols-[1.02fr_0.98fr] lg:items-center lg:gap-16 lg:py-24">
            <div class="max-w-xl">
                <p class="eyebrow">Gestión financiera · Laravel + MySQL</p>

                <h1 class="mt-5 font-display text-display-xl text-neutral-900 dark:text-neutral-50">
                    Cada peso,<br />
                    <span class="italic text-brand-700 dark:text-neutral-400">en su lugar.</span>
                </h1>

                <p class="mt-6 max-w-lg text-body-lg leading-relaxed text-neutral-600 dark:text-neutral-400">
                    Registra de dónde viene tu dinero, en qué lo gastas y cuánto queda en cada cuenta. Un panel sencillo, con las reglas de tu negocio aplicadas de forma automática.
                </p>

                <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:items-center">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn-primary btn-lg">
                            Ir al panel
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </a>
                        <a href="{{ route('transacciones.create') }}" class="btn-secondary btn-lg">Registrar movimiento</a>
                    @else
                        <a href="{{ route('register') }}" class="btn-primary btn-lg">
                            Crear una cuenta
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </a>
                        <a href="{{ route('login') }}" class="btn-secondary btn-lg">Ya tengo cuenta</a>
                    @endauth
                </div>
            </div>

            {{-- Product preview --}}
            <div class="relative">
                <div class="overflow-hidden rounded-xl border border-neutral-200 bg-white shadow-xl dark:border-neutral-700 dark:bg-neutral-900">
                    <div class="flex items-center justify-between border-b border-neutral-200 px-3.5 py-2.5 dark:border-neutral-800">
                        <div class="flex items-center gap-1.5" aria-hidden="true">
                            <span class="h-2 w-2 rounded-full bg-neutral-200 dark:bg-neutral-700"></span>
                            <span class="h-2 w-2 rounded-full bg-neutral-200 dark:bg-neutral-700"></span>
                            <span class="h-2 w-2 rounded-full bg-neutral-200 dark:bg-neutral-700"></span>
                        </div>
                        <span class="font-mono text-[0.625rem] text-neutral-400 dark:text-neutral-500">gestorfinanciero.test/dashboard</span>
                        <span class="rounded border border-neutral-200 px-1.5 py-0.5 text-[0.5625rem] font-medium uppercase tracking-[0.08em] text-neutral-400 dark:border-neutral-700 dark:text-neutral-500">COP</span>
                    </div>

                    <div class="grid grid-cols-[6.5rem_1fr]">
                        <div class="hidden border-r border-neutral-200 p-2.5 sm:block dark:border-neutral-800">
                            <div class="flex items-center gap-1.5 px-1 py-1">
                                <x-brand-mark class="h-4 w-4" />
                                <span class="text-[0.5625rem] font-semibold text-neutral-700 dark:text-neutral-300">Gestor</span>
                            </div>
                            <div class="mt-3 space-y-0.5">
                                <div class="flex items-center gap-1.5 rounded bg-brand-50 px-1.5 py-1 text-[0.5625rem] font-medium text-brand-700 dark:bg-neutral-800/70 dark:text-neutral-300">
                                    <span class="h-2.5 w-2.5 rounded-sm bg-brand-500/20"></span> Panel
                                </div>
                                <div class="flex items-center gap-1.5 px-1.5 py-1 text-[0.5625rem] text-neutral-500 dark:text-neutral-400">
                                    <span class="h-2.5 w-2.5 rounded-sm bg-neutral-200 dark:bg-neutral-700"></span> Transacciones
                                </div>
                                <div class="flex items-center gap-1.5 px-1.5 py-1 text-[0.5625rem] text-neutral-500 dark:text-neutral-400">
                                    <span class="h-2.5 w-2.5 rounded-sm bg-neutral-200 dark:bg-neutral-700"></span> Cuentas
                                </div>
                                <div class="flex items-center gap-1.5 px-1.5 py-1 text-[0.5625rem] text-neutral-500 dark:text-neutral-400">
                                    <span class="h-2.5 w-2.5 rounded-sm bg-neutral-200 dark:bg-neutral-700"></span> Categorías
                                </div>
                            </div>
                        </div>

                        <div class="p-3.5 sm:p-4">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <p class="text-[0.5625rem] font-medium uppercase tracking-[0.1em] text-neutral-400">Saldo total</p>
                                    <p class="mt-1 font-mono text-[1.375rem] font-medium tabular-nums tracking-tight text-neutral-900 dark:text-neutral-50">$2.735.000,00</p>
                                </div>
                                <span class="rounded border border-income-200 bg-income-50 px-1.5 py-0.5 text-[0.5625rem] font-medium text-income-700 dark:border-neutral-700 dark:bg-neutral-800/70 dark:text-neutral-300">+$600.000</span>
                            </div>

                            <div class="mt-3 grid grid-cols-3 gap-1.5">
                                <div class="rounded border border-neutral-200 p-2 dark:border-neutral-800">
                                    <p class="text-[0.5rem] uppercase tracking-[0.08em] text-neutral-400">Ingresos</p>
                                    <p class="mt-1 font-mono text-[0.6875rem] font-medium text-income-700 dark:text-neutral-300">+$600.000</p>
                                </div>
                                <div class="rounded border border-neutral-200 p-2 dark:border-neutral-800">
                                    <p class="text-[0.5rem] uppercase tracking-[0.08em] text-neutral-400">Gastos</p>
                                    <p class="mt-1 font-mono text-[0.6875rem] font-medium text-expense-700 dark:text-expense-300">−$365.000</p>
                                </div>
                                <div class="rounded border border-neutral-200 p-2 dark:border-neutral-800">
                                    <p class="text-[0.5rem] uppercase tracking-[0.08em] text-neutral-400">Neto</p>
                                    <p class="mt-1 font-mono text-[0.6875rem] font-medium text-neutral-700 dark:text-neutral-200">+$235.000</p>
                                </div>
                            </div>

                            <div class="mt-3 overflow-hidden rounded border border-neutral-200 dark:border-neutral-800">
                                <div class="flex items-center justify-between border-b border-neutral-100 px-2.5 py-1.5 dark:border-neutral-800">
                                    <span class="text-[0.5625rem] font-medium text-neutral-700 dark:text-neutral-300">Caja</span>
                                    <span class="font-mono text-[0.625rem] tabular-nums text-neutral-600 dark:text-neutral-300">$330.000,00</span>
                                </div>
                                <div class="flex items-center justify-between border-b border-neutral-100 px-2.5 py-1.5 dark:border-neutral-800">
                                    <span class="text-[0.5625rem] font-medium text-neutral-700 dark:text-neutral-300">Bancolombia</span>
                                    <span class="font-mono text-[0.625rem] tabular-nums text-neutral-600 dark:text-neutral-300">$1.650.000,00</span>
                                </div>
                                <div class="flex items-center justify-between px-2.5 py-1.5">
                                    <span class="text-[0.5625rem] font-medium text-neutral-700 dark:text-neutral-300">Ahorros</span>
                                    <span class="font-mono text-[0.625rem] tabular-nums text-neutral-600 dark:text-neutral-300">$755.000,00</span>
                                </div>
                            </div>

                            <div class="mt-3 flex items-center justify-between">
                                <div class="flex h-8 items-end gap-1" aria-hidden="true">
                                    <span class="w-2 rounded-sm bg-brand-200 dark:bg-neutral-700" style="height: 45%"></span>
                                    <span class="w-2 rounded-sm bg-brand-300 dark:bg-neutral-600" style="height: 70%"></span>
                                    <span class="w-2 rounded-sm bg-brand-500 dark:bg-neutral-500" style="height: 100%"></span>
                                    <span class="w-2 rounded-sm bg-income-200 dark:bg-neutral-700" style="height: 55%"></span>
                                    <span class="w-2 rounded-sm bg-income-300 dark:bg-neutral-600" style="height: 80%"></span>
                                    <span class="w-2 rounded-sm bg-income-500 dark:bg-neutral-500" style="height: 95%"></span>
                                </div>
                                <span class="text-[0.5rem] text-neutral-400">Ingresos vs. gastos</span>
                            </div>
                        </div>
                    </div>
                </div>
                <p class="mt-3 text-center font-mono text-[0.625rem] uppercase tracking-[0.1em] text-neutral-400 dark:text-neutral-500">Vista del panel · datos de demostración</p>
            </div>
        </div>
    </section>

    {{-- How it works --}}
    <section id="producto" class="scroll-mt-20 border-b border-neutral-200 dark:border-neutral-800">
        <div class="container-app py-14 sm:py-20">
            <div class="max-w-2xl">
                <p class="eyebrow">El flujo</p>
                <h2 class="mt-3 font-display text-display-md text-neutral-900 dark:text-neutral-50">Tres pasos. Ninguna hoja de cálculo.</h2>
                <p class="mt-4 text-body text-neutral-600 dark:text-neutral-400">Todo lo que necesitas para entender tu situación financiera, sin configuraciones interminables.</p>
            </div>

            <div class="mt-10 grid border-t border-neutral-200 sm:grid-cols-3 sm:divide-x sm:divide-neutral-200 dark:border-neutral-800 dark:sm:divide-neutral-800">
                <div class="border-b border-neutral-200 py-7 sm:border-b-0 sm:pr-8 dark:border-neutral-800">
                    <span class="font-mono text-[0.6875rem] text-neutral-400">01</span>
                    <h3 class="mt-5 text-heading-sm text-neutral-900 dark:text-neutral-50">Registra</h3>
                    <p class="mt-2 text-body-sm leading-relaxed text-neutral-500 dark:text-neutral-400">Anota cada ingreso o gasto con su cuenta, categoría, fecha y descripción.</p>
                </div>
                <div class="border-b border-neutral-200 py-7 sm:border-b-0 sm:px-8 dark:border-neutral-800">
                    <span class="font-mono text-[0.6875rem] text-neutral-400">02</span>
                    <h3 class="mt-5 text-heading-sm text-neutral-900 dark:text-neutral-50">Clasifica</h3>
                    <p class="mt-2 text-body-sm leading-relaxed text-neutral-500 dark:text-neutral-400">Las categorías se separan por tipo. El sistema impide mezclar ingresos con gastos.</p>
                </div>
                <div class="py-7 sm:pl-8">
                    <span class="font-mono text-[0.6875rem] text-neutral-400">03</span>
                    <h3 class="mt-5 text-heading-sm text-neutral-900 dark:text-neutral-50">Consulta</h3>
                    <p class="mt-2 text-body-sm leading-relaxed text-neutral-500 dark:text-neutral-400">El saldo de cada cuenta se actualiza al instante, con el efecto de cada movimiento.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Balance rules --}}
    <section id="reglas" class="scroll-mt-20 border-b border-neutral-200 dark:border-neutral-800">
        <div class="container-app grid gap-12 py-14 sm:py-20 lg:grid-cols-2 lg:items-center lg:gap-16">
            <div>
                <p class="eyebrow">Integridad</p>
                <h2 class="mt-3 font-display text-display-md text-neutral-900 dark:text-neutral-50">El saldo no se edita.<br /><span class="italic text-brand-700 dark:text-neutral-400">Se explica solo.</span></h2>
                <p class="mt-4 max-w-lg text-body text-neutral-600 dark:text-neutral-400">
                    Cada cuenta refleja la suma de sus movimientos. Si editas o eliminas una transacción, el saldo se revierte y se vuelve a calcular automáticamente.
                </p>

                <ul class="mt-7 space-y-3.5">
                    @foreach ([
                        'Un ingreso aumenta el saldo; un gasto lo disminuye.',
                        'No se registran montos iguales o menores que cero.',
                        'Una categoría de ingreso solo acepta ingresos, y una de gasto solo gastos.',
                        'Ningún gasto puede superar el saldo disponible de la cuenta.',
                    ] as $rule)
                        <li class="flex items-start gap-2.5 text-body-sm text-neutral-600 dark:text-neutral-400">
                            <svg class="mt-0.5 h-4 w-4 shrink-0 text-brand-600 dark:text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M5 13l4 4L19 7" />
                            </svg>
                            {{ $rule }}
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="rounded-xl border border-neutral-200 bg-white p-5 shadow-card sm:p-6 dark:border-neutral-800 dark:bg-neutral-900">
                <div class="flex items-center justify-between border-b border-neutral-200 pb-3 dark:border-neutral-800">
                    <p class="text-[0.75rem] font-medium text-neutral-700 dark:text-neutral-300">Cuenta Caja · COP</p>
                    <span class="badge-neutral">Ejemplo</span>
                </div>

                <ol class="mt-4 space-y-4">
                    <li class="flex items-baseline justify-between gap-4">
                        <div>
                            <p class="text-[0.75rem] font-medium text-neutral-700 dark:text-neutral-300">Saldo inicial</p>
                            <p class="mt-0.5 text-[0.6875rem] text-neutral-400">Al crear la cuenta</p>
                        </div>
                        <span class="font-mono text-[0.8125rem] tabular-nums text-neutral-700 dark:text-neutral-300">$200.000,00</span>
                    </li>
                    <li class="flex items-baseline justify-between gap-4">
                        <div>
                            <p class="text-[0.75rem] font-medium text-neutral-700 dark:text-neutral-300">Ingreso · Salario</p>
                            <p class="mt-0.5 text-[0.6875rem] text-neutral-400">Aumenta el saldo</p>
                        </div>
                        <span class="font-mono text-[0.8125rem] tabular-nums text-income-700 dark:text-neutral-300">+$150.000,00</span>
                    </li>
                    <li class="flex items-baseline justify-between gap-4">
                        <div>
                            <p class="text-[0.75rem] font-medium text-neutral-700 dark:text-neutral-300">Gasto · Servicios</p>
                            <p class="mt-0.5 text-[0.6875rem] text-neutral-400">Disminuye el saldo</p>
                        </div>
                        <span class="font-mono text-[0.8125rem] tabular-nums text-expense-700 dark:text-expense-300">−$20.000,00</span>
                    </li>
                </ol>

                <div class="mt-5 flex items-baseline justify-between border-t border-neutral-200 pt-4 dark:border-neutral-800">
                    <span class="text-[0.6875rem] font-medium uppercase tracking-[0.08em] text-neutral-500 dark:text-neutral-400">Saldo final</span>
                    <span class="font-mono text-kpi-sm font-semibold tabular-nums text-neutral-900 dark:text-neutral-50">$330.000,00</span>
                </div>
            </div>
        </div>
    </section>

    {{-- Security --}}
    <section id="seguridad" class="scroll-mt-20 border-b border-neutral-200 dark:border-neutral-800">
        <div class="container-app grid gap-12 py-14 sm:py-20 lg:grid-cols-[0.9fr_1.1fr] lg:gap-16">
            <div>
                <p class="eyebrow">Seguridad</p>
                <h2 class="mt-3 font-display text-display-md text-neutral-900 dark:text-neutral-50">Un acceso.<br />Todas tus cuentas.</h2>
                <p class="mt-4 max-w-md text-body text-neutral-600 dark:text-neutral-400">
                    El sistema está construido con Laravel Breeze. Los módulos de cuentas, categorías y transacciones solo están disponibles para usuarios autenticados.
                </p>
                <a href="{{ route('login') }}" class="mt-6 inline-flex items-center gap-1.5 text-[0.8125rem] font-medium text-brand-700 underline-offset-4 transition-colors hover:underline dark:text-neutral-300">
                    Acceder al sistema
                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </a>
            </div>

            <div class="divide-y divide-neutral-200 border-y border-neutral-200 dark:divide-neutral-800 dark:border-neutral-800">
                @foreach ([
                    ['title' => 'Autenticación completa', 'text' => 'Registro, inicio y cierre de sesión, verificación de correo y recuperación de contraseña.', 'icon' => 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z'],
                    ['title' => 'Integridad referencial', 'text' => 'Las llaves foráneas impiden eliminar cuentas o categorías que tengan movimientos asociados.', 'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'],
                    ['title' => 'Trazabilidad', 'text' => 'Cada movimiento guarda el usuario que lo registró y la fecha en que se creó o modificó.', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
                ] as $item)
                    <div class="flex gap-4 py-5">
                        <span class="icon-chip-brand mt-0.5">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="{{ $item['icon'] }}" />
                            </svg>
                        </span>
                        <div>
                            <h3 class="text-[0.875rem] font-medium text-neutral-900 dark:text-neutral-50">{{ $item['title'] }}</h3>
                            <p class="mt-1 text-[0.8125rem] leading-relaxed text-neutral-500 dark:text-neutral-400">{{ $item['text'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="py-14 sm:py-20">
        <div class="container-app">
            <div class="relative overflow-hidden rounded-2xl bg-neutral-950 px-6 py-12 sm:px-10 lg:px-14 lg:py-16">
                <div class="pointer-events-none absolute inset-0 opacity-[0.06]" style="background-image: linear-gradient(to right, #fff 1px, transparent 1px), linear-gradient(to bottom, #fff 1px, transparent 1px); background-size: 48px 48px;"></div>
                <div class="pointer-events-none absolute -bottom-32 -right-24 h-80 w-80 rounded-full bg-brand-500/15 blur-3xl"></div>

                <div class="relative max-w-xl">
                    <p class="text-[0.6875rem] font-medium uppercase tracking-[0.14em] text-brand-300">Empieza ahora</p>
                    <h2 class="mt-3 font-display text-display-md text-white">Tu dinero, por fin, en una sola vista.</h2>
                    <p class="mt-3 text-[0.9375rem] leading-relaxed text-neutral-400">
                        Crea tu cuenta, registra tu primer movimiento y deja que el sistema mantenga los saldos en orden.
                    </p>
                    <div class="mt-7 flex flex-col gap-3 sm:flex-row">
                        @auth
                            <a href="{{ route('dashboard') }}" class="btn-lg bg-white text-neutral-900 hover:bg-neutral-100">Ir al panel</a>
                        @else
                            <a href="{{ route('register') }}" class="btn-lg bg-white text-neutral-900 hover:bg-neutral-100">Crear mi cuenta</a>
                            <a href="{{ route('login') }}" class="btn-lg border border-white/20 bg-transparent text-white hover:bg-white/5">Ya tengo cuenta</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-guest-layout>