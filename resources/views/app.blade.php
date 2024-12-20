<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ordering System</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('images/cotton.png') }}">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">

</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a href="{{ Auth::check() ? route('home') : '/' }}">
                <img src="{{ asset('images/kendy.png') }}" alt="Logo" width="60" height="60" class="img-fluid">
            </a>

            <a class="navbar-brand" href="{{ url('/') }}"> Kendy Corner</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/cart') }}">
                            <i class="bi bi-bag">
                                <span class="badge">
                                    @php
                                        use Illuminate\Support\Facades\Auth;
                                        $user = Auth::user();

                                        $totalQuantity = \App\Models\OrderItem::whereHas('order', function ($query) use ($user) {
                                            $query->where('user_id', $user->id)
                                                ->where('order_status', 'cart');
                                        })->sum('quantity');
                                    @endphp

                                    {{ $totalQuantity }}
                                </span>
                            </i>
                        </a>
                    </li>
                    @if(Auth::check())
                        <li class="nav-item">
                            <span class="nav-link welcome-message">
                                Welcome back, <strong>{{ Session::get('first_name') }}</strong>
                            </span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('profile.show') }}">
                                <i class="bi bi-person-circle" style="font-size: 1.2rem;"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/register') }}">Sign up</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        @yield('content')
    </div>

    <footer class="footer text-white py-4 mt-5">
        <div class="container text-center">
            <p>&copy; 2024 Kendy Corner. All Rights Reserved.</p>
            <p><a href="{{ url('/privacy') }}" class="text-white">Privacy Policy</a> | <a href="{{ url('/terms') }}" class="text-white">Terms of Service</a></p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>

</html>