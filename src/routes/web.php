<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::prefix('products')->controller(ProductController::class)->group(function () {

    // 商品一覧
    Route::get('/', 'index')->name('products.index');

    // 商品検索
    Route::get('/search', 'search')->name('products.search');

    // 商品詳細・更新
    Route::get('/detail/{productId}', 'show')->name('products.detail');

    // 商品更新処理
    Route::put('/{productId}/update', 'update')->name('products.update');

    // 商品登録
    Route::get('/register', 'create')->name('products.create');

    // 商品登録処理
    Route::post('/register', 'store')->name('products.store');

    // 商品削除
    Route::delete('/{productId}/delete', 'destroy')->name('products.destroy');
});
