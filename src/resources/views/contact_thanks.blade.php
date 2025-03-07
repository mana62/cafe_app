@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/contact_thanks.css') }}">
@endsection

@section('content')
    <div class="content">
        <h1 class="content__title">お問い合わせありがとうございました </h1>
        <p class="content__description">
            お問い合わせいただきありがとうございます<br>
            お問い合わせ内容を確認のうえ、回答させていただきます<br>
            今しばらくお待ちください
        </p>
        <div class="content__img">
            <img src="{{ asset('img/items5.png') }}" alt="">
        </div>
    </div>
@endsection
