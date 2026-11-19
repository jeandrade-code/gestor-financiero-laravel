@php
    $tieneMovimientos = $cuenta->exists && $cuenta->tieneTransacciones();
    $monedaSeleccionada = old('moneda', $cuenta->moneda ?? 'COP');
@endphp

<div class="space-y-5">
    <div>
        <label for="nombre" class="label">Nombre <span class="required-mark" aria-hidden="true">*</span></label>
        <input id="nombre"
               type="text"
               name="nombre"
               value="{{ old('nombre', $cuenta->nombre) }}"
               required
               maxlength="150"
               autocomplete="off"
               autofocus
               class="input {{ $errors->has('nombre') ? 'input-error' : '' }}"
               aria-describedby="{{ $errors->has('nombre') ? 'nombre-error' : 'nombre-hint' }}"
               aria-invalid="{{ $errors->has('nombre') ? 'true' : 'false' }}"
               placeholder="Ej. Caja, Bancolombia, Ahorros">
        @if ($errors->has('nombre'))
            <p id="nombre-error" class="form-error" role="alert">{{ $errors->first('nombre') }}</p>
        @else
            <p id="nombre-hint" class="form-hint">Usa el nombre con el que reconoces la cuenta en tu día a día.</p>
        @endif
    </div>

    <div>
        <label for="descripcion" class="label">Descripción <span class="ml-1 font-normal text-neutral-400">Opcional</span></label>
        <textarea id="descripcion"
                  name="descripcion"
                  rows="3"
                  maxlength="255"
                  class="input resize-y {{ $errors->has('descripcion') ? 'input-error' : '' }}"
                  placeholder="¿Para qué usas esta cuenta?">{{ old('descripcion', $cuenta->descripcion) }}</textarea>
        @if ($errors->has('descripcion'))
            <p class="form-error" role="alert">{{ $errors->first('descripcion') }}</p>
        @else
            <p class="form-hint">Máximo 255 caracteres.</p>
        @endif
    </div>

    <div class="grid gap-5 sm:grid-cols-2">
        <div>
            <label for="saldo" class="label">
                {{ $tieneMovimientos ? 'Saldo actual' : 'Saldo inicial' }} <span class="required-mark" aria-hidden="true">*</span>
            </label>
            <div class="relative">
                <span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 font-mono text-[0.75rem] text-neutral-400">$</span>
                <input id="saldo"
                       type="number"
                       name="saldo"
                       value="{{ old('saldo', $cuenta->saldo ?? '0.00') }}"
                       required
                       step="0.01"
                       min="0"
                       max="9999999999999999.99"
                       class="input pl-7 font-mono tabular-nums {{ $errors->has('saldo') ? 'input-error' : '' }} {{ $tieneMovimientos ? 'cursor-not-allowed bg-neutral-100 text-neutral-500 dark:bg-neutral-800/60 dark:text-neutral-400' : '' }}"
                       aria-describedby="{{ $errors->has('saldo') ? 'saldo-error' : 'saldo-hint' }}"
                       aria-invalid="{{ $errors->has('saldo') ? 'true' : 'false' }}"
                       placeholder="0.00"
                       @readonly($tieneMovimientos)>
            </div>
            @if ($errors->has('saldo'))
                <p id="saldo-error" class="form-error" role="alert">{{ $errors->first('saldo') }}</p>
            @elseif ($tieneMovimientos)
                <p id="saldo-hint" class="form-hint">Se calcula automáticamente a partir de los movimientos.</p>
            @else
                <p id="saldo-hint" class="form-hint">El monto con el que abre la cuenta.</p>
            @endif
        </div>

        <div>
            <label for="moneda" class="label">Moneda <span class="required-mark" aria-hidden="true">*</span></label>
            @if ($tieneMovimientos)
                <input type="hidden" name="moneda" value="{{ $cuenta->moneda }}">
            @endif
            <select id="moneda"
                    name="moneda"
                    @required(! $tieneMovimientos)
                    @disabled($tieneMovimientos)
                    class="input {{ $errors->has('moneda') ? 'input-error' : '' }} {{ $tieneMovimientos ? 'cursor-not-allowed bg-neutral-100 text-neutral-500 dark:bg-neutral-800/60 dark:text-neutral-400' : '' }}"
                    aria-describedby="{{ $errors->has('moneda') ? 'moneda-error' : 'moneda-hint' }}">
                @foreach (['COP' => 'COP — Peso colombiano', 'USD' => 'USD — Dólar estadounidense', 'EUR' => 'EUR — Euro', 'MXN' => 'MXN — Peso mexicano', 'PEN' => 'PEN — Sol peruano'] as $codigo => $etiqueta)
                    <option value="{{ $codigo }}" @selected($monedaSeleccionada === $codigo)>{{ $etiqueta }}</option>
                @endforeach
            </select>
            @if ($errors->has('moneda'))
                <p id="moneda-error" class="form-error" role="alert">{{ $errors->first('moneda') }}</p>
            @elseif ($tieneMovimientos)
                <p id="moneda-hint" class="form-hint">No se puede cambiar porque la cuenta ya tiene movimientos.</p>
            @else
                <p id="moneda-hint" class="form-hint">Se bloquea al registrar el primer movimiento.</p>
            @endif
        </div>
    </div>
</div>