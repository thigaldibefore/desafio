<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.ico') }}">
    <title>@yield('title','Clique Carretas - Sistema ADM')</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/lib/stroke-7/style.css') }}"/>
    <link rel="stylesheet" type="text/css"
          href="{{ asset('assets/lib/perfect-scrollbar/css/perfect-scrollbar.css') }}"/>
    <link rel="stylesheet" type="text/css"
          href="{{ asset('assets/lib/jquery.gritter/css/jquery.gritter.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/lib/summernote/summernote-bs4.css')}}"/>

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/lib/select2/css/select2.min.css')}}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/themes/theme-google.css') }}" type="text/css"/>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/lib/ui-confirm/duDialog.min.css')}}"/>

    @yield('css')


    <style>
        .loadingModal {
            display: none;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.6);
            position: fixed;
            z-index: 9999;
        }

        .loadingModal .content-loading {
            position: relative;
            width: 60px;
            height: 60px;
            top: 50%;
            left: 50%;
            margin-top: -30px;
            margin-left: -30px;
        }

        .loader {
            width: 80px;
            height: 80px;
        }

        .datepicker-days {
            padding: 16px;
        }

        .btn-remove {
            padding: 0 5px 0 5px;
            border-style: none;
            border-radius: 50%;
        }

        ul.nav:nth-child(2) {
            flex-grow: unset !important;
        }

        #search_cliente_top {
            background-color: #4a5a77 !important;
        }

        .select2 {
            width: 100% !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__clear {
            margin-right: 20px !important;
        }
    </style>
</head>

<body>
<div class="loadingModal" id="">
    <div class="content-loading">
        <div class="loader">
            <img width="60px" src="{{asset('assets/img/loading.gif')}}" alt="">
        </div>
    </div>
</div>

<div id="app" class="am-wrapper am-fixed-sidebar">


    <div class="am-content">

        <div class="main-content">
            @include('layout.navbar')
            @include('layout.sidemenu')
            @if(isset($section_title))
                <div class="page-head pt-1 pb-1 mb-4">
                    <h4 class="pl-1"><b>@yield('section_title')</b></h4>
                    @yield('breadcrumb')
                </div>
            @endif
            @yield('content')
            
            @yield('modals')

        </div>
    </div>
    @include('layout.rightsidebar')
</div>

<script>
    window.__auth = JSON.parse('{!!  Auth::user() !!}');
</script>

<script src="{{ asset('assets/lib/jquery/jquery.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('assets/lib/bootstrap/dist/js/bootstrap.bundle.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/lib/perfect-scrollbar/js/perfect-scrollbar.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/lib/jquery.gritter/js/jquery.gritter.js')}}" type="text/javascript"></script>
<script src="{{ asset('assets/lib/moment.js/moment.js')}}" type="text/javascript"></script>
<script src="{{ asset('assets/lib/moment.js/locale/pt-br.js')}}" type="text/javascript"></script>
<script src="{{ asset('assets/lib/summernote/summernote-bs4.js')}}" type="text/javascript"></script>

<script src="{{ asset('assets/lib/select2/js/select2.min.js')}}" type="text/javascript"></script>

<script src="{{ asset('assets/lib/moment.js/moment.js')}}" type="text/javascript"></script>
<script src="{{ asset('assets/lib/moment.js/locale/pt-br.js')}}" type="text/javascript"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script> -->

<script src="{{ asset('assets/lib/datepicker/js/bootstrap-datepicker.js')}}"
        type="text/javascript"></script>
<script src="{{ asset('assets/lib/datepicker/locales/bootstrap-datepicker.pt-BR.min.js')}}"
        type="text/javascript"></script>
<script src="{{ asset('assets/lib/ui-confirm/duDialog.min.js')}}" type="text/javascript"></script>
<script src="https://www.gstatic.com/firebasejs/7.8.1/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.8.1/firebase-database.js"></script>


<script src="{{ asset('js/app.js') }}" type="text/javascript"></script>

<script src="{{ asset('assets/js/main.js') }}" type="text/javascript"></script>


<script type="text/javascript">

    $(document).ready(function () {

        $('.modal').on('hidden.bs.modal', function () {
            if ($('.modal').hasClass('show')) {
                $("html").addClass('am-modal-open');
                $("body").addClass('modal-open');
            } else {
                $("html").removeClass('am-modal-open');
                $("body").removeClass('modal-open');
            }
        });
        App.init({
            openLeftSidebarOnClick: true
        });
    });
</script>
@yield('javascript')

</body>

</html>