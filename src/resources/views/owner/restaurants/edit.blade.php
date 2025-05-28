@extends('layouts.app')

@section('title', '店舗情報編集')

<link rel="stylesheet" href="{{ asset('css/owner_edit.css') }}">

@section('content')
<div class="edit-container">
    <div class="title-group">
        <a href="{{ route('owner.restaurants.index') }}" class="back-btn">&lt;</a>
        <h2 class="edit-title">店舗情報の編集</h2>
    </div>

    <form action="{{ route('owner.restaurants.update', $restaurant->id) }}" method="POST" enctype="multipart/form-data" class="edit-form">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">店舗名</label>
            <input type="text" name="name" value="{{ old('name', $restaurant->name) }}">
            @error('name') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="overview">概要</label>
            <textarea name="overview">{{ old('overview', $restaurant->overview) }}</textarea>
            @error('overview') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label>現在の画像</label>
            <img src="{{ asset('storage/' . $restaurant->image) }}" alt="{{ $restaurant->name }}" class="current-image">
        </div>

        <div class="form-group">
            <label for="image">新しい画像（任意）</label>
            <input type="file" name="image" id="imageInput">
            <div id="preview" class="image-preview">画像プレビューがここに表示されます</div>
            @error('image') <div class="error">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="submit-btn">更新する</button>
    </form>
</div>

<script>
    document.getElementById('imageInput').addEventListener('change', function (event) {
        const preview = document.getElementById('preview');
        preview.innerHTML = '';

        const file = event.target.files[0];
        if (file) {
            const img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            img.style.maxWidth = '100%';
            img.style.borderRadius = '6px';
            img.onload = () => URL.revokeObjectURL(img.src);
            preview.appendChild(img);
        } else {
            preview.textContent = '画像プレビューがここに表示されます';
        }
    });
</script>
@endsection
