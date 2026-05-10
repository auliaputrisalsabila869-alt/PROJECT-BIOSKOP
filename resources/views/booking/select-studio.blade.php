@extends('layouts.app')

@section('title', 'Pilih Studio - ' . $film->judul)

@section('content')
<section class="min-h-screen pt-24 pb-12 bg-gradient-to-b from-gray-50 to-white">
    <div class="container mx-auto px-4">
        <div class="mb-8">
            <a href="{{ route('films.show', $film->slug) }}" class="text-red-600 hover:text-red-700 mb-4 inline-flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> Kembali ke Detail Film
            </a>
            <h1 class="text-3xl font-bold text-gray-900 mt-2">Pilih Studio</h1>
            <p class="text-gray-600">{{ $film->judul }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="md:col-span-2 bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Studio Tersedia</h2>
                <p class="text-gray-500 mb-6">Pilih studio untuk melihat jadwal tayang yang tersedia.</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @forelse($studios as $studio)
                        <a href="{{ route('booking.select-schedule', ['filmId' => $film->id, 'studio_id' => $studio->id]) }}" class="group block rounded-2xl border border-gray-200 bg-white p-5 hover:border-red-500 hover:shadow-lg transition">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <p class="text-sm text-gray-500 uppercase tracking-[0.2em]">Studio</p>
                                    <h3 class="text-xl font-bold text-gray-900">{{ $studio->nama }}</h3>
                                </div>
                                <div class="text-red-600 text-2xl">
                                    <i class="fas fa-building"></i>
                                </div>
                            </div>
                            <p class="text-gray-500 text-sm">Lihat jadwal film {{ $film->judul }} di studio ini.</p>
                        </a>
                    @empty
                        <div class="col-span-1 sm:col-span-2 bg-gray-50 rounded-2xl border border-dashed border-gray-300 p-8 text-center">
                            <i class="fas fa-exclamation-circle text-4xl text-gray-400 mb-4"></i>
                            <p class="text-gray-500">Belum ada studio yang memiliki jadwal tayang untuk film ini.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Info Film</h2>
                <p class="text-gray-600 mb-3"><span class="font-semibold">Judul:</span> {{ $film->judul }}</p>
                <p class="text-gray-600 mb-3"><span class="font-semibold">Genre:</span> {{ $film->genre }}</p>
                <p class="text-gray-600 mb-3"><span class="font-semibold">Durasi:</span> {{ $film->duration }}</p>
                <p class="text-gray-600"><span class="font-semibold">Rating:</span> {{ $film->rating }} / 5</p>
            </div>
        </div>

        <div class="text-center">
            <a href="{{ route('booking.select-schedule', $film->id) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-red-600 hover:text-red-700">
                <i class="fas fa-list"></i> Lihat semua jadwal
            </a>
        </div>
    </div>
</section>
@endsection
