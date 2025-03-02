<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Café Lumière</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Playwrite+IT+Moderna:wght@100..400&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    @yield('css')
</head>
<body>
    <header class="header">
        <div class="header__inner">
            <a href="" class="header__logo"><span class="header__logo-span">Café</span>Lumière</a>

        <nav class="nav">
            <ul class="nav__list">
                <li class="nav__item"><a href="{{ route('home') }}" class="nav__link">Home</a></li>
                <li class="nav__item"><a href="{{ route('product') }}" class="nav__link">Menu</a></li>
                <li class="nav__item"><a href="{{ route('contact') }}" class="nav__link">Contact</a></li>
                @guest
                    <li class="nav__item"><a href="{{ route('login') }}" class="nav__link">Login</a></li>
                    <li class="nav__item"><a href="{{ route('register') }}" class="nav__link">Register</a></li>
                @endguest
                @auth
                <li class="nav__item"><a href="" class="nav__link">Mypage</a></li>
                    <li class="nav__item">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="nav__link">Logout</button>
                        </form>
                    </li>
                @endauth
            </ul>
        </div>
    </header>

        <main class="main">
            @yield('content')
        </main>

        <footer class="footer">
            <div class="footer__inner">
                <small class="footer__copy">© 2021 Café Lumière</small>
            </div>
        </footer>

        @yield('js')
</body>
</html>