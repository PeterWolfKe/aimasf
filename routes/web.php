<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index']);
Route::post('/buy', [PaymentController::class, 'store'])->name('payment.store');
Route::get('/payment', [PaymentController::class, 'index'])->name('payment.index');
Route::post('/payment/process', [PaymentController::class, 'processPayment'])->name('payment.process');
