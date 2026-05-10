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
}