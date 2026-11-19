<?php

namespace Tests\Feature;

use App\Models\Categoria;
use App\Models\Cuenta;
use App\Models\Transaccion;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EliminacionProtegidaTest extends TestCase
{
    use RefreshDatabase;

    public function test_no_permite_eliminar_una_cuenta_con_transacciones(): void
    {
        $usuario = User::factory()->create();
        $cuenta = Cuenta::factory()->create(['saldo' => 100000]);
        $categoria = Categoria::factory()->ingreso()->create();

        Transaccion::factory()->create([
            'cuenta_id' => $cuenta->getKey(),
            'categoria_id' => $categoria->getKey(),
            'tipo' => Transaccion::TIPO_INGRESO,
        ]);

        $respuesta = $this->actingAs($usuario)->delete(route('cuentas.destroy', $cuenta));

        $respuesta->assertRedirect(route('cuentas.index'));
        $respuesta->assertSessionHas('error');
        $this->assertDatabaseHas('cuentas', ['id' => $cuenta->getKey()]);
    }

    public function test_no_permite_eliminar_una_categoria_con_transacciones(): void
    {
        $usuario = User::factory()->create();
        $cuenta = Cuenta::factory()->create();
        $categoria = Categoria::factory()->gasto()->create();

        Transaccion::factory()->create([
            'cuenta_id' => $cuenta->getKey(),
            'categoria_id' => $categoria->getKey(),
            'tipo' => Transaccion::TIPO_GASTO,
        ]);

        $respuesta = $this->actingAs($usuario)->delete(route('categorias.destroy', $categoria));

        $respuesta->assertRedirect(route('categorias.index'));
        $respuesta->assertSessionHas('error');
        $this->assertDatabaseHas('categorias', ['id' => $categoria->getKey()]);
    }

    public function test_permite_eliminar_una_cuenta_sin_movimientos(): void
    {
        $usuario = User::factory()->create();
        $cuenta = Cuenta::factory()->create();

        $respuesta = $this->actingAs($usuario)->delete(route('cuentas.destroy', $cuenta));

        $respuesta->assertRedirect(route('cuentas.index'));
        $respuesta->assertSessionHas('estado');
        $this->assertDatabaseMissing('cuentas', ['id' => $cuenta->getKey()]);
    }

    public function test_permite_eliminar_una_categoria_sin_movimientos(): void
    {
        $usuario = User::factory()->create();
        $categoria = Categoria::factory()->create();

        $respuesta = $this->actingAs($usuario)->delete(route('categorias.destroy', $categoria));

        $respuesta->assertRedirect(route('categorias.index'));
        $respuesta->assertSessionHas('estado');
        $this->assertDatabaseMissing('categorias', ['id' => $categoria->getKey()]);
    }

    public function test_los_modulos_requieren_autenticacion(): void
    {
        $this->get(route('categorias.index'))->assertRedirect(route('login'));
        $this->get(route('cuentas.index'))->assertRedirect(route('login'));
        $this->get(route('transacciones.index'))->assertRedirect(route('login'));
    }
}