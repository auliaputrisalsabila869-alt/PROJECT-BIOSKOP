<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    protected $fillable = ['judul', 'sinopsis', 'durasi', 'genre', 'poster'];
}

