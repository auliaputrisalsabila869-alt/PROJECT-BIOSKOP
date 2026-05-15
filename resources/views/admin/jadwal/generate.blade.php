@extends('admin.layouts.app')
@section('title', 'Generate Jadwal Otomatis')
@section('content')

<div class="max-w-3xl">
    <a href="{{ route('admin.jadwal.index') }}"
       class="inline-flex items-center gap-2 text-red-600 hover:text-red-700 text-sm font-medium mb-5">
        <i class="fas fa-arrow-left"></i> Kembali ke Daftar Jadwal
    </a>

    <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
        <div class="mb-6">
            <h2 class="text-lg font-bold text-gray-900">Generate Jadwal Otomatis</h2>
            <p class="text-sm text-gray-400 mt-1">
                Buat jadwal tayang untuk banyak film sekaligus secara otomatis
            </p>
        </div>

        <form action="{{ route('admin.jadwal.generate-bulk') }}" method="POST" class="space-y-6">
            @csrf

            {{-- Pilih Film --}}
            {{-- Pilih Film + Harga per film --}}
<div>
    <label class="block text-sm font-bold text-gray-700 mb-2">
        Pilih Film & Harga <span class="text-red-500">*</span>
        <span class="text-gray-400 font-normal ml-1">(atur harga tiap film)</span>
    </label>
    <div class="border border-gray-200 rounded-xl overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="text-left px-4 py-2 text-xs font-bold text-gray-400 uppercase w-8"></th>
                    <th class="text-left px-4 py-2 text-xs font-bold text-gray-400 uppercase">Film</th>
                    <th class="text-left px-4 py-2 text-xs font-bold text-gray-400 uppercase w-48">Harga Tiket</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($films as $film)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 py-3 text-center">
                        <input type="checkbox" name="film_ids[]" value="{{ $film->id }}"
                               class="w-4 h-4 text-red-600 rounded border-gray-300 focus:ring-red-500">
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-3">
                            @if($film->poster)
                            <img src="{{ $film->poster }}" class="w-8 h-11 object-cover rounded flex-shrink-0">
                            @else
                            <div class="w-8 h-11 bg-gray-100 rounded flex-shrink-0 flex items-center justify-center">
                                <i class="fas fa-film text-gray-300 text-xs"></i>
                            </div>
                            @endif
                            <div>
                                <p class="text-sm font-semibold text-gray-800">{{ $film->judul }}</p>
                                <p class="text-xs text-gray-400">{{ $film->durasi }} menit · {{ $film->genre }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3">
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs font-medium">Rp</span>
                            <input type="number"
                                   name="harga_film[{{ $film->id }}]"
                                   value="50000"
                                   min="1000" step="1000"
                                   class="w-full border border-gray-200 rounded-lg pl-8 pr-3 py-1.5 text-sm focus:outline-none focus:border-red-500 transition">
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Tombol pilih semua --}}
    <div class="flex gap-3 mt-2">
        <button type="button" onclick="selectAllFilms(true)"
                class="text-xs text-red-600 hover:text-red-700 font-medium">
            Pilih Semua
        </button>
        <span class="text-gray-300">|</span>
        <button type="button" onclick="selectAllFilms(false)"
                class="text-xs text-gray-500 hover:text-gray-700 font-medium">
            Hapus Semua
        </button>
        <span class="text-gray-300">|</span>
        <button type="button" onclick="setAllHarga()"
                class="text-xs text-blue-600 hover:text-blue-700 font-medium">
            Samakan Semua Harga
        </button>
    </div>
</div>

                {{-- Tombol pilih semua --}}
                <div class="flex gap-3 mt-2">
                    <button type="button" onclick="selectAllFilms(true)"
                            class="text-xs text-red-600 hover:text-red-700 font-medium">
                        Pilih Semua
                    </button>
                    <span class="text-gray-300">|</span>
                    <button type="button" onclick="selectAllFilms(false)"
                            class="text-xs text-gray-500 hover:text-gray-700 font-medium">
                        Hapus Semua
                    </button>
                </div>
            </div>

            {{-- Pilih Studio --}}
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    Pilih Studio <span class="text-red-500">*</span>
                    <span class="text-gray-400 font-normal ml-1">(film akan dirotasi antar studio)</span>
                </label>
                <div class="flex flex-wrap gap-2">
                    @foreach($studios as $studio)
                    <label class="flex items-center gap-2 px-3 py-2 border border-gray-200 rounded-xl hover:border-red-400 cursor-pointer transition">
                        <input type="checkbox" name="studio_ids[]" value="{{ $studio->id }}"
                               class="w-4 h-4 text-red-600 rounded border-gray-300 focus:ring-red-500" checked>
                        <span class="text-sm font-medium text-gray-700">{{ $studio->nama }}</span>
                        <span class="text-xs text-gray-400">({{ $studio->kapasitas }} kursi)</span>
                    </label>
                    @endforeach
                </div>
                @error('studio_ids')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Tanggal & Jumlah Hari --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1.5">
                        Tanggal Mulai <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="tanggal_mulai"
                           value="{{ date('Y-m-d') }}"
                           class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-100 transition">
                    @error('tanggal_mulai')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1.5">
                        Jumlah Hari <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="jumlah_hari" value="7" min="1" max="30"
                           class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-100 transition">
                    @error('jumlah_hari')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- Jam Tayang --}}
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    Jam Tayang <span class="text-red-500">*</span>
                    <span class="text-gray-400 font-normal ml-1">(pilih satu atau lebih)</span>
                </label>
                <div class="flex flex-wrap gap-2">
                    @foreach(['09:00', '11:00', '13:00', '15:00', '17:00', '19:00', '21:00', '21:30'] as $jam)
                    <label class="cursor-pointer">
                        <input type="checkbox" name="jam_tayang[]" value="{{ $jam }}"
                               class="peer sr-only"
                               {{ in_array($jam, ['13:00', '16:00', '19:00']) ? 'checked' : '' }}>
                        <div class="px-4 py-2 border-2 border-gray-200 rounded-xl text-sm font-semibold text-gray-600
                                    peer-checked:border-red-500 peer-checked:bg-red-50 peer-checked:text-red-600
                                    hover:border-gray-300 transition">
                            {{ $jam }}
                        </div>
                    </label>
                    @endforeach
                </div>
                @error('jam_tayang')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Harga --}}
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1.5">
                    Harga Tiket <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm font-medium">Rp</span>
                    <input type="number" name="harga" value="50000" min="1000" step="1000"
                           class="w-full border border-gray-300 rounded-xl pl-10 pr-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-100 transition">
                </div>
                @error('harga')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Info --}}
            <div class="bg-blue-50 border border-blue-100 rounded-xl p-4">
                <h4 class="text-sm font-bold text-blue-800 mb-1 flex items-center gap-2">
                    <i class="fas fa-info-circle"></i> Informasi
                </h4>
                <ul class="text-xs text-blue-700 space-y-1">
                    <li>• Film akan dirotasi antar studio yang dipilih secara otomatis</li>
                    <li>• Jadwal yang sudah ada atau bentrok akan dilewati otomatis</li>
                    <li>• Waktu selesai otomatis dihitung dari durasi film + 15 menit iklan</li>
                </ul>
            </div>

            <button type="submit"
                    class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 rounded-xl transition flex items-center justify-center gap-2">
                <i class="fas fa-magic"></i> Generate Jadwal Sekarang
            </button>
        </form>
    </div>
</div>

<script>
function selectAllFilms(select) {
    document.querySelectorAll('input[name="film_ids[]"]').forEach(cb => {
        cb.checked = select;
    });
}

// Samakan semua harga berdasarkan input pertama
function setAllHarga() {
    const inputs = document.querySelectorAll('input[name^="harga_film"]');
    if (inputs.length === 0) return;
    const harga = prompt('Masukkan harga yang sama untuk semua film:', '50000');
    if (harga && !isNaN(harga)) {
        inputs.forEach(input => input.value = parseInt(harga));
    }
}
</script>
@endsection