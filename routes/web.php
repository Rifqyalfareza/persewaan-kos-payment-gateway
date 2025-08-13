<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransactionController;

Route::get('/', [App\Http\Controllers\BoardingHouseController::class, 'index'])->name('list-kost');
Route::get('/list-kost/details/{id}', [App\Http\Controllers\BoardingHouseController::class, 'show'])->name('details');
Route::get('list-kost/category/{id}', [App\Http\Controllers\BoardingHouseController::class, 'showCategories'])->name('showCategories');
Route::get('/register', [AuthController::class, 'indexRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');
Route::get('/login', [AuthController::class, 'indexLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('auth');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/sewa', [App\Http\Controllers\TransactionController::class, 'createTransaction'])->name('sewa');
Route::get('/transactions', [App\Http\Controllers\TransactionController::class, 'index'])->name('transactions');
Route::post('/checkout', [App\Http\Controllers\TransactionController::class, 'checkout'])->name('checkout');
Route::get('/midtrans-callback', [App\Http\Controllers\TransactionController::class, 'callback']);
Route::get('/payment/finish', [TransactionController::class, 'finish'])->name('payment.finish');
