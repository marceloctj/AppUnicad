<?php

namespace ApiUnicad\Http\Controllers;

use ApiUnicad\Http\Requests\EntregaRequest;
use ApiUnicad\Model\Cliente;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;

use ApiUnicad\Model\Entrega;

class EntregaController extends Controller
{
   /**
    * @var Entrega
    */
    private $entregaModel;

    /**
     * @var Cliente
     */
    private $clienteModel;

    public function __construct(Cliente $clienteModel, Entrega $entregaModel)
    {
        $this->entregaModel = $entregaModel;
        $this->clienteModel = $clienteModel;
    }

    public function index()
    {
        $entregas = $this->entregaModel
            ->with(['enderecoOrigem', 'cliente', 'enderecoDestino'])
            ->has('cliente')
            ->orderBy('data_entrega')
            ->get();

        return ['data' => $entregas];
    }

    public function show($id)
    {
        $entrega =  $this->entregaModel
            ->with(['enderecoOrigem', 'cliente', 'enderecoDestino'])
            ->has('cliente')
            ->findOrfail($id);

        return ['data' => $entrega];
    }

    public function store(EntregaRequest $request)
    {
        //$data = $this->request->only(['nome', 'data_entrega', 'endereco_destino', 'endereco_origem']);
        //dd($validations);
    }
}
