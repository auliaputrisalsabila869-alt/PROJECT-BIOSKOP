@extends('layouts.app')

@section('title', 'Pilih Kursi')

@section('content')
<section class="min-h-screen pt-24 pb-12 bg-gradient-to-b from-gray-50 to-white">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('booking.select-schedule', $schedule->film_id) }}" class="text-red-600 hover:text-red-700 mb-4 inline-flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> Kembali Pilih Jadwal
            </a>
            <h1 class="text-3xl font-bold text-gray-900 mt-2">Pilih Kursi</h1>
        </div>
        
        <!-- Info Film & Jadwal -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 mb-8">
            <div class="flex flex-col md:flex-row justify-between gap-4">
                <div>
                    <h2 class="text-xl font-bold text-gray-900">{{ $schedule->film->judul }}</h2>
                    <div class="flex flex-wrap gap-4 mt-2 text-sm text-gray-600">
                        <span><i class="fas fa-calendar mr-1"></i> {{ $schedule->tanggal_formatted }}</span>
                        <span><i class="fas fa-clock mr-1"></i> {{ $schedule->waktu_tayang }}</span>
                        <span><i class="fas fa-building mr-1"></i> {{ $schedule->studio->nama }}</span>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">Harga Tiket</p>
                    <p class="text-2xl font-bold text-red-600">Rp {{ number_format($schedule->harga, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
        
        <!-- Studio Layout & Seats -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 mb-8">
            <!-- Screen -->
            <div class="mb-8">
                <div class="w-full h-3 bg-gradient-to-r from-gray-300 via-gray-400 to-gray-300 rounded-full"></div>
                <p class="text-center text-gray-500 text-sm mt-2">LAYAR</p>
            </div>
            
            <!-- Seats Grid -->
            <form id="seatForm" action="{{ route('booking.process', $schedule->id) }}" method="POST">
                @csrf
                <div class="space-y-4">
                    @foreach($seatsByRow as $row => $seats)
                    <div class="flex justify-center gap-2">
                        <div class="w-8 flex items-center justify-center font-bold text-gray-400">{{ $row }}</div>
                        <div class="flex gap-2">
                            @foreach($seats as $seat)
                            <button type="button"
                                    class="seat-btn w-10 h-10 rounded-lg text-sm font-medium transition
                                           {{ $seat['is_booked'] ? 'bg-gray-300 cursor-not-allowed opacity-50' : 'bg-gray-100 hover:bg-red-100 hover:text-red-600 border-2 border-gray-200' }}
                                           {{ in_array($seat['id'], session('selected_seats', [])) ? 'bg-red-600 text-white border-red-600' : '' }}"
                                    data-seat-id="{{ $seat['id'] }}"
                                    data-seat-number="{{ $seat['nomor_kursi'] }}"
                                    {{ $seat['is_booked'] ? 'disabled' : '' }}>
                                {{ $seat['nomor'] }}
                            </button>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- Hidden input for selected seats -->
                <input type="hidden" name="selected_seats" id="selectedSeatsInput" value="">
                
                <!-- Legend -->
                <div class="flex justify-center gap-6 mt-8 pt-6 border-t border-gray-200">
                    <div class="flex items-center gap-2">
                        <div class="w-6 h-6 bg-gray-100 border-2 border-gray-200 rounded"></div>
                        <span class="text-sm text-gray-600">Tersedia</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-6 h-6 bg-red-600 rounded"></div>
                        <span class="text-sm text-gray-600">Dipilih</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-6 h-6 bg-gray-300 rounded opacity-50"></div>
                        <span class="text-sm text-gray-600">Terisi</span>
                    </div>
                </div>
                
                <!-- Summary -->
                <div class="mt-8 p-4 bg-gray-50 rounded-xl">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-gray-600">Kursi dipilih:</span>
                        <span id="selectedSeatsDisplay" class="font-semibold text-gray-900">-</span>
                    </div>
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-gray-600">Total harga:</span>
                        <span id="totalPriceDisplay" class="text-2xl font-bold text-red-600">Rp 0</span>
                    </div>
                    <button type="submit" id="submitBtn" class="w-full bg-red-600 hover:bg-red-700 text-white py-3 rounded-xl font-semibold transition disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                        Lanjutkan ke Pembayaran
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
let selectedSeats = [];
const hargaPerTiket = {{ $schedule->harga }};
const seatButtons = document.querySelectorAll('.seat-btn:not([disabled])');
const selectedSeatsInput = document.getElementById('selectedSeatsInput');
const selectedSeatsDisplay = document.getElementById('selectedSeatsDisplay');
const totalPriceDisplay = document.getElementById('totalPriceDisplay');
const submitBtn = document.getElementById('submitBtn');

function updateSummary() {
    // Update display
    if (selectedSeats.length === 0) {
        selectedSeatsDisplay.textContent = '-';
        totalPriceDisplay.textContent = 'Rp 0';
        submitBtn.disabled = true;
    } else {
        const seatNumbers = selectedSeats.map(s => s.number).join(', ');
        selectedSeatsDisplay.textContent = seatNumbers;
        const total = selectedSeats.length * hargaPerTiket;
        totalPriceDisplay.textContent = 'Rp ' + total.toLocaleString('id-ID');
        submitBtn.disabled = false;
    }
    
    // Update hidden input
    selectedSeatsInput.value = JSON.stringify(selectedSeats.map(s => s.id));
}

function toggleSeat(button, seatId, seatNumber) {
    const index = selectedSeats.findIndex(s => s.id === seatId);
    
    if (index === -1) {
        // Add seat
        selectedSeats.push({ id: seatId, number: seatNumber });
        button.classList.add('bg-red-600', 'text-white', 'border-red-600');
        button.classList.remove('bg-gray-100', 'hover:bg-red-100');
    } else {
        // Remove seat
        selectedSeats.splice(index, 1);
        button.classList.remove('bg-red-600', 'text-white', 'border-red-600');
        button.classList.add('bg-gray-100', 'hover:bg-red-100');
    }
    
    updateSummary();
}

seatButtons.forEach(btn => {
    btn.addEventListener('click', function() {
        const seatId = parseInt(this.dataset.seatId);
        const seatNumber = this.dataset.seatNumber;
        toggleSeat(this, seatId, seatNumber);
    });
});
</script>
@endsection