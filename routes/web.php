<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FilmController;

Route::get('/', function () {
    return view('home');
})->name('home');

// Route untuk halaman login/register
Route::get('/login', function () {
    return view('auth');
})->name('login');
Route::get('/films', [FilmController::class, 'index'])->name('films.index');
Route::get('/films/{slug}', [FilmController::class, 'show'])->name('films.show');

Route::get('/register', function () {
    return view('auth');
})->name('register');