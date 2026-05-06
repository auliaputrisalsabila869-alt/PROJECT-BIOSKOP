<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/films', [FilmController::class, 'index'])->name('films.index');
Route::get('/films/{slug}', [FilmController::class, 'show'])->name('films.show');


Route::middleware('guest')->group(function () {
    Route::get('/daftar',  [AuthController::class, 'showDaftar'])->name('daftar');
    Route::post('/daftar', [AuthController::class, 'daftar']);

    Route::get('/login',   [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',  [AuthController::class, 'login']);
});

// Logout
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');

    // Khusus admin
    Route::middleware('can:admin')->group(function () {
        Route::get('/admin/dashboard', fn() => view('admin.dashboard'))->name('admin.dashboard');
    });
});