<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Login
Route::post('/login', [AuthenticationController::class, 'login'])->withoutMiddleware('auth:sanctum');

// Logout
Route::post('logout', [AuthenticationController::class, 'logout'])->middleware('auth:sanctum');

// Register
Route::post('/register', [AuthenticationController::class, 'register'])->withoutMiddleware('auth:sanctum');