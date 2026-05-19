@extends('layouts.app')

@section('title', 'Pembayaran QRIS - CTIXID')

@section('content')
<div class="min-h-screen pt-28 pb-16 bg-gradient-to-b from-white via-[#fdf0f0] to-[#f7caca]">
    <div class="w-full max-w-6xl mx-auto px-6 md:px-10">

        {{-- Payment Notice --}}
        <div class="bg-white/80 border border-white rounded-3xl shadow-sm p-6 mb-8 flex items-center justify-between gap-5">
            <div>
                <h2 class="text-xl md:text-2xl font-bold text-red-600">
                    Selesaikan pembayaran dengan QRIS
                </h2>
                <p class="text-gray-600 mt-1">
                    Scan kode QRIS menggunakan aplikasi e-wallet atau mobile banking yang mendukung QRIS.
                </p>
            </div>

            <div 
                id="qrisCountdown"
                class="shrink-0 bg-red-100 text-red-700 rounded-xl px-5 py-3 font-bold"
            >
                10:00
            </div>
        </div>

        <a href="javascript:history.back()" class="inline-flex items-center gap-3 text-gray-800 font-bold text-2xl mb-8">
            <i class="fas fa-arrow-left"></i>
            Konfirmasi pesanan
        </a>

        <div class="grid grid-cols-1 lg:grid-cols-[1fr_430px] gap-8 items-start">

            {{-- LEFT: QRIS Payment --}}
            <div class="bg-white/85 rounded-3xl border border-white shadow-sm p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">
                    Metode pembayaran
                </h2>

                <div class="border-2 border-red-500 rounded-2xl p-5 mb-8 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-5 h-5 rounded-full border-2 border-red-600 flex items-center justify-center">
                            <div class="w-2.5 h-2.5 rounded-full bg-red-600"></div>
                        </div>

                        <div>
                            <p class="text-lg font-bold text-gray-900">QRIS</p>
                            <p class="text-gray-500 text-sm">Universal payment Indonesia</p>
                        </div>
                    </div>

                    <div class="text-red-600 font-black text-2xl">
                        QRIS
                    </div>
                </div>

                <div class="flex flex-col items-center">
                    <div class="bg-white rounded-3xl p-5 shadow-sm border border-gray-100">
                        {{-- QRIS dummy visual untuk demo --}}
                        <div class="w-72 h-72 bg-white grid grid-cols-7 gap-2 p-4 border border-gray-200 rounded-xl">
                            @for($i = 1; $i <= 49; $i++)
                                @php
                                    $filled = in_array($i, [1,2,3,8,10,15,16,17,22,24,25,29,31,34,36,37,38,40,43,45,47,48,49]);
                                @endphp

                                <div class="{{ $filled ? 'bg-gray-900' : 'bg-gray-100' }} rounded-sm"></div>
                            @endfor
                        </div>
                    </div>

                    <p class="text-gray-600 text-center mt-5 max-w-md">
                        Ini tampilan QRIS untuk demo project. Untuk pembayaran asli, QRIS harus dibuat melalui payment gateway atau merchant QRIS resmi.
                    </p>
                </div>
            </div>

            {{-- RIGHT: Order Detail --}}
            <div class="bg-white/90 rounded-3xl border border-white shadow-sm overflow-hidden">
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

                <div class="border-t border-gray-200 mx-7"></div>

                <div class="p-7">
                    <h3 class="text-xl font-bold text-gray-900 mb-5">
                        Detail tiket
                    </h3>

                    <div class="space-y-3 mb-6">
                        @foreach($seatList as $seat)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <span class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center text-gray-800 font-bold">
                                        {{ $seat }}
                                    </span>

                                    <div>
                                        <p class="font-semibold text-gray-900">Tiket</p>
                                        <p class="text-gray-500 text-sm">Reguler 2D</p>
                                    </div>
                                </div>

                                <p class="font-bold text-gray-900">
                                    Rp{{ number_format($ticketPrice, 0, ',', '.') }}
                                </p>
                            </div>
                        @endforeach
                    </div>

                    <div class="border-t border-gray-200 pt-5 space-y-3">
                        <div class="flex items-center justify-between text-gray-700">
                            <span>Subtotal</span>
                            <span>Rp{{ number_format($totalPrice, 0, ',', '.') }}</span>
                        </div>

                        <div class="flex items-center justify-between text-gray-900 font-bold text-lg">
                            <span>Total pembayaran</span>
                            <span>Rp{{ number_format($totalPrice, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <button
                        type="button"
                        id="confirmPaymentBtn"
                        class="mt-7 w-full h-14 rounded-full bg-red-600 text-white font-bold hover:bg-red-700 transition"
                    >
                        Saya sudah bayar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const countdownElement = document.getElementById('qrisCountdown');

    if (!countdownElement) return;

    let remainingSeconds = 10 * 60;

    function updateCountdown() {
        const minutes = Math.floor(remainingSeconds / 60);
        const seconds = remainingSeconds % 60;

        countdownElement.textContent =
            String(minutes).padStart(2, '0') + ':' + String(seconds).padStart(2, '0');

        if (remainingSeconds <= 0) {
            clearInterval(timer);

            countdownElement.textContent = '00:00';
            countdownElement.classList.remove('bg-red-100', 'text-red-700');
            countdownElement.classList.add('bg-gray-200', 'text-gray-600');

            const payButton = document.querySelector('#confirmPaymentBtn');

            if (payButton) {
                payButton.disabled = true;
                payButton.textContent = 'Waktu pembayaran habis';
                payButton.classList.remove('bg-red-600', 'hover:bg-red-700');
                payButton.classList.add('bg-gray-400', 'cursor-not-allowed');
            }

            return;
        }

        remainingSeconds--;
    }

    updateCountdown();

    const timer = setInterval(updateCountdown, 1000);
});
</script>

@endsection