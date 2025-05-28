@extends('layouts.app')

@section('title', '予約編集')

@section('content')
<link rel="stylesheet" href="{{ asset('css/reservation_edit.css') }}">

<div class="form-container">
    <a href="{{ url()->previous() }}" class="back-btn">&lt;</a>
    <h2>予約編集</h2>
    <form action="{{ route('reservations.update', $reservation->id) }}" method="POST">
        @csrf

        <label>予約店舗：{{ $reservation->restaurant->name }}</label>

        <label>予約日</label>
        <input type="date" name="date" value="{{ $reservation->date }}">
        @error('date')
            <div class="error">{{ $message }}</div>
        @enderror

        <label>予約時間</label>
        <input type="time" name="time" value="{{ $reservation->time }}">
        @error('time')
            <div class="error">{{ $message }}</div>
        @enderror

        <label>人数</label>
        <input type="number" name="number_of_people" value="{{ $reservation->number_of_people }}" min="1">
        @error('number_of_people')
            <div class="error">{{ $message }}</div>
        @enderror

        <button type="submit">更新する</button>
    </form>
</div>
@endsection
