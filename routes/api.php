<?php

use App\Http\Controllers\MovieController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:api')->group(function () {
    Route::get('/v1/movies', [MovieController::class, 'index']);
    Route::post('/v1/movies', [MovieController::class, 'store']);
    Route::post('/v1/logout', [AuthController::class, 'logout']);
});

Route::post('/v1/login', [AuthController::class, 'login']);