@extends('admin.layouts.app')
@section('title', 'Edit Film - ' . $film->judul)
@section('content')

<div class="max-w-2xl">
    <a href="{{ route('admin.films.index') }}"
       class="inline-flex items-center gap-2 text-red-600 hover:text-red-700 text-sm font-medium mb-5">
        <i class="fas fa-arrow-left"></i> Kembali ke Daftar Film
    </a>

    <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">

        @if($film->poster)
        <div class="mb-5 flex items-center gap-4 p-4 bg-gray-50 rounded-xl border border-gray-200">
            <img src="{{ $film->poster }}" alt="{{ $film->judul }}"
                 class="w-16 h-22 object-cover rounded-lg shadow">
            <div>
                <p class="text-sm font-semibold text-gray-700">Poster Saat Ini</p>
                <p class="text-xs text-gray-400 mt-0.5">Upload file baru atau isi URL untuk mengganti</p>
            </div>
        </div>
        @endif

        <h2 class="text-lg font-bold text-gray-900 mb-5">Edit Informasi Film</h2>
        <form action="{{ route('admin.films.update', $film) }}" method="POST"
              enctype="multipart/form-data" class="space-y-4">
            @csrf @method('PUT')
            @include('admin.films._form', ['film' => $film])
            <div class="pt-2">
                <button type="submit"
                        class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 rounded-xl transition flex items-center justify-center gap-2">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection