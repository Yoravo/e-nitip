<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Nitip</title>
    <link rel="icon" href="{{ asset('asset/media/e-nitip/e-nitip-favicon-red.png') }}" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <!-- Navbar Section -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom border-secondary rounded-bottom-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('welcome') }}">
                <img src="{{ asset('asset/media/e-nitip/e-nitip-high-resolution-logo-red.png') }}" alt="E-Nitip Logo" class="img-fluid" style="max-height: 60px;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    @if (Auth::check() && Auth::user()->role == 'admin')
                        <li class="nav-item">
                            <a class="nav-link text-white bg-danger" href="{{ route('admin.dashboard') }}">
                                Dashboard
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- Locker Layout Section -->
    <div class="container-fluid mt-1">
        <h3 class="text-center text-danger mb-1">Denah Locker</h3>

        <div class="card border-0">
            <div class="card-body">
            <!-- Create 10x10 Locker Grid -->
            <div class="container">
                <div class="row justify-content-center">
                @foreach ($lockers as $index => $item)
                    <!-- Every 10 items, start a new row -->
                    @if ($index % 10 === 0 && $index != 0)
                </div>
                <div class="row justify-content-center">
                @endif
                <div class="col-1 p-0">
                    <!-- Card within a card for compact layout -->
                    <div class="text-center">
                    <div class="p-1">
                        <a href="#" onclick="event.preventDefault()"
                        class="btn locker {{ $item->is_available ? 'btn-secondary' : 'btn-danger' }} w-100">
                        {{ $item->locker_code }}
                        </a>
                    </div>
                    </div>
                </div>
                @endforeach
                </div>
            </div>
            </div>
        </div>

        <!-- Clear Legend Section -->
        <div class="mt-2 d-flex justify-content-center">
            <div class="d-flex align-items-center mx-4">
                <button class="btn btn-secondary" style="width: 40px; height: 40px;"></button>
                <span class="ms-2 text-dark">Kosong</span>
            </div>
            <div class="d-flex align-items-center mx-4">
                <button class="btn btn-danger" style="width: 40px; height: 40px;"></button>
                <span class="ms-2 text-dark">Terisi</span>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
