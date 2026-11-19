@php
    $tipoSeleccionado = old('tipo', $transaccion->tipo);
    $cuentaSeleccionada = old('cuenta_id', $transaccion->cuenta_id);
    $categoriaSeleccionada = old('categoria_id', $transaccion->categoria_id);
    $fechaSeleccionada = old('fecha', $transaccion->fecha?->format('Y-m-d'));
@endphp

<div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
    <div>
        <x-input-label for="cuenta_id" value="Cuenta" />
        <select id="cuenta_id" name="cuenta_id" required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            <option value="">Seleccione una cuenta</option>
            @foreach ($cuentas as $cuenta)
                <option value="{{ $cuenta->id }}" @selected((string) $cuentaSeleccionada === (string) $cuenta->id)>
                    {{ $cuenta->nombre }} — saldo {{ $cuenta->saldoFormateado() }}
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('cuenta_id')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="tipo" value="Tipo de movimiento" />
        <select id="tipo" name="tipo" required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            <option value="">Seleccione un tipo</option>
            @foreach ($tipos as $valor => $etiqueta)
                <option value="{{ $valor }}" @selected($tipoSeleccionado === $valor)>{{ $etiqueta }}</option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('tipo')" class="mt-2" />
    </div>
</div>

<div>
    <x-input-label for="categoria_id" value="Categoría" />
    <select id="categoria_id" name="categoria_id" required
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        <option value="">Seleccione una categoría</option>
        @foreach ($categorias as $categoria)
            <option value="{{ $categoria->id }}" data-tipo="{{ $categoria->tipo }}"
                    @selected((string) $categoriaSeleccionada === (string) $categoria->id)>
                {{ $categoria->nombre }} ({{ $categoria->tipo }})
            </option>
        @endforeach
    </select>
    <p class="mt-1 text-xs text-gray-500">La categoría debe coincidir con el tipo de movimiento seleccionado.</p>
    <x-input-error :messages="$errors->get('categoria_id')" class="mt-2" />
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
    <div>
        <x-input-label for="monto" value="Monto" />
        <x-text-input id="monto" name="monto" type="number" step="0.01" min="0.01" class="mt-1 block w-full"
                      :value="old('monto', $transaccion->monto)" required />
        <x-input-error :messages="$errors->get('monto')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="fecha" value="Fecha" />
        <x-text-input id="fecha" name="fecha" type="date" class="mt-1 block w-full"
                      :value="$fechaSeleccionada" required />
        <x-input-error :messages="$errors->get('fecha')" class="mt-2" />
    </div>
</div>

<div>
    <x-input-label for="descripcion" value="Descripción (opcional)" />
    <textarea id="descripcion" name="descripcion" rows="3"
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('descripcion', $transaccion->descripcion) }}</textarea>
    <x-input-error :messages="$errors->get('descripcion')" class="mt-2" />
</div>

<script>
    (function () {
        const tipo = document.getElementById('tipo');
        const categoria = document.getElementById('categoria_id');

        if (! tipo || ! categoria) {
            return;
        }

        const filtrar = function () {
            const seleccionado = tipo.value;
            let primeraVisible = null;

            Array.from(categoria.options).forEach(function (opcion) {
                const tipoOpcion = opcion.dataset.tipo;

                if (! tipoOpcion) {
                    opcion.hidden = false;

                    return;
                }

                const visible = seleccionado === '' || tipoOpcion === seleccionado;
                opcion.hidden = ! visible;

                if (visible && primeraVisible === null) {
                    primeraVisible = opcion;
                }
            });

            if (categoria.selectedOptions.length > 0 && categoria.selectedOptions[0].hidden) {
                categoria.value = primeraVisible ? primeraVisible.value : '';
            }
        };

        tipo.addEventListener('change', filtrar);
        filtrar();
    })();
</script>