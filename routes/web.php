<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;


Route::get('/', [AuthController::class, 'index'])->name("login");
Route::post('/', [AuthController::class, 'login'])->name("auth.login");
Route::get('/register', [AuthController::class, 'register'])->name("register");
Route::post('/register', [AuthController::class, 'store'])->name("auth.store");

Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

    Route::prefix('posts')->name('post.')->group(function () {
        Route::get('/', [PostController::class, 'post'])->name('retrieve');
        Route::post('/store', [PostController::class, 'storePost'])->name('store');
        Route::get('/show/{post_id}', [PostController::class, 'showPost'])->name('show');
        Route::post('/update', [PostController::class, 'updatePost'])->name('update');
        Route::post('/destroy/{post_id}', [PostController::class, 'destroyPost'])->name('destroy');

        // comments
        Route::post('/comment/store', [PostController::class, 'storeComment'])->name('comment.store');
        Route::get('/comment/show/{comment_id}', [PostController::class, 'showComment'])->name('comment.show');
        Route::post('/comment/update', [PostController::class, 'updateComment'])->name('comment.update');
        Route::post('/comment/destroy/{comment_id}', [PostController::class, 'destroyComment'])->name('comment.destroy');
    });
});
