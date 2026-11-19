<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-heading-lg text-neutral-900 dark:text-neutral-50">Editar cuenta</h2>
                <p class="text-body text-neutral-600 dark:text-neutral-400 mt-1">Modifica la información de {{ $cuenta->nombre }}</p>
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
                @if ($cuenta->tieneTransacciones())
                    <div class="mb-6 p-4 bg-warning-50 dark:bg-warning-900/20 border border-warning-200 dark:border-warning-800 rounded-xl">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-warning-600 dark:text-warning-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <p class="text-body-sm font-medium text-warning-800 dark:text-warning-300">Saldo calculado automáticamente</p>
                                <p class="text-caption text-warning-700 dark:text-warning-400 mt-1">Esta cuenta tiene {{ $cuenta->transacciones_count }} movimiento{{ $cuenta->transacciones_count !== 1 ? 's' : '' }}. El saldo se actualiza automáticamente y no se puede editar manualmente.</p>
                            </div>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('cuentas.update', $cuenta) }}" class="space-y-6" novalidate>
                    @csrf
                    @method('PUT')

                    <!-- Nombre -->
                    <div>
                        <label for="nombre" class="label">Nombre <span class="text-expense-500" aria-hidden="true">*</span></label>
                        <input id="nombre"
                               type="text"
                               name="nombre"
                               value="{{ old('nombre', $cuenta->nombre) }}"
                               required
                               maxlength="150"
                               autocomplete="off"
                               class="input {{ $errors->has('nombre') ? 'input-error' : '' }}"
                               aria-describedby="{{ $errors->has('nombre') ? 'nombre-error' : 'nombre-hint' }}"
                               aria-invalid="{{ $errors->has('nombre') ? 'true' : 'false' }}"
                               placeholder="Ej: Efectivo, Bancolombia, Ahorros...">
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
                                  placeholder="Breve descripción...">{{ old('descripcion', $cuenta->descripcion) }}</textarea>
                        @if ($errors->has('descripcion'))
                            <p id="descripcion-error" class="form-error" role="alert">{{ $errors->first('descripcion') }}</p>
                        @else
                            <p id="descripcion-hint" class="form-hint">Máximo 255 caracteres</p>
                        @endif
                    </div>

                    <!-- Saldo (solo lectura si tiene movimientos) / Moneda -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div>
                            <label for="saldo" class="label">
                                Saldo actual
                                @if ($cuenta->tieneTransacciones())
                                    <span class="text-caption font-normal text-neutral-500 dark:text-neutral-400 ml-1">(automático)</span>
                                @else
                                    <span class="text-expense-500" aria-hidden="true">*</span>
                                @endif
                            </label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-neutral-500 dark:text-neutral-400" aria-hidden="true">{{ $cuenta->moneda }} </span>
                                <input id="saldo"
                                       type="number"
                                       name="saldo"
                                       value="{{ old('saldo', $cuenta->saldo) }}"
                                       step="0.01"
                                       min="0"
                                       max="9999999999999999.99"
                                       class="input pl-12 {{ $errors->has('saldo') ? 'input-error' : '' }}"
                                       aria-describedby="{{ $errors->has('saldo') ? 'saldo-error' : 'saldo-hint' }}"
                                       aria-invalid="{{ $errors->has('saldo') ? 'true' : 'false' }}"
                                       {{ $cuenta->tieneTransacciones() ? 'readonly' : 'required' }}>
                            </div>
                            @if ($errors->has('saldo'))
                                <p id="saldo-error" class="form-error" role="alert">{{ $errors->first('saldo') }}</p>
                            @elseif ($cuenta->tieneTransacciones())
                                <p id="saldo-hint" class="form-hint">El saldo se calcula automáticamente a partir de los movimientos registrados</p>
                            @else
                                <p id="saldo-hint" class="form-hint">Saldo inicial de la cuenta</p>
                            @endif
                        </div>

                        <div>
                            <label for="moneda" class="label">Moneda</label>
                            <div class="relative">
                                <select id="moneda"
                                        name="moneda"
                                        class="input {{ $errors->has('moneda') ? 'input-error' : '' }}"
                                        aria-describedby="{{ $errors->has('moneda') ? 'moneda-error' : 'moneda-hint' }}"
                                        {{ $cuenta->tieneTransacciones() ? 'disabled' : 'required' }}>
                                    <option value="COP" {{ $cuenta->moneda === 'COP' ? 'selected' : '' }}>COP - Peso Colombiano</option>
                                    <option value="USD" {{ $cuenta->moneda === 'USD' ? 'selected' : '' }}>USD - Dólar Americano</option>
                                    <option value="EUR" {{ $cuenta->moneda === 'EUR' ? 'selected' : '' }}>EUR - Euro</option>
                                    <option value="MXN" {{ $cuenta->moneda === 'MXN' ? 'selected' : '' }}>MXN - Peso Mexicano</option>
                                    <option value="PEN" {{ $cuenta->moneda === 'PEN' ? 'selected' : '' }}>PEN - Sol Peruano</option>
                                </select>
                            </div>
                            @if ($errors->has('moneda'))
                                <p id="moneda-error" class="form-error" role="alert">{{ $errors->first('moneda') }}</p>
                            @elseif ($cuenta->tieneTransacciones())
                                <p id="moneda-hint" class="form-hint">No se puede cambiar: la cuenta tiene movimientos en esta moneda</p>
                            @else
                                <p id="moneda-hint" class="form-hint">La moneda no se puede cambiar después si hay movimientos</p>
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Guardar cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>