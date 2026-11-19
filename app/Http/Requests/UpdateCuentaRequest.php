<?php

namespace App\Http\Requests;

use App\Models\Cuenta;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class UpdateCuentaRequest extends FormRequest
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
            'descripcion' => ['nullable', 'string', 'max:255'],
            'saldo' => ['required', 'numeric', 'min:0', 'max:9999999999999999.99'],
            'moneda' => ['required', 'string', 'max:10'],
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
                $cuenta = $this->route('cuenta');

                if (! $cuenta instanceof Cuenta) {
                    return;
                }

                if ($validator->errors()->has('saldo')) {
                    return;
                }

                if (! $cuenta->tieneTransacciones()) {
                    return;
                }

                $saldoNuevo = round((float) $this->input('saldo'), 2);

                if (abs($saldoNuevo - (float) $cuenta->saldo) > 0.001) {
                    $validator->errors()->add(
                        'saldo',
                        'El saldo de una cuenta con movimientos se actualiza automáticamente y no puede editarse manualmente.'
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
            'nombre.required' => 'El nombre de la cuenta es obligatorio.',
            'nombre.max' => 'El nombre no puede superar los 150 caracteres.',
            'saldo.required' => 'El saldo es obligatorio.',
            'saldo.numeric' => 'El saldo debe ser un valor numérico.',
            'saldo.min' => 'El saldo no puede ser negativo.',
            'moneda.required' => 'La moneda es obligatoria.',
            'moneda.max' => 'La moneda no puede superar los 10 caracteres.',
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
            'saldo' => 'saldo',
            'moneda' => 'moneda',
            'descripcion' => 'descripción',
        ];
    }
}
