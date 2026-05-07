<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>BioskopApp | @yield('title', 'Movie Experience')</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
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
    </style>
    
    @stack('styles')
</head>

<body class="bg-gradient-to-br from-white via-gray-50 to-white text-gray-900">
    
    <!-- Navbar -->
    <nav class="fixed w-full z-50 glass border-b border-white/10 px-6 py-4">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-orange-500 rounded-xl flex items-center justify-center">
                    <i class="fas fa-film text-white text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-black">CITIX<span class="text-red-500">ID</span></h1>
                    <p class="text-xs text-gray-400 -mt-1">Premium Movie Experience</p>
                </div>
            </a>
            
            <div class="hidden md:flex items-center gap-8">
                <a href="{{ route('home') }}#home" class="text-gray-300 hover:text-red-500 transition">Home</a>
                <a href="{{ route('films.index') }}" class="text-gray-300 hover:text-red-500 transition">Film</a>
                <a href="{{ route('home') }}#jadwal" class="text-gray-300 hover:text-red-500 transition">Jadwal</a>
                <a href="{{ route('home') }}#tentang" class="text-gray-300 hover:text-red-500 transition">Tentang</a>
            </div>
            
            <div class="flex items-center gap-4">
                @auth
                    <div class="flex items-center gap-3 bg-gray-800/50 rounded-full px-4 py-2">
                        <i class="fas fa-user-circle text-red-400"></i>
                        <span>{{ Auth::user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-red-400 hover:text-red-300">Logout</button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="glow-btn bg-red-600 hover:bg-red-700 px-6 py-2 rounded-full text-sm font-bold flex items-center gap-2">
                        <i class="fas fa-sign-in-alt"></i> Sign In
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="pt-20">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="relative mt-20 bg-gradient-to-b from-black/50 to-black border-t border-gray-800">
        <!-- Decorative Background -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-0 left-10 w-72 h-72 bg-red-600/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-10 w-72 h-72 bg-purple-600/10 rounded-full blur-3xl"></div>
        </div>

        <!-- Main Content -->
        <div class="relative max-w-7xl mx-auto px-6 py-16">
            <!-- Footer Grid -->
            <div class="grid grid-cols-1 md:grid-cols-5 gap-10 mb-12">
                <!-- Brand Section -->
                <div class="md:col-span-1">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-orange-500 rounded-xl flex items-center justify-center">
                            <i class="fas fa-film text-white text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-black">CTIX.<span class="text-red-500">ID</span></h2>
                            <p class="text-xs text-gray-400">Lampung</p>
                        </div>
                    </div>
                    <p class="text-gray-400 text-sm leading-relaxed">Platform bioskop online terpercaya dengan pengalaman menonton terbaik dan kualitas premium.</p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-white font-bold mb-4 flex items-center gap-2">
                        <i class="fas fa-link text-red-500"></i> Quick Links
                    </h4>
                    <ul class="space-y-3">
                        <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-red-500 transition text-sm flex items-center gap-2"><i class="fas fa-chevron-right text-xs"></i> Beranda</a></li>
                        <li><a href="{{ route('films.index') }}" class="text-gray-400 hover:text-red-500 transition text-sm flex items-center gap-2"><i class="fas fa-chevron-right text-xs"></i> Daftar Film</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-red-500 transition text-sm flex items-center gap-2"><i class="fas fa-chevron-right text-xs"></i> Jadwal Tayang</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-red-500 transition text-sm flex items-center gap-2"><i class="fas fa-chevron-right text-xs"></i> Promo</a></li>
                    </ul>
                </div>

                <!-- Company -->
                <div>
                    <h4 class="text-white font-bold mb-4 flex items-center gap-2">
                        <i class="fas fa-building text-red-500"></i> Perusahaan
                    </h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-400 hover:text-red-500 transition text-sm flex items-center gap-2"><i class="fas fa-chevron-right text-xs"></i> Tentang Kami</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-red-500 transition text-sm flex items-center gap-2"><i class="fas fa-chevron-right text-xs"></i> Karir</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-red-500 transition text-sm flex items-center gap-2"><i class="fas fa-chevron-right text-xs"></i> Press</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-red-500 transition text-sm flex items-center gap-2"><i class="fas fa-chevron-right text-xs"></i> Blog</a></li>
                    </ul>
                </div>

                <!-- Support -->
                <div>
                    <h4 class="text-white font-bold mb-4 flex items-center gap-2">
                        <i class="fas fa-headset text-red-500"></i> Dukungan
                    </h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-400 hover:text-red-500 transition text-sm flex items-center gap-2"><i class="fas fa-chevron-right text-xs"></i> Bantuan</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-red-500 transition text-sm flex items-center gap-2"><i class="fas fa-chevron-right text-xs"></i> FAQ</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-red-500 transition text-sm flex items-center gap-2"><i class="fas fa-chevron-right text-xs"></i> Kebijakan Privasi</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-red-500 transition text-sm flex items-center gap-2"><i class="fas fa-chevron-right text-xs"></i> Syarat & Ketentuan</a></li>
                    </ul>
                </div>

                <!-- Newsletter -->
                <div>
                    <h4 class="text-white font-bold mb-4 flex items-center gap-2">
                        <i class="fas fa-bell text-red-500"></i> Newsletter
                    </h4>
                    <p class="text-gray-400 text-sm mb-3">Dapatkan penawaran dan update terbaru.</p>
                    <form class="space-y-2">
                        <input type="email" placeholder="Email Anda" class="w-full bg-gray-900/50 border border-gray-700 rounded-lg px-3 py-2 text-white text-sm placeholder-gray-500 focus:outline-none focus:border-red-500 transition">
                        <button type="submit" class="w-full bg-gradient-to-r from-red-600 to-orange-600 hover:from-red-700 hover:to-orange-700 rounded-lg px-3 py-2 text-white font-semibold text-sm transition">Subscribe</button>
                    </form>
                </div>
            </div>

            <!-- Divider -->
            <div class="border-t border-gray-800 my-8"></div>

            <!-- Bottom Section -->
            <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                <!-- Copyright -->
                <div class="text-gray-500 text-sm">
                    &copy; 2026 CTIX.ID Lampung. Semua hak dilindungi. | Dibuat dengan <i class="fas fa-heart text-red-600"></i> untuk pengalaman menonton terbaik.
                </div>

                <!-- Social Media -->
                <div class="flex gap-4">
                    <a href="#" class="w-10 h-10 bg-gray-800/50 hover:bg-red-600 rounded-full flex items-center justify-center transition transform hover:scale-110" title="Instagram">
                        <i class="fab fa-instagram text-white text-lg"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-gray-800/50 hover:bg-red-600 rounded-full flex items-center justify-center transition transform hover:scale-110" title="Facebook">
                        <i class="fab fa-facebook-f text-white text-lg"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-gray-800/50 hover:bg-red-600 rounded-full flex items-center justify-center transition transform hover:scale-110" title="Twitter">
                        <i class="fab fa-x-twitter text-white text-lg"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-gray-800/50 hover:bg-red-600 rounded-full flex items-center justify-center transition transform hover:scale-110" title="YouTube">
                        <i class="fab fa-youtube text-white text-lg"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-gray-800/50 hover:bg-red-600 rounded-full flex items-center justify-center transition transform hover:scale-110" title="TikTok">
                        <i class="fab fa-tiktok text-white text-lg"></i>
                    </a>
                </div>

                <!-- Payment Methods -->
                
            </div>
        </div>

        <!-- Scroll to Top Button -->
        <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})" class="fixed bottom-8 right-8 w-12 h-12 bg-gradient-to-r from-red-600 to-orange-600 hover:from-red-700 hover:to-orange-700 rounded-full flex items-center justify-center text-white shadow-lg hover:shadow-2xl transition transform hover:scale-110 opacity-0 hover:opacity-100 pointer-events-none hover:pointer-events-auto" id="scrollTop">
            <i class="fas fa-arrow-up"></i>
        </button>

        <script>
            // Show/hide scroll to top button
            window.addEventListener('scroll', () => {
                const scrollTopBtn = document.getElementById('scrollTop');
                if (window.scrollY > 300) {
                    scrollTopBtn.classList.remove('opacity-0', 'pointer-events-none');
                    scrollTopBtn.classList.add('opacity-100', 'pointer-events-auto');
                } else {
                    scrollTopBtn.classList.add('opacity-0', 'pointer-events-none');
                    scrollTopBtn.classList.remove('opacity-100', 'pointer-events-auto');
                }
            });
        </script>
    </footer>

    @stack('scripts')
</body>
</html>