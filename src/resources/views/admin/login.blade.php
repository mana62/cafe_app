<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="{{ asset('css/admin_login.css') }}">
</head>

<body>
    <div class="container">
        <h2>Admin Login</h2>
        <form method="POST" action="{{ route('admin.login') }}">
            @csrf
            <label>Email <input type="email" name="email" required></label><br>
            <label>Password <input type="password" name="password" required></label><br>
            <button type="submit">LOGIN</button>
        </form>
    </div>
</body>

</html>
