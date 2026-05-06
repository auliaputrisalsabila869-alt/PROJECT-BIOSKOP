@extends('layouts.app')

@section('content')

<!-- MAIN AUTH SECTION -->
<section class="min-h-screen bg-gray-900 flex items-center justify-center relative overflow-hidden px-4 py-8">

    <!-- Background Decorative Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-32 -left-32 w-96 h-96 bg-red-600/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-red-800/10 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-red-900/5 rounded-full blur-3xl"></div>
        <!-- Grid pattern -->
        <div class="absolute inset-0 opacity-5"
            style="background-image: linear-gradient(#dc2626 1px, transparent 1px), linear-gradient(90deg, #dc2626 1px, transparent 1px); background-size: 50px 50px;">
        </div>
    </div>

    <div class="relative w-full max-w-md mx-auto animate-fade-in-up">
        <div class="bg-gray-800/60 backdrop-blur-sm border border-gray-700/50 rounded-2xl p-8 shadow-2xl">

            <!-- Form Header -->
            <div class="mb-6">
                <div class="inline-flex items-center gap-2 bg-red-600/10 border border-red-600/20 rounded-full px-3 py-1 mb-4">
                    <div class="w-2 h-2 bg-red-500 rounded-full animate-pulse"></div>
                    <span class="text-red-400 text-xs font-semibold tracking-wide uppercase">Login</span>
                </div>
                <h3 class="text-2xl font-bold text-white">Masuk ke Akun</h3>
                <p class="text-gray-400 text-sm mt-1">Silakan masukkan email dan password Anda</p>
            </div>

            <!-- Alert Error -->
            @if ($errors->any())
                <div class="bg-red-900/40 border border-red-700/50 rounded-xl p-4 mb-5 flex items-start gap-3">
                    <i class="fas fa-exclamation-circle text-red-400 mt-0.5 flex-shrink-0"></i>
                    <div class="text-red-300 text-sm">
                        {{ $errors->first() }}
                    </div>
                </div>
            @endif

            <!-- Success Message -->
            @if (session('success'))
                <div class="bg-green-900/40 border border-green-700/50 rounded-xl p-4 mb-5 flex items-start gap-3">
                    <i class="fas fa-check-circle text-green-400 mt-0.5 flex-shrink-0"></i>
                    <div class="text-green-300 text-sm">{{ session('success') }}</div>
                </div>
            @endif

            <!-- Form -->
            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1.5">Email</label>
                    <div class="relative">
                        <i class="fas fa-envelope absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-500 text-sm"></i>
                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="nama@email.com"
                            autocomplete="email"
                            class="w-full bg-gray-900/70 border @error('email') border-red-500 @else border-gray-700 @enderror
                                   rounded-xl py-3 pl-10 pr-4 text-white placeholder-gray-500
                                   focus:outline-none focus:border-red-500 focus:bg-gray-900 transition text-sm"
                        >
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1.5">Password</label>
                    <div class="relative">
                        <i class="fas fa-lock absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-500 text-sm"></i>
                        <input
                            type="password"
                            name="password"
                            id="passwordInput"
                            placeholder="••••••••"
                            autocomplete="current-password"
                            class="w-full bg-gray-900/70 border @error('password') border-red-500 @else border-gray-700 @enderror
                                   rounded-xl py-3 pl-10 pr-12 text-white placeholder-gray-500
                                   focus:outline-none focus:border-red-500 focus:bg-gray-900 transition text-sm"
                        >
                        <button type="button" onclick="togglePassword()" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-300 transition">
                            <i id="eyeIcon" class="fas fa-eye text-sm"></i>
                        </button>
                    </div>
                </div>

                <!-- Ingat Saya & Lupa Password -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <div class="relative">
                            <input type="checkbox" name="remember" class="peer sr-only">
                            <div class="w-4 h-4 border-2 border-gray-600 rounded peer-checked:bg-red-600 peer-checked:border-red-600 transition"></div>
                            <i class="fas fa-check text-white text-[10px] absolute top-[1px] left-[1px] hidden peer-checked:block pointer-events-none"></i>
                        </div>
                        <span class="text-gray-400 text-sm group-hover:text-gray-300 transition">Ingat saya</span>
                    </label>
                    <a href="#" class="text-red-500 text-sm hover:text-red-400 transition">Lupa password?</a>
                </div>

                <!-- Submit -->
                <button
                    type="submit"
                    class="w-full bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800
                           text-white font-bold py-3 rounded-xl transition shadow-lg shadow-red-900/30
                           flex items-center justify-center gap-2 group">
                    <span>Masuk Sekarang</span>
                    <i class="fas fa-arrow-right text-sm group-hover:translate-x-1 transition-transform"></i>
                </button>
            </form>

            <!-- Divider -->
            <div class="flex items-center gap-3 my-5">
                <div class="flex-1 h-px bg-gray-700"></div>
                <span class="text-gray-500 text-xs">atau</span>
                <div class="flex-1 h-px bg-gray-700"></div>
            </div>

            <!-- Daftar Link -->
            <p class="text-center text-sm text-gray-400">
                Belum punya akun?
                <a href="{{ route('daftar') }}" class="text-red-500 font-semibold hover:text-red-400 transition ml-1">
                    Daftar Gratis
                    <i class="fas fa-external-link-alt text-xs ml-1"></i>
                </a>
            </p>

        </div>
    </div>

</section>

<!-- FOOTER MINI -->
<footer class="bg-black border-t border-gray-800 py-4">
    <div class="container mx-auto px-4 text-center text-gray-500 text-xs">
        &copy; 2026 CTIX.ID Lampung. All rights reserved.
    </div>
</footer>

<!-- Animations & Scripts -->
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-up   { animation: fadeInUp 0.7s ease-out both; }

    html { scroll-behavior: smooth; }
    ::-webkit-scrollbar { width: 8px; height: 8px; }
    ::-webkit-scrollbar-track { background: #1a1a1a; }
    ::-webkit-scrollbar-thumb { background: #dc2626; border-radius: 4px; }
    ::-webkit-scrollbar-thumb:hover { background: #b91c1c; }
</style>

<script>
// Toggle password visibility
function togglePassword() {
    const input = document.getElementById('passwordInput');
    const icon  = document.getElementById('eyeIcon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}

// Navbar scroll effect
window.addEventListener('scroll', () => {
    const nav = document.querySelector('nav');
    if (window.scrollY > 50) {
        nav.classList.add('bg-black/95', 'backdrop-blur-md');
    } else {
        nav.classList.remove('bg-black/95', 'backdrop-blur-md');
    }
});
</script>

@endsection