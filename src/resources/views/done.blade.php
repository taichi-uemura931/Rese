@extends('layouts.app')

@section('title', '予約完了')

@section('content')
<link rel="stylesheet" href="{{ asset('css/done.css') }}">

<div class="done-container">
    <p class="done-message">ご予約ありがとうございます</p>
    <a href="{{ route('home') }}" class="back-button">戻る</a>
</div>
@endsection
