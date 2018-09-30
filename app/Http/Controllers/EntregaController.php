<?php

namespace ApiUnicad\Http\Controllers;

use ApiUnicad\Http\Requests\EntregaRequest;
use ApiUnicad\Model\Cliente;
use Carbon\Carbon;
use Illuminate\Http\Request;
use ApiUnicad\Http\Resources\Entrega as EntregaResource;

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
        $entregas = EntregaResource::collection($this->entregaModel
            ->with('cliente')->has('cliente')
            ->orderBy('data_entrega')
            ->get());

        return ['data' => $entregas];
    }

    public function show($id)
    {
        $entrega = new EntregaResource($this->entregaModel
            ->with('cliente')->has('cliente')
            ->findOrfail($id));

        return ['data' => $entrega];
    }

    public function store(Request $request)
    {
        $data = $request->json()->all();

        $validation = $this->getValidationFactory()->make($data, [
            'cliente' => 'required',
            'data_entrega' => 'required|date_format:Y-m-d|after_or_equal:today',
            'endereco_destino' => 'required',
            'endereco_origem' => 'required',
        ], [
            'data_entrega.after_or_equal' => 'O campo data entrega deve ser uma data superior ou igual a hoje'
        ]);
gi
        if($validation->fails())
            return response()->json(['errors' => $validation->errors()], 422);

        $cliente = Cliente::where('nome', $data['cliente'])->first();

        if(!$cliente)
            $cliente = Cliente::create(['nome' => $data['cliente']]);

        $data['data_entrega'] = Carbon::createFromFormat('Y-m-d', $data['data_entrega']);

        $entrega = $cliente->entregas()->create(array_except($data, ['cliente']));

        return response()->json([
            'data' => ['id' => $entrega->id]
        ], 201);
    }
}
