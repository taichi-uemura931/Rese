@extends('layouts.app')

@section('title', 'メール認証')

@section('content')
<link rel="stylesheet" href="{{ asset('css/verify.css') }}">

<div class="verify-container">
    <h2>登録していただいたメールアドレスに認証メールを送付しました</h2>
    <p>メール内のリンクをクリックして、メール認証を完了してください。</p>

    @if (session('status') === 'verification-link-sent')
        <p class="resend-message">新しい確認リンクを送信しました。</p>
    @endif

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="verify-button">認証メールを再送する</button>
    </form>
</div>
@endsection
