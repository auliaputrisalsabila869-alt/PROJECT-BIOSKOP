<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Film;
use App\Models\Schedule;
use App\Models\Studio;
use App\Models\Seat;
use App\Models\Booking;
use App\Models\BookingSeat;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    // Halaman pilih jadwal dengan tampilan 1 minggu
    public function selectSchedule($filmId)
    {
        $film = Film::findOrFail($filmId);
        
        // Get date range: today to next 6 days (1 week)
        $startDate = Carbon::today();
        $endDate = Carbon::today()->addDays(6);
        
        // Get all dates in the week
        $dates = [];
        for ($date = $startDate->copy(); $date <= $endDate; $date->addDay()) {
            $dates[] = $date->copy();
        }
        
        // Get schedules for this film within the week
        $schedules = Schedule::where('film_id', $filmId)
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->with('studio')
            ->orderBy('tanggal')
            ->orderBy('waktu_mulai')
            ->get();
        
        // Group schedules by date
        $schedulesByDate = [];
        foreach ($schedules as $schedule) {
            $dateKey = $schedule->tanggal->format('Y-m-d');
            if (!isset($schedulesByDate[$dateKey])) {
                $schedulesByDate[$dateKey] = [];
            }
            $schedulesByDate[$dateKey][] = $schedule;
        }
        
        return view('booking.select-schedule', compact('film', 'dates', 'schedulesByDate'));
    }
    
    // Halaman pilih kursi
    public function selectSeats($scheduleId)
    {
        $schedule = Schedule::with(['film', 'studio'])->findOrFail($scheduleId);
        
        // Get all seats in this studio
        $allSeats = Seat::where('studio_id', $schedule->studio_id)->orderBy('baris')->orderBy('nomor')->get();
        
        // Get booked seat IDs for this schedule
        $bookedSeatIds = $schedule->booked_seats;
        
        // Group seats by row for display
        $seatsByRow = [];
        foreach ($allSeats as $seat) {
            if (!isset($seatsByRow[$seat->baris])) {
                $seatsByRow[$seat->baris] = [];
            }
            $seatsByRow[$seat->baris][] = [
                'id' => $seat->id,
                'nomor' => $seat->nomor,
                'nomor_kursi' => $seat->nomor_kursi,
                'is_booked' => in_array($seat->id, $bookedSeatIds)
            ];
        }
        
        return view('booking.select-seats', compact('schedule', 'seatsByRow'));
    }
    
    // Proses pemesanan
    public function processBooking(Request $request, $scheduleId)
    {
        $request->validate([
            'selected_seats' => 'required|array|min:1',
            'selected_seats.*' => 'exists:seats,id'
        ]);
        
        $schedule = Schedule::findOrFail($scheduleId);
        $selectedSeats = $request->selected_seats;
        
        // Check if selected seats are still available
        $bookedSeatIds = $schedule->booked_seats;
        $conflictingSeats = array_intersect($selectedSeats, $bookedSeatIds);
        
        if (count($conflictingSeats) > 0) {
            $conflictingSeatNumbers = Seat::whereIn('id', $conflictingSeats)->pluck('nomor_kursi')->toArray();
            return back()->with('error', 'Kursi ' . implode(', ', $conflictingSeatNumbers) . ' sudah dipesan!');
        }
        
        // Create booking
        $jumlahTiket = count($selectedSeats);
        $totalHarga = $jumlahTiket * $schedule->harga;
        $kodeBooking = 'TIX' . strtoupper(Str::random(8));
        
        $booking = Booking::create([
            'user_id' => Auth::id(),
            'schedule_id' => $scheduleId,
            'kode_booking' => $kodeBooking,
            'jumlah_tiket' => $jumlahTiket,
            'total_harga' => $totalHarga,
            'status' => 'pending'
        ]);
        
        // Create booking seats
        foreach ($selectedSeats as $seatId) {
            BookingSeat::create([
                'booking_id' => $booking->id,
                'seat_id' => $seatId
            ]);
        }
        
        // Redirect to payment page
        return redirect()->route('booking.payment', $booking->id);
    }
    
    // Halaman pembayaran
    public function payment($bookingId)
    {
        $booking = Booking::with(['schedule.film', 'schedule.studio', 'bookingSeats.seat'])->findOrFail($bookingId);
        
        // Ensure booking belongs to current user
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }
        
        return view('booking.payment', compact('booking'));
    }
    
    // Proses pembayaran
    public function processPayment(Request $request, $bookingId)
    {
        $booking = Booking::findOrFail($bookingId);
        
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }
        
        // Simulate payment processing
        $request->validate([
            'payment_method' => 'required|in:transfer,qris,credit_card'
        ]);
        
        // Update booking status to paid
        $booking->update(['status' => 'paid']);
        
        return redirect()->route('booking.success', $bookingId);
    }
    
    // Halaman sukses / tiket
    public function success($bookingId)
    {
        $booking = Booking::with(['schedule.film', 'schedule.studio', 'bookingSeats.seat'])->findOrFail($bookingId);
        
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }
        
        return view('booking.success', compact('booking'));
    }
    
    // Riwayat pemesanan user
    public function history()
    {
        $bookings = Booking::with(['schedule.film', 'schedule.studio'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('booking.history', compact('bookings'));
    }
    
    // Detail tiket yang dipesan
    public function myTickets()
    {
        $bookings = Booking::with(['schedule.film', 'schedule.studio', 'bookingSeats.seat'])
            ->where('user_id', Auth::id())
            ->where('status', 'paid')
            ->whereHas('schedule', function($query) {
                $query->where('tanggal', '>=', Carbon::today());
            })
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('booking.my-tickets', compact('bookings'));
    }
}