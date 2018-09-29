<?php

namespace ApiUnicad\Model;

use Illuminate\Database\Eloquent\Model;

class Entrega extends Model
{
    protected $fillable = [
        'data_entrega', 'endereco_origem_numero', 'endereco_origem_complemento', 'endereco_destino_numero',
        'endereco_destino_complemento'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function enderecoOrigem()
    {
        return $this->belongsTo(Endereco::class, 'endereco_origem_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function enderecoDestino()
    {
        return $this->belongsTo(Endereco::class, 'endereco_destino_id');
    }
}
