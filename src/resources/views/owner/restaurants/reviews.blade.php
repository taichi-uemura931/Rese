@extends('layouts.app')

@section('title', $restaurant->name . 'のレビュー')

<link rel="stylesheet" href="{{ asset('css/restaurant_reviews.css') }}">

@section('content')
    <div class="container">
        <a href="{{ url()->previous() }}" class="back-btn">&lt;</a>
        <h2>{{ $restaurant->name }}のレビュー一覧</h2>

        @if ($restaurant->reviews->isEmpty())
            <p class="no-review-message">この店舗にはまだレビューが</br>ありません</p>
        @else
            <ul class="review-list">
                @foreach ($restaurant->reviews as $review)
                    <li class="review-item">
                        <strong>{{ $review->user->name }}</strong> さん<br>
                        評価: {{ $review->rating }} / 5<br>
                        コメント: {{ $review->comment ?? '（コメントなし）' }}<br>
                        投稿日: {{ $review->created_at->format('Y年m月d日 H:i') }}
                    </li>
                    <hr>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
