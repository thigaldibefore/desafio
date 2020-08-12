<?php

namespace App\Http\Controllers\web;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Str;




class DashboardController extends Controller
{

    public function index(Request $request)
    {
        if(\Auth::user()) {
            if(\Auth::user()->editado != 0) {
                \Auth::logout();
                session()->flush();
                return redirect('/login')->withErrors('Sua conta foi alterada. Por favor faça login novamente');
            }
        }

        return view('pages.dashboard.index', ['section_title' => null,]);
    }
}
