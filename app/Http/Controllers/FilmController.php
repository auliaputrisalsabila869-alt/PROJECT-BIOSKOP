<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Film;
use Illuminate\Support\Str;

class FilmController extends Controller
{   
    public function home()
{
    $nowShowing = Film::where('status', 'now_showing')
        ->latest()
        ->take(5)
        ->get();

    $comingSoon = Film::where('status', 'coming_soon')
        ->orderBy('release_date')
        ->take(4)
        ->get();

    return view('home', compact('nowShowing', 'comingSoon'));
}

    public function index(Request $request)
    {
        $search = $request->get('search');
        $sort   = $request->get('sort', 'newest');

        // Now Showing
        $nowShowingQuery = Film::where('status', 'now_showing');

        if ($search) {
            $nowShowingQuery->where(function($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                  ->orWhere('genre', 'like', '%' . $search . '%')
                  ->orWhere('director', 'like', '%' . $search . '%');
            });
        }

        if ($sort === 'rating') {
            $nowShowingQuery->orderByDesc('rating');
        } elseif ($sort === 'title') {
            $nowShowingQuery->orderBy('judul');
        } else {
            $nowShowingQuery->latest();
        }

        $nowShowing = $nowShowingQuery->get();

        // Coming Soon
        $comingSoonQuery = Film::where('status', 'coming_soon');

        if ($search) {
            $comingSoonQuery->where(function($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                  ->orWhere('genre', 'like', '%' . $search . '%');
            });
        }

        $comingSoon = $comingSoonQuery->orderBy('release_date')->get();

        $genres = ['Action', 'Animation', 'Comedy', 'Drama', 'Sci-Fi', 'Horror', 'Romance'];

        return view('films.index', compact('nowShowing', 'comingSoon', 'genres', 'sort', 'search'));
    }

    public function show($slug)
    {
        // Cari dari database
        $films = Film::all();
        $film  = $films->first(fn($f) => Str::slug($f->judul) === $slug);

        if (!$film) {
            abort(404);
        }

        // Cast dari JSON string ke array
        if (is_string($film->cast)) {
            $film->cast = json_decode($film->cast, true) ?? [];
        }

        $recommendations = Film::where('id', '!=', $film->id)
            ->where('status', 'now_showing')
            ->where('genre', 'like', '%' . explode(',', $film->genre)[0] . '%')
            ->take(4)
            ->get();

        return view('films.show', compact('film', 'recommendations'));
    }

    // =========================
    // STORE FILM
    // =========================
    public function store(Request $request)
    {
        $request->validate([
            'judul'    => 'required|string|max:255',
            'sinopsis' => 'required|string',
            'durasi'   => 'required|integer|min:1',
            'genre'    => 'required|string',
            'poster'   => 'nullable|image|max:2048',
        ]);

        $posterPath = null;

        if ($request->hasFile('poster')) {
            $posterPath = '/storage/' . $request->file('poster')->store('posters', 'public');
        } elseif ($request->filled('poster_url')) {
            $posterPath = $request->poster_url;
        }

        Film::create([
            'judul'        => $request->judul,
            'sinopsis'     => $request->sinopsis,
            'durasi'       => $request->durasi,
            'genre'        => $request->genre,
            'poster'       => $posterPath,
            'rating'       => $request->rating ?? 0,
            'rating_count' => 0,
            'age_rating'   => $request->age_rating ?? 'PG-13',
            'trailer'      => $request->trailer,
            'director'     => $request->director,
            'backdrop'     => $request->backdrop,
            'release_date' => $request->release_date,
            'status'       => $request->status ?? 'now_showing',
        ]);

        return redirect()->route('admin.films.index')
            ->with('success', 'Film "' . $request->judul . '" berhasil ditambahkan!');
    }

    // =========================
    // UPDATE FILM
    // =========================
    public function update(Request $request, Film $film)
    {
        $request->validate([
            'judul'    => 'required|string|max:255',
            'sinopsis' => 'required|string',
            'durasi'   => 'required|integer|min:1',
            'genre'    => 'required|string',
            'poster'   => 'nullable|image|max:2048',
        ]);

        $posterPath = $film->poster;

        if ($request->hasFile('poster')) {
            $posterPath = '/storage/' . $request->file('poster')->store('posters', 'public');
        } elseif ($request->filled('poster_url')) {
            $posterPath = $request->poster_url;
        }

        $film->update([
            'judul'        => $request->judul,
            'sinopsis'     => $request->sinopsis,
            'durasi'       => $request->durasi,
            'genre'        => $request->genre,
            'poster'       => $posterPath,
            'rating'       => $request->rating ?? $film->rating,
            'age_rating'   => $request->age_rating ?? $film->age_rating,
            'trailer'      => $request->trailer,
            'director'     => $request->director,
            'backdrop'     => $request->backdrop,
            'release_date' => $request->release_date,
            'status'       => $request->status ?? $film->status,
        ]);

        return redirect()->route('admin.films.index')
            ->with('success', 'Film berhasil diupdate!');
    }
}