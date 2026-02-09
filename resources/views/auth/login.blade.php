<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CSWDO | Login</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700&display=fallback">
    <link rel="stylesheet" href="{{ url('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ url('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('dist/css/adminlte.min.css') }}">

    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            font-family: 'Source Sans Pro', sans-serif;
            /* This is the "cool" color from your target image. */
            background-color: #F0F7F6;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            overflow: hidden;

        }
        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1; /* Sits behind the card */

            /* 1. This adds your Panabo image */
            background-image: url("{{ asset('dist/img/panabo-bg3.jpg') }}"); /* <-- YOUR NEW IMAGE */
            background-size: cover;
            background-position: center;
            /* 2. This applies the "hint of grey" AND the new blur effect */
            filter: grayscale(30%) opacity(0.6) blur(1px);
            /* 2. This applies the "hint of grey" effect */

        }


        /* This is the main card that holds everything */
        .login-card-container {
            display: flex;
            width: 1000px;
            max-width: 1000px; /* <-- THIS MAKES IT WIDE */
            min-height: 500px; /* This gives it shape */
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            overflow: hidden; /* To keep the image corners rounded */
            position: relative;
            z-index: 2;
        }

        /* 1. The Left-Side Image Panel (INSIDE the card) */
.card-image-panel {
    flex-basis: 50%;

    /* This points to the image you just added */
    background-image: url("{{ asset('dist/img/panabo-bg1.jpg') }}");

    background-size: cover;
    background-position: center;
}

        /* 2. The Right-Side Form Panel */
        .card-form-panel {
            flex-basis: 50%;
            padding: 2.5rem;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-logo img {
            width: 70px;
            margin-bottom: 1rem;
        }

        .login-header h2 {
            font-weight: 600;
            font-size: 1.5rem;
            color: #333;
            margin-bottom: 0.25rem;
        }

        .login-header p {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
        }

        /* 3. Form Styles */
        .input-group .form-control {
            height: 45px;
            font-size: 0.95rem;
            border-radius: 8px !important;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            box-shadow: none;
            padding-right: 2.5rem; /* Space for icon */
        }

        .input-group.mb-3 { position: relative; }
        .input-group-append {
            position: absolute;
            right: 0;
            top: 0;
            height: 100%;
            display: flex;
            align-items: center;
            z-index: 10;
        }
        .input-group-text {
            background-color: transparent;
            border: none;
            padding-right: 1rem;
            color: #6c757d;
        }

        /* 4. Button */
        .btn-cswdo {
            background-color: #1D4FA1;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 0.65rem;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.2s ease;
        }
        .btn-cswdo:hover {
             background-color: #174283;
             color: #fff;
        }

        /* 5. Links */
        .login-links {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }
        .login-links a { color: #1D4FA1; }
        .login-links .icheck-primary label { font-weight: 400; }

        /* 6. Responsive */
        @media (max-width: 768px) {
            body {
                align-items: flex-start;
                padding-top: 2rem;
            }
            .login-card-container {
                flex-direction: column;
                width: 90%;
                max-width: 420px;
                min-height: 0;
            }
            .card-image-panel {
                display: none; /* Hide image panel on mobile */
            }
            .card-form-panel {
                flex-basis: 100%;
                padding: 2rem;
            }
        }
    </style>
</head>

<body>

    <div class="login-card-container">

        <div class="card-image-panel">
            </div>

        <div class="card-form-panel">
            <div class="login-logo">
                <img src="{{ asset('dist/img/CSWD.png') }}" alt="CSWDO Logo">
            </div>
            <div class="login-header">
                <h2>City Social Welfare and Development Office</h2>
                <p>Panabo City</p>
            </div>

            @include('_message')

            <form action="{{ url('login') }}" method="POST">
                @csrf

                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                    <div class="input-group-append">
                        <div class="input-group-text"><i class="fas fa-envelope"></i></div>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                    <div class="input-group-append">
                        <div class="input-group-text"><i class="fas fa-lock"></i></div>
                    </div>
                </div>

                <div class="login-links">
                    <div class="icheck-primary d-inline">
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember"> Remember Me </label>
                    </div>
                    <a href="{{ url('forgot-password') }}" class="float-right">Forgot password?</a>
                </div>

                <button type="submit" class="btn btn-cswdo btn-block mb-3">Log in</button>
            </form>


        </div>
    </div>

    <script src="{{ url('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ url('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ url('dist/js/adminlte.min.js') }}"></script>

</body>

</html>