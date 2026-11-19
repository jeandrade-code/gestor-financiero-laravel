<?php

namespace Tests\Feature;

use App\Models\Categoria;
use App\Models\Cuenta;
use App\Models\Transaccion;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VistasTest extends TestCase
{
    use RefreshDatabase;

    public function test_las_vistas_de_los_tres_modulos_renderizan(): void
    {
        $usuario = User::factory()->create();
        $cuenta = Cuenta::factory()->create();
        $categoria = Categoria::factory()->ingreso()->create();

        $transaccion = Transaccion::factory()->create([
            'cuenta_id' => $cuenta->getKey(),
            'categoria_id' => $categoria->getKey(),
            'tipo' => Transaccion::TIPO_INGRESO,
        ]);

        $rutas = [
            route('dashboard'),
            route('categorias.index'),
            route('categorias.create'),
            route('categorias.edit', $categoria),
            route('cuentas.index'),
            route('cuentas.create'),
            route('cuentas.edit', $cuenta),
            route('transacciones.index'),
            route('transacciones.create'),
            route('transacciones.edit', $transaccion),
        ];

        foreach ($rutas as $ruta) {
            $this->actingAs($usuario)->get($ruta)->assertOk();
        }
    }

    public function test_el_formulario_de_transaccion_conserva_los_datos_tras_un_error(): void
    {
        $usuario = User::factory()->create();
        $cuenta = Cuenta::factory()->create(['saldo' => 1000]);
        $categoria = Categoria::factory()->ingreso()->create();

        $respuesta = $this->actingAs($usuario)
            ->from(route('transacciones.create'))
            ->post(route('transacciones.store'), [
                'cuenta_id' => $cuenta->getKey(),
                'categoria_id' => $categoria->getKey(),
                'tipo' => Transaccion::TIPO_INGRESO,
                'monto' => -5,
                'fecha' => '2026-11-19',
                'descripcion' => 'Descripción que debe conservarse',
            ]);

        $respuesta->assertRedirect(route('transacciones.create'));

        $this->actingAs($usuario)
            ->get(route('transacciones.create'))
            ->assertSee('Descripción que debe conservarse');
    }
}
