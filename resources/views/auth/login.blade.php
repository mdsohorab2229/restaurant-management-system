<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />

    <title>Login :: Datatrix :: DataTrix Software</title>

    <!-- Bootstrap 3.3.7 -->
    <link href="{{ URL::asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />
    <!-- Font Awesome -->
    <link href="{{ URL::asset('assets/vendor/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" />
    <!-- Ionicons -->
    <link href="{{ URL::asset('assets/vendor/Ionicons/css/ionicons.min.css') }}" rel="stylesheet" />
    <!-- Theme style -->
    {{-- <link href="{{ URL::asset('assets/css/main.min.css') }}" rel="stylesheet" />--}}
    <link href="{{ URL::asset('assets/css/custom-login.css') }}" rel="stylesheet" /> 
    <!-- iCheck -->
    <link href="{{ URL::asset('assets/vendor/iCheck/square/red.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/favicon.png') }}" rel="shortcut icon">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]> <script
            src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script> <script
            src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script> <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="">
            <h2>Jannat Restaurant</h2>
        </a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body login-body">
        <div class="login-avater">
            <h2 class="textx-center">Sign In</h2>
            <img src="{{ asset('assets/images/waiter.png') }}" alt="" class="avater-img">
        </div>
            @if($errors->has('credentials'))
                <span class="help-block" style="color:red">{{$errors->first('credentials')}}</span>
                @endif
        <form action="{{ route('login') }}" method="POST" class="login-form">
            {{ csrf_field() }}

            <div class="form-group has-feedback">
                <input type="text" class="form-control" name="email" placeholder="Email or Username" value="{{ old('email') }}" autofocus required/>
                {{-- <span class="glyphicon glyphicon-envelope form-control-feedback"></span> --}}

                @if ($errors->has('email'))
                    <span class="help-block" style="color:red">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" name="password" placeholder="Password" required/>
                {{-- <span class="glyphicon glyphicon-lock form-control-feedback"></span> --}}

                @if ($errors->has('password'))
                    <span class="help-block" style="color:red">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                @endif
            </div>
            <div class="form-group">
                <button type="submit" class="login-btn">Sign In</button>
            </div>
            <div class="login-footer">
                <div class="row">
                    <div class="col-xs-6">
                        <label>
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} />
                            Remember Me
                        </label>
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-6 text-right">
                        <a href="/">Forgot Password?</a>
                    </div>
                </div>
            </div>
        </form>

    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="{{ URL::asset('assets/vendor/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ URL::asset('assets/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
<!-- iCheck -->
<script src="{{ URL::asset('assets/vendor/iCheck/icheck.min.js') }}"></script>
<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-red', radioClass: 'iradio_square-red', increaseArea: '20%' // optional
        });
    });
</script>
</body>
</html>