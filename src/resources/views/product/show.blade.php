@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/product.css') }}">
@endsection

@section('content')

<div class="product-show">

    <nav class="breadcrumb">
        <ul class="breadcrumb__list">
            <li class="breadcrumb__parent u-inline-block u-font-weight-bold">
                商品一覧
            </li>
            <li class="breadcrumb__current u-inline-block">
                > {{ $product->name }}
            </li>
        </ul>
    </nav>

    <form method="post"
        action="{{ route('products.update', $product->id) }}"
        enctype="multipart/form-data"
        class="edit-form">

        @csrf
        @method('PUT')

        {{-- 商品画像 --}}
        <div class="product-show__container u-w-100 u-flex">

            <div class="product-show__file u-inline-block">

                @if (!$errors->has('image'))
                {{-- バリデーションエラーがないときだけ既存画像を表示 --}}
                <img src="{{ asset('storage/' . $product->image) }}"
                    id="preview"
                    alt="商品画像"
                    class="product-show__image u-w-100">
                @else
                {{-- エラー時は空の preview を出しておく（エラー後も JS の preview が使えるように） --}}
                <img
                    id="preview"
                    src=""
                    alt="商品画像"
                    class="product-show__image u-w-100"
                    style="display:none;">
                @endif

                <div class="input-file">
                    <label for="img" class="input-file__button">
                        ファイルを選択
                    </label>

                    <input type="file"
                        name="image"
                        id="img"
                        class="input-file__native">

                    <span class="input-file__name"></span>
                </div>

                <div class="input--error">
                    @foreach ($errors->get('image', []) as $error)
                    {{ $error }}
                    @endforeach
                </div>

            </div>

            <div class="product-show__content u-inline-block">

                {{-- 商品名 --}}
                <div class="product-show__group">
                    <label for="name" class="product-show__label">商品名</label>

                    <input type="text"
                        name="name"
                        id="name"
                        value="{{ old('name', $product->name) }}"
                        placeholder="商品名を入力"
                        class="input input--text">
                </div>

                <div class="input--error">
                    @error('name')
                    {{ $message }}
                    @enderror
                </div>

                {{-- 値段 --}}
                <div class="product-show__group">
                    <label for="price" class="product-show__label">値段</label>

                    <input type="text"
                        name="price"
                        id="price"
                        value="{{ old('price', $product->price) }}"
                        placeholder="値段を入力"
                        class="input input--text">
                </div>

                <div class="input--error">
                    @foreach ($errors->get('price', []) as $error)
                    {{ $error }}
                    @endforeach
                </div>

                {{-- 季節 --}}
                <div class="product-show__group">
                    <label class="product-show__label">季節</label>

                    @foreach ($seasons as $season)
                    <label for="season-{{ $season->id }}"
                        class="product-show__season">

                        <input type="hidden" value="" name="season[]">

                        <input type="checkbox"
                            name="season[]"
                            id="season-{{ $season->id }}"
                            value="{{ $season->id }}"
                            class="input-checkbox u-cursor-pointer"
                            {{ in_array($season->id, old('season', $product->
                            seasons->pluck('id')->toArray())) ? 'checked' : '' }}>

                        {{ $season->name }}
                    </label>
                    @endforeach

                    <div class="input--error">
                        @error('season')
                        {{ $message }}
                        @enderror
                    </div>
                </div>

            </div>
        </div>

        {{-- 商品説明 --}}
        <div class="product-show__description">

            <label for="description" class="product-show__label">商品説明</label>

            <textarea name="description"
                id="description"
                placeholder="商品の説明を入力"
                class="input input--textarea u-border-none">{{ old('description', $product->description) }}</textarea>

            <div class="input--error">
                @foreach ($errors->get('description', []) as $error)
                {{ $error }}
                @endforeach
            </div>

        </div>

        {{-- ボタン --}}
        <div class="buttons u-flex-center">

            <a href="{{ route('products.index') }}"
                class="back-button
                    u-inline-block
                    u-color-black
                    u-cursor-pointer
                    u-hover-opacity">
                戻る
            </a>

            <button type="submit"
                class="submit-button
                        u-font-size-16px
                        u-border-none
                        u-cursor-pointer
                        u-hover-opacity">
                変更を保存
            </button>

        </div>

    </form>

    {{-- 削除フォーム --}}
    <form action="{{ route('products.destroy', $product) }}"
        method="post"
        class="delete-form">

        @csrf
        @method('DELETE')

        @if (!$errors->any())
        {{-- バリデーションエラーがないときだけ表示 --}}
        <button class="delete-form__button
                    u-border-none
                    u-cursor-pointer">
        </button>
        @endif

    </form>

</div>

<script>
    document.getElementById('img').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const preview = document.getElementById('preview');

        if (!file) {
            preview.style.display = 'none';
            preview.src = '';
            return;
        }

        preview.src = URL.createObjectURL(file);
        preview.style.display = 'block';
    });

    const nativeInput = document.getElementById('img');
    const fileName = document.querySelector('.input-file__name');

    nativeInput.addEventListener('change', () => {
        fileName.textContent = nativeInput.files.length ?
            nativeInput.files[0].name :
            '';
    });
</script>

@endsection