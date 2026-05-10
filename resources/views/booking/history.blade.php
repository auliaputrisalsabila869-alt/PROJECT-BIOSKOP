@extends('layouts.app')

@section('title', 'Riwayat Pemesanan')

@section('content')
<section class="min-h-screen pt-24 pb-12 bg-gradient-to-b from-gray-50 to-white">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Riwayat Pemesanan</h1>
            <p class="text-gray-600">Semua pemesanan tiket Anda</p>
        </div>

        @if($bookings->count() > 0)
        <div class="space-y-4">
            @foreach($bookings as $booking)
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden hover:shadow-xl transition">
                <div class="grid md:grid-cols-5 gap-4 p-6">
                    <!-- Film -->
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-bold mb-1">Film</p>
                        <p class="font-bold text-gray-900">{{ $booking->schedule->film->judul }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $booking->schedule->studio->nama }}</p>
                    </div>

                    <!-- Schedule -->
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-bold mb-1">Jadwal</p>
                        <p class="font-bold text-gray-900">{{ $booking->schedule->tanggal_formatted }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $booking->schedule->waktu_tayang }}</p>
                    </div>

                    <!-- Seats -->
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-bold mb-1">Kursi</p>
                        <div class="flex flex-wrap gap-1">
                            @foreach($booking->bookingSeats as $bs)
                            <span class="text-xs px-2 py-1 bg-gray-100 rounded text-gray-700">
                                {{ $bs->seat->nomor_kursi }}
                            </span>
                            @endforeach
                        </div>
                    </div>

                    <!-- Booking Code -->
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-bold mb-1">Kode Booking</p>
                        <p class="font-mono font-bold text-red-600">{{ $booking->kode_booking }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $booking->jumlah_tiket }} Tiket</p>
                    </div>

                    <!-- Status -->
                    <div class="flex flex-col justify-between">
                        <div>
                            @if($booking->status === 'pending')
                            <span class="inline-block px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-bold">
                                <i class="fas fa-clock mr-1"></i> Menunggu Pembayaran
                            </span>
                            @elseif($booking->status === 'paid')
                            <span class="inline-block px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">
                                <i class="fas fa-check mr-1"></i> Terbayar
                            </span>
                            @elseif($booking->status === 'expired')
                            <span class="inline-block px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-bold">
                                <i class="fas fa-times mr-1"></i> Kadaluarsa
                            </span>
                            @endif
                        </div>
                        <p class="text-right font-bold text-gray-900">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($bookings->hasPages())
        <div class="mt-8">
            {{ $bookings->links() }}
        </div>
        @endif
        @else
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-12 text-center">
            <i class="fas fa-history text-6xl text-gray-300 mb-4"></i>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Pemesanan</h3>
            <p class="text-gray-600 mb-6">Anda belum melakukan pemesanan tiket</p>
            <a href="{{ route('films.index') }}" class="inline-block px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl font-semibold transition">
                <i class="fas fa-film mr-2"></i> Pesan Tiket Sekarang
            </a>
        </div>
        @endif
    </div>
</section>
@endsection
