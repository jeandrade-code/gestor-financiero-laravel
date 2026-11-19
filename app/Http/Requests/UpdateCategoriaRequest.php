<?php

namespace App\Http\Requests;

use App\Models\Categoria;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class UpdateCategoriaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:150'],
            'tipo' => ['required', Rule::in(array_keys(Categoria::tipos()))],
            'descripcion' => ['nullable', 'string', 'max:255'],
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @return array<int, callable>
     */
    public function after(): array
    {
        return [
            function (Validator $validator): void {
                $categoria = $this->route('categoria');

                if (! $categoria instanceof Categoria) {
                    return;
                }

                if ($validator->errors()->has('tipo')) {
                    return;
                }

                $tipoNuevo = (string) $this->input('tipo');

                if ($tipoNuevo === $categoria->tipo) {
                    return;
                }

                if ($categoria->tieneTransacciones()) {
                    $validator->errors()->add(
                        'tipo',
                        'No puede cambiar el tipo de una categoría que ya tiene transacciones asociadas.'
                    );
                }
            },
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre de la categoría es obligatorio.',
            'nombre.max' => 'El nombre no puede superar los 150 caracteres.',
            'tipo.required' => 'Debe seleccionar el tipo de categoría.',
            'tipo.in' => 'El tipo debe ser ingreso o gasto.',
            'descripcion.max' => 'La descripción no puede superar los 255 caracteres.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'nombre' => 'nombre',
            'tipo' => 'tipo',
            'descripcion' => 'descripción',
        ];
    }
}