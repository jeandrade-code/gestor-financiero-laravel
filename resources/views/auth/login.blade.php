<x-auth-layout title="Iniciar sesión — {{ config('app.name') }}">
    <div class="mb-8">
        <p class="eyebrow">Acceso</p>
        <h1 class="mt-2 text-heading-xl font-semibold tracking-tight text-neutral-900 dark:text-neutral-50">Inicia sesión</h1>
        <p class="mt-1.5 text-body-sm text-neutral-500 dark:text-neutral-400">Ingresa tus credenciales para acceder a tu espacio financiero.</p>
    </div>

    @if (session('status'))
        <div class="mb-5">
            <x-alert type="success" :message="session('status')" />
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-4" novalidate data-loading>
        @csrf

        <div>
            <label for="email" class="label">Correo electrónico</label>
            <input id="email"
                   type="email"
                   name="email"
                   value="{{ old('email') }}"
                   required
                   autocomplete="username"
                   autofocus
                   class="input {{ $errors->has('email') ? 'input-error' : '' }}"
                   aria-describedby="{{ $errors->has('email') ? 'email-error' : '' }}"
                   aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}"
                   placeholder="tu@correo.com">
            @if ($errors->has('email'))
                <p id="email-error" class="form-error" role="alert">{{ $errors->first('email') }}</p>
            @endif
        </div>

        <div>
            <div class="mb-1.5 flex items-center justify-between gap-4">
                <label for="password" class="label !mb-0">Contraseña</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-[0.75rem] font-medium text-brand-700 underline-offset-4 transition-colors hover:underline dark:text-neutral-300">
                        ¿Olvidaste tu contraseña?
                    </a>
                @endif
            </div>
            <input id="password"
                   type="password"
                   name="password"
                   required
                   autocomplete="current-password"
                   class="input {{ $errors->has('password') ? 'input-error' : '' }}"
                   aria-describedby="{{ $errors->has('password') ? 'password-error' : '' }}"
                   aria-invalid="{{ $errors->has('password') ? 'true' : 'false' }}"
                   placeholder="••••••••">
            @if ($errors->has('password'))
                <p id="password-error" class="form-error" role="alert">{{ $errors->first('password') }}</p>
            @endif
        </div>

        <div class="flex items-center gap-2 pt-1">
            <input id="remember_me"
                   type="checkbox"
                   name="remember"
                   class="h-3.5 w-3.5 rounded border-neutral-300 text-brand-700 focus:ring-brand-500/30 dark:border-neutral-600 dark:bg-neutral-900">
            <label for="remember_me" class="cursor-pointer text-[0.8125rem] text-neutral-600 dark:text-neutral-400">Mantener la sesión abierta</label>
        </div>

        <button type="submit" class="btn-primary btn-lg mt-2 w-full" data-loading-text="Ingresando…">
            Iniciar sesión
        </button>
    </form>

    <div class="mt-7 flex items-center gap-3">
        <span class="h-px flex-1 bg-neutral-200 dark:bg-neutral-800"></span>
        <span class="text-[0.6875rem] font-medium uppercase tracking-[0.1em] text-neutral-400">o</span>
        <span class="h-px flex-1 bg-neutral-200 dark:bg-neutral-800"></span>
    </div>

    <p class="mt-5 text-center text-[0.8125rem] text-neutral-500 dark:text-neutral-400">
        ¿Aún no tienes cuenta?
        <a href="{{ route('register') }}" class="font-medium text-brand-700 underline-offset-4 transition-colors hover:underline dark:text-neutral-300">Crea una gratis</a>
    </p>

    <p class="mt-8 text-center text-[0.6875rem] leading-relaxed text-neutral-400 dark:text-neutral-500">
        Al continuar aceptas los términos de uso y la política de privacidad del proyecto.
    </p>
</x-auth-layout>