<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Film;

class FilmSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Film::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $films = [
            [
                'judul'        => 'The Martian',
                'sinopsis'     => 'Seorang astronot terjebak di Mars dan harus bertahan hidup dengan sumber daya terbatas sambil menunggu tim penyelamat dari Bumi.',
                'durasi'       => 144,
                'genre'        => 'Sci-Fi',
                'poster'       => '/martian.jpg',
                'backdrop'     => 'https://image.tmdb.org/t/p/original/5aGhaIHYuQbqlHWvWYqMCnj40y2.jpg',
                'rating'       => 4.5,
                'rating_count' => 12500,
                'age_rating'   => 'PG-13',
                'trailer'      => 'https://www.youtube.com/embed/ej3ioOneTy8',
                'director'     => 'Ridley Scott',
                'cast'         => json_encode(['Matt Damon', 'Jessica Chastain', 'Kristen Wiig']),
                'release_date' => '2024-03-15',
                'status'       => 'now_showing',
            ],
            [
                'judul'        => 'Project: Kapali Guru',
                'sinopsis'     => 'Sebuah perjalanan emosional tentang pengorbanan dan cinta yang mengharukan.',
                'durasi'       => 120,
                'genre'        => 'Drama',
                'poster'       => '/ylbh.jpg',
                'backdrop'     => 'https://image.tmdb.org/t/p/original/8cdWjvZQUExUUTzyp4t6ejM3ZAC.jpg',
                'rating'       => 3.0,
                'rating_count' => 3200,
                'age_rating'   => 'R',
                'trailer'      => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'director'     => 'Joko Anwar',
                'cast'         => json_encode(['Reza Rahadian', 'Chicco Jerikho', 'Putri Marino']),
                'release_date' => '2024-03-10',
                'status'       => 'now_showing',
            ],
            [
                'judul'        => 'The Spider-Verse',
                'sinopsis'     => 'Petualangan lintas dimensi Spider-Man yang epik dan penuh warna.',
                'durasi'       => 140,
                'genre'        => 'Animation',
                'poster'       => '/spider.jpg',
                'backdrop'     => 'https://image.tmdb.org/t/p/original/iiXliCeykkzmJ0Eg9RYJ7F2CWSz.jpg',
                'rating'       => 5.0,
                'rating_count' => 25000,
                'age_rating'   => 'PG',
                'trailer'      => 'https://www.youtube.com/embed/cqGjhVJWtEg',
                'director'     => 'Joaquim Dos Santos',
                'cast'         => json_encode(['Shameik Moore', 'Hailee Steinfeld', 'Oscar Isaac']),
                'release_date' => '2024-03-20',
                'status'       => 'now_showing',
            ],
            [
                'judul'        => 'Ayah Ini Arahnya Kemana',
                'sinopsis'     => 'Kisah mengharukan tentang perjalanan seorang ayah mencari makna hidup untuk keluarganya.',
                'durasi'       => 172,
                'genre'        => 'Drama, Keluarga',
                'poster'       => '/ayah.jpg',
                'backdrop'     => 'https://image.tmdb.org/t/p/original/2ekGiNi6o6CqPmMfkCZBxrbycX7.jpg',
                'rating'       => 4.8,
                'rating_count' => 8900,
                'age_rating'   => 'PG-13',
                'trailer'      => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'director'     => 'Hanung Bramantyo',
                'cast'         => json_encode(['Ringgo Agus Rahman', 'Nirina Zubir', 'Deddy Sutomo']),
                'release_date' => '2024-03-18',
                'status'       => 'now_showing',
            ],
            [
                'judul'        => 'Dune: Part Two',
                'sinopsis'     => 'Kelanjutan epik perjalanan Paul Atreides di planet Arrakis melawan kekuatan jahat.',
                'durasi'       => 166,
                'genre'        => 'Sci-Fi, Epic',
                'poster'       => 'https://image.tmdb.org/t/p/w500/8b8R8l88Qje9dnbOE6hjt2rTxE4.jpg',
                'backdrop'     => 'https://image.tmdb.org/t/p/original/8Y43P2jjtbx0RxSRxS5BRFQ20Hs.jpg',
                'rating'       => 4.9,
                'rating_count' => 18700,
                'age_rating'   => 'PG-13',
                'trailer'      => 'https://www.youtube.com/embed/Way9Dexny3w',
                'director'     => 'Denis Villeneuve',
                'cast'         => json_encode(['Timothée Chalamet', 'Zendaya', 'Rebecca Ferguson']),
                'release_date' => '2024-03-01',
                'status'       => 'now_showing',
            ],
            [
                'judul'        => 'Kung Fu Panda 4',
                'sinopsis'     => 'Po kembali dengan petualangan baru yang lebih kocak dan penuh kejutan!',
                'durasi'       => 94,
                'genre'        => 'Animation, Comedy',
                'poster'       => 'https://image.tmdb.org/t/p/w500/kDp1vUBnMpe8ak4rjgl3cLELrVc.jpg',
                'backdrop'     => 'https://image.tmdb.org/t/p/original/2rvT3KMw0m3VxIetR1FWi1SV5mr.jpg',
                'rating'       => 4.6,
                'rating_count' => 5500,
                'age_rating'   => 'PG',
                'trailer'      => 'https://www.youtube.com/embed/_inKs4eeHiI',
                'director'     => 'Mike Mitchell',
                'cast'         => json_encode(['Jack Black', 'Awkwafina', 'Viola Davis']),
                'release_date' => '2024-03-08',
                'status'       => 'now_showing',
            ],
            [
                'judul'        => 'Kupeluk Kamu Selamanya',
                'sinopsis'     => 'Film romance terbaru yang akan menyentuh hati tentang kesetiaan dan cinta sejati.',
                'durasi'       => 110,
                'genre'        => 'Romance, Drama',
                'poster'       => null,
                'backdrop'     => 'https://image.tmdb.org/t/p/original/z4ImUvrRfPpL1GqUOfrXlK9u8rR.jpg',
                'rating'       => 0,
                'rating_count' => 0,
                'age_rating'   => 'PG-13',
                'trailer'      => null,
                'director'     => 'Sutradara Baru',
                'cast'         => json_encode(['Pemeran 1', 'Pemeran 2']),
                'release_date' => '2026-06-30',
                'status'       => 'coming_soon',
            ],
            [
                'judul'        => 'The Devil Wears Prada 2',
                'sinopsis'     => 'Sekuel dari film ikonik tentang dunia fashion yang penuh intrik.',
                'durasi'       => 120,
                'genre'        => 'Comedy, Drama',
                'poster'       => null,
                'backdrop'     => null,
                'rating'       => 0,
                'rating_count' => 0,
                'age_rating'   => 'PG-13',
                'trailer'      => null,
                'director'     => 'David Frankel',
                'cast'         => json_encode(['Anne Hathaway', 'Meryl Streep', 'Emily Blunt']),
                'release_date' => '2026-12-25',
                'status'       => 'coming_soon',
            ],
        ];

        foreach ($films as $film) {
            Film::create($film);
        }

        $this->command->info('✅ ' . count($films) . ' film berhasil ditambahkan.');
    }
}