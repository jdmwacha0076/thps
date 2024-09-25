<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


//For fetching data from the API in JSON format
Route::middleware('throttle:60,1')->get('/products', [ProductController::class, 'JSONRawData']);
