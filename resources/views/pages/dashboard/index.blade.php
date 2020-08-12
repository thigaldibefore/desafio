@extends('layout.layout')


@section('section_title') {{ $section_title }} @endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/lib/jquery.fullcalendar/fullcalendar.min.css') }}"/>

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/lib/summernote/summernote-bs4.css')}}"/>
    <link rel="stylesheet" type="text/css"
          href="{{ asset('assets/lib/datepicker/css/bootstrap-datepicker3.css') }}"/>
    <style>
        .select2-selection__rendered {
            font-size: 12px;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__rendered {
            min-height: 1em !important;
        }
    </style>

@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 col-lg-6">
            <h1>Bem vindo!</h1>
        </div>
    </div>
@endsection
@section('javascript')
    <script src="{{ asset('assets/lib/jquery-ui/jquery-ui.min.js')}}" type="text/javascript"></script>
    <script src="{{ asset('assets/lib/moment.js/moment.js')}}" type="text/javascript"></script>
    <script src="{{ asset('assets/lib/jquery.fullcalendar/fullcalendar.min.js')}}" type="text/javascript"></script>
    <script src="{{ asset('assets/lib/jquery.fullcalendar/locale/pt-br.js')}}" type="text/javascript"></script>
    <script src="{{ asset('assets/lib/summernote/summernote.js')}}" type="text/javascript"></script>


    <script src="{{ asset('assets/lib/datepicker/js/bootstrap-datepicker.js')}}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/lib/datepicker/locales/bootstrap-datepicker.pt-BR.min.js')}}"
            type="text/javascript"></script>
@endsection
