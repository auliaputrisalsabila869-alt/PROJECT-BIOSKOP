<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\Studio;
use App\Models\Schedule;
use Illuminate\Http\Request;
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
    
    public function bioskopSelectSeats($scheduleId)
{
    $schedule = Schedule::with(['film', 'studio'])->findOrFail($scheduleId);

    $qty = (int) request('seat_count', 1);
    $qty = max(1, min(8, $qty));

    return view('bioskop.select-seats', compact('schedule', 'qty'));
}

    public function searchSuggestions(Request $request)
{
    $keyword = trim($request->get('q', ''));
    $city = strtoupper(trim($request->get('city', 'LAMPUNG')));

    if (strlen($keyword) < 2) {
        return response()->json([
            'films' => [],
            'bioskop' => [],
        ]);
    }

    $films = Film::query()
        ->where(function ($query) use ($keyword) {
            $query->where('judul', 'like', "%{$keyword}%")
                ->orWhere('genre', 'like', "%{$keyword}%")
                ->orWhere('director', 'like', "%{$keyword}%");
        })
        ->limit(6)
        ->get()
        ->map(function ($film) {
            return [
                'title' => $film->judul,
                'poster' => $film->poster,
                'genre' => $film->genre,
                'age_rating' => $film->age_rating ?? 'R13+',
                'format' => '2D',
                'rating' => $film->rating ?? 0,
                'url' => route('films.show', Str::slug($film->judul)),
            ];
        });

        $bioskop = Studio::query()
            ->where('city', $city)
            ->whereIn('nama', [
                'CENTRAL LAMPUNG XXI',
                'MALL BOEMI KEDATON XXI',
                'CIPLAZ LAMPUNG XXI',
            ])
            ->where(function ($query) use ($keyword) {
                $query->where('nama', 'like', "%{$keyword}%")
                    ->orWhere('address', 'like', "%{$keyword}%")
                    ->orWhere('city', 'like', "%{$keyword}%");
            })
            ->orderByRaw("
                CASE
                    WHEN nama = 'CENTRAL LAMPUNG XXI' THEN 1
                    WHEN nama = 'MALL BOEMI KEDATON XXI' THEN 2
                    WHEN nama = 'CIPLAZ LAMPUNG XXI' THEN 3
                    ELSE 4
                END
            ")
            ->get()
            ->map(function ($studio) {
                return [
                    'name' => $studio->nama,
                    'city' => $studio->city,
                    'address' => $studio->address,
                    'distance' => '0 km',
                    'brand' => 'Cinema XXI',
                    'capacity' => $studio->kapasitas,
                    'url' => route('bioskop.detail', Str::slug($studio->nama)),
                ];
            });

    return response()->json([
        'films' => $films,
        'bioskop' => $bioskop,
    ]);
}

    public function show($slug)
    {
        $film = Film::all()->first(function ($film) use ($slug) {
            return Str::slug($film->judul) === $slug;
        });

        if (!$film) {
            abort(404);
        }

        $recommendations = Film::where('id', '!=', $film->id)
            ->where('status', $film->status)
            ->limit(4)
            ->get();

        return view('films.show', compact('film', 'recommendations'));
    }

    public function bioskopDetail($slug)
    {
        $allowedCinemaNames = [
            'CENTRAL LAMPUNG XXI',
            'MALL BOEMI KEDATON XXI',
            'CIPLAZ LAMPUNG XXI',
        ];

        $studio = Studio::where('city', 'LAMPUNG')
            ->whereIn('nama', $allowedCinemaNames)
            ->get()
            ->first(function ($studio) use ($slug) {
                return Str::slug($studio->nama) === $slug;
            });

        if (!$studio) {
            abort(404);
        }

        $tanggal = request('tanggal', now()->toDateString());

            $schedules = Schedule::where('studio_id', $studio->id)
                ->whereDate('tanggal', $tanggal)
                ->with('film')
                ->orderBy('waktu_mulai')
                ->get();

            $films = $schedules
                ->groupBy('film_id')
                ->map(function ($group) {
                    return [
                        'film' => $group->first()->film,
                        'schedules' => $group,
                    ];
                })
                ->values();

        return view('bioskop.detail', compact('studio', 'films', 'tanggal'));
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
    public function bioskopPayment($scheduleId)
{
    $schedule = Schedule::with(['film', 'studio'])->findOrFail($scheduleId);

    $seats = request('seats', '');
    $seatList = collect(explode(',', $seats))
        ->map(fn ($seat) => trim($seat))
        ->filter()
        ->values();

    if ($seatList->isEmpty()) {
        return redirect()
            ->route('bioskop.select-seats', $scheduleId)
            ->with('error', 'Silakan pilih kursi terlebih dahulu.');
    }

    $ticketPrice = $schedule->harga ?? 40000;
    $totalPrice = $ticketPrice * $seatList->count();

    return view('bioskop.payment', compact(
        'schedule',
        'seatList',
        'ticketPrice',
        'totalPrice'
    ));
}
}