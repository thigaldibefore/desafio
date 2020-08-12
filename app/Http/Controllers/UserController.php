<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page = ($request->has('page') && $request->has('page') != null) ? $request->get('page') : 0;
        $page = $page * config('app.sistema.per_page');

        $filtros = $request->all();
        $filtros['status'] = '1';
        $users = User::getUser($filtros)->simplePaginate($page);

        return response()->json($users->toArray());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
            'password' => 'required|confirmed|min:6',
        ], [
            'name.required' => 'O nome é obrigatório',
            'password.required' => 'A senha é obrigatória',
            'password.confirmed' => 'As senhas não coincidem',
            'email.required' => 'O email é obrigatório',
            'unique' => 'Esse :attribute já foi cadastrado no banco',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->getMessageBag()->toArray()]);
        } else {
            $data = [
                'name' => $request->get('name'),
                'login' => $request->get('login'),
                'email' => $request->get('email'),
                'password' => $request->get('password'),
                'password' => Hash::make($request->get('password')),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => null
            ];
            $user = User::create($data);
            activity()
            ->useLog('store')
            ->on($user)
            ->withProperties(['original' => $user])
            ->log("Alterou um usuário");

            return response()->json(['success' => true, 'message' => 'Usuário cadastrado', 'data' => $user]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        if ($user) {
            return response()->json(['data' => $user->toArray()]);
        } else {
            return response()->json(['success' => false, 'error' => 'Usuário não encontrado']);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['success' => false, 'error' => 'Usuário não encontrado']);
        }

        $validateArray = [
            'name' => 'required',
            'email' => 'required|unique:users,email,' . $user->id,
        ];
        if ($request->has('password') && $request->get('password') != '') {
            $validateArray['password'] = 'required|confirmed|min:6';
        }
        $validator = Validator::make($request->all(), $validateArray, [
            'name.required' => 'O nome é obrigatório',
            'password.required' => 'A senha é obrigatória',
            'password.confirmed' => 'As senhas não coincidem',
            'email.required' => 'O email é obrigatório',
            'unique' => 'Esse :attribute já foi cadastrado no banco',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->getMessageBag()->toArray()]);
        } else {
            $data = [
                'name' => $request->get('name'),
                'login' => $request->get('login'),
                'email' => $request->get('email'),
                'updated_at' => \Carbon\Carbon::now(),
            ];
            if ($request->has('password') && $request->get('password') != '') {
                $data['password'] = Hash::make($request->get('password'));
            }

            activity()
            ->useLog('update')
            ->on($user)
            ->withProperties(['original' => $user, 'alterado' => $data])
            ->log("Alterou um usuário");

            $user->update($data);

            $data['editado'] = 1;
            return response()->json(['success' => true, 'message' => 'Usuário alterado', 'data' => $user]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if ($user) {
            activity()
            ->useLog('destroy')
            ->on($user)
            ->withProperties(['original' => $user])
            ->log("Alterou um usuário");
            $user->delete();

            return response()->json(['success' => true, 'message' => 'Usuário removido']);
        } else {
            return response()->json(['success' => false, 'error' => 'Usuário não encontrado']);
        }
    }
}
