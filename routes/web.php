<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


Route::get('/', [AuthController::class, 'index'])->name("login");
Route::post('/', [AuthController::class, 'login'])->name("auth.login");
Route::get('/register', [AuthController::class, 'register'])->name("register");
Route::post('/register', [AuthController::class, 'store'])->name("auth.store");

Route::middleware(['auth'])->group(function (){
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
});
