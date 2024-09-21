<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\MealsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::get('meals', [MealsController::class, 'fetchMeals']);
Route::post('meal/store', [MealsController::class, 'store']);
Route::post('meal/update/{id}', [MealsController::class, 'update']);
Route::get('meal/delete/{id}', [MealsController::class, 'delete']);

Route::get('categories', [CategoryController::class, 'fetchCategories']);
