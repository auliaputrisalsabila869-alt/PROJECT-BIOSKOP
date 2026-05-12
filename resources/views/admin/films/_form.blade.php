@php $film = $film ?? null; @endphp

<div>
    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
        Judul Film <span class="text-red-500">*</span>
    </label>
    <input type="text" name="judul" value="{{ old('judul', $film?->judul) }}"
           placeholder="Contoh: Avengers: Endgame"
           class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-100 transition">
    @error('judul')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
</div>

<div class="grid grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
            Genre <span class="text-red-500">*</span>
        </label>
        <input type="text" name="genre" value="{{ old('genre', $film?->genre) }}"
               placeholder="Action, Sci-Fi"
               class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-100 transition">
        @error('genre')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
            Durasi (menit) <span class="text-red-500">*</span>
        </label>
        <input type="number" name="durasi" value="{{ old('durasi', $film?->durasi) }}"
               placeholder="120" min="1"
               class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-100 transition">
        @error('durasi')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
    </div>
</div>

<div class="grid grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Rating (0-5)</label>
        <input type="number" name="rating" value="{{ old('rating', $film?->rating ?? 0) }}"
               min="0" max="5" step="0.1" placeholder="4.5"
               class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-100 transition">
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Age Rating</label>
        <select name="age_rating"
                class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-100 transition">
            <option value="G"    {{ old('age_rating', $film?->age_rating) == 'G'    ? 'selected' : '' }}>G (Semua Umur)</option>
            <option value="PG"   {{ old('age_rating', $film?->age_rating) == 'PG'   ? 'selected' : '' }}>PG</option>
            <option value="PG-13"{{ old('age_rating', $film?->age_rating) == 'PG-13'? 'selected' : '' }}>PG-13</option>
            <option value="R"    {{ old('age_rating', $film?->age_rating) == 'R'    ? 'selected' : '' }}>R</option>
        </select>
    </div>
</div>

<div class="grid grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Sutradara</label>
        <input type="text" name="director" value="{{ old('director', $film?->director) }}"
               placeholder="Nama Sutradara"
               class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-100 transition">
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Status Tayang</label>
        <select name="status"
                class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-100 transition">
            <option value="now_showing" {{ old('status', $film?->status) == 'now_showing' ? 'selected' : '' }}>
                Sedang Tayang
            </option>
            <option value="coming_soon" {{ old('status', $film?->status) == 'coming_soon' ? 'selected' : '' }}>
                Coming Soon
            </option>
        </select>
    </div>
</div>

<div>
    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tanggal Rilis</label>
    <input type="date" name="release_date"
           value="{{ old('release_date', $film?->release_date ? \Carbon\Carbon::parse($film->release_date)->format('Y-m-d') : '') }}"
           class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-100 transition">
</div>

<div>
    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
        Sinopsis <span class="text-red-500">*</span>
    </label>
    <textarea name="sinopsis" rows="4" placeholder="Tulis sinopsis film..."
              class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-100 transition resize-none">{{ old('sinopsis', $film?->sinopsis) }}</textarea>
    @error('sinopsis')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
</div>

<div>
    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Link Trailer (YouTube embed)</label>
    <input type="text" name="trailer" value="{{ old('trailer', $film?->trailer) }}"
           placeholder="https://www.youtube.com/embed/xxxxx"
           class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-100 transition">
    <p class="text-xs text-gray-400 mt-1">Format: https://www.youtube.com/embed/ID_VIDEO</p>
</div>

<div>
    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Poster</label>
    <p class="text-xs text-gray-400 mb-2">Upload file <span class="font-semibold">atau</span> isi URL poster</p>
    @if($film?->poster)
    <div class="mb-2 flex items-center gap-3 p-3 bg-gray-50 rounded-xl border border-gray-200">
        <img src="{{ $film->poster }}" class="w-10 h-14 object-cover rounded-lg shadow-sm">
        <p class="text-xs text-gray-500">Poster saat ini. Upload baru untuk mengganti.</p>
    </div>
    @endif
    <input type="file" name="poster" accept="image/*"
           class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm mb-2
                  file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0
                  file:bg-red-50 file:text-red-600 file:text-xs file:font-semibold hover:file:bg-red-100">
    <input type="text" name="poster_url" value="{{ old('poster_url') }}"
           placeholder="https://link-poster.jpg (opsional jika tidak upload file)"
           class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-100 transition">
</div>

<div>
    <label class="block text-sm font-semibold text-gray-700 mb-1.5">URL Backdrop</label>
    <input type="text" name="backdrop" value="{{ old('backdrop', $film?->backdrop) }}"
           placeholder="https://link-backdrop.jpg"
           class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-100 transition">
    <p class="text-xs text-gray-400 mt-1">Gambar latar belakang di halaman detail film</p>
</div>