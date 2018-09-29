<?php

use Illuminate\Database\Seeder;

use \ApiUnicad\Model\Cliente;
use \ApiUnicad\Model\Entrega;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Cliente::class, 10)->create()->each(function (Cliente $cliente) {
            $cliente->entregas()->save(factory(Entrega::class)->make());
        });
    }
}
