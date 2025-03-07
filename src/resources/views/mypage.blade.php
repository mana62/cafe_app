@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
    <div class="mypage-container">
        <div class="flex__ttl">
            <h1>ようこそ、<span>{{ $user->name }}さん</span></h1>
            <div class="flex__img">
                <img src="{{ asset('img/flower1.jpeg') }}" alt="">
            </div>
        </div>

        <div class="message">
            @if (session('success'))
                <div class="message-session">
                    {{ session('success') }}
                </div>
            @endif
        </div>

        <div class="mypage-tabs">
            <button class="tab-btn active" onclick="showTab('profile')">ユーザー情報</button>
            <button class="tab-btn" onclick="showTab('orders')">購入履歴</button>
            <button class="tab-btn" onclick="showTab('favorites')">お気に入り</button>
            <button class="tab-btn" onclick="showTab('reviews')">レビュー一覧</button>
            <button class="tab-btn" onclick="showTab('address')">配送先情報</button>
        </div>

        <div class="mypage-content">
            <div id="profile" class="tab-content active">
                <div class="section-container user-info">
                    <div class="flex">
                        <h2 class="section-title">ユーザー情報</h2>
                        <div class="change-info">
                            <a href="javascript:void(0);" onclick="toggleEdit('user-info')">ユーザー情報を編集</a>
                        </div>
                    </div>

                    <div class="info-text" id="user-info-display">
                        <p><span class="label">名 前</span> <span>{{ $user->name }}</span></p>
                        <p><span class="label">メール</span> <span>{{ $user->email }}</span></p>
                        <p><span class="label">登録日</span> <span>{{ $user->created_at->format('Y年m月d日') }}</span></p>
                    </div>

                    <div class="edit-form" id="user-info-edit" style="display: none;">
                        <form action="{{ route('user.update', ['id' => $user->id]) }}" method="POST">
                            @csrf
                            <label>名 前</label>
                            <input type="text" name="name" value="{{ $user->name }}">

                            <label>メール</label>
                            <input type="email" name="email" value="{{ $user->email }}">

                            <div class="edit-buttons">
                                <button type="submit">保存</button>
                                <button type="button" onclick="toggleEdit('user-info')">キャンセル</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div id="orders" class="tab-content">
                <div class="section-container order-info">
                    <h2 class="section-title">購入履歴</h2>
                    @if ($orders->count() > 0)
                        <ul class="item-list order-ul">
                            @foreach ($orders as $order)
                                @foreach ($order->products as $product)
                                    <li class="order-li">
                                        <img src="{{ asset('img/' . $product->image_path) }}" alt="">
                                        <div class="items">
                                            <p><span class="order-label">注文ID</span><span>{{ $order->id }}</span></p>
                                            <p><span class="order-label">商品</span><span>{{ $product->name }}</span></p>
                                            <p><span class="order-label">注文日</span><span>{{ $order->created_at->format('Y年m月d日') }}</span></p>
                                        </div>
                                    </li>
                                @endforeach
                            @endforeach
                        </ul>
                    @else
                        <p>購入履歴はありません</p>
                    @endif
                </div>
            </div>

            <div id="favorites" class="tab-content">
                <div class="section-container favorite-info">
                    <h2 class="section-title">お気に入り</h2>
                    @if ($favorites->count() > 0)
                        <ul class="item-list favorite-ul">
                            @foreach ($favorites as $favorite)
                                <li class="favorite-li">
                                    <img src="{{ asset('img/' . $favorite->product->image_path) }}" alt="{{ $favorite->product->name }}">
                                    <div class="items">
                                        <p>{{ $favorite->product->name }}</p>
                                        <a href="{{ route('product.detail', $favorite->product->id) }}">詳細を見る</a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>お気に入り商品はありません</p>
                    @endif
                </div>
            </div>

            <div id="reviews" class="tab-content">
                <div class="section-container review-info">
                    <h2 class="section-title">レビュー一覧</h2>

                    @if ($reviews->count() > 0)
                        <ul class="item-list review-ul">
                            @foreach ($reviews as $review)
                                <li class="review-li">
                                    <img src="{{ asset('img/' . $review->product->image_path) }}" alt="">
                                    <div class="items">
                                        <p><span class="review-label">商品</span> <span>{{ $review->product->name }}</span></p>
                                        <p><span class="review-label">評価</span> <span>{{ $review->rating }}</span></p>
                                        <p><span class="review-label">コメント</span> <span>{{ $review->comment }}</span></p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>投稿したレビューはありません</p>
                    @endif
                </div>
            </div>

            <div id="address" class="tab-content">
                <div class="section-container address-info">
                    <div class="flex">
                        <h2 class="section-title">配送先情報</h2>
                        <div class="change-address">
                            <a href="javascript:void(0);" onclick="toggleEdit('address')">配送先を編集</a>
                        </div>
                    </div>

                    <div class="info-text" id="address-display">
                        <p><span class="label">郵便番号</span> <span>{{ $address->postal_code ?? '' }}</span></p>
                        <p><span class="label">住所</span> <span>{{ $address->address ?? '' }}</span></p>
                        <p><span class="label">建物名</span> <span>{{ $address->building ?? '' }}</span></p>
                    </div>

                    <div class="edit-form" id="address-edit" style="display: none;">
                        <form action="{{ route('address.update', ['id' => $user->id]) }}" method="POST">
                            @csrf
                            <label>郵便番号</label>
                            <input type="text" name="postal_code" value="{{ $address->postal_code ?? '' }}">

                            <label>住所</label>
                            <input type="text" name="address" value="{{ $address->address ?? '' }}">

                            <label>建物名</label>
                            <input type="text" name="building" value="{{ $address->building ?? '' }}">

                            <div class="edit-buttons">
                                <button type="submit">保存</button>
                                <button type="button" onclick="toggleEdit('address')">キャンセル</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('js/mypage.js') }}"></script>
@endsection