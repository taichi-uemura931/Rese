@extends('layouts.app')

@section('title', '会員登録')

<link rel="stylesheet" href="{{ asset('css/register.css') }}">

@section('content')
<div class="form-container">
    <h2 class="form-title">Registration</h2>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <input type="text" name="name" placeholder="Username" value="{{ old('name') }}">
        @error('name')
            <div class="error">{{ $message }}</div>
        @enderror
        <input type="email" name="email" placeholder="Email" value="{{ old('email') }}">
        @error('email')
            <div class="error">{{ $message }}</div>
        @enderror
        <input type="password" name="password" placeholder="Password" value="{{ old('password') }}">
        @error('password')
            <div class="error">{{ $message }}</div>
        @enderror
        <button type="submit">登録</button>
    </form>
</div>
@endsection
