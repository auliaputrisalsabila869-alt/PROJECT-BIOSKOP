@extends('admin.layouts.app')
@section('title', 'Tambah Film')
@section('content')

<div class="max-w-2xl">
    <a href="{{ route('admin.films.index') }}"
       class="inline-flex items-center gap-2 text-red-600 hover:text-red-700 text-sm font-medium mb-5">
        <i class="fas fa-arrow-left"></i> Kembali ke Daftar Film
    </a>

    <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
        <h2 class="text-lg font-bold text-gray-900 mb-5">Informasi Film</h2>
        <form action="{{ route('admin.films.store') }}" method="POST"
              enctype="multipart/form-data" class="space-y-4">
            @csrf
            @include('admin.films._form')
            <div class="pt-2">
                <button type="submit"
                        class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 rounded-xl transition flex items-center justify-center gap-2">
                    <i class="fas fa-plus"></i> Simpan Film
                </button>
            </div>
        </form>
    </div>
</div>
@endsection