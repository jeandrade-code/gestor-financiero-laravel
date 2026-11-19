<x-guest-layout title="Recuperar contraseña - {{ config('app.name') }}">
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
                    <h1 class="text-heading-lg text-neutral-900 dark:text-neutral-50 text-center">Recuperar contraseña</h1>
                    <p class="text-body text-neutral-600 dark:text-neutral-400 text-center mt-1">Te enviaremos un enlace para restablecerla</p>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <x-alert type="success" :message="session('status')" />
                    @endif

                    <form method="POST" action="{{ route('password.email') }}" class="space-y-5" novalidate>
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
                                   placeholder="tu@email.com">
                            @if ($errors->has('email'))
                                <p id="email-error" class="form-error" role="alert">{{ $errors->first('email') }}</p>
                            @endif
                        </div>

                        <button type="submit"
                                class="btn-primary btn-lg w-full mt-2"
                                :disabled="submitting"
                                @click="submitting = true">
                            <span class="flex items-center justify-center gap-2">
                                <svg class="w-5 h-5 animate-spin hidden" id="forgot-spinner" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span id="forgot-text">Enviar enlace</span>
                            </span>
                        </button>
                    </form>
                </div>

                <div class="card-footer flex flex-col sm:flex-row items-center justify-center gap-3 text-center sm:text-left">
                    <p class="text-body-sm text-neutral-600 dark:text-neutral-400">
                        ¿Recordaste tu contraseña?
                        <a href="{{ route('login') }}" class="font-medium text-brand-600 dark:text-brand-400 hover:underline transition-colors ml-1">
                            Volver al login
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelector('form').addEventListener('submit', function(e) {
            const btn = this.querySelector('button[type="submit"]');
            const spinner = document.getElementById('forgot-spinner');
            const text = document.getElementById('forgot-text');

            btn.disabled = true;
            spinner.classList.remove('hidden');
            text.textContent = 'Enviando...';
        });
    </script>
</x-guest-layout>