@extends('admin.layouts.app')
@section('title', 'Laporan Penjualan')
@section('content')

{{-- Filter Tanggal --}}
<div class="bg-white rounded-2xl border border-gray-200 p-5 mb-6 shadow-sm">
    <form method="GET" class="flex gap-4 flex-wrap items-end">
        <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1">Dari Tanggal</label>
            <input type="date" name="dari" value="{{ $dari }}"
                   class="border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 transition">
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1">Sampai Tanggal</label>
            <input type="date" name="sampai" value="{{ $sampai }}"
                   class="border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 transition">
        </div>
        <button type="submit"
                class="bg-red-600 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-red-700 transition flex items-center gap-2">
            <i class="fas fa-search"></i> Tampilkan
        </button>
    </form>
</div>

{{-- Summary Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-6">
    <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-money-bill-wave text-green-600"></i>
            </div>
            <div>
                <p class="text-xs text-gray-400 font-medium">Total Pendapatan</p>
                <p class="text-xl font-black text-gray-900">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-receipt text-blue-600"></i>
            </div>
            <div>
                <p class="text-xs text-gray-400 font-medium">Total Transaksi</p>
                <p class="text-xl font-black text-gray-900">{{ $bookings->count() }}</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-ticket-alt text-red-600"></i>
            </div>
            <div>
                <p class="text-xs text-gray-400 font-medium">Total Tiket Terjual</p>
                <p class="text-xl font-black text-gray-900">{{ $totalTiket }}</p>
            </div>
        </div>
    </div>
</div>

{{-- Tabel Transaksi --}}
<div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm">
    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
        <div>
            <h3 class="font-bold text-gray-900">Riwayat Transaksi</h3>
            <p class="text-xs text-gray-400 mt-0.5">Periode: {{ \Carbon\Carbon::parse($dari)->format('d M Y') }} — {{ \Carbon\Carbon::parse($sampai)->format('d M Y') }}</p>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="text-left px-6 py-3 text-xs font-bold text-gray-400 uppercase">Kode</th>
                    <th class="text-left px-6 py-3 text-xs font-bold text-gray-400 uppercase">User</th>
                    <th class="text-left px-6 py-3 text-xs font-bold text-gray-400 uppercase">Film</th>
                    <th class="text-left px-6 py-3 text-xs font-bold text-gray-400 uppercase">Studio</th>
                    <th class="text-left px-6 py-3 text-xs font-bold text-gray-400 uppercase">Tiket</th>
                    <th class="text-left px-6 py-3 text-xs font-bold text-gray-400 uppercase">Total</th>
                    <th class="text-left px-6 py-3 text-xs font-bold text-gray-400 uppercase">Tanggal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($bookings as $booking)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-3 font-mono text-xs font-bold text-red-600">{{ $booking->kode_booking }}</td>
                    <td class="px-6 py-3 text-sm text-gray-700">{{ $booking->user->name ?? '-' }}</td>
                    <td class="px-6 py-3 text-sm text-gray-700">{{ $booking->schedule->film->judul ?? '-' }}</td>
                    <td class="px-6 py-3 text-sm text-gray-600">{{ $booking->schedule->studio->nama ?? '-' }}</td>
                    <td class="px-6 py-3 text-sm text-gray-600 text-center">{{ $booking->jumlah_tiket }}</td>
                    <td class="px-6 py-3 text-sm font-semibold text-gray-900">
                        Rp {{ number_format($booking->total_harga, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-3 text-xs text-gray-400">{{ $booking->created_at->format('d M Y H:i') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-16 text-center">
                        <i class="fas fa-chart-bar text-5xl text-gray-200 mb-3 block"></i>
                        <p class="text-gray-400 font-medium">Tidak ada transaksi pada periode ini</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection