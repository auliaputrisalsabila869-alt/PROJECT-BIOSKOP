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
    <div class="bg-white/70 backdrop-blur-sm rounded-2xl p-5 border border-gray-200 shadow-sm">
        <form method="GET" action="{{ route('films.index') }}" id="filterForm">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="md:col-span-2 relative">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Cari film, genre..."
                           class="w-full border border-gray-300 rounded-xl py-3 pl-11 pr-4 text-gray-900 placeholder-gray-400 focus:outline-none focus:border-red-600 transition">
                </div>
                <div>
                    <select name="sort" class="w-full border border-gray-300 rounded-xl py-3 px-4 text-gray-900 focus:outline-none focus:border-red-600 transition">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Rating Tertinggi</option>
                        <option value="title"  {{ request('sort') == 'title'  ? 'selected' : '' }}>Judul A-Z</option>
                    </select>
                </div>
                <div>
                    <button type="submit"
                            class="w-full bg-red-600 hover:bg-red-700 text-white rounded-xl py-3 font-semibold transition flex items-center justify-center gap-2 shadow-sm">
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
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Sedang Tayang</h2>
            <p class="text-gray-500 text-sm mt-0.5">{{ count($films) }} film tersedia</p>
        </div>
        {{-- View Toggle --}}
        <div class="flex gap-2">
            <button onclick="setView('grid')" id="gridViewBtn"
                    class="p-2 rounded-lg bg-red-600 text-white shadow-sm">
                <i class="fas fa-th-large"></i>
            </button>
            <button onclick="setView('list')" id="listViewBtn"
                    class="p-2 rounded-lg bg-gray-200 text-gray-600 hover:bg-gray-300 transition">
                <i class="fas fa-list"></i>
            </button>
        </div>
    </div>

    {{-- Grid View --}}
    <div id="gridView" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
        @foreach($films as $film)
        @php $slug = \Illuminate\Support\Str::slug($film->judul); @endphp
        <div class="group cursor-pointer" onclick="window.location='{{ route('films.show', $slug) }}'">

            {{-- Poster --}}
            <div class="relative overflow-hidden rounded-xl mb-3 shadow-sm">
                @if($film->poster)
                <img src="{{ $film->poster }}" alt="{{ $film->judul }}"
                     class="w-full h-64 object-cover group-hover:scale-110 transition duration-500"
                     onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'w-full h-64 bg-gradient-to-br from-gray-700 to-gray-800 flex items-center justify-center\'><i class=\'fas fa-film text-6xl text-gray-500\'></i></div>'">
                @else
                <div class="w-full h-64 bg-gradient-to-br from-gray-700 to-gray-800 flex items-center justify-center">
                    <i class="fas fa-film text-6xl text-gray-500"></i>
                </div>
                @endif

                {{-- Overlay --}}
                <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-0 group-hover:opacity-100 transition"></div>

                {{-- Tombol Pesan --}}
                <div class="absolute bottom-0 left-0 right-0 p-3 transform translate-y-full group-hover:translate-y-0 transition duration-300">
                    <a href="{{ route('films.show', $slug) }}"
                       class="block w-full bg-red-600 text-white text-xs font-bold py-2 rounded-lg hover:bg-red-700 text-center"
                       onclick="event.stopPropagation()">
                        <i class="fas fa-ticket-alt mr-1"></i> Pesan Tiket
                    </a>
                </div>

                {{-- Age Rating Badge --}}
                @if($film->age_rating)
                <div class="absolute top-2 right-2 bg-red-600 text-white text-xs font-bold px-2 py-0.5 rounded">
                    {{ $film->age_rating }}
                </div>
                @endif

                {{-- Rating Badge --}}
                @if($film->rating > 0)
                <div class="absolute bottom-2 left-2 bg-black/70 backdrop-blur-sm px-2 py-1 rounded-lg">
                    <div class="flex items-center gap-1">
                        <i class="fas fa-star text-yellow-400 text-xs"></i>
                        <span class="text-white text-xs font-bold">{{ $film->rating }}</span>
                    </div>
                </div>
                @endif
            </div>

            {{-- Info --}}
            <div>
                <h3 class="text-gray-900 font-semibold group-hover:text-red-600 transition line-clamp-1 text-sm">
                    {{ $film->judul }}
                </h3>

                {{-- Bintang --}}
                <div class="flex items-center gap-1.5 mt-1">
                    <div class="flex text-yellow-400 text-xs">
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
                    @if($film->rating_count > 0)
                    <span class="text-gray-500 text-xs">({{ number_format($film->rating_count / 1000, 1) }}k)</span>
                    @endif
                </div>

                <p class="text-gray-500 text-xs mt-0.5">{{ $film->genre }} · {{ $film->durasi }} menit</p>
            </div>
        </div>
        @endforeach
    </div>

    {{-- List View --}}
    <div id="listView" class="hidden space-y-4">
        @foreach($films as $film)
        @php $slug = \Illuminate\Support\Str::slug($film->judul); @endphp
        <div class="group bg-white rounded-xl overflow-hidden border border-gray-200 hover:border-red-500 hover:shadow-lg transition cursor-pointer"
             onclick="window.location='{{ route('films.show', $slug) }}'">
            <div class="flex gap-4 p-4">
                <div class="w-24 h-32 flex-shrink-0">
                    @if($film->poster)
                    <img src="{{ $film->poster }}" alt="{{ $film->judul }}"
                         class="w-full h-full object-cover rounded-lg"
                         onerror="this.onerror=null; this.src=''">
                    @else
                    <div class="w-full h-full bg-gray-200 rounded-lg flex items-center justify-center">
                        <i class="fas fa-film text-2xl text-gray-400"></i>
                    </div>
                    @endif
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-bold text-gray-900 group-hover:text-red-600 transition">{{ $film->judul }}</h3>
                    <div class="flex items-center gap-2 mt-1">
                        <div class="flex text-yellow-400 text-sm">
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
                        @if($film->rating_count > 0)
                        <span class="text-gray-500 text-sm">({{ number_format($film->rating_count / 1000, 1) }}k ulasan)</span>
                        @endif
                        <span class="text-gray-300">·</span>
                        <span class="text-gray-500 text-sm">{{ $film->genre }}</span>
                        <span class="text-gray-300">·</span>
                        <span class="text-gray-500 text-sm">{{ $film->durasi }} menit</span>
                    </div>
                    <p class="text-gray-500 text-sm mt-2 line-clamp-2">{{ $film->sinopsis }}</p>
                    <div class="flex items-center gap-2 mt-2">
                        @if($film->age_rating)
                        <span class="bg-red-100 text-red-700 text-xs px-2 py-0.5 rounded font-semibold">{{ $film->age_rating }}</span>
                        @endif
                    </div>
                </div>
                <div class="flex items-center flex-shrink-0">
                    <a href="{{ route('films.show', $slug) }}"
                       class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-xl font-semibold text-sm transition"
                       onclick="event.stopPropagation()">
                        Pesan Tiket
                    </a>
                </div>
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
function setView(view) {
    const gridView = document.getElementById('gridView');
    const listView = document.getElementById('listView');
    const gridBtn  = document.getElementById('gridViewBtn');
    const listBtn  = document.getElementById('listViewBtn');

    if (view === 'grid') {
        gridView.classList.remove('hidden');
        listView.classList.add('hidden');
        gridBtn.classList.add('bg-red-600', 'text-white');
        gridBtn.classList.remove('bg-gray-200', 'text-gray-600');
        listBtn.classList.remove('bg-red-600', 'text-white');
        listBtn.classList.add('bg-gray-200', 'text-gray-600');
        localStorage.setItem('filmView', 'grid');
    } else {
        gridView.classList.add('hidden');
        listView.classList.remove('hidden');
        listBtn.classList.add('bg-red-600', 'text-white');
        listBtn.classList.remove('bg-gray-200', 'text-gray-600');
        gridBtn.classList.remove('bg-red-600', 'text-white');
        gridBtn.classList.add('bg-gray-200', 'text-gray-600');
        localStorage.setItem('filmView', 'list');
    }
}

// Load saved view
const savedView = localStorage.getItem('filmView');
if (savedView === 'list') setView('list');

// Auto submit on filter change
document.querySelectorAll('#filterForm select').forEach(select => {
    select.addEventListener('change', () => document.getElementById('filterForm').submit());
});
</script>

<style>
.line-clamp-1 { display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden; }
.line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
</style>
@endsection