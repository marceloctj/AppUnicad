<?php

namespace Tests\Feature;

use ApiUnicad\Model\Entrega;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EntregaTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBuscarEntregaExistente()
    {
        $entrega = Entrega::first();
        $response = $this->get("api/entregas/{$entrega->id}");
        $response->assertStatus(200);
    }

    public function testBuscarEntregaNaoExistente()
    {
        $entrega = PHP_INT_MAX;
        $response = $this->get("api/entregas/{$entrega}");
        $response->assertStatus(404);
    }

    public function testCriarNovaEntrega()
    {
        $response = $this->postJson("api/entregas", [
            'cliente' => Str::random(10),
            'data_entrega' => Carbon::now()->addDay(rand(1,5))->format('Y-m-d'),
            'endereco_origem' => 'Rua Guaíra, 13, Duque de Caxias, RJ',
            'endereco_destino' => 'Rua Santa Clara, 141, Copacabana, Rio de Janeiro, RJ'
        ]);

        $response->assertStatus(201);
    }

    public function testCriarNovaEntregaSemCliente()
    {
        $response = $this->postJson("api/entregas", [
            'data_entrega' => Carbon::now()->addDay(rand(1,5))->format('Y-m-d'),
            'endereco_origem' => 'Rua Guaíra, 13, Duque de Caxias, RJ',
            'endereco_destino' => 'Rua Santa Clara, 141, Copacabana, Rio de Janeiro, RJ'
        ]);

        $response->assertStatus(422);
        $response->assertJsonStructure(['errors' => ['cliente']]);
    }

    public function testCriarNovaEntregaSemDataEntrega()
    {
        $response = $this->postJson("api/entregas", [
            'cliente' => Str::random(10),
            'endereco_origem' => 'Rua Guaíra, 13, Duque de Caxias, RJ',
            'endereco_destino' => 'Rua Santa Clara, 141, Copacabana, Rio de Janeiro, RJ'
        ]);

        $response->assertStatus(422);
        $response->assertJsonStructure(['errors' => ['data_entrega']]);
    }

    public function testCriarNovaEntregaComDataEntregaInvalida()
    {
        $response = $this->postJson("api/entregas", [
            'cliente' => Str::random(10),
            'data_entrega' => Carbon::now()->addDay(rand(1,5))->format('Y'),
            'endereco_origem' => 'Rua Guaíra, 13, Duque de Caxias, RJ',
            'endereco_destino' => 'Rua Santa Clara, 141, Copacabana, Rio de Janeiro, RJ'
        ]);

        $response->assertStatus(422);
        $response->assertJsonStructure(['errors' => ['data_entrega']]);
    }

    public function testCriarNovaEntregaSemEnderecoOrigem()
    {
        $response = $this->postJson("api/entregas", [
            'cliente' => Str::random(10),
            'data_entrega' => Carbon::now()->addDay(rand(1,5))->format('Y-m-d'),
            'endereco_destino' => 'Rua Santa Clara, 141, Copacabana, Rio de Janeiro, RJ'
        ]);

        $response->assertStatus(422);
        $response->assertJsonStructure(['errors' => ['endereco_origem']]);
    }

    public function testCriarNovaEntregaSemEnderecoDestino()
    {
        $response = $this->postJson("api/entregas", [
            'cliente' => Str::random(10),
            'data_entrega' => Carbon::now()->addDay(rand(1,5))->format('Y-m-d'),
            'endereco_origem' => 'Rua Guaíra, 13, Duque de Caxias, RJ',
        ]);

        $response->assertStatus(422);
        $response->assertJsonStructure(['errors' => ['endereco_destino']]);
    }
}
