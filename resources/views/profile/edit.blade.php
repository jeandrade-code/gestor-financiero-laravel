<x-app-layout>
    <x-slot name="header">
        <x-page-header
            eyebrow="Cuenta"
            title="Mi perfil"
            description="Gestiona tus datos de acceso y la seguridad de tu cuenta.">
            <x-slot:actions>
                <a href="{{ route('dashboard') }}" class="btn-secondary btn-md">Volver al panel</a>
            </x-slot:actions>
        </x-page-header>
    </x-slot>

    @if (session('status') === 'profile-updated')
        <div class="mb-5">
            <x-alert type="success" message="Tu información personal se actualizó correctamente." />
        </div>
    @elseif (session('status') === 'password-updated')
        <div class="mb-5">
            <x-alert type="success" message="Tu contraseña se actualizó correctamente." />
        </div>
    @endif

    <div class="grid gap-5 lg:grid-cols-[minmax(0,1fr)_18rem] lg:items-start">
        <div class="space-y-5">
            {{-- Personal information --}}
            <section class="card">
                <div class="card-header">
                    <h2 class="section-title">Información personal</h2>
                    <p class="mt-0.5 text-[0.75rem] text-neutral-500 dark:text-neutral-400">El nombre y el correo se usan para identificarte en el sistema.</p>
                </div>

                <form method="POST" action="{{ route('profile.update') }}" novalidate data-loading>
                    @csrf

                    <div class="card-body space-y-5">
                        <div>
                            <label for="name" class="label">Nombre <span class="required-mark" aria-hidden="true">*</span></label>
                            <input id="name"
                                   type="text"
                                   name="name"
                                   value="{{ old('name', $user->name) }}"
                                   required
                                   maxlength="255"
                                   autocomplete="name"
                                   class="input {{ $errors->has('name') ? 'input-error' : '' }}"
                                   aria-invalid="{{ $errors->has('name') ? 'true' : 'false' }}">
                            @if ($errors->has('name'))
                                <p class="form-error" role="alert">{{ $errors->first('name') }}</p>
                            @endif
                        </div>

                        <div>
                            <label for="email" class="label">Correo electrónico <span class="required-mark" aria-hidden="true">*</span></label>
                            <input id="email"
                                   type="email"
                                   name="email"
                                   value="{{ old('email', $user->email) }}"
                                   required
                                   maxlength="255"
                                   autocomplete="email"
                                   class="input {{ $errors->has('email') ? 'input-error' : '' }}"
                                   aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}">
                            @if ($errors->has('email'))
                                <p class="form-error" role="alert">{{ $errors->first('email') }}</p>
                            @else
                                <p class="form-hint">Si cambias el correo, deberás verificarlo de nuevo.</p>
                            @endif
                        </div>
                    </div>

                    <div class="flex justify-end border-t border-neutral-200 bg-neutral-50/60 px-5 py-4 dark:border-neutral-800 dark:bg-neutral-900/40">
                        <button type="submit" class="btn-primary btn-md w-full sm:w-auto" data-loading-text="Guardando…">
                            Guardar cambios
                        </button>
                    </div>
                </form>
            </section>

            {{-- Password --}}
            <section class="card">
                <div class="card-header">
                    <h2 class="section-title">Cambiar contraseña</h2>
                    <p class="mt-0.5 text-[0.75rem] text-neutral-500 dark:text-neutral-400">Usa al menos 8 caracteres y evita reutilizar contraseñas.</p>
                </div>

                <form method="POST" action="{{ route('password.update') }}" novalidate data-loading>
                    @csrf

                    <div class="card-body space-y-5">
                        <div>
                            <label for="current_password" class="label">Contraseña actual <span class="required-mark" aria-hidden="true">*</span></label>
                            <input id="current_password"
                                   type="password"
                                   name="current_password"
                                   required
                                   autocomplete="current-password"
                                   class="input {{ $errors->updatePassword->has('current_password') ? 'input-error' : '' }}"
                                   aria-invalid="{{ $errors->updatePassword->has('current_password') ? 'true' : 'false' }}">
                            @if ($errors->updatePassword->has('current_password'))
                                <p class="form-error" role="alert">{{ $errors->updatePassword->first('current_password') }}</p>
                            @endif
                        </div>

                        <div class="grid gap-5 sm:grid-cols-2">
                            <div>
                                <label for="password" class="label">Nueva contraseña <span class="required-mark" aria-hidden="true">*</span></label>
                                <div class="relative">
                                    <input id="password"
                                           type="password"
                                           name="password"
                                           required
                                           autocomplete="new-password"
                                           class="input pr-11 {{ $errors->updatePassword->has('password') ? 'input-error' : '' }}"
                                           aria-invalid="{{ $errors->updatePassword->has('password') ? 'true' : 'false' }}">
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
                                @if ($errors->updatePassword->has('password'))
                                    <p class="form-error" role="alert">{{ $errors->updatePassword->first('password') }}</p>
                                @endif
                            </div>

                            <div>
                                <label for="password_confirmation" class="label">Confirmar contraseña <span class="required-mark" aria-hidden="true">*</span></label>
                                <input id="password_confirmation"
                                       type="password"
                                       name="password_confirmation"
                                       required
                                       autocomplete="new-password"
                                       class="input">
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end border-t border-neutral-200 bg-neutral-50/60 px-5 py-4 dark:border-neutral-800 dark:bg-neutral-900/40">
                        <button type="submit" class="btn-primary btn-md w-full sm:w-auto" data-loading-text="Actualizando…">
                            Actualizar contraseña
                        </button>
                    </div>
                </form>
            </section>
        </div>

        {{-- Account summary --}}
        <aside class="space-y-4">
            <section class="card p-5">
                <div class="flex items-center gap-3">
                    <span class="flex h-11 w-11 items-center justify-center rounded-full bg-brand-50 text-[0.9375rem] font-semibold text-brand-700 dark:bg-neutral-800/70 dark:text-neutral-300">
                        {{ strtoupper(mb_substr($user->name, 0, 1)) }}
                    </span>
                    <div class="min-w-0">
                        <p class="truncate text-[0.875rem] font-medium text-neutral-900 dark:text-neutral-50">{{ $user->name }}</p>
                        <p class="truncate text-[0.75rem] text-neutral-500 dark:text-neutral-400">{{ $user->email }}</p>
                    </div>
                </div>

                <dl class="mt-5 space-y-2.5 border-t border-neutral-200 pt-4 text-[0.8125rem] dark:border-neutral-800">
                    <div class="flex justify-between gap-3">
                        <dt class="text-neutral-500 dark:text-neutral-400">Miembro desde</dt>
                        <dd class="text-neutral-800 dark:text-neutral-200">{{ $user->created_at?->format('d/m/Y') ?? '—' }}</dd>
                    </div>
                    <div class="flex items-center justify-between gap-3">
                        <dt class="text-neutral-500 dark:text-neutral-400">Estado</dt>
                        <dd>
                            <span class="badge-success"><span class="badge-dot"></span>Cuenta activa</span>
                        </dd>
                    </div>
                </dl>
            </section>

            <section class="rounded-xl border border-neutral-200 p-4 dark:border-neutral-800">
                <p class="eyebrow">Accesos directos</p>
                <div class="mt-3 space-y-1">
                    <a href="{{ route('transacciones.index') }}" class="nav-item px-2 py-1.5">Transacciones</a>
                    <a href="{{ route('cuentas.index') }}" class="nav-item px-2 py-1.5">Cuentas</a>
                    <a href="{{ route('categorias.index') }}" class="nav-item px-2 py-1.5">Categorías</a>
                </div>
            </section>
        </aside>
    </div>

    {{-- Danger zone --}}
    <section class="mt-5 overflow-hidden rounded-xl border border-expense-200 bg-white dark:border-expense-500/30 dark:bg-neutral-900">
        <div class="border-b border-expense-100 bg-expense-50/50 px-5 py-4 dark:border-expense-500/20 dark:bg-expense-500/5">
            <h2 class="text-[0.9375rem] font-semibold text-expense-800 dark:text-expense-200">Zona de riesgo</h2>
            <p class="mt-0.5 text-[0.75rem] text-expense-700/80 dark:text-expense-300/80">Eliminar tu cuenta borra también todas tus cuentas y movimientos. Esta acción es irreversible.</p>
        </div>

        <form method="POST" action="{{ route('profile.destroy') }}" class="p-5" onsubmit="return confirm('¿Eliminar definitivamente tu cuenta y todos tus datos financieros?')">
            @csrf
            @method('DELETE')

            <div class="flex flex-col gap-3 sm:flex-row sm:items-end">
                <div class="w-full sm:max-w-xs">
                    <label for="delete_password" class="label">Confirma con tu contraseña</label>
                    <input id="delete_password"
                           type="password"
                           name="password"
                           required
                           autocomplete="current-password"
                           class="input {{ $errors->userDeletion->has('password') ? 'input-error' : '' }}"
                           aria-invalid="{{ $errors->userDeletion->has('password') ? 'true' : 'false' }}">
                    @if ($errors->userDeletion->has('password'))
                        <p class="form-error" role="alert">{{ $errors->userDeletion->first('password') }}</p>
                    @endif
                </div>
                <button type="submit" class="btn-destructive btn-md w-full sm:w-auto">
                    Eliminar mi cuenta
                </button>
            </div>
        </form>
    </section>
</x-app-layout>