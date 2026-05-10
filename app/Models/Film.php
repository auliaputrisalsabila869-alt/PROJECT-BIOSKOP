<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Film extends Model
{
    protected $fillable = ['judul', 'sinopsis', 'durasi', 'genre', 'poster'];

    // Accessor untuk slug (dari judul)
    public function getSlugAttribute()
    {
        return Str::slug($this->judul);
    }

    // Accessor untuk duration (alias durasi)
    public function getDurationAttribute()
    {
        return $this->durasi . ' menit';
    }

    // Accessor untuk synopsis (alias sinopsis)
    public function getSynopsisAttribute()
    {
        return $this->sinopsis;
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}