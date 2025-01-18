<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmailSubscriptionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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


Route::post('/subscribe', [EmailSubscriptionController::class, 'subscribe'])
    ->middleware('throttle:100,1')
    ->name('email.subscribe');
Route::get('/subscribe/confirm/{token}', [EmailSubscriptionController::class, 'confirm'])
    ->middleware('throttle:100,1')
    ->name('email.confirm');

Route::middleware(['no-cache'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/payment', [PaymentController::class, 'index']);
});


Route::get('/terms-and-conditions', function () {
    return Inertia::render('TermsAndConditions');
});
Route::get('/protection-of-personal-information', function () {
    return Inertia::render('ProtectionOfPersonalInformation');
});

Route::post('/buy', [PaymentController::class, 'store'])->name('payment.store');
Route::post('/payment/process', [PaymentController::class, 'processPayment'])->name('payment.process');
Route::post('/payment/apply-discount', [PaymentController::class, 'applyDiscount'])->name('payment.apply-discount');
Route::post('/payment/webhook', [PaymentController::class, 'handleWebhook'])->name('payment.success');

Route::get('/payment-success', [PaymentController::class, 'paymentSuccess'])
    ->middleware('throttle:100,1');

Route::get('/login', function () {
    if (auth()->check() && auth()->user()->admin) {
        return redirect()->route('admin.dashboard');
    }
    return Inertia::render('Login');
});
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
});
