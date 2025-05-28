@extends('layouts.app')

@section('title', '来店確認結果')

@section('content')
<div class="verify-result">
    <h2>{{ $message }}</h2>
    <a href="{{ route('owner.dashboard') }}">← ダッシュボードに戻る</a>
</div>
@endsection
