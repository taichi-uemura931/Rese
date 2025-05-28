@extends('layouts.app')

@section('title', '店舗新規作成')

<link rel="stylesheet" href="{{ asset('css/owner_create.css') }}">

@section('content')
<div class="create-container">
    <div class="title-group">
        <a href="{{ route('owner.restaurants.index') }}" class="back-btn">&lt;</a>
        <h2 class="create-title">店舗を新規登録</h2>
    </div>

    <form action="{{ route('owner.restaurants.store') }}" method="POST" enctype="multipart/form-data" class="create-form">
        @csrf

        <div class="form-group">
            <label for="name">店舗名</label>
            <input type="text" name="name" value="{{ old('name') }}">
            @error('name') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="overview">概要</label>
            <textarea name="overview">{{ old('overview') }}</textarea>
            @error('overview') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="image">画像</label>
            <input type="file" name="image" id="imageInput" accept="image/*">
            <div class="image-preview" id="imagePreview">
                <p>画像プレビューがここに表示されます</p>
            </div>
            @error('image') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="area">エリア</label>
            <select name="area_id" required>
                <option value="">選択してください</option>
                @foreach ($areas as $area)
                    <option value="{{ $area->id }}">{{ $area->name }}</option>
                @endforeach
            </select>
            @error('area_id') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label for="genres">ジャンル</label>
            <select name="genre_id" required>
                <option value="">選択してください</option>
                @foreach ($genres as $genre)
                    <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                @endforeach
            </select>
            @error('genre_ids') <div class="error">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="submit-btn">登録する</button>
    </form>
</div>

<script>
    document.getElementById('imageInput').addEventListener('change', function (e) {
        const preview = document.getElementById('imagePreview');
        preview.innerHTML = '';

        const file = e.target.files[0];
        if (file) {
            const img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            img.onload = () => URL.revokeObjectURL(img.src);
            img.style.maxWidth = '100%';
            img.style.maxHeight = '200px';
            preview.appendChild(img);
        } else {
            preview.innerHTML = '<p>画像プレビューがここに表示されます</p>';
        }
    });
</script>
@endsection
