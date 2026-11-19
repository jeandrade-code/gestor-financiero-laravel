<x-guest-layout title="Confirmar contraseña - {{ config('app.name') }}">
    <div class="min-h-[calc(100vh-200px)] flex items-center justify-center py-12 px-4">
        <div class="w-full max-w-md">
            <!-- Logo -->
            <div class="text-center mb-10 animate-in">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2" aria-label="{{ config('app.name') }} - Inicio">
                    <svg class="w-10 h-10 text-brand-600 dark:text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-display-sm font-bold text-neutral-900 dark:text-neutral-50">{{ config('app.name') }}</span>
                </a>
            </div>

            <!-- Card -->
            <div class="card animate-in stagger-1">
                <div class="card-header">
                    <h1 class="text-heading-lg text-neutral-900 dark:text-neutral-50 text-center">Confirmar contraseña</h1>
                    <p class="text-body text-neutral-600 dark:text-neutral-400 text-center mt-1">Esta es un área segura. Confirma tu identidad para continuar.</p>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5" novalidate>
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
                                   aria-describedby="{{ $errors->has('password') ? 'password-error' : '' }}"
                                   aria-invalid="{{ $errors->has('password') ? 'true' : 'false' }}"
                                   placeholder="••••••••">
                            @if ($errors->has('password'))
                                <p id="password-error" class="form-error" role="alert">{{ $errors->first('password') }}</p>
                            @endif
                        </div>

                        <button type="submit"
                                class="btn-primary btn-lg w-full mt-2"
                                :disabled="submitting"
                                @click="submitting = true">
                            <span class="flex items-center justify-center gap-2">
                                <svg class="w-5 h-5 animate-spin hidden" id="confirm-spinner" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span id="confirm-text">Confirmar</span>
                            </span>
                        </button>
                    </form>
                </div>

                <div class="card-footer flex flex-col sm:flex-row items-center justify-center gap-3 text-center sm:text-left">
                    <p class="text-body-sm text-neutral-600 dark:text-neutral-400">
                        <a href="{{ route('dashboard') }}" class="font-medium text-brand-600 dark:text-brand-400 hover:underline transition-colors">
                            Volver al panel
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelector('form').addEventListener('submit', function(e) {
            const btn = this.querySelector('button[type="submit"]');
            const spinner = document.getElementById('confirm-spinner');
            const text = document.getElementById('confirm-text');

            btn.disabled = true;
            spinner.classList.remove('hidden');
            text.textContent = 'Confirmando...';
        });
    </script>
</x-guest-layout>