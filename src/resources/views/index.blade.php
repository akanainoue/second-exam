@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="container">
    <aside class="sidebar">
        <h2>
            @if(request('keyword'))
                "{{ request('keyword') }}"の商品一覧
            @else
                商品一覧
            @endif
        </h2>
        <form class="search" method="GET" action="{{ route('products.search') }}">
            <input type="text" name="keyword" placeholder="商品名で検索" value="{{ request('keyword') }}">
            <button type="submit" class="search-btn">検索</button>
        </form>
        <form class="sort" method="GET" action="{{ route('products.sort') }}">
        <label for="sort">価格順で表示</label>
            <select id="sort" name="sort" onchange="this.form.submit()">
                <option value="">価格で並べ替え</option>
                <option value="high" {{ request('sort') == 'high' ? 'selected' : '' }}>高い順に表示</option>
                <option value="low" {{ request('sort') == 'low' ? 'selected' : '' }}>安い順に表示</option>
            </select>
        </form>

        @if(request('sort'))
            <div class="sort-tag">
                <span class="sort-text">
                {{ request('sort') == 'high' ? '高い順に表示' : '安い順に表示' }}
                </span>
                <a class="sort-link" href="{{ route('products.index') }}">&times;</a>
            </div>
        @endif
    </aside>

    <div class="main">
        @if (!request('keyword'))
        <a href="{{ route('products.register') }}" class="add-btn">+ 商品を追加</a>
        @endif
        <section class="product-list">
            @foreach($products as $product)
            <a href="{{ route('products.detail', ['productId' => $product->id]) }}" class="product-card-link">
                <div class="product-card">
                    <img src="{{ asset('storage/fruits/' . $product->image) }}" alt="{{ $product->name }}">
                    <div class="description">
                        <span>{{ $product->name }}</span>
                        <span>￥{{ number_format($product->price) }}</span>
                    </div>
                </div>
            </a>
            @endforeach
        </section>
        <div class="pagination">
            {{ $products->links('vendor.pagination.custom') }}
        </div>
    </div>
</div>
@endsection

