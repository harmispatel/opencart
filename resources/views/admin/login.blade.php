<!--
    * This is ADMIN LOGIN FORM VIEW
-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ADMIN : LOGIN</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('public/plugins/fontawesome-free/css/all.min.css') }}">

    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{ asset('public/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('public/dist/css/adminlte.min.css') }}">

</head>
<body>

    <div class="container mt-5">
        <div class="row">
            {{-- Login Section Start --}}
            <div class="login-box m-auto">
                <div class="login-logo">
                    <a href=""><b>MANAGER</b></a>
                </div>
                <!-- /.login-logo -->
                <div class="card">
                    <div class="card-body login-card-body">
                        <p class="login-box-msg">Log in to start your session</p>
                        <form action="{{ route('login') }}" method="post">
                            {{ csrf_field() }}
                            <div class="input-group">
                                <input type="text" name="email" class="form-control {{ ($errors->has('email')) ? 'is-invalid' : '' }}" placeholder="Email">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-envelope"></span>
                                    </div>
                                </div>
                            </div>
                            @if($errors->has('email'))
                                <span class="text-danger mt-0">
                                    {{ $errors->first('email') }}
                                </span>
                            @endif
                            <div class="input-group mt-3">
                                <input type="password" name="password" class="form-control {{ ($errors->has('password')) ? 'is-invalid' : '' }}" placeholder="Password">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                            </div>
                            @if($errors->has('password'))
                                <span class="text-danger mt-0">
                                    {{ $errors->first('password') }}
                                </span>
                            @endif

                            @if(Session::has('error'))
                                <div class="text-danger">
                                    {{ session::get('error') }}
                                </div>
                            @endif

                            <div class="input-group mt-3">
                                <button type="submit" class="btn btn-primary btn-block">Sign In </button>
                            </div>
                        </form>
                    </div>
                    <!-- /.login-card-body -->
                </div>
            </div>
            {{-- / End Login Section --}}
        </div>
    </div>

    <script src="{{ asset('public/plugins/jquery/jquery.min.js') }}"></script>

    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('public/plugins/jquery-ui/jquery-ui.min.js') }}"></script>

    <!-- Bootstrap 4 -->
    <script src="{{ asset('public/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('public/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>

    <!-- AdminLTE App -->
    <script src="{{ asset('public/dist/js/adminlte.js') }}"></script>

</body>
</html>

