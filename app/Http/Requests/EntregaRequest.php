<?php

namespace ApiUnicad\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EntregaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nome' => 'required',
            'data_entrega' => 'required|date_format:d/m/Y',
            'endereco_destino.cep' => 'required|exists:enderecos,cep',
            'endereco_destino.numero' => 'required',
            'endereco_origem.cep' => 'required|exists:enderecos,cep',
            'endereco_origem.numero' => 'required'
        ];
    }
}
