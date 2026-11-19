<?php

namespace App\Models;

use Database\Factories\CategoriaFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categoria extends Model
{
    /** @use HasFactory<CategoriaFactory> */
    use HasFactory;

    public const TIPO_INGRESO = 'ingreso';

    public const TIPO_GASTO = 'gasto';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'categorias';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nombre',
        'tipo',
        'descripcion',
    ];

    /**
     * Transacciones registradas con esta categoría.
     *
     * @return HasMany<Transaccion, $this>
     */
    public function transacciones(): HasMany
    {
        return $this->hasMany(Transaccion::class, 'categoria_id');
    }

    /**
     * Determina si la categoría tiene movimientos asociados.
     */
    public function tieneTransacciones(): bool
    {
        return $this->transacciones()->exists();
    }

    /**
     * Tipos de categoría disponibles para los formularios.
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
}
