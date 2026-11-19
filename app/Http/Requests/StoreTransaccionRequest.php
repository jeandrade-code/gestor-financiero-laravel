<?php

namespace App\Http\Requests;

use App\Http\Requests\Concerns\ValidaTransaccion;
use Illuminate\Foundation\Http\FormRequest;

class StoreTransaccionRequest extends FormRequest
{
    use ValidaTransaccion;

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
        return $this->reglasTransaccion();
    }

    /**
     * Configure the validator instance.
     *
     * @return array<int, callable>
     */
    public function after(): array
    {
        return $this->validacionCategoriaCoherente();
    }

    /**
     * Datos listos para persistir.
     *
     * @return array<string, mixed>
     */
    public function datosTransaccion(): array
    {
        return [
            'cuenta_id' => $this->integer('cuenta_id'),
            'categoria_id' => $this->integer('categoria_id'),
            'tipo' => (string) $this->input('tipo'),
            'monto' => (float) $this->input('monto'),
            'fecha' => (string) $this->input('fecha'),
            'descripcion' => $this->input('descripcion'),
            'creado_por' => $this->user()?->name,
        ];
    }
}
