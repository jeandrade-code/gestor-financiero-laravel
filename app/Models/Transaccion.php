<?php

namespace App\Models;

use Database\Factories\TransaccionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaccion extends Model
{
    /** @use HasFactory<TransaccionFactory> */
    use HasFactory;

    public const TIPO_INGRESO = 'ingreso';

    public const TIPO_GASTO = 'gasto';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'transacciones';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'cuenta_id',
        'categoria_id',
        'tipo',
        'monto',
        'fecha',
        'descripcion',
        'creado_por',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'monto' => 'decimal:2',
            'fecha' => 'date',
        ];
    }

    /**
     * Cuenta a la que pertenece el movimiento.
     *
     * @return BelongsTo<Cuenta, $this>
     */
    public function cuenta(): BelongsTo
    {
        return $this->belongsTo(Cuenta::class, 'cuenta_id');
    }

    /**
     * Categoría del movimiento.
     *
     * @return BelongsTo<Categoria, $this>
     */
    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    /**
     * Tipos de movimiento disponibles para los formularios.
     *
     * @return array<string, string>
     */
    public static function tipos(): array
    {
        return [
            self::TIPO_INGRESO => 'Ingreso',
            self::TIPO_GASTO => 'Gasto',
        ];
    }

    /**
     * Indica si el movimiento representa una entrada de dinero.
     */
    public function esIngreso(): bool
    {
        return $this->tipo === self::TIPO_INGRESO;
    }

    /**
     * Indica si el movimiento representa una salida de dinero.
     */
    public function esGasto(): bool
    {
        return $this->tipo === self::TIPO_GASTO;
    }

    /**
     * Efecto del movimiento sobre el saldo de la cuenta: positivo si es ingreso.
     */
    public function efectoEnSaldo(): float
    {
        return $this->esIngreso() ? (float) $this->monto : -1 * (float) $this->monto;
    }

    /**
     * Monto formateado con la moneda de la cuenta asociada.
     */
    public function montoFormateado(): string
    {
        return number_format((float) $this->monto, 2, ',', '.').' '.$this->cuenta->moneda;
    }
}