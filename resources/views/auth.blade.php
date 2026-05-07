@extends('layouts.app')

@section('title', 'Masuk & Daftar')

@section('content')
<section class="min-h-screen flex items-center justify-center px-4 py-20">
    <div class="max-w-md w-full">
        <!-- Card Login/Register -->
        <div class="bg-gray-800/50 backdrop-blur-sm rounded-2xl border border-white/10 p-8">
            
            <!-- Tabs -->
            <div class="flex gap-2 mb-8 border-b border-white/10 pb-2">
                <button id="loginTabBtn" class="flex-1 py-2 text-center font-semibold transition-all border-b-2 border-red-500 text-red-500">
                    Masuk
                </button>
                <button id="registerTabBtn" class="flex-1 py-2 text-center font-semibold transition-all border-b-2 border-transparent text-gray-400 hover:text-white">
                    Daftar
                </button>
            </div>
            
            <!-- Form Login -->
            <div id="loginForm">
                <form id="loginFormElement">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm text-gray-400 mb-1">Email</label>
                            <input type="email" id="loginEmail" placeholder="contoh@email.com" 
                                class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-red-500 transition">
                        </div>
                        <div>
                            <label class="block text-sm text-gray-400 mb-1">Kata Sandi</label>
                            <input type="password" id="loginPassword" placeholder="••••••••" 
                                class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-red-500 transition">
                        </div>
                        <button type="submit" class="w-full bg-red-600 hover:bg-red-700 py-3 rounded-xl font-semibold transition">
                            <i class="fas fa-sign-in-alt mr-2"></i> Masuk
                        </button>
                    </div>
                </form>
                <p class="text-center text-gray-400 text-sm mt-4">
                    Belum punya akun? 
                    <button id="switchToRegister" class="text-red-500 hover:underline">Daftar sekarang</button>
                </p>
            </div>
            
            <!-- Form Register -->
            <div id="registerForm" class="hidden">
                <form id="registerFormElement">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm text-gray-400 mb-1">Nama Lengkap</label>
                            <input type="text" id="regName" placeholder="John Doe" 
                                class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-red-500 transition">
                        </div>
                        <div>
                            <label class="block text-sm text-gray-400 mb-1">Email</label>
                            <input type="email" id="regEmail" placeholder="contoh@email.com" 
                                class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-red-500 transition">
                        </div>
                        <div>
                            <label class="block text-sm text-gray-400 mb-1">Kata Sandi</label>
                            <input type="password" id="regPassword" placeholder="Minimal 6 karakter" 
                                class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-red-500 transition">
                        </div>
                        <div>
                            <label class="block text-sm text-gray-400 mb-1">Konfirmasi Sandi</label>
                            <input type="password" id="regConfirmPassword" placeholder="Ulangi sandi" 
                                class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-red-500 transition">
                        </div>
                        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 py-3 rounded-xl font-semibold transition">
                            <i class="fas fa-user-plus mr-2"></i> Daftar
                        </button>
                    </div>
                </form>
                <p class="text-center text-gray-400 text-sm mt-4">
                    Sudah punya akun? 
                    <button id="switchToLogin" class="text-red-500 hover:underline">Masuk disini</button>
                </p>
            </div>
            
        </div>
    </div>
</section>

<script>
    // Tab switching
    const loginTab = document.getElementById('loginTabBtn');
    const registerTab = document.getElementById('registerTabBtn');
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');
    
    function setActiveTab(isLogin) {
        if(isLogin) {
            loginTab.classList.add('border-red-500', 'text-red-500');
            loginTab.classList.remove('border-transparent', 'text-gray-400');
            registerTab.classList.remove('border-red-500', 'text-red-500');
            registerTab.classList.add('border-transparent', 'text-gray-400');
            loginForm.classList.remove('hidden');
            registerForm.classList.add('hidden');
        } else {
            registerTab.classList.add('border-red-500', 'text-red-500');
            registerTab.classList.remove('border-transparent', 'text-gray-400');
            loginTab.classList.remove('border-red-500', 'text-red-500');
            loginTab.classList.add('border-transparent', 'text-gray-400');
            registerForm.classList.remove('hidden');
            loginForm.classList.add('hidden');
        }
    }
    
    loginTab.addEventListener('click', () => setActiveTab(true));
    registerTab.addEventListener('click', () => setActiveTab(false));
    document.getElementById('switchToRegister')?.addEventListener('click', () => setActiveTab(false));
    document.getElementById('switchToLogin')?.addEventListener('click', () => setActiveTab(true));
    
    // Simulasi login dengan localStorage
    function showMessage(msg, isError = false) {
        const toast = document.createElement('div');
        toast.className = `fixed bottom-6 right-6 z-50 glass rounded-xl px-5 py-3 border-l-4 ${isError ? 'border-red-500' : 'border-green-500'} shadow-2xl animate-pulse`;
        toast.innerHTML = `<div class="flex items-center gap-3"><i class="fas ${isError ? 'fa-exclamation-triangle text-red-500' : 'fa-check-circle text-green-500'}"></i><span>${msg}</span></div>`;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 3000);
    }
    
    // Login handler
    document.getElementById('loginFormElement')?.addEventListener('submit', function(e) {
        e.preventDefault();
        const email = document.getElementById('loginEmail').value;
        const password = document.getElementById('loginPassword').value;
        
        if(!email || !password) {
            showMessage('Harap isi email dan password!', true);
            return;
        }
        
        // Simulasi cek user di localStorage
        const users = JSON.parse(localStorage.getItem('bioskop_users') || '[]');
        const user = users.find(u => u.email === email && u.password === password);
        
        if(user) {
            localStorage.setItem('bioskop_current_user', JSON.stringify(user));
            showMessage(`Selamat datang ${user.name}!`);
            setTimeout(() => {
                window.location.href = "{{ route('home') }}";
            }, 1000);
        } else {
            showMessage('Email atau password salah!', true);
        }
    });
    
    // Register handler
    document.getElementById('registerFormElement')?.addEventListener('submit', function(e) {
        e.preventDefault();
        const name = document.getElementById('regName').value;
        const email = document.getElementById('regEmail').value;
        const password = document.getElementById('regPassword').value;
        const confirm = document.getElementById('regConfirmPassword').value;
        
        if(!name || !email || !password) {
            showMessage('Harap isi semua field!', true);
            return;
        }
        if(password.length < 6) {
            showMessage('Password minimal 6 karakter!', true);
            return;
        }
        if(password !== confirm) {
            showMessage('Konfirmasi password tidak cocok!', true);
            return;
        }
        
        const users = JSON.parse(localStorage.getItem('bioskop_users') || '[]');
        if(users.find(u => u.email === email)) {
            showMessage('Email sudah terdaftar!', true);
            return;
        }
        
        const newUser = { name, email, password };
        users.push(newUser);
        localStorage.setItem('bioskop_users', JSON.stringify(users));
        localStorage.setItem('bioskop_current_user', JSON.stringify(newUser));
        
        showMessage('Pendaftaran berhasil! Selamat datang!');
        setTimeout(() => {
            window.location.href = "{{ route('home') }}";
        }, 1000);
    });
</script>
@endsection