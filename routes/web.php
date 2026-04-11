<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'registerUser'])->name('register.post');
Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'forgotPasswordSendOTP'])->name('password.noHp');
Route::get('/otp', [AuthController::class, 'otp'])->name('otp');
Route::post('/otp', [AuthController::class, 'verifyOTP'])->name('otp.verify');
Route::get('/reset-password', [AuthController::class, 'resetPassword'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'updatePassword'])->name('password.update');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['api.auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/services', [ServiceController::class, 'index'])->name('services');
    Route::get('/services/{kode}', [ServiceController::class, 'show'])->name('services.detail');
    Route::get('/service/{kode}/book', [ServiceController::class, 'book'])->name('services.book');
    Route::post('/service/{kode}/book/location', [ServiceController::class, 'storeLocation'])->name('services.book.location');
    Route::post('/service/check-ranger', [ServiceController::class, 'checkAvailableRanger'])->name('services.checkRanger');
    Route::get('/voucher',[VoucherController::class,'index'])->name('voucher.index');
    Route::post('/voucher/buy',[VoucherController::class,'buy'])->name('voucher.buy');
    Route::get('/history', [HistoryController::class, 'index'])->name('history.index');
    Route::get('/profile',[ProfileController::class,'index'])->name('profile.index');
});
