<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CTIX.ID | @yield('title', 'Movie Experience')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">


<style>
    * { 
        font-family: 'Poppins', sans-serif; 
    }

    .glass {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(0, 0, 0, 0.08);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
    }

    .glow-btn {
        box-shadow: 0 0 20px rgba(239, 68, 68, 0.5);
        transition: all 0.3s ease;
    }

    .glow-btn:hover {
        box-shadow: 0 0 40px rgba(239, 68, 68, 0.8);
        transform: translateY(-3px);
    }

    .text-gradient {
        background: linear-gradient(135deg, #ef4444, #f97316, #eab308);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    html { 
        scroll-behavior: smooth; 
    }

    .user-dropdown { 
        display: none; 
    }

    .user-dropdown.open { 
        display: block; 
    }

    .city-option {
        display: block;
        width: 100%;
        text-align: left;
        padding: 13px 28px;
        font-size: 16px;
        font-weight: 500;
        color: #3f3f46;
        letter-spacing: 0.03em;
        transition: all 0.2s ease;
    }

    .city-option:hover {
        background: rgba(255, 255, 255, 0.65);
        color: #111827;
    }

    .city-option.active {
        background: rgba(255, 255, 255, 0.65);
        color: #111827;
        font-weight: 700;
    }
</style>

    @stack('styles')
</head>

<body class="bg-gradient-to-br from-white via-gray-50 to-white text-gray-900">

    <!-- Navbar -->
    <nav class="fixed w-full z-50 glass border-b border-gray-200 px-6 py-3">
        <div class="max-w-7xl mx-auto relative flex items-center">

            {{-- Logo + Location --}}
            <div class="flex items-center gap-5 z-20">

                {{-- Logo lama --}}
                <a href="{{ route('home') }}" class="flex items-center gap-3 shrink-0">
                    <div class="w-10 h-10 bg-gradient-to-br from-red-500 to-orange-500 rounded-xl flex items-center justify-center">
                        <i class="fas fa-film text-white text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-black leading-none">CTIX<span class="text-red-500">ID</span></h1>
                        <p class="text-xs text-gray-400">Premium Movie Experience</p>
                    </div>
                </a>

                {{-- Location Button --}}
                <div class="relative shrink-0" id="locationWrapper">
                    <button 
                        type="button"
                        onclick="toggleLocationPanel()"
                        class="hidden md:flex items-center gap-3 bg-gray-200/80 hover:bg-gray-200 rounded-full px-5 py-2.5 transition-all duration-200"
                    >
                        <i class="fas fa-map-marker-alt text-gray-700 text-base"></i>
                        <span id="selectedLocationText" class="text-sm font-bold tracking-wider text-gray-800 uppercase">
                            LAMPUNG
                        </span>
                    </button>

                        <div 
                            id="locationPanel"
                            class="hidden absolute left-0 top-full mt-3 w-[460px] max-w-[92vw] bg-[#eeeeee] border border-gray-300 rounded-[24px] shadow-2xl overflow-hidden z-[999]"
                        >
                        <div class="px-7 pt-7 pb-5">
                            <h3 class="text-[22px] font-bold text-gray-800 mb-5">
                                Pilih lokasi kamu
                            </h3>

                            <div class="relative">
                                <i class="fas fa-search absolute left-5 top-1/2 -translate-y-1/2 text-gray-800 text-lg"></i>
                                <input 
                                    type="text"
                                    id="locationSearchInput"
                                    placeholder="Cari kota"
                                    autocomplete="off"
                                    class="w-full h-12 bg-white/70 border border-transparent rounded-full pl-12 pr-5 text-base text-gray-800 placeholder-gray-600 focus:outline-none focus:ring-0 focus:border-transparent"
                                >
                            </div>
                        </div>

                        <div class="border-t border-gray-300"></div>

                        <div id="locationList" class="max-h-[330px] overflow-y-auto py-2">  
                            <button type="button" data-city="AMBON" class="city-option">AMBON</button>
                            <button type="button" data-city="BALIKPAPAN" class="city-option">BALIKPAPAN</button>
                            <button type="button" data-city="BANDUNG" class="city-option">BANDUNG</button>
                            <button type="button" data-city="BANJARMASIN" class="city-option">BANJARMASIN</button>
                            <button type="button" data-city="BATAM" class="city-option">BATAM</button>
                            <button type="button" data-city="BEKASI" class="city-option">BEKASI</button>
                            <button type="button" data-city="BOGOR" class="city-option">BOGOR</button>
                            <button type="button" data-city="DENPASAR" class="city-option">DENPASAR</button>
                            <button type="button" data-city="JAKARTA" class="city-option">JAKARTA</button>
                            <button type="button" data-city="LAMPUNG" class="city-option">LAMPUNG</button>
                            <button type="button" data-city="MAKASSAR" class="city-option">MAKASSAR</button>
                            <button type="button" data-city="MEDAN" class="city-option">MEDAN</button>
                            <button type="button" data-city="PALEMBANG" class="city-option">PALEMBANG</button>
                            <button type="button" data-city="SEMARANG" class="city-option">SEMARANG</button>
                            <button type="button" data-city="SURABAYA" class="city-option">SURABAYA</button>
                            <button type="button" data-city="YOGYAKARTA" class="city-option">YOGYAKARTA</button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Nav Links --}}
            <div class="hidden md:flex items-center gap-8 absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 z-10">
                <a href="{{ route('home') }}"
                   class="text-sm font-medium {{ request()->routeIs('home') ? 'text-red-600 font-semibold' : 'text-gray-600 hover:text-red-500' }} transition">
                    Home
                </a>
                <a href="{{ route('films.index') }}"
                   class="text-sm font-medium {{ request()->routeIs('films.*') ? 'text-red-600 font-semibold' : 'text-gray-600 hover:text-red-500' }} transition">
                    Film
                </a>
                @auth
                <a href="{{ route('booking.my-tickets') }}"
                   class="text-sm font-medium {{ request()->routeIs('booking.my-tickets') ? 'text-red-600 font-semibold' : 'text-gray-600 hover:text-red-500' }} transition">
                    Tiket Saya
                </a>
                <a href="{{ route('booking.history') }}"
                   class="text-sm font-medium {{ request()->routeIs('booking.history') ? 'text-red-600 font-semibold' : 'text-gray-600 hover:text-red-500' }} transition">
                    Riwayat
                </a>
                @endauth
            </div>

            {{-- Auth Area --}}
            <div class="ml-auto flex items-center gap-3 z-20">
                @auth
                    {{-- User Dropdown --}}
                    <div class="relative" id="userMenuWrapper">
                        <button onclick="toggleUserMenu()"
                                class="flex items-center gap-2 bg-gray-100 hover:bg-gray-200 border border-gray-200 rounded-full px-4 py-2 transition">
                            <div class="w-7 h-7 bg-gradient-to-br from-red-500 to-orange-400 rounded-full flex items-center justify-center">
                                <span class="text-white text-xs font-bold">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </span>
                            </div>
                            <span class="text-sm font-semibold text-gray-800 hidden sm:block">
                                {{ Str::limit(Auth::user()->name, 12) }}
                            </span>
                            <i class="fas fa-chevron-down text-xs text-gray-500"></i>
                        </button>

                        {{-- Dropdown Menu --}}
                        <div id="userDropdown"
                             class="user-dropdown absolute right-0 top-full mt-2 w-52 bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden z-50">
                            <div class="px-4 py-3 border-b border-gray-100">
                                <p class="text-xs text-gray-400">Masuk sebagai</p>
                                <p class="text-sm font-semibold text-gray-800 truncate">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-400 truncate">{{ Auth::user()->email }}</p>
                            </div>
                            <div class="py-1">
                                <a href="{{ route('booking.my-tickets') }}"
                                   class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-red-50 hover:text-red-600 transition">
                                    <i class="fas fa-ticket-alt w-4 text-center text-red-400"></i>
                                    Tiket Saya
                                </a>
                                <a href="{{ route('booking.history') }}"
                                   class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-red-50 hover:text-red-600 transition">
                                    <i class="fas fa-history w-4 text-center text-red-400"></i>
                                    Riwayat Pemesanan
                                </a>
                            </div>
                            <div class="border-t border-gray-100 py-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                            class="flex items-center gap-3 w-full px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition">
                                        <i class="fas fa-sign-out-alt w-4 text-center"></i>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}"
                       class="text-sm font-medium text-gray-600 hover:text-red-600 transition px-3 py-2">
                        Masuk
                    </a>
                    <a href="{{ route('daftar') }}"
                       class="glow-btn bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-full text-sm font-bold transition">
                        <i class="fas fa-user-plus mr-1"></i> Daftar
                    </a>
                @endauth
            </div>
        </div>

        {{-- Flash Messages --}}
        @if(session('success'))
        <div class="max-w-7xl mx-auto mt-2">
            <div class="bg-green-50 border border-green-200 text-green-700 text-sm rounded-xl px-4 py-2 flex items-center gap-2">
                <i class="fas fa-check-circle text-green-500"></i>
                {{ session('success') }}
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="max-w-7xl mx-auto mt-2">
            <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl px-4 py-2 flex items-center gap-2">
                <i class="fas fa-exclamation-circle text-red-500"></i>
                {{ session('error') }}
            </div>
        </div>
        @endif
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

<!-- Footer -->
<footer class="bg-gray-900 border-t border-gray-800 mt-auto">
    <div class="max-w-6xl mx-auto px-6 py-10">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mb-8">

            {{-- Brand --}}
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-2 mb-3">
                    <div class="w-8 h-8 bg-gradient-to-br from-red-500 to-orange-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-film text-white text-sm"></i>
                    </div>
                    <h2 class="text-lg font-black text-white">CTIX<span class="text-red-500">ID</span></h2>
                </div>
                <p class="text-gray-400 text-xs leading-relaxed">Platform bioskop online terpercaya di Lampung.</p>
                <div class="flex gap-2 mt-3">
                    <a href="#" class="w-7 h-7 bg-gray-800 hover:bg-red-600 rounded-lg flex items-center justify-center transition">
                        <i class="fab fa-instagram text-white text-xs"></i>
                    </a>
                    <a href="#" class="w-7 h-7 bg-gray-800 hover:bg-red-600 rounded-lg flex items-center justify-center transition">
                        <i class="fab fa-tiktok text-white text-xs"></i>
                    </a>
                    <a href="#" class="w-7 h-7 bg-gray-800 hover:bg-red-600 rounded-lg flex items-center justify-center transition">
                        <i class="fab fa-youtube text-white text-xs"></i>
                    </a>
                </div>
            </div>

            {{-- Film --}}
            <div>
                <h4 class="text-white font-bold text-sm mb-3">Film</h4>
                <ul class="space-y-2">
                    <li><a href="{{ route('films.index') }}" class="text-gray-400 hover:text-white text-xs transition">Sedang Tayang</a></li>
                    <li><a href="{{ route('films.index') }}?status=coming_soon" class="text-gray-400 hover:text-white text-xs transition">Coming Soon</a></li>
                </ul>
            </div>

            {{-- Akun --}}
            <div>
                <h4 class="text-white font-bold text-sm mb-3">Akun</h4>
                <ul class="space-y-2">
                    @auth
                    <li><a href="{{ route('booking.my-tickets') }}" class="text-gray-400 hover:text-white text-xs transition">Tiket Saya</a></li>
                    <li><a href="{{ route('booking.history') }}" class="text-gray-400 hover:text-white text-xs transition">Riwayat</a></li>
                    @else
                    <li><a href="{{ route('login') }}" class="text-gray-400 hover:text-white text-xs transition">Masuk</a></li>
                    <li><a href="{{ route('daftar') }}" class="text-gray-400 hover:text-white text-xs transition">Daftar</a></li>
                    @endauth
                </ul>
            </div>

            {{-- Info --}}
            <div>
                <h4 class="text-white font-bold text-sm mb-3">Info</h4>
                <ul class="space-y-2">
                    <li><a href="#" class="text-gray-400 hover:text-white text-xs transition">Tentang Kami</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white text-xs transition">Bantuan</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white text-xs transition">Kebijakan Privasi</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white text-xs transition">Syarat & Ketentuan</a></li>
                </ul>
            </div>
        </div>

        <div class="border-t border-gray-800 pt-6 flex flex-col md:flex-row justify-between items-center gap-3">
            <p class="text-gray-500 text-xs">&copy; 2026 CTIX.ID Lampung. Semua hak dilindungi.</p>
            <p class="text-gray-600 text-xs">Dibuat dengan <i class="fas fa-heart text-red-500"></i> untuk pengalaman menonton terbaik</p>
        </div>
    </div>
</footer>

    <script>
        function toggleUserMenu() {
            const dropdown = document.getElementById('userDropdown');
            if (dropdown) {
                dropdown.classList.toggle('open');
            }
        }

        function toggleLocationPanel() {
            const panel = document.getElementById('locationPanel');
            if (panel) {
                panel.classList.toggle('hidden');
            }
        }

        function closeLocationPanel() {
            const panel = document.getElementById('locationPanel');
            if (panel) {
                panel.classList.add('hidden');
            }
        }

        function setSelectedLocation(city) {
            const selectedLocationText = document.getElementById('selectedLocationText');
            const cityOptions = document.querySelectorAll('.city-option');

            if (selectedLocationText) {
                selectedLocationText.textContent = city;
            }

            localStorage.setItem('ctix_selected_city', city);

            cityOptions.forEach(option => {
                option.classList.toggle('active', option.dataset.city === city);
            });

            closeLocationPanel();

            window.dispatchEvent(new CustomEvent('ctixLocationChanged', {
                detail: { city: city }
            }));
        }

        function filterLocationList(keyword) {
            const cityOptions = document.querySelectorAll('.city-option');
            const normalizedKeyword = keyword.toLowerCase();

            cityOptions.forEach(option => {
                const cityName = option.dataset.city.toLowerCase();
                option.style.display = cityName.includes(normalizedKeyword) ? 'block' : 'none';
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
            const selectedLocationText = document.getElementById('selectedLocationText');
            const locationSearchInput = document.getElementById('locationSearchInput');
            const cityOptions = document.querySelectorAll('.city-option');

            const savedCity = localStorage.getItem('ctix_selected_city') || 'LAMPUNG';

            if (selectedLocationText) {
                selectedLocationText.textContent = savedCity;
            }

            cityOptions.forEach(option => {
                option.classList.toggle('active', option.dataset.city === savedCity);

                option.addEventListener('click', function () {
                    setSelectedLocation(this.dataset.city);
                });
            });

            if (locationSearchInput) {
                locationSearchInput.addEventListener('input', function () {
                    filterLocationList(this.value);
                });
            }
        });

        document.addEventListener('click', function(e) {
            const userWrapper = document.getElementById('userMenuWrapper');
            const locationWrapper = document.getElementById('locationWrapper');

            if (userWrapper && !userWrapper.contains(e.target)) {
                const dropdown = document.getElementById('userDropdown');
                if (dropdown) {
                    dropdown.classList.remove('open');
                }
            }

            if (locationWrapper && !locationWrapper.contains(e.target)) {
                closeLocationPanel();
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeLocationPanel();

                const dropdown = document.getElementById('userDropdown');
                if (dropdown) {
                    dropdown.classList.remove('open');
                }
            }
        });
    </script>

    @stack('scripts')
</body>
</html>