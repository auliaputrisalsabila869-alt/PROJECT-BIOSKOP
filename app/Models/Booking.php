<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = ['user_id', 'schedule_id', 'kode_booking', 'jumlah_tiket', 'total_harga', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function bookingSeats()
    {
        return $this->hasMany(BookingSeat::class);
    }

    public function getSeatsAttribute()
    {
        return $this->bookingSeats()->with('seat')->get()->map(function($bs) {
            return $bs->seat->nomor_kursi;
        })->toArray();
    }
}