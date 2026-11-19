<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCuentaRequest;
use App\Http\Requests\UpdateCuentaRequest;
use App\Models\Cuenta;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CuentaController extends Controller
{
    /**
     * Listado de cuentas con su saldo actual.
     */
    public function index(Request $request): View
    {
        $cuentas = Cuenta::query()
            ->withCount('transacciones')
            ->when($request->filled('search'), function ($query) use ($request): void {
                $term = '%'.$request->string('search')->trim().'%';

                $query->where(fn ($query) => $query
                    ->where('nombre', 'like', $term)
                    ->orWhere('descripcion', 'like', $term));
            })
            ->orderBy('nombre')
            ->paginate(9)
            ->withQueryString();

        return view('cuentas.index', [
            'cuentas' => $cuentas,
            'saldoTotal' => (float) Cuenta::query()->sum('saldo'),
            'totalCuentas' => Cuenta::query()->count(),
        ]);
    }

    /**
     * Formulario de creación.
     */
    public function create(): View
    {
        return view('cuentas.create', [
            'cuenta' => new Cuenta(['moneda' => 'COP', 'saldo' => 0]),
        ]);
    }

    /**
     * Guarda una cuenta nueva.
     */
    public function store(StoreCuentaRequest $request): RedirectResponse
    {
        Cuenta::query()->create($request->validated());

        return redirect()
            ->route('cuentas.index')
            ->with('estado', 'Cuenta creada correctamente.');
    }

    /**
     * Formulario de edición.
     */
    public function edit(Cuenta $cuenta): View
    {
        return view('cuentas.edit', compact('cuenta'));
    }

    /**
     * Actualiza la cuenta.
     */
    public function update(UpdateCuentaRequest $request, Cuenta $cuenta): RedirectResponse
    {
        $cuenta->update($request->validated());

        return redirect()
            ->route('cuentas.index')
            ->with('estado', 'Cuenta actualizada correctamente.');
    }

    /**
     * Elimina la cuenta si no tiene movimientos asociados.
     */
    public function destroy(Cuenta $cuenta): RedirectResponse
    {
        if ($cuenta->tieneTransacciones()) {
            return redirect()
                ->route('cuentas.index')
                ->with('error', 'No se puede eliminar la cuenta porque tiene movimientos asociados.');
        }

        $cuenta->delete();

        return redirect()
            ->route('cuentas.index')
            ->with('estado', 'Cuenta eliminada correctamente.');
    }
}
