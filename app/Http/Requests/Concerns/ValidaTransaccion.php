<?php

namespace App\Http\Requests\Concerns;

use App\Models\Categoria;
use App\Models\Transaccion;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

trait ValidaTransaccion
{
    /**
     * Reglas base compartidas por el alta y la edición de movimientos.
     *
     * @return array<string, mixed>
     */
    protected function reglasTransaccion(): array
    {
        return [
            'cuenta_id' => ['required', 'integer', Rule::exists('cuentas', 'id')],
            'categoria_id' => ['required', 'integer', Rule::exists('categorias', 'id')],
            'tipo' => ['required', Rule::in([Transaccion::TIPO_INGRESO, Transaccion::TIPO_GASTO])],
            'monto' => ['required', 'numeric', 'gt:0', 'max:9999999999999999.99'],
            'fecha' => ['required', 'date'],
            'descripcion' => ['nullable', 'string', 'max:255'],
        ];
    }

    /**
     * Valida que la categoría elegida corresponda al tipo de movimiento.
     *
     * @return array<int, callable>
     */
    protected function validacionCategoriaCoherente(): array
    {
        return [
            function (Validator $validator): void {
                if ($validator->errors()->hasAny(['categoria_id', 'tipo'])) {
                    return;
                }

                $categoria = Categoria::query()->find($this->input('categoria_id'));

                if ($categoria === null) {
                    return;
                }

                if ($categoria->tipo !== (string) $this->input('tipo')) {
                    $validator->errors()->add(
                        'categoria_id',
                        $categoria->tipo === Categoria::TIPO_INGRESO
                            ? 'Una categoría de ingreso solo puede asociarse a transacciones de tipo ingreso.'
                            : 'Una categoría de gasto solo puede asociarse a transacciones de tipo gasto.'
                    );
                }
            },
        ];
    }

    /**
     * Mensajes personalizados en español.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'cuenta_id.required' => 'Debe seleccionar una cuenta.',
            'cuenta_id.exists' => 'La cuenta seleccionada no existe.',
            'categoria_id.required' => 'Debe seleccionar una categoría.',
            'categoria_id.exists' => 'La categoría seleccionada no existe.',
            'tipo.required' => 'Debe seleccionar el tipo de movimiento.',
            'tipo.in' => 'El tipo debe ser ingreso o gasto.',
            'monto.required' => 'El monto es obligatorio.',
            'monto.numeric' => 'El monto debe ser un valor numérico.',
            'monto.gt' => 'El monto debe ser mayor que cero.',
            'fecha.required' => 'La fecha es obligatoria.',
            'fecha.date' => 'La fecha no tiene un formato válido.',
            'descripcion.max' => 'La descripción no puede superar los 255 caracteres.',
        ];
    }

    /**
     * Atributos legibles para los mensajes de error.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'cuenta_id' => 'cuenta',
            'categoria_id' => 'categoría',
            'tipo' => 'tipo',
            'monto' => 'monto',
            'fecha' => 'fecha',
            'descripcion' => 'descripción',
        ];
    }
}
