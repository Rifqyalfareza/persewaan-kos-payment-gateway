<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/boarding-houses', [App\Http\Controllers\BoardingController::class, 'index']);
Route::get('/boarding-houses/{id}', [App\Http\Controllers\BoardingController::class, 'show']);