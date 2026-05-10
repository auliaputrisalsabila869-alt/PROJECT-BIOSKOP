<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Seat;
use App\Models\Studio;
use Illuminate\Http\Request;

class KursiAdminController extends Controller
{
    public function index()
    {
        $studios = Studio::with('seats')->get();
        return view('admin.kursi.index', compact('studios'));
    }

    public function generate(Request $request)
    {
        $request->validate([
            'studio_id' => 'required|exists:studios,id',
            'baris'     => 'required|string',
            'per_baris' => 'required|integer|min:1|max:30',
        ]);

        $studio   = Studio::findOrFail($request->studio_id);
        $barisArr = array_map('trim', explode(',', strtoupper($request->baris)));
        $perBaris = (int) $request->per_baris;
        $count    = 0;

        foreach ($barisArr as $b) {
            for ($n = 1; $n <= $perBaris; $n++) {
                $exists = Seat::where('studio_id', $studio->id)
                    ->where('nomor_kursi', $b . $n)->exists();
                if (!$exists) {
                    Seat::create([
                        'studio_id'   => $studio->id,
                        'nomor_kursi' => $b . $n,
                        'baris'       => $b,
                        'nomor'       => $n,
                    ]);
                    $count++;
                }
            }
        }

        return redirect()->route('admin.kursi.index')
            ->with('success', $count . ' kursi berhasil digenerate untuk ' . $studio->nama . '!');
    }

    public function destroy(Seat $seat)
    {
        $seat->delete();
        return redirect()->route('admin.kursi.index')
            ->with('success', 'Kursi berhasil dihapus!');
    }
}