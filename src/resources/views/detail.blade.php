@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')
<div class="edit-container">
    <h2 class="edit-header">
        <a href="{{ route('products.index') }}">商品一覧</a> &gt; {{ $product->name }}
    </h2>
    <form class="edit-form" action="{{ route('products.update', ['productId' => $product->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="edit-main__upper">
            <div class="edit-image">
                <img src="{{ asset('storage/fruits/' . $product->image) }}" alt="{{$product->name}}" width="300">
                <input type="file" name="image" accept="image/*" value="{{ old('image') }}">
                <span class="filename">{{ $product->image }}</span>
                <div class="form-error">
                    @error('image')
                    {{$message}}
                    @enderror
                </div>
            </div>
            <div class="edit-fields">
                <div class="edit-item">
                    <label>商品名</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}">
                    <div class="form-error">
                        @error('name')
                        {{$message}}
                        @enderror
                    </div>
                </div>
                <div class="edit-item">
                    <label>値段</label>
                    <input type="number" name="price" value="{{ old('price', $product->price) }}">
                    <div class="form-error">
                        @error('price')
                        {{$message}}
                        @enderror
                    </div>
                </div>
                <div class="edit-item">
                    <label>季節</label>
                    <div class="season-options">
                    @foreach($seasons as $season)
                        <label class="custom-checkbox"><input class="checkbox" type="checkbox" name="seasons[]" value="{{ $season->id }}" {{ $product->seasons->contains($season->id) ? 'checked' : '' }}><span class="checkmark"></span> {{ $season->name }}</label>
                    @endforeach
                    </div>
                    <div class="form-error">
                        @error('seasons')
                        {{$message}}
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="edit-main__lower">
            <div class="edit-description">
                <label>商品説明</label>
                <textarea name="description">{{ old('description', $product->description) }}</textarea>
                <div class="form-error">
                    @error('description')
                    {{$message}}
                    @enderror
                </div>
            </div>
            <div class="edit-buttons">
                <a href="{{ route('products.index') }}" class="btn gray">戻る</a>
                <button type="submit" class="btn yellow">変更を保存</button>
            </div>
        </div>
    </form>

    <form action="{{ route('products.destroy', ['productId' => $product->id]) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn-red">🗑</button>
    </form>
</div>
@endsection
