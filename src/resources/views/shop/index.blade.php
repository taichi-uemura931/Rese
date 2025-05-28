@extends('layouts.app')

@section('title', 'トップページ')

<link rel="stylesheet" href="{{ asset('css/index.css') }}">

@section('header')
    <form action="{{ route('shop.search') }}" method="GET" class="search-container" id="search-form">
        <select name="area" onchange="document.getElementById('search-form').submit();">
            <option value="">All area</option>
            @foreach ($areas as $area)
                <option value="{{ $area->id }}" {{ request('area') == $area->id ? 'selected' : '' }}>
                    {{ $area->name }}
                </option>
            @endforeach
        </select>

        <select name="genre" onchange="document.getElementById('search-form').submit();">
            <option value="">All genre</option>
            @foreach ($genres as $genre)
                <option value="{{ $genre->id }}" {{ request('genre') == $genre->id ? 'selected' : '' }}>
                    {{ $genre->name }}
                </option>
            @endforeach
        </select>

        <input type="text" name="keyword" placeholder="Search ..." value="{{ request('keyword') }}">
    </form>
@endsection

@section('content')
    @if ($restaurants->isEmpty())
        <div class="no-result-message">
            お探しの飲食店が見つかりませんでした
        </div>
    @else
        <div class="shop-grid">
            @foreach ($restaurants as $restaurant)
                <div class="shop-card">
                    <img src="{{ asset('storage/' . $restaurant->image) }}" alt="{{ $restaurant->name }}" class="shop-img">
                    <div class="shop-info">
                        <p class="shop-name">{{ $restaurant->name }}</p>
                        <p class="shop-tag">
                            @foreach ($restaurant->areas as $area)
                                #{{ $area->name }}
                            @endforeach
                            @foreach ($restaurant->genres as $genre)
                                #{{ $genre->name }}
                            @endforeach
                        </p>
                    </div>
                    <div class="shop-actions">
                        <div class="action-buttons">
                            <a href="{{ route('shop.detail', $restaurant->id) }}" class="detail-btn">詳しくみる</a>
                            <a href="{{ route('restaurant.reviews', $restaurant->id) }}" class="review-btn">レビューを見る</a>
                        </div>
                        <div class="heart-form">
                            @auth
                                <button type="button" class="heart-btn {{ auth()->user()->favorites->contains($restaurant->id) ? 'liked' : '' }}"
                                        data-restaurant-id="{{ $restaurant->id }}">
                                    <i class="{{ auth()->user()->favorites->contains($restaurant->id) ? 'fas' : 'far' }} fa-heart"></i>
                                </button>
                            @else
                                <button type="button" class="heart-btn" onclick="alert('いいねするにはログインしてください')">
                                    <i class="far fa-heart"></i>
                                </button>
                            @endauth
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection

<script>
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.heart-btn').forEach(button => {
        button.addEventListener('click', async (e) => {
            e.preventDefault();

            const restaurantId = button.dataset.restaurantId;
            const icon = button.querySelector('i');
            const isLiked = button.classList.contains('liked');

            try {
                const response = await fetch(`/favorite/${restaurantId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                });

                if (!response.ok) throw new Error('通信エラー');

                if (isLiked) {
                    button.classList.remove('liked');
                    icon.classList.remove('fas');
                    icon.classList.add('far');
                } else {
                    button.classList.add('liked');
                    icon.classList.remove('far');
                    icon.classList.add('fas');
                }

            } catch (error) {
                console.error('いいね通信失敗:', error);
            }
        });
    });
});
</script>