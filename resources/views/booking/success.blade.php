@extends('layouts.app')
@section('title', 'Pemesanan Berhasil - ' . $booking->kode_booking)
@section('content')

<section class="min-h-screen pt-24 pb-12 bg-gradient-to-b from-green-50 to-white">
    <div class="container mx-auto px-4 max-w-2xl">

        {{-- Success Icon --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 rounded-full mb-4">
                <i class="fas fa-check text-4xl text-green-600"></i>
            </div>
            <h1 class="text-3xl font-black text-gray-900 mb-1">Pemesanan Berhasil!</h1>
            <p class="text-gray-500">Tiket Anda siap digunakan</p>
        </div>

        {{-- TIKET (yang bisa di-download) --}}
        <div id="ticketCard"
             class="bg-white rounded-2xl shadow-xl overflow-hidden mb-6 border border-gray-100">

            {{-- Header Tiket --}}
            <div class="bg-gradient-to-r from-red-600 to-red-700 px-6 py-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-film text-white"></i>
                    </div>
                    <div>
                        <h2 class="text-white font-black text-lg leading-none">CTIX.ID</h2>
                        <p class="text-red-200 text-xs">Cinema Ticket</p>
                    </div>
                </div>
                <span class="bg-white/20 text-white text-xs font-bold px-3 py-1 rounded-full">
                    {{ strtoupper($booking->status) }}
                </span>
            </div>

            {{-- Kode Booking --}}
            <div class="text-center py-5 border-b border-dashed border-gray-200 px-6">
                <p class="text-xs text-gray-400 uppercase tracking-widest mb-1">Kode Booking</p>
                <p class="text-4xl font-black font-mono text-red-600 tracking-widest">{{ $booking->kode_booking }}</p>
            </div>

            {{-- Detail Tiket --}}
            <div class="grid grid-cols-2 gap-0 border-b border-dashed border-gray-200">
                <div class="p-5 border-r border-dashed border-gray-200">
                    <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Film</p>
                    <p class="font-bold text-gray-900">{{ $booking->schedule->film->judul }}</p>
                </div>
                <div class="p-5">
                    <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Studio</p>
                    <p class="font-bold text-gray-900">{{ $booking->schedule->studio->nama }}</p>
                </div>
                <div class="p-5 border-r border-t border-dashed border-gray-200">
                    <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Tanggal</p>
                    <p class="font-bold text-gray-900">{{ $booking->schedule->tanggal_formatted }}</p>
                </div>
                <div class="p-5 border-t border-dashed border-gray-200">
                    <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Jam Tayang</p>
                    <p class="font-bold text-gray-900">{{ $booking->schedule->waktu_tayang }}</p>
                </div>
            </div>

            {{-- Kursi & Total --}}
            <div class="px-6 py-4 border-b border-dashed border-gray-200">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wider mb-2">Nomor Kursi</p>
                        <div class="flex flex-wrap gap-1.5">
                            @foreach($booking->bookingSeats as $bs)
                            <span class="bg-red-100 text-red-700 font-bold text-sm px-3 py-1 rounded-lg">
                                {{ $bs->seat->nomor_kursi }}
                            </span>
                            @endforeach
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Total</p>
                        <p class="text-2xl font-black text-red-600">
                            Rp {{ number_format($booking->total_harga, 0, ',', '.') }}
                        </p>
                        <p class="text-xs text-gray-400">{{ $booking->jumlah_tiket }} tiket</p>
                    </div>
                </div>
            </div>

            {{-- QR Code --}}
            <div class="px-6 py-5 flex items-center gap-6">
                <div class="flex-shrink-0">
                    {{-- QR Code menggunakan API --}}
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=120x120&data={{ $booking->kode_booking }}&bgcolor=ffffff&color=000000&margin=10"
                         alt="QR Code {{ $booking->kode_booking }}"
                         class="w-28 h-28 rounded-lg border border-gray-100">
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-800 mb-1">Tunjukkan QR Code ini</p>
                    <p class="text-xs text-gray-500 leading-relaxed">
                        Scan QR code ini saat check-in di loket bioskop. Tiket berlaku untuk
                        <span class="font-semibold">{{ $booking->schedule->film->judul }}</span>
                        pada tanggal {{ $booking->schedule->tanggal_formatted }}.
                    </p>
                    <p class="text-xs text-gray-400 mt-2">
                        <i class="fas fa-envelope mr-1"></i>
                        Konfirmasi dikirim ke {{ Auth::user()->email }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Info Penting --}}
        <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 mb-6">
            <h4 class="font-bold text-blue-900 mb-2 flex items-center gap-2 text-sm">
                <i class="fas fa-info-circle text-blue-500"></i> Informasi Penting
            </h4>
            <ul class="text-xs text-blue-800 space-y-1">
                <li class="flex items-start gap-1.5"><i class="fas fa-check text-blue-400 mt-0.5 flex-shrink-0"></i> Tiba 15 menit sebelum jadwal tayang</li>
                <li class="flex items-start gap-1.5"><i class="fas fa-check text-blue-400 mt-0.5 flex-shrink-0"></i> Tunjukkan kode booking atau QR code saat check-in</li>
                <li class="flex items-start gap-1.5"><i class="fas fa-check text-blue-400 mt-0.5 flex-shrink-0"></i> Tiket tidak dapat ditukar atau dikembalikan setelah jam tayang</li>
            </ul>
        </div>

        {{-- Tombol Aksi --}}
        <div class="grid grid-cols-2 gap-3 mb-4">
            <button onclick="downloadTicket()"
                    class="flex items-center justify-center gap-2 bg-red-600 hover:bg-red-700 text-white font-bold py-3 rounded-xl transition">
                <i class="fas fa-download"></i> Download Tiket
            </button>
            <a href="{{ route('booking.my-tickets') }}"
               class="flex items-center justify-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold py-3 rounded-xl transition">
                <i class="fas fa-ticket-alt"></i> Tiket Saya
            </a>
        </div>
        <a href="{{ route('home') }}"
           class="block text-center text-gray-500 hover:text-gray-700 text-sm transition">
            <i class="fas fa-home mr-1"></i> Kembali ke Beranda
        </a>
    </div>
</section>

{{-- Script Download Tiket --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
function downloadTicket() {
    const ticket = document.getElementById('ticketCard');
    const btn = event.target.closest('button');
    btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Memproses...';
    btn.disabled = true;

    html2canvas(ticket, {
        scale: 2,
        useCORS: true,
        backgroundColor: '#ffffff',
        logging: false,
    }).then(canvas => {
        const link = document.createElement('a');
        link.download = 'tiket-{{ $booking->kode_booking }}.png';
        link.href = canvas.toDataURL('image/png');
        link.click();

        btn.innerHTML = '<i class="fas fa-check mr-2"></i> Berhasil!';
        btn.className = btn.className.replace('bg-red-600 hover:bg-red-700', 'bg-green-600');
        setTimeout(() => {
            btn.innerHTML = '<i class="fas fa-download mr-2"></i> Download Tiket';
            btn.className = btn.className.replace('bg-green-600', 'bg-red-600 hover:bg-red-700');
            btn.disabled = false;
        }, 2000);
    }).catch(() => {
        btn.innerHTML = '<i class="fas fa-download mr-2"></i> Download Tiket';
        btn.disabled = false;
    });
}
</script>
@endsection