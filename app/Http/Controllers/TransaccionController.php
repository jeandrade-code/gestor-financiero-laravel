<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransaccionRequest;
use App\Http\Requests\UpdateTransaccionRequest;
use App\Models\Categoria;
use App\Models\Cuenta;
use App\Models\Transaccion;
use App\Services\GestorSaldo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TransaccionController extends Controller
{
    public function __construct(private readonly GestorSaldo $gestorSaldo) {}

    /**
     * Listado de movimientos con los nombres de cuenta y categoría.
     */
    public function index(Request $request): View
    {
        $transacciones = Transaccion::query()
            ->with(['cuenta', 'categoria'])
            ->when($request->filled('tipo'), fn ($query) => $query->where('tipo', $request->string('tipo')))
            ->when($request->filled('cuenta_id'), fn ($query) => $query->where('cuenta_id', $request->integer('cuenta_id')))
            ->orderByDesc('fecha')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('transacciones.index', [
            'transacciones' => $transacciones,
            'cuentas' => Cuenta::query()->orderBy('nombre')->get(),
            'filtros' => [
                'tipo' => $request->input('tipo'),
                'cuenta_id' => $request->input('cuenta_id'),
            ],
        ]);
    }

    /**
     * Formulario de creación.
     */
    public function create(): View
    {
        return view('transacciones.create', [
            'transaccion' => new Transaccion(['fecha' => now()->toDateString()]),
            'cuentas' => Cuenta::query()->orderBy('nombre')->get(),
            'categorias' => Categoria::query()->orderBy('tipo')->orderBy('nombre')->get(),
            'tipos' => Transaccion::tipos(),
        ]);
    }

    /**
     * Registra un movimiento aplicando su efecto en el saldo.
     */
    public function store(StoreTransaccionRequest $request): RedirectResponse
    {
        $this->gestorSaldo->registrar($request->datosTransaccion());

        return redirect()
            ->route('transacciones.index')
            ->with('estado', 'Transacción registrada correctamente.');
    }

    /**
     * Formulario de edición.
     */
    public function edit(Transaccion $transaccion): View
    {
        return view('transacciones.edit', [
            'transaccion' => $transaccion,
            'cuentas' => Cuenta::query()->orderBy('nombre')->get(),
            'categorias' => Categoria::query()->orderBy('tipo')->orderBy('nombre')->get(),
            'tipos' => Transaccion::tipos(),
        ]);
    }

    /**
     * Actualiza el movimiento revirtiendo y reaplicando el saldo.
     */
    public function update(UpdateTransaccionRequest $request, Transaccion $transaccion): RedirectResponse
    {
        $this->gestorSaldo->actualizar($transaccion, $request->datosTransaccion());

        return redirect()
            ->route('transacciones.index')
            ->with('estado', 'Transacción actualizada correctamente.');
    }

    /**
     * Elimina el movimiento revirtiendo su efecto en el saldo.
     */
    public function destroy(Transaccion $transaccion): RedirectResponse
    {
        $this->gestorSaldo->eliminar($transaccion);

        return redirect()
            ->route('transacciones.index')
            ->with('estado', 'Transacción eliminada correctamente.');
    }
}