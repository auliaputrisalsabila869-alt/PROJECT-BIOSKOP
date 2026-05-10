<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Film;
use App\Models\Schedule;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalPendapatan  = Booking::where('status', 'paid')->sum('total_harga');
        $totalTransaksi   = Booking::count();
        $transaksiPaid    = Booking::where('status', 'paid')->count();
        $transaksiPending = Booking::where('status', 'pending')->count();

        $filmTerlaris = Film::withCount(['schedules as total_tiket' => function ($q) {
            $q->join('bookings', 'bookings.schedule_id', '=', 'schedules.id')
              ->where('bookings.status', 'paid')
              ->selectRaw('sum(bookings.jumlah_tiket)');
        }])->orderByDesc('total_tiket')->take(5)->get();

        $transaksiTerbaru = Booking::with(['user', 'schedule.film'])
            ->latest()->take(8)->get();

        $pendapatanHarian = [];
        for ($i = 6; $i >= 0; $i--) {
            $tanggal = Carbon::today()->subDays($i);
            $pendapatanHarian[] = [
                'tanggal' => $tanggal->format('d M'),
                'total'   => Booking::where('status', 'paid')
                    ->whereDate('created_at', $tanggal)
                    ->sum('total_harga'),
            ];
        }

        $totalFilm   = Film::count();
        $totalJadwal = Schedule::where('tanggal', '>=', Carbon::today())->count();

        return view('admin.dashboard', compact(
            'totalPendapatan', 'totalTransaksi', 'transaksiPaid',
            'transaksiPending', 'filmTerlaris', 'transaksiTerbaru',
            'pendapatanHarian', 'totalFilm', 'totalJadwal'
        ));
    }
}