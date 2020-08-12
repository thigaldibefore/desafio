@extends('layout.layout')
@section('section_title') Clientes @endsection


@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/lib/ui-confirm/duDialog.min.css')}}" /> 

<style>
    .clienteInfo .clienteTooltip {
        visibility: hidden;
        background-color: #eeeeee;
        position: absolute;
        margin-left: 12%;
        width: auto;
        min-width: 200px;
        padding: 5px 10px;
        border: 1px solid darkslategrey;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;
        /*margin-top: -15px;*/
        z-index: 1;
        left: 10%;
    }

    .clienteInfo:hover {
        text-decoration: underline;
    }

    .clienteInfo:hover .clienteTooltip {
        visibility: visible;
    }

    .clienteInfoRazao .clienteTooltipRazao {
        visibility: hidden;
        background-color: #eeeeee;
        position: absolute;
        margin-left: 12%;
        width: auto;
        min-width: 200px;
        padding: 5px 10px;
        border: 1px solid darkslategrey;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;
        /*margin-top: -15px;*/
        z-index: 1;
        left: 39%;
    }

    .clienteInfoRazao:hover {
        text-decoration: underline;
    }

    .clienteInfoRazao:hover .clienteTooltipRazao {
        visibility: visible;
    }

    #btn-atender {
        border: 0 !important;
    }

    .dropdown-menu>.dropdown-item:hover {
        color: #242323;
    }
</style>


@endsection

@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/">Home</a></li>
    <li class="breadcrumb-item active">Clientes</li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card card-filters">
            <div class="card-body pb-0">
                <div class="row">
                    <div class="col-md-2">
                        <button class="btn btn-primary btn-rounded" onclick="location.href = '/clientes/create'">
                            <i class="icon icon-left s7-plus"></i> Novo Cliente
                        </button>
                    </div>
                    <form name="search_clientes" method="GET" action="clientes" class="col-md-10">
                        <div class="row">
                            <div class="col-lg-7 col-12">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="nome_cliente" placeholder="Buscar cliente" value="{{app('request')->input('nome_cliente')}}">
                                </div>
                            </div>
                            <div class="col-lg-5 col-12">
                                <button class="btn btn-secondary sendForm">
                                    <i class="icon s7-search"></i>Buscar
                                </button>
                                <button class="btn btn-link" type="button" onclick="location.href = '/clientes'">
                                    <i class="icon s7-close"></i>Limpar busca
                                </button>
                            </div>
                        </div>
                        <div style="display: none; margin-left: -21%;" id="advancedSearchForm">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="email_cliente" placeholder="E-mail" value="{{app('request')->input('email_cliente')}}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="documento_cliente" placeholder="Documento" value="{{app('request')->input('documento_cliente')}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="widget">
                    <div class="widget-body">
                        <table class="table">
                            <thead class="">
                                <tr>
                                    <th width="25%" class="text-left">Nome</th>
                                    <th width="25%" class="text-left">Email</th>
                                    @if(Auth::user()->isAdmin())
                                    <th class="number" width="1%"></th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($clientes as $cliente)
                                <tr>
                                    <td>{{$cliente->nome}}</td>
                                    <td>{{$cliente->email}}</td>

                                    <td class="number">
                                        <div class="btn-group dropright">
                                            <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                <i class="icon s7-menu"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-left">
                                                <a class="dropdown-item" href="javascript:void(0);" onclick="window.location='clientes/show/{{$cliente->id}}';">
                                                    <i class="icon s7-pen"></i> Editar
                                                </a>
                                                <div class="dropdown-divider"></div>
                                                <button class="dropdown-item text-danger deleteCliente" cliente_id="{{$cliente->id}}">
                                                    <i class="icon s7-trash"></i> Remover
                                                </button>
                                            </div>
                                        </div>
                                    </td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div id="total-display"></div>
                        <span>Mostrando <b>{{$clientes->count()}}</b> de <b>{{$clientes->total()}}</b> clientes</span>
                    </div>
                </div>
                <div id="pagination-contents"></div>
                {{ $clientes->appends(request()->input())->links("pagination::bootstrap-4") }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script src="{{ asset('assets/js/pages/clientes/clientes_index.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/lib/ui-confirm/duDialog.min.js')}}" type="text/javascript"></script>
<!-- <script src="{{ asset('assets/lib/select2/js/select2.min.js')}}" type="text/javascript"></script> -->
<script src="{{ asset('assets/lib/moment.js/moment.js')}}" type="text/javascript"></script>
<script src="{{ asset('assets/lib/moment.js/locale/pt-br.js')}}" type="text/javascript"></script>
@endsection

@section('modals')
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