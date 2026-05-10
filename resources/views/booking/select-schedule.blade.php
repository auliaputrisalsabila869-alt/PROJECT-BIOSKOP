@extends('layouts.app')

@section('title', 'Pilih Jadwal - ' . $film->judul)

@section('content')
<section class="min-h-screen pt-24 pb-12 bg-gradient-to-b from-gray-50 to-white">
    <div class="container mx-auto px-4 max-w-5xl">

        {{-- Header --}}
        <div class="mb-8">
            <a href="{{ route('films.show', $film->slug ?? \Illuminate\Support\Str::slug($film->judul)) }}"
               class="text-red-600 hover:text-red-700 mb-4 inline-flex items-center gap-2 text-sm font-medium">
                <i class="fas fa-arrow-left"></i> Kembali ke Detail Film
            </a>
            <div class="mt-4 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Pilih Jadwal Tayang</h1>
                    <p class="text-gray-500 mt-1">
                        <i class="fas fa-film text-red-400 mr-1"></i>
                        {{ $film->judul }}
                        @if(isset($film->duration) || isset($film->durasi))
                        &nbsp;·&nbsp;
                        <span class="text-gray-400 text-sm">
                            <i class="fas fa-clock mr-1"></i>
                            {{ $film->duration ?? $film->durasi . ' menit' }}
                        </span>
                        @endif
                    </p>
                </div>
                @if(!empty($selectedStudio))
                <div class="flex items-center gap-3 bg-red-50 border border-red-100 rounded-xl px-4 py-3">
                    <i class="fas fa-building text-red-500"></i>
                    <div>
                        <p class="text-xs text-red-500 font-semibold uppercase tracking-wide">Studio Dipilih</p>
                        <p class="font-bold text-gray-900 text-sm">{{ $selectedStudio->nama }}</p>
                    </div>
                    <a href="{{ route('booking.select-studio', $film->id) }}"
                       class="ml-3 text-xs text-red-600 hover:text-red-700 font-semibold underline">Ubah</a>
                </div>
                @endif
            </div>
        </div>

        {{-- Tab Tanggal 7 Hari --}}
        <div class="bg-white rounded-2xl shadow-md border border-gray-200 overflow-hidden mb-8">
            <div class="grid grid-cols-7">
                @foreach($dates as $index => $date)
                @php
                    $dateKey     = $date->format('Y-m-d');
                    $hasSchedule = isset($schedulesByDate[$dateKey]) && count($schedulesByDate[$dateKey]) > 0;
                    $isToday     = $date->isToday();
                @endphp
                <button onclick="scrollToDate('{{ $date->format('Ymd') }}')"
                        class="relative flex flex-col items-center justify-center py-4 px-1 transition-all
                               {{ $isToday ? 'bg-red-600 text-white' : 'bg-white hover:bg-red-50 text-gray-700 hover:text-red-600' }}
                               {{ $index < 6 ? 'border-r border-gray-100' : '' }}">
                    <span class="text-xs font-medium uppercase tracking-wider {{ $isToday ? 'text-red-100' : 'text-gray-400' }}">
                        {{ $date->translatedFormat('D') }}
                    </span>
                    <span class="text-2xl font-black mt-0.5 leading-none">{{ $date->format('d') }}</span>
                    <span class="text-xs mt-0.5 {{ $isToday ? 'text-red-100' : 'text-gray-400' }}">
                        {{ $date->translatedFormat('M') }}
                    </span>
                    @if($hasSchedule)
                    <span class="absolute bottom-1.5 w-1.5 h-1.5 rounded-full {{ $isToday ? 'bg-white' : 'bg-red-500' }}"></span>
                    @endif
                </button>
                @endforeach
            </div>
        </div>

        {{-- Jadwal Per Hari --}}
        <div class="space-y-10" id="scheduleContainer">
            @foreach($dates as $date)
            @php
                $dateKey   = $date->format('Y-m-d');
                $dayScheds = $schedulesByDate[$dateKey] ?? [];
            @endphp
            <div id="scheduleDate{{ $date->format('Ymd') }}" class="scroll-mt-28">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center {{ $date->isToday() ? 'bg-red-600' : 'bg-gray-100' }}">
                        <i class="fas fa-calendar-day text-sm {{ $date->isToday() ? 'text-white' : 'text-gray-500' }}"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                            {{ $date->translatedFormat('l') }}
                            @if($date->isToday())
                            <span class="text-xs bg-red-100 text-red-600 font-semibold px-2 py-0.5 rounded-full">Hari Ini</span>
                            @endif
                            @if($date->isTomorrow())
                            <span class="text-xs bg-orange-100 text-orange-600 font-semibold px-2 py-0.5 rounded-full">Besok</span>
                            @endif
                        </h2>
                        <p class="text-gray-400 text-sm">{{ $date->translatedFormat('d F Y') }}</p>
                    </div>
                </div>

                @if(count($dayScheds) > 0)
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                    @foreach($dayScheds as $schedule)
                    @php
                        $totalSeats  = \App\Models\Seat::where('studio_id', $schedule->studio_id)->count();
                        $bookedSeats = count($schedule->booked_seats);
                        $sisaKursi   = $totalSeats - $bookedSeats;
                        $almostFull  = $sisaKursi <= 5 && $sisaKursi > 0;
                        $isFull      = $sisaKursi <= 0;
                    @endphp
                    <button
                        type="button"
                        onclick="{{ $isFull ? '' : 'openTicketModal(' . $schedule->id . ', \'' . \Carbon\Carbon::parse($schedule->waktu_mulai)->format('H:i') . '\', \'' . addslashes($schedule->studio->nama) . '\', ' . $schedule->harga . ', \'' . $date->translatedFormat('l\, d F Y') . '\')' }}"
                        class="group relative bg-white border-2 rounded-xl p-4 text-left transition w-full
                               {{ $isFull ? 'border-gray-200 opacity-50 cursor-not-allowed' : 'border-gray-200 hover:border-red-500 hover:shadow-lg cursor-pointer' }}">

                        @if($isFull)
                        <span class="absolute top-2 right-2 text-xs bg-gray-200 text-gray-600 px-2 py-0.5 rounded-full font-semibold">Habis</span>
                        @elseif($almostFull)
                        <span class="absolute top-2 right-2 text-xs bg-orange-100 text-orange-600 px-2 py-0.5 rounded-full font-semibold animate-pulse">Hampir Penuh</span>
                        @endif

                        <div class="text-3xl font-black text-gray-800 group-hover:text-red-600 transition leading-none mb-2">
                            {{ \Carbon\Carbon::parse($schedule->waktu_mulai)->format('H:i') }}
                        </div>
                        <div class="text-xs text-gray-500 flex items-center gap-1 mb-3">
                            <i class="fas fa-building text-red-400"></i>
                            {{ $schedule->studio->nama }}
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-gray-400 flex items-center gap-1">
                                <i class="fas fa-chair"></i>
                                {{ $isFull ? 'Penuh' : $sisaKursi . ' kursi' }}
                            </span>
                            <span class="text-sm font-bold text-red-600">
                                Rp {{ number_format($schedule->harga, 0, ',', '.') }}
                            </span>
                        </div>
                        <div class="mt-2 pt-2 border-t border-gray-100 text-xs text-gray-400">
                            <i class="fas fa-clock mr-1"></i>
                            Selesai {{ \Carbon\Carbon::parse($schedule->waktu_selesai)->format('H:i') }}
                        </div>
                    </button>
                    @endforeach
                </div>
                @else
                <div class="bg-gray-50 rounded-xl p-8 text-center border border-dashed border-gray-200">
                    <i class="fas fa-calendar-times text-3xl text-gray-300 mb-2"></i>
                    <p class="text-gray-400 text-sm">Tidak ada jadwal tayang pada hari ini</p>
                </div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- MODAL: Berapa Tiket? --}}
<div id="ticketModal" class="fixed inset-0 z-50 hidden items-center justify-center px-4"
     style="background: rgba(0,0,0,0.5); backdrop-filter: blur(4px);">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm overflow-hidden animate-modal">

        {{-- Header Modal --}}
        <div class="flex items-center justify-between px-5 pt-5 pb-4 border-b border-gray-100">
            <h3 class="text-lg font-bold text-gray-900">Berapa tiket yang dibutuhkan?</h3>
            <button onclick="closeTicketModal()" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-100 transition text-gray-500">
                <i class="fas fa-times"></i>
            </button>
        </div>

        {{-- Info Film --}}
        <div class="px-5 py-4 flex items-center gap-4 bg-gray-50 border-b border-gray-100">
            @if($film->poster)
            <img src="{{ $film->poster }}" alt="{{ $film->judul }}"
                 class="w-14 h-20 object-cover rounded-lg shadow">
            @else
            <div class="w-14 h-20 bg-gray-200 rounded-lg flex items-center justify-center">
                <i class="fas fa-film text-gray-400 text-xl"></i>
            </div>
            @endif
            <div>
                <p class="font-bold text-gray-900 text-sm">{{ $film->judul }}</p>
                <p id="modalTanggal" class="text-xs text-gray-500 mt-0.5"></p>
                <div class="mt-2 space-y-1">
                    <p class="text-xs text-orange-500 flex items-center gap-1">
                        <i class="fas fa-circle text-[6px]"></i>
                        Tiket yang sudah dibeli tidak bisa di-refund atau ditukar
                    </p>
                    <p class="text-xs text-orange-500 flex items-center gap-1">
                        <i class="fas fa-circle text-[6px]"></i>
                        Wajib membeli tiket untuk anak berumur 2 tahun ke atas
                    </p>
                </div>
            </div>
        </div>

        {{-- Jam Tayang --}}
        <div class="px-5 py-3 border-b border-gray-100">
            <div class="bg-gray-100 rounded-lg px-4 py-2.5 inline-block">
                <span id="modalJam" class="font-bold text-gray-800 text-lg"></span>
            </div>
        </div>

        {{-- Jumlah Tiket --}}
        <div class="px-5 py-5">
            <div class="flex items-center justify-center gap-6">
                <button onclick="changeQty(-1)"
                        class="w-10 h-10 rounded-full border-2 border-gray-300 flex items-center justify-center hover:border-red-500 hover:text-red-600 transition text-xl font-bold text-gray-600">
                    −
                </button>
                <span id="qtyDisplay" class="text-3xl font-black text-gray-900 w-8 text-center">1</span>
                <button onclick="changeQty(1)"
                        class="w-10 h-10 rounded-full border-2 border-gray-300 flex items-center justify-center hover:border-red-500 hover:text-red-600 transition text-xl font-bold text-gray-600">
                    +
                </button>
            </div>
            <p class="text-center text-sm text-gray-400 mt-2">
                Harga: <span id="modalHarga" class="font-semibold text-gray-700"></span> / tiket
            </p>
        </div>

        {{-- Tombol Lanjut --}}
        <div class="px-5 pb-5">
            <a id="modalLanjutBtn" href="#"
               class="block w-full bg-gray-900 hover:bg-gray-700 text-white text-center font-bold py-3.5 rounded-xl transition text-base">
                Lanjutkan
            </a>
        </div>
    </div>
</div>

<style>
@keyframes modalSlideUp {
    from { opacity: 0; transform: translateY(30px) scale(0.97); }
    to   { opacity: 1; transform: translateY(0) scale(1); }
}
.animate-modal { animation: modalSlideUp 0.25s ease-out both; }
</style>

<script>
let currentScheduleId = null;
let currentHarga      = 0;
let currentQty        = 1;
const maxQty          = 8;

function openTicketModal(scheduleId, jam, studio, harga, tanggal) {
    currentScheduleId = scheduleId;
    currentHarga      = harga;
    currentQty        = 1;

    document.getElementById('modalJam').textContent    = jam;
    document.getElementById('modalTanggal').textContent = tanggal;
    document.getElementById('modalHarga').textContent  = 'Rp ' + harga.toLocaleString('id-ID');
    document.getElementById('qtyDisplay').textContent  = 1;
    updateLanjutBtn();

    const modal = document.getElementById('ticketModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeTicketModal() {
    const modal = document.getElementById('ticketModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

function changeQty(delta) {
    currentQty = Math.min(maxQty, Math.max(1, currentQty + delta));
    document.getElementById('qtyDisplay').textContent = currentQty;
    updateLanjutBtn();
}

function updateLanjutBtn() {
    const btn  = document.getElementById('modalLanjutBtn');
    // Kirim ke halaman select-seats dengan query param jumlah_tiket
    btn.href   = `/booking/schedule/${currentScheduleId}/seats?qty=${currentQty}`;
}

// Tutup modal klik backdrop
document.getElementById('ticketModal').addEventListener('click', function(e) {
    if (e.target === this) closeTicketModal();
});

// Scroll ke hari ini
document.addEventListener('DOMContentLoaded', function() {
    const today = '{{ \Carbon\Carbon::today()->format('Ymd') }}';
    const el = document.getElementById('scheduleDate' + today);
    if (el) setTimeout(() => el.scrollIntoView({ behavior: 'smooth', block: 'start' }), 300);
});

function scrollToDate(dateId) {
    const el = document.getElementById('scheduleDate' + dateId);
    if (el) el.scrollIntoView({ behavior: 'smooth', block: 'start' });
}
</script>
@endsection