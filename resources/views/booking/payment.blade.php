@extends('layouts.app')

@section('title', 'Pembayaran - ' . $booking->kode_booking)

@section('content')
<section class="min-h-screen pt-24 pb-12 bg-gradient-to-b from-gray-50 to-white">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('booking.my-tickets') }}" class="text-red-600 hover:text-red-700 mb-4 inline-flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <h1 class="text-3xl font-bold text-gray-900 mt-2">Pembayaran</h1>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            <!-- Left: Payment Form -->
            <div class="md:col-span-2 bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Pilih Metode Pembayaran</h2>

                <form action="{{ route('booking.process-payment', $booking->id) }}" method="POST">
                    @csrf

                    <div class="space-y-4">
                        <!-- Transfer Bank -->
                        <label class="flex items-center p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-red-500 hover:bg-red-50 transition payment-option" data-method="transfer">
                            <input type="radio" name="payment_method" value="transfer" class="w-5 h-5 text-red-600 cursor-pointer" required>
                            <div class="ml-4 flex-1">
                                <p class="font-semibold text-gray-900">Transfer Bank</p>
                                <p class="text-sm text-gray-500">Transfer manual ke rekening BioskopApp</p>
                                <p class="text-xs text-gray-400 mt-1">BCA: 1234567890 atas nama PT. BioskopApp</p>
                            </div>
                            <div class="text-3xl text-gray-300">
                                <i class="fas fa-university"></i>
                            </div>
                        </label>

                        <!-- QRIS -->
                        <label class="flex items-center p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-red-500 hover:bg-red-50 transition payment-option" data-method="qris">
                            <input type="radio" name="payment_method" value="qris" class="w-5 h-5 text-red-600 cursor-pointer">
                            <div class="ml-4 flex-1">
                                <p class="font-semibold text-gray-900">QRIS</p>
                                <p class="text-sm text-gray-500">Scan QR Code dengan aplikasi banking Anda</p>
                            </div>
                            <div class="text-3xl text-gray-300">
                                <i class="fas fa-qrcode"></i>
                            </div>
                        </label>

                        <!-- Credit Card -->
                        <label class="flex items-center p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-red-500 hover:bg-red-50 transition payment-option" data-method="credit_card">
                            <input type="radio" name="payment_method" value="credit_card" class="w-5 h-5 text-red-600 cursor-pointer">
                            <div class="ml-4 flex-1">
                                <p class="font-semibold text-gray-900">Kartu Kredit</p>
                                <p class="text-sm text-gray-500">Visa, Mastercard, atau Amex</p>
                            </div>
                            <div class="text-3xl text-gray-300">
                                <i class="fas fa-credit-card"></i>
                            </div>
                        </label>
                    </div>

                    <!-- Additional Info Display -->
                    <div id="paymentInfo" class="mt-6 p-4 bg-blue-50 rounded-xl border border-blue-200 hidden">
                        <div id="transferInfo" class="hidden">
                            <h3 class="font-bold text-blue-900 mb-2">Instruksi Transfer</h3>
                            <ol class="list-decimal list-inside text-sm text-blue-800 space-y-1">
                                <li>Buka aplikasi banking Anda</li>
                                <li>Pilih Transfer Bank</li>
                                <li>Input nomor rekening: 1234567890</li>
                                <li>Nominal: Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</li>
                                <li>Catatan: {{ $booking->kode_booking }}</li>
                                <li>Kirim transfer</li>
                            </ol>
                        </div>
                        <div id="qrisInfo" class="hidden text-center">
                            <p class="text-sm text-blue-800 mb-3">Scan QR Code berikut:</p>
                            <div class="w-40 h-40 bg-white rounded-lg mx-auto flex items-center justify-center border-2 border-blue-200">
                                <i class="fas fa-qrcode text-6xl text-gray-300"></i>
                            </div>
                            <p class="text-xs text-blue-700 mt-3">Nominal akan otomatis terisi</p>
                        </div>
                        <div id="cardInfo" class="hidden">
                            <h3 class="font-bold text-blue-900 mb-3">Input Data Kartu</h3>
                            <div class="space-y-3">
                                <input type="text" placeholder="Nama Pemilik Kartu" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                <input type="text" placeholder="1234 5678 9012 3456" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                <div class="grid grid-cols-2 gap-2">
                                    <input type="text" placeholder="MM/YY" class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                    <input type="text" placeholder="CVV" class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full mt-6 bg-red-600 hover:bg-red-700 text-white py-3 rounded-xl font-semibold transition">
                        <i class="fas fa-lock mr-2"></i> Lanjutkan ke Pembayaran
                    </button>
                </form>
            </div>

            <!-- Right: Order Summary -->
            <div>
                <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 sticky top-24">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Ringkasan Pesanan</h3>

                    <!-- Film Info -->
                    <div class="mb-6 pb-6 border-b border-gray-200">
                        <p class="text-sm text-gray-500">Film</p>
                        <p class="font-semibold text-gray-900">{{ $booking->schedule->film->judul }}</p>
                    </div>

                    <!-- Schedule Info -->
                    <div class="mb-6 pb-6 border-b border-gray-200">
                        <p class="text-sm text-gray-500 mb-2">Detail Jadwal</p>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Studio</span>
                                <span class="font-semibold text-gray-900">{{ $booking->schedule->studio->nama }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tanggal</span>
                                <span class="font-semibold text-gray-900">{{ $booking->schedule->tanggal_formatted }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Jam</span>
                                <span class="font-semibold text-gray-900">{{ $booking->schedule->waktu_tayang }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Seats Info -->
                    <div class="mb-6 pb-6 border-b border-gray-200">
                        <p class="text-sm text-gray-500 mb-2">Kursi Pilihan</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach($booking->bookingSeats as $bs)
                            <span class="inline-block px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm font-semibold">
                                {{ $bs->seat->nomor_kursi }}
                            </span>
                            @endforeach
                        </div>
                    </div>

                    <!-- Price Summary -->
                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">{{ $booking->jumlah_tiket }} Tiket × Rp {{ number_format($booking->schedule->harga, 0, ',', '.') }}</span>
                            <span class="font-semibold text-gray-900">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Biaya Admin</span>
                            <span class="font-semibold text-gray-900">Gratis</span>
                        </div>
                    </div>

                    <!-- Total -->
                    <div class="pt-6 border-t border-gray-200">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-bold text-gray-900">Total</span>
                            <span class="text-2xl font-bold text-red-600">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <!-- Booking Code -->
                    <div class="mt-6 p-4 bg-gray-100 rounded-lg text-center">
                        <p class="text-xs text-gray-500 uppercase tracking-widest">Kode Booking</p>
                        <p class="text-lg font-bold text-gray-900 font-mono">{{ $booking->kode_booking }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.querySelectorAll('.payment-option').forEach(option => {
    option.addEventListener('click', function() {
        const method = this.dataset.method;
        const infoDiv = document.getElementById('paymentInfo');
        
        // Hide all info sections
        document.getElementById('transferInfo').classList.add('hidden');
        document.getElementById('qrisInfo').classList.add('hidden');
        document.getElementById('cardInfo').classList.add('hidden');
        
        // Show relevant section
        if (method === 'transfer') {
            document.getElementById('transferInfo').classList.remove('hidden');
            infoDiv.classList.remove('hidden');
        } else if (method === 'qris') {
            document.getElementById('qrisInfo').classList.remove('hidden');
            infoDiv.classList.remove('hidden');
        } else if (method === 'credit_card') {
            document.getElementById('cardInfo').classList.remove('hidden');
            infoDiv.classList.remove('hidden');
        }
    });
});
</script>
@endsection
