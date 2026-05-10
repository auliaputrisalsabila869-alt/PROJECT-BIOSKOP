@extends('layouts.app')

@section('title', 'Tiket Saya')

@section('content')
<section class="min-h-screen pt-24 pb-12 bg-gradient-to-b from-gray-50 to-white">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Tiket Saya</h1>
            <p class="text-gray-600">Tiket untuk film yang akan datang</p>
        </div>

        @if($bookings->count() > 0)
        <div class="space-y-6">
            @foreach($bookings as $booking)
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden hover:shadow-xl transition">
                <div class="grid md:grid-cols-4 gap-6 p-6">
                    <!-- Left: Film Info -->
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $booking->schedule->film->judul }}</h3>
                        <div class="space-y-2 text-sm text-gray-600">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-building text-red-600"></i>
                                {{ $booking->schedule->studio->nama }}
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="fas fa-calendar text-red-600"></i>
                                {{ $booking->schedule->tanggal_formatted }}
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="fas fa-clock text-red-600"></i>
                                {{ $booking->schedule->waktu_tayang }}
                            </div>
                        </div>
                    </div>

                    <!-- Middle: Seats -->
                    <div>
                        <p class="text-sm font-bold text-gray-500 uppercase mb-2">Kursi</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach($booking->bookingSeats as $bs)
                            <span class="inline-block px-3 py-1 bg-red-100 text-red-700 rounded-lg font-semibold text-sm">
                                {{ $bs->seat->nomor_kursi }}
                            </span>
                            @endforeach
                        </div>
                    </div>

                    <!-- Right: Booking Code -->
                    <div class="flex flex-col justify-center">
                        <p class="text-xs text-gray-500 uppercase mb-1">Kode Booking</p>
                        <p class="text-xl font-bold font-mono text-red-600">{{ $booking->kode_booking }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $booking->jumlah_tiket }} Tiket</p>
                    </div>

                    <!-- Actions -->
                    <div class="flex flex-col justify-center gap-2">
                        <button class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-semibold transition text-sm">
                            <i class="fas fa-download mr-1"></i> Download
                        </button>
                        <button class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-900 rounded-lg font-semibold transition text-sm">
                            <i class="fas fa-share mr-1"></i> Bagikan
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-12 text-center">
            <i class="fas fa-ticket-alt text-6xl text-gray-300 mb-4"></i>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Tiket</h3>
            <p class="text-gray-600 mb-6">Anda belum memiliki tiket untuk film yang akan datang</p>
            <a href="{{ route('films.index') }}" class="inline-block px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl font-semibold transition">
                <i class="fas fa-film mr-2"></i> Pesan Tiket Sekarang
            </a>
        </div>
        @endif
    </div>
</section>
@endsection
