<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-heading-lg text-neutral-900 dark:text-neutral-50">Editar transacción</h2>
                <p class="text-body text-neutral-600 dark:text-neutral-400 mt-1">Modifica el movimiento del {{ $transaccion->fecha->format('d/m/Y') }}</p>
            </div>
            <a href="{{ route('transacciones.index') }}" class="btn-secondary btn-md">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Volver
            </a>
        </div>
    </x-slot>

    <div class="max-w-2xl">
        @if ($transaccion->esIngreso())
            <div class="mb-6 p-4 bg-income-50 dark:bg-income-900/20 border border-income-200 dark:border-income-800 rounded-xl animate-in">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-income-600 dark:text-income-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                    </svg>
                    <div>
                        <p class="text-body-sm font-medium text-income-800 dark:text-income-300">Ingreso registrado</p>
                        <p class="text-caption text-income-700 dark:text-income-400 mt-1">Al editar, se revertirá el efecto anterior en el saldo de la cuenta y se aplicará el nuevo valor.</p>
                    </div>
                </div>
            </div>
        @else
            <div class="mb-6 p-4 bg-expense-50 dark:bg-expense-900/20 border border-expense-200 dark:border-expense-800 rounded-xl animate-in">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-expense-600 dark:text-expense-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 10l-7 7m0 0l-7-7m7-7v18"/>
                    </svg>
                    <div>
                        <p class="text-body-sm font-medium text-expense-800 dark:text-expense-300">Gasto registrado</p>
                        <p class="text-caption text-expense-700 dark:text-expense-400 mt-1">Al editar, se revertirá el efecto anterior en el saldo de la cuenta y se aplicará el nuevo valor.</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="card animate-in stagger-1">
            <div class="card-header">
                <h3 class="text-heading-md text-neutral-900 dark:text-neutral-50">Detalles de la transacción</h3>
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('transacciones.update', $transaccion) }}" class="space-y-6" novalidate id="transaccion-form">
                    @csrf
                    @method('PUT')

                    <!-- Cuenta -->
                    <div>
                        <label for="cuenta_id" class="label">Cuenta <span class="text-expense-500" aria-hidden="true">*</span></label>
                        <select id="cuenta_id"
                                name="cuenta_id"
                                required
                                class="input {{ $errors->has('cuenta_id') ? 'input-error' : '' }}"
                                aria-describedby="{{ $errors->has('cuenta_id') ? 'cuenta_id-error' : 'cuenta_id-hint' }}"
                                aria-invalid="{{ $errors->has('cuenta_id') ? 'true' : 'false' }}">
                            <option value="">Selecciona una cuenta</option>
                            @foreach ($cuentas as $cuenta)
                                <option value="{{ $cuenta->id }}"
                                        {{ old('cuenta_id', $transaccion->cuenta_id) == $cuenta->id ? 'selected' : '' }}
                                        data-saldo="{{ $cuenta->saldo }}"
                                        data-moneda="{{ $cuenta->moneda }}">
                                    {{ $cuenta->nombre }} — {{ $cuenta->saldoFormateado() }}
                                </option>
                            @endforeach
                        </select>
                        @if ($errors->has('cuenta_id'))
                            <p id="cuenta_id-error" class="form-error" role="alert">{{ $errors->first('cuenta_id') }}</p>
                        @else
                            <p id="cuenta_id-hint" class="form-hint">Cambiar la cuenta revertirá el efecto en la anterior y aplicará en la nueva</p>
                        @endif
                    </div>

                    <!-- Tipo -->
                    <div>
                        <label class="label">Tipo <span class="text-expense-500" aria-hidden="true">*</span></label>
                        <div class="grid grid-cols-2 gap-3">
                            @foreach(['ingreso' => ['label' => 'Ingreso', 'icon' => 'M5 10l7-7m0 0l7 7m-7-7v18', 'color' => 'income'], 'gasto' => ['label' => 'Gasto', 'icon' => 'M19 10l-7 7m0 0l-7-7m7-7v18', 'color' => 'expense']] as $value => $data)
                                <label class="relative">
                                    <input type="radio"
                                           name="tipo"
                                           value="{{ $value }}"
                                           {{ old('tipo', $transaccion->tipo) === $value ? 'checked' : '' }}
                                           required
                                           class="peer sr-only"
                                           aria-describedby="{{ $errors->has('tipo') ? 'tipo-error' : '' }}"
                                           onchange="filtrarCategorias(this.value)">
                                    <div class="peer-checked:border-{{ $data['color'] }}-500 peer-checked:bg-{{ $data['color'] }}-50 dark:peer-checked:bg-{{ $data['color'] }}-900/20 peer-focus:ring-2 peer-focus:ring-{{ $data['color'] }}-500 peer-focus:ring-offset-2 border-2 border-neutral-200 dark:border-neutral-700 rounded-xl p-4 text-center cursor-pointer transition-all duration-200">
                                        <div class="w-10 h-10 mx-auto mb-2 rounded-lg flex items-center justify-center
                                            {{ $value === 'ingreso' ? 'bg-income-100 text-income-600 dark:bg-income-900/30 dark:text-income-400 peer-checked:bg-income-600 peer-checked:text-white'
                                               : 'bg-expense-100 text-expense-600 dark:bg-expense-900/30 dark:text-expense-400 peer-checked:bg-expense-600 peer-checked:text-white' }}">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $data['icon'] }}"/>
                                            </svg>
                                        </div>
                                        <span class="text-body font-medium text-neutral-900 dark:text-neutral-50 peer-checked:text-{{ $data['color'] }}-700 dark:peer-checked:text-{{ $data['color'] }}-300">{{ $data['label'] }}</span>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                        @if ($errors->has('tipo'))
                            <p id="tipo-error" class="form-error" role="alert">{{ $errors->first('tipo') }}</p>
                        @endif
                    </div>

                    <!-- Categoría -->
                    <div>
                        <label for="categoria_id" class="label">Categoría <span class="text-expense-500" aria-hidden="true">*</span></label>
                        <select id="categoria_id"
                                name="categoria_id"
                                required
                                class="input {{ $errors->has('categoria_id') ? 'input-error' : '' }}"
                                aria-describedby="{{ $errors->has('categoria_id') ? 'categoria_id-error' : 'categoria_id-hint' }}"
                                aria-invalid="{{ $errors->has('categoria_id') ? 'true' : 'false' }}">
                            <option value="">Selecciona un tipo primero</option>
                            @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->id }}"
                                        {{ old('categoria_id', $transaccion->categoria_id) == $categoria->id ? 'selected' : '' }}
                                        data-tipo="{{ $categoria->tipo }}"
                                        {{ (old('tipo', $transaccion->tipo) && old('tipo', $transaccion->tipo) !== $categoria->tipo) ? 'hidden' : '' }}>
                                    {{ $categoria->nombre }} ({{ $categoria->tipo }})
                                </option>
                            @endforeach
                        </select>
                        @if ($errors->has('categoria_id'))
                            <p id="categoria_id-error" class="form-error" role="alert">{{ $errors->first('categoria_id') }}</p>
                        @else
                            <p id="categoria_id-hint" class="form-hint">Debe coincidir con el tipo seleccionado</p>
                        @endif
                    </div>

                    <!-- Monto y Fecha -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div>
                            <label for="monto" class="label">Monto <span class="text-expense-500" aria-hidden="true">*</span></label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-neutral-500 dark:text-neutral-400" aria-hidden="true">$</span>
                                <input id="monto"
                                       type="number"
                                       name="monto"
                                       value="{{ old('monto', $transaccion->monto) }}"
                                       required
                                       step="0.01"
                                       min="0.01"
                                       class="input pl-8 {{ $errors->has('monto') ? 'input-error' : '' }}"
                                       aria-describedby="{{ $errors->has('monto') ? 'monto-error' : 'monto-hint' }}"
                                       aria-invalid="{{ $errors->has('monto') ? 'true' : 'false' }}"
                                       placeholder="0.00">
                            </div>
                            @if ($errors->has('monto'))
                                <p id="monto-error" class="form-error" role="alert">{{ $errors->first('monto') }}</p>
                            @else
                                <p id="monto-hint" class="form-hint">Debe ser mayor que cero</p>
                            @endif
                        </div>

                        <div>
                            <label for="fecha" class="label">Fecha <span class="text-expense-500" aria-hidden="true">*</span></label>
                            <input id="fecha"
                                   type="date"
                                   name="fecha"
                                   value="{{ old('fecha', $transaccion->fecha->toDateString()) }}"
                                   required
                                   max="{{ now()->toDateString() }}"
                                   class="input {{ $errors->has('fecha') ? 'input-error' : '' }}"
                                   aria-describedby="{{ $errors->has('fecha') ? 'fecha-error' : 'fecha-hint' }}"
                                   aria-invalid="{{ $errors->has('fecha') ? 'true' : 'false' }}">
                            @if ($errors->has('fecha'))
                                <p id="fecha-error" class="form-error" role="alert">{{ $errors->first('fecha') }}</p>
                            @else
                                <p id="fecha-hint" class="form-hint">No puede ser una fecha futura</p>
                            @endif
                        </div>
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
                                  placeholder="Detalles del movimiento...">{{ old('descripcion', $transaccion->descripcion) }}</textarea>
                        @if ($errors->has('descripcion'))
                            <p id="descripcion-error" class="form-error" role="alert">{{ $errors->first('descripcion') }}</p>
                        @else
                            <p id="descripcion-hint" class="form-hint">Máximo 255 caracteres</p>
                        @endif
                    </div>

                    <!-- Actions -->
                    <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-neutral-200 dark:border-neutral-700">
                        <a href="{{ route('transacciones.index') }}" class="btn-secondary btn-md flex-1 sm:flex-none">
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

    <script>
        // Datos de categorías para filtrado dinámico
        const categoriasData = @json($categorias->map(fn($c) => ['id' => $c->id, 'nombre' => $c->nombre, 'tipo' => $c->tipo]));

        function filtrarCategorias(tipoSeleccionado) {
            const select = document.getElementById('categoria_id');
            const currentValue = select.value;

            // Limpiar opciones excepto la primera
            while (select.options.length > 1) {
                select.remove(1);
            }

            // Añadir opciones filtradas
            categoriasData.filter(c => c.tipo === tipoSeleccionado).forEach(categoria => {
                const option = document.createElement('option');
                option.value = categoria.id;
                option.textContent = `${categoria.nombre} (${categoria.tipo})`;
                option.dataset.tipo = categoria.tipo;
                if (categoria.id == currentValue) {
                    option.selected = true;
                }
                select.appendChild(option);
            });

            // Si el valor actual no coincide con el tipo, resetear
            if (currentValue) {
                const selectedOption = select.querySelector(`option[value="${currentValue}"]`);
                if (!selectedOption || selectedOption.dataset.tipo !== tipoSeleccionado) {
                    select.value = '';
                }
            }
        }

        // Inicializar al cargar
        document.addEventListener('DOMContentLoaded', () => {
            const tipoSeleccionado = document.querySelector('input[name="tipo"]:checked');
            if (tipoSeleccionado) {
                filtrarCategorias(tipoSeleccionado.value);
            }
        });
    </script>
</x-app-layout>