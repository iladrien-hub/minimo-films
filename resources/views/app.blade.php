<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('public/assets/style/style.css') }}">
    <link
        href="https://fonts.googleapis.com/css2?family=Inconsolata&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap"
        rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" rel="stylesheet">
    <title>Minimø</title>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
        crossorigin="anonymous"></script>
</head>

<body>

    <header>
        <div class="container-wide">
            <div class="header-content">
                <a href="{{ route("welcome") }}" class="header-home">minimø</a>
                <nav class="header-menu">
                    <ul>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('search') }}">Search</a>
                        </li>
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="{{ route("home") }}" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>
                            </li>
                            <li>
                                <div>
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <section class="content" style="padding-bottom: 30px">
        @yield('content')
    </section>

    <footer>
        <div class="container-wide">
            <div class="footer-content">
                <div class="footer-menu">
                    <ul>
                        <li><a href="#">Privacy</a></li>
                        <li><a href="#">Terms and conditions</a></li>
                        @if(Auth::user() != null && Auth::user()->rights_level >= 1)
                            <li><a href="{{ route("admin") }}">To admin</a></li>
                        @endif
                    </ul>
                </div>
                <div class="footer-menu">
                    <ul>
                        <li>Follow</li>
                        <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                        <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                        <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

</body>

</html>
