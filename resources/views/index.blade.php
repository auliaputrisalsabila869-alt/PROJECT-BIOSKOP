<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BioskopApp | Masuk & Daftar</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { font-family: 'Poppins', sans-serif; }
        
        /* Custom Glass Effect */
        .glass { 
            background: rgba(255, 255, 255, 0.05); 
            backdrop-filter: blur(20px); 
            border: 1px solid rgba(255, 255, 255, 0.1); 
        }
        
        .glass-heavy {
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }
        
        /* Animated Gradient Background */
        .animated-bg {
            background: linear-gradient(-45deg, #0f172a, #1e1b4b, #312e81, #0f172a);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }
        
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        /* Floating Animation */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        .float-animation {
            animation: float 6s ease-in-out infinite;
        }
        
        /* Glowing Button */
        .glow-btn {
            box-shadow: 0 0 20px rgba(239, 68, 68, 0.5);
            transition: all 0.3s ease;
        }
        
        .glow-btn:hover {
            box-shadow: 0 0 40px rgba(239, 68, 68, 0.8);
            transform: translateY(-3px);
        }
        
        /* Card Hover Effects */
        .movie-card {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        
        .movie-card:hover {
            transform: translateY(-15px) scale(1.02);
        }
        
        .movie-card:hover .card-overlay {
            opacity: 1;
        }
        
        /* Text Gradient */
        .text-gradient {
            background: linear-gradient(135deg, #ef4444, #f97316, #eab308);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #0f172a; }
        ::-webkit-scrollbar-thumb { background: #ef4444; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #dc2626; }
        
        /* Modal Animation */
        .modal-enter {
            animation: modalFadeIn 0.3s cubic-bezier(0.34, 1.2, 0.64, 1);
        }
        
        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: scale(0.95) translateY(-20px);
            }
            to {
                opacity: 1;
                transform: scale(1) translateY(0px);
            }
        }
        
        /* Input focus style */
        .input-focus:focus {
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.3);
            border-color: #ef4444;
            outline: none;
        }
        
        /* Toast notification */
        .toast-notify {
            animation: toastSlide 0.3s ease forwards;
        }
        
        @keyframes toastSlide {
            from {
                opacity: 0;
                transform: translateX(100%);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
    </style>
</head>
<body class="animated-bg text-white overflow-x-hidden">

    <!-- Animated Background Particles -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 left-10 w-72 h-72 bg-red-500/10 rounded-full blur-3xl float-animation"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-purple-500/10 rounded-full blur-3xl float-animation" style="animation-delay: -3s;"></div>
        <div class="absolute top-1/2 left-1/2 w-64 h-64 bg-blue-500/10 rounded-full blur-3xl float-animation" style="animation-delay: -6s;"></div>
    </div>

    <!-- Navbar -->
    <nav class="fixed w-full z-50 glass border-b border-white/5 px-6 py-4">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a href="#" class="flex items-center gap-3 hover:opacity-90 transition-opacity">
                <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-orange-500 rounded-xl flex items-center justify-center">
                    <i class="fas fa-film text-white text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-black tracking-tight">BIOSKOP<span class="text-red-500">APP</span></h1>
                    <p class="text-xs text-gray-400 -mt-1">Premium Movie Experience</p>
                </div>
            </a>
            
            <div class="hidden md:flex items-center gap-8">
                <a href="#home" class="text-sm font-medium text-gray-300 hover:text-red-500 transition-all relative group">
                    Home
                    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-red-500 group-hover:w-full transition-all duration-300"></span>
                </a>
                <a href="#film" class="text-sm font-medium text-gray-300 hover:text-red-500 transition-all relative group">
                    Film
                    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-red-500 group-hover:w-full transition-all duration-300"></span>
                </a>
                <a href="#jadwal" class="text-sm font-medium text-gray-300 hover:text-red-500 transition-all relative group">
                    Jadwal
                    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-red-500 group-hover:w-full transition-all duration-300"></span>
                </a>
                <a href="#tentang" class="text-sm font-medium text-gray-300 hover:text-red-500 transition-all relative group">
                    Tentang
                    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-red-500 group-hover:w-full transition-all duration-300"></span>
                </a>
            </div>
            
            <div class="flex items-center gap-4">
                <button class="p-2 text-gray-300 hover:text-white transition-colors">
                    <i class="fas fa-search text-lg"></i>
                </button>
                <!-- Tombol Sign In yang akan membuka modal -->
                <button id="openSignInBtn" class="glow-btn bg-red-600 hover:bg-red-700 px-6 py-2.5 rounded-full text-sm font-bold transition-all flex items-center gap-2">
                    <i class="fas fa-sign-in-alt"></i>
                    Sign In
                </button>
                <!-- Avatar user (hidden saat belum login) -->
                <div id="userAvatar" class="hidden items-center gap-2 bg-gray-800/50 rounded-full pl-3 pr-2 py-1 border border-white/10">
                    <i class="fas fa-user-circle text-red-400 text-xl"></i>
                    <span id="userNameDisplay" class="text-sm font-medium">User</span>
                    <button id="logoutBtn" class="ml-2 text-xs text-gray-400 hover:text-red-400">Logout</button>
                </div>
            </div>
        </div>
    </nav>

    <!-- MODAL LOGIN & REGISTER -->
    <div id="authModal" class="fixed inset-0 z-[100] flex items-center justify-center px-4 hidden transition-all duration-300" style="background: rgba(0,0,0,0.8); backdrop-filter: blur(8px);">
        <div class="glass-heavy rounded-3xl w-full max-w-md p-8 modal-enter relative border border-white/20 shadow-2xl">
            <!-- Tombol close -->
            <button id="closeModalBtn" class="absolute top-5 right-5 text-gray-400 hover:text-white transition">
                <i class="fas fa-times text-xl"></i>
            </button>
            
            <!-- Tab Navigation -->
            <div class="flex gap-4 mb-8 border-b border-white/10 pb-2">
                <button id="loginTabBtn" class="text-lg font-bold pb-2 transition-all flex-1 text-center border-b-2 border-red-500 text-red-400">Masuk</button>
                <button id="registerTabBtn" class="text-lg font-bold pb-2 transition-all flex-1 text-center border-b-2 border-transparent text-gray-400 hover:text-white">Daftar</button>
            </div>
            
            <!-- Form Login -->
            <div id="loginForm" class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Email</label>
                    <input type="email" id="loginEmail" placeholder="contoh@email.com" class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white placeholder-gray-400 focus:outline-none input-focus transition">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Kata Sandi</label>
                    <input type="password" id="loginPassword" placeholder="••••••••" class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white placeholder-gray-400 focus:outline-none input-focus transition">
                </div>
                <button id="doLoginBtn" class="w-full bg-gradient-to-r from-red-600 to-orange-600 py-3 rounded-xl font-bold text-lg mt-4 hover:shadow-xl transition-all transform hover:scale-[1.02]">
                    <i class="fas fa-arrow-right-to-bracket mr-2"></i> Masuk
                </button>
                <p class="text-center text-gray-400 text-sm mt-4">Belum punya akun? <button id="switchToRegister" class="text-red-500 hover:underline font-semibold">Daftar sekarang</button></p>
            </div>
            
            <!-- Form Register -->
            <div id="registerForm" class="space-y-4 hidden">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Nama Lengkap</label>
                    <input type="text" id="regName" placeholder="John Doe" class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white placeholder-gray-400 focus:outline-none input-focus">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Email</label>
                    <input type="email" id="regEmail" placeholder="contoh@email.com" class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white placeholder-gray-400 focus:outline-none input-focus">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Kata Sandi</label>
                    <input type="password" id="regPassword" placeholder="Minimal 6 karakter" class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white placeholder-gray-400 focus:outline-none input-focus">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Konfirmasi Sandi</label>
                    <input type="password" id="regConfirmPassword" placeholder="Ulangi sandi" class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white placeholder-gray-400 focus:outline-none input-focus">
                </div>
                <button id="doRegisterBtn" class="w-full bg-gradient-to-r from-green-600 to-teal-600 py-3 rounded-xl font-bold text-lg mt-2 hover:shadow-xl transition-all transform hover:scale-[1.02]">
                    <i class="fas fa-user-plus mr-2"></i> Daftar
                </button>
                <p class="text-center text-gray-400 text-sm mt-4">Sudah punya akun? <button id="switchToLogin" class="text-red-500 hover:underline font-semibold">Masuk disini</button></p>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toastMessage" class="fixed bottom-6 right-6 z-[110] hidden toast-notify glass-heavy rounded-xl px-5 py-3 border-l-4 border-red-500 shadow-2xl">
        <div class="flex items-center gap-3">
            <i id="toastIcon" class="fas fa-info-circle text-red-500"></i>
            <span id="toastText" class="text-sm font-medium">Pesan</span>
        </div>
    </div>

    <!-- Hero Section (ringkas agar tetap modern) -->
    <section id="home" class="relative min-h-screen flex items-center justify-center pt-20">
        <div class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-[#0f172a]"></div>
        <div class="relative z-10 max-w-6xl mx-auto px-6 text-center">
            <div class="inline-flex items-center gap-2 bg-white/5 border border-white/10 px-4 py-2 rounded-full mb-8">
                <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                <span class="text-sm text-gray-300">Sekarang Tayang</span>
                <span class="text-red-500 font-semibold">Avengers: Endgame</span>
            </div>
            <h2 class="text-6xl md:text-8xl font-black mb-6 leading-tight">
                <span class="block text-gray-400">RAIKAN</span>
                <span class="text-gradient">PERSEMAN</span>
                <br>
                <span class="text-4xl md:text-6xl">TAYANGAN</span>
            </h2>
            <p class="text-gray-400 text-lg md:text-xl max-w-3xl mx-auto mb-10 leading-relaxed">
                Temukan pengalaman menonton film terbaik dengan kualitas gambar 4K, 
                audio Dolby Atmos, dan kenyamanan tanpa batas. Hanya di BioskopApp.
            </p>
            <div class="flex flex-col md:flex-row gap-4 justify-center items-center">
                <a href="#film" class="glow-btn bg-red-600 hover:bg-red-700 px-10 py-4 rounded-2xl font-bold text-lg transition-all flex items-center gap-3">
                    <i class="fas fa-play"></i>
                    Mulai Menonton
                </a>
            </div>
        </div>
        <div class="absolute bottom-10 left-1/2 -translate-x-1/2 animate-bounce">
            <div class="w-6 h-10 border-2 border-white/30 rounded-full flex justify-center pt-2">
                <div class="w-1.5 h-3 bg-white/50 rounded-full"></div>
            </div>
        </div>
    </section>

    <!-- Film Section (dipertahankan dengan sedikit penyesuaian) -->
    <section id="film" class="py-24 relative">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-end mb-12">
                <div>
                    <span class="text-red-500 font-semibold text-sm tracking-widest uppercase">Koleksi Film</span>
                    <h3 class="text-4xl font-black mt-2">Sedang <span class="text-gradient">Tayang</span></h3>
                    <div class="h-1 w-24 bg-red-600 mt-4 rounded-full"></div>
                </div>
                <div class="flex gap-3 mt-6 md:mt-0">
                    <button class="p-3 rounded-full bg-white/5 hover:bg-white/10 transition-colors"><i class="fas fa-chevron-left"></i></button>
                    <button class="p-3 rounded-full bg-white/5 hover:bg-white/10 transition-colors"><i class="fas fa-chevron-right"></i></button>
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Film Card 1 -->
                <div class="movie-card group relative bg-gray-800/50 rounded-3xl overflow-hidden border border-white/5">
                    <div class="relative h-[400px] overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1509248961158-e54f6934749c?auto=format&fit=crop&q=80&w=800" alt="Avengers" class="w-full h-full object-cover group-hover:scale-110 transition-duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-transparent to-transparent"></div>
                        <div class="absolute top-4 left-4 bg-yellow-500 text-black px-3 py-1 rounded-full text-sm font-bold flex items-center gap-1"><i class="fas fa-star text-xs"></i>8.4</div>
                        <div class="card-overlay absolute inset-0 bg-black/60 flex items-center justify-center opacity-0 transition-all duration-300"><button class="w-20 h-20 bg-red-600 rounded-full flex items-center justify-center hover:scale-110 transition-transform"><i class="fas fa-play text-2xl ml-1"></i></button></div>
                    </div>
                    <div class="p-6"><h4 class="text-xl font-bold mb-2 group-hover:text-red-500 transition-colors">Avengers: Endgame</h4><div class="flex items-center gap-3 text-gray-400 text-sm mb-3"><span><i class="fas fa-clock mr-1"></i>3h 1m</span><span class="w-1 h-1 bg-gray-400 rounded-full"></span><span>Action</span></div><button class="w-full bg-gradient-to-r from-red-600 to-orange-600 py-3 rounded-xl font-bold hover:opacity-90 transition-opacity">Pesan Tiket</button></div>
                </div>
                <div class="movie-card group relative bg-gray-800/50 rounded-3xl overflow-hidden border border-white/5"><div class="relative h-[400px] overflow-hidden"><img src="https://images.unsplash.com/photo-1635805737707-575885ab0820?auto=format&fit=crop&q=80&w=800" alt="Spider-Man" class="w-full h-full object-cover group-hover:scale-110 transition-duration-700"><div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-transparent to-transparent"></div><div class="absolute top-4 left-4 bg-yellow-500 text-black px-3 py-1 rounded-full text-sm font-bold flex items-center gap-1"><i class="fas fa-star text-xs"></i>8.1</div><div class="card-overlay absolute inset-0 bg-black/60 flex items-center justify-center opacity-0 transition-all duration-300"><button class="w-20 h-20 bg-red-600 rounded-full flex items-center justify-center hover:scale-110 transition-transform"><i class="fas fa-play text-2xl ml-1"></i></button></div></div><div class="p-6"><h4 class="text-xl font-bold mb-2 group-hover:text-red-500 transition-colors">Spider-Man: No Way Home</h4><div class="flex items-center gap-3 text-gray-400 text-sm mb-3"><span><i class="fas fa-clock mr-1"></i>2h 28m</span><span class="w-1 h-1 bg-gray-400 rounded-full"></span><span>Action</span></div><button class="w-full bg-gradient-to-r from-red-600 to-orange-600 py-3 rounded-xl font-bold hover:opacity-90 transition-opacity">Pesan Tiket</button></div></div>
                <div class="movie-card group relative bg-gray-800/50 rounded-3xl overflow-hidden border border-white/5"><div class="relative h-[400px] overflow-hidden"><img src="https://images.unsplash.com/photo-1531259683007-016a7b628fc3?auto=format&fit=crop&q=80&w=800" alt="Batman" class="w-full h-full object-cover group-hover:scale-110 transition-duration-700"><div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-transparent to-transparent"></div><div class="absolute top-4 left-4 bg-yellow-500 text-black px-3 py-1 rounded-full text-sm font-bold flex items-center gap-1"><i class="fas fa-star text-xs"></i>7.8</div><div class="card-overlay absolute inset-0 bg-black/60 flex items-center justify-center opacity-0 transition-all duration-300"><button class="w-20 h-20 bg-red-600 rounded-full flex items-center justify-center hover:scale-110 transition-transform"><i class="fas fa-play text-2xl ml-1"></i></button></div></div><div class="p-6"><h4 class="text-xl font-bold mb-2 group-hover:text-red-500 transition-colors">The Batman</h4><div class="flex items-center gap-3 text-gray-400 text-sm mb-3"><span><i class="fas fa-clock mr-1"></i>2h 56m</span><span class="w-1 h-1 bg-gray-400 rounded-full"></span><span>Crime</span></div><button class="w-full bg-gradient-to-r from-red-600 to-orange-600 py-3 rounded-xl font-bold hover:opacity-90 transition-opacity">Pesan Tiket</button></div></div>
                <div class="movie-card group relative bg-gray-800/50 rounded-3xl overflow-hidden border border-white/5"><div class="relative h-[400px] overflow-hidden"><img src="https://images.unsplash.com/photo-1596727147705-61a532a655bd?auto=format&fit=crop&q=80&w=800" alt="Iron Man" class="w-full h-full object-cover group-hover:scale-110 transition-duration-700"><div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-transparent to-transparent"></div><div class="absolute top-4 left-4 bg-yellow-500 text-black px-3 py-1 rounded-full text-sm font-bold flex items-center gap-1"><i class="fas fa-star text-xs"></i>7.9</div><div class="card-overlay absolute inset-0 bg-black/60 flex items-center justify-center opacity-0 transition-all duration-300"><button class="w-20 h-20 bg-red-600 rounded-full flex items-center justify-center hover:scale-110 transition-transform"><i class="fas fa-play text-2xl ml-1"></i></button></div></div><div class="p-6"><h4 class="text-xl font-bold mb-2 group-hover:text-red-500 transition-colors">Iron Man 3</h4><div class="flex items-center gap-3 text-gray-400 text-sm mb-3"><span><i class="fas fa-clock mr-1"></i>2h 10m</span><span class="w-1 h-1 bg-gray-400 rounded-full"></span><span>Action</span></div><button class="w-full bg-gradient-to-r from-red-600 to-orange-600 py-3 rounded-xl font-bold hover:opacity-90 transition-opacity">Pesan Tiket</button></div></div>
            </div>
        </div>
    </section>

    <section id="jadwal" class="py-24 bg-black/20"><div class="max-w-7xl mx-auto px-6 text-center"><span class="text-red-500 font-semibold text-sm tracking-widest uppercase">Jadwal Tayang</span><h3 class="text-4xl font-black mt-2">Pilih <span class="text-gradient">Waktu</span></h3><div class="flex flex-wrap justify-center gap-4 mt-8"><div class="glass p-6 rounded-2xl w-32 border-red-500/50"><p class="text-sm">Sen</p><p class="font-bold">20</p></div><div class="glass p-6 rounded-2xl w-32 opacity-50"><p class="text-sm">Sel</p><p class="font-bold">21</p></div><div class="glass p-6 rounded-2xl w-32 opacity-50"><p class="text-sm">Rab</p><p class="font-bold">22</p></div></div></div></section>

    <footer id="tentang" class="border-t border-white/10 py-16">
        <div class="max-w-7xl mx-auto px-6 text-center text-gray-500 text-sm">&copy; 2026 BioskopApp. All rights reserved. Made with <i class="fas fa-heart text-red-500"></i> in Indonesia</div>
    </footer>

    <script>
        // --- Auth System (Simulasi localStorage) ---
        let currentUser = localStorage.getItem('bioskop_user') ? JSON.parse(localStorage.getItem('bioskop_user')) : null;
        
        // DOM Elements
        const modal = document.getElementById('authModal');
        const openSignInBtn = document.getElementById('openSignInBtn');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const loginTab = document.getElementById('loginTabBtn');
        const registerTab = document.getElementById('registerTabBtn');
        const loginFormDiv = document.getElementById('loginForm');
        const registerFormDiv = document.getElementById('registerForm');
        const switchToRegister = document.getElementById('switchToRegister');
        const switchToLogin = document.getElementById('switchToLogin');
        const doLoginBtn = document.getElementById('doLoginBtn');
        const doRegisterBtn = document.getElementById('doRegisterBtn');
        const userAvatar = document.getElementById('userAvatar');
        const userNameDisplay = document.getElementById('userNameDisplay');
        const logoutBtn = document.getElementById('logoutBtn');
        
        // Helper UI Toast
        function showToast(message, isError = false) {
            const toast = document.getElementById('toastMessage');
            const toastText = document.getElementById('toastText');
            const toastIcon = document.getElementById('toastIcon');
            toastText.innerText = message;
            if(isError) {
                toastIcon.className = "fas fa-exclamation-triangle text-orange-500";
                toast.style.borderLeftColor = "#f97316";
            } else {
                toastIcon.className = "fas fa-check-circle text-green-500";
                toast.style.borderLeftColor = "#22c55e";
            }
            toast.classList.remove('hidden');
            setTimeout(() => {
                toast.classList.add('hidden');
            }, 3000);
        }
        
        // Update UI berdasarkan login status
        function updateNavbarAuth() {
            if(currentUser) {
                openSignInBtn.classList.add('hidden');
                userAvatar.classList.remove('hidden');
                userNameDisplay.innerText = currentUser.name.split(' ')[0] || currentUser.name;
            } else {
                openSignInBtn.classList.remove('hidden');
                userAvatar.classList.add('hidden');
            }
        }
        
        // Simpan user & update state
        function setCurrentUser(user) {
            currentUser = user;
            if(user) {
                localStorage.setItem('bioskop_user', JSON.stringify(user));
            } else {
                localStorage.removeItem('bioskop_user');
            }
            updateNavbarAuth();
        }
        
        // Login logic
        function handleLogin(email, password) {
            const users = JSON.parse(localStorage.getItem('bioskop_users') || '[]');
            const foundUser = users.find(u => u.email === email && u.password === password);
            if(foundUser) {
                setCurrentUser({ name: foundUser.name, email: foundUser.email });
                showToast(`Selamat datang kembali, ${foundUser.name}!`);
                closeModal();
                return true;
            } else {
                showToast("Email atau kata sandi salah.", true);
                return false;
            }
        }
        
        // Register logic
        function handleRegister(name, email, password, confirm) {
            if(!name.trim()) { showToast("Nama lengkap harus diisi.", true); return false; }
            if(!email.includes('@')) { showToast("Email tidak valid.", true); return false; }
            if(password.length < 6) { showToast("Kata sandi minimal 6 karakter.", true); return false; }
            if(password !== confirm) { showToast("Konfirmasi kata sandi tidak cocok.", true); return false; }
            
            const users = JSON.parse(localStorage.getItem('bioskop_users') || '[]');
            if(users.find(u => u.email === email)) {
                showToast("Email sudah terdaftar, silakan login.", true);
                return false;
            }
            const newUser = { name: name.trim(), email, password };
            users.push(newUser);
            localStorage.setItem('bioskop_users', JSON.stringify(users));
            // Auto login setelah register
            setCurrentUser({ name: newUser.name, email: newUser.email });
            showToast(`Pendaftaran berhasil! Selamat menikmati, ${newUser.name}.`);
            closeModal();
            return true;
        }
        
        function logout() {
            setCurrentUser(null);
            showToast("Anda telah logout.");
        }
        
        // Modal control
        function openModal() {
            modal.classList.remove('hidden');
            // reset ke tab login
            loginTab.click();
        }
        function closeModal() {
            modal.classList.add('hidden');
            // reset input fields agar bersih saat buka lagi
            document.getElementById('loginEmail').value = '';
            document.getElementById('loginPassword').value = '';
            document.getElementById('regName').value = '';
            document.getElementById('regEmail').value = '';
            document.getElementById('regPassword').value = '';
            document.getElementById('regConfirmPassword').value = '';
        }
        
        // Tab switching
        function setActiveTab(isLogin) {
            if(isLogin) {
                loginTab.classList.add('border-red-500', 'text-red-400');
                loginTab.classList.remove('border-transparent', 'text-gray-400');
                registerTab.classList.remove('border-red-500', 'text-red-400');
                registerTab.classList.add('border-transparent', 'text-gray-400');
                loginFormDiv.classList.remove('hidden');
                registerFormDiv.classList.add('hidden');
            } else {
                registerTab.classList.add('border-red-500', 'text-red-400');
                registerTab.classList.remove('border-transparent', 'text-gray-400');
                loginTab.classList.remove('border-red-500', 'text-red-400');
                loginTab.classList.add('border-transparent', 'text-gray-400');
                registerFormDiv.classList.remove('hidden');
                loginFormDiv.classList.add('hidden');
            }
        }
        
        // Event Listeners
        openSignInBtn.addEventListener('click', openModal);
        closeModalBtn.addEventListener('click', closeModal);
        modal.addEventListener('click', (e) => { if(e.target === modal) closeModal(); });
        
        loginTab.addEventListener('click', () => setActiveTab(true));
        registerTab.addEventListener('click', () => setActiveTab(false));
        switchToRegister.addEventListener('click', () => setActiveTab(false));
        switchToLogin.addEventListener('click', () => setActiveTab(true));
        
        doLoginBtn.addEventListener('click', () => {
            const email = document.getElementById('loginEmail').value;
            const password = document.getElementById('loginPassword').value;
            if(email && password) handleLogin(email, password);
            else showToast("Harap isi email dan kata sandi.", true);
        });
        
        doRegisterBtn.addEventListener('click', () => {
            const name = document.getElementById('regName').value;
            const email = document.getElementById('regEmail').value;
            const pwd = document.getElementById('regPassword').value;
            const confirm = document.getElementById('regConfirmPassword').value;
            handleRegister(name, email, pwd, confirm);
        });
        
        logoutBtn.addEventListener('click', () => {
            logout();
        });
        
        // Enter key handling untuk form di dalam modal
        const loginPass = document.getElementById('loginPassword');
        const regConfirm = document.getElementById('regConfirmPassword');
        loginPass.addEventListener('keypress', (e) => { if(e.key === 'Enter') doLoginBtn.click(); });
        regConfirm.addEventListener('keypress', (e) => { if(e.key === 'Enter') doRegisterBtn.click(); });
        
        //navbar
        updateNavbarAuth();
        
        // Smooth scrolling untuk navbar links (tetap mempertahankan interaksi)
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                if(href === "#" || href === "") return;
                const target = document.querySelector(href);
                if(target) {
                    e.preventDefault();
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });
    </script>
</body>
</html>