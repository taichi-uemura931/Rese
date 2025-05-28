@extends('layouts.app')

@section('title', 'マイページ')

<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">

@section('content')
<div class="mypage-container">
    <h2>{{ $user->name }}さん</h2>

    <div class="reservation-section">
        <h3>予約状況</h3>
        @if ($reservations->count())
            <div class="scroll-area">
                @foreach ($reservations as $reservation)
                <div class="reservation-card">
                    <p>Shop：{{ $reservation->restaurant->name }}</p>
                    <p>Date：{{ $reservation->date }}</p>
                    <p>Time：{{ $reservation->time }}</p>
                    <p>Number：{{ $reservation->number_of_people }}人</p>

                    <div class="reservation-actions">
                        <a href="{{ route('reservations.edit', $reservation->id) }}" class="edit-btn">予約内容の変更</a>
                        <a href="{{ route('mypage.verify', $reservation->id) }}" class="edit-btn">QRコードを表示する</a>
                        <a href="{{ route('restaurant.reviews', $reservation->restaurant->id) }}" class="edit-btn">レビューを見る</a>
                        @if ($reservation->visited)
                            <a href="{{ route('review.create', ['reservation_id' => $reservation->id]) }}" class="edit-btn">レビューを書く</a>
                        @endif
                        <form action="{{ route('reservations.cancel', $reservation->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="cancel-btn" onclick="return confirm('予約をキャンセルしますか？')">キャンセル</button>
                        </form>
                    </div>

                </div>
                @endforeach
            </div>
        @else
            <p>予約した店舗はありません</p>
        @endif
    </div>

    <div class="favorites-section">
        <h3>お気に入り店舗</h3>
        @if (auth()->user()->favorites->count())
            <div class="scroll-area">
                @foreach (auth()->user()->favorites as $restaurant)
                    <div class="shop-card">
                        <img src="{{ asset('storage/' . $restaurant->image) }}" alt="{{ $restaurant->name }}"  class="shop-img">
                        <p class="shop-name">{{ $restaurant->name }}</p>
                        <p class="shop-tag">
                            @foreach ($restaurant->areas as $area)
                                #{{ $area->name }}
                            @endforeach
                            @foreach ($restaurant->genres as $genre)
                                #{{ $genre->name }}
                            @endforeach
                        </p>
                        <a href="{{ route('shop.detail', $restaurant->id) }}" class="detail-btn">詳しくみる</a>
                    </div>
                @endforeach
            </div>
        @else
            <p>いいねした店舗はありません</p>
        @endif
    </div>
</div>
@endsection
