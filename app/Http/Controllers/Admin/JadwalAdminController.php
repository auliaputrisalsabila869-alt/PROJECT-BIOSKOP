<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Film;
use App\Models\Studio;
use Illuminate\Http\Request;
use Carbon\Carbon;

class JadwalAdminController extends Controller
{
    public function index()
    {
        $jadwals = Schedule::with(['film', 'studio'])
            ->orderBy('tanggal', 'desc')
            ->orderBy('waktu_mulai')
            ->paginate(15);
        return view('admin.jadwal.index', compact('jadwals'));
    }

    public function create()
    {
        $films   = Film::orderBy('judul')->get();
        $studios = Studio::orderBy('nama')->get();
        return view('admin.jadwal.create', compact('films', 'studios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'film_id'     => 'required|exists:films,id',
            'studio_id'   => 'required|exists:studios,id',
            'tanggal'     => 'required|date',
            'waktu_mulai' => 'required',
            'harga'       => 'required|integer|min:1000',
        ]);

        $film         = Film::findOrFail($request->film_id);
        $waktuMulai   = Carbon::parse($request->tanggal . ' ' . $request->waktu_mulai);
        $waktuSelesai = $waktuMulai->copy()->addMinutes($film->durasi + 15);

        Schedule::create([
            'film_id'       => $request->film_id,
            'studio_id'     => $request->studio_id,
            'tanggal'       => $request->tanggal,
            'waktu_mulai'   => $waktuMulai->format('H:i:s'),
            'waktu_selesai' => $waktuSelesai->format('H:i:s'),
            'harga'         => $request->harga,
        ]);

        return redirect()->route('admin.jadwal.index')
            ->with('success', 'Jadwal berhasil ditambahkan!');
    }

    public function edit(Schedule $jadwal)
    {
        $films   = Film::orderBy('judul')->get();
        $studios = Studio::orderBy('nama')->get();
        return view('admin.jadwal.edit', compact('jadwal', 'films', 'studios'));
    }

    public function update(Request $request, Schedule $jadwal)
    {
        $request->validate([
            'film_id'     => 'required|exists:films,id',
            'studio_id'   => 'required|exists:studios,id',
            'tanggal'     => 'required|date',
            'waktu_mulai' => 'required',
            'harga'       => 'required|integer|min:1000',
        ]);

        $film         = Film::findOrFail($request->film_id);
        $waktuMulai   = Carbon::parse($request->tanggal . ' ' . $request->waktu_mulai);
        $waktuSelesai = $waktuMulai->copy()->addMinutes($film->durasi + 15);

        $jadwal->update([
            'film_id'       => $request->film_id,
            'studio_id'     => $request->studio_id,
            'tanggal'       => $request->tanggal,
            'waktu_mulai'   => $waktuMulai->format('H:i:s'),
            'waktu_selesai' => $waktuSelesai->format('H:i:s'),
            'harga'         => $request->harga,
        ]);

        return redirect()->route('admin.jadwal.index')
            ->with('success', 'Jadwal berhasil diupdate!');
    }

    public function destroy(Schedule $jadwal)
    {
        $jadwal->delete();
        return redirect()->route('admin.jadwal.index')
            ->with('success', 'Jadwal berhasil dihapus!');
    }
    // Form generate jadwal otomatis
public function generateForm()
{
    $films   = Film::where('status', 'now_showing')->orderBy('judul')->get();
    $studios = Studio::orderBy('nama')->get();
    return view('admin.jadwal.generate', compact('films', 'studios'));
}

// Proses generate jadwal otomatis
public function generateBulk(Request $request)
{
    $request->validate([
        'film_ids'      => 'required|array|min:1',
        'film_ids.*'    => 'exists:films,id',
        'studio_ids'    => 'required|array|min:1',
        'studio_ids.*'  => 'exists:studios,id',
        'tanggal_mulai' => 'required|date',
        'jumlah_hari'   => 'required|integer|min:1|max:30',
        'jam_tayang'    => 'required|array|min:1',
        'harga_film'    => 'required|array',
    ]);

    $films        = Film::whereIn('id', $request->film_ids)->get();
    $studioIds    = $request->studio_ids;
    $tanggalMulai = \Carbon\Carbon::parse($request->tanggal_mulai);
    $jumlahHari   = (int) $request->jumlah_hari;
    $jamTayang    = $request->jam_tayang;
    $hargaFilm    = $request->harga_film; // ['film_id' => harga]
    $count        = 0;
    $skipped      = 0;

    for ($hari = 0; $hari < $jumlahHari; $hari++) {
        $tanggal = $tanggalMulai->copy()->addDays($hari);

        foreach ($films as $filmIndex => $film) {
            $studioId = $studioIds[$filmIndex % count($studioIds)];

            // Ambil harga per film
            $harga = $hargaFilm[$film->id] ?? 50000;

            foreach ($jamTayang as $jam) {
                $waktuMulai   = \Carbon\Carbon::parse($tanggal->format('Y-m-d') . ' ' . $jam);
                $waktuSelesai = $waktuMulai->copy()->addMinutes($film->durasi + 15);

                // Cek bentrok
                $bentrok = Schedule::where('studio_id', $studioId)
                    ->where('tanggal', $tanggal->format('Y-m-d'))
                    ->where(function($q) use ($waktuMulai, $waktuSelesai) {
                        $q->whereBetween('waktu_mulai', [$waktuMulai, $waktuSelesai])
                          ->orWhereBetween('waktu_selesai', [$waktuMulai, $waktuSelesai])
                          ->orWhere(function($q2) use ($waktuMulai, $waktuSelesai) {
                              $q2->where('waktu_mulai', '<=', $waktuMulai)
                                 ->where('waktu_selesai', '>=', $waktuSelesai);
                          });
                    })->exists();

                // Cek duplikat
                $exists = Schedule::where('film_id', $film->id)
                    ->where('studio_id', $studioId)
                    ->where('tanggal', $tanggal->format('Y-m-d'))
                    ->where('waktu_mulai', $waktuMulai->format('H:i:s'))
                    ->exists();

                if (!$bentrok && !$exists) {
                    Schedule::create([
                        'film_id'       => $film->id,
                        'studio_id'     => $studioId,
                        'tanggal'       => $tanggal->format('Y-m-d'),
                        'waktu_mulai'   => $waktuMulai->format('H:i:s'),
                        'waktu_selesai' => $waktuSelesai->format('H:i:s'),
                        'harga'         => $harga, // ← harga per film
                    ]);
                    $count++;
                } else {
                    $skipped++;
                }
            }
        }
    }

    return redirect()->route('admin.jadwal.index')
        ->with('success', "$count jadwal berhasil dibuat! $skipped jadwal dilewati.");
}
}