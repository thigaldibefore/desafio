<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Clientes;
use Illuminate\Http\Request;
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
        if (\Auth::user()) {
            if (\Auth::user()->editado != 0) {
                \Auth::logout();
                session()->flush();
                return redirect('/login')->withErrors('Sua conta foi alterada. Por favor faça login novamente');
            }
        }
        
        $clientes = $this->getParams($request->all());

        return view('pages.clientes.index', ['clientes' => $clientes]);
    }

    public function create() {
        return view('pages.clientes.create', ['section_title' => 'Novo Cliente']);
    }

    public function show($id) {
        $cliente = Clientes::find($id);
        
        return view('pages.clientes.create', ['section_title' => 'Editar Cliente', 'cliente' => $cliente]);
    }

    public function getParams($request)
    {
        \Carbon\Carbon::setLocale('pt_BR');
        $page = 15;
        $clientes = Clientes::getClientes([
            'id' => isset($request['id_cliente']) ? $request['id_cliente'] : null,
            'nome' => isset($request['nome_cliente']) ? $request['nome_cliente'] : null,
            'documento' => isset($request['documento_cliente']) ? $request['documento_cliente'] : null,
        ])->paginate($page);

        return $clientes;
    }
}
