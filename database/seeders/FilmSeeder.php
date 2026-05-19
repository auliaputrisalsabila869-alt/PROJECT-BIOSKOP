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
                'backdrop'     => '/bd_martian.jpg',
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
                'judul'        => 'Yang Lain Boleh Hilang Asal Kau Jangan',
                'sinopsis'     => 'Kesha, mahasiswi tingkat akhir sekolah film, harus memilih antara mengejar mimpinya atau pulang untuk merawat ibunya yang perlahan kehilangan ingatan akibat Alzheimer.',
                'durasi'       => 113,
                'genre'        => 'Drama Keluarga',
                'poster'       => '/ylbh.jpg',
                'backdrop'     => '/bd_ylbh.png',
                'rating'       => 4.5,
                'rating_count' => 1200,
                'age_rating'   => '13+',
                'trailer'      => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'director'     => 'Kuntz Agus',
                'cast'         => json_encode(['Lulu Tobing', 'Ibnu Jamil', 'Yasmin Napper', 'Shofia Shireen', 'Jordan Omar']),
                'release_date' => '2026-05-13',
                'status'       => 'now_showing',
            ],

            [
                'judul'        => 'Ayah Ini Arahnya Kemana',
                'sinopsis'     => 'Kisah mengharukan tentang perjalanan seorang ayah mencari makna hidup untuk keluarganya.',
                'durasi'       => 172,
                'genre'        => 'Drama, Keluarga',
                'poster'       => '/ayah.jpg',
                'backdrop'     => '/bd_ayah.jpg',
                'rating'       => 4.8,
                'rating_count' => 8900,
                'age_rating'   => 'PG-13',
                'trailer'      => 'https://www.youtube.com/embed/Cr9EOETsDuU?si=SF0inDcU1l9ZCyZL',
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
                'poster'       => '/dune.png',
                'backdrop'     => '/bd_dune.jpg',
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
                'poster'       => '/panda.png',
                'backdrop'     => '/bd_panda.jpg',
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
                'judul'        => 'The Devil Wears Prada 2',
                'sinopsis'     => 'Sekuel dari film ikonik tentang dunia fashion yang penuh intrik.',
                'durasi'       => 120,
                'genre'        => 'Comedy, Drama',
                'poster'       => '/prada.png',
                'backdrop'     => '/bd_prada.png',
                'rating'       => 0,
                'rating_count' => 0,
                'age_rating'   => 'PG-13',
                'trailer'      => 'https://www.youtube.com/embed/PMd1at7OwiE?si=aB7xo5QuMW3QPXyJ',
                'director'     => 'David Frankel',
                'cast'         => json_encode(['Anne Hathaway', 'Meryl Streep', 'Emily Blunt']),
                'release_date' => '2026-12-25',
                'status'       => 'coming_soon',
            ],

            [
                'judul'        => 'Interstellar',
                'sinopsis'     => 'Sekelompok astronot melakukan perjalanan lintas galaksi untuk mencari planet baru bagi umat manusia.',
                'durasi'       => 169,
                'genre'        => 'Sci-Fi, Adventure',
                'poster'       => '/interstellar.jpg',
                'backdrop'     => '/bd_interstellar.jpg',
                'rating'       => 4.9,
                'rating_count' => 32000,
                'age_rating'   => 'PG-13',
                'trailer'      => 'https://www.youtube.com/embed/zSWdZVtXT7E',
                'director'     => 'Christopher Nolan',
                'cast'         => json_encode(['Matthew McConaughey', 'Anne Hathaway', 'Jessica Chastain']),
                'release_date' => '2024-04-01',
                'status'       => 'now_showing',
            ],

            [
                'judul'        => 'John Wick 4',
                'sinopsis'     => 'John Wick kembali menghadapi organisasi pembunuh internasional dalam pertarungan tanpa ampun.',
                'durasi'       => 169,
                'genre'        => 'Action, Thriller',
                'poster'       => '/johnwick4.png',
                'backdrop'     => '/bd_johnwick4.jpg',
                'rating'       => 4.7,
                'rating_count' => 21000,
                'age_rating'   => 'R',
                'trailer'      => 'https://www.youtube.com/embed/qEVUtrk8_B4',
                'director'     => 'Chad Stahelski',
                'cast'         => json_encode(['Keanu Reeves', 'Donnie Yen', 'Bill Skarsgård']),
                'release_date' => '2024-04-10',
                'status'       => 'now_showing',
            ],

            [
                'judul'        => 'Inside Out 2',
                'sinopsis'     => 'Riley tumbuh remaja dan emosi baru mulai muncul dalam pikirannya.',
                'durasi'       => 105,
                'genre'        => 'Animation, Family',
                'poster'       => '/insideout2.jpg',
                'backdrop'     => '/bd_insideout2.webp',
                'rating'       => 4.8,
                'rating_count' => 9800,
                'age_rating'   => 'PG',
                'trailer'      => 'https://www.youtube.com/embed/LEjhY15eCx0?si=ABrMglE2QBearmBe',
                'director'     => 'Kelsey Mann',
                'cast'         => json_encode(['Amy Poehler', 'Phyllis Smith', 'Lewis Black']),
                'release_date' => '2024-05-01',
                'status'       => 'now_showing',
            ],

            [
                'judul'        => 'Agak Laen 2',
                'sinopsis'     => 'Empat sahabat Bene, Boris, Jegel, dan Oki kembali beraksi dalam petualangan komedi baru. Kali ini mereka menyamar di sebuah panti jompo untuk mengungkap kasus misterius yang penuh kekacauan dan kejadian absurd.',
                'durasi'       => 122,
                'genre'        => 'Comedy, Mystery',
                'poster'       => '/agakLaen.jpg',
                'backdrop'     => '/bd_agakLaen.webp',
                'rating'       => 4.7,
                'rating_count' => 9125,
                'age_rating'   => '13+',
                'trailer'      => 'https://www.youtube.com/embed/fYjJ6zP2Cp0?si=czyfGwlUemKdDUqw',
                'director'     => 'Muhadkly Acho',
                'cast'         => json_encode(['Bene Dion','Boris Bokir','Indra Jegel','Oki Rengga','Tissa Biani']),
                'release_date' => '2025-11-27',
                'status'       => 'now_showing',
            ],

            [
                'judul'        => 'Avengers: Doomsday',
                'sinopsis'     => 'Para Avengers bersatu kembali untuk menghadapi ancaman multiverse yang dapat menghancurkan seluruh realitas. Dengan munculnya musuh baru yang sangat kuat, para pahlawan Marvel harus bekerja sama demi menyelamatkan alam semesta.',
                'durasi'       => 0,
                'genre'        => 'Action, Sci-Fi',
                'poster'       => '/avengers.jpeg',
                'backdrop'     => '/bd_avengers.jpg',
                'rating'       => 0,
                'rating_count' => 0,
                'age_rating'   => 'PG-13',
                'trailer'      => 'https://www.youtube.com/embed/399Ez7WHK5s?si=zy6fKVRcYB1aC0p5',
                'director'     => 'Anthony Russo, Joe Russo',
                'cast'         => json_encode(['Robert Downey Jr.','Tom Holland','Benedict Cumberbatch','Pedro Pascal','Vanessa Kirby']),
                'release_date' => '2027-05-07',
                'status'       => 'coming_soon',
            ],

            [
                'judul'        => 'Final Destination: Bloodlines',
                'sinopsis'     => 'Teror kematian kembali menghantui sekelompok anak muda yang mencoba melarikan diri dari takdir.',
                'durasi'       => 118,
                'genre'        => 'Horror, Thriller',
                'poster'       => 'final.png',
                'backdrop'     => 'bd_final.jpg',
                'rating'       => 0,
                'rating_count' => 0,
                'age_rating'   => 'R',
                'trailer'      => 'https://www.youtube.com/embed/KnWzz0n60pE?si=TgEsQqXpmCrZU0Jl',
                'director'     => 'Zach Lipovsky',
                'cast'         => json_encode(['Brec Bassinger', 'Teo Briones']),
                'release_date' => '2026-10-15',
                'status'       => 'coming_soon',
            ],
            [
                'judul'        => 'The Batman Part II',
                'sinopsis'     => 'Bruce Wayne kembali sebagai Batman dan menghadapi ancaman baru yang lebih misterius dan berbahaya di Gotham City. Saat kekacauan semakin meningkat, Batman harus mengungkap konspirasi gelap yang dapat menghancurkan kota.',
                'durasi'       => 0,
                'genre'        => 'Action, Crime, Drama',
                'poster'       => '/batman.png',
                'backdrop'     => '/bd_batman.png',
                'rating'       => 0,
                'rating_count' => 0,
                'age_rating'   => 'PG-13',
                'trailer'      => null,
                'director'     => 'Matt Reeves',
                'cast'         => json_encode(['Robert Pattinson','Zoë Kravitz','Colin Farrell','Andy Serkis','Jeffrey Wright']),
    'release_date' => '2027-10-01',
            'status'       => 'coming_soon',
            ],
        ];

        foreach ($films as $film) {
            Film::create($film);
        }

        $this->command->info('✅ ' . count($films) . ' film berhasil ditambahkan.');
    }
}