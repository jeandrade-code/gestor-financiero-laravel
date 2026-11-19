@php
    $tieneMovimientos = $cuenta->exists && $cuenta->tieneTransacciones();
@endphp

<div>
    <x-input-label for="nombre" value="Nombre" />
    <x-text-input id="nombre" name="nombre" type="text" class="mt-1 block w-full"
                  :value="old('nombre', $cuenta->nombre)" required autofocus />
    <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
</div>

<div>
    <x-input-label for="descripcion" value="Descripción (opcional)" />
    <textarea id="descripcion" name="descripcion" rows="3"
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('descripcion', $cuenta->descripcion) }}</textarea>
    <x-input-error :messages="$errors->get('descripcion')" class="mt-2" />
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
    <div>
        <x-input-label for="saldo" value="Saldo" />
        <x-text-input id="saldo" name="saldo" type="number" step="0.01" min="0" class="mt-1 block w-full"
                      :value="old('saldo', $cuenta->saldo ?? '0.00')" :readonly="$tieneMovimientos" required />
        @if ($tieneMovimientos)
            <p class="mt-1 text-xs text-gray-500">El saldo se actualiza con las transacciones registradas.</p>
        @endif
        <x-input-error :messages="$errors->get('saldo')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="moneda" value="Moneda" />
        <x-text-input id="moneda" name="moneda" type="text" maxlength="10" class="mt-1 block w-full"
                      :value="old('moneda', $cuenta->moneda ?? 'COP')" required />
        <x-input-error :messages="$errors->get('moneda')" class="mt-2" />
    </div>
</div>