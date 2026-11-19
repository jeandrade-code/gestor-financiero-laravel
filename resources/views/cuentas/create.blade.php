<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-heading-lg text-neutral-900 dark:text-neutral-50">Nueva cuenta</h2>
                <p class="text-body text-neutral-600 dark:text-neutral-400 mt-1">Añade una cuenta de efectivo, bancaria o de inversión</p>
            </div>
            <a href="{{ route('cuentas.index') }}" class="btn-secondary btn-md">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Volver
            </a>
        </div>
    </x-slot>

    <div class="max-w-2xl">
        <div class="card animate-in">
            <div class="card-header">
                <h3 class="text-heading-md text-neutral-900 dark:text-neutral-50">Información de la cuenta</h3>
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('cuentas.store') }}" class="space-y-6" novalidate>
                    @csrf

                    <!-- Nombre -->
                    <div>
                        <label for="nombre" class="label">Nombre <span class="text-expense-500" aria-hidden="true">*</span></label>
                        <input id="nombre"
                               type="text"
                               name="nombre"
                               value="{{ old('nombre') }}"
                               required
                               maxlength="150"
                               autocomplete="off"
                               class="input {{ $errors->has('nombre') ? 'input-error' : '' }}"
                               aria-describedby="{{ $errors->has('nombre') ? 'nombre-error' : 'nombre-hint' }}"
                               aria-invalid="{{ $errors->has('nombre') ? 'true' : 'false' }}"
                               placeholder="Ej: Efectivo, Bancolombia, Ahorros, Tarjeta de crédito...">
                        @if ($errors->has('nombre'))
                            <p id="nombre-error" class="form-error" role="alert">{{ $errors->first('nombre') }}</p>
                        @else
                            <p id="nombre-hint" class="form-hint">Máximo 150 caracteres</p>
                        @endif
                    </div>

                    <!-- Descripción -->
                    <div>
                        <label for="descripcion" class="label">Descripción (opcional)</label>
                        <textarea id="descripcion"
                                  name="descripcion"
                                  rows="3"
                                  maxlength="255"
                                  class="input {{ $errors->has('descripcion') ? 'input-error' : '' }}"
                                  aria-describedby="{{ $errors->has('descripcion') ? 'descripcion-error' : 'descripcion-hint' }}"
                                  placeholder="Breve descripción...">{{ old('descripcion') }}</textarea>
                        @if ($errors->has('descripcion'))
                            <p id="descripcion-error" class="form-error" role="alert">{{ $errors->first('descripcion') }}</p>
                        @else
                            <p id="descripcion-hint" class="form-hint">Máximo 255 caracteres</p>
                        @endif
                    </div>

                    <!-- Saldo inicial y Moneda -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div>
                            <label for="saldo" class="label">Saldo inicial <span class="text-expense-500" aria-hidden="true">*</span></label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-neutral-500 dark:text-neutral-400" aria-hidden="true">$</span>
                                <input id="saldo"
                                       type="number"
                                       name="saldo"
                                       value="{{ old('saldo', 0) }}"
                                       required
                                       step="0.01"
                                       min="0"
                                       max="9999999999999999.99"
                                       class="input pl-8 {{ $errors->has('saldo') ? 'input-error' : '' }}"
                                       aria-describedby="{{ $errors->has('saldo') ? 'saldo-error' : 'saldo-hint' }}"
                                       aria-invalid="{{ $errors->has('saldo') ? 'true' : 'false' }}"
                                       placeholder="0.00">
                            </div>
                            @if ($errors->has('saldo'))
                                <p id="saldo-error" class="form-error" role="alert">{{ $errors->first('saldo') }}</p>
                            @else
                                <p id="saldo-hint" class="form-hint">El saldo se actualizará automáticamente con los movimientos</p>
                            @endif
                        </div>

                        <div>
                            <label for="moneda" class="label">Moneda <span class="text-expense-500" aria-hidden="true">*</span></label>
                            <select id="moneda"
                                    name="moneda"
                                    required
                                    class="input {{ $errors->has('moneda') ? 'input-error' : '' }}"
                                    aria-describedby="{{ $errors->has('moneda') ? 'moneda-error' : 'moneda-hint' }}"
                                    aria-invalid="{{ $errors->has('moneda') ? 'true' : 'false' }}">
                                <option value="COP" {{ old('moneda', 'COP') === 'COP' ? 'selected' : '' }}>COP - Peso Colombiano</option>
                                <option value="USD" {{ old('moneda') === 'USD' ? 'selected' : '' }}>USD - Dólar Americano</option>
                                <option value="EUR" {{ old('moneda') === 'EUR' ? 'selected' : '' }}>EUR - Euro</option>
                                <option value="MXN" {{ old('moneda') === 'MXN' ? 'selected' : '' }}>MXN - Peso Mexicano</option>
                                <option value="PEN" {{ old('moneda') === 'PEN' ? 'selected' : '' }}>PEN - Sol Peruano</option>
                            </select>
                            @if ($errors->has('moneda'))
                                <p id="moneda-error" class="form-error" role="alert">{{ $errors->first('moneda') }}</p>
                            @else
                                <p id="moneda-hint" class="form-hint">La moneda no se puede cambiar después</p>
                            @endif
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-neutral-200 dark:border-neutral-700">
                        <a href="{{ route('cuentas.index') }}" class="btn-secondary btn-md flex-1 sm:flex-none">
                            Cancelar
                        </a>
                        <button type="submit" class="btn-primary btn-md flex-1 sm:flex-none">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Crear cuenta
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>