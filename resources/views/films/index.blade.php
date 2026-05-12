@extends('layouts.app')
@section('title', 'Daftar Film - CTIX.ID')
@section('content')

{{-- HERO --}}
<section class="relative pt-20 pb-10 bg-gradient-to-br from-red-50 via-white to-gray-50">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-4xl md:text-5xl font-black mb-3">
            <span class="text-gray-900">Jadwal</span>
            <span class="bg-gradient-to-r from-red-600 to-orange-500 bg-clip-text text-transparent"> & Film</span>
        </h1>
        <p class="text-gray-500 max-w-xl mx-auto">Film yang sedang tayang dan akan segera hadir di bioskop CTIX.ID</p>
    </div>
</section>

{{-- SEARCH & FILTER --}}
<section class="container mx-auto px-4 py-6">
    <form method="GET" action="{{ route('films.index') }}" id="filterForm">
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-4 flex flex-wrap gap-3 items-center">

            {{-- Search --}}
            <div class="relative flex-1 min-w-64">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                <input type="text" name="search" id="searchInput" value="{{ $search }}"
                       placeholder="Cari judul film, genre, sutradara..."
                       class="w-full border border-gray-200 rounded-xl py-2.5 pl-10 pr-4 text-sm focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-100 transition">
            </div>

            {{-- Sort --}}
            <select name="sort" onchange="this.form.submit()"
                    class="border border-gray-200 rounded-xl py-2.5 px-4 text-sm focus:outline-none focus:border-red-500 transition">
                <option value="newest" {{ $sort == 'newest' ? 'selected' : '' }}>Terbaru</option>
                <option value="rating" {{ $sort == 'rating' ? 'selected' : '' }}>Rating Tertinggi</option>
                <option value="title"  {{ $sort == 'title'  ? 'selected' : '' }}>Judul A-Z</option>
            </select>

            {{-- Submit --}}
            <button type="submit"
                    class="bg-red-600 hover:bg-red-700 text-white px-6 py-2.5 rounded-xl text-sm font-semibold transition flex items-center gap-2">
                <i class="fas fa-search"></i> Cari
            </button>

            @if($search)
            <a href="{{ route('films.index') }}"
               class="text-gray-500 hover:text-red-600 text-sm flex items-center gap-1 transition">
                <i class="fas fa-times-circle"></i> Reset
            </a>
            @endif
        </div>

        {{-- Hasil pencarian --}}
        @if($search)
        <div class="mt-3 px-1">
            <p class="text-sm text-gray-500">
                Hasil pencarian untuk <span class="font-bold text-gray-900">"{{ $search }}"</span>:
                {{ $nowShowing->count() + $comingSoon->count() }} film ditemukan
            </p>
        </div>
        @endif
    </form>
</section>

{{-- NOW SHOWING --}}
<section class="container mx-auto px-4 pb-10">
    <div class="flex items-center gap-3 mb-5">
        <div class="w-1 h-8 bg-red-600 rounded-full"></div>
        <div>
            <h2 class="text-2xl font-black text-gray-900">Sedang Tayang</h2>
            <p class="text-gray-400 text-sm">{{ $nowShowing->count() }} film tersedia</p>
        </div>
    </div>

    @if($nowShowing->count() > 0)
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-5">
        @foreach($nowShowing as $film)
        @php $slug = \Illuminate\Support\Str::slug($film->judul); @endphp
        <div class="group cursor-pointer" onclick="window.location='{{ route('films.show', $slug) }}'">

            {{-- Poster --}}
            <div class="relative overflow-hidden rounded-xl mb-3 shadow-sm aspect-[2/3]">
                @if($film->poster)
                <img src="{{ $film->poster }}" alt="{{ $film->judul }}"
                     class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                     onerror="this.parentElement.innerHTML='<div class=\'w-full h-full bg-gradient-to-br from-gray-700 to-gray-800 flex items-center justify-center\'><i class=\'fas fa-film text-5xl text-gray-500\'></i></div>'">
                @else
                <div class="w-full h-full bg-gradient-to-br from-gray-700 to-gray-800 flex items-center justify-center">
                    <i class="fas fa-film text-5xl text-gray-500"></i>
                </div>
                @endif

                {{-- Overlay --}}
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition duration-300"></div>

                {{-- Tombol Pesan --}}
                <div class="absolute bottom-0 left-0 right-0 p-3 translate-y-full group-hover:translate-y-0 transition duration-300">
                    <a href="{{ route('films.show', $slug) }}"
                       class="block w-full bg-red-600 hover:bg-red-700 text-white text-xs font-bold py-2 rounded-lg text-center"
                       onclick="event.stopPropagation()">
                        <i class="fas fa-ticket-alt mr-1"></i> Pesan Tiket
                    </a>
                </div>

                {{-- Age Rating --}}
                @if($film->age_rating)
                <div class="absolute top-2 right-2 bg-red-600 text-white text-xs font-bold px-1.5 py-0.5 rounded">
                    {{ $film->age_rating }}
                </div>
                @endif

                {{-- Rating --}}
                @if($film->rating > 0)
                <div class="absolute bottom-2 left-2 bg-black/70 backdrop-blur-sm px-2 py-1 rounded-lg flex items-center gap-1">
                    <i class="fas fa-star text-yellow-400 text-xs"></i>
                    <span class="text-white text-xs font-bold">{{ $film->rating }}</span>
                </div>
                @endif
            </div>

            {{-- Info --}}
            <h3 class="text-gray-900 font-bold text-sm group-hover:text-red-600 transition line-clamp-1">
                {{ $film->judul }}
            </h3>

            {{-- Bintang --}}
            <div class="flex items-center gap-1 mt-0.5">
                @for($i = 1; $i <= 5; $i++)
                    @if($i <= floor($film->rating))
                        <i class="fas fa-star text-yellow-400 text-xs"></i>
                    @elseif($i - 0.5 <= $film->rating)
                        <i class="fas fa-star-half-alt text-yellow-400 text-xs"></i>
                    @else
                        <i class="far fa-star text-gray-300 text-xs"></i>
                    @endif
                @endfor
                @if($film->rating_count > 0)
                <span class="text-gray-400 text-xs ml-1">({{ number_format($film->rating_count/1000, 1) }}k)</span>
                @endif
            </div>

            <p class="text-gray-400 text-xs mt-0.5">{{ $film->genre }} · {{ $film->durasi }} menit</p>
        </div>
        @endforeach
    </div>
    @else
    <div class="text-center py-12 bg-white rounded-2xl border border-dashed border-gray-200">
        <i class="fas fa-film text-5xl text-gray-200 mb-3 block"></i>
        <p class="text-gray-400 font-medium">Tidak ada film yang sedang tayang</p>
        @if($search)
        <p class="text-gray-400 text-sm mt-1">untuk pencarian "{{ $search }}"</p>
        @endif
    </div>
    @endif
</section>

{{-- COMING SOON --}}
<section class="container mx-auto px-4 pb-16">
    <div class="flex items-center gap-3 mb-5">
        <div class="w-1 h-8 bg-orange-500 rounded-full"></div>
        <div>
            <h2 class="text-2xl font-black text-gray-900">Segera Hadir</h2>
            <p class="text-gray-400 text-sm">Film yang akan segera tayang</p>
        </div>
    </div>

    @if($comingSoon->count() > 0)
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-5">
        @foreach($comingSoon as $film)
        @php $slug = \Illuminate\Support\Str::slug($film->judul); @endphp
        <div class="group cursor-pointer" onclick="window.location='{{ route('films.show', $slug) }}'">
            <div class="relative overflow-hidden rounded-xl mb-3 shadow-sm aspect-[2/3]">
                @if($film->poster)
                <img src="{{ $film->poster }}" alt="{{ $film->judul }}"
                     class="w-full h-full object-cover group-hover:scale-105 transition duration-500 filter brightness-75">
                @else
                <div class="w-full h-full bg-gradient-to-br from-gray-600 to-gray-800 flex items-center justify-center">
                    <i class="fas fa-film text-5xl text-gray-500"></i>
                </div>
                @endif

                {{-- Coming Soon Badge --}}
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="bg-orange-500 text-white text-xs font-black px-3 py-1.5 rounded-full uppercase tracking-wider">
                        Coming Soon
                    </div>
                </div>

                {{-- Tanggal Rilis --}}
                @if($film->release_date)
                <div class="absolute bottom-2 left-0 right-0 text-center">
                    <span class="bg-black/70 text-white text-xs px-2 py-1 rounded-full">
                        {{ $film->release_date->format('d M Y') }}
                    </span>
                </div>
                @endif
            </div>

            <h3 class="text-gray-900 font-bold text-sm group-hover:text-orange-500 transition line-clamp-1">
                {{ $film->judul }}
            </h3>
            <p class="text-gray-400 text-xs mt-0.5">{{ $film->genre }}</p>
        </div>
        @endforeach
    </div>
    @else
    <div class="text-center py-12 bg-white rounded-2xl border border-dashed border-gray-200">
        <i class="fas fa-clock text-5xl text-gray-200 mb-3 block"></i>
        <p class="text-gray-400 font-medium">Belum ada film coming soon</p>
    </div>
    @endif
</section>

<style>
.line-clamp-1 { display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden; }
.aspect-\[2\/3\] { aspect-ratio: 2/3; }
</style>
@endsection