@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/payment_stripe.css') }}">
@endsection

@section('content')
    <h1 class="title">カード情報</h1>
    <div id="paymentMessage"></div>
    <div id="card-errors" class="payment-error"></div>

    <form id="paymentForm">
        @csrf
        {{-- 合計金額を計算 --}}
        @php
            // $product->price * $product->pivot->quantity → 単価 × 個数
            // sum(fn($product) => ... ) → すべての商品の合計を計算
            $total = $order->products->sum(fn($product) => $product->price * $product->pivot->quantity);
        @endphp

        {{-- number_format($total) → カンマ区切りで金額を表示 --}}
        <p id="amount" class="payment-input">合計：¥{{ number_format($total) }}円</p>

        {{-- 商品一覧の表示 --}}
        <div class="items">
            <p>商品：</p>
            <div>
                {{-- 注文した商品の一覧を表示 --}}
                @foreach ($order->products as $product)
                    {{-- checked disabled → すべてのチェックボックスを選択状態で固定（変更不可） --}}
                    <p><input type="checkbox" class="item-checkbox" value="{{ $product->id }}" checked disabled>
                        {{ $product->name }} (¥{{ number_format($product->price) }})</p>
                @endforeach
            </div>
        </div>

        {{-- Stripe決済の要素 --}}
        {{-- クレジットカード入力欄 (#card-element) を配置 --}}
        <div class="card-element-form" id="card-element"></div>

        {{-- Stripe用の client_secret と order_id をフォームに埋め込む --}}
        <input type="hidden" id="order_id" value="{{ $order->id }}">
        <input type="hidden" id="client_secret" value="{{ $client_secret ?? '' }}">
        <button class="payment__button-submit" type="submit">支払う</button>
    </form>
@endsection

@section('js')
    {{-- StripeのSDK を読み込む --}}
    <script src="https://js.stripe.com/v3/"></script>
    {{-- axios（HTTPリクエストライブラリ） をCDNから読み込む --}}
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        // 環境変数 STRIPE_KEY（公開鍵）をJavaScriptで使えるようにする
        window.stripePublicKey = "{{ env('STRIPE_KEY') }}";
    </script>

    <script src="{{ asset('js/payment_stripe.js') }}"></script>
@endsection
