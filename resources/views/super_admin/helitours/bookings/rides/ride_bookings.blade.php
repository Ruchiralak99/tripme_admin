@extends('layouts.super_admin')

@section('content')
<div class="min-h-screen bg-slate-50">
    {{-- Page Header --}}
    <div class="bg-white border-b border-slate-200 px-6 py-4">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">Ride Bookings</h1>
                    <p class="text-slate-600 mt-1">Manage all helicopter ride bookings</p>
                </div>
                <div class="flex items-center gap-3">
                    <span class="bg-orange-100 text-orange-800 text-sm font-medium px-3 py-1 rounded-full">
                        {{ $rideBookings->total() }} Total Bookings
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- Alert Messages --}}
    @if (session('success'))
        <div class="max-w-7xl mx-auto px-6 py-4">
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ session('success') }}
            </div>
        </div>
    @endif

    <div class="max-w-7xl mx-auto px-6 py-6">
        {{-- Filters and Search Section --}}
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-6">
            <form method="GET" action="{{ route('super_admin.bookings.rides.bookings') }}" id="filterForm">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-6 gap-4 mb-4">
                    {{-- Search --}}
                    <div class="lg:col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-2">Search</label>
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Search by reference, name, phone, email..."
                               class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                    </div>

                    {{-- Status Filter --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Status</label>
                        <select name="status" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            <option value="">All Status</option>
                            @foreach($statuses as $status)
                                <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Payment Type Filter --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Payment Type</label>
                        <select name="payment_type" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            <option value="">All Types</option>
                            @foreach($paymentTypes as $paymentType)
                                <option value="{{ $paymentType }}" {{ request('payment_type') == $paymentType ? 'selected' : '' }}>
                                    {{ ucfirst($paymentType) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Promo Code Filter --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Promo Code</label>
                        <select name="promo_filter" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            <option value="">All Bookings</option>
                            <option value="with_promo" {{ request('promo_filter') == 'with_promo' ? 'selected' : '' }}>With Promo Code</option>
                            <option value="without_promo" {{ request('promo_filter') == 'without_promo' ? 'selected' : '' }}>Without Promo Code</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    {{-- Date From --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Date From</label>
                        <input type="date" name="date_from" value="{{ request('date_from') }}"
                               class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                    </div>

                    {{-- Date To --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Date To</label>
                        <input type="date" name="date_to" value="{{ request('date_to') }}"
                               class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                    </div>

                    {{-- Filter Actions --}}
                    <div class="flex items-end gap-2">
                        <button type="submit" class="flex-1 bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z"></path>
                            </svg>
                            Apply Filters
                        </button>
                        <a href="{{ route('super_admin.bookings.rides.bookings') }}" class="bg-slate-500 hover:bg-slate-600 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                            Clear
                        </a>
                    </div>
                </div>
            </form>
        </div>

        {{-- Bookings Table --}}
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            @if($rideBookings->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Booking Details</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Customer</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Ride Info</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Payment</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @foreach($rideBookings as $booking)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    {{-- Booking Details --}}
                                    <td class="px-6 py-4">
                                        <div class="space-y-1">
                                            <div class="text-sm font-medium text-slate-900">{{ $booking->booking_reference }}</div>
                                            <div class="text-xs text-slate-500">{{ $booking->created_at->format('M d, Y H:i') }}</div>
                                            @if($booking->promo_code)
                                                <div class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                                    </svg>
                                                    {{ $booking->promo_code }}
                                                </div>
                                            @endif
                                        </div>
                                    </td>

                                    {{-- Customer --}}
                                    <td class="px-6 py-4">
                                        <div class="space-y-1">
                                            <div class="text-sm font-medium text-slate-900">{{ $booking->full_name }}</div>
                                            <div class="text-xs text-slate-500">{{ $booking->phone_number }}</div>
                                            <div class="text-xs text-slate-500">{{ $booking->email }}</div>
                                        </div>
                                    </td>

                                    {{-- Ride Info --}}
                                    <td class="px-6 py-4">
                                        <div class="space-y-1">
                                            <div class="text-sm font-medium text-slate-900">{{ $booking->ride->name }}</div>
                                            <div class="text-xs text-slate-500">{{ $booking->city->name ?? 'N/A' }}</div>
                                            <div class="text-xs text-slate-500">{{ $booking->quantity }} {{ $booking->quantity == 1 ? 'passenger' : 'passengers' }}</div>
                                        </div>
                                    </td>

                                    {{-- Payment --}}
                                    <td class="px-6 py-4">
                                        <div class="space-y-1">
                                            <div class="text-sm font-medium text-slate-900">LKR {{ number_format($booking->total_amount, 2) }}</div>
                                            <div class="text-xs">
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                                    {{ $booking->payment_type === 'full' ? 'bg-green-100 text-green-800' :
                                                       ($booking->payment_type === 'partial' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800') }}">
                                                    {{ ucfirst($booking->payment_type) }}
                                                </span>
                                            </div>
                                            <div class="text-xs text-slate-500">{{ $booking->payment_status }}</div>
                                        </div>
                                    </td>

                                    {{-- Status --}}
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ $booking->status === 'confirmed' ? 'bg-green-100 text-green-800' :
                                               ($booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                                ($booking->status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800')) }}">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </td>

                                    {{-- Actions --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('super_admin.bookings.rides.view', $booking->id) }}"
                                               class="text-blue-600 hover:text-blue-800 transition-colors" title="View Details">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </a>
                                            <a href="{{ route('super_admin.bookings.rides.edit', $booking->id) }}"
                                               class="text-orange-600 hover:text-orange-800 transition-colors" title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </a>
                                            <form method="POST" action="{{ route('super_admin.bookings.rides.destroy', $booking->id) }}"
                                                  class="inline" onsubmit="return confirm('Are you sure you want to delete this booking?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 transition-colors" title="Delete">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="px-6 py-4 border-t border-slate-200 bg-slate-50">
                    {{ $rideBookings->withQueryString()->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="w-12 h-12 text-slate-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-slate-900 mb-2">No bookings found</h3>
                    <p class="text-slate-600">No ride bookings match your current filters.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit form when filters change
    const filterInputs = document.querySelectorAll('#filterForm select, #filterForm input[type="date"]');
    filterInputs.forEach(input => {
        input.addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });
    });

    // Submit form on search input (with debounce)
    const searchInput = document.querySelector('input[name="search"]');
    let searchTimeout;
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            document.getElementById('filterForm').submit();
        }, 500);
    });
});
</script>
@endsection
