<?php

namespace App\Http\Controllers\web;

use App\Models\Ceps;
use App\Models\Cidades;
use App\Models\Estados;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        if(\Auth::user()) {
            if(\Auth::user()->editado != 0) {
                \Auth::logout();
                session()->flush();
                return redirect('/login')->withErrors('Sua conta foi alterada. Por favor faça login novamente');
            }
        }

        if (isset(\Auth::user()->id)) {
            return redirect()->route('dashboard');
        }
        return view('pages.login');
    }

    public function fixCidadesKeys()
    {
        if(\Auth::user()) {
            if(\Auth::user()->editado != 0) {
                \Auth::logout();
                session()->flush();
                return redirect('/login')->withErrors('Sua conta foi alterada. Por favor faça login novamente');
            }
        }

        $estados = Estados::all();
        foreach ($estados as $estado):
            $cidades = Cidades::where('estado', $estado->sigla)
                ->where('faixa_ini', '>=', $estado->faixa_ini)
                ->where('faixa_fim', '<=', $estado->faixa_fim)
                ->update(['estado_id' => $estado->id]);
        endforeach;
    }

    public function fixCepsKeys()
    {
        if(\Auth::user()) {
            if(\Auth::user()->editado != 0) {
                \Auth::logout();
                session()->flush();
                return redirect('/login')->withErrors('Sua conta foi alterada. Por favor faça login novamente');
            }
        }

        $ceps = Ceps::whereNull('cidade_id')->limit(20000)->get();
        foreach($ceps as $cep):
            $cidade = Cidades::where('cidade', $cep->cidade)->first();
            $cep->update(['cidade_id'=>$cidade->id]);
        endforeach;
    }


    public function phpinfo()
    {
        dd(phpinfo());
    }
}
