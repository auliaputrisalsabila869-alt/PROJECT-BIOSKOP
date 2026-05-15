<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\FilmAdminController;
use App\Http\Controllers\Admin\JadwalAdminController;
use App\Http\Controllers\Admin\KursiAdminController;
use App\Http\Controllers\Admin\BookingAdminController;
use App\Http\Controllers\Admin\LaporanAdminController;

// === HOME ===
Route::get('/', [FilmController::class, 'home'])->name('home');

// === AUTH ROUTES ===
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('daftar');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// === FILM ROUTES ===
Route::get('/films', [FilmController::class, 'index'])->name('films.index');
Route::get('/films/{slug}', [FilmController::class, 'show'])->name('films.show');

// === BOOKING ROUTES (harus login) ===
Route::middleware(['auth'])->group(function () {
    Route::get('/booking/film/{filmId}/studio', [BookingController::class, 'selectStudio'])->name('booking.select-studio');
    Route::get('/booking/film/{filmId}/schedule', [BookingController::class, 'selectSchedule'])->name('booking.select-schedule');
    Route::get('/booking/schedule/{scheduleId}/seats', [BookingController::class, 'selectSeats'])->name('booking.select-seats');
    Route::post('/booking/schedule/{scheduleId}/process', [BookingController::class, 'processBooking'])->name('booking.process');
    Route::get('/booking/{bookingId}/payment', [BookingController::class, 'payment'])->name('booking.payment');
    Route::post('/booking/{bookingId}/payment', [BookingController::class, 'processPayment'])->name('booking.process-payment');
    Route::get('/booking/{bookingId}/success', [BookingController::class, 'success'])->name('booking.success');
    Route::get('/my-bookings', [BookingController::class, 'history'])->name('booking.history');
    Route::get('/my-tickets', [BookingController::class, 'myTickets'])->name('booking.my-tickets');
});

/// === ADMIN ROUTES (harus login + admin) ===
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    // Film
    Route::resource('films', FilmAdminController::class);

    // Jadwal - kembali ke resource biasa
    Route::resource('jadwal', JadwalAdminController::class);

    // Kursi
    Route::get('kursi', [KursiAdminController::class, 'index'])->name('kursi.index');
    Route::post('kursi/generate', [KursiAdminController::class, 'generate'])->name('kursi.generate');
    Route::delete('kursi/{seat}', [KursiAdminController::class, 'destroy'])->name('kursi.destroy');

    // Booking
    Route::get('bookings', [BookingAdminController::class, 'index'])->name('bookings.index');
    Route::patch('bookings/{booking}/status', [BookingAdminController::class, 'updateStatus'])->name('bookings.update-status');

    // Laporan
    Route::get('laporan', [LaporanAdminController::class, 'index'])->name('laporan.index');
});