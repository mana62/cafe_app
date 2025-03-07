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
        @php
            $total = $order->products->sum(fn($product) => $product->price * $product->pivot->quantity);
        @endphp

        <p id="amount" class="payment-input">合計：¥{{ number_format($total) }}円</p>

        <div class="items">
        <p>商品：</p>
            <div>
        @foreach($order->products as $product)
                <p><input type="checkbox" class="item-checkbox" value="{{ $product->id }}" checked disabled>
                {{ $product->name }} (¥{{ number_format($product->price) }})</p>
        @endforeach
            </div>
    </div>

        <div class="card-element-form" id="card-element"></div>

        <input type="hidden" id="order_id" value="{{ $order->id }}">
        <input type="hidden" id="client_secret" value="{{ $client_secret ?? '' }}">

        <button class="payment__button-submit" type="submit">支払う</button>
    </form>
@endsection

@section('js')
    <script src="https://js.stripe.com/v3/"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        window.stripePublicKey = "{{ env('STRIPE_KEY') }}";
    </script>

    <script src="{{ asset('js/payment_stripe.js') }}"></script>
@endsection