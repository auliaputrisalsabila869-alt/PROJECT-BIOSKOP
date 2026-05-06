<?php
// app/Http/Controllers/FilmController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FilmController extends Controller
{
    // Data film dummy (nanti bisa diganti dengan database)
    private function getFilms()
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
                'rating' => 4.5,
                'rating_count' => 12500,
                'release_date' => '2024-03-15',
                'age_rating' => 'PG-13',
                'director' => 'Ridley Scott',
                'cast' => ['Matt Damon', 'Jessica Chastain', 'Kristen Wiig'],
                'synopsis' => 'Seorang astronot terjebak di Mars dan harus bertahan hidup dengan sumber daya terbatas.',
                'trailer' => 'https://www.youtube.com/embed/ej3ioOneTy8',
                'is_now_showing' => true,
                'schedules' => [
                    ['time' => '10:00', 'studio' => 'Studio 1', 'price' => 50000],
                    ['time' => '13:30', 'studio' => 'Studio 2', 'price' => 50000],
                    ['time' => '16:45', 'studio' => 'Studio 1', 'price' => 55000],
                    ['time' => '20:00', 'studio' => 'Studio 3', 'price' => 55000],
                ]
            ],
            (object) [
                'id' => 2,
                'judul' => 'Project: Kapali Guru',
                'slug' => 'project-kapali-guru',
                'poster' => '/ylbh.jpg',
                'backdrop' => 'https://image.tmdb.org/t/p/original/8cdWjvZQUExUUTzyp4t6ejM3ZAC.jpg',
                'genre' => 'Drama',
                'duration' => '120 menit',
                'rating' => 3.0,
                'rating_count' => 3200,
                'release_date' => '2024-03-10',
                'age_rating' => 'R',
                'director' => 'Joko Anwar',
                'cast' => ['Reza Rahadian', 'Chicco Jerikho', 'Putri Marino'],
                'synopsis' => 'Sebuah perjalanan emosional tentang pengorbanan dan cinta.',
                'trailer' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'is_now_showing' => true,
                'schedules' => [
                    ['time' => '11:00', 'studio' => 'Studio 2', 'price' => 45000],
                    ['time' => '14:30', 'studio' => 'Studio 1', 'price' => 45000],
                    ['time' => '19:00', 'studio' => 'Studio 2', 'price' => 50000],
                ]
            ],
            (object) [
                'id' => 3,
                'judul' => 'The Spider-Verse',
                'slug' => 'the-spider-verse',
                'poster' => '/spider.jpg',
                'backdrop' => 'https://image.tmdb.org/t/p/original/iiXliCeykkzmJ0Eg9RYJ7F2CWSz.jpg',
                'genre' => 'Animation',
                'duration' => '140 menit',
                'rating' => 5.0,
                'rating_count' => 25000,
                'release_date' => '2024-03-20',
                'age_rating' => 'PG',
                'director' => 'Joaquim Dos Santos',
                'cast' => ['Shameik Moore', 'Hailee Steinfeld', 'Oscar Isaac'],
                'synopsis' => 'Petualangan lintas dimensi Spider-Man yang epik.',
                'trailer' => 'https://www.youtube.com/embed/cqGjhVJWtEg',
                'is_now_showing' => true,
                'schedules' => [
                    ['time' => '09:30', 'studio' => 'Studio 1', 'price' => 50000],
                    ['time' => '12:45', 'studio' => 'Studio 3', 'price' => 50000],
                    ['time' => '15:30', 'studio' => 'Studio 2', 'price' => 55000],
                    ['time' => '18:15', 'studio' => 'Studio 1', 'price' => 55000],
                    ['time' => '21:00', 'studio' => 'Studio 3', 'price' => 60000],
                ]
            ],
            (object) [
                'id' => 4,
                'judul' => 'Ayah Ini Arahnya Kemana',
                'slug' => 'ayah-ini-arahnya-kemana',
                'poster' => '/ayah.jpg',
                'backdrop' => 'https://image.tmdb.org/t/p/original/2ekGiNi6o6CqPmMfkCZBxrbycX7.jpg',
                'genre' => 'Drama, Keluarga',
                'duration' => '172 menit',
                'rating' => 4.8,
                'rating_count' => 8900,
                'release_date' => '2024-03-18',
                'age_rating' => 'PG-13',
                'director' => 'Hanung Bramantyo',
                'cast' => ['Ringgo Agus Rahman', 'Nirina Zubir', 'Deddy Sutomo'],
                'synopsis' => 'Kisah mengharukan tentang perjalanan seorang ayah mencari makna hidup.',
                'trailer' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'is_now_showing' => true,
                'schedules' => [
                    ['time' => '10:30', 'studio' => 'Studio 2', 'price' => 48000],
                    ['time' => '13:00', 'studio' => 'Studio 1', 'price' => 48000],
                    ['time' => '16:00', 'studio' => 'Studio 3', 'price' => 52000],
                    ['time' => '19:30', 'studio' => 'Studio 2', 'price' => 52000],
                ]
            ],
            (object) [
                'id' => 5,
                'judul' => 'Dune: Part Two',
                'slug' => 'dune-part-two',
                'poster' => 'https://image.tmdb.org/t/p/w500/8b8R8l88Qje9dnbOE6hjt2rTxE4.jpg',
                'backdrop' => 'https://image.tmdb.org/t/p/original/8Y43P2jjtbx0RxSRxS5BRFQ20Hs.jpg',
                'genre' => 'Sci-Fi, Epic',
                'duration' => '166 menit',
                'rating' => 4.9,
                'rating_count' => 18700,
                'release_date' => '2024-03-01',
                'age_rating' => 'PG-13',
                'director' => 'Denis Villeneuve',
                'cast' => ['Timothée Chalamet', 'Zendaya', 'Rebecca Ferguson'],
                'synopsis' => 'Kelanjutan epik perjalanan Paul Atreides di planet Arrakis.',
                'trailer' => 'https://www.youtube.com/embed/Way9Dexny3w',
                'is_now_showing' => true,
                'schedules' => [
                    ['time' => '11:00', 'studio' => 'Studio 4', 'price' => 60000],
                    ['time' => '14:30', 'studio' => 'Studio 5', 'price' => 60000],
                    ['time' => '18:00', 'studio' => 'Studio 4', 'price' => 65000],
                    ['time' => '21:30', 'studio' => 'Studio 3', 'price' => 65000],
                ]
            ],
            (object) [
                'id' => 6,
                'judul' => 'Kung Fu Panda 4',
                'slug' => 'kung-fu-panda-4',
                'poster' => 'https://image.tmdb.org/t/p/w500/kDp1vUBnMpe8ak4rjgl3cLELrVc.jpg',
                'backdrop' => 'https://image.tmdb.org/t/p/original/2rvT3KMw0m3VxIetR1FWi1SV5mr.jpg',
                'genre' => 'Animation, Comedy',
                'duration' => '94 menit',
                'rating' => 4.6,
                'rating_count' => 5500,
                'release_date' => '2024-03-08',
                'age_rating' => 'PG',
                'director' => 'Mike Mitchell',
                'cast' => ['Jack Black', 'Awkwafina', 'Viola Davis'],
                'synopsis' => 'Po kembali dengan petualangan baru yang lebih kocak!',
                'trailer' => 'https://www.youtube.com/embed/_inKs4eeHiI',
                'is_now_showing' => true,
                'schedules' => [
                    ['time' => '09:00', 'studio' => 'Studio 2', 'price' => 45000],
                    ['time' => '11:30', 'studio' => 'Studio 1', 'price' => 45000],
                    ['time' => '14:00', 'studio' => 'Studio 2', 'price' => 48000],
                    ['time' => '16:30', 'studio' => 'Studio 4', 'price' => 48000],
                ]
            ],
            (object) [
                'id' => 7,
                'judul' => 'Kupeluk Kamu Selamanya',
                'slug' => 'kupeluk-kamu-selamanya',
                'poster' => null,
                'backdrop' => 'https://image.tmdb.org/t/p/original/z4ImUvrRfPpL1GqUOfrXlK9u8rR.jpg',
                'genre' => 'Romance, Drama',
                'duration' => '110 menit',
                'rating' => 0,
                'rating_count' => 0,
                'release_date' => '2026-04-30',
                'age_rating' => 'PG-13',
                'director' => 'Sutradara Baru',
                'cast' => ['Pemeran 1', 'Pemeran 2'],
                'synopsis' => 'Film romance terbaru yang akan menyentuh hati.',
                'trailer' => null,
                'is_now_showing' => false,
                'schedules' => []
            ],
            (object) [
                'id' => 8,
                'judul' => 'The Devil Wears Prada 2',
                'slug' => 'the-devil-wears-prada-2',
                'poster' => null,
                'backdrop' => 'https://image.tmdb.org/t/p/original/5T2VxK9jKxM5TjY6VxZxVbZzY4Z.jpg',
                'genre' => 'Comedy, Drama',
                'duration' => '120 menit',
                'rating' => 0,
                'rating_count' => 0,
                'release_date' => '2025-12-25',
                'age_rating' => 'PG-13',
                'director' => 'David Frankel',
                'cast' => ['Anne Hathaway', 'Meryl Streep', 'Emily Blunt'],
                'synopsis' => 'Sekuel dari film ikonik tentang dunia fashion.',
                'trailer' => null,
                'is_now_showing' => false,
                'schedules' => []
            ],
        ];
    }

    public function index(Request $request)
    {
        $films = collect($this->getFilms());
        
        // Filter berdasarkan status (now showing / coming soon)
        $status = $request->get('status', 'now_showing');
        if ($status === 'now_showing') {
            $films = $films->filter(function($film) {
                return $film->is_now_showing;
            });
        } elseif ($status === 'coming_soon') {
            $films = $films->filter(function($film) {
                return !$film->is_now_showing;
            });
        }
        
        // Filter berdasarkan genre
        if ($request->has('genre') && $request->genre) {
            $films = $films->filter(function($film) use ($request) {
                return stripos($film->genre, $request->genre) !== false;
            });
        }
        
        // Filter berdasarkan pencarian
        if ($request->has('search') && $request->search) {
            $search = strtolower($request->search);
            $films = $films->filter(function($film) use ($search) {
                return stripos($film->judul, $search) !== false || 
                       stripos($film->genre, $search) !== false ||
                       stripos($film->director, $search) !== false;
            });
        }
        
        // Sorting
        $sort = $request->get('sort', 'newest');
        if ($sort === 'rating') {
            $films = $films->sortByDesc('rating');
        } elseif ($sort === 'title') {
            $films = $films->sortBy('judul');
        } else {
            $films = $films->sortByDesc('release_date');
        }
        
        $genres = ['Action', 'Animation', 'Comedy', 'Drama', 'Sci-Fi', 'Horror', 'Romance', 'Thriller'];
        
        return view('films.index', compact('films', 'genres', 'status', 'sort'));
    }

    public function show($slug)
    {
        $films = collect($this->getFilms());
        $film = $films->firstWhere('slug', $slug);
        
        if (!$film) {
            abort(404);
        }
        
        $recommendations = $films->where('id', '!=', $film->id)
                                 ->where('genre', 'like', '%' . explode(',', $film->genre)[0] . '%')
                                 ->take(4);
        
        return view('films.show', compact('film', 'recommendations'));
    }
}