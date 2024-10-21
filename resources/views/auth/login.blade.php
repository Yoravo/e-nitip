<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - E-Nitip</title>
    <link rel="shortcut icon" href="{{ asset('asset/e-nitip-favicon-red.png') }}">
    <!-- Bootstrap 5.3.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Google Fonts (Poppins for example) -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet">
</head>

<body style="font-family: 'Poppins', sans-serif;">

    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="row w-100" style="max-width: 800px;">
            <!-- Logo Section -->
            <div class="col-md-6 d-flex flex-column justify-content-center align-items-center order-md-2 mb-4 mb-md-0">
                <img src="{{ asset('asset/media/e-nitip/e-nitip-high-resolution-logo-red.png') }}" alt="E-Nitip Logo"
                    class="img-fluid mb-2" style="max-width: 100%; max-height: 200px;">
            </div>

            <!-- Login Form Section -->
            <div class="col-md-6 d-flex flex-column justify-content-center order-md-1">
                <h3 class="text-center text-danger fw-bold mb-4">LOGIN</h3>

                <!-- Error Alert -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Login Form -->
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label" :value="__('Email')">Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                            value="{{ old('email') }}" required autofocus>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label" :value="__('Password')">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>

                    <div class="mb-3 text-end">
                        <a href="{{ route('password.request') }}" class="text-primary">Forgot Password?</a>
                    </div>

                    <div class="d-grid col-6 mx-auto">
                        <button type="submit" class="btn btn-danger">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5.3.3 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
