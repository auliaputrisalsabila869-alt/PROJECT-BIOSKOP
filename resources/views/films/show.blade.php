@extends('layouts.app')

@section('title', $film->judul . ' - CinemaXXI')

@section('content')
<!-- HERO dengan Backdrop -->
<section class="relative pt-16 min-h-[60vh] flex items-end">
    <div class="absolute inset-0 bg-cover bg-center bg-no-repeat"
        style="background-image: url('{{ $film->backdrop ?? 'https://via.placeholder.com/1920x1080' }}');">
        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/80 to-transparent"></div>
    </div>
    
    <div class="relative container mx-auto px-4 py-12">
        <div class="flex flex-col md:flex-row gap-8 items-end">
            <div class="w-48 md:w-64 rounded-xl overflow-hidden shadow-2xl">
                @if($film->poster)
                    <img src="{{ $film->poster }}" alt="{{ $film->judul }}" class="w-full">
                @else
                    <div class="w-full h-72 bg-gradient-to-br from-gray-700 to-gray-800 flex items-center justify-center">
                        <i class="fas fa-film text-6xl text-gray-500"></i>
                    </div>
                @endif
            </div>
            <div class="flex-1">
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-2">{{ $film->judul }}</h1>
                <div class="flex flex-wrap items-center gap-3 mb-4">
                    <div class="flex items-center gap-1">
                        <div class="flex text-yellow-400">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= floor($film->rating))
                                    <i class="fas fa-star"></i>
                                @elseif($i - 0.5 <= $film->rating)
                                    <i class="fas fa-star-half-alt"></i>
                                @else
                                    <i class="far fa-star"></i>
                                @endif
                            @endfor
                        </div>
                        <span class="text-white ml-2">{{ $film->rating }}</span>
                        <span class="text-gray-400">({{ number_format($film->rating_count / 1000, 1) }}k ulasan)</span>
                    </div>
                    <span class="text-gray-500">|</span>
                    <span class="text-gray-300">{{ $film->duration }}</span>
                    <span class="text-gray-500">|</span>
                    <span class="bg-red-600/20 text-red-400 px-2 py-1 rounded text-sm">{{ $film->age_rating }}</span>
                </div>
                <p class="text-gray-300 text-lg mb-4 line-clamp-3">{{ $film->synopsis }}</p>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('booking.select-studio', $film->id) }}" 
   class="bg-red-600 hover:bg-red-700 text-white px-8 py-3 rounded-xl font-semibold transition flex items-center gap-2">
    <i class="fas fa-ticket-alt"></i> Pesan Tiket
</a>
                    @if($film->trailer)
                    <button onclick="openTrailer('{{ $film->trailer }}')" class="bg-gray-700 hover:bg-gray-600 text-white px-8 py-3 rounded-xl font-semibold transition flex items-center gap-2">
                        <i class="fas fa-play"></i> Trailer
                    </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<!-- INFO DETAIL & JADWAL -->
<section class="bg-gray-900 min-h-screen pb-12">
    <div class="container mx-auto px-4 py-12">
        <div class="grid md:grid-cols-3 gap-8">
        <!-- Info Film -->
        <div class="md:col-span-2 space-y-6">
            <div class="bg-gray-800/30 rounded-2xl p-6 border border-gray-700">
                <h2 class="text-2xl font-bold text-white mb-4">Sinopsis</h2>
                <p class="text-gray-300 leading-relaxed">{{ $film->synopsis }}</p>
            </div>
            
            <div class="bg-gray-800/30 rounded-2xl p-6 border border-gray-700">
                <h2 class="text-2xl font-bold text-white mb-4">Detail Film</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-gray-400 text-sm">Sutradara</p>
                        <p class="text-white font-semibold">{{ $film->director }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-sm">Genre</p>
                        <p class="text-white font-semibold">{{ $film->genre }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-sm">Durasi</p>
                        <p class="text-white font-semibold">{{ $film->duration }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-sm">Tanggal Rilis</p>
                        <p class="text-white font-semibold">{{ \Carbon\Carbon::parse($film->release_date)->format('d F Y') }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-gray-800/30 rounded-2xl p-6 border border-gray-700">
                <h2 class="text-2xl font-bold text-white mb-4">Pemeran</h2>
                <div class="flex flex-wrap gap-2">
                    @foreach($film->cast ?? [] as $actor)
                    <span class="bg-gray-700 px-3 py-1 rounded-full text-sm text-gray-300">
                    {{ $actor }}
                    </span>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Rekomendasi Film -->
        <div class="space-y-4">
            <h2 class="text-2xl font-bold text-white">Rekomendasi</h2>
            @if(isset($recommendations) && count($recommendations) > 0)
                @foreach($recommendations as $rec)
                    <div class="bg-gray-800/50 rounded-xl overflow-hidden border border-gray-700 flex gap-4 cursor-pointer hover:border-red-500 transition" onclick="window.location='{{ route('films.show', $rec->slug) }}'">
                        @if($rec->poster)
                            <img src="{{ $rec->poster }}" alt="{{ $rec->judul }}" class="w-24 h-32 object-cover">
                        @else
                            <div class="w-24 h-32 bg-gray-700 flex items-center justify-center">
                                <i class="fas fa-film text-2xl text-gray-500"></i>
                            </div>
                        @endif
                        <div class="py-3 pr-3 flex-1">
                            <h3 class="font-bold text-white line-clamp-1">{{ $rec->judul }}</h3>
                            <p class="text-xs text-gray-400 mt-1">{{ $rec->genre }}</p>
                            <div class="flex items-center gap-1 mt-2">
                                <i class="fas fa-star text-yellow-400 text-xs"></i>
                                <span class="text-sm font-semibold text-white">{{ $rec->rating }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="text-gray-400">Belum ada rekomendasi.</p>
            @endif
        </div>
        </div>
    </div>
</section>
@endsection