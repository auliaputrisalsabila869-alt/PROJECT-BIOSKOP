<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanAdminController extends Controller
{
    public function index(Request $request)
    {
        $dari   = $request->get('dari', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $sampai = $request->get('sampai', Carbon::today()->format('Y-m-d'));

        $bookings = Booking::with(['user', 'schedule.film', 'schedule.studio'])
            ->where('status', 'paid')
            ->whereBetween('created_at', [
                Carbon::parse($dari)->startOfDay(),
                Carbon::parse($sampai)->endOfDay(),
            ])
            ->latest()
            ->get();

        $totalPendapatan = $bookings->sum('total_harga');
        $totalTiket      = $bookings->sum('jumlah_tiket');

        return view('admin.laporan.index', compact(
            'bookings', 'totalPendapatan', 'totalTiket', 'dari', 'sampai'
        ));
    }
}