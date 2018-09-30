<?php

namespace ApiUnicad\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class Entrega extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'               => $this->id,
            'data_entrega'     => $this->data_entrega->format('d/m/Y'),
            'cliente'          => $this->cliente->nome,
            'endereco_origem'  => $this->endereco_origem,
            'endereco_destino' => $this->endereco_destino,
        ];
    }
}
