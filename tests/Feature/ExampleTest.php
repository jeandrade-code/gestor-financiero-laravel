<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * La raíz muestra la landing page.
     */
    public function test_la_raiz_muestra_la_landing_page(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('Gestor Financiero');
    }

    /**
     * La ruta de login es accesible.
     */
    public function test_la_ruta_login_es_accesible(): void
    {
        $response = $this->get(route('login'));

        $response->assertOk();
        $response->assertSee('Iniciar sesión');
    }
}
