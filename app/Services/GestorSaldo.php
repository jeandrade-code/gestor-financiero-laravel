<?php

namespace App\Services;

use App\Models\Cuenta;
use App\Models\Transaccion;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class GestorSaldo
{
    /**
     * Registra un movimiento y aplica su efecto sobre el saldo de la cuenta.
     *
     * @param  array{cuenta_id: int|string, categoria_id: int|string, tipo: string, monto: float|string, fecha: string, descripcion?: string|null, creado_por?: string|null}  $datos
     *
     * @throws ValidationException
     */
    public function registrar(array $datos): Transaccion
    {
        return DB::transaction(function () use ($datos): Transaccion {
            /** @var Cuenta $cuenta */
            $cuenta = Cuenta::query()->lockForUpdate()->findOrFail($datos['cuenta_id']);

            $tipo = (string) $datos['tipo'];
            $monto = round((float) $datos['monto'], 2);

            $this->garantizarMontoPositivo($monto);
            $this->garantizarSaldoSuficiente($cuenta, $tipo, $monto);

            $transaccion = Transaccion::query()->create([
                'cuenta_id' => $cuenta->getKey(),
                'categoria_id' => $datos['categoria_id'],
                'tipo' => $tipo,
                'monto' => $monto,
                'fecha' => $datos['fecha'],
                'descripcion' => $datos['descripcion'] ?? null,
                'creado_por' => $datos['creado_por'] ?? null,
            ]);

            $this->ajustarSaldo($cuenta, $tipo, $monto);

            return $transaccion;
        });
    }

    /**
     * Actualiza un movimiento revirtiendo su efecto anterior y aplicando el nuevo.
     *
     * @param  array{cuenta_id: int|string, categoria_id: int|string, tipo: string, monto: float|string, fecha: string, descripcion?: string|null, creado_por?: string|null}  $datos
     *
     * @throws ValidationException
     */
    public function actualizar(Transaccion $transaccion, array $datos): Transaccion
    {
        return DB::transaction(function () use ($transaccion, $datos): Transaccion {
            /** @var Cuenta|null $cuentaAnterior */
            $cuentaAnterior = Cuenta::query()->lockForUpdate()->find($transaccion->cuenta_id);

            $cuentaAnterior?->decrement('saldo', $transaccion->efectoEnSaldo());

            /** @var Cuenta $cuentaNueva */
            $cuentaNueva = Cuenta::query()->lockForUpdate()
                ->findOrFail($datos['cuenta_id'])
                ->refresh();

            $tipo = (string) $datos['tipo'];
            $monto = round((float) $datos['monto'], 2);

            $this->garantizarMontoPositivo($monto);
            $this->garantizarSaldoSuficiente($cuentaNueva, $tipo, $monto);

            $transaccion->update([
                'cuenta_id' => $cuentaNueva->getKey(),
                'categoria_id' => $datos['categoria_id'],
                'tipo' => $tipo,
                'monto' => $monto,
                'fecha' => $datos['fecha'],
                'descripcion' => $datos['descripcion'] ?? null,
                'creado_por' => $datos['creado_por'] ?? $transaccion->creado_por,
            ]);

            $this->ajustarSaldo($cuentaNueva, $tipo, $monto);

            return $transaccion->refresh();
        });
    }

    /**
     * Elimina un movimiento revirtiendo su efecto sobre el saldo.
     *
     * @throws ValidationException
     */
    public function eliminar(Transaccion $transaccion): void
    {
        DB::transaction(function () use ($transaccion): void {
            /** @var Cuenta|null $cuenta */
            $cuenta = Cuenta::query()->lockForUpdate()->find($transaccion->cuenta_id);

            $cuenta?->decrement('saldo', $transaccion->efectoEnSaldo());
            $transaccion->delete();
        });
    }

    /**
     * Aplica el efecto del movimiento sobre el saldo de la cuenta.
     */
    private function ajustarSaldo(Cuenta $cuenta, string $tipo, float $monto): void
    {
        $cuenta->decrement('saldo', $tipo === Transaccion::TIPO_INGRESO ? -1 * $monto : $monto);
    }

    /**
     * Rechaza montos iguales o inferiores a cero.
     *
     * @throws ValidationException
     */
    private function garantizarMontoPositivo(float $monto): void
    {
        if ($monto <= 0) {
            throw ValidationException::withMessages([
                'monto' => __('El monto debe ser mayor que cero.'),
            ]);
        }
    }

    /**
     * Rechaza gastos que superen el saldo disponible de la cuenta.
     *
     * @throws ValidationException
     */
    private function garantizarSaldoSuficiente(Cuenta $cuenta, string $tipo, float $monto): void
    {
        if ($tipo !== Transaccion::TIPO_GASTO) {
            return;
        }

        if ($monto > (float) $cuenta->saldo) {
            throw ValidationException::withMessages([
                'monto' => __('El gasto supera el saldo disponible de la cuenta (:saldo).', [
                    'saldo' => $cuenta->saldoFormateado(),
                ]),
            ]);
        }
    }
}