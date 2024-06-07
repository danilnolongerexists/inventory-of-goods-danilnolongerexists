<?php

use Illuminate\Support\Facades\Route;
use App\Orchid\Screens\ProductListScreen;
use App\Orchid\Screens\ProductEditScreen;
use App\Orchid\Screens\ProductCreateScreen;

Route::get('/', function () {
    return view('welcome');
});

Route::screen('products', ProductListScreen::class)->name('platform.product.list');
Route::screen('products/create', ProductCreateScreen::class)->name('platform.product.create');
Route::screen('products/{product}/edit', ProductEditScreen::class)->name('platform.product.edit');
