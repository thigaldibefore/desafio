<?php

namespace App\Http\Controllers;

use App\Models\Ceps;
use App\Models\Cidades;
use App\Models\Estados;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CepController extends Controller
{
    public function index(Request $request)
    {
        $__cep = str_replace(['-', '.'], '', $request->cep);

        $locale = Cache::remember('busca_cep_' . $__cep,(60*24)*30, function () use($__cep) {
            return Ceps::where('cep', '=', $__cep)->where('cep_ativo', 'S')->get();
        });

        if (count($locale) > 0) {
            return json_encode(['success' => true, 'dados' => $locale]);
        } else {
            Cache::forget('busca_cep_' . $__cep);
            return json_encode(['success' => false, 'dados' => 'Cep não encontrado']);
        }
    }

    public function cidades($estado, Request $request)
    {
        $locale = Cidades::where('cidade', 'like', '%' . $request->term . '%')->where('estado', '=', $estado)->get();


        if (count($locale) > 0) {
            return json_encode(['success' => true, 'dados' => $locale]);
        } else {
            return json_encode(['success' => false, 'dados' => 'Cidade não encontrada']);
        }
    }

    public function estados(Request $request)
    {
        $locale = Estados::where('sigla', 'like', '%' . $request->term . '%')->groupBy('sigla')->get();


        if (count($locale) > 0) {
            return json_encode(['success' => true, 'dados' => $locale]);
        } else {
            return json_encode(['success' => false, 'dados' => 'Estado não encontrado']);
        }
    }
}
