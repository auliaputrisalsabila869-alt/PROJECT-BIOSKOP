<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Film;
use Illuminate\Http\Request;

class FilmAdminController extends Controller
{
    public function index()
    {
        $films = Film::latest()->paginate(10);
        return view('admin.films.index', compact('films'));
    }

    public function create()
    {
        return view('admin.films.create');
    }

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

        // Handle cast - konversi string ke array
        $castData = null;
        if ($request->filled('cast')) {
            $castData = array_values(array_filter(
                array_map('trim', explode(',', $request->cast))
            ));
        }

        Film::create([
            'judul'        => $request->judul,
            'sinopsis'     => $request->sinopsis,
            'durasi'       => $request->durasi,
            'genre'        => $request->genre,
            'poster'       => $posterPath,
            'rating'       => $request->rating ?? 0,
            'rating_count' => $request->rating_count ?? 0,
            'age_rating'   => $request->age_rating ?? 'PG-13',
            'trailer'      => $request->trailer,
            'director'     => $request->director,
            'cast'         => $castData,
            'backdrop'     => $request->backdrop,
            'release_date' => $request->release_date ?: null,
            'status'       => $request->status ?? 'now_showing',
        ]);

        return redirect()->route('admin.films.index')
            ->with('success', 'Film "' . $request->judul . '" berhasil ditambahkan!');
    }

    public function edit(Film $film)
    {
        return view('admin.films.edit', compact('film'));
    }

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

        // Handle cast - konversi string ke array
        $castData = $film->cast; // default: tetap cast lama
        if ($request->filled('cast')) {
            $castData = array_values(array_filter(
                array_map('trim', explode(',', $request->cast))
            ));
        }

        $film->update([
            'judul'        => $request->judul,
            'sinopsis'     => $request->sinopsis,
            'durasi'       => $request->durasi,
            'genre'        => $request->genre,
            'poster'       => $posterPath,
            'rating'       => $request->rating ?? $film->rating,
            'age_rating'   => $request->age_rating ?? $film->age_rating,
            'trailer'      => $request->trailer ?? $film->trailer,
            'director'     => $request->director ?? $film->director,
            'cast'         => $castData,
            'backdrop'     => $request->backdrop ?? $film->backdrop,
            'release_date' => $request->release_date ?: $film->release_date,
            'status'       => $request->status ?? $film->status,
        ]);

        return redirect()->route('admin.films.index')
            ->with('success', 'Film "' . $film->judul . '" berhasil diupdate!');
    }

    public function destroy(Film $film)
    {
        $film->delete();
        return redirect()->route('admin.films.index')
            ->with('success', 'Film berhasil dihapus!');
    }
}