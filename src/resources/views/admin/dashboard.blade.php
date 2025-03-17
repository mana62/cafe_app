<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <a href="{{ route('product') }}" class="header__logo"><span class="header__logo-span">Café</span>Lumière</a>
            <nav class="nav">
                <ul class="nav__list">
                    <li class="nav__item"><a href="#" class="nav__link" onclick="showSection('user')">ユーザー管理</a></li>
                    <li class="nav__item"><a href="#" class="nav__link" onclick="showSection('product')">商品管理</a></li>
                    <li class="nav__item"><a href="#" class="nav__link" onclick="showSection('new')">New商品</a></li>
                    <li class="nav__item"><a href="#" class="nav__link" onclick="showSection('order')">注文管理</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="content">
        <h1>Admin Dashboard</h1>

        <!-- ユーザー管理 -->
        <div id="user" class="admin-section">
            <h2>ユーザー管理</h2>
            <table>
                <tr>
                    <th>NO</th>
                    <th>ユーザー名</th>
                    <th>メールアドレス</th>
                    <th>登録日</th>
                    <th></th>
                </tr>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user['name'] }}</td>
                        <td>{{ $user['email'] }}</td>
                        <td>{{ $user->created_at->format('Y-m-d') }}</td>
                        <td>
                            <form action="{{ route('admin.users.delete', $user->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit">削除</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
            <div class="pagination">
                {{ $users->links('vendor.pagination.tailwind') }}
            </div>
        </div>

        <!-- 商品管理 -->
        <div id="product" class="admin-section" style="display: none;">
            <h2>商品管理</h2>
            <table>
                <tr>
                    <th>NO</th>
                    <th>商品画像</th>
                    <th>商品名</th>
                    <th>価格</th>
                    <th></th>
                    <th></th>
                </tr>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><img src="{{ asset('img/' . $product->image_path) }}" width="50"></td>
                        <td>{{ $product['name'] }}</td>
                        <td>{{ floor($product['price']) }}円</td>                        <td>
                            <form action="{{ route('admin.products.update', $product->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="text" name="name" value="{{ $product->name }}">
                                <input type="number" name="price" value="{{ $product->price }}">
                                <div>
                                <button type="submit">編集</button>
                            </div>
                            </form>
                        </td>
                        <td>
                            <form action="{{ route('admin.products.delete', $product->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit">削除</button>
                        </td>
                    </tr>
                @endforeach
            </table>
            <div class="pagination">
                {{ $products->links('vendor.pagination.tailwind') }}
            </div>
        </div>

            <div id="new" class="admin-section" style="display: none;">
            <h2>新しい商品を追加</h2>
            <form action="{{ route('admin.products.store') }}" method="POST">
                @csrf
                <input type="text" name="name" placeholder="商品名">
                <input type="file" name="image">
                <input type="number" name="price" placeholder="価格">
                <button type="submit">追加</button>
            </form>
            <div class="pagination">
                {{ $products->links('vendor.pagination.tailwind') }}
            </div>
        </div>

        <!-- 注文管理 -->
        <div id="order" class="admin-section" style="display: none;">
            <h2>注文管理</h2>
            <table>
                <tr>
                    <th>NO</th>
                    <th>注文ID</th>
                    <th>ユーザー名</th>
                    <th>商品名</th>
                    <th>注文日</th>
                    <th>ステータス</th>
                </tr>
                @foreach ($orders as $order)
                    @foreach ($order->products as $product)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->user->name }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $order->created_at->format('Y-m-d') }}</td>
                            <td>{{ $order->status }}</td>
                        </tr>
                    @endforeach
                @endforeach
            </table>
            <div class="pagination">
                {{ $orders->links('vendor.pagination.tailwind') }}
            </div>
        </div>
    </div>
    </main>

    <script>
        function showSection(section) {
            document.querySelectorAll('.admin-section').forEach(el => el.style.display = 'none');
            document.getElementById(section).style.display = 'block';
        }
    </script>
</body>
</html>
