<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ setting('name') }}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dashboard/css/adminlte.min.css') }} ">
    <!-- Google Font: Cairo -->
    <link href="https://fonts.googleapis.com/css?family=Cairo:400,700" rel="stylesheet">
    <style>
        body, h1, h2, h3, h4, h5, h6 {
            font-family: 'Cairo', sans-serif !important;
        }
    </style>
    <!-- bootstrap rtl -->
    <link rel="stylesheet" href="{{ asset('dashboard/css/bootstrap-rtl.min.css') }}">
    <!-- template rtl version -->
    <link rel="stylesheet" href="{{ asset('dashboard/css/custom-style.css') }}">
</head>

<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <img style="float: initial;max-height: 100px;border-radius: .25rem;" src="{{ setting('logo_path') }}" alt="Logo"
            class="brand-image"><br>
        <a href="#"><b>{{ setting('name') }}</b></a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <form action="{{ route('login') }}" method="post">
                {{ csrf_field() }}
                {{ method_field('post') }}
                <div class="input-group mb-3">
                    <input type="email" name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           placeholder="{{ __('E-Mail Address') }}">
                    <div class="input-group-append">
                        <span class="fa fa-envelope input-group-text"></span>
                    </div>
                    @error ('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="{{ __('Password') }}">
                    <div class="input-group-append">
                        <span class="fa fa-lock input-group-text"></span>
                    </div>
                    @error ('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="remember"> @lang('site.remember_me')
                    </label>
                </div>
                <button type="submit" class="btn btn-primary btn-block"> @lang('site.login') </button>
            </form>
        </div>
        <!-- /.login-card-body -->
    </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{ asset('dashboard/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('dashboard/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

</body>

</html>
