<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'registerUser'])->name('register.post');
// Route::get('/home',[App\Http\Controllers\HomeController::class,'index'])->name('home');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['api.auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/services', [ServiceController::class, 'index'])->name('services');
    Route::get('/services/{kode}', [ServiceController::class, 'show'])->name('services.detail');
    Route::get('/service/{kode}/book', [ServiceController::class, 'book'])->name('services.book');
});
