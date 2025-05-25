<?php

use App\Http\Controllers\MealController;
use App\Http\Controllers\RecommendationController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/meals', [MealController::class, 'index']);
    Route::get('/recommend', [RecommendationController::class, 'recommend']);
    Route::get('/history', [RecommendationController::class, 'history']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
