@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/contact_confirm.css') }}">
@endsection

@section('content')
    <div class="content">
        <form action="{{ route('contact.store') }}" method="POST">
            @csrf
            <input type="hidden" name="name" value="{{ $contact['name'] }}" readonly>
            <input type="hidden" name="email" value="{{ $contact['email'] }}" readonly>
            <input type="hidden" name="content" value="{{ $contact['content'] }}" readonly>
            <table class="content__table">
                <tr>
                    <th>お名前</th>
                    <td>{{ $contact['name'] }}</td>
                </tr>
                <tr>
                    <th>メールアドレス</th>
                    <td>{{ $contact['email'] }}</td>
                </tr>
                <tr>
                    <th>お問い合わせ内容</th>
                    <td>{{ $contact['content'] ?? '' }}</td>
                </tr>
            </table>
            <div class="content__button">
                <button type="submit" class="content__button-submit">送信</button>
            </div>
        </form>
    </div>
@endsection
