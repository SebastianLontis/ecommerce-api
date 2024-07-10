<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Login
Route::post('/login', [AuthenticationController::class, 'login'])->withoutMiddleware('auth:sanctum');

// Logout
Route::post('logout', [AuthenticationController::class, 'logout'])->middleware('auth:sanctum');

// Register
Route::post('/register', [AuthenticationController::class, 'register'])->withoutMiddleware('auth:sanctum');

// Categories
Route::get('/categories', [CategoryController::class, 'index']);
Route::post('/categories', [CategoryController::class, 'store']);
Route::get('/categories/{category}', [CategoryController::class, 'show']);
Route::put('/categories/{category}', [CategoryController::class, 'update']);
Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);

//Product
Route::get('/products', [ProductController::class, 'index']);
Route::post('/products', [ProductController::class, 'store']);
Route::get('/products/{product}', [ProductController::class, 'show']);
Route::put('/products/{product}', [ProductController::class, 'update']);
Route::delete('/products/{product}', [ProductController::class, 'destroy']);