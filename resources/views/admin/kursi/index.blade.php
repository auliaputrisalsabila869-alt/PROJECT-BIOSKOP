@extends('admin.layouts.app')
@section('title', 'Manajemen Kursi')
@section('content')

{{-- Form Generate --}}
<div class="bg-white rounded-2xl border border-gray-200 p-6 mb-6 shadow-sm">
    <h3 class="text-base font-bold text-gray-900 mb-1">Generate Kursi Otomatis</h3>
    <p class="text-sm text-gray-400 mb-4">Buat kursi secara otomatis untuk studio yang dipilih</p>
    <form action="{{ route('admin.kursi.generate') }}" method="POST" class="flex gap-3 flex-wrap items-end">
        @csrf
        <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1">Studio</label>
            <select name="studio_id" class="border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 transition">
                @foreach($studios as $studio)
                <option value="{{ $studio->id }}">{{ $studio->nama }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1">Baris (pisah koma)</label>
            <input type="text" name="baris" value="A,B,C,D,E,F" placeholder="A,B,C,D,E,F"
                   class="border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 transition w-44">
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1">Kursi per Baris</label>
            <input type="number" name="per_baris" value="16" min="1" max="30"
                   class="border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 transition w-28">
        </div>
        <button type="submit"
                class="bg-red-600 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-red-700 transition flex items-center gap-2">
            <i class="fas fa-magic"></i> Generate Kursi
        </button>
    </form>
</div>

{{-- Daftar Kursi per Studio --}}
<div class="space-y-5">
    @foreach($studios as $studio)
    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 bg-gray-50">
            <div>
                <h3 class="font-bold text-gray-900">{{ $studio->nama }}</h3>
                <p class="text-xs text-gray-400 mt-0.5">
                    {{ $studio->seats->count() }} kursi terdaftar · Kapasitas {{ $studio->kapasitas }}
                </p>
            </div>
            @if($studio->seats->count() > 0)
            <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full">
                <i class="fas fa-check mr-1"></i> Aktif
            </span>
            @else
            <span class="px-3 py-1 bg-gray-100 text-gray-500 text-xs font-bold rounded-full">
                Belum ada kursi
            </span>
            @endif
        </div>

        @if($studio->seats->count() > 0)
        <div class="p-6">
            {{-- Layar --}}
            <div class="mb-6 text-center">
                <div class="w-2/3 mx-auto h-2 bg-gradient-to-r from-gray-200 via-gray-400 to-gray-200 rounded-full"></div>
                <p class="text-xs text-gray-400 mt-1 tracking-widest">LAYAR</p>
            </div>

            @foreach($studio->seats->groupBy('baris') as $baris => $seats)
            <div class="flex items-center gap-2 mb-2">
                <span class="w-5 text-xs font-bold text-gray-400 text-center flex-shrink-0">{{ $baris }}</span>
                <div class="flex flex-wrap gap-1">
                    @foreach($seats->sortBy('nomor') as $seat)
                    <span class="w-9 h-9 bg-gray-100 border border-gray-200 rounded-lg text-xs font-medium text-gray-600 flex items-center justify-center hover:bg-red-50 hover:border-red-200 transition cursor-default">
                        {{ $seat->nomor }}
                    </span>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="px-6 py-10 text-center text-gray-400 text-sm">
            <i class="fas fa-chair text-4xl text-gray-200 mb-3 block"></i>
            Belum ada kursi. Gunakan form di atas untuk generate kursi.
        </div>
        @endif
    </div>
    @endforeach
</div>
@endsection