<?php

use App\Http\Controllers\MealController;
use App\Http\Controllers\MealPlanController;
use App\Http\Controllers\RecommendationController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('/meals', MealController::class);
    Route::get('/recommend', [RecommendationController::class, 'recommend']);
    Route::resource('mealplans', MealPlanController::class)->only(['show', 'store', 'index']);
    Route::get('/history', [RecommendationController::class, 'history']);
    Route::patch('/profile/edit', [AuthController::class, 'edit']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
