@php($year = date('Y'))

<footer class="border-t border-neutral-200 bg-white dark:border-neutral-800 dark:bg-neutral-900">
    <div class="mx-auto w-full max-w-[80rem] px-4 py-8 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 gap-8 lg:grid-cols-[1.6fr_1fr_1fr]">
            <div class="col-span-2 lg:col-span-1">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2.5" aria-label="{{ config('app.name') }} — Inicio">
                    <x-brand-mark class="h-7 w-7" />
                    <span class="text-[0.8125rem] font-semibold tracking-tight text-neutral-900 dark:text-neutral-50">Gestor Financiero</span>
                </a>
                <p class="mt-3 max-w-xs text-[0.8125rem] leading-relaxed text-neutral-500 dark:text-neutral-400">
                    Un espacio único para registrar ingresos, controlar gastos y saber exactamente cuánto hay en cada cuenta.
                </p>
            </div>

            <div>
                <p class="eyebrow">Producto</p>
                <ul class="mt-3 space-y-2 text-[0.8125rem]">
                    <li><a href="{{ route('dashboard') }}" class="text-neutral-500 transition-colors hover:text-neutral-900 dark:text-neutral-400 dark:hover:text-neutral-100">Panel general</a></li>
                    <li><a href="{{ route('transacciones.index') }}" class="text-neutral-500 transition-colors hover:text-neutral-900 dark:text-neutral-400 dark:hover:text-neutral-100">Transacciones</a></li>
                    <li><a href="{{ route('cuentas.index') }}" class="text-neutral-500 transition-colors hover:text-neutral-900 dark:text-neutral-400 dark:hover:text-neutral-100">Cuentas</a></li>
                    <li><a href="{{ route('categorias.index') }}" class="text-neutral-500 transition-colors hover:text-neutral-900 dark:text-neutral-400 dark:hover:text-neutral-100">Categorías</a></li>
                </ul>
            </div>

            <div>
                <p class="eyebrow">Cuenta</p>
                <ul class="mt-3 space-y-2 text-[0.8125rem]">
                    <li><a href="{{ route('profile.edit') }}" class="text-neutral-500 transition-colors hover:text-neutral-900 dark:text-neutral-400 dark:hover:text-neutral-100">Mi perfil</a></li>
                    <li><a href="{{ route('transacciones.create') }}" class="text-neutral-500 transition-colors hover:text-neutral-900 dark:text-neutral-400 dark:hover:text-neutral-100">Registrar movimiento</a></li>
                    <li><a href="mailto:soporte@gestorfinanciero.test" class="text-neutral-500 transition-colors hover:text-neutral-900 dark:text-neutral-400 dark:hover:text-neutral-100">Soporte</a></li>
                </ul>
            </div>
        </div>

        <div class="mt-8 flex flex-col gap-2 border-t border-neutral-200 pt-4 text-[0.6875rem] text-neutral-400 sm:flex-row sm:items-center sm:justify-between dark:border-neutral-800 dark:text-neutral-500">
            <p>&copy; {{ $year }} Gestor Financiero. Todos los derechos reservados.</p>
            <p>Proyecto académico · Laravel · Breeze · MySQL</p>
        </div>
    </div>
</footer>