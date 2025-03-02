@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/product.css') }}">
@endsection

@section('content')
    <div class="product-list">
        <h1 class="product-list__title">Menu</h1>
        <div class="product-list__grid">
            @foreach ($products as $product)
                <div class="product-card">
                    <img class="product-card__image" src="{{ asset('img/' . $product->image_path) }}" alt="">
                    <h2 class="product-card__name">{{ $product->name }}</h2>
                    <p class="product-card__price">¥{{ number_format($product->price) }}</p>
                    <p class="product-card__description">{{ $product->description }}</p>
                    <a href="" class="detail-link">詳細はこちら</a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
