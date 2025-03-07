@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/product_detail.css') }}">
@endsection

@section('content')
    <article class="item-detail">
        <div class="box">

            <div class="message">
                @if (session('success'))
                    <div class="message-session">
                        {{ session('success') }}
                    </div>
                @endif
            </div>

            <div class="message">
                @if (session('error'))
                    <div class="message-session">
                        {{ session('error') }}
                    </div>
                @endif
            </div>
    
            <div class="item-detail__card">
                <!-- 📌 左側（商品画像） -->
                <figure class="item-detail__img">
                    <img src="{{ asset('img/' . $product->image_path) }}" alt="{{ $product->name }}">
                </figure>

                <!-- 📌 右側（商品情報 + レビュー） -->
                <div class="item-detail__info">
                    <h1 class="item-detail-title">Item</h1>

                    <header class="item-detail__header">
                        <h2>{{ $product->name }}</h2>
                    </header>

                    <p class="liked-text">
                        お気に入りに追加
                        <span id="liked-btn-{{ $product->id }}"
                            class="liked-btn {{ $product->favorites->contains('product_id', $product->id) ? 'liked' : '' }}"
                            data-product-id="{{ $product->id }}">
                            &hearts;
                        </span>
                    </p>

                    <section class="item-detail__price">
                        <p><strong>¥{{ number_format($product->price) }}</strong></p>
                    </section>

                    <section class="item-detail__description">
                        <p>{{ $product->description }}</p>
                    </section>

                    <h2 class="item-detail-title">Cart</h2>
                    <div class="item-detail__cart">
                        <!-- 📌 数量選択フォーム -->
                        <form action="{{ route('cart.add', ['id' => $product->id]) }}" method="POST" class="cart-form">
                            @csrf
                            <input type="number" name="quantity" min="1" value="1" class="cart-quantity">
                            <button type="submit" class="contact__button-submit">カートに追加</button>
                        </form>
                    </div>
                    <div class="item-detail__cart-link">
                            <a href="{{ route('cart') }}">カートを見る</a>
                        </div>

                    <div class="item-detail__review">
                        <h2 class="item-detail-title">Review</h2>
                        <!-- 📌 レビュー投稿フォーム -->
                        <form action="{{ route('reviews.store', $product->id) }}" method="POST" class="review-form">
                            @csrf
                            <div class="review__content-rating">
                                <div class="review__stars">
                                    <label data-value="1">★</label>
                                    <label data-value="2">★</label>
                                    <label data-value="3">★</label>
                                    <label data-value="4">★</label>
                                    <label data-value="5">★</label>
                                </div>
                                <input type="hidden" name="rating" id="rating-value">
                            </div>
                            <div class="error">
                                @error('rating')
                                    <p class="error__message">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex">
                                <textarea name="comment" rows="6" cols="60" placeholder="レビューを入力してください"></textarea>
                                <button type="submit" class="contact__button-submit">レビューを投稿</button>
                            </div>
                            <div class="error">
                                @error('comment')
                                    <p class="error__message">{{ $message }}</p>
                                @enderror
                            </div>
                        </form>

                        <!-- 📌 レビューリスト -->
                        @if ($product->reviews->count() > 0)
                            <ul>
                                @foreach ($product->reviews as $review)
                                    <li class="review-item">
                                        <div>
                                            <p class="review-user">{{ $review->user->name }} <span>さんの投稿</span></p>
                                            <span class="review-stars">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <span class="{{ $i <= $review->rating ? 'selected' : '' }}">★</span>
                                                @endfor
                                                <p class="review-comment">{{ $review->comment }}</p>
                                            </span>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="no-review">まだレビューはありません</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        </div>
        <div class="contact__button-purchase">
            <a href="{{ route('checkout') }}" class="contact__button-submit">購入画面へ</a>
        </div>
    </article>
@endsection

@section('js')
    <script src="{{ asset('js/product_detail.js') }}"></script>
@endsection
