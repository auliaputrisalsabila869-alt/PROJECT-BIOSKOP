@extends('layouts.app')

@section('title', 'Pemesanan Berhasil - ' . $booking->kode_booking)

@section('content')
<section class="min-h-screen pt-24 pb-12 bg-gradient-to-b from-green-50 to-white flex items-center justify-center">
    <div class="container mx-auto px-4">
        <!-- Success Card -->
        <div class="max-w-2xl mx-auto">
            <!-- Success Icon -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-green-100 rounded-full mb-6">
                    <i class="fas fa-check text-5xl text-green-600"></i>
                </div>
                <h1 class="text-4xl font-bold text-gray-900 mb-2">Pemesanan Berhasil!</h1>
                <p class="text-lg text-gray-600">Tiket Anda siap digunakan</p>
            </div>

            <!-- Booking Info Card -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-8 mb-8">
                <!-- Booking Code -->
                <div class="text-center mb-8 pb-8 border-b border-gray-200">
                    <p class="text-sm text-gray-500 uppercase tracking-widest mb-2">Kode Booking</p>
                    <p class="text-4xl font-bold font-mono text-red-600">{{ $booking->kode_booking }}</p>
                    <p class="text-xs text-gray-500 mt-2">Simpan kode ini untuk check-in</p>
                </div>

                <!-- Ticket Details -->
                <div class="grid md:grid-cols-2 gap-8 mb-8">
                    <!-- Left: Film & Schedule -->
                    <div>
                        <h3 class="text-sm font-bold text-gray-500 uppercase mb-4">Detail Tiket</h3>
                        <div class="space-y-4">
                            <div>
                                <p class="text-xs text-gray-500">Judul Film</p>
                                <p class="text-lg font-bold text-gray-900">{{ $booking->schedule->film->judul }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Studio</p>
                                <p class="text-lg font-bold text-gray-900">{{ $booking->schedule->studio->nama }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Tanggal Tayang</p>
                                <p class="text-lg font-bold text-gray-900">{{ $booking->schedule->tanggal_formatted }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Jam Tayang</p>
                                <p class="text-lg font-bold text-gray-900">{{ $booking->schedule->waktu_tayang }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Seats & Summary -->
                    <div>
                        <h3 class="text-sm font-bold text-gray-500 uppercase mb-4">Kursi Anda</h3>
                        <div class="space-y-4">
                            <div>
                                <p class="text-xs text-gray-500 mb-2">Nomor Kursi</p>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($booking->bookingSeats as $bs)
                                    <span class="inline-block px-4 py-2 bg-red-100 text-red-700 rounded-lg font-bold text-lg">
                                        {{ $bs->seat->nomor_kursi }}
                                    </span>
                                    @endforeach
                                </div>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Jumlah Tiket</p>
                                <p class="text-lg font-bold text-gray-900">{{ $booking->jumlah_tiket }} Tiket</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Total Harga</p>
                                <p class="text-2xl font-bold text-red-600">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Status -->
                <div class="p-4 bg-green-50 border border-green-200 rounded-xl text-center mb-8">
                    <p class="text-sm text-green-700 font-semibold">
                        <i class="fas fa-check-circle mr-2"></i> Pembayaran Berhasil
                    </p>
                    <p class="text-xs text-green-600 mt-1">Status: {{ ucfirst($booking->status) }}</p>
                </div>

                <!-- Important Info -->
                <div class="p-4 bg-blue-50 border border-blue-200 rounded-xl mb-8">
                    <h4 class="font-bold text-blue-900 mb-2 flex items-center gap-2">
                        <i class="fas fa-info-circle"></i> Informasi Penting
                    </h4>
                    <ul class="text-sm text-blue-800 space-y-1">
                        <li>✓ Tiba 15 menit sebelum jadwal tayang</li>
                        <li>✓ Tunjukkan kode booking atau email konfirmasi saat check-in</li>
                        <li>✓ Tiket berlaku untuk {{ $booking->schedule->film->judul }} pada tanggal {{ $booking->schedule->tanggal_formatted }}</li>
                        <li>✓ Tidak dapat ditukar atau dikembalikan setelah jam tayang</li>
                    </ul>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="grid md:grid-cols-2 gap-4 mb-8">
                <a href="{{ route('booking.my-tickets') }}" class="block text-center px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl font-semibold transition">
                    <i class="fas fa-ticket-alt mr-2"></i> Lihat Tiket Saya
                </a>
                <a href="{{ route('home') }}" class="block text-center px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-900 rounded-xl font-semibold transition">
                    <i class="fas fa-home mr-2"></i> Kembali ke Beranda
                </a>
            </div>

            <!-- QR Code Section (untuk check-in) -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-8">
                <h3 class="text-lg font-bold text-gray-900 mb-4 text-center">QR Code Tiket</h3>
                <div class="flex justify-center mb-4">
                    <div class="w-48 h-48 bg-gray-100 rounded-lg flex items-center justify-center border-2 border-dashed border-gray-300">
                        <div class="text-center">
                            <i class="fas fa-qrcode text-6xl text-gray-400 mb-2"></i>
                            <p class="text-xs text-gray-500">{{ $booking->kode_booking }}</p>
                        </div>
                    </div>
                </div>
                <p class="text-center text-sm text-gray-600">
                    Tunjukkan QR code ini saat check-in di loket bioskop
                </p>
            </div>

            <!-- Confirmation Email -->
            <div class="mt-8 p-4 text-center">
                <p class="text-sm text-gray-600">
                    <i class="fas fa-envelope text-gray-400 mr-2"></i>
                    Email konfirmasi telah dikirim ke {{ Auth::user()->email }}
                </p>
            </div>
        </div>
    </div>
</section>
@endsection
