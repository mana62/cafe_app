@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/verify-email.css') }}">
@endsection

@section('content')
    <div class="verify-email">
        <h1 class="verify-email__ttl">メールアドレスの確認が必要です</h1>
        <p class="verify-email__text">登録したメールアドレスに確認メールを送信しました</p>
        <p class="verify-email__text">リンクをクリックして確認を完了してください</p>
        <form class="verify-email__form" method="POST" action="{{ route('verification.send') }}">
            @csrf
            <div class="verify-email__button">
                <button class="verify-email__button-submit" type="submit">再送信</button>
            </div>
        </form>
    </div>
@endsection
