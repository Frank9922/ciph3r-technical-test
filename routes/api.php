<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::apiResource('products', ProductController::class);
Route::prefix('products')->group(function() {

    Route::get('/{product}/prices', [ProductController::class, 'prices']);

    Route::post('/{product}/prices', [ProductController::class, 'storePrice']);
});

