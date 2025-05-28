@extends('layouts.app')

@section('title', '店舗代表者ダッシュボード')

<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

@section('content')
<div class="dashboard-container">
    <h2>ようこそ、{{ Auth::user()->name }} さん</h2>
    <p>ご自身の店舗情報と予約情報を管理できます。</p>

    <div class="actions">
        <a href="{{ route('owner.restaurants.index') }}" class="btn ">店舗情報を管理</a>
        <a href="{{ route('owner.reservations.index') }}" class="btn ">予約状況を確認</a>
    </div>
</div>
@endsection
