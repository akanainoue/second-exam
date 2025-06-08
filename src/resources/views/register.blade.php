@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<main class="register-page">
    <h2 class="register-page__title">商品登録</h2>
    <form class="register-form" method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-item name">
            <label>商品名 <span class="require">必須</span></label>
            <input type="text" name="name" value="{{ old('name') }}">
            <div class="form-error">
                @error('name')
                {{$message}}
                @enderror
            </div>
        </div>
        <div class="form-item price">
            <label>値段 <span class="require">必須</span></label>
            <input type="number" name="price" value="{{ old('price') }}">
            <div class="form-error">
                @error('price')
                {{$message}}
                @enderror
            </div> 
        </div>
        <div class="form-item image">
            <label>商品画像 <span class="require">必須</span></label>
            <input type="file" name="image" value="{{ old ('image') }}">
            <div class="form-error">
                @error('image')
                {{$message}}
                @enderror
            </div>
        </div>
        <div class="form-item seasons">
            <label>季節 <span class="require">必須</span><span class="require-season">複数選択可</span></label>
            <div class="season-options">
            @foreach($seasons as $season)
                <label><input type="checkbox" name="seasons[]" value="{{ $season->id }}" {{ old('seasons[]')==$season->id ? 'selected' : '' }} > {{ $season->name }}</label>
            @endforeach
            </div>
            <div class="form-error">
                @error('seasons')
                {{$message}}
                @enderror
            </div>
        </div>
        <div class="form-item description">
            <label>商品説明 <span class="require">必須</span></label>
            <textarea name="description" value="{{ old('description') }}"></textarea>
            <div class="form-error">
                @error('description')
                {{$message}}
                @enderror
            </div>
        </div>

        <div class="btn-group">
            <a class="btn gray" href="{{ route('products.index') }}" class="btn">戻る</a>
            <button type="submit" class="btn yellow">登録</button>
        </div>
    </form>
</main>
@endsection