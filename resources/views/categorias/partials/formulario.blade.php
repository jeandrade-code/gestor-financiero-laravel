@php
    $tipoSeleccionado = old('tipo', $categoria->tipo);
@endphp

<div>
    <x-input-label for="nombre" value="Nombre" />
    <x-text-input id="nombre" name="nombre" type="text" class="mt-1 block w-full"
                  :value="old('nombre', $categoria->nombre)" required autofocus />
    <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
</div>

<div>
    <x-input-label for="tipo" value="Tipo" />
    <select id="tipo" name="tipo" required
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        <option value="">Seleccione un tipo</option>
        @foreach ($tipos as $valor => $etiqueta)
            <option value="{{ $valor }}" @selected($tipoSeleccionado === $valor)>{{ $etiqueta }}</option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('tipo')" class="mt-2" />
</div>

<div>
    <x-input-label for="descripcion" value="Descripción (opcional)" />
    <textarea id="descripcion" name="descripcion" rows="3"
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('descripcion', $categoria->descripcion) }}</textarea>
    <x-input-error :messages="$errors->get('descripcion')" class="mt-2" />
</div>