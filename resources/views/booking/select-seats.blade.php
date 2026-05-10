@extends('layouts.app')

@section('title', 'Pilih Kursi - ' . $schedule->film->judul)

@section('content')
<div class="min-h-screen pt-20 bg-gray-50">

    {{-- Top Bar --}}
    <div class="bg-white border-b border-gray-200 px-6 py-3 flex items-center gap-4 sticky top-16 z-30 shadow-sm">
        <a href="{{ route('booking.select-schedule', $schedule->film_id) }}"
           class="w-9 h-9 flex items-center justify-center rounded-full hover:bg-gray-100 transition text-gray-600">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1 class="text-lg font-bold text-gray-900">Pilih kursi kamu</h1>
    </div>

    <div class="flex flex-col lg:flex-row gap-0 max-w-7xl mx-auto">

        {{-- LEFT: Studio Layout --}}
        <div class="flex-1 px-6 py-8 overflow-x-auto">

            {{-- Legenda --}}
            <div class="flex items-center justify-center gap-6 mb-8">
                <div class="flex items-center gap-2 text-sm text-gray-500">
                    <div class="w-7 h-7 bg-gray-100 border-2 border-gray-200 rounded-lg"></div>
                    Tersedia
                </div>
                <div class="flex items-center gap-2 text-sm text-gray-500">
                    <div class="w-7 h-7 bg-gray-300 rounded-lg"></div>
                    Dibooking
                </div>
                <div class="flex items-center gap-2 text-sm text-gray-500">
                    <div class="w-7 h-7 bg-red-500 rounded-lg"></div>
                    Terisi
                </div>
                <div class="flex items-center gap-2 text-sm text-gray-500">
                    <div class="w-7 h-7 bg-teal-500 rounded-lg"></div>
                    Dipilih
                </div>
            </div>

            {{-- Area Layar --}}
            <div class="mb-8">
                <div class="relative w-full max-w-xl mx-auto">
                    <div class="h-10 bg-gradient-to-b from-gray-300 to-gray-200 rounded-t-[50%] flex items-center justify-center shadow-md">
                        <span class="text-xs text-gray-500 font-medium tracking-widest">Area Layar</span>
                    </div>
                </div>
            </div>

            {{-- Form Kursi --}}
            <form id="seatForm" action="{{ route('booking.process', $schedule->id) }}" method="POST">
                @csrf
                <input type="hidden" name="selected_seats" id="selectedSeatsInput" value="">

                <div class="space-y-2 min-w-max mx-auto">
                    @foreach($seatsByRow as $row => $seats)
                    <div class="flex items-center gap-2">
                        <div class="w-6 text-center text-xs font-bold text-gray-400 flex-shrink-0">{{ $row }}</div>
                        <div class="flex gap-1.5 flex-wrap">
                            @foreach($seats as $seat)
                            <button
                                type="button"
                                class="seat-btn w-9 h-9 rounded-lg text-xs font-semibold transition-all flex items-center justify-center
                                       {{ $seat['is_booked']
                                           ? 'bg-red-400 text-white cursor-not-allowed'
                                           : 'bg-gray-100 border border-gray-200 hover:border-teal-400 hover:bg-teal-50 text-gray-600' }}"
                                data-seat-id="{{ $seat['id'] }}"
                                data-seat-number="{{ $seat['nomor_kursi'] }}"
                                {{ $seat['is_booked'] ? 'disabled' : '' }}>
                                {{ $seat['nomor_kursi'] }}
                            </button>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
            </form>
        </div>

        {{-- RIGHT: Sidebar Info --}}
        <div class="lg:w-80 xl:w-96 bg-white border-l border-gray-200 flex flex-col sticky top-28 self-start min-h-[calc(100vh-7rem)]">

            {{-- Film Info --}}
            <div class="p-5 border-b border-gray-100">
                <div class="flex gap-4">
                    @if($schedule->film->poster)
                    <img src="{{ $schedule->film->poster }}" alt="{{ $schedule->film->judul }}"
                         class="w-16 h-24 object-cover rounded-lg shadow flex-shrink-0">
                    @else
                    <div class="w-16 h-24 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-film text-gray-400 text-xl"></i>
                    </div>
                    @endif
                    <div>
                        <h2 class="font-black text-gray-900 text-base leading-tight">{{ $schedule->film->judul }}</h2>
                        <div class="mt-2 space-y-1.5">
                            <div class="flex items-center gap-2 text-xs text-gray-500">
                                <i class="fas fa-film text-gray-400 w-3"></i>
                                <span>Cinema XXI</span>
                            </div>
                            <div class="flex items-start gap-2 text-xs text-gray-500">
                                <i class="fas fa-map-marker-alt text-gray-400 w-3 mt-0.5"></i>
                                <span>{{ $schedule->studio->nama }}, Reguler 2D</span>
                            </div>
                            <div class="flex items-center gap-2 text-xs text-gray-500">
                                <i class="fas fa-calendar text-gray-400 w-3"></i>
                                <span>{{ $schedule->tanggal_formatted }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Jam Tayang --}}
            <div class="px-5 py-3 border-b border-gray-100 bg-gray-50">
                <div class="flex items-center gap-3">
                    <i class="fas fa-clock text-gray-500 text-lg"></i>
                    <span class="text-2xl font-black text-gray-900">{{ $schedule->waktu_tayang }}</span>
                </div>
            </div>

            {{-- Kursi Dipilih --}}
            <div class="px-5 py-4 flex-1 border-b border-gray-100">
                <p class="text-sm font-bold text-gray-700 mb-1">Nomor kursi</p>
                <p id="sidebarSeats" class="text-sm text-gray-400">Kamu belum pilih kursi</p>
                <div id="sidebarSeatsWrap" class="flex flex-wrap gap-1.5 mt-2 hidden"></div>

                <p class="text-sm font-bold text-gray-700 mt-4">
                    <span id="sidebarCount">0</span> kursi terpilih
                </p>

                {{-- Total Harga --}}
                <div id="totalSection" class="hidden mt-4 pt-4 border-t border-gray-100">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">Total</span>
                        <span id="sidebarTotal" class="text-xl font-black text-gray-900"></span>
                    </div>
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="p-5 space-y-2 border-t border-gray-100 bg-white">
                <button type="button" onclick="clearSeats()"
                        class="w-full border-2 border-gray-300 text-gray-700 font-semibold py-3 rounded-xl hover:border-gray-400 transition text-sm">
                    Hapus pilihan
                </button>
                <button type="button" id="lanjutBtn" onclick="submitSeats()"
                        disabled
                        class="w-full bg-gray-300 text-gray-500 font-bold py-3 rounded-xl transition text-sm cursor-not-allowed"
                        id="lanjutBtn">
                    Lanjut
                </button>
            </div>
        </div>

    </div>
</div>

{{-- Error --}}
@if(session('error'))
<div class="fixed top-24 left-1/2 -translate-x-1/2 z-50 bg-red-600 text-white px-6 py-3 rounded-xl shadow-lg flex items-center gap-2 text-sm">
    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
</div>
@endif

<script>
let selectedSeats  = [];
const hargaPerTiket = {{ $schedule->harga }};
const maxQty        = {{ request('qty', 8) }};

function updateSidebar() {
    const countEl      = document.getElementById('sidebarCount');
    const seatsEl      = document.getElementById('sidebarSeats');
    const seatsWrap    = document.getElementById('sidebarSeatsWrap');
    const totalSection = document.getElementById('totalSection');
    const totalEl      = document.getElementById('sidebarTotal');
    const lanjutBtn    = document.getElementById('lanjutBtn');
    const inputEl      = document.getElementById('selectedSeatsInput');

    countEl.textContent = selectedSeats.length;

    if (selectedSeats.length === 0) {
        seatsEl.textContent = 'Kamu belum pilih kursi';
        seatsEl.classList.remove('hidden');
        seatsWrap.classList.add('hidden');
        seatsWrap.innerHTML = '';
        totalSection.classList.add('hidden');

        lanjutBtn.disabled  = true;
        lanjutBtn.className = 'w-full bg-gray-300 text-gray-500 font-bold py-3 rounded-xl transition text-sm cursor-not-allowed';
        inputEl.value       = '';
    } else {
        seatsEl.classList.add('hidden');
        seatsWrap.classList.remove('hidden');
        seatsWrap.innerHTML = selectedSeats.map(s =>
            `<span class="text-xs bg-teal-100 text-teal-700 font-bold px-2 py-1 rounded-lg">${s.number}</span>`
        ).join('');

        const total         = selectedSeats.length * hargaPerTiket;
        totalEl.textContent = 'Rp ' + total.toLocaleString('id-ID');
        totalSection.classList.remove('hidden');

        lanjutBtn.disabled  = false;
        lanjutBtn.className = 'w-full bg-gray-900 hover:bg-gray-700 text-white font-bold py-3 rounded-xl transition text-sm';
        inputEl.value       = JSON.stringify(selectedSeats.map(s => s.id));
    }
}

function clearSeats() {
    selectedSeats.forEach(s => {
        const btn = document.querySelector(`[data-seat-id="${s.id}"]`);
        if (btn) {
            btn.classList.remove('bg-teal-500', 'text-white', 'border-teal-500');
            btn.classList.add('bg-gray-100', 'border', 'border-gray-200', 'text-gray-600');
        }
    });
    selectedSeats = [];
    updateSidebar();
}

function submitSeats() {
    if (selectedSeats.length === 0) return;
    document.getElementById('seatForm').submit();
}

document.querySelectorAll('.seat-btn:not([disabled])').forEach(btn => {
    btn.addEventListener('click', function () {
        const seatId     = parseInt(this.dataset.seatId);
        const seatNumber = this.dataset.seatNumber;
        const index      = selectedSeats.findIndex(s => s.id === seatId);

        if (index === -1) {
            // Cek batas maksimum
            if (selectedSeats.length >= maxQty) {
                // Flash warning
                this.classList.add('animate-pulse');
                setTimeout(() => this.classList.remove('animate-pulse'), 600);
                return;
            }
            selectedSeats.push({ id: seatId, number: seatNumber });
            this.classList.add('bg-teal-500', 'text-white', 'border-teal-500');
            this.classList.remove('bg-gray-100', 'border', 'border-gray-200', 'text-gray-600',
                                   'hover:border-teal-400', 'hover:bg-teal-50');
        } else {
            selectedSeats.splice(index, 1);
            this.classList.remove('bg-teal-500', 'text-white', 'border-teal-500');
            this.classList.add('bg-gray-100', 'border', 'border-gray-200', 'text-gray-600',
                                'hover:border-teal-400', 'hover:bg-teal-50');
        }

        updateSidebar();
    });
});
</script>
@endsection