<?php

namespace Tests\Feature;

use App\Models\Categoria;
use App\Models\Cuenta;
use App\Models\Transaccion;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransaccionCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_registra_una_transaccion_y_actualiza_el_saldo(): void
    {
        $usuario = User::factory()->create(['name' => 'Ana Pérez']);
        $cuenta = Cuenta::factory()->create(['saldo' => 200000]);
        $categoria = Categoria::factory()->ingreso()->create();

        $respuesta = $this->actingAs($usuario)->post(route('transacciones.store'), [
            'cuenta_id' => $cuenta->getKey(),
            'categoria_id' => $categoria->getKey(),
            'tipo' => Transaccion::TIPO_INGRESO,
            'monto' => 150000,
            'fecha' => now()->toDateString(),
            'descripcion' => 'Ingreso de prueba',
        ]);

        $respuesta->assertRedirect(route('transacciones.index'));
        $respuesta->assertSessionHas('estado');
        $this->assertSame('350000.00', $cuenta->refresh()->saldo);
        $this->assertDatabaseHas('transacciones', [
            'cuenta_id' => $cuenta->getKey(),
            'creado_por' => 'Ana Pérez',
        ]);
    }

    public function test_rechaza_una_categoria_que_no_coincide_con_el_tipo(): void
    {
        $usuario = User::factory()->create();
        $cuenta = Cuenta::factory()->create(['saldo' => 500000]);
        $categoriaGasto = Categoria::factory()->gasto()->create();

        $respuesta = $this->actingAs($usuario)->post(route('transacciones.store'), [
            'cuenta_id' => $cuenta->getKey(),
            'categoria_id' => $categoriaGasto->getKey(),
            'tipo' => Transaccion::TIPO_INGRESO,
            'monto' => 10000,
            'fecha' => now()->toDateString(),
        ]);

        $respuesta->assertSessionHasErrors('categoria_id');
        $this->assertSame('500000.00', $cuenta->refresh()->saldo);
    }

    public function test_muestra_los_nombres_de_cuenta_y_categoria_en_el_listado(): void
    {
        $usuario = User::factory()->create();
        $cuenta = Cuenta::factory()->create(['nombre' => 'Caja Principal', 'saldo' => 100000]);
        $categoria = Categoria::factory()->ingreso()->create(['nombre' => 'Salario Mensual']);

        Transaccion::factory()->create([
            'cuenta_id' => $cuenta->getKey(),
            'categoria_id' => $categoria->getKey(),
            'tipo' => Transaccion::TIPO_INGRESO,
            'monto' => 10000,
            'descripcion' => 'Movimiento visible',
        ]);

        $respuesta = $this->actingAs($usuario)->get(route('transacciones.index'));

        $respuesta->assertOk();
        $respuesta->assertSee('Caja Principal');
        $respuesta->assertSee('Salario Mensual');
        $respuesta->assertSee('Movimiento visible');
    }

    public function test_no_permite_editar_el_saldo_de_una_cuenta_con_movimientos(): void
    {
        $usuario = User::factory()->create();
        $cuenta = Cuenta::factory()->create(['saldo' => 100000]);
        $categoria = Categoria::factory()->ingreso()->create();

        Transaccion::factory()->create([
            'cuenta_id' => $cuenta->getKey(),
            'categoria_id' => $categoria->getKey(),
            'tipo' => Transaccion::TIPO_INGRESO,
        ]);

        $respuesta = $this->actingAs($usuario)->put(route('cuentas.update', $cuenta), [
            'nombre' => $cuenta->nombre,
            'descripcion' => $cuenta->descripcion,
            'saldo' => 999999,
            'moneda' => $cuenta->moneda,
        ]);

        $respuesta->assertSessionHasErrors('saldo');
        $this->assertSame('100000.00', $cuenta->refresh()->saldo);
    }

    public function test_no_permite_cambiar_el_tipo_de_una_categoria_con_movimientos(): void
    {
        $usuario = User::factory()->create();
        $cuenta = Cuenta::factory()->create();
        $categoria = Categoria::factory()->ingreso()->create(['nombre' => 'Ingreso Fijo']);

        Transaccion::factory()->create([
            'cuenta_id' => $cuenta->getKey(),
            'categoria_id' => $categoria->getKey(),
            'tipo' => Transaccion::TIPO_INGRESO,
        ]);

        $respuesta = $this->actingAs($usuario)->put(route('categorias.update', $categoria), [
            'nombre' => 'Ingreso Fijo',
            'tipo' => Categoria::TIPO_GASTO,
            'descripcion' => null,
        ]);

        $respuesta->assertSessionHasErrors('tipo');
        $this->assertSame(Categoria::TIPO_INGRESO, $categoria->refresh()->tipo);
    }
}