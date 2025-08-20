@extends('layouts.super_admin')

@section('content')

<div class="p-6">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Air Taxi Bookings</h1>
            <p class="text-slate-600 mt-1">Manage and track all air taxi bookings</p>
        </div>
    </div>

    {{-- Filters and Search --}}
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-4 mb-6">
        <form method="GET" action="{{ route('super_admin.bookings.air_taxi.bookings') }}" class="flex flex-col lg:flex-row gap-4">
            {{-- Search --}}
            <div class="flex-1">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Search by name, phone, email, or tour type..."
                           class="block w-full pl-10 pr-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                </div>
            </div>

            {{-- Date Filter --}}
            <div class="flex gap-2">
                <select name="filter" class="px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                    <option value="">All Time</option>
                    <option value="today" {{ request('filter') == 'today' ? 'selected' : '' }}>Today</option>
                    <option value="week" {{ request('filter') == 'week' ? 'selected' : '' }}>Last Week</option>
                    <option value="month" {{ request('filter') == 'month' ? 'selected' : '' }}>Last Month</option>
                </select>

                <button type="submit" class="px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors">
                    Filter
                </button>

                @if(request()->hasAny(['search', 'filter']))
                    <a href="{{ route('super_admin.bookings.air_taxi.bookings') }}"
                       class="px-4 py-2 bg-slate-500 text-white rounded-lg hover:bg-slate-600 transition-colors">
                        Clear
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Bookings Table --}}
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden">
        @if($airTaxiBookings->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Contact</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Aircraft</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Tour Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Date & Time</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Passengers</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        @foreach($airTaxiBookings as $booking)
                            <tr class="hover:bg-slate-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">
                                    #{{ $booking->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-slate-900">{{ $booking->full_name }}</div>
                                    @if($booking->user)
                                        <div class="text-sm text-slate-500">{{ $booking->user->email }}</div>
                                    @else
                                        <div class="text-sm text-slate-500">Guest Booking</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-slate-900">{{ $booking->phone_number }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($booking->aircraft)
                                        <div class="text-sm font-medium text-slate-900">{{ $booking->aircraft->name }}</div>
                                        <div class="text-sm text-slate-500">{{ $booking->aircraft->passenger_seats }} seats</div>
                                    @else
                                        <span class="text-sm text-slate-400">Aircraft not found</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-slate-900">{{ $booking->tour_type }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-slate-900">{{ $booking->booking_date->format('M d, Y') }}</div>
                                    <div class="text-sm text-slate-500">{{ $booking->booking_time->format('H:i A') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-slate-900">{{ count($booking->passengers) }} passengers</div>
                                    <div class="text-sm text-slate-500">
                                        @foreach($booking->passengers as $passenger)
                                            <div class="truncate">{{ $passenger['name'] }}</div>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'confirmed' => 'bg-green-100 text-green-800',
                                            'cancelled' => 'bg-red-100 text-red-800',
                                            'completed' => 'bg-blue-100 text-blue-800'
                                        ];
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$booking->status] ?? 'bg-slate-100 text-slate-800' }}">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('super_admin.bookings.air_taxi.view', $booking->id) }}"
                                           class="text-blue-600 hover:text-blue-900 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>
                                        <a href="{{ route('super_admin.bookings.air_taxi.edit', $booking->id) }}"
                                           class="text-orange-600 hover:text-orange-900 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>

                                        {{-- Quick Status Update --}}
                                        <div class="relative inline-block text-left">
                                            <select onchange="updateStatus({{ $booking->id }}, this.value)"
                                                    class="text-xs border-0 bg-transparent focus:ring-0 text-slate-600">
                                                <option value="">Status</option>
                                                <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                                <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                            </select>
                                        </div>

                                        <form method="POST" action="{{ route('super_admin.bookings.air_taxi.delete', $booking->id) }}"
                                              class="inline" onsubmit="return confirm('Are you sure you want to delete this booking?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 transition-colors">
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
            @if($airTaxiBookings->hasPages())
                <div class="px-6 py-4 border-t border-slate-200">
                    {{ $airTaxiBookings->appends(request()->all())->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2M4 13h2m13-4h-3"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-slate-900">No bookings found</h3>
                <p class="mt-1 text-sm text-slate-500">
                    @if(request()->hasAny(['search', 'filter']))
                        Try adjusting your search or filter criteria.
                    @else
                        No air taxi bookings have been made yet.
                    @endif
                </p>
            </div>
        @endif
    </div>
</div>

{{-- Status Update Script --}}
<script>
function updateStatus(bookingId, status) {
    if (!status) return;

    fetch(`{{ url('super_admin/bookings/air-taxi-bookings') }}/${bookingId}/status`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ status: status })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error updating status. Please try again.');
    });
}
</script>

@endsection
