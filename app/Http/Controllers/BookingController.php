<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\FilmController;
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
    /**
     * Cari data film: coba dari DB dulu, fallback ke dummy.
     * Mengembalikan object yang sudah dinormalisasi agar view konsisten.
     */
    protected function findFilmData($filmId)
    {
        // Coba dari database dulu
        $film = Film::find($filmId);
        if ($film) {
            return $film;
        }

        // Fallback ke data dummy
        $filmController = new FilmController();
        $films = collect($filmController->getFilms());
        return $films->firstWhere('id', (int) $filmId);
    }

    /**
     * Normalisasi field film agar konsisten antara DB dan dummy.
     * Mengembalikan array/object dengan field standar.
     */
    protected function normalizeFilm($film)
    {
        if ($film instanceof Film) {
            // Dari database - sudah ada accessor slug & duration
            return $film;
        }

        // Dari dummy - pastikan field ada
        if (!isset($film->slug)) {
            $film->slug = Str::slug($film->judul);
        }
        if (!isset($film->duration)) {
            $film->duration = ($film->durasi ?? 0) . ' menit';
        }
        if (!isset($film->sinopsis) && isset($film->synopsis)) {
            $film->sinopsis = $film->synopsis;
        }
        if (!isset($film->durasi) && isset($film->duration)) {
            // parse angka dari "120 menit"
            $film->durasi = (int) filter_var($film->duration, FILTER_SANITIZE_NUMBER_INT);
        }

        return $film;
    }

    // Halaman pilih studio
    public function selectStudio($filmId)
    {
        $film = $this->findFilmData($filmId);
        if (!$film) {
            abort(404);
        }
        $film = $this->normalizeFilm($film);

        $studios = Schedule::where('film_id', $filmId)
            ->where('tanggal', '>=', Carbon::today())
            ->with('studio')
            ->get()
            ->pluck('studio')
            ->unique('id')
            ->values();

        return view('booking.select-studio', compact('film', 'studios'));
    }

    // Halaman pilih jadwal dengan tampilan 1 minggu
    public function selectSchedule($filmId)
    {
        $film = $this->findFilmData($filmId);
        if (!$film) {
            abort(404);
        }
        $film = $this->normalizeFilm($film);

        $studioId = request('studio_id');

        // Get date range: today to next 6 days (1 week)
        $startDate = Carbon::today();
        $endDate   = Carbon::today()->addDays(6);

        // Buat array semua tanggal dalam minggu ini
        $dates = [];
        for ($date = $startDate->copy(); $date <= $endDate; $date->addDay()) {
            $dates[] = $date->copy();
        }

        // Query jadwal film dalam rentang 1 minggu
        $query = Schedule::where('film_id', $filmId)
            ->whereBetween('tanggal', [$startDate, $endDate]);

        if ($studioId) {
            $query->where('studio_id', $studioId);
            $selectedStudio = Studio::find($studioId);
        } else {
            $selectedStudio = null;
        }

        $schedules = $query->with('studio')
            ->orderBy('tanggal')
            ->orderBy('waktu_mulai')
            ->get();

        // Group jadwal berdasarkan tanggal
        $schedulesByDate = [];
        foreach ($schedules as $schedule) {
            $dateKey = $schedule->tanggal->format('Y-m-d');
            if (!isset($schedulesByDate[$dateKey])) {
                $schedulesByDate[$dateKey] = [];
            }
            $schedulesByDate[$dateKey][] = $schedule;
        }

        return view('booking.select-schedule', compact(
            'film', 'dates', 'schedulesByDate', 'selectedStudio'
        ));
    }

    // Halaman pilih kursi
    // Halaman pilih kursi
    public function selectSeats($scheduleId){
    $schedule = Schedule::with(['film', 'studio'])->findOrFail($scheduleId);

    $allSeats = Seat::where('studio_id', $schedule->studio_id)
        ->orderBy('baris')
        ->orderBy('nomor')
        ->get();

    $bookedSeatIds = $schedule->booked_seats;

    $seatsByRow = [];
    foreach ($allSeats as $seat) {
        if (!isset($seatsByRow[$seat->baris])) {
            $seatsByRow[$seat->baris] = [];
        }
        $seatsByRow[$seat->baris][] = [
            'id'          => $seat->id,
            'nomor'       => $seat->nomor,
            'nomor_kursi' => $seat->nomor_kursi,
            'is_booked'   => in_array($seat->id, $bookedSeatIds),
        ];
    }

    // Ambil jumlah tiket dari modal sebelumnya
    $qty = (int) request('qty', 1);
    $qty = max(1, min(8, $qty)); // Batasi 1-8

    return view('booking.select-seats', compact('schedule', 'seatsByRow', 'qty'));
}

    // Proses pemesanan
    public function processBooking(Request $request, $scheduleId)
    {
        $request->validate([
            'selected_seats'   => 'required|string',
        ]);

        // Parse JSON dari hidden input
        $selectedSeats = json_decode($request->selected_seats, true);

        if (empty($selectedSeats) || !is_array($selectedSeats)) {
            return back()->with('error', 'Pilih minimal 1 kursi.');
        }

        // Validasi seat IDs ada di DB
        $validIds = Seat::whereIn('id', $selectedSeats)->pluck('id')->toArray();
        if (count($validIds) !== count($selectedSeats)) {
            return back()->with('error', 'Kursi tidak valid.');
        }

        $schedule = Schedule::findOrFail($scheduleId);

        // Cek kursi sudah dipesan
        $bookedSeatIds    = $schedule->booked_seats;
        $conflictingSeats = array_intersect($selectedSeats, $bookedSeatIds);

        if (count($conflictingSeats) > 0) {
            $conflictingSeatNumbers = Seat::whereIn('id', $conflictingSeats)
                ->pluck('nomor_kursi')
                ->toArray();
            return back()->with('error', 'Kursi ' . implode(', ', $conflictingSeatNumbers) . ' sudah dipesan!');
        }

        $jumlahTiket = count($selectedSeats);
        $totalHarga  = $jumlahTiket * $schedule->harga;
        $kodeBooking = 'TIX' . strtoupper(Str::random(8));

        $booking = Booking::create([
            'user_id'      => Auth::id(),
            'schedule_id'  => $scheduleId,
            'kode_booking' => $kodeBooking,
            'jumlah_tiket' => $jumlahTiket,
            'total_harga'  => $totalHarga,
            'status'       => 'pending',
        ]);

        foreach ($selectedSeats as $seatId) {
            BookingSeat::create([
                'booking_id' => $booking->id,
                'seat_id'    => $seatId,
            ]);
        }

        return redirect()->route('booking.payment', $booking->id);
    }

    // Halaman pembayaran
    public function payment($bookingId)
    {
        $booking = Booking::with([
            'schedule.film',
            'schedule.studio',
            'bookingSeats.seat',
        ])->findOrFail($bookingId);

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

        $request->validate([
            'payment_method' => 'required|in:transfer,qris,credit_card',
        ]);

        $booking->update(['status' => 'paid']);

        return redirect()->route('booking.success', $bookingId);
    }

    // Halaman sukses / tiket
    public function success($bookingId)
    {
        $booking = Booking::with([
            'schedule.film',
            'schedule.studio',
            'bookingSeats.seat',
        ])->findOrFail($bookingId);

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

    // Tiket aktif user
    public function myTickets()
    {
        $bookings = Booking::with([
            'schedule.film',
            'schedule.studio',
            'bookingSeats.seat',
        ])
            ->where('user_id', Auth::id())
            ->where('status', 'paid')
            ->whereHas('schedule', function ($query) {
                $query->where('tanggal', '>=', Carbon::today());
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('booking.my-tickets', compact('bookings'));
    }
}