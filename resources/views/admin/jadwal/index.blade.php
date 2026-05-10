@extends('admin.layouts.app')
@section('title', 'Manajemen Jadwal')
@section('content')

<div class="flex items-center justify-between mb-6">
    <p class="text-sm text-gray-500">Total <span class="font-bold text-gray-900">{{ $jadwals->total() }}</span> jadwal</p>
    <a href="{{ route('admin.jadwal.create') }}"
       class="bg-red-600 hover:bg-red-700 text-white px-5 py-2.5 rounded-xl font-semibold text-sm transition flex items-center gap-2 shadow-sm">
        <i class="fas fa-plus"></i> Tambah Jadwal
    </a>
</div>

<div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm">
    <table class="w-full">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="text-left px-6 py-3 text-xs font-bold text-gray-400 uppercase">Film</th>
                <th class="text-left px-6 py-3 text-xs font-bold text-gray-400 uppercase">Studio</th>
                <th class="text-left px-6 py-3 text-xs font-bold text-gray-400 uppercase">Tanggal</th>
                <th class="text-left px-6 py-3 text-xs font-bold text-gray-400 uppercase">Waktu</th>
                <th class="text-left px-6 py-3 text-xs font-bold text-gray-400 uppercase">Harga</th>
                <th class="text-right px-6 py-3 text-xs font-bold text-gray-400 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @forelse($jadwals as $jadwal)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-3 text-sm font-semibold text-gray-800">{{ $jadwal->film->judul }}</td>
                <td class="px-6 py-3">
                    <span class="px-2 py-1 bg-gray-100 text-gray-600 text-xs rounded-lg">{{ $jadwal->studio->nama }}</span>
                </td>
                <td class="px-6 py-3 text-sm text-gray-600">{{ $jadwal->tanggal->format('d M Y') }}</td>
                <td class="px-6 py-3 text-sm text-gray-600">
                    <span class="font-semibold">{{ \Carbon\Carbon::parse($jadwal->waktu_mulai)->format('H:i') }}</span>
                    <span class="text-gray-400"> — {{ \Carbon\Carbon::parse($jadwal->waktu_selesai)->format('H:i') }}</span>
                </td>
                <td class="px-6 py-3 text-sm font-semibold text-red-600">
                    Rp {{ number_format($jadwal->harga, 0, ',', '.') }}
                </td>
                <td class="px-6 py-3 text-right">
                    <div class="flex justify-end gap-2">
                        <a href="{{ route('admin.jadwal.edit', $jadwal) }}"
                           class="px-3 py-1.5 bg-blue-50 text-blue-600 hover:bg-blue-100 rounded-lg text-xs font-semibold transition">
                            <i class="fas fa-edit mr-1"></i> Edit
                        </a>
                        <form action="{{ route('admin.jadwal.destroy', $jadwal) }}" method="POST"
                              onsubmit="return confirm('Hapus jadwal ini?')">
                            @csrf @method('DELETE')
                            <button class="px-3 py-1.5 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg text-xs font-semibold transition">
                                <i class="fas fa-trash mr-1"></i> Hapus
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-16 text-center">
                    <i class="fas fa-calendar-times text-5xl text-gray-200 mb-3 block"></i>
                    <p class="text-gray-400 font-medium">Belum ada jadwal</p>
                    <a href="{{ route('admin.jadwal.create') }}" class="text-red-600 text-sm mt-2 inline-block hover:underline">
                        + Tambah jadwal pertama
                    </a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    @if($jadwals->hasPages())
    <div class="px-6 py-4 border-t border-gray-100">{{ $jadwals->links() }}</div>
    @endif
</div>
@endsection