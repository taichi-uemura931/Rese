@extends('layouts.app')

@section('title', 'お知らせメール送信')

<link rel="stylesheet" href="{{ asset('css/admin_email.css') }}">

@section('content')
<div class="form-container">
    <h2>利用者へのお知らせメール</h2>
    <a href="{{ url()->previous() }}" class="back-btn">&lt;</a>

    <form method="POST" action="{{ route('admin.email.send') }}">
        @csrf
        <label>件名</label>
        <input type="text" name="subject" value="{{ old('subject') }}" required>
        @error('subject')
            <div class="error">{{ $message }}</div>
        @enderror

        <label>本文</label>
        <textarea name="message" rows="8" required>{{ old('message') }}</textarea>
        @error('message')
            <div class="error">{{ $message }}</div>
        @enderror

        <button type="submit">送信する</button>
    </form>
</div>
@endsection
