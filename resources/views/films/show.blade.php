@extends('layouts.app')
@section('title', $film->judul . ' - CTIX.ID')
@section('content')

@php
    $posterPath = $film->poster;
    $backdropPath = $film->backdrop;

    $posterIsUrl = $posterPath && \Illuminate\Support\Str::startsWith($posterPath, ['http://', 'https://']);
    $backdropIsUrl = $backdropPath && \Illuminate\Support\Str::startsWith($backdropPath, ['http://', 'https://']);

    $posterExists = $posterPath && ($posterIsUrl || file_exists(public_path(ltrim($posterPath, '/'))));
    $backdropExists = $backdropPath && ($backdropIsUrl || file_exists(public_path(ltrim($backdropPath, '/'))));

    $posterUrl = $posterExists ? $posterPath : null;
    $backdropUrl = $backdropExists ? $backdropPath : '/bd_martian.jpg';
@endphp

{{-- HERO dengan Backdrop --}}
<section class="relative pt-16 min-h-[65vh] flex items-end">
    <div class="absolute inset-0 bg-cover bg-center bg-no-repeat"
        style="background-image: url('{{ $backdropUrl }}');">
        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/70 to-gray-900/30"></div>
    </div>

    <div class="relative container mx-auto px-4 py-12">
        <div class="flex flex-col md:flex-row gap-8 items-end">

            {{-- Poster --}}
            <div class="w-44 md:w-56 flex-shrink-0 rounded-xl overflow-hidden shadow-2xl">
                @if($posterUrl)
                    <img 
                        src="{{ $posterUrl }}" 
                        alt="{{ $film->judul }}" 
                        class="w-full h-72 object-cover"
                        onerror="this.outerHTML='<div class=\'w-full h-72 bg-gray-700 flex items-center justify-center\'><i class=\'fas fa-film text-6xl text-gray-500\'></i></div>'"
                    >
                @else
                    <div class="w-full h-72 bg-gray-700 flex items-center justify-center">
                        <i class="fas fa-film text-6xl text-gray-500"></i>
                    </div>
                @endif
            </div>

            {{-- Info --}}
            <div class="flex-1">
                {{-- Status Badge --}}
                @if(isset($film->status))
                <div class="mb-3">
                    @if($film->status === 'now_showing')
                    <span class="bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full">
                        <i class="fas fa-circle text-[8px] mr-1 animate-pulse"></i> Sedang Tayang
                    </span>
                    @else
                    <span class="bg-orange-500 text-white text-xs font-bold px-3 py-1 rounded-full">
                        <i class="fas fa-clock text-xs mr-1"></i> Coming Soon
                    </span>
                    @endif
                </div>
                @endif

                <h1 class="text-4xl md:text-5xl font-black text-white mb-3">{{ $film->judul }}</h1>

                {{-- Meta --}}
                <div class="flex flex-wrap items-center gap-3 mb-4">
                    @if(isset($film->rating) && $film->rating > 0)
                    <div class="flex items-center gap-1.5 bg-black/40 px-3 py-1.5 rounded-full">
                        <div class="flex text-yellow-400 text-sm">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= floor($film->rating))
                                    <i class="fas fa-star"></i>
                                @elseif($i - 0.5 <= $film->rating)
                                    <i class="fas fa-star-half-alt"></i>
                                @else
                                    <i class="far fa-star text-gray-500"></i>
                                @endif
                            @endfor
                        </div>
                        <span class="text-white font-bold text-sm">{{ $film->rating }}</span>
                        @if(isset($film->rating_count) && $film->rating_count > 0)
                        <span class="text-gray-400 text-xs">({{ number_format($film->rating_count/1000, 1) }}k)</span>
                        @endif
                    </div>
                    @endif

                    <span class="text-gray-300 text-sm flex items-center gap-1">
                        <i class="fas fa-clock text-gray-400"></i>
                        {{ $film->durasi }} menit
                    </span>

                    @if(isset($film->age_rating))
                    <span class="bg-red-600/80 text-white text-xs font-bold px-2 py-1 rounded">
                        {{ $film->age_rating }}
                    </span>
                    @endif

                    @if(isset($film->release_date) && $film->release_date)
                    <span class="text-gray-300 text-sm flex items-center gap-1">
                        <i class="fas fa-calendar text-gray-400"></i>
                        @if($film->release_date instanceof \Carbon\Carbon)
                            {{ $film->release_date->format('d F Y') }}
                        @else
                            {{ \Carbon\Carbon::parse($film->release_date)->format('d F Y') }}
                        @endif
                    </span>
                    @endif
                </div>

                <p class="text-gray-300 text-base mb-5 max-w-2xl leading-relaxed">{{ $film->sinopsis }}</p>

                {{-- Tombol Aksi --}}
                <div class="flex flex-wrap gap-3">
                    @if(isset($film->status) && $film->status === 'now_showing')
                    <a href="{{ route('booking.select-studio', $film->id) }}"
                       class="bg-red-600 hover:bg-red-700 text-white px-8 py-3 rounded-xl font-bold transition flex items-center gap-2 shadow-lg">
                        <i class="fas fa-ticket-alt"></i> Pesan Tiket
                    </a>
                    @endif

                    @if(isset($film->trailer) && $film->trailer)
                    <button onclick="openTrailer('{{ $film->trailer }}')"
                            class="bg-white/10 hover:bg-white/20 border border-white/30 text-white px-8 py-3 rounded-xl font-bold transition flex items-center gap-2 backdrop-blur-sm">
                        <i class="fas fa-play"></i> Trailer
                    </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

{{-- DETAIL SECTION --}}
<section class="bg-gray-900 min-h-screen pb-16">
    <div class="container mx-auto px-4 py-10">
        <div class="grid md:grid-cols-3 gap-8">

            {{-- Kiri: Detail --}}
            <div class="md:col-span-2 space-y-6">

                {{-- Sinopsis --}}
                <div class="bg-gray-800/50 rounded-2xl p-6 border border-gray-700">
                    <h2 class="text-xl font-bold text-white mb-3 flex items-center gap-2">
                        <i class="fas fa-align-left text-red-500 text-base"></i> Sinopsis
                    </h2>
                    <p class="text-gray-300 leading-relaxed">{{ $film->sinopsis }}</p>
                </div>

                {{-- Detail Film --}}
                <div class="bg-gray-800/50 rounded-2xl p-6 border border-gray-700">
                    <h2 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
                        <i class="fas fa-info-circle text-red-500 text-base"></i> Detail Film
                    </h2>
                    <div class="grid grid-cols-2 gap-4">
                        @if(isset($film->director) && $film->director)
                        <div>
                            <p class="text-gray-400 text-xs uppercase tracking-wider mb-1">Sutradara</p>
                            <p class="text-white font-semibold">{{ $film->director }}</p>
                        </div>
                        @endif
                        <div>
                            <p class="text-gray-400 text-xs uppercase tracking-wider mb-1">Genre</p>
                            <p class="text-white font-semibold">{{ $film->genre }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400 text-xs uppercase tracking-wider mb-1">Durasi</p>
                            <p class="text-white font-semibold">{{ $film->durasi }} menit</p>
                        </div>
                        @if(isset($film->release_date) && $film->release_date)
                        <div>
                            <p class="text-gray-400 text-xs uppercase tracking-wider mb-1">Tanggal Rilis</p>
                            <p class="text-white font-semibold">
                                @if($film->release_date instanceof \Carbon\Carbon)
                                    {{ $film->release_date->format('d F Y') }}
                                @else
                                    {{ \Carbon\Carbon::parse($film->release_date)->format('d F Y') }}
                                @endif
                            </p>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Pemeran --}}
                @php
                    $castData = [];
                    $rawCast = \DB::table('films')->where('id', $film->id)->value('cast');
                    if ($rawCast) {
                        $decoded = json_decode($rawCast, true);
                        if (is_array($decoded)) {
                            $castData = $decoded;
                        }
                    }
                @endphp

                @if(!empty($castData))
                <div class="bg-gray-800/50 rounded-2xl p-6 border border-gray-700">
                    <h2 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
                        <i class="fas fa-users text-red-500 text-base"></i> Pemeran
                    </h2>
                    <div class="flex flex-wrap gap-2">
                        @foreach($castData as $actor)
                        <span class="bg-gray-700 text-gray-300 px-3 py-1.5 rounded-full text-sm">
                            {{ $actor }}
                        </span>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Trailer --}}
                @if(isset($film->trailer) && $film->trailer)
                <div class="bg-gray-800/50 rounded-2xl p-6 border border-gray-700">
                    <h2 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
                        <i class="fas fa-play-circle text-red-500 text-base"></i> Trailer
                    </h2>
                    <div class="relative rounded-xl overflow-hidden" style="padding-bottom: 56.25%;">
                        <iframe src="{{ $film->trailer }}"
                                class="absolute inset-0 w-full h-full"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                        </iframe>
                    </div>
                </div>
                @endif
            </div>

            {{-- Kanan: Rekomendasi --}}
            <div>
                <h2 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
                    <i class="fas fa-film text-red-500 text-base"></i> Rekomendasi
                </h2>
                <div class="space-y-3">
                    @forelse($recommendations as $rec)
                    @php $recSlug = \Illuminate\Support\Str::slug($rec->judul); @endphp
                    <div class="bg-gray-800/50 rounded-xl overflow-hidden border border-gray-700 flex gap-3 cursor-pointer hover:border-red-500 transition group"
                         onclick="window.location='{{ route('films.show', $recSlug) }}'">
                        @if($rec->poster)
                        <img src="{{ $rec->poster }}" alt="{{ $rec->judul }}"
                             class="w-20 h-28 object-cover flex-shrink-0">
                        @else
                        <div class="w-20 h-28 bg-gray-700 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-film text-gray-500"></i>
                        </div>
                        @endif
                        <div class="py-3 pr-3 flex-1 min-w-0">
                            <h3 class="font-bold text-white text-sm group-hover:text-red-400 transition line-clamp-2">{{ $rec->judul }}</h3>
                            <p class="text-gray-400 text-xs mt-1">{{ $rec->genre }}</p>
                            @if($rec->rating > 0)
                            <div class="flex items-center gap-1 mt-1.5">
                                <i class="fas fa-star text-yellow-400 text-xs"></i>
                                <span class="text-white text-xs font-bold">{{ $rec->rating }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                    @empty
                    <p class="text-gray-500 text-sm">Tidak ada rekomendasi.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Modal Trailer --}}
<div id="trailerModal"
     class="fixed inset-0 z-50 hidden items-center justify-center px-4"
     style="background: rgba(0,0,0,0.85);">
    <div class="bg-gray-900 rounded-2xl overflow-hidden w-full max-w-3xl shadow-2xl">
        <div class="flex items-center justify-between px-5 py-3 border-b border-gray-700">
            <h3 class="text-white font-bold">Trailer - {{ $film->judul }}</h3>
            <button onclick="closeTrailer()" class="text-gray-400 hover:text-white transition">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <div class="relative" style="padding-bottom: 56.25%;">
            <iframe id="trailerFrame" src="" class="absolute inset-0 w-full h-full"
                    frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
        </div>
    </div>
</div>

<script>
function openTrailer(url) {
    document.getElementById('trailerFrame').src = url + '?autoplay=1';
    const modal = document.getElementById('trailerModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeTrailer() {
    document.getElementById('trailerFrame').src = '';
    const modal = document.getElementById('trailerModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

document.getElementById('trailerModal').addEventListener('click', function(e) {
    if (e.target === this) closeTrailer();
});
</script>

<style>
.line-clamp-1 { display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden; }
.line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
</style>
@endsection