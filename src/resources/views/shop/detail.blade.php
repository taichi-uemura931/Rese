@extends('layouts.app')

@section('title', $restaurant->name)

@section('content')
<link rel="stylesheet" href="{{ asset('css/shop_detail.css') }}">

<div class="shop-detail-container">
    <div class="left-panel">
        <div class="shop-image-section">
            <a href="{{ url()->previous() }}" class="back-btn">&lt;</a>
            <h2 class="shop-title">{{ $restaurant->name }}</h2>
            <img src="{{ asset('storage/' . $restaurant->image) }}" alt="{{ $restaurant->name }}"  class="shop-main-img">
        </div>
        <p class="tags">
            @foreach($restaurant->areas as $area)
                #{{ $area->name }}
            @endforeach
            @foreach($restaurant->genres as $genre)
                #{{ $genre->name }}
            @endforeach
        </p>
        <p class="overview">{{ $restaurant->overview }}</p>
    </div>

    <div class="right-panel">
        <div class="reservation-form-container">
            <form action="{{ route('purchase') }}" method="POST" class="reservation-form">
                @csrf
                <input type="hidden" name="restaurant_id" value="{{ $restaurant->id }}">
                <h2>予約</h2>
                <input type="date" name="date" value="{{ old('date') }}">
                @error('date')
                    <div class="error">{{ $message }}</div>
                @enderror
                <input type="time" name="time" value="{{ old('time') }}">
                @error('time')
                    <div class="error">{{ $message }}</div>
                @enderror
                <select name="number_of_people">
                    <option value="" disabled {{ old('number_of_people') ? '' : 'selected' }}>未選択</option>
                    @for ($i = 1; $i <= 10; $i++)
                        <option value="{{ $i }}" {{ old('number_of_people') == $i ? 'selected' : '' }}>{{ $i }}人</option>
                    @endfor
                </select>
                @error('number_of_people')
                    <div class="error">{{ $message }}</div>
                @enderror

                <div class="summary">
                    <p>Shop：{{ $restaurant->name }}</p>
                    <p>Date：<span id="selected-date">未選択</span></p>
                    <p>Time：<span id="selected-time">未選択</span></p>
                    <p>Number：<span id="selected-number">未選択</span></p>
                </div>

                @if(Auth::check())
                    <button type="submit" class="reserve-btn">予約する</button>
                @else
                    <button type="button" class="reserve-btn" onclick="alert('予約するにはログインしてください')">予約する</button>
                @endif
            </form>
        </div>
    </div>
</div>

<script>
    const date = document.querySelector('input[name="date"]');
    const time = document.querySelector('input[name="time"]');
    const number = document.querySelector('select[name="number_of_people"]');

    date.addEventListener('change', () => {
        document.getElementById('selected-date').innerText = date.value;
    });
    time.addEventListener('change', () => {
        document.getElementById('selected-time').innerText = time.value;
    });
    number.addEventListener('change', () => {
        document.getElementById('selected-number').innerText = number.value + '人';
    });
</script>
@endsection
