<?php

use Faker\Generator as Faker;

$enderecos = [
    [
        'descricao' => 'Rua Almirante Grenfell, 405, Duque de Caxias, RJ',
        'lat' => '-22.788893',
        'lng' => '-43.284327'
    ],
    [
        'descricao' => 'Rodovia Washington Luiz, 5458, Vila São Luís, Duque de Caxias, RJ',
        'lat' => '-22.788893',
        'lng' => '-43.284327'
    ],
    [
        'descricao' => 'Rua Passo da Pátria, 105, Jardim Vinte e Cinco de Agosto, Duque de Caxias, RJ',
        'lat' => '-22.788893',
        'lng' => '-43.284327'
    ],
    [
        'descricao' => 'Rua 7 de Setembro, 92, Centro, Rio de Janeiro, RJ',
        'lat' => '-22.788893',
        'lng' => '-43.284327'
    ],
    [
        'descricao' => 'Rua Bulhões de Carvalho, 61, Copacabana, Rio de Janeiro, RJ ',
        'lat' => '-22.788893',
        'lng' => '-43.284327'
    ],
    [
        'descricao' => 'Rua Bambina, 65, Botafogo, Rio de Janeiro, RJ',
        'lat' => '-22.788893',
        'lng' => '-43.284327'
    ],
    [
        'descricao' => 'Rua dos Inválidos, 176, Centro, Rio de Janeiro, RJ',
        'lat' => '-22.788893',
        'lng' => '-43.284327'
    ],
    [
        'descricao' => 'Rua Santa Clara, 141, Copacabana, Rio de Janeiro, RJ',
        'lat' => '-22.788893',
        'lng' => '-43.284327'
    ],
];

$factory->define(\ApiUnicad\Model\Entrega::class, function (Faker $faker) use ($enderecos) {

    $enderecoOrigem  = $enderecos[rand(0,7)];
    $enderecoDestino  = $enderecos[rand(0,7)];

    return [
        'data_entrega' => $faker->dateTime,
        'endereco_origem' => $enderecoOrigem['descricao'],
        'endereco_destino' => $enderecoDestino['descricao'],
    ];
});
