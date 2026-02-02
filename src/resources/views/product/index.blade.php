@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/product.css') }}">
@endsection

@section('content')

<div class="product u-w-100">

    <div class="product__heading u-flex-between">
        <h2 class="product__title u-inline-block">
            @if (request('search'))
            "{{ request('search') }}"
            @endif
            商品一覧
        </h2>

        <a href="{{ route('products.create') }}"
            class="product__add-button
                u-shadow
                u-font-size-16px
                u-text-decoration-none
                u-font-weight-bold
                u-cursor-pointer
                u-hover-opacity">
            + 商品を追加
        </a>
    </div>

    <div class="product__row u-flex">

        <div class="product__controls">

            {{-- 検索フォーム --}}
            <form action="{{ route('products.search') }}" method="get"
                class="product__search-form">

                <input type="text"
                    name="search"
                    placeholder="商品名で検索"
                    value="{{ request('search') }}"
                    class="product__search-input u-w-100 u-border-none">

                <input type="hidden" name="sort" value="{{ request('sort') }}">

                <button type="submit"
                    class="product__search-button
                            u-shadow
                            u-w-100
                            u-border-none
                            u-font-weight-bold
                            u-cursor-pointer
                            u-hover-opacity">
                    検索
                </button>
            </form>

            <div class="product__sort u-font-weight-bold">
                価格順で表示
            </div>

            {{-- ソートフォーム --}}
            <form action="{{ route('products.index') }}" method="get"
                class="product__sort-form">

                <input type="hidden" name="search" value="{{ request('search') }}">

                <select name="sort"
                    class="product__sort-select
                            u-w-100
                            u-border-none
                            u-font-size-16px"
                    onchange="this.form.submit()"
                    required>

                    <option value="" class="product__sort-selected" selected>
                        価格で並び替え
                    </option>

                    <option value="price_desc"
                        class="product__sort-option"
                        {{ request('sort') == 'price_desc' ? 'selected' : '' }}>
                        高い順に表示
                    </option>

                    <option value="price_asc"
                        class="product__sort-option"
                        {{ request('sort') == 'price_asc' ? 'selected' : '' }}>
                        低い順に表示
                    </option>
                </select>

                @if (request('sort'))
                <div class="sort-modal
                                u-inline-block
                                u-shadow
                                u-font-weight-bold">

                    <span class="sort-modal__text">
                        @if (request('sort') === 'price_desc')
                        高い順に表示
                        @elseif (request('sort') === 'price_asc')
                        低い順に表示
                        @endif
                    </span>

                    <a href="{{ route('products.index') }}"
                        class="sort-modal__close u-text-decoration-none">
                        ✕
                    </a>
                </div>
                @endif

            </form>

        </div>

        <div class="product__list u-w-100">
            <div class="product__grid u-flex">

                @foreach ($products as $product)
                <a href="{{ route('products.detail', $product->id) }}"
                    class="product__card
                            u-shadow
                            u-color-black
                            u-text-decoration-none
                            u-hover-opacity">

                    <img src="{{ asset('storage/' . $product->image) }}"
                        alt="{{ $product->name }}"
                        class="product__image u-w-100">

                    <div class="product__content u-flex-between">
                        <div class="product__name">
                            {{ $product->name }}
                        </div>
                        <div class="product__price">
                            ¥{{ number_format($product->price) }}
                        </div>
                    </div>

                </a>
                @endforeach

            </div>

            <div class="product__pagination u-flex-center">
                {{ $products->links('vendor.pagination.default') }}
            </div>

        </div>

    </div>

</div>

@endsection