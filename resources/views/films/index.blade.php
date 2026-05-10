@extends('layouts.app')

@section('title', 'Daftar Film - CTIX.ID')

@section('content')
{{-- HERO --}}
<section class="relative pt-20 pb-12 overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-red-50 via-white to-gray-50"></div>
    <div class="relative container mx-auto px-4 text-center">
        <h1 class="text-4xl md:text-6xl font-bold mb-4">
            <span class="text-gray-900">Daftar</span>
            <span class="bg-gradient-to-r from-red-600 to-orange-500 bg-clip-text text-transparent"> Film</span>
        </h1>
        <p class="text-gray-600 text-lg max-w-2xl mx-auto">
            Temukan film terbaik dari berbagai genre dan nikmati pengalaman menonton terbaik.
        </p>
    </div>
</section>

{{-- FILTER --}}
<section class="container mx-auto px-4 py-6">
    <div class="bg-white rounded-2xl p-5 border border-gray-200 shadow-sm">
        <form method="GET" action="{{ route('films.index') }}" id="filterForm">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                {{-- Search --}}
                <div class="md:col-span-2 relative">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Cari film atau genre..."
                           class="w-full border border-gray-300 rounded-xl py-2.5 pl-11 pr-4 text-sm focus:outline-none focus:border-red-500 transition">
                </div>

                {{-- Sort --}}
                <div>
                    <select name="sort"
                            class="w-full border border-gray-300 rounded-xl py-2.5 px-4 text-sm focus:outline-none focus:border-red-500 transition">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="title"  {{ request('sort') == 'title'  ? 'selected' : '' }}>Judul A-Z</option>
                    </select>
                </div>

                {{-- Submit --}}
                <div>
                    <button type="submit"
                            class="w-full bg-red-600 hover:bg-red-700 text-white rounded-xl py-2.5 font-semibold text-sm transition flex items-center justify-center gap-2">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                </div>
            </div>
        </form>

        @if(request()->anyFilled(['search', 'sort']))
        <div class="mt-3 text-center">
            <a href="{{ route('films.index') }}" class="text-gray-500 hover:text-red-600 text-sm transition">
                <i class="fas fa-times-circle mr-1"></i> Reset filter
            </a>
        </div>
        @endif
    </div>
</section>

{{-- FILM GRID --}}
<section class="container mx-auto px-4 py-6 pb-16">

    @if(count($films) > 0)
    <div class="flex justify-between items-center mb-5">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Sedang Tayang</h2>
            <p class="text-gray-500 text-sm mt-0.5">{{ count($films) }} film tersedia</p>
        </div>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-5">
        @foreach($films as $film)
        @php
            $slug = \Illuminate\Support\Str::slug($film->judul);
        @endphp
        <div class="group cursor-pointer" onclick="window.location='{{ route('films.show', $slug) }}'">

            {{-- Poster --}}
            <div class="relative overflow-hidden rounded-xl mb-3 shadow-sm">
                @if($film->poster)
                    <img src="{{ $film->poster }}"
                         alt="{{ $film->judul }}"
                         class="w-full h-64 object-cover group-hover:scale-105 transition duration-500"
                         onerror="this.parentElement.innerHTML='<div class=\'w-full h-64 bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center\'><i class=\'fas fa-film text-5xl text-gray-400\'></i></div>'">
                @else
                    <div class="w-full h-64 bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center">
                        <i class="fas fa-film text-5xl text-gray-400"></i>
                    </div>
                @endif

                {{-- Overlay hover --}}
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition duration-300"></div>

                {{-- Tombol pesan --}}
                <div class="absolute bottom-0 left-0 right-0 p-3 transform translate-y-full group-hover:translate-y-0 transition duration-300">
                    <a href="{{ route('films.show', $slug) }}"
                       class="block w-full bg-red-600 hover:bg-red-700 text-white text-xs font-bold py-2 rounded-lg text-center transition"
                       onclick="event.stopPropagation()">
                        <i class="fas fa-ticket-alt mr-1"></i> Pesan Tiket
                    </a>
                </div>

                {{-- Badge genre --}}
                <div class="absolute top-2 left-2">
                    <span class="bg-black/60 backdrop-blur-sm text-white text-xs px-2 py-0.5 rounded-full">
                        {{ explode(',', $film->genre)[0] }}
                    </span>
                </div>
            </div>

            {{-- Info --}}
            <div class="px-0.5">
                <h3 class="text-gray-900 font-semibold text-sm group-hover:text-red-600 transition line-clamp-1">
                    {{ $film->judul }}
                </h3>
                <p class="text-gray-400 text-xs mt-0.5">
                    {{ $film->genre }} · {{ $film->durasi }} menit
                </p>
                <p class="text-gray-400 text-xs mt-0.5 line-clamp-2">{{ $film->sinopsis }}</p>
            </div>
        </div>
        @endforeach
    </div>

    @else
    <div class="text-center py-20">
        <i class="fas fa-film text-7xl text-gray-300 mb-4"></i>
        <h3 class="text-2xl font-bold text-gray-900 mb-2">Tidak ada film ditemukan</h3>
        <p class="text-gray-500 mb-6">Coba ubah kata kunci pencarian</p>
        <a href="{{ route('films.index') }}"
           class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl font-semibold transition inline-flex items-center gap-2">
            <i class="fas fa-sync-alt"></i> Reset Filter
        </a>
    </div>
    @endif
</section>

<script>
document.querySelectorAll('#filterForm select').forEach(select => {
    select.addEventListener('change', () => document.getElementById('filterForm').submit());
});
</script>

<style>
.line-clamp-1 { display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden; }
.line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
</style>
@endsection