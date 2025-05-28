@extends('layouts.app')

@section('title', 'ログイン')

<link rel="stylesheet" href="{{ asset('css/login.css') }}">

@section('content')
<div class="form-container">
    <h2 class="form-title">Login</h2>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <input type="email" name="email" placeholder="Email"  value="{{ old('email') }}">
        @error('email')
            <div class="error">{{ $message }}</div>
        @enderror
        <input type="password" name="password" placeholder="Password">
        @error('password')
            <div class="error">{{ $message }}</div>
        @enderror
        <button type="submit">ログイン</button>
    </form>
</div>
@endsection
