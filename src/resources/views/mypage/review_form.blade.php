@extends('layouts.app')

@section('title', 'レビュー投稿')

@section('content')
<link rel="stylesheet" href="{{ asset('css/review.css') }}">

<div class="review-container">
    <a href="{{ url()->previous() }}" class="back-btn">&lt;</a>
    <h2>{{ $reservation->restaurant->name }}へのレビュー</h2>

    @if ($alreadyReviewed)
        <p class="review-error">すでにレビュー済みです</p>
    @else
        <form action="{{ route('review.store', $reservation->id) }}" method="POST" class="review-form">
            @csrf

            <div class="form-group">
                <label for="rating">評価（1〜5）</label>
                <select name="rating" id="rating" required>
                    <option value="">選択してください</option>
                    @for ($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>
                            {{ $i }}
                        </option>
                    @endfor
                </select>
                @error('rating')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="comment">コメント（任意）</label>
                <textarea name="comment" id="comment" rows="5" placeholder="お店の感想など">{{ old('comment') }}</textarea>
                @error('comment')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="submit-btn">レビューを送信する</button>
        </form>
    @endif
</div>
@endsection
