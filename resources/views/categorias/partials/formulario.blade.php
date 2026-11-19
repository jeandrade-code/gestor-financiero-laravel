@php
    $tipoSeleccionado = old('tipo', $categoria->tipo ?: 'ingreso');
    $tipoBloqueado = $tipoBloqueado ?? false;
@endphp

<div class="space-y-5">
    <div>
        <label for="nombre" class="label">Nombre <span class="required-mark" aria-hidden="true">*</span></label>
        <input id="nombre"
               type="text"
               name="nombre"
               value="{{ old('nombre', $categoria->nombre) }}"
               required
               maxlength="150"
               autocomplete="off"
               autofocus
               class="input {{ $errors->has('nombre') ? 'input-error' : '' }}"
               aria-describedby="{{ $errors->has('nombre') ? 'nombre-error' : 'nombre-hint' }}"
               aria-invalid="{{ $errors->has('nombre') ? 'true' : 'false' }}"
               placeholder="Ej. Salario, Arrendamiento, Servicios">
        @if ($errors->has('nombre'))
            <p id="nombre-error" class="form-error" role="alert">{{ $errors->first('nombre') }}</p>
        @else
            <p id="nombre-hint" class="form-hint">Un nombre corto facilita encontrar la categoría al registrar movimientos.</p>
        @endif
    </div>

    <div>
        <span class="label">Tipo <span class="required-mark" aria-hidden="true">*</span></span>
        <div class="grid gap-3 sm:grid-cols-2">
            @foreach ([
                'ingreso' => ['label' => 'Ingreso', 'text' => 'Dinero que entra a una cuenta.', 'chip' => 'icon-chip-income', 'icon' => 'M5 10l7-7m0 0l7 7m-7-7v18'],
                'gasto' => ['label' => 'Gasto', 'text' => 'Dinero que sale de una cuenta.', 'chip' => 'icon-chip-expense', 'icon' => 'M19 10l-7 7m0 0l-7-7m7-7v18'],
            ] as $value => $data)
                <label class="type-option">
                    <input type="radio"
                           name="tipo"
                           value="{{ $value }}"
                           @checked($tipoSeleccionado === $value)
                           required
                           class="sr-only"
                           @disabled($tipoBloqueado)>
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

        @if ($tipoBloqueado)
            <p class="form-hint flex items-start gap-1.5">
                <svg class="mt-0.5 h-3.5 w-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 9v3.75m0 3.75h.008v.008H12v-.008zM10.34 3.94l-8.22 14.25A1.5 1.5 0 003.42 20.5h17.16a1.5 1.5 0 001.3-2.31L13.66 3.94a1.5 1.5 0 00-2.6 0z" />
                </svg>
                El tipo no se puede cambiar porque la categoría ya tiene movimientos asociados.
            </p>
        @endif

        @if ($errors->has('tipo'))
            <p class="form-error" role="alert">{{ $errors->first('tipo') }}</p>
        @endif
    </div>

    <div>
        <label for="descripcion" class="label">Descripción <span class="ml-1 font-normal text-neutral-400">Opcional</span></label>
        <textarea id="descripcion"
                  name="descripcion"
                  rows="3"
                  maxlength="255"
                  class="input resize-y {{ $errors->has('descripcion') ? 'input-error' : '' }}"
                  aria-describedby="{{ $errors->has('descripcion') ? 'descripcion-error' : 'descripcion-hint' }}"
                  placeholder="¿Qué incluye esta categoría?">{{ old('descripcion', $categoria->descripcion) }}</textarea>
        @if ($errors->has('descripcion'))
            <p id="descripcion-error" class="form-error" role="alert">{{ $errors->first('descripcion') }}</p>
        @else
            <p id="descripcion-hint" class="form-hint">Máximo 255 caracteres.</p>
        @endif
    </div>
</div>