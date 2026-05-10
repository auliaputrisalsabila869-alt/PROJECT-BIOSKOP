<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Film extends Model
{
    protected $fillable = [
        'judul', 'sinopsis', 'durasi', 'genre', 'poster',
        'rating', 'rating_count', 'age_rating'
    ];

    public function getSlugAttribute()
    {
        return Str::slug($this->judul);
    }

    public function getDurationAttribute()
    {
        return $this->durasi . ' menit';
    }

    public function getSynopsisAttribute()
    {
        return $this->sinopsis;
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}