<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;
use App\Services\AuthorService;

Route::get('/', [AuthController::class, 'login'])->name('login');
Route::post('check_login', [AuthController::class, 'check_login'])->name('check_login');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Book
    Route::resource('/book', BookController::class);
    
    // Author
    Route::get('/view_books/{author_id}', [AuthorController::class, 'view_books'])->name('view_books');
    Route::resource('/author', AuthorController::class);

    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
});
