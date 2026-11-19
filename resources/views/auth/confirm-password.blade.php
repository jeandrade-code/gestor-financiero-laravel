<x-auth-layout title="Confirmar contraseña — {{ config('app.name') }}">
    <div class="mb-8">
        <p class="eyebrow">Área segura</p>
        <h1 class="mt-2 text-heading-xl font-semibold tracking-tight text-neutral-900 dark:text-neutral-50">Confirma tu identidad</h1>
        <p class="mt-1.5 text-body-sm text-neutral-500 dark:text-neutral-400">Esta sección requiere tu contraseña actual para continuar.</p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-4" novalidate data-loading>
        @csrf

        <div>
            <label for="password" class="label">Contraseña</label>
            <input id="password"
                   type="password"
                   name="password"
                   required
                   autocomplete="current-password"
                   autofocus
                   class="input {{ $errors->has('password') ? 'input-error' : '' }}"
                   aria-invalid="{{ $errors->has('password') ? 'true' : 'false' }}"
                   placeholder="••••••••">
            @if ($errors->has('password'))
                <p class="form-error" role="alert">{{ $errors->first('password') }}</p>
            @endif
        </div>

        <button type="submit" class="btn-primary btn-lg mt-2 w-full" data-loading-text="Confirmando…">
            Confirmar y continuar
        </button>
    </form>

    <p class="mt-6 text-center text-[0.8125rem] text-neutral-500 dark:text-neutral-400">
        <a href="{{ route('dashboard') }}" class="font-medium text-brand-700 underline-offset-4 transition-colors hover:underline dark:text-neutral-300">Volver al panel</a>
    </p>
</x-auth-layout>