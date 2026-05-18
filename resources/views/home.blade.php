@extends('layouts.app')

@section('content')

{{-- HERO SECTION --}}
<section class="relative pt-20 min-h-screen flex items-center overflow-hidden bg-white">

    {{-- Animated Background --}}
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        {{-- Orb animasi --}}
        <div class="absolute -top-40 -left-40 w-[600px] h-[600px] bg-red-100 rounded-full opacity-40"
             style="animation: floatOrb1 8s ease-in-out infinite;"></div>
        <div class="absolute -bottom-40 -right-40 w-[500px] h-[500px] bg-orange-100 rounded-full opacity-30"
             style="animation: floatOrb2 10s ease-in-out infinite;"></div>
        <div class="absolute top-1/3 right-1/4 w-64 h-64 bg-red-50 rounded-full opacity-50"
             style="animation: floatOrb3 6s ease-in-out infinite;"></div>

        {{-- Grid pattern --}}
        <div class="absolute inset-0 opacity-[0.03]"
             style="background-image: linear-gradient(#dc2626 1px, transparent 1px), linear-gradient(90deg, #dc2626 1px, transparent 1px); background-size: 60px 60px;"></div>

        {{-- Film strip decorasi kiri --}}
        <div class="absolute left-0 top-0 bottom-0 w-16 opacity-5">
            @for($i = 0; $i < 20; $i++)
            <div class="w-10 h-7 border-2 border-gray-900 mx-auto mb-1 mt-1 rounded-sm"></div>
            @endfor
        </div>
        {{-- Film strip decorasi kanan --}}
        <div class="absolute right-0 top-0 bottom-0 w-16 opacity-5">
            @for($i = 0; $i < 20; $i++)
            <div class="w-10 h-7 border-2 border-gray-900 mx-auto mb-1 mt-1 rounded-sm"></div>
            @endfor
        </div>
    </div>

    <div class="relative container mx-auto px-6 py-20 text-center">

        {{-- Badge --}}
        <div class="inline-flex items-center gap-2 bg-red-50 border border-red-200 rounded-full px-4 py-1.5 mb-6"
             style="animation: fadeInDown 0.6s ease-out both;">
            <div class="w-2 h-2 bg-red-500 rounded-full" style="animation: pulse 2s infinite;"></div>
            <span class="text-red-600 text-xs font-bold tracking-widest uppercase">Now Showing</span>
        </div>

        {{-- Headline --}}
        <h1 class="text-6xl md:text-8xl font-black mb-6 leading-none"
            style="animation: fadeInUp 0.7s ease-out 0.1s both;">
            <span class="text-gray-900">Feel the</span><br>
            <span class="bg-gradient-to-r from-red-600 via-red-500 to-orange-500 bg-clip-text text-transparent"
                  style="animation: shimmer 3s ease-in-out infinite;">Memories</span>
        </h1>

        <p class="text-gray-500 text-xl max-w-xl mx-auto mb-10"
           style="animation: fadeInUp 0.7s ease-out 0.2s both;">
            Melampaui pengalaman menonton film biasa. Nikmati film terbaik dengan kualitas premium.
        </p>

        {{-- Search Bar --}}
        <div class="relative max-w-2xl mx-auto mb-12"
             style="animation: fadeInUp 0.7s ease-out 0.3s both;">
            <form action="{{ route('films.index') }}" method="GET">
                <div class="relative group">
                    <i class="fas fa-search absolute left-5 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-red-500 transition-colors text-lg"></i>
                    <input type="text" name="search"
                           placeholder="Cari film, genre, sutradara..."
                           class="w-full bg-white border-2 border-gray-200 focus:border-red-500 rounded-2xl py-4 pl-14 pr-6 text-gray-900 placeholder-gray-400 focus:outline-none transition-all text-base shadow-lg focus:shadow-red-100">
                    <button type="submit"
                            class="absolute right-2 top-1/2 -translate-y-1/2 bg-red-600 hover:bg-red-700 text-white px-6 py-2.5 rounded-xl font-semibold transition text-sm">
                        Cari
                    </button>
                </div>
            </form>

            {{-- Quick links --}}
            <div class="flex flex-wrap justify-center gap-2 mt-3">
                @foreach(['Drama', 'Horror', 'Action', 'Comedy', 'Animation'] as $genre)
                <a href="{{ route('films.index', ['search' => $genre]) }}"
                   class="text-xs text-gray-400 hover:text-red-600 bg-gray-50 hover:bg-red-50 border border-gray-200 hover:border-red-200 px-3 py-1 rounded-full transition">
                    {{ $genre }}
                </a>
                @endforeach
            </div>
        </div>

        {{-- CTA Buttons --}}
        <div class="flex flex-wrap justify-center gap-4 mb-16"
             style="animation: fadeInUp 0.7s ease-out 0.4s both;">
            <a href="{{ route('films.index') }}"
               class="group bg-red-600 hover:bg-red-700 text-white px-8 py-4 rounded-2xl font-bold text-base transition-all shadow-lg shadow-red-200 hover:shadow-xl hover:shadow-red-300 hover:-translate-y-0.5 flex items-center gap-2">
                <i class="fas fa-film"></i>
                Lihat Semua Film
                <i class="fas fa-arrow-right text-sm group-hover:translate-x-1 transition-transform"></i>
            </a>
            @guest
            <a href="{{ route('daftar') }}"
               class="group bg-white hover:bg-gray-50 text-gray-800 border-2 border-gray-200 hover:border-red-300 px-8 py-4 rounded-2xl font-bold text-base transition-all hover:-translate-y-0.5 flex items-center gap-2">
                <i class="fas fa-user-plus text-red-500"></i>
                Daftar Gratis
            </a>
            @endguest
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 max-w-3xl mx-auto"
             style="animation: fadeInUp 0.7s ease-out 0.5s both;">
            @foreach([
                ['icon' => 'fa-film', 'val' => '150+', 'label' => 'Film Tersedia'],
                ['icon' => 'fa-building', 'val' => '3', 'label' => 'Studio'],
                ['icon' => 'fa-users', 'val' => '2M+', 'label' => 'Penonton Puas'],
                ['icon' => 'fa-ticket-alt', 'val' => '500K+', 'label' => 'Tiket Terjual'],
            ] as $stat)
            <div class="group bg-white border border-gray-100 rounded-2xl p-4 hover:border-red-200 hover:shadow-lg hover:-translate-y-1 transition-all cursor-default"
                 style="animation: fadeInUp 0.5s ease-out both;">
                <i class="fas {{ $stat['icon'] }} text-2xl text-red-500 mb-2 block group-hover:scale-110 transition-transform"></i>
                <div class="text-2xl font-black text-gray-900">{{ $stat['val'] }}</div>
                <div class="text-gray-400 text-xs mt-0.5">{{ $stat['label'] }}</div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Scroll indicator --}}
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2"
         style="animation: bounce 2s infinite;">
        <div class="w-6 h-10 border-2 border-gray-300 rounded-full flex justify-center pt-2">
            <div class="w-1.5 h-3 bg-red-400 rounded-full"
                 style="animation: scrollDot 1.5s ease-in-out infinite;"></div>
        </div>
    </div>
</section>

{{-- NOW SHOWING SECTION --}}
<section class="py-16 bg-white">
    <div class="container mx-auto px-6">

        {{-- Section Header --}}
        <div class="flex justify-between items-end mb-8">
            <div>
                <span class="text-red-500 text-sm font-bold uppercase tracking-widest">Sedang Tayang</span>
                <h2 class="text-3xl font-black text-gray-900 mt-1">Film Pilihan</h2>
                <div class="w-12 h-1 bg-red-600 rounded-full mt-2"></div>
            </div>
            <a href="{{ route('films.index') }}"
               class="text-red-600 hover:text-red-700 font-semibold text-sm flex items-center gap-1 transition group">
                Lihat semua
                <i class="fas fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
            </a>
        </div>

        {{-- Film Grid dari Database --}}
        @php
            $nowShowing = \App\Models\Film::where('status', 'now_showing')
                ->latest()->take(5)->get();
        @endphp

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-5">
            @forelse($nowShowing as $index => $film)
            @php $slug = \Illuminate\Support\Str::slug($film->judul); @endphp
            <div class="group cursor-pointer"
                 onclick="window.location='{{ route('films.show', $slug) }}'"
                 style="animation: fadeInUp 0.5s ease-out {{ $index * 0.1 }}s both;">

                <div class="relative overflow-hidden rounded-xl mb-3 shadow-sm aspect-[2/3]">
                    @if($film->poster)
                    <img src="{{ $film->poster }}" alt="{{ $film->judul }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                         onerror="this.parentElement.innerHTML='<div class=\'w-full h-full bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center\'><i class=\'fas fa-film text-5xl text-gray-400\'></i></div>'">
                    @else
                    <div class="w-full h-full bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center">
                        <i class="fas fa-film text-5xl text-gray-400"></i>
                    </div>
                    @endif

                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition duration-300"></div>

                    <div class="absolute bottom-0 left-0 right-0 p-3 translate-y-full group-hover:translate-y-0 transition duration-300">
                        <a href="{{ route('films.show', $slug) }}"
                           class="block w-full bg-red-600 hover:bg-red-700 text-white text-xs font-bold py-2 rounded-lg text-center"
                           onclick="event.stopPropagation()">
                            <i class="fas fa-ticket-alt mr-1"></i> Pesan Tiket
                        </a>
                    </div>

                    @if($film->age_rating)
                    <div class="absolute top-2 right-2 bg-red-600 text-white text-xs font-bold px-1.5 py-0.5 rounded">
                        {{ $film->age_rating }}
                    </div>
                    @endif

                    @if($film->rating > 0)
                    <div class="absolute bottom-2 left-2 bg-black/70 backdrop-blur-sm px-2 py-1 rounded-lg flex items-center gap-1">
                        <i class="fas fa-star text-yellow-400 text-xs"></i>
                        <span class="text-white text-xs font-bold">{{ $film->rating }}</span>
                    </div>
                    @endif
                </div>

                <h3 class="text-gray-900 font-bold text-sm group-hover:text-red-600 transition line-clamp-1">
                    {{ $film->judul }}
                </h3>
                <div class="flex items-center gap-1 mt-0.5">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= floor($film->rating))
                            <i class="fas fa-star text-yellow-400 text-xs"></i>
                        @elseif($i - 0.5 <= $film->rating)
                            <i class="fas fa-star-half-alt text-yellow-400 text-xs"></i>
                        @else
                            <i class="far fa-star text-gray-300 text-xs"></i>
                        @endif
                    @endfor
                    @if($film->rating_count > 0)
                    <span class="text-gray-400 text-xs ml-1">({{ number_format($film->rating_count/1000, 1) }}k)</span>
                    @endif
                </div>
                <p class="text-gray-400 text-xs mt-0.5">{{ $film->genre }} · {{ $film->durasi }} menit</p>
            </div>
            @empty
            <div class="col-span-5 text-center py-12 text-gray-400">
                <i class="fas fa-film text-5xl mb-3 block"></i>
                <p>Belum ada film yang sedang tayang</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

{{-- COMING SOON SECTION --}}
@php
    $comingSoon = \App\Models\Film::where('status', 'coming_soon')->take(4)->get();
@endphp
@if($comingSoon->count() > 0)
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-6">
        <div class="flex justify-between items-end mb-8">
            <div>
                <span class="text-orange-500 text-sm font-bold uppercase tracking-widest">Segera Hadir</span>
                <h2 class="text-3xl font-black text-gray-900 mt-1">Coming Soon</h2>
                <div class="w-12 h-1 bg-orange-500 rounded-full mt-2"></div>
            </div>
            <a href="{{ route('films.index') }}"
               class="text-orange-500 hover:text-orange-600 font-semibold text-sm flex items-center gap-1 transition group">
                Lihat semua
                <i class="fas fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
            </a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
            @foreach($comingSoon as $index => $film)
            @php $slug = \Illuminate\Support\Str::slug($film->judul); @endphp
            <div class="group cursor-pointer"
                 onclick="window.location='{{ route('films.show', $slug) }}'"
                 style="animation: fadeInUp 0.5s ease-out {{ $index * 0.1 }}s both;">
                <div class="relative overflow-hidden rounded-xl mb-3 shadow-sm aspect-[2/3]">
                    @if($film->poster)
                    <img src="{{ $film->poster }}" alt="{{ $film->judul }}"
                         class="w-full h-full object-cover filter brightness-75 group-hover:brightness-90 transition duration-500">
                    @else
                    <div class="w-full h-full bg-gradient-to-br from-gray-600 to-gray-800 flex items-center justify-center">
                        <i class="fas fa-film text-5xl text-gray-500"></i>
                    </div>
                    @endif

                    <div class="absolute inset-0 flex items-center justify-center">
                        <span class="bg-orange-500 text-white text-xs font-black px-3 py-1.5 rounded-full uppercase tracking-wider shadow-lg">
                            Coming Soon
                        </span>
                    </div>

                    @if($film->release_date)
                    <div class="absolute bottom-2 left-0 right-0 text-center">
                        <span class="bg-black/70 text-white text-xs px-2 py-1 rounded-full">
                            {{ \Carbon\Carbon::parse($film->release_date)->format('d M Y') }}
                        </span>
                    </div>
                    @endif
                </div>
                <h3 class="text-gray-900 font-bold text-sm group-hover:text-orange-500 transition line-clamp-1">
                    {{ $film->judul }}
                </h3>
                <p class="text-gray-400 text-xs mt-0.5">{{ $film->genre }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- CARA PESAN SECTION --}}
<section class="py-16 bg-white">
    <div class="container mx-auto px-6 text-center">
        <span class="text-red-500 text-sm font-bold uppercase tracking-widest">Mudah & Cepat</span>
        <h2 class="text-3xl font-black text-gray-900 mt-1 mb-12">Cara Pesan Tiket</h2>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 max-w-4xl mx-auto relative">
            {{-- Garis penghubung --}}
            <div class="hidden md:block absolute top-10 left-[20%] right-[20%] h-0.5 bg-red-100 z-0"></div>

            @foreach([
                ['icon' => 'fa-film', 'step' => '01', 'title' => 'Pilih Film', 'desc' => 'Cari dan pilih film yang ingin ditonton'],
                ['icon' => 'fa-calendar-alt', 'step' => '02', 'title' => 'Pilih Jadwal', 'desc' => 'Tentukan tanggal dan jam tayang'],
                ['icon' => 'fa-chair', 'step' => '03', 'title' => 'Pilih Kursi', 'desc' => 'Pilih posisi kursi favorit kamu'],
                ['icon' => 'fa-credit-card', 'step' => '04', 'title' => 'Bayar', 'desc' => 'Selesaikan pembayaran dan tiket siap'],
            ] as $index => $step)
            <div class="relative z-10 group"
                 style="animation: fadeInUp 0.5s ease-out {{ $index * 0.15 }}s both;">
                <div class="w-20 h-20 bg-red-50 group-hover:bg-red-600 border-2 border-red-100 group-hover:border-red-600 rounded-2xl flex items-center justify-center mx-auto mb-4 transition-all duration-300 group-hover:-translate-y-2 group-hover:shadow-lg group-hover:shadow-red-200">
                    <i class="fas {{ $step['icon'] }} text-2xl text-red-500 group-hover:text-white transition-colors duration-300"></i>
                </div>
                <div class="text-red-200 text-xs font-black tracking-widest mb-1">{{ $step['step'] }}</div>
                <h3 class="font-black text-gray-900 text-base mb-1">{{ $step['title'] }}</h3>
                <p class="text-gray-400 text-xs leading-relaxed">{{ $step['desc'] }}</p>
            </div>
            @endforeach
        </div>

        <div class="mt-10">
            <a href="{{ route('films.index') }}"
               class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-8 py-4 rounded-2xl font-bold transition-all shadow-lg shadow-red-200 hover:shadow-xl hover:-translate-y-0.5">
                <i class="fas fa-ticket-alt"></i>
                Pesan Tiket Sekarang
                <i class="fas fa-arrow-right text-sm"></i>
            </a>
        </div>
    </div>
</section>

{{-- NEWSLETTER SECTION --}}
<section class="py-16 bg-gradient-to-r from-red-600 to-red-700">
    <div class="container mx-auto px-6 text-center">
        <h2 class="text-3xl font-black text-white mb-2">Jangan Lewatkan Film Favorit!</h2>
        <p class="text-red-200 mb-8">Dapatkan info promo dan jadwal film terbaru langsung ke email kamu</p>
        <form class="flex max-w-md mx-auto gap-3" onsubmit="return false;">
            <input type="email" placeholder="Email kamu..."
                   class="flex-1 bg-white/20 border border-white/30 rounded-xl px-4 py-3 text-white placeholder-white/60 focus:outline-none focus:border-white transition text-sm">
            <button type="submit"
                    class="bg-white text-red-600 font-bold px-6 py-3 rounded-xl hover:bg-gray-100 transition whitespace-nowrap text-sm">
                Subscribe
            </button>
        </form>
    </div>
</section>

<style>
@keyframes fadeInDown {
    from { opacity: 0; transform: translateY(-20px); }
    to   { opacity: 1; transform: translateY(0); }
}
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(30px); }
    to   { opacity: 1; transform: translateY(0); }
}
@keyframes floatOrb1 {
    0%, 100% { transform: translate(0, 0) scale(1); }
    50%       { transform: translate(30px, -30px) scale(1.05); }
}
@keyframes floatOrb2 {
    0%, 100% { transform: translate(0, 0) scale(1); }
    50%       { transform: translate(-20px, 20px) scale(1.03); }
}
@keyframes floatOrb3 {
    0%, 100% { transform: translate(0, 0); }
    50%       { transform: translate(15px, -15px); }
}
@keyframes shimmer {
    0%, 100% { filter: brightness(1); }
    50%       { filter: brightness(1.1); }
}
@keyframes scrollDot {
    0%   { opacity: 1; transform: translateY(0); }
    100% { opacity: 0; transform: translateY(8px); }
}
@keyframes pulse {
    0%, 100% { opacity: 1; }
    50%       { opacity: 0.5; }
}
@keyframes bounce {
    0%, 100% { transform: translateX(-50%) translateY(0); }
    50%       { transform: translateX(-50%) translateY(-10px); }
}
.line-clamp-1 {
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.aspect-\[2\/3\] { aspect-ratio: 2/3; }
</style>
@endsection