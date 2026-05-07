@extends('layouts.app')

@section('title', 'Daftar Film - CinemaXXI')

@section('content')
<!-- HERO SECTION untuk Halaman Film -->
<section class="relative pt-20 pb-12 overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-red-50 via-white to-gray-50"></div>
    <div class="relative container mx-auto px-4 text-center">
        <h1 class="text-4xl md:text-6xl font-bold mb-4">
            <span class="text-gray-900">Daftar</span>
            <span class="bg-gradient-to-r from-red-600 to-orange-500 bg-clip-text text-transparent">Film</span>
        </h1>
        <p class="text-gray-600 text-lg max-w-2xl mx-auto">
            Temukan ribuan film terbaik dari berbagai genre. 
            Nikmati pengalaman menonton yang tak terlupakan.
        </p>
    </div>
</section>

<!-- FILTER & SEARCH SECTION -->
<section class="container mx-auto px-4 py-8">
    <div class="bg-white/70 backdrop-blur-sm rounded-2xl p-6 border border-gray-200 shadow-md">
        <form method="GET" action="{{ route('films.index') }}" id="filterForm">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <!-- Search -->
                <div class="md:col-span-2">
                    <div class="relative">
                        <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input type="text" 
                            name="search" 
                            value="{{ request('search') }}"
                            placeholder="Cari film, sutradara, atau genre..." 
                            class="w-full bg-white border border-gray-300 rounded-xl py-3 pl-12 pr-4 text-gray-900 placeholder-gray-400 focus:outline-none focus:border-red-600 transition">
                    </div>
                </div>
                
                <!-- Genre Filter -->
                <div>
                    <select name="genre" class="w-full bg-white border border-gray-300 rounded-xl py-3 px-4 text-gray-900 focus:outline-none focus:border-red-600">
                        <option value="">Semua Genre</option>
                        @foreach($genres as $g)
                            <option value="{{ $g }}" {{ request('genre') == $g ? 'selected' : '' }}>{{ $g }}</option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Status Filter -->
                <div>
                    <select name="status" class="w-full bg-white border border-gray-300 rounded-xl py-3 px-4 text-gray-900 focus:outline-none focus:border-red-600">
                        <option value="now_showing" {{ request('status') == 'now_showing' ? 'selected' : '' }}>Sedang Tayang</option>
                        <option value="coming_soon" {{ request('status') == 'coming_soon' ? 'selected' : '' }}>Coming Soon</option>
                    </select>
                </div>
                
                <!-- Sort -->
                <div>
                    <select name="sort" class="w-full bg-white border border-gray-300 rounded-xl py-3 px-4 text-gray-900 focus:outline-none focus:border-red-600">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Rating Tertinggi</option>
                        <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>Judul A-Z</option>
                    </select>
                </div>
                
                <!-- Submit Button -->
                <div>
                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white rounded-xl py-3 font-semibold transition flex items-center justify-center gap-2 shadow-md">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                </div>
            </div>
        </form>
        
        <!-- Reset Filter -->
        @if(request()->anyFilled(['search', 'genre', 'status', 'sort']))
            <div class="mt-4 text-center">
                <a href="{{ route('films.index') }}" class="text-gray-600 hover:text-red-600 text-sm transition">
                    <i class="fas fa-times-circle mr-1"></i> Reset semua filter
                </a>
            </div>
        @endif
    </div>
</section>

<!-- FILM GRID SECTION -->
<section class="container mx-auto px-4 py-8">
    @if(count($films) > 0)
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">
                    @if(request('status') == 'coming_soon')
                        Akan Segera Tayang
                    @else
                        Sedang Tayang di Bioskop
                    @endif
                </h2>
                <p class="text-gray-600 text-sm mt-1">
                    Menampilkan {{ count($films) }} film
                </p>
            </div>
            
            <!-- View Toggle -->
            <div class="flex gap-2">
                <button onclick="setView('grid')" id="gridViewBtn" class="p-2 rounded-lg bg-red-600 text-white shadow-md">
                    <i class="fas fa-th-large"></i>
                </button>
                <button onclick="setView('list')" id="listViewBtn" class="p-2 rounded-lg bg-gray-200 text-gray-600 hover:bg-gray-300">
                    <i class="fas fa-list"></i>
                </button>
            </div>
        </div>
        
        <!-- Grid View -->
        <div id="gridView" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
            @foreach($films as $film)
            <div class="group cursor-pointer" onclick="window.location='{{ route('films.show', $film->slug) }}'">
                <div class="relative overflow-hidden rounded-xl mb-3">
                    @if($film->poster)
                        <img src="{{ $film->poster }}" alt="{{ $film->judul }}" 
                             class="w-full h-64 object-cover group-hover:scale-110 transition duration-500">
                    @else
                        <div class="w-full h-64 bg-gradient-to-br from-gray-700 to-gray-800 flex items-center justify-center">
                            <i class="fas fa-film text-6xl text-gray-500"></i>
                        </div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-0 group-hover:opacity-100 transition"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-3 bg-gradient-to-t from-black transform translate-y-full group-hover:translate-y-0 transition">
                        <button class="w-full bg-red-600 text-white text-xs font-bold py-2 rounded-lg hover:bg-red-700">
                            Pesan Tiket
                        </button>
                    </div>
                    @if($film->age_rating)
                        <div class="absolute top-2 right-2 bg-red-600 text-white text-xs font-bold px-2 py-1 rounded">
                            {{ $film->age_rating }}
                        </div>
                    @endif
                    @if($film->rating > 0)
                        <div class="absolute bottom-2 left-2 bg-black/70 backdrop-blur-sm px-2 py-1 rounded-lg">
                            <div class="flex items-center gap-1">
                                <i class="fas fa-star text-yellow-400 text-xs"></i>
                                <span class="text-white text-xs font-bold">{{ $film->rating }}</span>
                            </div>
                        </div>
                    @endif
                </div>
                <div>
                    <h3 class="text-gray-900 font-semibold group-hover:text-red-600 transition line-clamp-1">{{ $film->judul }}</h3>
                    <div class="flex items-center gap-2 mt-1">
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
                        <span class="text-gray-600 text-xs">({{ number_format($film->rating_count / 1000, 1) }}k)</span>
                    </div>
                    <p class="text-gray-600 text-xs mt-1">{{ $film->genre }} • {{ $film->duration }}</p>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- List View (Hidden by default) -->
        <div id="listView" class="hidden space-y-4">
            @foreach($films as $film)
            <div class="group cursor-pointer bg-white rounded-xl overflow-hidden border border-gray-200 hover:border-red-600 hover:shadow-lg transition"
                 onclick="window.location='{{ route('films.show', $film->slug) }}'">
                <div class="flex flex-col md:flex-row gap-4 p-4">
                    <div class="w-full md:w-32 h-32 relative">
                        @if($film->poster)
                            <img src="{{ $film->poster }}" alt="{{ $film->judul }}" 
                                 class="w-full h-full object-cover rounded-lg">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-gray-200 to-gray-300 rounded-lg flex items-center justify-center">
                                <i class="fas fa-film text-3xl text-gray-400"></i>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1">
                        <h3 class="text-xl font-bold text-gray-900 group-hover:text-red-600 transition">{{ $film->judul }}</h3>
                        <div class="flex items-center gap-3 mt-1">
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
                            <span class="text-gray-600 text-sm">({{ number_format($film->rating_count / 1000, 1) }}k ulasan)</span>
                            <span class="text-gray-300">•</span>
                            <span class="text-gray-600 text-sm">{{ $film->genre }}</span>
                            <span class="text-gray-600 text-sm">{{ $film->genre }}</span>
                            <span class="text-gray-300">•</span>
                            <span class="text-gray-600 text-sm">{{ $film->duration }}</span>
                        </div>
                        <p class="text-gray-600 text-sm mt-2 line-clamp-2">{{ $film->synopsis }}</p>
                        <div class="flex items-center gap-3 mt-3">
                            <span class="bg-red-100 text-red-700 text-xs px-2 py-1 rounded">{{ $film->age_rating }}</span>
                            <span class="text-gray-500 text-sm">{{ \Carbon\Carbon::parse($film->release_date)->format('d M Y') }}</span>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <button class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg font-semibold transition whitespace-nowrap">
                            Pesan Tiket
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Empty State -->
        @else
        <div class="text-center py-16">
            <i class="fas fa-film text-7xl text-gray-400 mb-4"></i>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">Tidak ada film ditemukan</h3>
            <p class="text-gray-600 mb-6">Coba ubah filter atau kata kunci pencarian Anda</p>
            <a href="{{ route('films.index') }}" class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl font-semibold transition inline-flex items-center gap-2">
                <i class="fas fa-sync-alt"></i> Reset Filter
            </a>
        </div>
        @endif
    </div>
</section>

<script>
// View Toggle (Grid / List)
function setView(view) {
    const gridView = document.getElementById('gridView');
    const listView = document.getElementById('listView');
    const gridBtn = document.getElementById('gridViewBtn');
    const listBtn = document.getElementById('listViewBtn');
    
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

// Load saved view preference
const savedView = localStorage.getItem('filmView');
if (savedView === 'list') {
    setView('list');
}

// Auto-submit form on filter change
document.querySelectorAll('#filterForm select').forEach(select => {
    select.addEventListener('change', () => {
        document.getElementById('filterForm').submit();
    });
});
</script>

<style>
.line-clamp-1 {
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection