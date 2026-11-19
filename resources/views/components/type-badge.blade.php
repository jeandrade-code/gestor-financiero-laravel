@props(['tipo' => null])

@if ($tipo === 'ingreso')
    <span class="badge-success">
        <span class="badge-dot"></span>
        Ingreso
    </span>
@elseif ($tipo === 'gasto')
    <span class="badge-destructive">
        <span class="badge-dot"></span>
        Gasto
    </span>
@else
    <span class="badge-neutral">Sin tipo</span>
@endif