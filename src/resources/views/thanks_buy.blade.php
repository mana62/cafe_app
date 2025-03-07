@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/thanks_buy.css') }}">
@endsection

@section('content')
    <div class="content">
        <p class="content__message">ご購入ありがとうございます</p>
        @if (session('paymentMethod') === 'クレジットカード')
            <p class="card-payment__message">お支払いが完了しました</p>
        @elseif (session('paymentMethod') === 'コンビニ払い')
            <p class="card-payment__message">お支払いの確認が取れ次第、発送いたします</p>
        @endif
        <div class="mypage__link">
            <a href="{{ route('mypage') }}">マイページへ戻る</a>
        </div>
    </div>
@endsection
