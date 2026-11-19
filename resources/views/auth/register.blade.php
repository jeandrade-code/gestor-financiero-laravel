<x-guest-layout title="Registrarse - {{ config('app.name') }}">
    <div class="min-h-[calc(100vh-200px)] flex items-center justify-center py-12 px-4">
        <div class="w-full max-w-md">
            <!-- Logo -->
            <div class="text-center mb-10 animate-in">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2" aria-label="{{ config('app.name') }} - Inicio">
                    <svg class="w-10 h-10 text-brand-600 dark:text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599 1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-display-sm font-bold text-neutral-900 dark:text-neutral-50">{{ config('app.name') }}</span>
                </a>
            </div>

            <!-- Card -->
            <div class="card animate-in stagger-1">
                <div class="card-header">
                    <h1 class="text-heading-lg text-neutral-900 dark:text-neutral-50 text-center">Crear cuenta</h1>
                    <p class="text-body text-neutral-600 dark:text-neutral-400 text-center mt-1">Comienza a gestionar tus finanzas hoy</p>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}" class="space-y-5" novalidate>
                        @csrf

                        <!-- Name -->
                        <div>
                            <label for="name" class="label">Nombre completo</label>
                            <input id="name"
                                   type="text"
                                   name="name"
                                   value="{{ old('name') }}"
                                   required
                                   autocomplete="name"
                                   autofocus
                                   class="input {{ $errors->has('name') ? 'input-error' : '' }}"
                                   aria-describedby="{{ $errors->has('name') ? 'name-error' : '' }}"
                                   aria-invalid="{{ $errors->has('name') ? 'true' : 'false' }}"
                                   placeholder="Juan Pérez">
                            @if ($errors->has('name'))
                                <p id="name-error" class="form-error" role="alert">{{ $errors->first('name') }}</p>
                            @endif
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="label">Correo electrónico</label>
                            <input id="email"
                                   type="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   required
                                   autocomplete="email"
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
                            <label for="password" class="label">Contraseña</label>
                            <div class="relative">
                                <input id="password"
                                       type="password"
                                       name="password"
                                       required
                                       autocomplete="new-password"
                                       class="input pr-12 {{ $errors->has('password') ? 'input-error' : '' }}"
                                       aria-describedby="{{ $errors->has('password') ? 'password-error' : 'password-hint' }}"
                                       aria-invalid="{{ $errors->has('password') ? 'true' : 'false' }}"
                                       placeholder="••••••••">
                                <button type="button"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-neutral-400 hover:text-neutral-600 dark:hover:text-neutral-300 transition-colors"
                                        onclick="togglePassword('password', this)"
                                        aria-label="Mostrar contraseña">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true" data-eye-open>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    <svg class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true" data-eye-closed>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                    </svg>
                                </button>
                            </div>
                            <p id="password-hint" class="form-hint">Mínimo 8 caracteres</p>
                            @if ($errors->has('password'))
                                <p id="password-error" class="form-error" role="alert">{{ $errors->first('password') }}</p>
                            @endif
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="label">Confirmar contraseña</label>
                            <input id="password_confirmation"
                                   type="password"
                                   name="password_confirmation"
                                   required
                                   autocomplete="new-password"
                                   class="input {{ $errors->has('password_confirmation') ? 'input-error' : '' }}"
                                   aria-describedby="{{ $errors->has('password_confirmation') ? 'password_confirmation-error' : '' }}"
                                   aria-invalid="{{ $errors->has('password_confirmation') ? 'true' : 'false' }}"
                                   placeholder="••••••••">
                            @if ($errors->has('password_confirmation'))
                                <p id="password_confirmation-error" class="form-error" role="alert">{{ $errors->first('password_confirmation') }}</p>
                            @endif
                        </div>

                        <!-- Submit -->
                        <button type="submit"
                                class="btn-primary btn-lg w-full mt-2"
                                :disabled="submitting"
                                @click="submitting = true">
                            <span class="flex items-center justify-center gap-2">
                                <svg class="w-5 h-5 animate-spin hidden" id="register-spinner" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span id="register-text">Crear mi cuenta</span>
                            </span>
                        </button>
                    </form>
                </div>

                <div class="card-footer flex flex-col sm:flex-row items-center justify-center gap-3 text-center sm:text-left">
                    <p class="text-body-sm text-neutral-600 dark:text-neutral-400">
                        ¿Ya tienes cuenta?
                        <a href="{{ route('login') }}" class="font-medium text-brand-600 dark:text-brand-400 hover:underline transition-colors ml-1">
                            Inicia sesión
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
        // Toggle password visibility
        function togglePassword(inputId, button) {
            const input = document.getElementById(inputId);
            const eyeOpen = button.querySelector('[data-eye-open]');
            const eyeClosed = button.querySelector('[data-eye-closed]');

            if (input.type === 'password') {
                input.type = 'text';
                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
                button.setAttribute('aria-label', 'Ocultar contraseña');
            } else {
                input.type = 'password';
                eyeOpen.classList.remove('hidden');
                eyeClosed.classList.add('hidden');
                button.setAttribute('aria-label', 'Mostrar contraseña');
            }
        }

        // Form submission feedback
        document.querySelector('form').addEventListener('submit', function(e) {
            const btn = this.querySelector('button[type="submit"]');
            const spinner = document.getElementById('register-spinner');
            const text = document.getElementById('register-text');

            btn.disabled = true;
            spinner.classList.remove('hidden');
            text.textContent = 'Creando cuenta...';
        });
    </script>
</x-guest-layout>