<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoriaRequest;
use App\Http\Requests\UpdateCategoriaRequest;
use App\Models\Categoria;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoriaController extends Controller
{
    /**
     * Listado de categorías.
     */
    public function index(): View
    {
        $categorias = Categoria::query()
            ->withCount('transacciones')
            ->orderBy('tipo')
            ->orderBy('nombre')
            ->paginate(10);

        return view('categorias.index', compact('categorias'));
    }

    /**
     * Formulario de creación.
     */
    public function create(): View
    {
        return view('categorias.create', [
            'categoria' => new Categoria,
            'tipos' => Categoria::tipos(),
        ]);
    }

    /**
     * Guarda una categoría nueva.
     */
    public function store(StoreCategoriaRequest $request): RedirectResponse
    {
        Categoria::query()->create($request->validated());

        return redirect()
            ->route('categorias.index')
            ->with('estado', 'Categoría creada correctamente.');
    }

    /**
     * Formulario de edición.
     */
    public function edit(Categoria $categoria): View
    {
        return view('categorias.edit', [
            'categoria' => $categoria,
            'tipos' => Categoria::tipos(),
        ]);
    }

    /**
     * Actualiza la categoría.
     */
    public function update(UpdateCategoriaRequest $request, Categoria $categoria): RedirectResponse
    {
        $categoria->update($request->validated());

        return redirect()
            ->route('categorias.index')
            ->with('estado', 'Categoría actualizada correctamente.');
    }

    /**
     * Elimina la categoría si no tiene movimientos asociados.
     */
    public function destroy(Categoria $categoria): RedirectResponse
    {
        if ($categoria->tieneTransacciones()) {
            return redirect()
                ->route('categorias.index')
                ->with('error', 'No se puede eliminar la categoría porque tiene transacciones asociadas.');
        }

        $categoria->delete();

        return redirect()
            ->route('categorias.index')
            ->with('estado', 'Categoría eliminada correctamente.');
    }
}