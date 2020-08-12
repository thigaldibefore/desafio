<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Session;

class ClientesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return response()->json(Clientes::getClientes($request->all())->get())->setStatusCode(200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $razao_social = $request->razao_social;
        $documento = $request->documento;
        $validation_rules = [
            'nome' => 'required',
            'documento' => [
                'required',
                Rule::unique('clientes')->where(function ($query) use ($request) {
                    return $query->whereNull('deleted_at')->where('documento', $request->documento);
                }),
            ]
        ];

        if (isset($request->email) && trim($request->email) != '') {
            $validation_rules['email'] = 'email:filter';
        }

        $validator = Validator::make($request->all(), $validation_rules, [
            'required' => 'O :attribute é obrigatório',
            'unique' => 'Esse :attribute já foi cadastrado no banco',
            'email' => 'Por favor informe um email válido',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->getMessageBag()->toArray()]);
        } else {
            $data = array_merge($validator->valid(), ['created_at' => \Carbon\Carbon::now()]);
            $clientes = Clientes::create($data);

            activity()
                ->useLog('store')
                ->on($clientes)
                ->withProperties(['original' => $clientes])
                ->log("Adicionou um cliente");

            return response()->json(['success' => true, 'message' => 'Cliente cadastrado com sucesso.', 'data' => $clientes]);
        }
    }

    public function show(Clientes $id)
    {
        if ($id) {
            return response()->json(['data' => $id->toArray()]);
        } else {
            return response()->json(['success' => false, 'error' => 'Cliente não encontrado']);
        }
    }

    public function update(Request $request, $id)
    {
        $razao_social = $request->razao_social;
        $documento = $request->documento;
        $clientes = Clientes::find($id);
        if (!$clientes) {
            return response()->json(['success' => false, 'error' => 'Cliente não encontrado']);
        }

        $validation_rules = [
            'nome' => 'required',
            'documento' => [
                'required',
                Rule::unique('clientes')->where(function ($query) use ($request, $id) {
                    return $query->whereNull('deleted_at')->where('documento', $request->documento)->where('id', '!=', $id);
                }),
            ],
        ];

        if (isset($request->email) && trim($request->email) != '') {
            $validation_rules['email'] = 'email:filter';
        }

        $validator = Validator::make($request->all(), $validation_rules, [
            'required' => 'O :attribute é obrigatório',
            'unique' => 'Esse :attribute já foi cadastrado no banco',
            'email' => 'Por favor informe um email válido',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->getMessageBag()->toArray()]);
        } else {
            $data = array_merge($validator->valid(), ['updated_at' => \Carbon\Carbon::now()]);

            activity()
                ->useLog('update')
                ->on($clientes)
                ->withProperties(['original' => $clientes, 'alterado' => $data])
                ->log("Alterou um cliente");

            $clientes->update($data);

            Session::flash('message', 'Cliente atualizado com sucesso.');

            return response()->json(['success' => true, 'message' => 'Cliente atualizado com sucesso.', 'data' => $clientes]);
        }
    }

    public function destroy($id)
    {
        $clientes = Clientes::find($id);
        if ($clientes) {
            try {
                activity()
                    ->useLog('destroy')
                    ->on($clientes)
                    ->withProperties(['original' => $clientes])
                    ->log("Removeu um cliente");

                $clientes->delete();
                Session::flash('message', 'Cliente removido com sucesso.');

                return response()->json(['success' => true, 'message' => 'Cliente removido']);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'error' => $e->getMessage()]);
            }
        } else {
            return response()->json(['success' => false, 'error' => 'Cliente não encontrado']);
        }
    }

    public function getLogs(Clientes $cliente, Request $request)
    {

        $logs = $cliente->logs();

        if (array_has($request, 'tipo') && $request['tipo'] !== null) {
            $logs = $logs->where('log_name', $request['tipo']);
        }
        if (array_has($request, 'usuario') && $request['usuario'] !== null) {
            $logs = $logs->where('causer_id', $request['usuario']);
        }
        if (array_has($request, 'data') && $request['data'] !== null) {
            $datefilter = date('Y-m-d', strtotime(str_replace('/', '-', $request['data'])));
            $logs = $logs->whereDate('created_at', $datefilter);
        }

        $logs = $logs->orderBy('created_at', 'desc')->get();
        $logs = $logs->load('user');
        $logs = $logs->toArray();



        return response()->json(['success' => true, 'message' => 'Listagem de logs', 'data' => $logs]);
    }

    public function checarDuplicado(Request $request)
    {
        if (isset($request->documento)) {
            $check = Clientes::where('conta_id', Auth::user()->conta_id)->where(function ($query) use ($request) {
                $query->where('documento', $request->documento)
                    ->orWhere('documento', str_replace(['.', '-'], '', $request->documento));
            })->first();
        }
        if (isset($check) && $check) {
            return response()->json(['duplicate' => true, 'dados' => $check]);
        } else {
           
            if (isset($check) && $check) {
                return response()->json(['duplicate' => true, 'dados' => $check]);
            } else {
               
                if (isset($check) && $check) {
                    return response()->json(['duplicate' => true, 'dados' => $check]);
                } else {
                    if (isset($request->email)) {
                        $check = Clientes::getClientes([
                            'email' => $request->email
                        ])->first();
                    }
                    if (isset($check) && $check) {
                        return response()->json(['duplicate' => true, 'dados' => $check]);
                    }
                }
            }
        }
        return response()->json(['duplicate' => false]);
    }
}
