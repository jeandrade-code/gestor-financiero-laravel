<?php

namespace Tests\Feature;

use App\Models\Categoria;
use App\Models\Cuenta;
use App\Models\Transaccion;
use App\Models\User;
use App\Services\GestorSaldo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class SaldoTest extends TestCase
{
    use RefreshDatabase;

    private GestorSaldo $gestor;

    protected function setUp(): void
    {
        parent::setUp();

        $this->gestor = app(GestorSaldo::class);
    }

    public function test_un_ingreso_aumenta_el_saldo_de_la_cuenta(): void
    {
        $cuenta = Cuenta::factory()->create(['saldo' => 200000]);
        $categoria = Categoria::factory()->ingreso()->create();

        $this->gestor->registrar($this->datos($cuenta, $categoria, Transaccion::TIPO_INGRESO, 150000));

        $this->assertSame('350000.00', $cuenta->refresh()->saldo);
    }

    public function test_un_gasto_disminuye_el_saldo_de_la_cuenta(): void
    {
        $cuenta = Cuenta::factory()->create(['saldo' => 350000]);
        $categoria = Categoria::factory()->gasto()->create();

        $this->gestor->registrar($this->datos($cuenta, $categoria, Transaccion::TIPO_GASTO, 20000));

        $this->assertSame('330000.00', $cuenta->refresh()->saldo);
    }

    public function test_caso_de_validacion_del_taller_deja_el_saldo_en_330000(): void
    {
        $cuenta = Cuenta::factory()->create(['saldo' => 200000]);
        $ingreso = Categoria::factory()->ingreso()->create();
        $gasto = Categoria::factory()->gasto()->create();

        $this->gestor->registrar($this->datos($cuenta, $ingreso, Transaccion::TIPO_INGRESO, 150000));
        $this->gestor->registrar($this->datos($cuenta, $gasto, Transaccion::TIPO_GASTO, 20000));

        $this->assertSame('330000.00', $cuenta->refresh()->saldo);
    }

    public function test_editar_un_movimiento_revierte_el_efecto_anterior_y_aplica_el_nuevo(): void
    {
        $cuenta = Cuenta::factory()->create(['saldo' => 100000]);
        $categoria = Categoria::factory()->ingreso()->create();

        $transaccion = $this->gestor->registrar($this->datos($cuenta, $categoria, Transaccion::TIPO_INGRESO, 50000));

        $this->assertSame('150000.00', $cuenta->refresh()->saldo);

        $this->gestor->actualizar($transaccion, $this->datos($cuenta, $categoria, Transaccion::TIPO_INGRESO, 80000));

        $this->assertSame('180000.00', $cuenta->refresh()->saldo);
    }

    public function test_editar_el_tipo_de_un_movimiento_ajusta_el_saldo_en_sentido_contrario(): void
    {
        $cuenta = Cuenta::factory()->create(['saldo' => 100000]);
        $ingreso = Categoria::factory()->ingreso()->create();
        $gasto = Categoria::factory()->gasto()->create();

        $transaccion = $this->gestor->registrar($this->datos($cuenta, $ingreso, Transaccion::TIPO_INGRESO, 50000));

        $this->assertSame('150000.00', $cuenta->refresh()->saldo);

        $this->gestor->actualizar($transaccion, $this->datos($cuenta, $gasto, Transaccion::TIPO_GASTO, 50000));

        $this->assertSame('50000.00', $cuenta->refresh()->saldo);
    }

    public function test_editar_la_cuenta_de_un_movimiento_traslada_el_efecto(): void
    {
        $origen = Cuenta::factory()->create(['saldo' => 100000]);
        $destino = Cuenta::factory()->create(['saldo' => 100000]);
        $categoria = Categoria::factory()->ingreso()->create();

        $transaccion = $this->gestor->registrar($this->datos($origen, $categoria, Transaccion::TIPO_INGRESO, 40000));

        $this->assertSame('140000.00', $origen->refresh()->saldo);

        $this->gestor->actualizar($transaccion, $this->datos($destino, $categoria, Transaccion::TIPO_INGRESO, 40000));

        $this->assertSame('100000.00', $origen->refresh()->saldo);
        $this->assertSame('140000.00', $destino->refresh()->saldo);
    }

    public function test_eliminar_un_movimiento_revierte_su_efecto_en_el_saldo(): void
    {
        $cuenta = Cuenta::factory()->create(['saldo' => 200000]);
        $categoria = Categoria::factory()->ingreso()->create();

        $transaccion = $this->gestor->registrar($this->datos($cuenta, $categoria, Transaccion::TIPO_INGRESO, 150000));

        $this->assertSame('350000.00', $cuenta->refresh()->saldo);

        $this->gestor->eliminar($transaccion);

        $this->assertSame('200000.00', $cuenta->refresh()->saldo);
        $this->assertDatabaseMissing('transacciones', ['id' => $transaccion->getKey()]);
    }

    public function test_rechaza_montos_menores_o_iguales_a_cero(): void
    {
        $cuenta = Cuenta::factory()->create(['saldo' => 200000]);
        $categoria = Categoria::factory()->ingreso()->create();

        $this->expectException(ValidationException::class);

        $this->gestor->registrar($this->datos($cuenta, $categoria, Transaccion::TIPO_INGRESO, 0));
    }

    public function test_rechaza_un_gasto_que_supera_el_saldo_disponible(): void
    {
        $cuenta = Cuenta::factory()->create(['saldo' => 10000]);
        $categoria = Categoria::factory()->gasto()->create();

        $this->expectException(ValidationException::class);

        $this->gestor->registrar($this->datos($cuenta, $categoria, Transaccion::TIPO_GASTO, 20000));
    }

    /**
     * @return array<string, mixed>
     */
    private function datos(Cuenta $cuenta, Categoria $categoria, string $tipo, float $monto): array
    {
        return [
            'cuenta_id' => $cuenta->getKey(),
            'categoria_id' => $categoria->getKey(),
            'tipo' => $tipo,
            'monto' => $monto,
            'fecha' => now()->toDateString(),
            'descripcion' => 'Movimiento de prueba',
            'creado_por' => User::factory()->make()->name,
        ];
    }
}