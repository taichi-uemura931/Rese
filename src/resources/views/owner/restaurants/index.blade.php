@extends('layouts.app')

@section('title', '店舗管理')

<link rel="stylesheet" href="{{ asset('css/owner_index.css') }}">

@section('content')
<div class="restaurant-index-container">
    <div class="title-group">
        <a href="{{ route('owner.dashboard') }}" class="back-btn">&lt;</a>
        <h2 class="page-title">あなたの店舗一覧</h2>
    </div>

    <div class="create-button-wrapper">
        <a href="{{ route('owner.restaurants.create') }}" class="create-btn">＋新規店舗を作成</a>
    </div>

    <div class="restaurant-card-list">
        @foreach ($restaurants as $restaurant)
            <div class="restaurant-card">
                <h3 class="restaurant-name">{{ $restaurant->name }}</h3>
                <p class="restaurant-overview">
                    {{ Str::limit($restaurant->overview, 100, '...') }}
                </p>
                <div class="restaurant-actions">
                    <a href="{{ route('owner.restaurants.edit', $restaurant->id) }}" class="action-btn">編集</a>
                    <a href="{{ route('owner.restaurants.reviews', $restaurant->id) }}" class="action-btn">レビューを見る</a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
