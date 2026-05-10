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
        * { font-family: 'Poppins', sans-serif; }

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

        html { scroll-behavior: smooth; }

        /* Dropdown user menu */
        .user-dropdown { display: none; }
        .user-dropdown.open { display: block; }
    </style>

    @stack('styles')
</head>

<body class="bg-gradient-to-br from-white via-gray-50 to-white text-gray-900">

    <!-- Navbar -->
    <nav class="fixed w-full z-50 glass border-b border-gray-200 px-6 py-3">
        <div class="max-w-7xl mx-auto flex justify-between items-center">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-br from-red-500 to-orange-500 rounded-xl flex items-center justify-center">
                    <i class="fas fa-film text-white text-lg"></i>
                </div>
                <div>
                    <h1 class="text-xl font-black leading-none">CTIX<span class="text-red-500">ID</span></h1>
                    <p class="text-xs text-gray-400">Premium Movie Experience</p>
                </div>
            </a>

            {{-- Nav Links --}}
            <div class="hidden md:flex items-center gap-8">
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
            <div class="flex items-center gap-3">
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
    <footer class="relative bg-gradient-to-b from-gray-900 to-black border-t border-gray-800 mt-16">
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-0 left-10 w-72 h-72 bg-red-600/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-10 w-72 h-72 bg-purple-600/10 rounded-full blur-3xl"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-6 py-16">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-10 mb-12">
                <div class="md:col-span-1">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-gradient-to-br from-red-500 to-orange-500 rounded-xl flex items-center justify-center">
                            <i class="fas fa-film text-white text-lg"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-black text-white">CTIX.<span class="text-red-500">ID</span></h2>
                            <p class="text-xs text-gray-400">Lampung</p>
                        </div>
                    </div>
                    <p class="text-gray-400 text-sm leading-relaxed">Platform bioskop online terpercaya untuk pengalaman menonton terbaik.</p>
                </div>

                <div>
                    <h4 class="text-white font-bold mb-4 text-sm flex items-center gap-2">
                        <i class="fas fa-link text-red-500"></i> Quick Links
                    </h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-red-500 transition text-sm flex items-center gap-2"><i class="fas fa-chevron-right text-xs"></i> Beranda</a></li>
                        <li><a href="{{ route('films.index') }}" class="text-gray-400 hover:text-red-500 transition text-sm flex items-center gap-2"><i class="fas fa-chevron-right text-xs"></i> Daftar Film</a></li>
                        @auth
                        <li><a href="{{ route('booking.my-tickets') }}" class="text-gray-400 hover:text-red-500 transition text-sm flex items-center gap-2"><i class="fas fa-chevron-right text-xs"></i> Tiket Saya</a></li>
                        <li><a href="{{ route('booking.history') }}" class="text-gray-400 hover:text-red-500 transition text-sm flex items-center gap-2"><i class="fas fa-chevron-right text-xs"></i> Riwayat</a></li>
                        @endauth
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-bold mb-4 text-sm flex items-center gap-2">
                        <i class="fas fa-building text-red-500"></i> Perusahaan
                    </h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-red-500 transition text-sm flex items-center gap-2"><i class="fas fa-chevron-right text-xs"></i> Tentang Kami</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-red-500 transition text-sm flex items-center gap-2"><i class="fas fa-chevron-right text-xs"></i> Karir</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-red-500 transition text-sm flex items-center gap-2"><i class="fas fa-chevron-right text-xs"></i> Blog</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-bold mb-4 text-sm flex items-center gap-2">
                        <i class="fas fa-headset text-red-500"></i> Dukungan
                    </h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-red-500 transition text-sm flex items-center gap-2"><i class="fas fa-chevron-right text-xs"></i> Bantuan</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-red-500 transition text-sm flex items-center gap-2"><i class="fas fa-chevron-right text-xs"></i> FAQ</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-red-500 transition text-sm flex items-center gap-2"><i class="fas fa-chevron-right text-xs"></i> Kebijakan Privasi</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-bold mb-4 text-sm flex items-center gap-2">
                        <i class="fas fa-bell text-red-500"></i> Newsletter
                    </h4>
                    <p class="text-gray-400 text-sm mb-3">Dapatkan update dan promo terbaru.</p>
                    <form class="space-y-2" onsubmit="return false;">
                        <input type="email" placeholder="Email Anda"
                               class="w-full bg-gray-900/50 border border-gray-700 rounded-lg px-3 py-2 text-white text-sm placeholder-gray-500 focus:outline-none focus:border-red-500 transition">
                        <button type="submit"
                                class="w-full bg-gradient-to-r from-red-600 to-orange-600 hover:from-red-700 hover:to-orange-700 rounded-lg px-3 py-2 text-white font-semibold text-sm transition">
                            Subscribe
                        </button>
                    </form>
                </div>
            </div>

            <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="text-gray-500 text-sm">
                    &copy; 2026 CTIX.ID Lampung. Semua hak dilindungi.
                    Dibuat dengan <i class="fas fa-heart text-red-600"></i> untuk pengalaman menonton terbaik.
                </div>
                <div class="flex gap-3">
                    @foreach(['instagram' => 'fab fa-instagram', 'facebook-f' => 'fab fa-facebook-f', 'x-twitter' => 'fab fa-x-twitter', 'youtube' => 'fab fa-youtube', 'tiktok' => 'fab fa-tiktok'] as $platform => $icon)
                    <a href="#" class="w-9 h-9 bg-gray-800/50 hover:bg-red-600 rounded-full flex items-center justify-center transition transform hover:scale-110">
                        <i class="{{ $icon }} text-white text-sm"></i>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Scroll to Top --}}
        <button onclick="window.scrollTo({top:0,behavior:'smooth'})"
                id="scrollTop"
                class="fixed bottom-8 right-8 w-11 h-11 bg-gradient-to-r from-red-600 to-orange-600 rounded-full flex items-center justify-center text-white shadow-lg transition transform hover:scale-110 opacity-0 pointer-events-none"
                id="scrollTop">
            <i class="fas fa-arrow-up text-sm"></i>
        </button>

        <script>
            window.addEventListener('scroll', () => {
                const btn = document.getElementById('scrollTop');
                if (!btn) return;
                if (window.scrollY > 300) {
                    btn.classList.remove('opacity-0', 'pointer-events-none');
                    btn.classList.add('opacity-100', 'pointer-events-auto');
                } else {
                    btn.classList.add('opacity-0', 'pointer-events-none');
                    btn.classList.remove('opacity-100', 'pointer-events-auto');
                }
            });
        </script>
    </footer>

    <script>
        // Toggle user dropdown
        function toggleUserMenu() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('open');
        }

        // Tutup dropdown kalau klik di luar
        document.addEventListener('click', function(e) {
            const wrapper = document.getElementById('userMenuWrapper');
            if (wrapper && !wrapper.contains(e.target)) {
                const dropdown = document.getElementById('userDropdown');
                if (dropdown) dropdown.classList.remove('open');
            }
        });
    </script>

    @stack('scripts')
</body>
</html>