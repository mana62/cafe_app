@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/product.css') }}">
@endsection

@section('content')
    <div class="product-list">
        <div class="product-list__header">
            <h1 class="product-list__title">Menu</h1>
            <form action="{{ route('product.search') }}" method="GET" class="product-list-search">
                <input type="text" name="product" value="{{ request('product') }}" placeholder="商品名を入力">
                <button type="submit">検索</button>
            </form>
        </div>

        <!-- エラーメッセージ -->
        <div class="error">
            @if (session('error'))
                <p class="error-message">{{ session('error') }}</p>
            @endif
        </div>

        <div class="product-list__grid">
            @if ($products->isEmpty())
                <p class="no-results">該当する商品がありません</p>
            @else
                @foreach ($products as $product)
                    <div class="product-card">
                        <img class="product-card__image" src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}">
                        <h2 class="product-card__name">{{ $product->name }}</h2>
                        <p class="product-card__price">¥{{ number_format($product->price) }}</p>
                        <p class="product-card__description">{{ $product->description }}</p>
                        <a href="{{ route('product.detail', ['id' => $product->id]) }}" class="detail-link">詳細はこちら</a>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="pagination">
            {{ $products->links('vendor.pagination.tailwind') }}
        </div>
    </div>
@endsection
