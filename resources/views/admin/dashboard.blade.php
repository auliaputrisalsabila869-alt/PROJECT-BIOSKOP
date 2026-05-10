@extends('admin.layouts.app')
@section('title', 'Dashboard')
@section('content')

{{-- Stats Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-6">
    <div class="bg-white rounded-2xl border border-gray-200 p-5 flex items-center gap-4 shadow-sm">
        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
            <i class="fas fa-money-bill-wave text-green-600 text-lg"></i>
        </div>
        <div>
            <p class="text-xs text-gray-400 font-medium">Total Pendapatan</p>
            <p class="text-lg font-black text-gray-900">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-200 p-5 flex items-center gap-4 shadow-sm">
        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
            <i class="fas fa-ticket-alt text-blue-600 text-lg"></i>
        </div>
        <div>
            <p class="text-xs text-gray-400 font-medium">Total Transaksi</p>
            <p class="text-lg font-black text-gray-900">{{ number_format($totalTransaksi) }}</p>
            <p class="text-xs text-gray-400 mt-0.5">
                <span class="text-green-500">{{ $transaksiPaid }} paid</span> ·
                <span class="text-yellow-500">{{ $transaksiPending }} pending</span>
            </p>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-200 p-5 flex items-center gap-4 shadow-sm">
        <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center flex-shrink-0">
            <i class="fas fa-film text-red-600 text-lg"></i>
        </div>
        <div>
            <p class="text-xs text-gray-400 font-medium">Total Film</p>
            <p class="text-lg font-black text-gray-900">{{ $totalFilm }}</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-200 p-5 flex items-center gap-4 shadow-sm">
        <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center flex-shrink-0">
            <i class="fas fa-calendar-alt text-purple-600 text-lg"></i>
        </div>
        <div>
            <p class="text-xs text-gray-400 font-medium">Jadwal Aktif</p>
            <p class="text-lg font-black text-gray-900">{{ $totalJadwal }}</p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mb-6">

    {{-- Grafik Pendapatan --}}
<div class="xl:col-span-2 bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
    <h3 class="text-base font-bold text-gray-900 mb-5">Pendapatan 7 Hari Terakhir</h3>

    @php 
        $maxPendapatan = max(array_column($pendapatanHarian, 'total')) ?: 1; 
    @endphp

    {{-- Area Grafik --}}
    <div class="flex items-end justify-between gap-2 h-48 pb-1">
        @foreach($pendapatanHarian as $data)
        @php 
            $persen = ($data['total'] / $maxPendapatan) * 100;
            $tinggi = max(round($persen), 2);
        @endphp
        <div class="flex-1 flex flex-col items-center gap-1 h-full justify-end group">
            
            {{-- Nilai di atas batang --}}
            <span class="text-xs font-semibold text-gray-500 mb-1 opacity-0 group-hover:opacity-100 transition-opacity">
                @if($data['total'] > 0)
                    {{ number_format($data['total']/1000, 0) }}k
                @endif
            </span>

            {{-- Batang --}}
            <div class="w-full relative">
                <div class="w-full rounded-t-xl bg-gradient-to-t from-red-600 to-red-400 group-hover:from-red-700 group-hover:to-red-500 transition-all"
                     style="height: {{ max(($tinggi / 100) * 160, 4) }}px">
                </div>
            </div>

            {{-- Tanggal --}}
            <span class="text-xs text-gray-400 mt-2 whitespace-nowrap">{{ $data['tanggal'] }}</span>
        </div>
        @endforeach
    </div>

    {{-- Garis bawah --}}
    <div class="w-full h-px bg-gray-100 mt-1"></div>

    @php $adaData = collect($pendapatanHarian)->sum('total') > 0; @endphp
    @if(!$adaData)
    <p class="text-xs text-gray-400 text-center mt-3 flex items-center justify-center gap-1">
        <i class="fas fa-info-circle"></i>
        Belum ada transaksi dalam 7 hari terakhir
    </p>
    @endif
</div>

    {{-- Film Terlaris --}}
    <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
        <h3 class="text-base font-bold text-gray-900 mb-4">Film Terlaris</h3>
        <div class="space-y-3">
            @forelse($filmTerlaris as $index => $film)
            <div class="flex items-center gap-3">
                <span class="w-6 h-6 rounded-full text-xs font-bold flex items-center justify-center flex-shrink-0
                             {{ $index === 0 ? 'bg-yellow-400 text-white' : ($index === 1 ? 'bg-gray-300 text-white' : 'bg-gray-100 text-gray-500') }}">
                    {{ $index + 1 }}
                </span>
                @if($film->poster)
                <img src="{{ $film->poster }}" alt="{{ $film->judul }}"
                     class="w-8 h-11 object-cover rounded flex-shrink-0">
                @else
                <div class="w-8 h-11 bg-gray-100 rounded flex-shrink-0 flex items-center justify-center">
                    <i class="fas fa-film text-gray-300 text-xs"></i>
                </div>
                @endif
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-800 truncate">{{ $film->judul }}</p>
                    <p class="text-xs text-gray-400">{{ $film->total_tiket ?? 0 }} tiket terjual</p>
                </div>
            </div>
            @empty
            <div class="text-center py-6">
                <i class="fas fa-film text-3xl text-gray-200 mb-2"></i>
                <p class="text-sm text-gray-400">Belum ada data</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

{{-- Transaksi Terbaru --}}
<div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
        <h3 class="text-base font-bold text-gray-900">Transaksi Terbaru</h3>
        <a href="{{ route('admin.bookings.index') }}"
           class="text-sm text-red-600 hover:text-red-700 font-medium flex items-center gap-1">
            Lihat semua <i class="fas fa-arrow-right text-xs"></i>
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="text-left px-6 py-3 text-xs font-bold text-gray-400 uppercase tracking-wider">Kode</th>
                    <th class="text-left px-6 py-3 text-xs font-bold text-gray-400 uppercase tracking-wider">User</th>
                    <th class="text-left px-6 py-3 text-xs font-bold text-gray-400 uppercase tracking-wider">Film</th>
                    <th class="text-left px-6 py-3 text-xs font-bold text-gray-400 uppercase tracking-wider">Total</th>
                    <th class="text-left px-6 py-3 text-xs font-bold text-gray-400 uppercase tracking-wider">Status</th>
                    <th class="text-left px-6 py-3 text-xs font-bold text-gray-400 uppercase tracking-wider">Waktu</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($transaksiTerbaru as $booking)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-3 font-mono text-xs font-bold text-red-600">{{ $booking->kode_booking }}</td>
                    <td class="px-6 py-3 text-sm text-gray-700">{{ $booking->user->name ?? '-' }}</td>
                    <td class="px-6 py-3 text-sm text-gray-700 max-w-xs truncate">{{ $booking->schedule->film->judul ?? '-' }}</td>
                    <td class="px-6 py-3 text-sm font-semibold text-gray-900">
                        Rp {{ number_format($booking->total_harga, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-3">
                        @if($booking->status === 'paid')
                        <span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full">Paid</span>
                        @elseif($booking->status === 'pending')
                        <span class="px-2 py-1 bg-yellow-100 text-yellow-700 text-xs font-bold rounded-full">Pending</span>
                        @else
                        <span class="px-2 py-1 bg-red-100 text-red-700 text-xs font-bold rounded-full">Cancelled</span>
                        @endif
                    </td>
                    <td class="px-6 py-3 text-xs text-gray-400">
                        {{ $booking->created_at->format('d M, H:i') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                        <i class="fas fa-inbox text-4xl mb-3 block text-gray-200"></i>
                        Belum ada transaksi
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection