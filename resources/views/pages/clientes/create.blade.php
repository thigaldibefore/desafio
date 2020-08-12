@extends('layout.layout')


@section('section_title') {{ $section_title }} @endsection

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/lib/dropzone/dropzone.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('assets/lib/ui-confirm/duDialog.min.css')}}" />
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

    .tab-content {
        background-color: transparent !important;
    }
</style>

<link rel="stylesheet" type="text/css" href="{{ asset('assets/lib/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css') }}" />
<link rel="stylesheet" type="text/css" href="https://daneden.github.io/animate.css/animate.min.css" />
@endsection
@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/">Home</a></li>
    <li class="breadcrumb-item"><a href="/clientes">Clientes</a></li>
    <li class="breadcrumb-item active">{{ $section_title }}</li>
</ol>
@endsection
@section('content')

<div class="row">
    <div class="col-sm-12">
        <p class=" {{Session::has('message') ? '' : 'd-none'}} alert animated fadeIn {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}
        </p>
    </div>
</div>
@if(isset($cliente))
<form role="form" name="formContato" method="PUT" action="/api/clientes/{{$cliente->id}}">
    @else
    <form role="form" name="formContato" method="POST" action="/api/clientes/store">
        @endif
        <input type="hidden" name="id" value="{{ isset($cliente->id) ? $cliente->id : '' }}">
        <input type="hidden" name="csrf_token" value="{{ csrf_token() }}">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <h2>Dados Gerais</h2>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Nome</label>
                                    <input class="form-control" type="text" placeholder="Nome" name="nome" value="{{isset($cliente->nome) ? $cliente->nome : ''}}">
                                    <ul class="parsley-errors-list filled" style="display:none" for="nome">
                                        <li class="parsley-required"></li>
                                    </ul>
                                </div>
                                <div class="form-group">
                                    <label>E-mail</label>
                                    <input type="text" class="form-control error email" placeholder="E-mail" name="email" value="{{isset($cliente->email) ? $cliente->email : ''}}">
                                </div>
                                <div class="form-group">
                                    <label>Latitude</label>
                                    <input class="form-control" type="text" placeholder="Latitude" name="latitude" value="{{isset($cliente->latitude) ? $cliente->latitude : ''}}">
                                    <ul class="parsley-errors-list filled" style="display:none" for="latitude">
                                        <li class="parsley-required"></li>
                                    </ul>
                                </div>
                                <div class="form-group">
                                    <label>Longitude</label>
                                    <input class="form-control" type="text" placeholder="Longitude" name="longitude" value="{{isset($cliente->longitude) ? $cliente->longitude : ''}}">
                                    <ul class="parsley-errors-list filled" style="display:none" for="longitude">
                                        <li class="parsley-required"></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-12">
                                <h2>Documentos</h2>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-4">
                                <div class="form-group">
                                    <label>Tipo</label>
                                    <select class="form-control" name="tipo">
                                        <option value="">Selecione</option>
                                        @foreach(['J'=>'Jurídica','F'=>'Física'] as $key => $tipo)
                                        <option value="{{$key}}" {{isset($cliente) && $cliente->tipo == $tipo  ? 'selected' : ''}}>
                                            {{ $tipo }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <ul class="parsley-errors-list filled" style="display:none" for="tipo">
                                        <li class="parsley-required"></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-12 col-sm-8">
                                <div class="form-group">
                                    <label>Documento</label>
                                    <input class="form-control error" type="text" placeholder="N Documento" name="documento" value="{{isset($cliente->documento) ? $cliente->documento : ''}}">
                                    <ul class="parsley-errors-list filled" style="display:none" for="documento">
                                        <li class="parsley-required"></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="card-footer">
            <div class="text-inverse">
                <a href="/clientes" class="btn btn-space btn-secondary" type="button">Cancelar</a>
                <button class="btn btn-space btn-primary sendForm" type="button">Salvar</button>
            </div>
        </div>
    </form>
    @endsection

    @section('modals')
    @endsection

    @section('javascript')
    <script src="{{ asset('assets/lib/moment.js/moment.js')}}" type="text/javascript"></script>
    <script src="{{ asset('assets/lib/moment.js/locale/pt-br.js')}}" type="text/javascript"></script>
    <script src="{{ asset('assets/lib/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js')}}" type="text/javascript">
    </script>
    <script src="{{ asset('assets/lib/ui-confirm/duDialog.min.js')}}" type="text/javascript"></script>
    <script src="https://igorescobar.github.io/jQuery-Mask-Plugin/js/jquery.mask.min.js"></script>
    <script src="{{ asset('assets/js/pages/clientes/clientes_crud.js') }}" type="text/javascript"></script>
    @endsection