@extends('layouts.app')

@section('title', 'QRコード表示')

<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">

@section('content')
    <div class="mypage-container">
        <a href="{{ url()->previous() }}" class="back-btn">&lt;</a>
        <h2 class="page-title">予約QRコード</h2>

        <div class="reservation-card qr-style">
            <p>店舗：{{ $reservation->restaurant->name }}</p>
            <p>日付：{{ $reservation->date }}</p>
            <p>時間：{{ $reservation->time }}</p>
            <p>人数：{{ $reservation->number_of_people }}人</p>
            <div class="qr-code">
                {!! $qrCode !!}
            </div>
        </div>
    </div>
@endsection
