<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.ico') }}">
    <title>@yield('title','CRUD')</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/lib/stroke-7/style.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/lib/perfect-scrollbar/css/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}" type="text/css" />
    <!-- <link rel="stylesheet" href="{{ asset('assets/css/theme-custom.css') }}" type="text/css" /> -->
    @yield('css')
</head>

<body class="am-splash-screen">
<div class="am-wrapper am-login">
    <div class="am-content">
      <div class="main-content">
        <div class="login-container">
          <div class="card">
            <div class="card-header"><span>Preencha com seus dados de acesso.</span></div>
            <div class="card-body">
                @if(Session::has('errors'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button class="close" data-dismiss="alert" aria-label="Close">
                      <span class="s7-close" aria-hidden="true"></span>
                    </button>
                    <span class="icon s7-close-circle"></span>{{Session::get('errors')->toArray()[0][0]}}
                  </div>
                @endif
              <form action="login" method="post">
                  {{ csrf_field() }}
                <div class="login-form">
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-prepend"><span class="input-group-text"><i class="icon s7-user"></i></span></div>
                      <input class="form-control" id="username" type="text" placeholder="Email" name="email" autocomplete="off">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-prepend"><span class="input-group-text"><i class="icon s7-lock"></i></span></div>
                      <input class="form-control" id="password" type="password" name="password" placeholder="Senha">
                    </div>
                  </div>
                  <div class="form-group login-submit">
                    <button class="btn btn-primary btn-lg btn-block" data-dismiss="modal" type="submit">Entrar</button>
                  </div>
                  {{-- <div class="form-group footer row">
                    <div class="col-6"><a href="#">Forgot Password?</a></div>
                    <div class="col-6 remember">
                      <label class="custom-control custom-control-inverse custom-checkbox custom-control-inline">
                        <input class="custom-control-input needsclick" type="checkbox" id="remember"><span class="custom-control-label">Remember Me</span>
                      </label>
                    </div>
                  </div> --}}
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="{{ asset('assets/lib/jquery/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/lib/perfect-scrollbar/js/perfect-scrollbar.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/lib/bootstrap/dist/js/bootstrap.bundle.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/main.js') }}" type="text/javascript"></script>
    @yield('javascript')
    <script type="text/javascript">
        $(document).ready(function() {
            //- initialize the javascript
            App.init({
                openLeftSidebarOnClick: true
            });
        });
    </script>
</body>

</html>