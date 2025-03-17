@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/checkout.css') }}">
@endsection

@section('content')
    <div class="content">
        <h1>購入画面</h1>

        <form action="{{ route('order.store') }}" method="POST">
            @csrf
            <table class="content__table">
                <tbody>
                    {{-- 初期値を0に設定 --}}
                    @php $total = 0; @endphp
                    @foreach ($carts as $cart)
                        @php
                            $subtotal = $cart->product->price * $cart->quantity;
                            $total += $subtotal;
                        @endphp
                        <tr>
                            <th class="content__table-th">商品名</th>
                            <td class="content__table-th">{{ $cart->product->name }}</td>
                        </tr>
                        <tr>
                            <th>価格</th>
                            <td>¥{{ number_format($cart->product->price) }}</td>
                        </tr>
                        <tr>
                            <th>数量</th>
                            <td>{{ $cart->quantity }}</td>
                        </tr>
                        <tr>
                            <th>小計</th>
                            <td>¥{{ number_format($subtotal) }}</td>
                        </tr>
                        <input type="hidden" name="product_ids[]" value="{{ $cart->product->id }}">
                        <input type="hidden" name="quantities[]" value="{{ $cart->quantity }}">
                    @endforeach
                    <tr>
                        <th class="total">合計</th>
                        <td class="total">¥{{ number_format($total) }}</td>
                    </tr>
                    <tr>
                        <th class="table__th-pay">支払い方法</th>
                        <td class="table__th-pay">
                            <select name="payment_method" class="content__select" required>
                                <option value="">選択してください</option>
                                @foreach ($payment_methods as $payment)
                                    <option value="{{ $payment->payment_method }}">{{ $payment->payment_method }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="content__button">
                <button type="submit" class="content__button-submit">購入を確定する</button>
            </div>
        </form>
    </div>
@endsection