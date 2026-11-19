<x-guest-layout title="Iniciar sesión - {{ config('app.name') }}">
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
                    <h1 class="text-heading-lg text-neutral-900 dark:text-neutral-50 text-center">Iniciar sesión</h1>
                    <p class="text-body text-neutral-600 dark:text-neutral-400 text-center mt-1">Accede a tu panel financiero</p>
                </div>

                <div class="card-body">
                    <!-- Status -->
                    @if (session('status'))
                        <x-alert type="success" :message="session('status')" />
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="space-y-5" novalidate>
                        @csrf

                        <!-- Email -->
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
                                   placeholder="tu@email.com">
                            @if ($errors->has('email'))
                                <p id="email-error" class="form-error" role="alert">{{ $errors->first('email') }}</p>
                            @endif
                        </div>

                        <!-- Password -->
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <label for="password" class="label mb-0">Contraseña</label>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}"
                                       class="text-caption text-brand-600 dark:text-brand-400 hover:underline transition-colors">
                                        ¿Olvidó su contraseña?
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

                        <!-- Remember me -->
                        <div class="flex items-center gap-2">
                            <input id="remember_me"
                                   type="checkbox"
                                   name="remember"
                                   class="w-4 h-4 rounded border-neutral-300 text-brand-600 focus:ring-brand-500 focus:ring-2 focus:ring-offset-0 dark:border-neutral-600 dark:bg-neutral-800"
                                   aria-describedby="remember-hint">
                            <label for="remember_me" class="text-body-sm text-neutral-700 dark:text-neutral-300 cursor-pointer" id="remember-hint">
                                Recordarme en este dispositivo
                            </label>
                        </div>

                        <!-- Submit -->
                        <button type="submit"
                                class="btn-primary btn-lg w-full mt-2"
                                :disabled="submitting"
                                @click="submitting = true">
                            <span class="flex items-center justify-center gap-2">
                                <svg class="w-5 h-5 animate-spin hidden" id="login-spinner" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span id="login-text">Iniciar sesión</span>
                            </span>
                        </button>
                    </form>
                </div>

                <div class="card-footer flex flex-col sm:flex-row items-center justify-center gap-3 text-center sm:text-left">
                    <p class="text-body-sm text-neutral-600 dark:text-neutral-400">
                        ¿No tienes cuenta?
                        <a href="{{ route('register') }}" class="font-medium text-brand-600 dark:text-brand-400 hover:underline transition-colors ml-1">
                            Regístrate gratis
                        </a>
                    </p>
                </div>
            </div>

            <!-- Footer note -->
            <p class="text-center text-caption text-neutral-500 dark:text-neutral-400 mt-6">
                Al continuar, aceptas nuestros <a href="#" class="underline hover:text-brand-600 dark:hover:text-brand-400">Términos de servicio</a> y <a href="#" class="underline hover:text-brand-600 dark:hover:text-brand-400">Política de privacidad</a>.
            </p>
        </div>
    </div>

    <script>
        // Simple form submission feedback
        document.querySelector('form').addEventListener('submit', function(e) {
            const btn = this.querySelector('button[type="submit"]');
            const spinner = document.getElementById('login-spinner');
            const text = document.getElementById('login-text');

            btn.disabled = true;
            spinner.classList.remove('hidden');
            text.textContent = 'Iniciando sesión...';
        });
    </script>
</x-guest-layout>