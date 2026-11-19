<x-auth-layout title="Restablecer contraseña — {{ config('app.name') }}">
    <div class="mb-8">
        <p class="eyebrow">Seguridad</p>
        <h1 class="mt-2 text-heading-xl font-semibold tracking-tight text-neutral-900 dark:text-neutral-50">Nueva contraseña</h1>
        <p class="mt-1.5 text-body-sm text-neutral-500 dark:text-neutral-400">Elige una contraseña que no uses en otros servicios.</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-4" novalidate data-loading>
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div>
            <label for="email" class="label">Correo electrónico</label>
            <input id="email"
                   type="email"
                   name="email"
                   value="{{ old('email', $request->email) }}"
                   required
                   autocomplete="email"
                   class="input {{ $errors->has('email') ? 'input-error' : '' }}"
                   aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}"
                   placeholder="tu@correo.com">
            @if ($errors->has('email'))
                <p class="form-error" role="alert">{{ $errors->first('email') }}</p>
            @endif
        </div>

        <div>
            <label for="password" class="label">Nueva contraseña</label>
            <div class="relative">
                <input id="password"
                       type="password"
                       name="password"
                       required
                       autocomplete="new-password"
                       class="input pr-11 {{ $errors->has('password') ? 'input-error' : '' }}"
                       aria-describedby="password-hint"
                       aria-invalid="{{ $errors->has('password') ? 'true' : 'false' }}"
                       placeholder="Mínimo 8 caracteres">
                <button type="button"
                        class="absolute right-1.5 top-1/2 -translate-y-1/2 rounded p-1.5 text-neutral-400 transition-colors hover:text-neutral-700 dark:hover:text-neutral-200"
                        onclick="togglePassword('password', this)"
                        aria-label="Mostrar contraseña">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true" data-eye-open>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <svg class="hidden h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true" data-eye-closed>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 3l18 18M10.584 10.587a2 2 0 002.828 2.83M9.878 5.09A10.9 10.9 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.5 10.5 0 01-4.144 5.27M6.228 6.228A10.5 10.5 0 002.458 12C3.732 16.057 7.523 19 12 19c1.02 0 1.999-.152 2.916-.435" />
                    </svg>
                </button>
            </div>
            <p id="password-hint" class="form-hint">Mínimo 8 caracteres.</p>
            @if ($errors->has('password'))
                <p class="form-error" role="alert">{{ $errors->first('password') }}</p>
            @endif
        </div>

        <div>
            <label for="password_confirmation" class="label">Confirmar contraseña</label>
            <input id="password_confirmation"
                   type="password"
                   name="password_confirmation"
                   required
                   autocomplete="new-password"
                   class="input"
                   placeholder="Repite tu contraseña">
            @if ($errors->has('password_confirmation'))
                <p class="form-error" role="alert">{{ $errors->first('password_confirmation') }}</p>
            @endif
        </div>

        <button type="submit" class="btn-primary btn-lg mt-2 w-full" data-loading-text="Actualizando…">
            Restablecer contraseña
        </button>
    </form>

    <p class="mt-6 text-center text-[0.8125rem] text-neutral-500 dark:text-neutral-400">
        <a href="{{ route('login') }}" class="font-medium text-brand-700 underline-offset-4 transition-colors hover:underline dark:text-neutral-300">Volver al inicio de sesión</a>
    </p>
</x-auth-layout>