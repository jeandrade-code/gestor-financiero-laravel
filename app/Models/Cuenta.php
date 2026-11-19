<?php

namespace App\Models;

use Database\Factories\CuentaFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cuenta extends Model
{
    /** @use HasFactory<CuentaFactory> */
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cuentas';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nombre',
        'descripcion',
        'saldo',
        'moneda',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'saldo' => 'decimal:2',
        ];
    }

    /**
     * Movimientos registrados sobre esta cuenta.
     *
     * @return HasMany<Transaccion, $this>
     */
    public function transacciones(): HasMany
    {
        return $this->hasMany(Transaccion::class, 'cuenta_id');
    }

    /**
     * Determina si la cuenta tiene movimientos asociados.
     */
    public function tieneTransacciones(): bool
    {
        return $this->transacciones()->exists();
    }

    /**
     * Saldo actual formateado con la moneda de la cuenta.
     */
    public function saldoFormateado(): string
    {
        return number_format((float) $this->saldo, 2, ',', '.').' '.$this->moneda;
    }
}
