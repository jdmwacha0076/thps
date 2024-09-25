<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

//For displaying products from the API in table form
Route::get('/api-products', [ProductController::class, 'showAPIProducts'])->name('api.products');

//For searching products from the API data
Route::get('/api-products/search', [ProductController::class, 'searchAPIProducts'])->name('api.products.search');

//For filtering products from the API data
Route::get('/api-products/filter', [ProductController::class, 'filterAPIProducts'])->name('api.products.filter');

//For showing all products from the API data
Route::get('/view/api/products', [ProductController::class, 'showProducts'])->name('products.index');

//For showing the product detailed data
Route::get('/products/{id}', [ProductController::class, 'showProductDetails'])->name('products.show');









