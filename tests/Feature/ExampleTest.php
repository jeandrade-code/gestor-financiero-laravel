<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * La raíz redirige al inicio de sesión.
     */
    public function test_la_raiz_redirige_al_inicio_de_sesion(): void
    {
        $response = $this->get('/');

        $response->assertRedirect(route('login'));
    }
}