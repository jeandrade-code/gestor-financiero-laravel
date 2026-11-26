@php
    $tipoSeleccionado = old('tipo', $transaccion->tipo ?: 'ingreso');
    $cuentaSeleccionada = old('cuenta_id', $transaccion->cuenta_id);
    $categoriaSeleccionada = old('categoria_id', $transaccion->categoria_id);
    $fechaSeleccionada = old('fecha', $transaccion->fecha?->format('Y-m-d') ?? now()->toDateString());
    $cuentaActual = $cuentas->firstWhere('id', (int) $cuentaSeleccionada);
    $monedaActual = $cuentaActual->moneda ?? 'COP';
    $montoInicial = old('monto', $transaccion->monto);
    $montoVisible = $montoInicial === null || $montoInicial === ''
        ? ''
        : number_format((float) $montoInicial, 2, ',', '.');
@endphp

<div class="space-y-5">
    {{-- Cuenta --}}
    <div>
        <label for="cuenta_id" class="label">Cuenta <span class="required-mark" aria-hidden="true">*</span></label>
        <select id="cuenta_id"
                name="cuenta_id"
                required
                class="input {{ $errors->has('cuenta_id') ? 'input-error' : '' }}"
                aria-describedby="{{ $errors->has('cuenta_id') ? 'cuenta_id-error' : 'cuenta-disponible' }}"
                aria-invalid="{{ $errors->has('cuenta_id') ? 'true' : 'false' }}">
            <option value="">Selecciona una cuenta</option>
            @foreach ($cuentas as $cuenta)
                <option value="{{ $cuenta->id }}"
                        @selected((string) $cuentaSeleccionada === (string) $cuenta->id)
                        data-saldo="{{ (float) $cuenta->saldo }}"
                        data-moneda="{{ $cuenta->moneda }}">
                    {{ $cuenta->nombre }} — {{ $cuenta->saldoFormateado() }}
                </option>
            @endforeach
        </select>
        @if ($errors->has('cuenta_id'))
            <p id="cuenta_id-error" class="form-error" role="alert">{{ $errors->first('cuenta_id') }}</p>
        @else
            <p id="cuenta-disponible" class="form-hint">
                @if ($cuentaActual)
                    Saldo disponible: <span class="font-mono tabular-nums">{{ $cuentaActual->saldoFormateado() }}</span>
                @else
                    Selecciona una cuenta para ver su saldo disponible.
                @endif
            </p>
        @endif
    </div>

    {{-- Tipo --}}
    <div>
        <span class="label">Tipo de movimiento <span class="required-mark" aria-hidden="true">*</span></span>
        <div class="grid gap-3 sm:grid-cols-2">
            @foreach ([
                'ingreso' => ['label' => 'Ingreso', 'text' => 'Suma al saldo de la cuenta.', 'chip' => 'icon-chip-income', 'icon' => 'M5 10l7-7m0 0l7 7m-7-7v18'],
                'gasto' => ['label' => 'Gasto', 'text' => 'Resta del saldo disponible.', 'chip' => 'icon-chip-expense', 'icon' => 'M19 10l-7 7m0 0l-7-7m7-7v18'],
            ] as $value => $data)
                <label class="type-option">
                    <input type="radio"
                           name="tipo"
                           value="{{ $value }}"
                           @checked($tipoSeleccionado === $value)
                           required
                           class="sr-only">
                    <span class="icon-chip {{ $data['chip'] }}">
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="{{ $data['icon'] }}" />
                        </svg>
                    </span>
                    <span class="min-w-0">
                        <span class="block text-[0.875rem] font-medium text-neutral-900 dark:text-neutral-50">{{ $data['label'] }}</span>
                        <span class="mt-0.5 block text-[0.75rem] text-neutral-500 dark:text-neutral-400">{{ $data['text'] }}</span>
                    </span>
                    <span class="type-check ml-auto">
                        <svg class="h-2.5 w-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                        </svg>
                    </span>
                </label>
            @endforeach
        </div>
        @if ($errors->has('tipo'))
            <p class="form-error" role="alert">{{ $errors->first('tipo') }}</p>
        @endif
    </div>

    {{-- Categoría --}}
    <div>
        <label for="categoria_id" class="label">Categoría <span class="required-mark" aria-hidden="true">*</span></label>
        <select id="categoria_id"
                name="categoria_id"
                required
                class="input {{ $errors->has('categoria_id') ? 'input-error' : '' }}"
                aria-describedby="{{ $errors->has('categoria_id') ? 'categoria_id-error' : 'categoria_id-hint' }}"
                aria-invalid="{{ $errors->has('categoria_id') ? 'true' : 'false' }}">
            <option value="">Selecciona una categoría</option>
            @foreach ($categorias as $categoria)
                <option value="{{ $categoria->id }}"
                        @selected((string) $categoriaSeleccionada === (string) $categoria->id)
                        data-tipo="{{ $categoria->tipo }}"
                        @if ($tipoSeleccionado !== $categoria->tipo) hidden disabled @endif>
                    {{ $categoria->nombre }}
                </option>
            @endforeach
        </select>
        @if ($errors->has('categoria_id'))
            <p id="categoria_id-error" class="form-error" role="alert">{{ $errors->first('categoria_id') }}</p>
        @else
            <p id="categoria_id-hint" class="form-hint">Solo se muestran las categorías del tipo seleccionado.</p>
        @endif
    </div>

    {{-- Monto y fecha --}}
    <div class="grid gap-5 sm:grid-cols-2">
        <div>
            <label for="monto" class="label">Monto <span class="required-mark" aria-hidden="true">*</span></label>
            <div class="relative">
                <span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 font-mono text-[0.75rem] text-neutral-400" aria-hidden="true">$</span>
                <input id="monto"
                       type="text"
                       inputmode="decimal"
                       value="{{ $montoVisible }}"
                       data-money-input
                       data-money-target="monto-valor"
                       autocomplete="off"
                       required
                       class="input pl-7 pr-14 font-mono tabular-nums {{ $errors->has('monto') ? 'input-error' : '' }}"
                       aria-describedby="{{ $errors->has('monto') ? 'monto-error' : 'monto-hint' }}"
                       aria-invalid="{{ $errors->has('monto') ? 'true' : 'false' }}"
                       placeholder="0,00">
                <input type="hidden" id="monto-valor" name="monto" value="{{ $montoInicial }}">
                <span id="monto-moneda" class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-[0.625rem] font-medium uppercase tracking-[0.08em] text-neutral-400">{{ $monedaActual }}</span>
            </div>
            @if ($errors->has('monto'))
                <p id="monto-error" class="form-error" role="alert">{{ $errors->first('monto') }}</p>
            @else
                <p id="monto-hint" class="form-hint">Debe ser mayor que cero.</p>
            @endif
            <p id="alerta-saldo" class="form-error hidden" role="status"></p>
        </div>

        <div>
            <label for="fecha" class="label">Fecha <span class="required-mark" aria-hidden="true">*</span></label>
            <input id="fecha"
                   type="date"
                   name="fecha"
                   value="{{ $fechaSeleccionada }}"
                   required
                   max="{{ now()->toDateString() }}"
                   class="input {{ $errors->has('fecha') ? 'input-error' : '' }}"
                   aria-describedby="{{ $errors->has('fecha') ? 'fecha-error' : 'fecha-hint' }}"
                   aria-invalid="{{ $errors->has('fecha') ? 'true' : 'false' }}">
            @if ($errors->has('fecha'))
                <p id="fecha-error" class="form-error" role="alert">{{ $errors->first('fecha') }}</p>
            @else
                <p id="fecha-hint" class="form-hint">No puede ser una fecha futura.</p>
            @endif
        </div>
    </div>

    {{-- Descripción --}}
    <div>
        <label for="descripcion" class="label">Descripción <span class="ml-1 font-normal text-neutral-400">Opcional</span></label>
        <textarea id="descripcion"
                  name="descripcion"
                  rows="3"
                  maxlength="255"
                  class="input resize-y {{ $errors->has('descripcion') ? 'input-error' : '' }}"
                  placeholder="Detalle del movimiento">{{ old('descripcion', $transaccion->descripcion) }}</textarea>
        @if ($errors->has('descripcion'))
            <p class="form-error" role="alert">{{ $errors->first('descripcion') }}</p>
        @else
            <p class="form-hint">Máximo 255 caracteres.</p>
        @endif
    </div>
</div>