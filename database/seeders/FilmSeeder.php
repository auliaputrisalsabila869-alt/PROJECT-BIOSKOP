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
                'judul'        => 'The Spider-Verse',
                'sinopsis'     => 'Petualangan lintas dimensi Spider-Man yang epik dan penuh warna.',
                'durasi'       => 140,
                'genre'        => 'Animation',
                'poster'       => '/spider.jpg',
                'backdrop'     => '/bd_spider.png',
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
                'backdrop'     => '/bd_ayah.jpg',
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
                'trailer'      => null,
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
                'poster'       => 'https://m.media-amazon.com/images/M/MV5BYWY3MDE2Y2UtOTE3Zi00MGUzLTg2MTItZjE1ZWVkMGVlODRmXkEyXkFqcGc@._V1_FMjpg_UX1000_.jpg',
                'backdrop'     => 'https://images.squarespace-cdn.com/content/v1/60241cb68df65b530cd84d95/1733769830669-KCJQZ4Y9W886JA24NM8R/i170_42.sel1616.155.jpg?format=2500w',
                'rating'       => 4.8,
                'rating_count' => 9800,
                'age_rating'   => 'PG',
                'trailer'      => 'https://www.youtube.com/embed/LEjhY15eCx0',
                'director'     => 'Kelsey Mann',
                'cast'         => json_encode(['Amy Poehler', 'Phyllis Smith', 'Lewis Black']),
                'release_date' => '2024-05-01',
                'status'       => 'now_showing',
            ],

            [
                'judul'        => 'Avengers: Secret Wars',
                'sinopsis'     => 'Para Avengers menghadapi ancaman multiverse terbesar yang pernah ada.',
                'durasi'       => 180,
                'genre'        => 'Action, Sci-Fi',
                'poster'       => 'https://m.media-amazon.com/images/M/MV5BYTQyZTQ5MWQtN2M4NC00YWQwLTg3ZTctM2JiZDE4NDBkZDJkXkEyXkFqcGc@._V1_.jpg',
                'backdrop'     => 'https://image.tmdb.org/t/p/original/yDHYTfA3R0jFYba16jBB1ef8oIt.jpg',
                'rating'       => 0,
                'rating_count' => 0,
                'age_rating'   => 'PG-13',
                'trailer'      => null,
                'director'     => 'Russo Brothers',
                'cast'         => json_encode(['Robert Downey Jr.', 'Tom Holland', 'Benedict Cumberbatch']),
                'release_date' => '2027-05-07',
                'status'       => 'coming_soon',
            ],

            [
                'judul'        => 'Final Destination: Bloodlines',
                'sinopsis'     => 'Teror kematian kembali menghantui sekelompok anak muda yang mencoba melarikan diri dari takdir.',
                'durasi'       => 118,
                'genre'        => 'Horror, Thriller',
                'poster'       => 'https://nos.jkt-1.neo.id/media.cinema21.co.id/movie-images/25FDBL.jpg',
                'backdrop'     => 'https://www.joblo.com/wp-content/uploads/2025/04/final-destination-bloodlines-cast-featured.jpg',
                'rating'       => 0,
                'rating_count' => 0,
                'age_rating'   => 'R',
                'trailer'      => null,
                'director'     => 'Zach Lipovsky',
                'cast'         => json_encode(['Brec Bassinger', 'Teo Briones']),
                'release_date' => '2026-10-15',
                'status'       => 'coming_soon',
            ],
            [
                'judul'        => 'The Batman 2',
                'sinopsis'     => 'Batman menghadapi musuh baru yang lebih gelap dan berbahaya di Gotham City.',
                'durasi'       => 150,
                'genre'        => 'Action, Crime',
                'poster'       => 'https://i.pinimg.com/736x/b8/a1/ef/b8a1efaa69f188061934253d3b2104ac.jpg',
                'backdrop'     => 'https://static0.colliderimages.com/wordpress/wp-content/uploads/2023/02/batman-2-robert-pattinson.jpg?w=1200&h=675&fit=crop',
                'rating'       => 0,
                'rating_count' => 0,
                'age_rating'   => 'PG-13',
                'trailer'      => null,
                'director'     => 'Matt Reeves',
                'cast'         => json_encode(['Robert Pattinson', 'Zoë Kravitz', 'Colin Farrell']),
                'release_date' => '2026-06-19',
                'status'       => 'coming_soon',
            ],
        ];

        foreach ($films as $film) {
            Film::create($film);
        }

        $this->command->info('✅ ' . count($films) . ' film berhasil ditambahkan.');
    }
}