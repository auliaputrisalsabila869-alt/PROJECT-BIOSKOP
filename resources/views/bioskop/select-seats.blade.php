@extends('layouts.app')

@section('title', 'Pilih Kursi - CTIXID')

@section('content')
<div class="min-h-screen pt-28 pb-16 bg-gradient-to-b from-white via-[#fdf0f0] to-[#f7caca]">
    <div class="w-full max-w-[1600px] mx-auto px-6 md:px-10 lg:px-14 xl:pr-[520px]">
        <a href="javascript:history.back()" class="inline-flex items-center gap-3 text-gray-800 font-bold text-2xl mb-8">
            <i class="fas fa-arrow-left"></i>
            Pilih kursi kamu
        </a>

        <div class="grid grid-cols-1 gap-8 items-start">
            <div class="bg-white/70 rounded-3xl p-8 border border-white shadow-sm overflow-hidden">
                <div class="flex justify-center gap-8 mb-8 text-sm">
                    <div class="flex items-center gap-2">
                        <span class="w-5 h-5 rounded bg-gray-200"></span>
                        <span>Tersedia</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-5 h-5 rounded bg-gray-500"></span>
                        <span>Dibooking</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-5 h-5 rounded bg-red-500"></span>
                        <span>Terisi</span>
                    </div>
                </div>

                <div class="h-14 bg-gray-300 text-center text-gray-700 tracking-[0.4em] font-serif flex items-center justify-center mb-12"
                     style="clip-path: polygon(0 0, 100% 0, 95% 100%, 5% 100%);">
                    Area Layar
                </div>

                <div class="overflow-x-auto overflow-y-hidden pb-5">
                    <div class="min-w-[980px] space-y-3">
                        @php
                            $rows = range('K', 'A');
                            $bookedSeats = ['D12', 'D11', 'D8', 'D7', 'A8', 'A7'];
                        @endphp

                        @foreach($rows as $row)
                            <div class="grid grid-cols-[repeat(15,44px)] gap-3 justify-center">
                                @for($number = 15; $number >= 1; $number--)
                                    @php
                                        $seatCode = $row . $number;
                                        $isBooked = in_array($seatCode, $bookedSeats);
                                    @endphp

                                    <button
                                        type="button"
                                        class="seat-btn h-10 rounded-lg text-sm font-medium transition
                                        {{ $isBooked ? 'bg-red-500 text-white cursor-not-allowed' : 'bg-gray-200 text-teal-700 hover:bg-red-100 hover:text-red-700' }}"
                                        data-seat="{{ $seatCode }}"
                                        @disabled($isBooked)
                                    >
                                        {{ $seatCode }}
                                    </button>
                                @endfor
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>


                        {{-- KANAN: Ringkasan Pesanan --}}
            <aside class="w-full xl:fixed xl:right-10 xl:top-28 xl:w-[430px] xl:z-40">
                <div class="w-full bg-white/85 rounded-3xl overflow-hidden border border-white shadow-sm">

                    {{-- Film Info --}}
                    <div class="p-7 flex gap-5">
                        <div class="w-28 h-40 rounded-xl overflow-hidden bg-gray-200 shrink-0">
                            @if($schedule->film && $schedule->film->poster)
                                <img 
                                    src="{{ $schedule->film->poster }}" 
                                    class="w-full h-full object-cover" 
                                    alt="{{ $schedule->film->judul }}"
                                >
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    <i class="fas fa-film text-3xl"></i>
                                </div>
                            @endif
                        </div>

                        <div class="flex-1 min-w-0">
                            <h1 class="text-2xl font-black text-gray-800 mb-5 leading-tight">
                                {{ $schedule->film->judul ?? 'Film' }}
                            </h1>

                            <div class="space-y-3 text-sm">
                                <div class="flex items-start gap-3 text-gray-700">
                                    <i class="fas fa-flag shrink-0 w-4 text-center mt-[2px]"></i>
                                    <span class="leading-snug">
                                        Cinema XXI
                                    </span>
                                </div>

                                <div class="flex items-start gap-3 text-gray-700">
                                    <i class="fas fa-map-marker-alt shrink-0 w-4 text-center mt-[2px]"></i>
                                    <span class="leading-snug">
                                        {{ $schedule->studio->nama ?? '-' }}, Reguler 2D
                                    </span>
                                </div>

                                <div class="flex items-start gap-3 text-gray-700">
                                    <i class="fas fa-calendar-alt shrink-0 w-4 text-center mt-[2px]"></i>
                                    <span class="leading-snug">
                                        {{ \Carbon\Carbon::parse($schedule->tanggal)->translatedFormat('l, d F Y') }},
                                        {{ \Carbon\Carbon::parse($schedule->waktu_mulai)->format('H:i') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Time Bar --}}
                    <div class="bg-gray-200 px-7 py-5 flex items-center gap-4 text-xl font-bold text-gray-900">
                        <i class="far fa-clock text-2xl"></i>
                        {{ \Carbon\Carbon::parse($schedule->waktu_mulai)->format('H:i') }}
                    </div>

                    {{-- Selected Seats Summary --}}
                    <div class="p-7">
                        <p class="text-xl font-semibold mb-7 text-gray-900">
                            <span id="selectedSeatCount">0</span> kursi terpilih
                        </p>

                        <p id="selectedSeatList" class="text-gray-600 mb-7 min-h-[24px]">
                            Belum ada kursi dipilih
                        </p>

                        <div class="grid grid-cols-2 gap-5">
                            <button
                                type="button"
                                id="clearSeatsBtn"
                                class="h-14 rounded-full border-2 border-gray-400 text-gray-700 font-bold disabled:opacity-40 disabled:cursor-not-allowed hover:bg-white transition"
                                disabled
                            >
                                Hapus pilihan
                            </button>

                            <button
                                type="button"
                                id="continueBtn"
                                class="h-14 rounded-full bg-gray-500 text-white font-bold disabled:opacity-60 disabled:cursor-not-allowed transition"
                                disabled
                            >
                                Lanjut
                            </button>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</div>

{{-- Seat Limit Warning Modal --}}
<div 
    id="seatLimitModal"
    class="hidden fixed inset-0 z-[9999] flex items-center justify-center px-4"
>
    <div 
        class="absolute inset-0 bg-white/75 backdrop-blur-[2px]"
        onclick="closeSeatLimitModal()"
    ></div>

    <div class="relative w-full max-w-xl bg-[#eeeeee] rounded-2xl shadow-2xl px-8 py-10 text-center">
        <div class="w-28 h-28 rounded-full bg-red-50 mx-auto mb-8 flex items-center justify-center">
            <i class="fas fa-chair text-5xl text-red-600"></i>
        </div>

        <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-3 leading-snug">
            Kursi yang dipilih kebanyakan, nih
        </h2>

        <p class="text-gray-600 text-base md:text-lg mb-8">
            Kamu cuma bisa memilih <span id="maxSeatText" class="font-bold text-gray-800">{{ $qty }}</span> kursi dalam satu pesanan.
        </p>

        <button 
            type="button"
            onclick="closeSeatLimitModal()"
            class="w-full max-w-md h-14 rounded-full bg-black text-white font-bold hover:bg-gray-800 transition"
        >
            Siap
        </button>
    </div>
</div>

<script>
const maxSeats = {{ $qty }};
let selectedSeats = [];

function openSeatLimitModal() {
    const modal = document.getElementById('seatLimitModal');

    if (modal) {
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }
}

function closeSeatLimitModal() {
    const modal = document.getElementById('seatLimitModal');

    if (modal) {
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
}

function updateSeatSummary() {
    const countEl = document.getElementById('selectedSeatCount');
    const listEl = document.getElementById('selectedSeatList');
    const clearBtn = document.getElementById('clearSeatsBtn');
    const continueBtn = document.getElementById('continueBtn');

    countEl.textContent = selectedSeats.length;
    listEl.textContent = selectedSeats.length ? selectedSeats.join(', ') : 'Belum ada kursi dipilih';

    clearBtn.disabled = selectedSeats.length === 0;
    continueBtn.disabled = selectedSeats.length !== maxSeats;

    if (selectedSeats.length === maxSeats) {
        continueBtn.classList.remove('bg-gray-500');
        continueBtn.classList.add('bg-red-600', 'hover:bg-red-700');
    } else {
        continueBtn.classList.add('bg-gray-500');
        continueBtn.classList.remove('bg-red-600', 'hover:bg-red-700');
    }
}

document.querySelectorAll('.seat-btn:not(:disabled)').forEach(button => {
    button.addEventListener('click', function () {
        const seat = this.dataset.seat;
        const isSelected = selectedSeats.includes(seat);

        if (isSelected) {
            selectedSeats = selectedSeats.filter(item => item !== seat);
            this.classList.remove('bg-red-600', 'text-white');
            this.classList.add('bg-gray-200', 'text-teal-700');
        } else {
            if (selectedSeats.length >= maxSeats) {
                openSeatLimitModal();
                return;
            }

            selectedSeats.push(seat);
            this.classList.remove('bg-gray-200', 'text-teal-700');
            this.classList.add('bg-red-600', 'text-white');
        }

        updateSeatSummary();
    });
});

document.getElementById('clearSeatsBtn').addEventListener('click', function () {
    selectedSeats = [];

    document.querySelectorAll('.seat-btn:not(:disabled)').forEach(button => {
        button.classList.remove('bg-red-600', 'text-white');
        button.classList.add('bg-gray-200', 'text-teal-700');
    });

    updateSeatSummary();
});

const continueBtn = document.getElementById('continueBtn');

if (continueBtn) {
    continueBtn.addEventListener('click', function () {
        if (selectedSeats.length !== maxSeats) {
            openSeatLimitModal();
            return;
        }

        const seatsParam = encodeURIComponent(selectedSeats.join(','));
        const paymentUrl = "{{ route('bioskop.payment', $schedule->id) }}";

        window.location.href = `${paymentUrl}?seats=${seatsParam}`;
    });
}

updateSeatSummary();

document.addEventListener('keydown', function (event) {
    if (event.key === 'Escape') {
        closeSeatLimitModal();
    }
});
</script>
@endsection