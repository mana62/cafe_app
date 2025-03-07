@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
@endsection

@section('content')
    <div class="content">

        <div class="message">
            @if (session('success'))
                <div class="message-session">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="message-session error">
                    {{ session('error') }}
                </div>
            @endif
        </div>

        <table class="cart__table">
            <tr>
                <th>No</th>
                <th>Image</th>
                <th>Item</th>
                <th>Number Of Pieces</th>
                <th>Delete</th>
            </tr>
            @forelse ($carts as $cart)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><img src="{{ asset('img/' . $cart->product->image_path) }}" alt="" class="td__img"></td>
                    <td>{{ $cart->product->name }}</td>
                    <td>
                        <form action="{{ route('cart.update', ['id' => $cart->id]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="cart_id" value="{{ $cart->id }}">
                            <input type="number" name="quantity" value="{{ $cart->quantity }}" min="1" required>
                            <button type="submit" class="item__update">個数を変更</button>
                        </form>

                        @error('quantity')
                            <p class="error__message">{{ $message }}</p>
                        @enderror
                    </td>
                    <td>
                        <form action="{{ route('cart.delete', $cart->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="item__delete">削除</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">カートは空です</td>
                </tr>
            @endforelse
        </table>

        <div class="contact__button-purchase">
            <a href="{{ route('checkout') }}" class="contact__button-submit">購入画面へ</a>
        </div>
    </div>
@endsection
