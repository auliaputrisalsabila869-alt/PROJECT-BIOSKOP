@extends('layouts.app')

@section('content')
<!-- HERO SECTION -->
<section class="relative pt-16 overflow-visible bg-gradient-to-br from-white via-cyan-50 to-cyan-100 z-20">
    <div class="absolute inset-0 bg-gradient-to-br from-gray-50 via-white to-cyan-100 opacity-80"></div>

    <div class="relative container mx-auto px-5 py-16 text-center">
        <div class="animate-fade-in-up">
            <h1 class="text-5xl md:text-7xl font-bold mb-4 text-gray-800">
                Feel the Memories
            </h1>

            <p class="text-gray-600 text-lg md:text-xl mb-8">
                Melampaui pengalaman menonton film biasa
            </p>

            <!-- SEARCH BAR -->
            <div class="relative max-w-3xl mx-auto z-40" id="searchWrapper">
                <div class="relative">
                    <i class="fas fa-search absolute left-6 top-1/2 -translate-y-1/2 text-gray-800 text-xl z-10"></i>

                    <input 
                        type="text"
                        id="searchInput"
                        autocomplete="off"
                        placeholder="Cari film atau bioskop"
                        class="w-full h-16 bg-white/80 backdrop-blur-md border border-gray-200 rounded-full pl-16 pr-6 text-lg text-gray-900 placeholder-gray-500 shadow-xl focus:outline-none focus:ring-2 focus:ring-cyan-300 focus:border-cyan-300 transition"
                    >
                </div>

                <!-- SEARCH PANEL -->
                <div 
                    id="searchPanel"
                    class="hidden absolute left-0 right-0 top-[78px] bg-[#eeeeee] border border-gray-300 rounded-3xl shadow-2xl overflow-hidden text-left z-50"
                >
                    <div class="flex items-center gap-6 px-8 py-8 border-b border-gray-300">
                        <button type="button" data-filter="all" class="search-tab bg-black text-white px-8 py-4 rounded-full font-semibold">
                            Semua
                        </button>

                        <button type="button" data-filter="film" class="search-tab bg-white text-gray-900 px-8 py-4 rounded-full font-semibold">
                            Film
                        </button>

                        <button type="button" data-filter="bioskop" class="search-tab bg-white text-gray-900 px-8 py-4 rounded-full font-semibold">
                            Bioskop
                        </button>
                    </div>

                    <div class="px-8 py-8 min-h-[260px] max-h-[520px] overflow-y-auto">
                        <div id="searchLoading" class="hidden text-gray-500 text-sm mb-4">
                            Mencari data...
                        </div>

                        <div id="filmResultSection">
                            <h3 class="text-2xl font-bold text-gray-800 mb-6">Film</h3>
                            <div id="filmResults" class="space-y-5"></div>
                        </div>

                        <div id="bioskopResultSection" class="mt-8">
                            <h3 class="text-2xl font-bold text-gray-800 mb-6">Bioskop</h3>
                            <div id="bioskopResults" class="space-y-4"></div>
                        </div>

                        <div id="emptySearchResult" class="hidden text-center py-12 text-gray-500">
                            <i class="fas fa-search text-4xl mb-3 block text-gray-300"></i>
                            Data tidak ditemukan.
                        </div>
                    </div>
                </div>
            </div>

            <div id="searchBackdrop" class="hidden fixed inset-0 bg-white/65 backdrop-blur-[2px] z-30"></div>

            <!-- MENU IKON -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 max-w-2xl mx-auto mt-14">
                <a href="{{ route('films.index') }}" class="flex flex-col items-center gap-4 group">
                    <div class="w-20 h-20 rounded-3xl border border-cyan-500 bg-cyan-50/70 flex items-center justify-center group-hover:bg-cyan-100 transition">
                        <i class="far fa-square text-3xl text-yellow-500"></i>
                    </div>
                    <span class="text-lg text-gray-800">Bioskop</span>
                </a>

                <a href="{{ route('films.index') }}" class="flex flex-col items-center gap-4 group">
                    <div class="w-20 h-20 rounded-3xl border border-cyan-500 bg-cyan-50/70 flex items-center justify-center group-hover:bg-cyan-100 transition">
                        <i class="fas fa-film text-3xl text-cyan-400"></i>
                    </div>
                    <span class="text-lg text-gray-800">Film</span>
                </a>

                <a href="#" class="flex flex-col items-center gap-4 group">
                    <div class="w-20 h-20 rounded-3xl border border-cyan-500 bg-cyan-50/70 flex items-center justify-center group-hover:bg-cyan-100 transition">
                        <i class="fas fa-box-open text-3xl text-orange-500"></i>
                    </div>
                    <span class="text-lg text-gray-800">m.food</span>
                </a>

                <a href="#" class="flex flex-col items-center gap-4 group">
                    <div class="w-20 h-20 rounded-3xl border border-cyan-500 bg-cyan-50/70 flex items-center justify-center group-hover:bg-cyan-100 transition">
                        <i class="fas fa-couch text-3xl text-teal-600"></i>
                    </div>
                    <span class="text-lg text-gray-800">Sewa Tempat</span>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- STATS SECTION -->
<section class="relative mt-8 container mx-auto px-4 z-0">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-gradient-to-br from-white to-gray-50 rounded-xl p-4 text-center border border-gray-200 hover:scale-105 transition transform shadow-md">
            <i class="fas fa-film text-3xl text-red-500 mb-2"></i>
            <div class="text-2xl font-bold text-gray-900">150+</div>
            <div class="text-gray-600 text-xs">Film Tersedia</div>
        </div>

        <div class="bg-gradient-to-br from-white to-gray-50 rounded-xl p-4 text-center border border-gray-200 hover:scale-105 transition transform shadow-md">
            <i class="fas fa-building text-3xl text-red-500 mb-2"></i>
            <div class="text-2xl font-bold text-gray-900">50+</div>
            <div class="text-gray-600 text-xs">Bioskop Partner</div>
        </div>

        <div class="bg-gradient-to-br from-white to-gray-50 rounded-xl p-4 text-center border border-gray-200 hover:scale-105 transition transform shadow-md">
            <i class="fas fa-users text-3xl text-red-500 mb-2"></i>
            <div class="text-2xl font-bold text-gray-900">2M+</div>
            <div class="text-gray-600 text-xs">Penonton Puas</div>
        </div>

        <div class="bg-gradient-to-br from-white to-gray-50 rounded-xl p-4 text-center border border-gray-200 hover:scale-105 transition transform shadow-md">
            <i class="fas fa-ticket-alt text-3xl text-red-500 mb-2"></i>
            <div class="text-2xl font-bold text-gray-900">500K+</div>
            <div class="text-gray-600 text-xs">Tiket Terjual</div>
        </div>
    </div>
</section>

<!-- NOW SHOWING SECTION -->
<section class="container mx-auto px-4 mt-16">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900">Now Showing</h2>
            <p class="text-gray-600 text-sm mt-1">Film yang sedang tayang di bioskop</p>
        </div>

        <a href="{{ route('films.index') }}" class="text-red-600 hover:text-red-700 transition font-medium flex items-center gap-1">
            Lihat semua
            <i class="fas fa-arrow-right text-xs"></i>
        </a>
    </div>

    @if($nowShowing->count() > 0)
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
            @foreach($nowShowing as $film)
                @php
                    $slug = \Illuminate\Support\Str::slug($film->judul);
                @endphp

                <div class="group cursor-pointer" onclick="window.location='{{ route('films.show', $slug) }}'">
                    <div class="relative overflow-hidden rounded-xl mb-3 shadow-sm aspect-[2/3]">
                        @if($film->poster)
                            <img 
                                src="{{ $film->poster }}" 
                                alt="{{ $film->judul }}" 
                                class="w-full h-full object-cover group-hover:scale-110 transition duration-500"
                                onerror="this.parentElement.innerHTML='<div class=\'w-full h-full bg-gradient-to-br from-gray-700 to-gray-800 flex items-center justify-center\'><i class=\'fas fa-film text-5xl text-gray-500\'></i></div>'"
                            >
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-gray-700 to-gray-800 flex items-center justify-center">
                                <i class="fas fa-film text-5xl text-gray-500"></i>
                            </div>
                        @endif

                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition duration-300"></div>

                        <div class="absolute bottom-0 left-0 right-0 p-3 translate-y-full group-hover:translate-y-0 transition duration-300">
                            <a 
                                href="{{ route('films.show', $slug) }}"
                                class="block w-full bg-red-600 hover:bg-red-700 text-white text-xs font-bold py-2 rounded-lg text-center"
                                onclick="event.stopPropagation()"
                            >
                                <i class="fas fa-ticket-alt mr-1"></i> Beli Tiket
                            </a>
                        </div>

                        @if($film->age_rating)
                            <div class="absolute top-2 right-2 bg-red-600 text-white text-xs font-bold px-2 py-1 rounded">
                                {{ $film->age_rating }}
                            </div>
                        @endif

                        @if($film->rating > 0)
                            <div class="absolute bottom-2 left-2 bg-black/70 backdrop-blur-sm px-2 py-1 rounded-lg flex items-center gap-1">
                                <i class="fas fa-star text-yellow-400 text-xs"></i>
                                <span class="text-white text-xs font-bold">{{ $film->rating }}</span>
                            </div>
                        @endif
                    </div>

                    <div>
                        <h3 class="text-gray-900 font-semibold group-hover:text-red-600 transition line-clamp-1">
                            {{ $film->judul }}
                        </h3>

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

                            <span class="text-gray-600 text-xs">
                                ({{ number_format($film->rating, 1) }})
                            </span>
                        </div>

                        <p class="text-gray-600 text-xs mt-1">
                            {{ $film->genre }} • {{ $film->durasi }} menit
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-12 bg-white rounded-2xl border border-dashed border-gray-200">
            <i class="fas fa-film text-5xl text-gray-200 mb-3 block"></i>
            <p class="text-gray-400 font-medium">Tidak ada film yang sedang tayang</p>
        </div>
    @endif
</section>

<!-- UPCOMING MOVIES SECTION -->
<section class="container mx-auto px-4 mt-16">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900">Coming Soon</h2>
            <p class="text-gray-600 text-sm mt-1">Film yang akan segera tayang</p>
        </div>
    </div>
    
    @if($comingSoon->count() > 0)
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($comingSoon as $film)
                @php
                    $slug = \Illuminate\Support\Str::slug($film->judul);
                @endphp

                <div 
                    class="bg-white rounded-xl overflow-hidden border border-gray-200 shadow-md group cursor-pointer"
                    onclick="window.location='{{ route('films.show', $slug) }}'"
                >
                    <div class="relative h-48 bg-gradient-to-br from-gray-200 to-gray-300 overflow-hidden">
                        @if($film->poster)
                            <img 
                                src="{{ $film->poster }}" 
                                alt="{{ $film->judul }}" 
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-500 filter brightness-75"
                            >
                        @else
                            <i class="fas fa-clock text-4xl text-gray-400 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"></i>
                        @endif

                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="bg-orange-500 text-white text-xs font-black px-3 py-1.5 rounded-full uppercase tracking-wider">
                                Coming Soon
                            </div>
                        </div>
                    </div>

                    <div class="p-3">
                        <h3 class="text-gray-900 font-semibold text-sm line-clamp-1">
                            {{ $film->judul }}
                        </h3>
                        <p class="text-gray-600 text-xs">{{ $film->genre }}</p>
                    </div>
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

<!-- NEWSLETTER SECTION -->
<section class="container mx-auto px-4 mt-16 mb-16">
    <div class="bg-gradient-to-r from-red-600 to-red-700 rounded-2xl p-8 text-center">
        <h3 class="text-2xl font-bold text-white mb-2">Get Special Offers</h3>
        <p class="text-white/90 mb-6">Dapatkan info promo dan film terbaru langsung ke email Anda</p>

        <div class="flex max-w-md mx-auto gap-3">
            <input 
                type="email" 
                placeholder="Email Anda" 
                class="flex-1 bg-white/20 border border-white/30 rounded-lg px-4 py-2 text-white placeholder-white/60 focus:outline-none focus:border-white"
            >

            <button class="bg-white text-red-600 font-bold px-6 py-2 rounded-lg hover:bg-gray-100 transition">
                Subscribe
            </button>
        </div>
    </div>
</section>

<!-- CUSTOM CSS -->
<style>
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-fade-in-up {
        animation: fadeInUp 0.8s ease-out;
    }
    
    html {
        scroll-behavior: smooth;
    }
    
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }
    
    ::-webkit-scrollbar-track {
        background: #f3f4f6;
    }
    
    ::-webkit-scrollbar-thumb {
        background: #dc2626;
        border-radius: 4px;
    }
    
    ::-webkit-scrollbar-thumb:hover {
        background: #b91c1c;
    }
</style>

<script>
const searchInput = document.getElementById('searchInput');
const searchPanel = document.getElementById('searchPanel');
const searchBackdrop = document.getElementById('searchBackdrop');
const searchLoading = document.getElementById('searchLoading');

const filmResults = document.getElementById('filmResults');
const bioskopResults = document.getElementById('bioskopResults');

const filmResultSection = document.getElementById('filmResultSection');
const bioskopResultSection = document.getElementById('bioskopResultSection');
const emptySearchResult = document.getElementById('emptySearchResult');

const tabs = document.querySelectorAll('.search-tab');

let activeFilter = 'all';
let searchTimer = null;
let latestData = {
    films: [],
    bioskop: [],
};

function openSearchPanel() {
    searchPanel.classList.remove('hidden');
    searchBackdrop.classList.remove('hidden');
}

function closeSearchPanel() {
    searchPanel.classList.add('hidden');
    searchBackdrop.classList.add('hidden');
}

function setActiveTab(filter) {
    activeFilter = filter;

    tabs.forEach(tab => {
        const isActive = tab.dataset.filter === filter;

        tab.classList.toggle('bg-black', isActive);
        tab.classList.toggle('text-white', isActive);
        tab.classList.toggle('bg-white', !isActive);
        tab.classList.toggle('text-gray-900', !isActive);
    });

    renderSearchResults();
}

function renderSearchResults() {
    filmResults.innerHTML = '';
    bioskopResults.innerHTML = '';

    const films = latestData.films || [];
    const bioskop = latestData.bioskop || [];

    const showFilm = activeFilter === 'all' || activeFilter === 'film';
    const showBioskop = activeFilter === 'all' || activeFilter === 'bioskop';

    filmResultSection.classList.toggle('hidden', !showFilm);
    bioskopResultSection.classList.toggle('hidden', !showBioskop);

    if (showFilm) {
        films.forEach(film => {
            filmResults.innerHTML += `
                <a href="${film.url}" class="flex items-center gap-5 group">
                    <div class="w-24 h-32 rounded-lg overflow-hidden bg-gray-300 shrink-0">
                        ${
                            film.poster
                            ? `<img src="${film.poster}" alt="${film.title}" class="w-full h-full object-cover">`
                            : `<div class="w-full h-full flex items-center justify-center text-gray-500"><i class="fas fa-film text-3xl"></i></div>`
                        }
                    </div>

                    <div>
                        <h4 class="text-xl font-semibold text-gray-900 group-hover:text-cyan-600 transition">
                            ${film.title}
                        </h4>

                        <div class="flex items-center gap-2 mt-3">
                            <span class="bg-gray-200 text-gray-700 text-sm px-3 py-1 rounded-md">
                                ${film.format}
                            </span>

                            <span class="bg-gray-200 text-gray-700 text-sm px-3 py-1 rounded-md">
                                ${film.age_rating}
                            </span>
                        </div>

                        <p class="text-gray-500 text-sm mt-2">${film.genre ?? ''}</p>
                    </div>
                </a>
            `;
        });
    }

    if (showBioskop) {
        bioskop.forEach(item => {
            bioskopResults.innerHTML += `
                <a href="${item.url}" class="flex items-center gap-4 p-4 rounded-2xl hover:bg-white transition">
                    <div class="w-14 h-14 rounded-2xl bg-cyan-100 flex items-center justify-center text-cyan-700">
                        <i class="fas fa-building text-xl"></i>
                    </div>

                    <div>
                        <h4 class="text-lg font-semibold text-gray-900">${item.name}</h4>
                        <p class="text-gray-500 text-sm">Kapasitas ${item.capacity} kursi</p>
                    </div>
                </a>
            `;
        });
    }

    const totalVisible =
        (showFilm ? films.length : 0) +
        (showBioskop ? bioskop.length : 0);

    emptySearchResult.classList.toggle('hidden', totalVisible > 0);
}

function fetchSearchResults(keyword) {
    searchLoading.classList.remove('hidden');

    fetch(`/search/suggestions?q=${encodeURIComponent(keyword)}`)
        .then(response => response.json())
        .then(data => {
            latestData = data;
            renderSearchResults();
        })
        .catch(() => {
            latestData = { films: [], bioskop: [] };
            renderSearchResults();
        })
        .finally(() => {
            searchLoading.classList.add('hidden');
        });
}

searchInput.addEventListener('focus', () => {
    if (searchInput.value.trim().length >= 2) {
        openSearchPanel();
    }
});

searchInput.addEventListener('input', function () {
    const keyword = this.value.trim();

    clearTimeout(searchTimer);

    if (keyword.length < 2) {
        closeSearchPanel();
        latestData = { films: [], bioskop: [] };
        return;
    }

    openSearchPanel();

    searchTimer = setTimeout(() => {
        fetchSearchResults(keyword);
    }, 300);
});

tabs.forEach(tab => {
    tab.addEventListener('click', () => {
        setActiveTab(tab.dataset.filter);
    });
});

searchBackdrop.addEventListener('click', closeSearchPanel);

document.addEventListener('keydown', function (event) {
    if (event.key === 'Escape') {
        closeSearchPanel();
    }
});

window.addEventListener('scroll', () => {
    const nav = document.querySelector('nav');

    if (!nav) return;

    if (window.scrollY > 50) {
        nav.classList.add('bg-white/90', 'backdrop-blur-md', 'shadow-lg');
    } else {
        nav.classList.remove('bg-white/90', 'backdrop-blur-md', 'shadow-lg');
    }
});
</script>
@endsection