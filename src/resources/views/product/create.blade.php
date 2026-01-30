@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/product.css') }}">
@endsection

@section('content')

<div class="product-create">

    <h1 class="product-create__title">
        商品登録
    </h1>

    <form method="post"
        action="{{ route('products.store') }}"
        enctype="multipart/form-data"
        class="create-form">

        @csrf

        {{-- 商品名 --}}
        <div class="product-create__group">
            <label for="name" class="product-create__label">商品名</label>
            <span class="product-create__required">必須</span>

            <input type="text"
                name="name"
                id="name"
                value="{{ old('name') }}"
                placeholder="商品名を入力"
                class="input input--text">

            <div class="input--error">
                @error('name')
                {{ $message }}
                @enderror
            </div>
        </div>

        {{-- 値段 --}}
        <div class="product-create__group">
            <label for="price" class="product-create__label">値段</label>
            <span class="product-create__required">必須</span>

            <input type="text"
                name="price"
                id="price"
                value="{{ old('price') }}"
                placeholder="値段を入力"
                class="input input--text">

            <div class="input--error">
                @error('price')
                {{ $message }}
                @enderror
            </div>
        </div>

        {{-- 商品画像 --}}
        <div class="product-create__group">
            <label for="img" class="product-create__label">商品画像</label>
            <span class="product-create__required">必須</span>

            <div class="product-create__image-box">

                <img id="preview"
                    class="product-create__preview u-mt-5">

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
                    @error('image')
                    {{ $message }}
                    @enderror
                </div>

            </div>
        </div>

        {{-- 季節 --}}
        <div class="product-create__group">
            <label class="product-create__label">季節</label>
            <span class="product-create__required">必須</span>
            <span class="product-create__seasons">複数選択可</span>

            <div class="product-create__season-list">
                @foreach ($seasons as $season)
                <label for="season-{{ $season->id }}"
                    class="product-create__season">

                    <input type="checkbox"
                        name="season[]"
                        id="season-{{ $season->id }}"
                        value="{{ $season->id }}"
                        class="input-checkbox u-cursor-pointer"
                        {{ in_array($season->id, old('season', [])) ? 'checked' : '' }}>

                    {{ $season->name }}
                </label>
                @endforeach
            </div>

            <div class="input--error">
                @error('season')
                {{ $message }}
                @enderror
            </div>
        </div>

        {{-- 商品説明 --}}
        <div class="product-create__description">

            <label for="description" class="product-create__label">商品説明</label>
            <span class="product-create__required">必須</span>

            <textarea name="description"
                id="description"
                placeholder="商品の説明を入力"
                class="input input--textarea u-border-none">{{ old('description') }}</textarea>

            <div class="input--error">
                @error('description')
                {{ $message }}
                @enderror
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
                登録
            </button>

        </div>

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