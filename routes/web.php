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
use App\Http\Controllers\BookingController;

// Booking Routes (harus login)
Route::middleware(['auth'])->group(function () {
    Route::get('/booking/film/{filmId}/schedule', [BookingController::class, 'selectSchedule'])->name('booking.select-schedule');
    Route::get('/booking/schedule/{scheduleId}/seats', [BookingController::class, 'selectSeats'])->name('booking.select-seats');
    Route::post('/booking/schedule/{scheduleId}/process', [BookingController::class, 'processBooking'])->name('booking.process');
    Route::get('/booking/{bookingId}/payment', [BookingController::class, 'payment'])->name('booking.payment');
    Route::post('/booking/{bookingId}/payment', [BookingController::class, 'processPayment'])->name('booking.process-payment');
    Route::get('/booking/{bookingId}/success', [BookingController::class, 'success'])->name('booking.success');
    Route::get('/my-bookings', [BookingController::class, 'history'])->name('booking.history');
    Route::get('/my-tickets', [BookingController::class, 'myTickets'])->name('booking.my-tickets');
});