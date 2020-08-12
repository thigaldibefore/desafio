@extends('layout.layout')


@section('section_title') {{ $section_title }} @endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/lib/dropzone/dropzone.css') }}"/>
    <style>
        .dropzone {
            padding: 0 !important;
        }

        .dz-image {
            width: 160px !important;
            height: 160px !important;
        }

        .dz-image img {
            width: 100% !important;
        }
    </style>
@endsection
@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item"><a href="/usuarios">Usuários</a></li>
        <li class="breadcrumb-item active">{{ $section_title }}</li>
    </ol>
@endsection
@section('content')


    @if(isset($users))
        <form role="form" name="formContato" method="PUT" action="/api/users/{{$users->id}}">
            @else
                <form role="form" name="formContato" method="POST" action="/api/users/store">
                    @endif
                    <input type="hidden" name="id"
                                                   value="{{ isset($users->id) ? $users->id : '' }}">
                                            <input type="hidden" name="csrf_token" value="{{ csrf_token() }}">
                    <div class="row">
                        <div class="col-lg-8 col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Nome</label>
                                                <input class="form-control" type="text" placeholder="Nome" name="name"
                                                       value="{{ isset($users->name) ? $users->name : '' }}">
                                                <ul class="parsley-errors-list filled" style="display:none" for="name">
                                                    <li class="parsley-required"></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Login</label>
                                                <input class="form-control" type="text" placeholder="Nome" name="login"
                                                       value="{{ isset($users->login) ? $users->login : '' }}">
                                                <ul class="parsley-errors-list filled" style="display:none" for="login">
                                                    <li class="parsley-required"></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input class="form-control" type="text" placeholder="Email" name="email"
                                                       value="{{ isset($users->email) ? $users->email : '' }}">
                                                <ul class="parsley-errors-list filled" style="display:none" for="email">
                                                    <li class="parsley-required"></li>
                                                </ul>

                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-12">
                                            <div class="form-group">
                                                <label>Perfil</label>
                                                <select class="form-control" name="nivel">
                                                    <option value="">Selecione</option>
                                                    @foreach([1=>'Administrador',2=>'Usuário'] as $key => $tipo)
                                                        <option value="{{$key}}"
                                                                {{ (isset($users) && $key == $users->nivel ) ? 'selected' : ''}}>
                                                            {{ $tipo }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <ul class="parsley-errors-list filled" style="display:none"
                                                    for="perfil">
                                                    <li class="parsley-required"></li>
                                                </ul>
                                            </div>
                                        </div>
                                        @if(isset($users))
                                            <div class="form-group col-12 col-sm-12">
                                                <button class="btn btn-secondary btn-show-password-fields"
                                                        type="button">Alterar Senha
                                                </button>
                                            </div>
                                        @endif
                                        <div class="hidde-password row container {{ isset($users) ? 'd-none' : '' }}">
                                            <div class="col-12 col-sm-6">
                                                <label>Senha</label>
                                                <input class="form-control" type="password" placeholder="Senha"
                                                       name="password"
                                                       value="">
                                                <ul class="parsley-errors-list filled" style="display:none"
                                                    for="password">
                                                    <li class="parsley-required"></li>
                                                </ul>

                                            </div>
                                            <div class="col-12 col-sm-6">
                                                <label>Confirme a Senha</label>
                                                <input class="form-control" type="password"
                                                       placeholder="Confirme a Senha"
                                                       name="password_confirmation" value="">
                                                <ul class="parsley-errors-list filled" style="display:none"
                                                    for="password_confirmation">
                                                    <li class="parsley-required"></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="mt-4 mb-4 border-top col-12"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 col-lg-4">
                            @if(isset($users) && is_file($users->avatar))
                                <div class="card cardLogo">
                                    <div class="card-header">
                                        <h3 style="float: left;">Avatar Atual</h3>
                                        <div class="tools dropdown">
                            <span class="icon s7-close deleteLogo" data-toggle="tooltip" data-placement="top" title=""
                                  data-original-title="Remover logo" conta_id="{{$users->id}}"></span>
                                        </div>
                                    </div>
                                    <div class="card-body text-center">
                                        <img src="{{asset($users->avatar) }}" width="120" alt=""
                                             class="rounded">
                                    </div>
                                </div>
                            @endif
                            <div class="card">
                                <div class="card-header">
                                    <h3>Avatar</h3>
                                </div>
                                <div class="card-body">
                                    <div class="dropzone" id="my-awesome-dropzone"
                                         action="assets/lib/dropzone/upload.php">
                                        <div class="dz-message">
                                            <div class="icon"><span class="s7-cloud-upload "></span></div>
                                            <h4>Arraste e solte seu arquivo aqui.</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header">
                                    <h3>Status</h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <select class="form-control" name="status" id="">
                                            <option value="">Selecione</option>
                                            @foreach(['1'=>'Ativo','2'=>'Pendente','0'=>'Inativo'] as $key => $tipo)
                                                <option value="{{$key}}"
                                                        {{ (isset($users) && $key == $users->status ) ? 'selected' : ''}}>
                                                    {{ $tipo }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <ul class="parsley-errors-list filled" style="display:none" for="active">
                                            <li class="parsley-required"></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-end">
                            <a href="/usuarios" class="btn btn-space btn-secondary" type="button">Cancelar</a>
                            <button class="btn btn-space btn-primary sendForm" type="button">Salvar</button>
                        </div>
                    </div>
                </form>
                @endsection

            @section('javascript')
                <script src="{{ asset('assets/lib/dropzone/dropzone.js') }}" type="text/javascript"></script>
                <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
                <script src="{{ asset('assets/js/pages/usuarios/usuarios_crud.js') }}" type="text/javascript"></script>
@endsection
