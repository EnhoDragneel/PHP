<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/teste', function () {
    return response()->json([
        'teste' => 1
    ]);
});

Route::prefix('products')->group(function () {
    Route::post('/', [ProductController::class, 'store']);
    Route::get('/', [ProductsController::class, 'index']);
    Route::get('/', [ProductsController::class, 'show']);
    Route::put('/{id}', [ProductsController::class, 'update']);
    Route::delete('/{id}', [ProductsController::class, 'delete']);
});