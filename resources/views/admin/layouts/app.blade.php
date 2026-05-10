<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Panel | @yield('title', 'CTIX.ID')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        * { font-family: 'Poppins', sans-serif; }
        .sidebar-link { transition: all 0.2s; }
        .sidebar-link:hover { background: rgba(239,68,68,0.08); color: #dc2626; }
        .sidebar-link.active { background: rgba(239,68,68,0.12); color: #dc2626; font-weight: 600; }
        .sidebar-link.active i { color: #dc2626; }
    </style>
    @stack('styles')
</head>

<body class="bg-gray-100 text-gray-900">
<div class="flex h-screen overflow-hidden">

    {{-- ===== SIDEBAR ===== --}}
    <aside id="sidebar"
           class="w-64 bg-white border-r border-gray-200 flex flex-col fixed inset-y-0 left-0 z-40 shadow-sm transition-transform duration-300">

        {{-- Logo --}}
        <div class="flex items-center gap-3 px-5 py-4 border-b border-gray-100">
            <div class="w-9 h-9 bg-gradient-to-br from-red-500 to-orange-500 rounded-xl flex items-center justify-center">
                <i class="fas fa-film text-white text-sm"></i>
            </div>
            <div>
                <h1 class="text-lg font-black leading-none">CTIX<span class="text-red-500">ID</span></h1>
                <p class="text-xs text-gray-400">Admin Panel</p>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 px-3 py-4 space-y-0.5 overflow-y-auto">

            {{-- Dashboard --}}
            <a href="{{ route('admin.dashboard') }}"
               class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-gray-600
                      {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-chart-pie w-4 text-center text-gray-400"></i>
                Dashboard
            </a>

            {{-- Konten --}}
            <div class="pt-4 pb-1 px-2">
                <p class="text-xs font-bold text-gray-300 uppercase tracking-wider">Konten</p>
            </div>

            <a href="{{ route('admin.films.index') }}"
               class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-gray-600
                      {{ request()->routeIs('admin.films.*') ? 'active' : '' }}">
                <i class="fas fa-film w-4 text-center text-gray-400"></i>
                Manajemen Film
            </a>

            <a href="{{ route('admin.jadwal.index') }}"
               class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-gray-600
                      {{ request()->routeIs('admin.jadwal.*') ? 'active' : '' }}">
                <i class="fas fa-calendar-alt w-4 text-center text-gray-400"></i>
                Manajemen Jadwal
            </a>

            <a href="{{ route('admin.kursi.index') }}"
               class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-gray-600
                      {{ request()->routeIs('admin.kursi.*') ? 'active' : '' }}">
                <i class="fas fa-chair w-4 text-center text-gray-400"></i>
                Manajemen Kursi
            </a>

            {{-- Transaksi --}}
            <div class="pt-4 pb-1 px-2">
                <p class="text-xs font-bold text-gray-300 uppercase tracking-wider">Transaksi</p>
            </div>

            @php $pendingCount = \App\Models\Booking::where('status','pending')->count(); @endphp

            <a href="{{ route('admin.bookings.index') }}"
               class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-gray-600
                      {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
                <i class="fas fa-ticket-alt w-4 text-center text-gray-400"></i>
                Pemesanan
                @if($pendingCount > 0)
                <span class="ml-auto bg-red-500 text-white text-xs font-bold px-1.5 py-0.5 rounded-full">
                    {{ $pendingCount }}
                </span>
                @endif
            </a>

            <a href="{{ route('admin.laporan.index') }}"
               class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-gray-600
                      {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
                <i class="fas fa-chart-bar w-4 text-center text-gray-400"></i>
                Laporan
            </a>

            {{-- Lainnya --}}
            <div class="pt-4 pb-1 px-2">
                <p class="text-xs font-bold text-gray-300 uppercase tracking-wider">Lainnya</p>
            </div>

            <a href="{{ route('home') }}" target="_blank"
               class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-gray-600">
                <i class="fas fa-external-link-alt w-4 text-center text-gray-400"></i>
                Lihat Website
            </a>

        </nav>

        {{-- User Info --}}
        <div class="px-4 py-3 border-t border-gray-100 bg-gray-50">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-gradient-to-br from-red-500 to-orange-400 rounded-full flex items-center justify-center flex-shrink-0">
                    <span class="text-white text-sm font-bold">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-800 truncate">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-red-500 font-medium">Administrator</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" title="Logout"
                            class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-red-50 text-gray-400 hover:text-red-600 transition">
                        <i class="fas fa-sign-out-alt text-sm"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    {{-- ===== MAIN AREA ===== --}}
    <div class="flex-1 flex flex-col ml-64 min-h-screen overflow-y-auto">

        {{-- Header --}}
        <header class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between sticky top-0 z-30 shadow-sm">
            <div class="flex items-center gap-4">
                <button onclick="toggleSidebar()"
                        class="w-9 h-9 flex items-center justify-center rounded-xl hover:bg-gray-100 text-gray-500 transition">
                    <i class="fas fa-bars"></i>
                </button>
                <div>
                    <h2 class="text-base font-bold text-gray-900">@yield('title', 'Dashboard')</h2>
                    <p class="text-xs text-gray-400">
                        {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                @if($pendingCount > 0)
                <a href="{{ route('admin.bookings.index') }}"
                   class="relative w-9 h-9 flex items-center justify-center rounded-xl bg-red-50 text-red-600 hover:bg-red-100 transition">
                    <i class="fas fa-bell text-sm"></i>
                    <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center">
                        {{ $pendingCount }}
                    </span>
                </a>
                @endif

                <div class="flex items-center gap-2 bg-gray-50 border border-gray-200 rounded-xl px-3 py-2">
                    <div class="w-7 h-7 bg-gradient-to-br from-red-500 to-orange-400 rounded-full flex items-center justify-center">
                        <span class="text-white text-xs font-bold">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </span>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-800 leading-none">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-red-500">Administrator</p>
                    </div>
                </div>
            </div>
        </header>

        {{-- Flash Messages --}}
        @if(session('success'))
        <div class="mx-6 mt-4 bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 flex items-center gap-2 text-sm">
            <i class="fas fa-check-circle text-green-500 flex-shrink-0"></i>
            {{ session('success') }}
            <button onclick="this.parentElement.remove()" class="ml-auto text-green-400 hover:text-green-600">
                <i class="fas fa-times text-xs"></i>
            </button>
        </div>
        @endif

        @if(session('error'))
        <div class="mx-6 mt-4 bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 flex items-center gap-2 text-sm">
            <i class="fas fa-exclamation-circle text-red-500 flex-shrink-0"></i>
            {{ session('error') }}
            <button onclick="this.parentElement.remove()" class="ml-auto text-red-400 hover:text-red-600">
                <i class="fas fa-times text-xs"></i>
            </button>
        </div>
        @endif

        {{-- Page Content --}}
        <main class="flex-1 p-6">
            @yield('content')
        </main>

        {{-- Footer --}}
        <footer class="px-6 py-4 border-t border-gray-200 bg-white">
            <p class="text-xs text-gray-400 text-center">
                &copy; 2026 CTIX.ID Admin Panel. All rights reserved.
            </p>
        </footer>
    </div>
</div>

<script>
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('-translate-x-full');
}
</script>

@stack('scripts')
</body>
</html>