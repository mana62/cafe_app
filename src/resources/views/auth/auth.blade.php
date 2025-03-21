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
                <div class="signup {{ old('register') ? '' : 'nodisplay' }}">
                    <h1 class="signup__ttl">Register</h1>
                    <form action="{{ route('register') }}" method="POST" class="signup__form">
                        @csrf
                        <input type="hidden" name="register" value="1">
                        <input type="text" name="name" placeholder="username" value="{{ old('name') }}">

                        <div class="error">
                            @error('name')
                                <p class="error__message">{{ $message }}</p>
                            @enderror
                        </div>

                        <input type="email" name="email" placeholder="email"
                            value="{{ old('register') ? old('email') : '' }}">

                        <div class="error">
                            @error('email')
                                <p class="error__message">{{ $message }}</p>
                            @enderror
                        </div>

                        <input type="password" name="password" placeholder="password">
                        <button type="button" class="toggle_password register" data-target="password"><img
                                src="{{ asset('img/icon/lock_open.png') }}" alt=""></button>

                        <div class="error">
                            @error('password')
                                <p class="error__message">{{ $message }}</p>
                            @enderror
                        </div>

                        <input type="password" name="password_confirmation" placeholder="confirm password">
                        <button type="button" class="toggle_password confirm_register" data-target="password"><img
                                src="{{ asset('img/icon/lock_open.png') }}" alt=""></button>
                        <button type="submit" class="button submit">CREATE ACCOUNT</button>
                    </form>
                </div>

                {{-- ログインフォーム --}}
                <div class="signin {{ old('register') ? 'nodisplay' : '' }}">
                    <h1 class="signin__ttl">Sign in</h1>
                    <form action="{{ route('login') }}" method="POST" class="signin__form">
                        @csrf
                        <input type="hidden" name="register" value="0">
                        <input type="email" name="email" placeholder="email"
                            value="{{ old('register') ? '' : old('email') }}">

                        <div class="error">
                            @error('email')
                                <p class="error__message">{{ $message }}</p>
                            @enderror
                        </div>

                        <input type="password" name="password" placeholder="password">
                        <button type="button" class="toggle_password login" data-target="password"><img
                                src="{{ asset('img/icon/lock_open.png') }}" alt=""></button>

                        <div class="error">
                            @error('password')
                                <p class="error__message">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="button submit">LOGIN</button>
                    </form>
                    <div class="admin-link">
                        <a href="{{ route('admin.login') }}">管理者の方はこちら</a>
                    </div>
                </div>
            </div>

            {{-- 背景部分 --}}
            <div class="leftbox">
                <h2 class="title"><span>Café</span>Lumière</h2>
                <p class="text">Savourons <span>chaque instant</span></p>
                <img class="cake1 img" src="{{ asset('img/pan-cake.jpeg') }}" alt="1357d638624297b" border="0">
                <p class="account">have an account?</p>
                <p class="link"><a href="{{ route('product') }}">show all menu</a></p>
                <button class="button" id="signin">LOGIN</button>
            </div>
            <div class="rightbox">
                <h2 class="title"><span>Café</span>Lumière</h2>
                <p class="text"> Savourons <span>chaque instant</span></p>
                <img class="cake2 img" src="{{ asset('img/cup-cake.jpeg') }}" alt="1357d638624297b" border="0">
                <p class="account">don't have an account?</p>
                <p class="link"><a href="{{ route('product') }}">show all menu</a></p>
                <button class="button" id="signup">SIGN UP</button>
            </div>
        </div>
    </div>

    </div>
    <script src="{{ asset('js/auth.js') }}"></script>
</body>

</html>
