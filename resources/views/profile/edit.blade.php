<x-app-layout>
    <x-slot name="header">
        <h2 class="text-heading-lg text-neutral-900 dark:text-neutral-50">Mi perfil</h2>
    </x-slot>

    <div class="max-w-2xl space-y-6">
        <!-- Profile Info -->
        <div class="card animate-in">
            <div class="card-header">
                <h3 class="text-heading-md text-neutral-900 dark:text-neutral-50">Información personal</h3>
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('profile.update') }}" class="space-y-6" novalidate>
                    @csrf

                    <!-- Name -->
                    <div>
                        <label for="name" class="label">Nombre <span class="text-expense-500" aria-hidden="true">*</span></label>
                        <input id="name"
                               type="text"
                               name="name"
                               value="{{ old('name', auth()->user()->name) }}"
                               required
                               maxlength="255"
                               autocomplete="name"
                               class="input {{ $errors->has('name') ? 'input-error' : '' }}"
                               aria-describedby="{{ $errors->has('name') ? 'name-error' : '' }}"
                               aria-invalid="{{ $errors->has('name') ? 'true' : 'false' }}">
                        @if ($errors->has('name'))
                            <p id="name-error" class="form-error" role="alert">{{ $errors->first('name') }}</p>
                        @endif
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="label">Correo electrónico <span class="text-expense-500" aria-hidden="true">*</span></label>
                        <input id="email"
                               type="email"
                               name="email"
                               value="{{ old('email', auth()->user()->email) }}"
                               required
                               maxlength="255"
                               autocomplete="email"
                               class="input {{ $errors->has('email') ? 'input-error' : '' }}"
                               aria-describedby="{{ $errors->has('email') ? 'email-error' : '' }}"
                               aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}">
                        @if ($errors->has('email'))
                            <p id="email-error" class="form-error" role="alert">{{ $errors->first('email') }}</p>
                        @endif
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-neutral-200 dark:border-neutral-700">
                        <button type="submit" class="btn-primary btn-md flex-1 sm:flex-none">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Guardar cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Update Password -->
        <div class="card animate-in stagger-1">
            <div class="card-header">
                <h3 class="text-heading-md text-neutral-900 dark:text-neutral-50">Cambiar contraseña</h3>
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('password.update') }}" class="space-y-6" novalidate>
                    @csrf

                    <!-- Current Password -->
                    <div>
                        <label for="current_password" class="label">Contraseña actual <span class="text-expense-500" aria-hidden="true">*</span></label>
                        <input id="current_password"
                               type="password"
                               name="current_password"
                               required
                               autocomplete="current-password"
                               class="input {{ $errors->has('current_password') ? 'input-error' : '' }}"
                               aria-describedby="{{ $errors->has('current_password') ? 'current_password-error' : '' }}"
                               aria-invalid="{{ $errors->has('current_password') ? 'true' : 'false' }}">
                        @if ($errors->has('current_password'))
                            <p id="current_password-error" class="form-error" role="alert">{{ $errors->first('current_password') }}</p>
                        @endif
                    </div>

                    <!-- New Password -->
                    <div>
                        <label for="password" class="label">Nueva contraseña <span class="text-expense-500" aria-hidden="true">*</span></label>
                        <div class="relative">
                            <input id="password"
                                   type="password"
                                   name="password"
                                   required
                                   autocomplete="new-password"
                                   class="input pr-12 {{ $errors->has('password') ? 'input-error' : '' }}"
                                   aria-describedby="{{ $errors->has('password') ? 'password-error' : 'password-hint' }}"
                                   aria-invalid="{{ $errors->has('password') ? 'true' : 'false' }}">
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
                        <label for="password_confirmation" class="label">Confirmar nueva contraseña <span class="text-expense-500" aria-hidden="true">*</span></label>
                        <input id="password_confirmation"
                               type="password"
                               name="password_confirmation"
                               required
                               autocomplete="new-password"
                               class="input {{ $errors->has('password_confirmation') ? 'input-error' : '' }}"
                               aria-describedby="{{ $errors->has('password_confirmation') ? 'password_confirmation-error' : '' }}"
                               aria-invalid="{{ $errors->has('password_confirmation') ? 'true' : 'false' }}">
                        @if ($errors->has('password_confirmation'))
                            <p id="password_confirmation-error" class="form-error" role="alert">{{ $errors->first('password_confirmation') }}</p>
                        @endif
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-neutral-200 dark:border-neutral-700">
                        <button type="submit" class="btn-primary btn-md flex-1 sm:flex-none">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Actualizar contraseña
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Delete Account -->
        <div class="card animate-in stagger-2 border-expense-200 dark:border-expense-800">
            <div class="card-header border-b border-expense-200 dark:border-expense-800">
                <h3 class="text-heading-md text-expense-600 dark:text-expense-400">Eliminar cuenta</h3>
            </div>

            <div class="card-body">
                <p class="text-body text-neutral-600 dark:text-neutral-400 mb-4">Esta acción eliminará permanentemente tu cuenta y todos tus datos financieros. No se puede deshacer.</p>

                <form method="POST" action="{{ route('profile.destroy') }}" class="space-y-4" onsubmit="return confirm('¿Estás absolutamente seguro de que quieres eliminar tu cuenta? Esta acción es irreversible.')">
                    @csrf
                    @method('DELETE')

                    <div>
                        <label for="password_confirm" class="label">Confirma con tu contraseña <span class="text-expense-500" aria-hidden="true">*</span></label>
                        <input id="password_confirm"
                               type="password"
                               name="password"
                               required
                               autocomplete="current-password"
                               class="input {{ $errors->has('password') ? 'input-error' : '' }}"
                               aria-describedby="{{ $errors->has('password') ? 'password_confirm-error' : '' }}"
                               aria-invalid="{{ $errors->has('password') ? 'true' : 'false' }}">
                        @if ($errors->has('password'))
                            <p id="password_confirm-error" class="form-error" role="alert">{{ $errors->first('password') }}</p>
                        @endif
                    </div>

                    <button type="submit" class="btn-destructive btn-md">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Eliminar mi cuenta
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
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
    </script>
</x-app-layout>