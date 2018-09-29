<?php

namespace ApiUnicad\Http\Controllers;

use ApiUnicad\Http\Requests\EntregaRequest;
use ApiUnicad\Model\Cliente;
use Carbon\Carbon;
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
            ->with('cliente')->has('cliente')
            ->orderBy('data_entrega')
            ->get();

        return ['data' => $entregas];
    }

    public function show($id)
    {
        $entrega = $this->entregaModel
            ->with('cliente')->has('cliente')
            ->findOrfail($id);

        return ['data' => $entrega];
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $validation = $this->getValidationFactory()->make($data, [
            'cliente' => 'required',
            'data_entrega' => 'required|date_format:d/m/Y',
            'endereco_destino' => 'required',
            'endereco_origem' => 'required',
        ]);

        if($validation->fails())
            return response()->json(['errors' => $validation->errors()], 422);

        $cliente = Cliente::where('nome', $data['cliente'])->first();

        if(!$cliente)
            $cliente = Cliente::create(['nome' => $data['cliente']]);

        list($dia, $mes, $ano) = explode('/', $data['data_entrega']);
        $data['data_entrega'] = Carbon::create($ano, $mes, $dia);

        $entrega = $cliente->entregas()->create(array_except($data, ['cliente']));

        return response()->json([
            'data' => ['id' => $entrega->id]
        ], 201);
    }
}
