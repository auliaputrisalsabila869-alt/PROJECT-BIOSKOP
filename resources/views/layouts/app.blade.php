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
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
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

<body class="bg-gradient-to-br from-gray-900 via-purple-900 to-gray-900 text-white">
    
    <!-- Navbar -->
    <nav class="fixed w-full z-50 glass border-b border-white/10 px-6 py-4">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-orange-500 rounded-xl flex items-center justify-center">
                    <i class="fas fa-film text-white text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-black">BIOSKOP<span class="text-red-500">APP</span></h1>
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
    <footer class="border-t border-white/10 py-12 mt-20">
        <div class="max-w-7xl mx-auto px-6 text-center text-gray-500 text-sm">
            &copy; {{ date('Y') }} BioskopApp. All rights reserved.
        </div>
    </footer>

    @stack('scripts')
</body>
</html>