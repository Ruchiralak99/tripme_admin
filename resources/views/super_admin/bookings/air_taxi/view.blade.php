@extends('layouts.super_admin')

@section('content')

<div class="p-6">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Booking Details</h1>
            <p class="text-slate-600 mt-1">Booking ID: #{{ $booking->id }}</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('super_admin.bookings.air_taxi.edit', $booking->id) }}"
               class="px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors">
                Edit Booking
            </a>
            <a href="{{ route('super_admin.bookings.air_taxi.bookings') }}"
               class="px-4 py-2 bg-slate-500 text-white rounded-lg hover:bg-slate-600 transition-colors">
                Back to Bookings
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Main Details --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Customer Information --}}
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                <h3 class="text-lg font-semibold text-slate-900 mb-4">Customer Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Full Name</label>
                        <p class="text-slate-900">{{ $booking->full_name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Phone Number</label>
                        <p class="text-slate-900">{{ $booking->phone_number }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Email Address</label>
                        <p class="text-slate-900">
                            @if($booking->user)
                                {{ $booking->user->email }}
                            @else
                                <span class="text-slate-500 italic">Guest Booking (No account)</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            {{-- Booking Details --}}
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                <h3 class="text-lg font-semibold text-slate-900 mb-4">Booking Details</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Tour Type</label>
                        <p class="text-slate-900">{{ $booking->tour_type }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Aircraft</label>
                        <p class="text-slate-900">
                            @if($booking->aircraft)
                                {{ $booking->aircraft->name }} ({{ $booking->aircraft->passenger_seats }} seats)
                            @else
                                <span class="text-red-500">Aircraft not found</span>
                            @endif
                        </p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Booking Date</label>
                        <p class="text-slate-900">{{ $booking->booking_date->format('l, F j, Y') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Booking Time</label>
                        <p class="text-slate-900">{{ $booking->booking_time->format('g:i A') }}</p>
                    </div>
                    @if($booking->total_amount)
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Total Amount</label>
                            <p class="text-slate-900 font-semibold">${{ number_format($booking->total_amount, 2) }}</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Passenger Details --}}
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                <h3 class="text-lg font-semibold text-slate-900 mb-4">Passenger Information</h3>
                <div class="space-y-4">
                    @foreach($booking->passengers as $index => $passenger)
                        <div class="border border-slate-200 rounded-lg p-4">
                            <h4 class="font-medium text-slate-900 mb-2">Passenger {{ $index + 1 }}</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Full Name</label>
                                    <p class="text-slate-900">{{ $passenger['name'] }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">NIC Number</label>
                                    <p class="text-slate-900">{{ $passenger['nic'] }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Notes --}}
            @if($booking->notes)
                <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4">Notes</h3>
                    <p class="text-slate-700 whitespace-pre-wrap">{{ $booking->notes }}</p>
                </div>
            @endif
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            {{-- Status Management --}}
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                <h3 class="text-lg font-semibold text-slate-900 mb-4">Status Management</h3>

                {{-- Current Status --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Current Status</label>
                    @php
                        $statusColors = [
                            'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                            'confirmed' => 'bg-green-100 text-green-800 border-green-200',
                            'cancelled' => 'bg-red-100 text-red-800 border-red-200',
                            'completed' => 'bg-blue-100 text-blue-800 border-blue-200'
                        ];
                    @endphp
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium border {{ $statusColors[$booking->status] ?? 'bg-slate-100 text-slate-800 border-slate-200' }}">
                        {{ ucfirst($booking->status) }}
                    </span>
                </div>

                {{-- Update Status Form --}}
                <form method="POST" action="{{ route('super_admin.bookings.air_taxi.status', $booking->id) }}">
                    @csrf
                    @method('PATCH')
                    <div class="mb-4">
                        <label for="status" class="block text-sm font-medium text-slate-700 mb-2">Update Status</label>
                        <select name="status" id="status" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>
                    <button type="submit" class="w-full px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors">
                        Update Status
                    </button>
                </form>
            </div>

            {{-- Booking Timeline --}}
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                <h3 class="text-lg font-semibold text-slate-900 mb-4">Booking Timeline</h3>
                <div class="space-y-3">
                    <div class="flex items-center text-sm">
                        <div class="w-2 h-2 bg-blue-500 rounded-full mr-3"></div>
                        <div>
                            <p class="font-medium text-slate-900">Booking Created</p>
                            <p class="text-slate-500">{{ $booking->created_at->format('M j, Y g:i A') }}</p>
                        </div>
                    </div>

                    @if($booking->confirmed_at)
                        <div class="flex items-center text-sm">
                            <div class="w-2 h-2 bg-green-500 rounded-full mr-3"></div>
                            <div>
                                <p class="font-medium text-slate-900">Booking Confirmed</p>
                                <p class="text-slate-500">{{ $booking->confirmed_at->format('M j, Y g:i A') }}</p>
                            </div>
                        </div>
                    @endif

                    <div class="flex items-center text-sm">
                        <div class="w-2 h-2 bg-slate-300 rounded-full mr-3"></div>
                        <div>
                            <p class="font-medium text-slate-900">Last Updated</p>
                            <p class="text-slate-500">{{ $booking->updated_at->format('M j, Y g:i A') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                <h3 class="text-lg font-semibold text-slate-900 mb-4">Quick Actions</h3>
                <div class="space-y-3">
                    <a href="{{ route('super_admin.bookings.air_taxi.edit', $booking->id) }}"
                       class="block w-full px-4 py-2 bg-orange-500 text-white text-center rounded-lg hover:bg-orange-600 transition-colors">
                        Edit Booking
                    </a>

                    <form method="POST" action="{{ route('super_admin.bookings.air_taxi.delete', $booking->id) }}"
                          onsubmit="return confirm('Are you sure you want to delete this booking? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="block w-full px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors">
                            Delete Booking
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
