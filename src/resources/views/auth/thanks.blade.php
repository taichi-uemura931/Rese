@extends('layouts.app')

@section('title', '会員登録完了')

@section('content')
<link rel="stylesheet" href="{{ asset('css/thanks.css') }}">

<div class="thanks-container">
    <h2>会員登録ありがとうございます</h2>
    <form action="{{ route('home') }}" method="GET">
        <button type="submit" class="thanks-btn">ログインする</button>
    </form>
</div>
@endsection
