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
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
</head>

<body>
    <div class="container">
        <div class="whitebox">
            <div class="pinkbox">

                {{-- 新規登録フォーム --}}
                <div class="signup nodisplay">
                    <h1 class="signup__ttl">register</h1>
                    <form action="{{ route('register') }}" method="POST" class="signup__form">
                        @csrf
                        <input type="text" name="name" placeholder="username">
                        <input type="email" name="email" placeholder="email">
                        <input type="password" name="password" placeholder="password">
                        <button type="button" class="toggle_password register" data-target="password"><img src="{{ asset('img/icon/lock_open.png')}}" alt=""></button>

                        <input type="password" name="password_confirmation" placeholder="confirm password">
                        <button type="button" class="toggle_password confirm_register" data-target="password"><img src="{{ asset('img/icon/lock_open.png')}}" alt=""></button>

                        <button class="button submit">CREATE ACCOUNT</button>
                    </form>
                </div>
                {{-- ログインフォーム --}}
                <div class="signin">
                    <h1 class="signin__ttl">sign in</h1>
                    <form action="{{ route('login') }}" method="POST" class="signin__form">
                        @csrf
                        <input type="email" name="email" placeholder="email">
                        <input type="password" placeholder="password">
                        <button type="button" class="toggle_password login" data-target="password"><img src="{{ asset('img/icon/lock_open.png')}}" alt=""></button>

                        <div class="checkbox">
                            <input type="checkbox" id="remember" /><label for="remember" class="signin__label">remember
                                me</label>
                        </div>

                        <button type="submit" class="button submit">LOGIN</button>
                    </form>
                </div>
            </div>
            <div class="leftbox">
                <h2 class="title"><span>Café</span>Lumière</h2>
                <p class="text">Savourons <span>chaque instant</span></p>
                <img class="cake1 img" src="{{ asset('img/pan-cake.jpeg') }}" alt="1357d638624297b" border="0">
                <p class="account">have an account?</p>
                <button class="button" id="signin">LOGIN</button>
            </div>
            <div class="rightbox">
                <h2 class="title"><span>Café</span>Lumière</h2>
                <p class="text"> Savourons <span>chaque instant</span></p>
                <img class="cake2 img" src="{{ asset('img/cup-cake.jpeg') }}" alt="1357d638624297b" border="0">
                <p class="account">don't have an account?</p>
                <button class="button" id="signup">SIGN UP</button>
            </div>
        </div>
    </div>

    </div>
    <script src="{{ asset('js/auth.js') }}"></script>
</body>

</html>
