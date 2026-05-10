@php $film = $film ?? null; @endphp

<div>
    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Judul Film <span class="text-red-500">*</span></label>
    <input type="text" name="judul" value="{{ old('judul', $film?->judul) }}"
           placeholder="Contoh: Avengers: Endgame"
           class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-100 transition">
    @error('judul')<p class="text-red-500 text-xs mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>@enderror
</div>

<div class="grid grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Genre <span class="text-red-500">*</span></label>
        <input type="text" name="genre" value="{{ old('genre', $film?->genre) }}"
               placeholder="Action, Sci-Fi"
               class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-100 transition">
        @error('genre')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Durasi (menit) <span class="text-red-500">*</span></label>
        <input type="number" name="durasi" value="{{ old('durasi', $film?->durasi) }}"
               placeholder="120" min="1"
               class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-100 transition">
        @error('durasi')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
    </div>
</div>

<div>
    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Sinopsis <span class="text-red-500">*</span></label>
    <textarea name="sinopsis" rows="4" placeholder="Tulis sinopsis film..."
              class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-100 transition resize-none">{{ old('sinopsis', $film?->sinopsis) }}</textarea>
    @error('sinopsis')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
</div>

<div>
    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Poster</label>
    <p class="text-xs text-gray-400 mb-2">Upload file <span class="font-semibold">atau</span> isi URL poster</p>
    <input type="file" name="poster" accept="image/*"
           class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm mb-2 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:bg-red-50 file:text-red-600 file:text-xs file:font-semibold hover:file:bg-red-100">
    <input type="text" name="poster_url" value="{{ old('poster_url') }}"
           placeholder="https://link-poster.jpg (opsional jika tidak upload file)"
           class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-100 transition">
</div>