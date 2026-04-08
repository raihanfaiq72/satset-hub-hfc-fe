<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});
Route::get('/login',[App\Http\Controllers\AuthController::class,'index'])->name('login');
Route::post('/login',[App\Http\Controllers\AuthController::class,'login'])->name('login.post');
Route::get('/register',[App\Http\Controllers\AuthController::class,'register'])->name('register');
Route::post('/register',[App\Http\Controllers\AuthController::class,'registerUser'])->name('register.post');
Route::get('/home',[App\Http\Controllers\HomeController::class,'index'])->name('home');
Route::get('/logout',[App\Http\Controllers\AuthController::class,'logout'])->name('logout');


Route::middleware(['api.auth'])->group(function () {
    Route::get('/dashboard',[App\Http\Controllers\DashboardController::class,'index'])->name('dashboard');
    Route::get('/services',[App\Http\Controllers\ServiceController::class,'index'])->name('services');
    Route::get('/services/{kode}',[App\Http\Controllers\ServiceController::class,'show'])->name('services.detail');
    Route::get('/service/{kode}/book',[App\Http\Controllers\ServiceController::class,'book'])->name('services.book');
});