<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with([
            'user',
            'schedule.film',
            'schedule.studio',
            'bookingSeats.seat'
        ])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where('kode_booking', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', fn($q) =>
                      $q->where('name', 'like', '%' . $request->search . '%')
                  );
        }

        $bookings = $query->paginate(15);
        return view('admin.bookings.index', compact('bookings'));
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,cancelled',
        ]);

        $booking->update(['status' => $request->status]);

        return redirect()->back()
            ->with('success', 'Status booking ' . $booking->kode_booking . ' berhasil diupdate!');
    }
}