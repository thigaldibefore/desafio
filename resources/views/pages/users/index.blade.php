@extends('layout.layout')
@section('section_title') Usuários @endsection

@section('css')
<link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/lib/ui-confirm/duDialog.min.css')}}" />
@endsection

@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/">Home</a></li>
    <li class="breadcrumb-item active">Usuários</li>
</ol>
@endsection

@section('content')

<div class="row">
    <div class="col-sm-12">
        <p class=" {{Session::has('message') ? '' : 'd-none'}} alert animated fadeIn {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}
        </p>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="card card-filters">
            <div class="card-body pb-0">
                <div class="d-flex justify-content-between">

                    <div>
                        <a class="btn btn-space btn-primary btn-rounded" href="/usuarios/create">
                            <i class="icon icon-left s7-plus"></i> Novo Usuário
                        </a>
                    </div>

                    <form name="search_usuario" method="GET" action="usuarios" style="width: 85%;">
                        <div class="row">
                            <div class="col-lg-3 col-12">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="login_usuario" placeholder="Login" value="{{app('request')->input('login_usuario')}}">
                                </div>
                            </div>
                            <div class="col-lg-3 col-12">
                                <div class="form-group">
                                    <input type="text" name="nome_usuario" class="form-control" placeholder="Nome" value="{{app('request')->input('nome_usuario')}}">
                                </div>
                            </div>
                            <div class="col-lg-4 col-12">
                                <div class="form-group">
                                    <input type="text" name="email_usuario" class="form-control" placeholder="E-mail" value="{{app('request')->input('email_usuario')}}">
                                </div>
                            </div>
                            <div class="col-lg-2 col-12 text-right">
                                <button class="btn btn-secondary" type="submit">
                                <i class="icon s7-search"></i>Buscar
                                </button>
                                <button class="btn btn-link" type="button" onclick="location.href = '/usuarios'">
                                <i class="icon s7-close"></i>Limpar Busca
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="widget">
            @if($users->count() > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th width="25%">Login</th>
                        <th width="25%">Nome</th>
                        <th width="25%">Email</th>
                        <th width="10%">Status</th>
                        <th width="1%"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{$user->login}}</td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td> {!! $user->StatusLabel !!}
                        </td>
                        <td class="number">
                            <div class="btn-group dropright">
                                <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <i class="icon s7-menu"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-left">
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="window.location='usuarios/show/{{$user->id}}';">
                                        <i class="icon s7-pen"></i> Editar
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <button class="dropdown-item text-danger deleteUser" user_id="{{$user->id}}">
                                        <i class="icon s7-trash"></i> Remover
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <span>Mostrando <b>{{$users->count()}}</b> de <b>{{$users->total()}}</b> usuários</span>
        </div>
        {{ $users->appends(request()->input())->links("pagination::bootstrap-4") }}

        @else
        <div>Nenhum registro encontrado.</div>
        @endif

    </div>
</div>

@endsection

@section('javascript')
<script src="{{ asset('assets/lib/select2/js/select2.min.js')}}" type="text/javascript"></script>
<script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('assets/lib/ui-confirm/duDialog.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('assets/js/pages/usuarios/usuarios_index.js') }}" type="text/javascript"></script>
@endsection

@section('modals')
<div class="modal fade modalConfirm" id="" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal" aria-hidden="true"><i class="icon s7-close"></i></button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <div class="i-circle text-warning"><i class="icon s7-attention"></i></div>
                    <h4>Remover Usuário!</h4>
                    <p>Gostaria de remover o item selecionado!</p>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button class="btn btn-warning confirmDelete" data-dismiss="modal">Remover</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modalError" id="" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal" aria-hidden="true"><i class="icon s7-close"></i></button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <div class="i-circle text-danger"><i class="icon s7-attention"></i></div>
                    <h4>Negado!</h4>
                    <p class="modalErrorMsg"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

@endsection