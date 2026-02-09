<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forgot Password</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ url('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ url('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ url('dist/css/adminlte.min.css') }}">
</head>

<body class="hold-transition login-page" style="background-color: #f4f6f9;">
    <div class="login-box">
        <!-- Card -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                {{-- Replace this with your logo image if needed --}}
                <a href="#" class="h1 font-weight-bold text-uppercase" style="letter-spacing: 1px;">
                    CSWDO
                </a>
                <p class="mt-1 mb-0" style="font-size: 14px; color: #6c757d;">City Social Welfare and Development Office</p>
            </div>

            <div class="card-body">
                <p class="login-box-msg font-weight-bold">Forgot your password?</p>
                <p class="text-muted mb-4" style="font-size: 14px;">Enter your email address to receive a password reset link.</p>

                @include('_message')

                <form action="{{ url('forgot-password') }}" method="post">
                    {{ csrf_field() }}
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" required name="email" placeholder="Enter your email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row align-items-center">
                        <div class="col-6">
                            <a href="{{ url('') }}" class="btn btn-link">← Back to Login</a>
                        </div>
                        <div class="col-6 text-right">
                            <button type="submit" class="btn btn-primary">Send Link</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="{{ url('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ url('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ url('dist/js/adminlte.min.js') }}"></script>
</body>

</html>