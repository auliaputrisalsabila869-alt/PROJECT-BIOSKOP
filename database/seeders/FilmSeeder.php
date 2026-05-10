<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Film;

class FilmSeeder extends Seeder
{
    public function run(): void
    {
        $films = [
            [
                'judul'    => 'The Martian',
                'sinopsis' => 'Seorang astronot terjebak di Mars dan harus bertahan hidup dengan sumber daya terbatas sambil menunggu tim penyelamat.',
                'durasi'   => 144,
                'genre'    => 'Sci-Fi',
                'poster'   => '/martian.jpg',
            ],
            [
                'judul'    => 'Project: Kapali Guru',
                'sinopsis' => 'Sebuah perjalanan emosional tentang pengorbanan dan cinta yang mengharukan.',
                'durasi'   => 120,
                'genre'    => 'Drama',
                'poster'   => '/ylbh.jpg',
            ],
            [
                'judul'    => 'The Spider-Verse',
                'sinopsis' => 'Petualangan lintas dimensi Spider-Man yang epik dan penuh warna.',
                'durasi'   => 140,
                'genre'    => 'Animation',
                'poster'   => '/spider.jpg',
            ],
            [
                'judul'    => 'Ayah Ini Arahnya Kemana',
                'sinopsis' => 'Kisah mengharukan tentang perjalanan seorang ayah mencari makna hidup untuk keluarganya.',
                'durasi'   => 172,
                'genre'    => 'Drama, Keluarga',
                'poster'   => '/ayah.jpg',
            ],
            [
                'judul'    => 'Dune: Part Two',
                'sinopsis' => 'Kelanjutan epik perjalanan Paul Atreides di planet Arrakis melawan kekuatan jahat.',
                'durasi'   => 166,
                'genre'    => 'Sci-Fi, Epic',
                'poster'   => 'https://image.tmdb.org/t/p/w500/8b8R8l88Qje9dnbOE6hjt2rTxE4.jpg',
            ],
            [
                'judul'    => 'Kung Fu Panda 4',
                'sinopsis' => 'Po kembali dengan petualangan baru yang lebih kocak dan penuh kejutan!',
                'durasi'   => 94,
                'genre'    => 'Animation, Comedy',
                'poster'   => 'https://image.tmdb.org/t/p/w500/kDp1vUBnMpe8ak4rjgl3cLELrVc.jpg',
            ],
        ];

        foreach ($films as $film) {
            Film::create($film);
        }

        $this->command->info('✅ Film seeder selesai: ' . count($films) . ' film ditambahkan.');
    }
}