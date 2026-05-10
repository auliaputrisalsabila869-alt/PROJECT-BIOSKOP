@extends('admin.layouts.app')
@section('title', 'Edit Jadwal')
@section('content')

<div class="max-w-lg">
    <a href="{{ route('admin.jadwal.index') }}"
       class="inline-flex items-center gap-2 text-red-600 hover:text-red-700 text-sm font-medium mb-5">
        <i class="fas fa-arrow-left"></i> Kembali ke Daftar Jadwal
    </a>

    <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
        <h2 class="text-lg font-bold text-gray-900 mb-5">Edit Jadwal Tayang</h2>
        <form action="{{ route('admin.jadwal.update', $jadwal) }}" method="POST" class="space-y-4">
            @csrf @method('PUT')

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Film <span class="text-red-500">*</span></label>
                <select name="film_id" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 transition">
                    @foreach($films as $film)
                    <option value="{{ $film->id }}" {{ $jadwal->film_id == $film->id ? 'selected' : '' }}>
                        {{ $film->judul }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Studio <span class="text-red-500">*</span></label>
                <select name="studio_id" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 transition">
                    @foreach($studios as $studio)
                    <option value="{{ $studio->id }}" {{ $jadwal->studio_id == $studio->id ? 'selected' : '' }}>
                        {{ $studio->nama }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tanggal <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal" value="{{ old('tanggal', $jadwal->tanggal->format('Y-m-d')) }}"
                           class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 transition">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Jam Mulai <span class="text-red-500">*</span></label>
                    <input type="time" name="waktu_mulai"
                           value="{{ old('waktu_mulai', \Carbon\Carbon::parse($jadwal->waktu_mulai)->format('H:i')) }}"
                           class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 transition">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Harga Tiket <span class="text-red-500">*</span></label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm font-medium">Rp</span>
                    <input type="number" name="harga" value="{{ old('harga', $jadwal->harga) }}"
                           min="1000" step="1000"
                           class="w-full border border-gray-300 rounded-xl pl-10 pr-4 py-2.5 text-sm focus:outline-none focus:border-red-500 transition">
                </div>
            </div>

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