<?php

use App\Models\Meal;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return Meal::all();
    return view('welcome');
});
