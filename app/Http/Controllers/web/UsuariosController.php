<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Session;

class UsuariosController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(\Auth::user()) {
            if(\Auth::user()->editado != 0) {
                \Auth::logout();
                session()->flush();
                return redirect('/login')->withErrors('Sua conta foi alterada. Por favor faça login novamente');
            }
        }

        $users = $this->getParams($request);
        return view('pages.users.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(\Auth::user()) {
            if(\Auth::user()->editado != 0) {
                \Auth::logout();
                session()->flush();
                return redirect('/login')->withErrors('Sua conta foi alterada. Por favor faça login novamente');
            }
        }

        return view('pages.users.create',
            ['section_title' => 'Novo Usuário']);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\User $clientes
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(\Auth::user()) {
            if(\Auth::user()->editado != 0) {
                \Auth::logout();
                session()->flush();
                return redirect('/login')->withErrors('Sua conta foi alterada. Por favor faça login novamente');
            }
        }

        $users = User::findOrFail($id);

        return view('pages.users.create', [
            'users' => $users,
            'section_title' => 'Editar Usuário'
        ]);
    }

    public function uploadAvatar(Request $request)
    {
        if(\Auth::user()) {
            if(\Auth::user()->editado != 0) {
                \Auth::logout();
                session()->flush();
                return redirect('/login')->withErrors('Sua conta foi alterada. Por favor faça login novamente');
            }
        }

        try {
            if (!is_dir(public_path('uploads/avatar'))) {
                mkdir(public_path('uploads/avatar'), 0777);
            }
            $photoName = 'avatar_' . $request->id . '.' . $request->file->getClientOriginalExtension();
            $request->file->move(public_path('uploads/avatar'), $photoName);
            $users = User::findOrFail($request->id);
            $users->avatar = $photoName;
            $users->save();
            Session::flash('message', 'Conta atualizada com sucesso.');

            return json_encode(['success' => true, 'message' => 'Upload finalizado']);
        } catch (\Exception $exception) {
            return json_encode(['success' => false, 'message' => $exception->getMessage()]);
        }
    }

    public function removeAvatar(Request $request)
    {
        if(\Auth::user()) {
            if(\Auth::user()->editado != 0) {
                \Auth::logout();
                session()->flush();
                return redirect('/login')->withErrors('Sua conta foi alterada. Por favor faça login novamente');
            }
        }
        

        try {
            $users = User::find($request->id);
            $users->avatar = null;
            $users->save();

            return json_encode(['success' => true, 'message' => 'avatar Removido']);
        } catch (\Exception $exception) {
            return json_encode(['success' => false, 'message' => $exception->getMessage()]);
        }
    }

    public function perfil(User $usuario)
    {
        if(\Auth::user()) {
            if(\Auth::user()->editado != 0) {
                \Auth::logout();
                session()->flush();
                return redirect('/login')->withErrors('Sua conta foi alterada. Por favor faça login novamente');
            }
        }

        return view('pages.sistema.users.perfil', compact('usuario'));
    }

    public function login(Request $request)
    {
        session()->flush();

        $credentials = $request->only('login','email', 'password');
        $credentials['status'] = 1;
        if (\Auth::attempt($credentials)) {

            $user = User::find(\Auth::user()->id);
            $data['editado'] = 0;
            $user->update(['editado' => 0]);
            return redirect()->intended('home');
        } else {
            return redirect('/login')->withErrors('Login ou senhas incorretos');
        }
    }

    public function logout()
    {
        \Auth::logout();
        session()->flush();

        return redirect('/login');
    }

    public function getParams(Request $request)
    {
        \Carbon\Carbon::setLocale('pt_BR');
        $page = 15;
        $contas = User::getUser([
            'nome' => $request->get('nome_usuario'),
            'email' => $request->get('email_usuario'),
            'login' => $request->get('login_usuario'),
        ])->paginate($page);

        return $contas;
    }
}
