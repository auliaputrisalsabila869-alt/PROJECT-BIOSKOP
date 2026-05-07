@extends('layouts.app')

@section('content')
<!-- NAVBAR Professional -->


<!-- HERO SECTION dengan Background Gradient -->
<section class="relative pt-16 overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-gray-50 via-white to-gray-50 opacity-40"></div>
    <div class="relative container mx-auto px-5 py-16 text-center">
        <div class="animate-fade-in-up">
            <h1 class="text-5xl md:text-7xl font-bold mb-4 bg-gradient-to-r from-red-600 to-orange-500 bg-clip-text text-transparent">
                Feel the Memories
            </h1>
            <p class="text-gray-600 text-lg md:text-xl mb-8">Melampaui pengalaman menonton film biasa</p>
            
            <!-- Search Bar yang Lebih Menarik -->
            <div class="relative max-w-2xl mx-auto">
                <div class="relative group">
                    <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 group-hover:text-red-600 transition"></i>
                    <input type="text" 
                        id="searchInput"
                        placeholder="Cari film, bioskop, atau promo..." 
                        class="w-full bg-white border-2 border-gray-300 rounded-full py-3 pl-12 pr-4 text-gray-900 placeholder-gray-400 focus:outline-none focus:border-red-600 focus:bg-white transition backdrop-blur-sm shadow-lg">
                </div>
                
                <!-- Search Results Dropdown -->
                <div id="searchResults" class="absolute top-full left-0 right-0 mt-2 bg-white rounded-xl shadow-2xl border border-gray-200 hidden z-50">
                    <div class="p-2">
                        <div class="text-gray-500 text-xs px-3 py-2">Rekomendasi Film</div>
                        <a href="#" class="flex items-center gap-3 px-3 py-2 hover:bg-gray-100 rounded-lg transition">
                            <i class="fas fa-film text-red-500"></i>
                            <div>
                                <div class="text-gray-900 text-sm">The Martian</div>
                                <div class="text-gray-500 text-xs">Sci-Fi • 144 menit</div>
                            </div>
                        </a>
                        <a href="#" class="flex items-center gap-3 px-3 py-2 hover:bg-gray-100 rounded-lg transition">
                            <i class="fas fa-film text-purple-500"></i>
                            <div>
                                <div class="text-gray-900 text-sm">Spider-Man: Across the Spider-Verse</div>
                                <div class="text-gray-500 text-xs">Animation • 140 menit</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- STATS SECTION -->
<section class="relative -mt-10 container mx-auto px-4 z-10">
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

<!-- QUICK ACCESS MENU -->
<section class="container mx-auto px-4 mt-12">
    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
        <a href="#" class="group relative overflow-hidden rounded-2xl">
            <div class="absolute inset-0 bg-gradient-to-r from-red-600 to-red-700 opacity-90 group-hover:scale-110 transition duration-500"></div>
            <div class="relative p-6 text-center">
                <i class="fas fa-calendar-alt text-4xl text-white mb-2"></i>
                <h3 class="text-white font-bold text-lg">Jadwal Tayang</h3>
                <p class="text-white/80 text-sm">Cek jadwal hari ini</p>
            </div>
        </a>
        <a href="#" class="group relative overflow-hidden rounded-2xl">
            <div class="absolute inset-0 bg-gradient-to-r from-purple-600 to-indigo-700 opacity-90 group-hover:scale-110 transition duration-500"></div>
            <div class="relative p-6 text-center">
                <i class="fas fa-ticket-alt text-4xl text-white mb-2"></i>
                <h3 class="text-white font-bold text-lg">Pesan Tiket</h3>
                <p class="text-white/80 text-sm">Booking sekarang</p>
            </div>
        </a>
        <a href="#" class="group relative overflow-hidden rounded-2xl">
            <div class="absolute inset-0 bg-gradient-to-r from-green-600 to-teal-700 opacity-90 group-hover:scale-110 transition duration-500"></div>
            <div class="relative p-6 text-center">
                <i class="fas fa-gift text-4xl text-white mb-2"></i>
                <h3 class="text-white font-bold text-lg">Promo Spesial</h3>
                <p class="text-white/80 text-sm">Diskon & hadiah</p>
            </div>
        </a>
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

    <!-- Movie Grid (Mengganti horizontal scroll dengan grid) -->
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
        <!-- Movie Card 1 -->
        <div class="group cursor-pointer">
            <div class="relative overflow-hidden rounded-xl mb-3">
                <img src="/martian.jpg" alt="The Martian" class="w-full h-64 object-cover group-hover:scale-110 transition duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-0 group-hover:opacity-100 transition"></div>
                <div class="absolute bottom-0 left-0 right-0 p-3 bg-gradient-to-t from-black transform translate-y-full group-hover:translate-y-0 transition">
                    <button class="w-full bg-red-600 text-white text-xs font-bold py-2 rounded-lg hover:bg-red-700">
                        Beli Tiket
                    </button>
                </div>
                <div class="absolute top-2 right-2 bg-red-600 text-white text-xs font-bold px-2 py-1 rounded">
                    PG-13
                </div>
            </div>
            <div>
                <h3 class="text-gray-900 font-semibold group-hover:text-red-600 transition">The Martian</h3>
                <div class="flex items-center gap-2 mt-1">
                    <div class="flex text-yellow-400 text-xs">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <span class="text-gray-600 text-xs">(4.5)</span>
                </div>
                <p class="text-gray-600 text-xs mt-1">Sci-Fi • 144 menit</p>
            </div>
        </div>

        <!-- Movie Card 2 -->
        <div class="group cursor-pointer">
            <div class="relative overflow-hidden rounded-xl mb-3">
                <img src="/ylbh.jpg" alt="Project: Kapali Guru" class="w-full h-64 object-cover group-hover:scale-110 transition duration-500">
                <div class="absolute bottom-0 left-0 right-0 p-3 bg-gradient-to-t from-black transform translate-y-full group-hover:translate-y-0 transition">
                    <button class="w-full bg-red-600 text-white text-xs font-bold py-2 rounded-lg hover:bg-red-700">
                        Beli Tiket
                    </button>
                </div>
            </div>
            <div>
                <h3 class="text-gray-900 font-semibold group-hover:text-red-600 transition">Project: Kapali Guru</h3>
                <div class="flex items-center gap-2 mt-1">
                    <div class="flex text-yellow-400 text-xs">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="far fa-star"></i>
                        <i class="far fa-star"></i>
                    </div>
                    <span class="text-gray-600 text-xs">(3.0)</span>
                </div>
                <p class="text-gray-600 text-xs mt-1">Drama • 120 menit</p>
            </div>
        </div>

        <!-- Movie Card 3 -->
        <div class="group cursor-pointer">
            <div class="relative overflow-hidden rounded-xl mb-3">
                <img src="/spider.jpg" alt="Spider-Verse" class="w-full h-64 object-cover group-hover:scale-110 transition duration-500">
                <div class="absolute bottom-0 left-0 right-0 p-3 bg-gradient-to-t from-black transform translate-y-full group-hover:translate-y-0 transition">
                    <button class="w-full bg-red-600 text-white text-xs font-bold py-2 rounded-lg hover:bg-red-700">
                        Beli Tiket
                    </button>
                </div>
            </div>
            <div>
                <h3 class="text-gray-900 font-semibold group-hover:text-red-600 transition">The Spider-Verse</h3>
                <div class="flex items-center gap-2 mt-1">
                    <div class="flex text-yellow-400 text-xs">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <span class="text-gray-600 text-xs">(5.0)</span>
                </div>
                <p class="text-gray-600 text-xs mt-1">Animation • 140 menit</p>
            </div>
        </div>
        <!-- Movie Card 4 -->
        <div class="group cursor-pointer">
            <div class="relative overflow-hidden rounded-xl mb-3">
                <img src="/ayah.jpg" alt="Ayah Ini Arahnya Kemana" class="w-full h-64 object-cover group-hover:scale-110 transition duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-0 group-hover:opacity-100 transition"></div>
                <div class="absolute bottom-0 left-0 right-0 p-3 bg-gradient-to-t from-black transform translate-y-full group-hover:translate-y-0 transition">
                    <button class="w-full bg-red-600 text-white text-xs font-bold py-2 rounded-lg hover:bg-red-700">
                        Beli Tiket
                    </button>
                </div>
                <div class="absolute top-2 right-2 bg-red-600 text-white text-xs font-bold px-2 py-1 rounded">
                    PG-13
                </div>
            </div>
            <div>
                <h3 class="text-gray-900 font-semibold group-hover:text-red-600 transition">Ayah Ini Arahnya Kemana</h3>
                <div class="flex items-center gap-2 mt-1">
                    <div class="flex text-yellow-400 text-xs">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <span class="text-gray-600 text-xs">(5)</span>
                </div>
                <p class="text-gray-600 text-xs mt-1">Sci-Fi •  172 menit</p>
            </div>
        </div>

        <!-- Tambahkan movie cards lainnya dengan struktur yang sama -->
        <!-- Movie Card 4 -->
        <div class="group cursor-pointer">
            <div class="relative overflow-hidden rounded-xl mb-3">
                <div class="w-full h-64 bg-gradient-to-br from-purple-200 to-pink-200 flex items-center justify-center">
                    <i class="fas fa-film text-6xl text-gray-300"></i>
                </div>
            </div>
            <div>
                <h3 class="text-gray-900 font-semibold">Coming Soon</h3>
                <p class="text-gray-600 text-xs mt-1">Segera tayang</p>
            </div>
        </div>
    </div>
</section>


<!-- UPCOMING MOVIES SECTION -->
<section class="container mx-auto px-4 mt-16">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900">Coming Soon</h2>
            <p class="text-gray-600 text-sm mt-1">Film yang akan segera tayang</p>
        </div>
    </div>
    
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl overflow-hidden border border-gray-200 shadow-md">
            <div class="relative h-48 bg-gradient-to-br from-gray-200 to-gray-300">
                <i class="fas fa-clock text-4xl text-gray-400 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"></i>
                <div class="absolute bottom-2 right-2 bg-black/70 px-2 py-1 rounded text-xs text-white">Coming 2026</div>
            </div>
            <div class="p-3">
                <h3 class="text-gray-900 font-semibold text-sm">Kupeluk Kamu Selamanya</h3>
                <p class="text-gray-600 text-xs">30 April 2026</p>
            </div>
        </div>
        
        <div class="bg-white rounded-xl overflow-hidden border border-gray-200 shadow-md">
            <div class="relative h-48 bg-gradient-to-br from-gray-200 to-gray-300">
                <i class="fas fa-clock text-4xl text-gray-400 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"></i>
            </div>
            <div class="p-3">
                <h3 class="text-gray-900 font-semibold text-sm">The Devil Wears Prada 2</h3>
                <p class="text-gray-600 text-xs">Coming Soon</p>
            </div>
        </div>
    </div>
</section>

<!-- NEWSLETTER SECTION -->
<section class="container mx-auto px-4 mt-16 mb-16">
    <div class="bg-gradient-to-r from-red-600 to-red-700 rounded-2xl p-8 text-center">
        <h3 class="text-2xl font-bold text-white mb-2">Get Special Offers</h3>
        <p class="text-white/90 mb-6">Dapatkan info promo dan film terbaru langsung ke email Anda</p>
        <div class="flex max-w-md mx-auto gap-3">
            <input type="email" placeholder="Email Anda" class="flex-1 bg-white/20 border border-white/30 rounded-lg px-4 py-2 text-white placeholder-white/60 focus:outline-none focus:border-white">
            <button class="bg-white text-red-600 font-bold px-6 py-2 rounded-lg hover:bg-gray-100 transition">
                Subscribe
            </button>
        </div>
    </div>
</section>



<!-- Custom CSS Animations -->
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
    
    /* Smooth scroll behavior */
    html {
        scroll-behavior: smooth;
    }
    
    /* Custom scrollbar */
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
// Search functionality
const searchInput = document.getElementById('searchInput');
const searchResults = document.getElementById('searchResults');

if (searchInput) {
    searchInput.addEventListener('focus', () => {
        searchResults.classList.remove('hidden');
    });
    
    searchInput.addEventListener('blur', () => {
        setTimeout(() => {
            searchResults.classList.add('hidden');
        }, 200);
    });
    
    searchInput.addEventListener('input', (e) => {
        const query = e.target.value.toLowerCase();
        const items = searchResults.querySelectorAll('a');
        
        items.forEach(item => {
            const text = item.textContent.toLowerCase();
            if (text.includes(query)) {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });
    });
}

// Smooth navbar scroll effect
window.addEventListener('scroll', () => {
    const nav = document.querySelector('nav');
    if (window.scrollY > 50) {
        nav.classList.add('bg-white/90', 'backdrop-blur-md', 'shadow-lg');
    } else {
        nav.classList.remove('bg-white/90', 'shadow-lg');
    }
});
</script>
@endsection