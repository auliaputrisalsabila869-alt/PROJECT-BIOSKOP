<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Film; // ← TAMBAH INI
use Illuminate\Support\Str;

class FilmController extends Controller
{
    // Data film dummy - TETAP ADA untuk halaman home & detail
    public function getFilms()
    {
        return [
            (object) [
                'id' => 1,
                'judul' => 'The Martian',
                'slug' => 'the-martian',
                'poster' => '/martian.jpg',
                'backdrop' => 'https://image.tmdb.org/t/p/original/5aGhaIHYuQbqlHWvWYqMCnj40y2.jpg',
                'genre' => 'Sci-Fi',
                'duration' => '144 menit',
                'durasi' => 144,
                'rating' => 4.5,
                'rating_count' => 12500,
                'release_date' => '2024-03-15',
                'age_rating' => 'PG-13',
                'director' => 'Ridley Scott',
                'cast' => ['Matt Damon', 'Jessica Chastain', 'Kristen Wiig'],
                'synopsis' => 'Seorang astronot terjebak di Mars dan harus bertahan hidup dengan sumber daya terbatas.',
                'sinopsis' => 'Seorang astronot terjebak di Mars dan harus bertahan hidup dengan sumber daya terbatas.',
                'trailer' => 'https://www.youtube.com/embed/ej3ioOneTy8',
                'is_now_showing' => true,
                'schedules' => [],
            ],
            (object) [
                'id' => 2,
                'judul' => 'Project: Kapali Guru',
                'slug' => 'project-kapali-guru',
                'poster' => '/ylbh.jpg',
                'backdrop' => 'https://image.tmdb.org/t/p/original/8cdWjvZQUExUUTzyp4t6ejM3ZAC.jpg',
                'genre' => 'Drama',
                'duration' => '120 menit',
                'durasi' => 120,
                'rating' => 3.0,
                'rating_count' => 3200,
                'release_date' => '2024-03-10',
                'age_rating' => 'R',
                'director' => 'Joko Anwar',
                'cast' => ['Reza Rahadian', 'Chicco Jerikho', 'Putri Marino'],
                'synopsis' => 'Sebuah perjalanan emosional tentang pengorbanan dan cinta.',
                'sinopsis' => 'Sebuah perjalanan emosional tentang pengorbanan dan cinta.',
                'trailer' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'is_now_showing' => true,
                'schedules' => [],
            ],
            (object) [
                'id' => 3,
                'judul' => 'The Spider-Verse',
                'slug' => 'the-spider-verse',
                'poster' => '/spider.jpg',
                'backdrop' => 'https://image.tmdb.org/t/p/original/iiXliCeykkzmJ0Eg9RYJ7F2CWSz.jpg',
                'genre' => 'Animation',
                'duration' => '140 menit',
                'durasi' => 140,
                'rating' => 5.0,
                'rating_count' => 25000,
                'release_date' => '2024-03-20',
                'age_rating' => 'PG',
                'director' => 'Joaquim Dos Santos',
                'cast' => ['Shameik Moore', 'Hailee Steinfeld', 'Oscar Isaac'],
                'synopsis' => 'Petualangan lintas dimensi Spider-Man yang epik.',
                'sinopsis' => 'Petualangan lintas dimensi Spider-Man yang epik.',
                'trailer' => 'https://www.youtube.com/embed/cqGjhVJWtEg',
                'is_now_showing' => true,
                'schedules' => [],
            ],
            (object) [
                'id' => 4,
                'judul' => 'Ayah Ini Arahnya Kemana',
                'slug' => 'ayah-ini-arahnya-kemana',
                'poster' => '/ayah.jpg',
                'backdrop' => 'https://image.tmdb.org/t/p/original/2ekGiNi6o6CqPmMfkCZBxrbycX7.jpg',
                'genre' => 'Drama, Keluarga',
                'duration' => '172 menit',
                'durasi' => 172,
                'rating' => 4.8,
                'rating_count' => 8900,
                'release_date' => '2024-03-18',
                'age_rating' => 'PG-13',
                'director' => 'Hanung Bramantyo',
                'cast' => ['Ringgo Agus Rahman', 'Nirina Zubir', 'Deddy Sutomo'],
                'synopsis' => 'Kisah mengharukan tentang perjalanan seorang ayah mencari makna hidup.',
                'sinopsis' => 'Kisah mengharukan tentang perjalanan seorang ayah mencari makna hidup.',
                'trailer' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'is_now_showing' => true,
                'schedules' => [],
            ],
            (object) [
                'id' => 5,
                'judul' => 'Dune: Part Two',
                'slug' => 'dune-part-two',
                'poster' => 'https://image.tmdb.org/t/p/w500/8b8R8l88Qje9dnbOE6hjt2rTxE4.jpg',
                'backdrop' => 'https://image.tmdb.org/t/p/original/8Y43P2jjtbx0RxSRxS5BRFQ20Hs.jpg',
                'genre' => 'Sci-Fi, Epic',
                'duration' => '166 menit',
                'durasi' => 166,
                'rating' => 4.9,
                'rating_count' => 18700,
                'release_date' => '2024-03-01',
                'age_rating' => 'PG-13',
                'director' => 'Denis Villeneuve',
                'cast' => ['Timothée Chalamet', 'Zendaya', 'Rebecca Ferguson'],
                'synopsis' => 'Kelanjutan epik perjalanan Paul Atreides di planet Arrakis.',
                'sinopsis' => 'Kelanjutan epik perjalanan Paul Atreides di planet Arrakis.',
                'trailer' => 'https://www.youtube.com/embed/Way9Dexny3w',
                'is_now_showing' => true,
                'schedules' => [],
            ],
            (object) [
                'id' => 6,
                'judul' => 'Kung Fu Panda 4',
                'slug' => 'kung-fu-panda-4',
                'poster' => 'https://image.tmdb.org/t/p/w500/kDp1vUBnMpe8ak4rjgl3cLELrVc.jpg',
                'backdrop' => 'https://image.tmdb.org/t/p/original/2rvT3KMw0m3VxIetR1FWi1SV5mr.jpg',
                'genre' => 'Animation, Comedy',
                'duration' => '94 menit',
                'durasi' => 94,
                'rating' => 4.6,
                'rating_count' => 5500,
                'release_date' => '2024-03-08',
                'age_rating' => 'PG',
                'director' => 'Mike Mitchell',
                'cast' => ['Jack Black', 'Awkwafina', 'Viola Davis'],
                'synopsis' => 'Po kembali dengan petualangan baru yang lebih kocak!',
                'sinopsis' => 'Po kembali dengan petualangan baru yang lebih kocak!',
                'trailer' => 'https://www.youtube.com/embed/_inKs4eeHiI',
                'is_now_showing' => true,
                'schedules' => [],
            ],
            (object) [
                'id' => 7,
                'judul' => 'Kupeluk Kamu Selamanya',
                'slug' => 'kupeluk-kamu-selamanya',
                'poster' => null,
                'backdrop' => 'https://image.tmdb.org/t/p/original/z4ImUvrRfPpL1GqUOfrXlK9u8rR.jpg',
                'genre' => 'Romance, Drama',
                'duration' => '110 menit',
                'durasi' => 110,
                'rating' => 0,
                'rating_count' => 0,
                'release_date' => '2026-04-30',
                'age_rating' => 'PG-13',
                'director' => 'Sutradara Baru',
                'cast' => ['Pemeran 1', 'Pemeran 2'],
                'synopsis' => 'Film romance terbaru yang akan menyentuh hati.',
                'sinopsis' => 'Film romance terbaru yang akan menyentuh hati.',
                'trailer' => null,
                'is_now_showing' => false,
                'schedules' => [],
            ],
            (object) [
                'id' => 8,
                'judul' => 'The Devil Wears Prada 2',
                'slug' => 'the-devil-wears-prada-2',
                'poster' => null,
                'backdrop' => 'https://image.tmdb.org/t/p/original/5T2VxK9jKxM5TjY6VxZxVbZzY4Z.jpg',
                'genre' => 'Comedy, Drama',
                'duration' => '120 menit',
                'durasi' => 120,
                'rating' => 0,
                'rating_count' => 0,
                'release_date' => '2025-12-25',
                'age_rating' => 'PG-13',
                'director' => 'David Frankel',
                'cast' => ['Anne Hathaway', 'Meryl Streep', 'Emily Blunt'],
                'synopsis' => 'Sekuel dari film ikonik tentang dunia fashion.',
                'sinopsis' => 'Sekuel dari film ikonik tentang dunia fashion.',
                'trailer' => null,
                'is_now_showing' => false,
                'schedules' => [],
            ],
        ];
    }

    // ← SATU method index, ambil dari DATABASE
    public function index(Request $request)
    {
        $query = Film::query();

        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%')
                  ->orWhere('genre', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('genre')) {
            $query->where('genre', 'like', '%' . $request->genre . '%');
        }

        $sort = $request->get('sort', 'newest');
        if ($sort === 'title') {
            $query->orderBy('judul');
        } else {
            $query->latest();
        }

        $films  = $query->get();
        $genres = ['Action', 'Animation', 'Comedy', 'Drama', 'Sci-Fi', 'Horror', 'Romance'];
        $status = $request->get('status', 'now_showing');

        return view('films.index', compact('films', 'genres', 'status', 'sort'));
    }

    // ← SATU method show, cari dari DATABASE by slug
    public function show($slug)
    {
        $films = Film::all();
        $film  = $films->first(function ($f) use ($slug) {
            return Str::slug($f->judul) === $slug;
        });

        if (!$film) {
            // Fallback cari di dummy (untuk film yang belum di DB)
            $dummyFilms = collect($this->getFilms());
            $film = $dummyFilms->firstWhere('slug', $slug);
        }

        if (!$film) {
            abort(404);
        }

        // Rekomendasi
        if ($film instanceof \App\Models\Film) {
            $allFilms = Film::where('id', '!=', $film->id)->get();
            $recommendations = $allFilms->filter(function ($f) use ($film) {
                return str_contains(
                    strtolower($f->genre),
                    strtolower(explode(',', $film->genre)[0])
                );
            })->take(4);
        } else {
            $dummyFilms = collect($this->getFilms());
            $recommendations = $dummyFilms->where('id', '!=', $film->id)->take(4);
        }

        return view('films.show', compact('film', 'recommendations'));
    }
}