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
            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-money-bill-wave text-green-600 text-lg"></i>
            </div>

            <div>
                <p class="text-xs text-gray-400 font-medium">Total Pendapatan</p>
                <p class="text-xl font-black text-gray-900">
                    Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                </p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-receipt text-blue-600 text-lg"></i>
            </div>

            <div>
                <p class="text-xs text-gray-400 font-medium">Total Transaksi</p>
                <p class="text-xl font-black text-gray-900">{{ $bookings->count() }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-ticket-alt text-red-600 text-lg"></i>
            </div>

            <div>
                <p class="text-xs text-gray-400 font-medium">Total Tiket Terjual</p>
                <p class="text-xl font-black text-gray-900">{{ $totalTiket }}</p>
            </div>
        </div>
    </div>

</div>

{{-- Grafik Pendapatan --}}
<div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm mb-6">
    <h3 class="text-base font-bold text-gray-900 mb-5">Grafik Pendapatan</h3>

    @php
        $grafikData = [];

        $dari_date = \Carbon\Carbon::parse($dari);
        $sampai_date = \Carbon\Carbon::parse($sampai);

        $diff = $dari_date->diffInDays($sampai_date);
        $diff = min($diff, 29);

        for ($i = 0; $i <= $diff; $i++) {
            $tgl = $dari_date->copy()->addDays($i);

            $total = $bookings->filter(function ($b) use ($tgl) {
                return \Carbon\Carbon::parse($b->created_at)->format('Y-m-d') === $tgl->format('Y-m-d');
            })->sum('total_harga');

            $grafikData[] = [
                'tanggal' => $tgl->format('d M'),
                'total' => $total,
            ];
        }

        $maxGrafik = max(array_column($grafikData, 'total')) ?: 1;
    @endphp

    @if(count($grafikData) > 0)
        <div class="flex items-end gap-1 h-48 overflow-x-auto pb-2">

            @foreach($grafikData as $data)

                @php
                    $heightPx = max(($data['total'] / $maxGrafik) * 160, 4);
                @endphp

                <div class="flex flex-col items-center gap-1 flex-shrink-0 group"
                    style="min-width: {{ count($grafikData) > 15 ? '30px' : '40px' }}">

                    <span class="text-xs text-gray-400 opacity-0 group-hover:opacity-100 transition whitespace-nowrap">
                        @if($data['total'] > 0)
                            Rp{{ number_format($data['total'] / 1000, 0) }}k
                        @endif
                    </span>

                    <div class="w-full rounded-t-lg transition-all relative cursor-pointer"
                        style="height: {{ $heightPx }}px; background: {{ $data['total'] > 0 ? 'linear-gradient(to top, #dc2626, #f87171)' : '#f3f4f6' }}">
                    </div>

                    <span class="text-xs text-gray-400 whitespace-nowrap"
                        style="font-size: {{ count($grafikData) > 15 ? '9px' : '11px' }}">
                        {{ $data['tanggal'] }}
                    </span>

                </div>

            @endforeach

        </div>
    @endif
</div>

{{-- Grafik Film --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

    {{-- Pendapatan per Film --}}
    <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
        <h3 class="text-base font-bold text-gray-900 mb-4">Pendapatan per Film</h3>

        @php
            $perFilm = $bookings->groupBy(function ($b) {
                return $b->schedule->film->judul ?? 'Unknown';
            })->map(function ($group) {
                return $group->sum('total_harga');
            })->sortDesc()->take(6);

            $maxFilm = $perFilm->max() ?: 1;

            $filmColors = [
                'bg-red-500',
                'bg-orange-500',
                'bg-yellow-500',
                'bg-green-500',
                'bg-blue-500',
                'bg-purple-500'
            ];

            $filmIndex = 0;
        @endphp

        <div class="space-y-3">

            @forelse($perFilm as $judul => $total)

                @php
                    $persen = ($total / $maxFilm) * 100;
                    $color = $filmColors[$filmIndex % count($filmColors)];
                    $filmIndex++;
                @endphp

                <div>
                    <div class="flex justify-between items-center mb-1">
                        <span class="text-xs font-semibold text-gray-700 truncate max-w-[150px]">
                            {{ $judul }}
                        </span>

                        <span class="text-xs font-bold text-gray-900">
                            Rp {{ number_format($total / 1000, 0) }}k
                        </span>
                    </div>

                    <div class="w-full bg-gray-100 rounded-full h-2.5">
                        <div class="{{ $color }} h-2.5 rounded-full"
                            style="width: {{ $persen }}%">
                        </div>
                    </div>
                </div>

            @empty

                <p class="text-sm text-gray-400 text-center py-4">
                    Tidak ada data
                </p>

            @endforelse

        </div>
    </div>

    {{-- Tiket per Film --}}
    <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
        <h3 class="text-base font-bold text-gray-900 mb-4">Tiket Terjual per Film</h3>

        @php
            $tiketPerFilm = $bookings->groupBy(function ($b) {
                return $b->schedule->film->judul ?? 'Unknown';
            })->map(function ($group) {
                return $group->sum('jumlah_tiket');
            })->sortDesc()->take(6);
            $maxTiket = $tiketPerFilm->max() ?: 1;
            $tiketColors = [
                'bg-blue-500',
                'bg-teal-500',
                'bg-cyan-500',
                'bg-indigo-500',
                'bg-violet-500',
                'bg-pink-500'
            ];
            $tiketIndex = 0;
        @endphp
        <div class="space-y-3">
            @forelse($tiketPerFilm as $judul => $tiket)
                @php
                    $persen = ($tiket / $maxTiket) * 100;
                    $color2 = $tiketColors[$tiketIndex % count($tiketColors)];
                    $tiketIndex++;
                @endphp
                <div>
                    <div class="flex justify-between items-center mb-1">
                        <span class="text-xs font-semibold text-gray-700 truncate max-w-[150px]">
                            {{ $judul }}
                        </span>
                        <span class="text-xs font-bold text-gray-900">
                            {{ $tiket }} tiket
                        </span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2.5">
                        <div class="{{ $color2 }} h-2.5 rounded-full"
                            style="width: {{ $persen }}%">
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-sm text-gray-400 text-center py-4">
                    Tidak ada data
                </p>
            @endforelse
        </div>
    </div>
</div>

{{-- Tabel Transaksi --}}
<div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm">
    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
        <div>
            <h3 class="font-bold text-gray-900">Riwayat Transaksi</h3>
            <p class="text-xs text-gray-400 mt-0.5">
                {{ \Carbon\Carbon::parse($dari)->format('d M Y') }}
                —
                {{ \Carbon\Carbon::parse($sampai)->format('d M Y') }}
            </p>
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
                        <td class="px-6 py-3 font-mono text-xs font-bold text-red-600">
                            {{ $booking->kode_booking }}
                        </td>
                        <td class="px-6 py-3 text-sm text-gray-700">
                            {{ $booking->user->name ?? '-' }}
                        </td>
                        <td class="px-6 py-3 text-sm text-gray-700">
                            {{ $booking->schedule->film->judul ?? '-' }}
                        </td>
                        <td class="px-6 py-3 text-sm text-gray-600">
                            {{ $booking->schedule->studio->nama ?? '-' }}
                        </td>
                        <td class="px-6 py-3 text-sm text-gray-600 text-center">
                            {{ $booking->jumlah_tiket }}
                        </td>
                        <td class="px-6 py-3 text-sm font-semibold text-gray-900">
                            Rp {{ number_format($booking->total_harga, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-3 text-xs text-gray-400">
                            {{ $booking->created_at->format('d M Y H:i') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-16 text-center">
                            <i class="fas fa-chart-bar text-5xl text-gray-200 mb-3 block"></i>
                            <p class="text-gray-400 font-medium">
                                Tidak ada transaksi pada periode ini
                            </p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection