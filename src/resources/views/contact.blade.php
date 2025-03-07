@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/contact.css') }}">
@endsection

@section('content')
    <div class="contact">
      {{-- <div class="contact-img">
        <img src="{{ asset('img/ribbon2.jpeg') }}" alt="">
      </div> --}}
        <h1 class="contact__title">お問い合わせ</h1>
        <p class="contact__description">
            お問い合わせはこちらからどうぞ<br>
            ご意見・ご質問など、お気軽にお問い合わせください
        </p>
        <form action="{{ url('/contact/confirm') }}" method="POST" class="contact__form">
            @csrf
            <div class="contact__item">
                <label for="name" class="contact__form-label">お名前 <span class="contact__form-required">必須</span></label>
                <input type="text" id="name" name="name" class="contact__form-input" placeholder="例：山田 太郎" value="{{ old('name') }}" >
            </div>

            <div class="error">
                @error('name')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="contact__item">
                <label for="email" class="contact__form-label">メールアドレス <span class="contact__form-required">必須</span></label>
                <input type="email" id="email" name="email" class="contact__form-input" placeholder="例：example@email.com" value="{{ old('email') }}">
            </div>

            <div class="error">
                @error('email')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>


            <div class="contact__item">
                <label for="content" class="contact__form-label">お問い合わせ内容 <span class="contact__form-required">必須</span></label>
                <textarea id="content" name="content" class="contact__form-textarea" placeholder="お問い合わせ内容を入力してください">{{ old('content') }}</textarea>
            </div>

            <div class="error">
                @error('content')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>


            <div class="contact__button">
                <button type="submit" class="contact__button-submit">送信する</button>
            </div>
        </form>
    </div>
@endsection
