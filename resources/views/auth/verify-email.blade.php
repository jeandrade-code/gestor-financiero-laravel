<x-auth-layout title="Verificar correo — {{ config('app.name') }}">
    <div class="mb-8">
        <p class="eyebrow">Verificación</p>
        <h1 class="mt-2 text-heading-xl font-semibold tracking-tight text-neutral-900 dark:text-neutral-50">Revisa tu correo</h1>
        <p class="mt-1.5 text-body-sm text-neutral-500 dark:text-neutral-400">Enviamos un enlace de verificación a tu bandeja de entrada. Ábrelo para activar tu cuenta.</p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-5">
            <x-alert type="success" message="Enviamos un nuevo enlace de verificación a tu correo." />
        </div>
    @endif

    <div class="rounded-lg border border-neutral-200 bg-neutral-50/70 p-4 dark:border-neutral-800 dark:bg-neutral-900/60">
        <p class="text-[0.8125rem] leading-relaxed text-neutral-600 dark:text-neutral-400">
            Si no encuentras el mensaje, revisa la carpeta de spam. También puedes solicitar un enlace nuevo.
        </p>
    </div>

    <form method="POST" action="{{ route('verification.send') }}" class="mt-5" data-loading>
        @csrf
        <button type="submit" class="btn-primary btn-lg w-full" data-loading-text="Enviando…">
            Reenviar enlace de verificación
        </button>
    </form>

    <form method="POST" action="{{ route('logout') }}" class="mt-3">
        @csrf
        <button type="submit" class="btn-ghost btn-md w-full">
            Cerrar sesión
        </button>
    </form>

    <p class="mt-6 text-center text-[0.8125rem] text-neutral-500 dark:text-neutral-400">
        <a href="{{ route('login') }}" class="font-medium text-brand-700 underline-offset-4 transition-colors hover:underline dark:text-neutral-300">Ya verifiqué mi correo</a>
    </p>
</x-auth-layout>