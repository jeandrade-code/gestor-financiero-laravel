<x-guest-layout title="Gestor Financiero - Tu control financiero inteligente">
    <!-- Hero Section -->
    <section class="relative min-h-[90vh] flex items-center justify-center overflow-hidden">
        <!-- Background pattern -->
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,_var(--tw-gradient-stops))] from-brand-50/50 via-transparent to-transparent dark:from-brand-900/20 dark:via-transparent" aria-hidden="true"></div>
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%233b82f6" fill-opacity="0.03"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-50" aria-hidden="true"></div>

        <div class="container-app relative z-10 py-12 sm:py-20 lg:py-28">
            <div class="max-w-4xl mx-auto text-center">
                <!-- Badge -->
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-brand-50 dark:bg-brand-900/30 border border-brand-200 dark:border-brand-800 mb-8 animate-in">
                    <span class="w-2 h-2 rounded-full bg-income-500 animate-pulse" aria-hidden="true"></span>
                    <span class="text-caption font-medium text-brand-700 dark:text-brand-300">Nueva versión 2.0 - Diseño renovado</span>
                </div>

                <!-- Headline -->
                <h1 class="text-display-xl text-neutral-900 dark:text-neutral-50 font-bold tracking-tight text-balance mb-6 animate-in stagger-1">
                    Control total de tus
                    <span class="text-brand-600 dark:text-brand-400"> finanzas</span>
                    en un solo lugar
                </h1>

                <!-- Subheadline -->
                <p class="text-body-lg text-neutral-600 dark:text-neutral-400 max-w-2xl mx-auto mb-10 animate-in stagger-2">
                    Registra ingresos, gestiona gastos, controla saldos por cuenta y toma decisiones informadas con una interfaz diseñada para la claridad financiera.
                </p>

                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 animate-in stagger-3">
                    <a href="{{ route('register') }}"
                       class="btn-primary btn-lg w-full sm:w-auto">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                        </svg>
                        Comenzar gratis
                    </a>
                    <a href="{{ route('login') }}"
                       class="btn-outline btn-lg w-full sm:w-auto">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Iniciar sesión
                    </a>
                </div>

                <!-- Trust indicators -->
                <div class="mt-16 animate-in stagger-4">
                    <div class="flex flex-wrap items-center justify-center gap-8 text-neutral-400 dark:text-neutral-500 text-caption">
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            Datos encriptados
                        </span>
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            Privacidad total
                        </span>
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            Sincronización instantánea
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scroll indicator -->
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce" aria-hidden="true">
            <svg class="w-6 h-6 text-neutral-400 dark:text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
            </svg>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-16 sm:py-24 bg-white dark:bg-neutral-950" aria-labelledby="features-heading">
        <div class="container-app">
            <header class="text-center max-w-2xl mx-auto mb-16">
                <h2 id="features-heading" class="text-display-md text-neutral-900 dark:text-neutral-50 mb-4">
                    Todo lo que necesitas para
                    <span class="text-brand-600 dark:text-brand-400"> gestionar tu dinero</span>
                </h2>
                <p class="text-body-lg text-neutral-600 dark:text-neutral-400">
                    Herramientas potentes, interfaz limpia, control total.
                </p>
            </header>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Feature 1: Cuentas -->
                <article class="card-hover card p-6 animate-in stagger-1">
                    <div class="w-12 h-12 rounded-xl bg-brand-100 dark:bg-brand-900/30 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-brand-600 dark:text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <h3 class="text-heading-sm text-neutral-900 dark:text-neutral-50 mb-2">Múltiples cuentas</h3>
                    <p class="text-body text-neutral-600 dark:text-neutral-400">Gestiona efectivo, bancos, tarjetas e inversiones. Cada cuenta con su moneda y saldo actualizado en tiempo real.</p>
                </article>

                <!-- Feature 2: Categorías -->
                <article class="card-hover card p-6 animate-in stagger-2">
                    <div class="w-12 h-12 rounded-xl bg-income-100 dark:bg-income-900/30 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-income-600 dark:text-income-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                    </div>
                    <h3 class="text-heading-sm text-neutral-900 dark:text-neutral-50 mb-2">Categorías inteligentes</h3>
                    <p class="text-body text-neutral-600 dark:text-neutral-400">Organa ingresos y gastos por tipo. Filtros automáticos que evitan errores: categorías de ingreso solo para ingresos, de gasto solo para gastos.</p>
                </article>

                <!-- Feature 3: Transacciones -->
                <article class="card-hover card p-6 animate-in stagger-3">
                    <div class="w-12 h-12 rounded-xl bg-warning-100 dark:bg-warning-900/30 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-warning-600 dark:text-warning-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-heading-sm text-neutral-900 dark:text-neutral-50 mb-2">Movimientos precisos</h3>
                    <p class="text-body text-neutral-600 dark:text-neutral-400">Registra cada transacción con cuenta, categoría, fecha, monto y descripción. El saldo se calcula automáticamente al crear, editar o eliminar.</p>
                </article>

                <!-- Feature 4: Dashboard -->
                <article class="card-hover card p-6 animate-in stagger-4">
                    <div class="w-12 h-12 rounded-xl bg-expense-100 dark:bg-expense-900/30 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-expense-600 dark:text-expense-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <h3 class="text-heading-sm text-neutral-900 dark:text-neutral-50 mb-2">Panel de control</h3>
                    <p class="text-body text-neutral-600 dark:text-neutral-400">Vista general con saldo total, ingresos vs gastos, últimas transacciones y accesos rápidos a las acciones más usadas.</p>
                </article>

                <!-- Feature 5: Reglas de saldo -->
                <article class="card-hover card p-6 animate-in stagger-5">
                    <div class="w-12 h-12 rounded-xl bg-neutral-100 dark:bg-neutral-800 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-neutral-600 dark:text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <h3 class="text-heading-sm text-neutral-900 dark:text-neutral-50 mb-2">Reglas de negocio</h3>
                    <p class="text-body text-neutral-600 dark:text-neutral-400">Validaciones automáticas: montos positivos, categorías coherentes, gastos que no superan el saldo disponible. Tu dinero siempre protegido.</p>
                </article>

                <!-- Feature 6: Seguridad -->
                <article class="card-hover card p-6 animate-in stagger-6">
                    <div class="w-12 h-12 rounded-xl bg-brand-100 dark:bg-brand-900/30 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-brand-600 dark:text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <h3 class="text-heading-sm text-neutral-900 dark:text-neutral-50 mb-2">Acceso seguro</h3>
                    <p class="text-body text-neutral-600 dark:text-neutral-400">Autenticación con Laravel Breeze: registro, login, verificación de email, recuperación de contraseña y gestión de perfil.</p>
                </article>
            </div>
        </div>
    </section>

    <!-- Stats / Social Proof Section -->
    <section class="py-16 bg-neutral-100 dark:bg-neutral-900" aria-labelledby="stats-heading">
        <div class="container-app">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div class="animate-in stagger-1">
                    <div class="text-display-lg font-bold text-brand-600 dark:text-brand-400 tabular-nums">5</div>
                    <div class="text-body text-neutral-600 dark:text-neutral-400 mt-1">Categorías predefinidas</div>
                </div>
                <div class="animate-in stagger-2">
                    <div class="text-display-lg font-bold text-income-600 dark:text-income-400 tabular-nums">3</div>
                    <div class="text-body text-neutral-600 dark:text-neutral-400 mt-1">Cuentas de ejemplo</div>
                </div>
                <div class="animate-in stagger-3">
                    <div class="text-display-lg font-bold text-warning-600 dark:text-warning-400 tabular-nums">5</div>
                    <div class="text-body text-neutral-600 dark:text-neutral-400 mt-1">Transacciones de prueba</div>
                </div>
                <div class="animate-in stagger-4">
                    <div class="text-display-lg font-bold text-neutral-600 dark:text-neutral-400 tabular-nums">46</div>
                    <div class="text-body text-neutral-600 dark:text-neutral-400 mt-1">Pruebas automatizadas</div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-brand-600 dark:bg-brand-700" aria-labelledby="cta-heading">
        <div class="container-app text-center">
            <h2 id="cta-heading" class="text-display-md text-white mb-4">
                ¿Listo para tomar el control?
            </h2>
            <p class="text-body-lg text-brand-100 mb-8 max-w-xl mx-auto">
                Únete a quienes ya gestionan sus finanzas con claridad. Crea tu cuenta en segundos.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('register') }}"
                   class="btn-lg px-8 py-3 bg-white text-brand-600 hover:bg-brand-50 active:bg-brand-100 shadow-lg">
                    Crear mi cuenta gratis
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </a>
                <a href="{{ route('login') }}"
                   class="btn-lg px-8 py-3 border-2 border-white text-white hover:bg-white/10 active:bg-white/20">
                    Ya tengo cuenta
                </a>
            </div>
        </div>
    </section>
</x-guest-layout>