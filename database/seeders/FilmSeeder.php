<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Film;

class FilmSeeder extends Seeder
{
    public function run(): void
    {
        // Matikan foreign key check dulu
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Film::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $films = [
            [
                'judul'        => 'The Martian',
                'sinopsis'     => 'Seorang astronot terjebak di Mars dan harus bertahan hidup dengan sumber daya terbatas sambil menunggu tim penyelamat.',
                'durasi'       => 144,
                'genre'        => 'Sci-Fi',
                'poster'       => '/martian.jpg',
                'rating'       => 4.5,
                'rating_count' => 12500,
                'age_rating'   => 'PG-13',
            ],
            [
                'judul'        => 'Project: Kapali Guru',
                'sinopsis'     => 'Sebuah perjalanan emosional tentang pengorbanan dan cinta yang mengharukan.',
                'durasi'       => 120,
                'genre'        => 'Drama',
                'poster'       => '/ylbh.jpg',
                'rating'       => 3.0,
                'rating_count' => 3200,
                'age_rating'   => 'R',
            ],
            [
                'judul'        => 'The Spider-Verse',
                'sinopsis'     => 'Petualangan lintas dimensi Spider-Man yang epik dan penuh warna.',
                'durasi'       => 140,
                'genre'        => 'Animation',
                'poster'       => '/spider.jpg',
                'rating'       => 5.0,
                'rating_count' => 25000,
                'age_rating'   => 'PG',
            ],
            [
                'judul'        => 'Ayah Ini Arahnya Kemana',
                'sinopsis'     => 'Kisah mengharukan tentang perjalanan seorang ayah mencari makna hidup untuk keluarganya.',
                'durasi'       => 172,
                'genre'        => 'Drama, Keluarga',
                'poster'       => '/ayah.jpg',
                'rating'       => 4.8,
                'rating_count' => 8900,
                'age_rating'   => 'PG-13',
            ],
            [
                'judul'        => 'Dune: Part Two',
                'sinopsis'     => 'Kelanjutan epik perjalanan Paul Atreides di planet Arrakis melawan kekuatan jahat.',
                'durasi'       => 166,
                'genre'        => 'Sci-Fi, Epic',
                'poster'       => 'https://image.tmdb.org/t/p/w500/8b8R8l88Qje9dnbOE6hjt2rTxE4.jpg',
                'rating'       => 4.9,
                'rating_count' => 18700,
                'age_rating'   => 'PG-13',
            ],
            [
                'judul'        => 'Kung Fu Panda 4',
                'sinopsis'     => 'Po kembali dengan petualangan baru yang lebih kocak dan penuh kejutan!',
                'durasi'       => 94,
                'genre'        => 'Animation, Comedy',
                'poster'       => 'https://image.tmdb.org/t/p/w500/kDp1vUBnMpe8ak4rjgl3cLELrVc.jpg',
                'rating'       => 4.6,
                'rating_count' => 5500,
                'age_rating'   => 'PG',
            ],
            [
                'judul'        => 'Yang Lain Boleh Hilang Asal Kau Jangan',
                'sinopsis'     => 'Kisah cinta yang menyentuh hati tentang kesetiaan dan pengorbanan.',
                'durasi'       => 113,
                'genre'        => 'Drama',
                'poster'       => '/ylbh.jpg',
                'rating'       => 4.2,
                'rating_count' => 6700,
                'age_rating'   => 'PG-13',
            ],
        ];

        foreach ($films as $film) {
            Film::create($film);
        }

        $this->command->info('✅ Film seeder selesai: ' . count($films) . ' film ditambahkan.');
    }
}