<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Schedule extends Model
{
    protected $fillable = ['film_id', 'studio_id', 'tanggal', 'waktu_mulai', 'waktu_selesai', 'harga'];

    protected $casts = [
        'tanggal' => 'date',
        'waktu_mulai' => 'datetime',
        'waktu_selesai' => 'datetime',
    ];

    public function film()
    {
        return $this->belongsTo(Film::class);
    }

    public function studio()
    {
        return $this->belongsTo(Studio::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // Mendapatkan kursi yang sudah terbooking untuk jadwal ini
    public function getBookedSeatsAttribute()
    {
        $bookedSeatIds = [];
        foreach ($this->bookings as $booking) {
            foreach ($booking->bookingSeats as $bookingSeat) {
                $bookedSeatIds[] = $bookingSeat->seat_id;
            }
        }
        return $bookedSeatIds;
    }

    // Format waktu tayang
    public function getWaktuTayangAttribute()
    {
        return Carbon::parse($this->waktu_mulai)->format('H:i');
    }

    // Format tanggal
    public function getTanggalFormattedAttribute()
    {
        return Carbon::parse($this->tanggal)->translatedFormat('l, d F Y');
    }
}