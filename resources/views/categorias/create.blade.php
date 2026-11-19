<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-heading-lg text-neutral-900 dark:text-neutral-50">Nueva categoría</h2>
                <p class="text-body text-neutral-600 dark:text-neutral-400 mt-1">Define una nueva forma de clasificar tus movimientos</p>
            </div>
            <a href="{{ route('categorias.index') }}" class="btn-secondary btn-md">
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
                <h3 class="text-heading-md text-neutral-900 dark:text-neutral-50">Información de la categoría</h3>
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('categorias.store') }}" class="space-y-6" novalidate>
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
                               placeholder="Ej: Salario, Supermercado, Transporte...">
                        @if ($errors->has('nombre'))
                            <p id="nombre-error" class="form-error" role="alert">{{ $errors->first('nombre') }}</p>
                        @else
                            <p id="nombre-hint" class="form-hint">Máximo 150 caracteres</p>
                        @endif
                    </div>

                    <!-- Tipo -->
                    <div>
                        <label class="label">Tipo <span class="text-expense-500" aria-hidden="true">*</span></label>
                        <div class="grid grid-cols-2 gap-3">
                            @foreach(['ingreso' => 'Ingreso', 'gasto' => 'Gasto'] as $value => $label)
                                <label class="relative">
                                    <input type="radio"
                                           name="tipo"
                                           value="{{ $value }}"
                                           {{ old('tipo', 'ingreso') === $value ? 'checked' : '' }}
                                           required
                                           class="peer sr-only"
                                           aria-describedby="{{ $errors->has('tipo') ? 'tipo-error' : '' }}">
                                    <div class="peer-checked:border-brand-500 peer-checked:bg-brand-50 dark:peer-checked:bg-brand-900/20 peer-focus:ring-2 peer-focus:ring-brand-500 peer-focus:ring-offset-2 border-2 border-neutral-200 dark:border-neutral-700 rounded-xl p-4 text-center cursor-pointer transition-all duration-200">
                                        <div class="w-10 h-10 mx-auto mb-2 rounded-lg flex items-center justify-center
                                            {{ $value === 'ingreso' ? 'bg-income-100 text-income-600 dark:bg-income-900/30 dark:text-income-400 peer-checked:bg-income-600 peer-checked:text-white'
                                               : 'bg-expense-100 text-expense-600 dark:bg-expense-900/30 dark:text-expense-400 peer-checked:bg-expense-600 peer-checked:text-white' }}">
                                            @if ($value === 'ingreso')
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                                                </svg>
                                            @else
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 10l-7 7m0 0l-7-7m7-7v18"/>
                                                </svg>
                                            @endif
                                        </div>
                                        <span class="text-body font-medium text-neutral-900 dark:text-neutral-50 peer-checked:text-brand-700 dark:peer-checked:text-brand-300">{{ $label }}</span>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                        @if ($errors->has('tipo'))
                            <p id="tipo-error" class="form-error" role="alert">{{ $errors->first('tipo') }}</p>
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
                                  placeholder="Breve descripción de qué incluye esta categoría...">{{ old('descripcion') }}</textarea>
                        @if ($errors->has('descripcion'))
                            <p id="descripcion-error" class="form-error" role="alert">{{ $errors->first('descripcion') }}</p>
                        @else
                            <p id="descripcion-hint" class="form-hint">Máximo 255 caracteres</p>
                        @endif
                    </div>

                    <!-- Actions -->
                    <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-neutral-200 dark:border-neutral-700">
                        <a href="{{ route('categorias.index') }}" class="btn-secondary btn-md flex-1 sm:flex-none">
                            Cancelar
                        </a>
                        <button type="submit" class="btn-primary btn-md flex-1 sm:flex-none">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Crear categoría
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>