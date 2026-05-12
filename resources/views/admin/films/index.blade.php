@extends('admin.layouts.app')
@section('title', 'Manajemen Film')
@section('content')

<div class="flex items-center justify-between mb-6">
    <p class="text-sm text-gray-500">Total <span class="font-bold text-gray-900">{{ $films->total() }}</span> film</p>
    <a href="{{ route('admin.films.create') }}"
       class="bg-red-600 hover:bg-red-700 text-white px-5 py-2.5 rounded-xl font-semibold text-sm transition flex items-center gap-2 shadow-sm">
        <i class="fas fa-plus"></i> Tambah Film
    </a>
</div>

<div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm">
    <table class="w-full">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="text-left px-6 py-3 text-xs font-bold text-gray-400 uppercase">Film</th>
                <th class="text-left px-6 py-3 text-xs font-bold text-gray-400 uppercase">Genre</th>
                <th class="text-left px-6 py-3 text-xs font-bold text-gray-400 uppercase">Durasi</th>
                <th class="text-left px-6 py-3 text-xs font-bold text-gray-400 uppercase">Status</th>
                <th class="text-left px-6 py-3 text-xs font-bold text-gray-400 uppercase">Rating</th>
                <th class="text-right px-6 py-3 text-xs font-bold text-gray-400 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($films as $film)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        @if($film->poster)
                        <img src="{{ $film->poster }}" alt="{{ $film->judul }}"
                             class="w-10 h-14 object-cover rounded-lg flex-shrink-0 shadow-sm">
                        @else
                        <div class="w-10 h-14 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-film text-gray-300 text-xs"></i>
                        </div>
                        @endif
                        <div>
                            <p class="font-semibold text-gray-900 text-sm">{{ $film->judul }}</p>
                            <p class="text-xs text-gray-400 mt-0.5 line-clamp-1 max-w-xs">{{ $film->sinopsis }}</p>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 bg-gray-100 text-gray-600 text-xs rounded-lg">{{ $film->genre }}</span>
                </td>
                <td class="px-6 py-4 text-sm text-gray-600">{{ $film->durasi }} menit</td>
                <td class="px-6 py-4">
                    @if(isset($film->status) && $film->status === 'now_showing')
                    <span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full">
                        <i class="fas fa-circle text-[6px] mr-1"></i> Tayang
                    </span>
                    @else
                    <span class="px-2 py-1 bg-orange-100 text-orange-700 text-xs font-bold rounded-full">
                        <i class="fas fa-clock text-xs mr-1"></i> Coming Soon
                    </span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-1">
                        <i class="fas fa-star text-yellow-400 text-xs"></i>
                        <span class="text-sm font-semibold text-gray-700">{{ $film->rating ?? 0 }}</span>
                    </div>
                </td>
                <td class="px-6 py-4 text-right">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('admin.films.edit', $film) }}"
                           class="px-3 py-1.5 bg-blue-50 text-blue-600 hover:bg-blue-100 rounded-lg text-xs font-semibold transition">
                            <i class="fas fa-edit mr-1"></i> Edit
                        </a>
                        <form action="{{ route('admin.films.destroy', $film) }}" method="POST"
                              onsubmit="return confirm('Hapus film {{ addslashes($film->judul) }}?')">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    class="px-3 py-1.5 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg text-xs font-semibold transition">
                                <i class="fas fa-trash mr-1"></i> Hapus
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-16 text-center">
                    <i class="fas fa-film text-5xl text-gray-200 mb-3 block"></i>
                    <p class="text-gray-400 font-medium">Belum ada film</p>
                    <a href="{{ route('admin.films.create') }}"
                       class="text-red-600 text-sm mt-2 inline-block hover:underline">
                        + Tambah film pertama
                    </a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($films->hasPages())
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $films->links() }}
    </div>
    @endif
</div>

@endsection