@extends('admin.layouts.app')
@section('title', 'Manajemen Pemesanan')
@section('content')

{{-- Filter --}}
<div class="bg-white rounded-2xl border border-gray-200 p-4 mb-6 shadow-sm">
    <form method="GET" class="flex gap-3 flex-wrap items-end">
        <div class="flex-1 min-w-48">
            <label class="block text-xs font-semibold text-gray-500 mb-1">Cari</label>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Kode booking / nama user..."
                   class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 transition">
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1">Status</label>
            <select name="status" class="border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-red-500 transition">
                <option value="">Semua Status</option>
                <option value="pending"   {{ request('status') === 'pending'   ? 'selected' : '' }}>Pending</option>
                <option value="paid"      {{ request('status') === 'paid'      ? 'selected' : '' }}>Paid</option>
                <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>
        <button type="submit"
                class="bg-red-600 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-red-700 transition flex items-center gap-2">
            <i class="fas fa-search"></i> Filter
        </button>
        <a href="{{ route('admin.bookings.index') }}"
           class="px-5 py-2.5 border border-gray-300 rounded-xl text-sm text-gray-600 hover:bg-gray-50 transition">
            Reset
        </a>
    </form>
</div>

{{-- Stats --}}
<div class="grid grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-xl border border-gray-200 p-4 flex items-center gap-3">
        <div class="w-10 h-10 bg-yellow-100 rounded-xl flex items-center justify-center">
            <i class="fas fa-clock text-yellow-600"></i>
        </div>
        <div>
            <p class="text-xs text-gray-400">Pending</p>
            <p class="text-xl font-black text-gray-900">
                {{ \App\Models\Booking::where('status','pending')->count() }}
            </p>
        </div>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-4 flex items-center gap-3">
        <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
            <i class="fas fa-check text-green-600"></i>
        </div>
        <div>
            <p class="text-xs text-gray-400">Paid</p>
            <p class="text-xl font-black text-gray-900">
                {{ \App\Models\Booking::where('status','paid')->count() }}
            </p>
        </div>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-4 flex items-center gap-3">
        <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center">
            <i class="fas fa-times text-red-600"></i>
        </div>
        <div>
            <p class="text-xs text-gray-400">Cancelled</p>
            <p class="text-xl font-black text-gray-900">
                {{ \App\Models\Booking::where('status','cancelled')->count() }}
            </p>
        </div>
    </div>
</div>

{{-- Tabel --}}
<div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full min-w-max">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="text-left px-4 py-3 text-xs font-bold text-gray-400 uppercase">Kode</th>
                    <th class="text-left px-4 py-3 text-xs font-bold text-gray-400 uppercase">User</th>
                    <th class="text-left px-4 py-3 text-xs font-bold text-gray-400 uppercase">Film</th>
                    <th class="text-left px-4 py-3 text-xs font-bold text-gray-400 uppercase">Kursi</th>
                    <th class="text-left px-4 py-3 text-xs font-bold text-gray-400 uppercase">Total</th>
                    <th class="text-left px-4 py-3 text-xs font-bold text-gray-400 uppercase">Status</th>
                    <th class="text-left px-4 py-3 text-xs font-bold text-gray-400 uppercase">Tanggal</th>
                    <th class="text-left px-4 py-3 text-xs font-bold text-gray-400 uppercase">Update Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($bookings as $booking)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 py-3 font-mono text-xs font-bold text-red-600 whitespace-nowrap">
                        {{ $booking->kode_booking }}
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-700 whitespace-nowrap">
                        {{ $booking->user->name ?? '-' }}
                    </td>
                    <td class="px-4 py-3">
                        <p class="text-sm font-semibold text-gray-800 max-w-[180px] truncate">
                            {{ $booking->schedule->film->judul ?? '-' }}
                        </p>
                        <p class="text-xs text-gray-400">{{ $booking->schedule->studio->nama ?? '' }}</p>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex flex-wrap gap-1">
                            @foreach($booking->bookingSeats as $bs)
                            <span class="text-xs bg-gray-100 text-gray-600 px-1.5 py-0.5 rounded font-medium">
                                {{ $bs->seat->nomor_kursi }}
                            </span>
                            @endforeach
                        </div>
                    </td>
                    <td class="px-4 py-3 text-sm font-bold text-gray-900 whitespace-nowrap">
                        Rp {{ number_format($booking->total_harga, 0, ',', '.') }}
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        @if($booking->status === 'paid')
                        <span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full">
                            <i class="fas fa-check mr-1"></i>Paid
                        </span>
                        @elseif($booking->status === 'pending')
                        <span class="px-2 py-1 bg-yellow-100 text-yellow-700 text-xs font-bold rounded-full">
                            <i class="fas fa-clock mr-1"></i>Pending
                        </span>
                        @else
                        <span class="px-2 py-1 bg-red-100 text-red-700 text-xs font-bold rounded-full">
                            <i class="fas fa-times mr-1"></i>Cancelled
                        </span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-xs text-gray-400 whitespace-nowrap">
                        {{ $booking->created_at->format('d M Y') }}
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        <form action="{{ route('admin.bookings.update-status', $booking) }}"
                              method="POST" class="flex items-center gap-2">
                            @csrf @method('PATCH')
                            <select name="status"
                                    class="border border-gray-200 rounded-lg px-2 py-1.5 text-xs focus:outline-none focus:border-red-500 transition">
                                <option value="pending"   {{ $booking->status === 'pending'   ? 'selected' : '' }}>Pending</option>
                                <option value="paid"      {{ $booking->status === 'paid'      ? 'selected' : '' }}>Paid</option>
                                <option value="cancelled" {{ $booking->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            <button type="submit"
                                    class="px-3 py-1.5 bg-red-600 text-white rounded-lg text-xs font-semibold hover:bg-red-700 transition whitespace-nowrap">
                                Update
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-16 text-center">
                        <i class="fas fa-inbox text-5xl text-gray-200 mb-3 block"></i>
                        <p class="text-gray-400 font-medium">Belum ada pemesanan</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($bookings->hasPages())
    <div class="px-6 py-4 border-t border-gray-100">{{ $bookings->links() }}</div>
    @endif
</div>
@endsection