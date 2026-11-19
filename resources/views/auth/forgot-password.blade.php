<x-auth-layout title="Recuperar contraseña — {{ config('app.name') }}">
    <div class="mb-8">
        <p class="eyebrow">Recuperación</p>
        <h1 class="mt-2 text-heading-xl font-semibold tracking-tight text-neutral-900 dark:text-neutral-50">Restablece tu acceso</h1>
        <p class="mt-1.5 text-body-sm text-neutral-500 dark:text-neutral-400">Escribe el correo con el que te registraste y te enviaremos un enlace seguro.</p>
    </div>

    @if (session('status'))
        <div class="mb-5">
            <x-alert type="success" :message="session('status')" />
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4" novalidate data-loading>
        @csrf

        <div>
            <label for="email" class="label">Correo electrónico</label>
            <input id="email"
                   type="email"
                   name="email"
                   value="{{ old('email') }}"
                   required
                   autocomplete="email"
                   autofocus
                   class="input {{ $errors->has('email') ? 'input-error' : '' }}"
                   aria-describedby="{{ $errors->has('email') ? 'email-error' : '' }}"
                   aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}"
                   placeholder="tu@correo.com">
            @if ($errors->has('email'))
                <p id="email-error" class="form-error" role="alert">{{ $errors->first('email') }}</p>
            @endif
        </div>

        <button type="submit" class="btn-primary btn-lg mt-2 w-full" data-loading-text="Enviando enlace…">
            Enviar enlace de recuperación
        </button>
    </form>

    <p class="mt-6 text-center text-[0.8125rem] text-neutral-500 dark:text-neutral-400">
        <a href="{{ route('login') }}" class="font-medium text-brand-700 underline-offset-4 transition-colors hover:underline dark:text-neutral-300">Volver al inicio de sesión</a>
    </p>
</x-auth-layout>