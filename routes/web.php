<?php

use App\Http\Controllers\ConversionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::get('/', [ConversionController::class, 'index']);
Route::get('/convert', [ConversionController::class, 'conversion'])->name('currency.convert');
Route::get('/pay', [ConversionController::class, 'pay'])->name('currency.pay');
Route::get('/accept', [ConversionController::class, 'accept'])->name('payment.accept');
Route::get('/cancel', [ConversionController::class, 'cancel'])->name('payment.cancel');
Route::get('/callback', [ConversionController::class, 'callback'])->name('payment.callback');

Route::get('/dashboard', [ConversionController::class, 'panel'])->middleware(['auth', 'verified'])->name('dashboard');
Route::patch('/orders/approve/{conversion}', [ConversionController::class, 'approve'])->middleware(['auth', 'verified'])->name('orders.approve');
Route::delete('/orders/destroy/{conversion}', [ConversionController::class, 'destroy'])->middleware(['auth', 'verified'])->name('orders.destroy');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
