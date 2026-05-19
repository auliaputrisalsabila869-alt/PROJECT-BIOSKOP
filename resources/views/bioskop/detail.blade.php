@extends('layouts.app')

@section('title', $studio->nama . ' - CTIXID')

@section('content')
<div class="min-h-screen pt-28 pb-16 bg-gradient-to-b from-white via-[#fdf0f0] to-[#f7caca]">
    <div class="max-w-5xl mx-auto px-5">

        {{-- Breadcrumb --}}
        <nav class="text-sm md:text-base text-gray-500 mb-6">
            <a href="{{ route('home') }}" class="hover:text-red-600 transition">Beranda</a>
            <span class="mx-2">/</span>
            <span>Bioskop</span>
            <span class="mx-2">/</span>
            <span class="font-bold text-gray-800">{{ $studio->nama }}</span>
        </nav>

        {{-- Title --}}
        <h1 class="text-4xl md:text-5xl font-black tracking-wide text-gray-800 mb-6">
            {{ $studio->nama }}
        </h1>

        {{-- Info Button --}}
        <button 
            type="button" 
            class="inline-flex items-center gap-2 border border-red-500 text-gray-800 rounded-full px-5 py-2 text-sm font-semibold mb-7 hover:bg-red-50 transition"
        >
            <i class="fas fa-info-circle text-red-600"></i>
            Info Bioskop
        </button>

        {{-- Date Picker --}}
        <div class="flex items-center gap-5 md:gap-10 mb-10 overflow-x-auto pb-2">
            @php
                $days = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
                $today = now();
            @endphp

            @for ($i = 0; $i < 7; $i++)
                @php
                    $date = $today->copy()->addDays($i);
                    $isActive = $date->toDateString() === $tanggal;
                    $dayLabel = $i === 0 ? 'Hari ini' : $days[$date->dayOfWeek];
                @endphp

                <a 
                    href="{{ route('bioskop.detail', \Illuminate\Support\Str::slug($studio->nama)) }}?tanggal={{ $date->toDateString() }}"
                    class="min-w-[66px] rounded-xl px-4 py-3 text-center transition
                    {{ $isActive ? 'bg-red-600 text-white shadow-md' : 'text-gray-500 hover:bg-white/70' }}"
                >
                    <div class="text-sm font-medium">{{ $dayLabel }}</div>
                    <div class="text-xl font-bold">{{ $date->format('d') }}</div>
                </a>
            @endfor
        </div>

        {{-- Brand + Search --}}
        <div class="flex items-center justify-between mb-7">
            <div class="inline-flex items-center justify-center bg-black text-white rounded-2xl px-9 py-3">
                <span class="font-serif italic text-lg">
                    Cinema <span class="font-bold">XXI</span>
                </span>
            </div>

            <div class="hidden md:flex items-center gap-3 text-gray-600">
                <i class="fas fa-search text-xl"></i>
                <input
                    type="text"
                    id="cinemaMovieSearch"
                    placeholder="Search"
                    class="bg-transparent border-none outline-none text-base placeholder-gray-600 w-32"
                >
            </div>
        </div>

        {{-- Film List --}}
        <div class="space-y-6 max-w-5xl mx-auto" id="cinemaMovieList">
            @if($films->isEmpty())
                <div class="bg-white/75 rounded-3xl p-12 text-center border border-white">
                    <i class="fas fa-film text-5xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500 text-lg">
                        Belum ada jadwal film untuk tanggal ini.
                    </p>
                </div>
            @else
                @foreach($films as $item)
                    @php
                        $film = $item['film'];
                    @endphp

                    @continue(!$film)

                    @php
                        $posterPath = $film->poster;
                        $posterIsUrl = $posterPath && \Illuminate\Support\Str::startsWith($posterPath, ['http://', 'https://']);
                        $posterExists = $posterPath && ($posterIsUrl || file_exists(public_path(ltrim($posterPath, '/'))));

                        $firstSchedule = $item['schedules']->first();
                        $ticketPrice = $firstSchedule ? number_format($firstSchedule->harga, 0, ',', '.') : '0';
                    @endphp

                    <div 
                        class="cinema-movie-card bg-white/85 rounded-3xl p-6 md:p-7 shadow-sm border border-white"
                        data-title="{{ strtolower($film->judul) }}"
                    >
                        {{-- Top Film Info --}}
                        <div class="flex items-center gap-6">
                            <div class="w-24 h-36 rounded-xl overflow-hidden bg-gray-200 shrink-0">
                                @if($posterExists)
                                    <img 
                                        src="{{ $posterPath }}"
                                        alt="{{ $film->judul }}"
                                        class="w-full h-full object-cover"
                                        onerror="this.outerHTML='<div class=\'w-full h-full flex items-center justify-center bg-gray-200 text-gray-400\'><i class=\'fas fa-film text-3xl\'></i></div>'"
                                    >
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gray-200 text-gray-400">
                                        <i class="fas fa-film text-3xl"></i>
                                    </div>
                                @endif
                            </div>

                            <div class="flex-1">
                                <h3 class="text-2xl font-bold text-gray-800 mb-2">
                                    {{ $film->judul }}
                                </h3>

                                <p class="text-gray-500 text-sm mb-4">
                                    {{ $film->genre }}
                                </p>

                                <div class="flex items-center gap-2">
                                    <span class="bg-yellow-100 text-yellow-700 text-xs font-bold px-3 py-1 rounded-md">
                                        {{ $film->age_rating ?? 'R13+' }}
                                    </span>

                                    <span class="bg-gray-100 text-gray-700 text-sm font-semibold px-3 py-1 rounded-md">
                                        2D
                                    </span>
                                </div>
                            </div>

                            <button 
                                type="button"
                                class="text-gray-400 hover:text-red-600 transition shrink-0"
                                onclick="this.closest('.cinema-movie-card').querySelector('.schedule-detail').classList.toggle('hidden')"
                            >
                                <i class="fas fa-chevron-down text-xl"></i>
                            </button>
                        </div>

                        {{-- Schedule Detail --}}
                        <div class="schedule-detail mt-7 pt-7 border-t border-gray-200">
                            <div class="flex items-center justify-between mb-5">
                                <p class="text-gray-800 font-semibold text-lg">
                                    Reguler 2D
                                </p>

                                <p class="text-gray-800 font-bold text-lg">
                                    Rp{{ $ticketPrice }}
                                </p>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 max-w-2xl">
                                @foreach($item['schedules'] as $schedule)
                                    @guest
                                        <button
                                            type="button"
                                            class="open-login-modal bg-red-600 hover:bg-red-700 text-white rounded-lg px-5 py-4 font-bold text-center transition"
                                        >
                                            {{ \Carbon\Carbon::parse($schedule->waktu_mulai)->format('H:i') }}
                                        </button>
                                    @else
                                        <button
                                            type="button"
                                            class="open-seat-count-modal bg-red-600 hover:bg-red-700 text-white rounded-lg px-5 py-4 font-bold text-center transition"
                                            data-film-title="{{ $film->judul }}"
                                            data-studio-name="{{ $studio->nama }}"
                                            data-show-date="{{ \Carbon\Carbon::parse($schedule->tanggal)->translatedFormat('l, d F Y') }}"
                                            data-show-time="{{ \Carbon\Carbon::parse($schedule->waktu_mulai)->format('H:i') }}"
                                            data-seat-url="{{ route('bioskop.select-seats', $schedule->id) }}"
                                        >
                                            {{ \Carbon\Carbon::parse($schedule->waktu_mulai)->format('H:i') }}
                                        </button>
                                    @endguest
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

{{-- Login Required Modal --}}
<div 
    id="loginRequiredModal"
    class="hidden fixed inset-0 z-[9999] flex items-center justify-center px-4"
>
    <div 
        class="absolute inset-0 bg-white/75 backdrop-blur-[2px]"
        data-close-login-modal
    ></div>

    <div class="relative w-full max-w-xl bg-[#eeeeee] rounded-2xl shadow-2xl px-8 py-10 text-center">
        <div class="w-28 h-28 rounded-full bg-gray-200 mx-auto mb-8 flex items-center justify-center">
            <i class="fas fa-sign-in-alt text-5xl text-gray-700"></i>
        </div>

        <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-3">
            Yuk, login dulu buat lanjut
        </h2>

        <p class="text-gray-600 text-base md:text-lg mb-8">
            Kamu baru bisa akses halaman ini setelah login.
        </p>

        <div class="grid grid-cols-2 gap-5 max-w-md mx-auto">
            <button 
                type="button"
                data-close-login-modal
                class="h-14 rounded-full border-2 border-gray-700 text-gray-800 font-bold hover:bg-white transition"
            >
                Nanti aja
            </button>

            <a 
                href="{{ url('/login') }}"
                class="h-14 rounded-full bg-black text-white font-bold flex items-center justify-center hover:bg-gray-800 transition"
            >
                Login
            </a>
        </div>
    </div>
</div>

{{-- Seat Count Modal --}}
<div 
    id="seatCountModal"
    class="hidden fixed inset-0 z-[9999] flex items-center justify-center px-4"
>
    <div 
        class="absolute inset-0 bg-white/75 backdrop-blur-[2px]"
        data-close-seat-modal
    ></div>

    <div class="relative w-full max-w-xl bg-[#eeeeee] rounded-2xl shadow-2xl overflow-hidden">
        <div class="flex items-center gap-4 px-8 py-6 border-b border-gray-300">
            <button 
                type="button" 
                data-close-seat-modal
                class="text-gray-700 hover:text-red-600 transition"
            >
                <i class="fas fa-times text-2xl"></i>
            </button>

            <h2 class="text-2xl font-bold text-gray-800">
                How many seats needed?
            </h2>
        </div>

        <div class="px-8 py-8">
            <div class="flex items-start gap-8 mb-8">
                <div class="font-serif italic text-2xl text-gray-800 shrink-0">
                    Cinema <span class="font-bold">XXI</span>
                </div>

                <div>
                    <h3 id="seatModalFilmTitle" class="text-2xl font-bold text-gray-800 uppercase">
                        -
                    </h3>
                    <p id="seatModalDate" class="text-gray-600 mt-1">
                        -
                    </p>
                </div>
            </div>

            <ul class="text-amber-700 text-sm leading-relaxed mb-7 list-disc pl-5 space-y-2">
                <li>Tiket yang sudah dibeli tidak bisa di-refund atau ditukar.</li>
                <li>Kamu wajib membeli tiket untuk anak berumur 2 tahun dan lebih.</li>
            </ul>

            <div class="bg-gray-200 rounded-lg px-6 py-5 mb-7">
                <span id="seatModalTime" class="font-bold text-gray-800 text-lg">
                    -
                </span>
            </div>

            <div class="flex items-center justify-center gap-7 mb-8">
                <button 
                    type="button"
                    id="decreaseSeatBtn"
                    class="w-12 h-12 rounded-full border border-gray-400 text-gray-700 text-2xl hover:bg-white transition"
                >
                    -
                </button>

                <span id="seatCountValue" class="text-2xl font-bold text-gray-800 w-8 text-center">
                    1
                </span>

                <button 
                    type="button"
                    id="increaseSeatBtn"
                    class="w-12 h-12 rounded-full border border-gray-400 text-gray-700 text-2xl hover:bg-white transition"
                >
                    +
                </button>
            </div>

            <a 
                id="continueSeatBtn"
                href="#"
                class="block w-full h-14 rounded-full bg-black text-white font-bold text-center leading-[56px] hover:bg-gray-800 transition"
            >
                Continue
            </a>
        </div>
    </div>
</div>

<script>
let selectedSeatCount = 1;
let selectedSeatBaseUrl = '#';

function openLoginRequiredModal() {
    const modal = document.getElementById('loginRequiredModal');

    if (modal) {
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }
}

function closeLoginRequiredModal() {
    const modal = document.getElementById('loginRequiredModal');

    if (modal) {
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
}

function openSeatCountModal(button) {
    const modal = document.getElementById('seatCountModal');
    const filmTitle = document.getElementById('seatModalFilmTitle');
    const dateText = document.getElementById('seatModalDate');
    const timeText = document.getElementById('seatModalTime');

    selectedSeatCount = 1;
    selectedSeatBaseUrl = button.dataset.seatUrl || '#';

    document.getElementById('seatCountValue').textContent = selectedSeatCount;

    if (filmTitle) filmTitle.textContent = button.dataset.filmTitle || '-';
    if (dateText) dateText.textContent = button.dataset.showDate || '-';
    if (timeText) timeText.textContent = button.dataset.showTime || '-';

    updateContinueSeatUrl();

    if (modal) {
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }
}

function closeSeatCountModal() {
    const modal = document.getElementById('seatCountModal');

    if (modal) {
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
}

function updateContinueSeatUrl() {
    const continueBtn = document.getElementById('continueSeatBtn');

    if (!continueBtn) return;

    const separator = selectedSeatBaseUrl.includes('?') ? '&' : '?';
    continueBtn.href = `${selectedSeatBaseUrl}${separator}seat_count=${selectedSeatCount}`;
}

document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('cinemaMovieSearch');
    const cards = document.querySelectorAll('.cinema-movie-card');

    const loginButtons = document.querySelectorAll('.open-login-modal');
    const seatButtons = document.querySelectorAll('.open-seat-count-modal');
    const closeLoginButtons = document.querySelectorAll('[data-close-login-modal]');
    const closeSeatButtons = document.querySelectorAll('[data-close-seat-modal]');

    const decreaseSeatBtn = document.getElementById('decreaseSeatBtn');
    const increaseSeatBtn = document.getElementById('increaseSeatBtn');
    const seatCountValue = document.getElementById('seatCountValue');

    loginButtons.forEach(button => {
        button.addEventListener('click', function (event) {
            event.preventDefault();
            openLoginRequiredModal();
        });
    });

    seatButtons.forEach(button => {
        button.addEventListener('click', function (event) {
            event.preventDefault();
            openSeatCountModal(button);
        });
    });

    closeLoginButtons.forEach(button => {
        button.addEventListener('click', closeLoginRequiredModal);
    });

    closeSeatButtons.forEach(button => {
        button.addEventListener('click', closeSeatCountModal);
    });

    if (decreaseSeatBtn) {
        decreaseSeatBtn.addEventListener('click', function () {
            if (selectedSeatCount > 1) {
                selectedSeatCount--;
                seatCountValue.textContent = selectedSeatCount;
                updateContinueSeatUrl();
            }
        });
    }

    if (increaseSeatBtn) {
        increaseSeatBtn.addEventListener('click', function () {
            if (selectedSeatCount < 10) {
                selectedSeatCount++;
                seatCountValue.textContent = selectedSeatCount;
                updateContinueSeatUrl();
            }
        });
    }

    if (searchInput) {
        searchInput.addEventListener('input', function () {
            const keyword = this.value.toLowerCase().trim();

            cards.forEach(card => {
                const title = card.dataset.title || '';
                card.style.display = title.includes(keyword) ? 'block' : 'none';
            });
        });
    }
});

document.addEventListener('keydown', function (event) {
    if (event.key === 'Escape') {
        closeLoginRequiredModal();
        closeSeatCountModal();
    }
});
</script>
@endsection