@extends('layouts.app')

@section('title', 'Pilih Jadwal - ' . $film->judul)

@section('content')
<section class="min-h-screen pt-24 pb-12 bg-gradient-to-b from-gray-50 to-white">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('films.show', $film->slug) }}" class="text-red-600 hover:text-red-700 mb-4 inline-flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> Kembali ke Detail Film
            </a>
            <h1 class="text-3xl font-bold text-gray-900 mt-2">Pilih Jadwal Tayang</h1>
            <p class="text-gray-600">{{ $film->judul }}</p>
        </div>
        
        <!-- Week Calendar -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden mb-8">
            <div class="grid grid-cols-7 gap-px bg-gray-200">
                @foreach($dates as $date)
                <div class="bg-white p-4 text-center {{ $date->isToday() ? 'bg-red-50' : '' }}" id="dateTab{{ $date->format('Ymd') }}" onclick="scrollToDate('{{ $date->format('Y-m-d') }}')">
                    <p class="text-sm text-gray-500">{{ $date->translatedFormat('D') }}</p>
                    <p class="text-2xl font-bold {{ $date->isToday() ? 'text-red-600' : 'text-gray-800' }}">{{ $date->format('d') }}</p>
                    <p class="text-xs text-gray-400">{{ $date->translatedFormat('M') }}</p>
                </div>
                @endforeach
            </div>
        </div>
        
        <!-- Schedules by Date -->
        <div class="space-y-8">
            @foreach($dates as $date)
            <div id="scheduleDate{{ $date->format('Ymd') }}" class="scroll-mt-24">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-calendar-day text-red-600"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">{{ $date->translatedFormat('l') }}</h2>
                        <p class="text-gray-500 text-sm">{{ $date->translatedFormat('d F Y') }}</p>
                    </div>
                </div>
                
                @if(isset($schedulesByDate[$date->format('Y-m-d')]) && count($schedulesByDate[$date->format('Y-m-d')]) > 0)
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($schedulesByDate[$date->format('Y-m-d')] as $schedule)
                    <a href="{{ route('booking.select-seats', $schedule->id) }}" 
                       class="bg-white border-2 border-gray-200 rounded-xl p-4 hover:border-red-500 hover:shadow-lg transition group">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-2xl font-bold text-gray-800 group-hover:text-red-600">
                                {{ Carbon\Carbon::parse($schedule->waktu_mulai)->format('H:i') }}
                            </span>
                            <span class="text-xs bg-gray-100 px-2 py-1 rounded-full">{{ $schedule->studio->nama }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-500">
                                <i class="fas fa-chair mr-1"></i> Kursi tersedia
                            </span>
                            <span class="font-bold text-red-600">
                                Rp {{ number_format($schedule->harga, 0, ',', '.') }}
                            </span>
                        </div>
                        <div class="mt-3">
                            <span class="text-xs text-gray-400">
                                <i class="fas fa-clock mr-1"></i> Durasi: {{ $film->durasi }} menit
                            </span>
                        </div>
                    </a>
                    @endforeach
                </div>
                @else
                <div class="bg-gray-50 rounded-xl p-8 text-center border border-gray-200">
                    <i class="fas fa-clock text-4xl text-gray-400 mb-2"></i>
                    <p class="text-gray-500">Tidak ada jadwal tayang pada hari ini</p>
                </div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</section>

<script>
function scrollToDate(date) {
    const element = document.getElementById('scheduleDate' + date.replace(/-/g, ''));
    if (element) {
        element.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
}
</script>
@endsection