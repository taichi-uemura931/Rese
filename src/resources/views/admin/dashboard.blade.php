@extends('layouts.app')

@section('title', '管理者ダッシュボード')

<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

@section('content')
<div class="dashboard-container">
    <h2>ようこそ、管理者 {{ optional(Auth::user())->name }} さん</h2>
    <p>ここから店舗代表者の管理が行えます</p>

    <div class="actions">
        <a href="{{ route('admin.owners.create') }}" class="btn">店舗代表者の新規登録</a>
        <a href="{{ route('admin.email.form') }}" class="btn">利用者への一斉お知らせメール</a>
    </div>
</div>
@endsection

