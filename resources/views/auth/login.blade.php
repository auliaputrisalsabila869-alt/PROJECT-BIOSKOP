@extends('layouts.app')

@section('content')

<!-- MAIN AUTH SECTION - LIGHT THEME -->
<section class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-gray-100 flex items-center justify-center relative overflow-hidden px-4 py-8">

    <!-- Background Decorative - Light -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-32 -left-32 w-96 h-96 bg-red-100/60 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-orange-100/60 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-red-50/40 rounded-full blur-3xl"></div>
        <!-- Grid pattern light -->
        <div class="absolute inset-0 opacity-[0.03]"
            style="background-image: linear-gradient(#dc2626 1px, transparent 1px), linear-gradient(90deg, #dc2626 1px, transparent 1px); background-size: 50px 50px;">
        </div>
    </div>

    <div class="relative w-full max-w-md mx-auto animate-fade-in-up">
        <div class="bg-white/90 backdrop-blur-sm border border-gray-200 rounded-2xl p-8 shadow-xl shadow-gray-200/50">

            <!-- Form Header -->
            <div class="mb-6 text-center">
                <div class="inline-flex items-center gap-2 bg-red-50 border border-red-200 rounded-full px-4 py-1.5 mb-4">
                    <div class="w-2 h-2 bg-red-500 rounded-full animate-pulse"></div>
                    <span class="text-red-600 text-xs font-semibold tracking-wide uppercase">Login</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900">Masuk ke Akun</h3>
                <p class="text-gray-500 text-sm mt-1">Silakan masukkan email dan password Anda</p>
            </div>

            <!-- Alert Error -->
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-5 flex items-start gap-3">
                    <i class="fas fa-exclamation-circle text-red-500 mt-0.5 flex-shrink-0"></i>
                    <div class="text-red-600 text-sm">
                        {{ $errors->first() }}
                    </div>
                </div>
            @endif

            <!-- Success Message -->
            @if (session('success'))
                <div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-5 flex items-start gap-3">
                    <i class="fas fa-check-circle text-green-500 mt-0.5 flex-shrink-0"></i>
                    <div class="text-green-600 text-sm">{{ session('success') }}</div>
                </div>
            @endif

            <!-- Form -->
            <form method="POST" action="{{ route('login.process') }}" class="space-y-5">
                @csrf

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                    <div class="relative">
                        <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="nama@email.com"
                            autocomplete="email"
                            class="w-full bg-gray-50 border @error('email') border-red-400 @else border-gray-300 @enderror
                                   rounded-xl py-3 pl-11 pr-4 text-gray-900 placeholder-gray-400
                                   focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-100 focus:bg-white transition text-sm"
                        >
                    </div>
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                    <div class="relative">
                        <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                        <input
                            type="password"
                            name="password"
                            id="passwordInput"
                            placeholder="••••••••"
                            autocomplete="current-password"
                            class="w-full bg-gray-50 border @error('password') border-red-400 @else border-gray-300 @enderror
                                   rounded-xl py-3 pl-11 pr-12 text-gray-900 placeholder-gray-400
                                   focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-100 focus:bg-white transition text-sm"
                        >
                        <button type="button" onclick="togglePassword()" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition">
                            <i id="eyeIcon" class="fas fa-eye text-sm"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Ingat Saya & Lupa Password -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <div class="relative">
                            <input type="checkbox" name="remember" class="peer sr-only">
                            <div class="w-4 h-4 border-2 border-gray-300 rounded peer-checked:bg-red-500 peer-checked:border-red-500 transition"></div>
                            <i class="fas fa-check text-white text-[10px] absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 hidden peer-checked:block pointer-events-none"></i>
                        </div>
                        <span class="text-gray-600 text-sm group-hover:text-gray-800 transition">Ingat saya</span>
                    </label>
                    <a href="#" class="text-red-600 text-sm hover:text-red-700 font-medium transition">Lupa password?</a>
                </div>

                <!-- Submit -->
                <button
                    type="submit"
                    class="w-full bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700
                           text-white font-semibold py-3 rounded-xl transition shadow-lg shadow-red-200
                           flex items-center justify-center gap-2 group">
                    <span>Masuk Sekarang</span>
                    <i class="fas fa-arrow-right text-sm group-hover:translate-x-1 transition-transform"></i>
                </button>
            </form>

            <!-- Divider -->
            <div class="flex items-center gap-3 my-6">
                <div class="flex-1 h-px bg-gray-200"></div>
                <span class="text-gray-400 text-xs">atau</span>
                <div class="flex-1 h-px bg-gray-200"></div>
            </div>

            <!-- Daftar Link -->
            <p class="text-center text-sm text-gray-500">
                Belum punya akun?
                <a href="{{ route('daftar') }}" class="text-red-600 font-semibold hover:text-red-700 transition ml-1">
                    Daftar Gratis
                    <i class="fas fa-external-link-alt text-xs ml-1"></i>
                </a>
            </p>

        </div>
    </div>

</section>

<!-- FOOTER MINI - LIGHT -->
<footer class="bg-white border-t border-gray-200 py-4">
    <div class="container mx-auto px-4 text-center text-gray-400 text-xs">
        &copy; 2026 CTIX.ID Lampung. All rights reserved.
    </div>
</footer>

<!-- Animations & Scripts -->
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-up { animation: fadeInUp 0.7s ease-out both; }

    html { scroll-behavior: smooth; }
    ::-webkit-scrollbar { width: 8px; height: 8px; }
    ::-webkit-scrollbar-track { background: #f1f1f1; }
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
</script>

@endsection