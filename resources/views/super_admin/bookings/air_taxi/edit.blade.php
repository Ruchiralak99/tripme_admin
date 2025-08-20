@extends('layouts.super_admin')

@section('content')
    <div class="p-6">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Edit Booking</h1>
                <p class="text-slate-600 mt-1">Booking ID: #{{ $booking->id }}</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('super_admin.bookings.air_taxi.view', $booking->id) }}"
                    class="px-4 py-2 bg-slate-500 text-white rounded-lg hover:bg-slate-600 transition-colors">
                    View Details
                </a>
                <a href="{{ route('super_admin.bookings.air_taxi.bookings') }}"
                    class="px-4 py-2 bg-slate-500 text-white rounded-lg hover:bg-slate-600 transition-colors">
                    Back to Bookings
                </a>
            </div>
        </div>

        {{-- Edit Form --}}
        <form method="POST" action="{{ route('super_admin.bookings.air_taxi.update', $booking->id) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Main Form --}}
                <div class="lg:col-span-2 space-y-6">
                    {{-- Customer Information --}}
                    <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                        <h3 class="text-lg font-semibold text-slate-900 mb-4">Customer Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="full_name" class="block text-sm font-medium text-slate-700 mb-2">
                                    Full Name *
                                </label>

                                <input type="text" id="full_name" name="full_name"
                                    value="{{ old('full_name', $booking->full_name) }}" required
                                    @class([
                                        'w-full px-3 py-2 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500',
                                        'border border-slate-300' => !$errors->has('full_name'),
                                        'border border-red-500' => $errors->has('full_name'),
                                    ])>

                                @error('full_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="phone_number" class="block text-sm font-medium text-slate-700 mb-2">
                                    Phone Number *
                                </label>

                                <input type="tel" id="phone_number" name="phone_number"
                                    value="{{ old('phone_number', $booking->phone_number) }}" required
                                    @class([
                                        'w-full px-3 py-2 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500',
                                        'border border-slate-300' => !$errors->has('phone_number'),
                                        'border border-red-500' => $errors->has('phone_number'),
                                    ])>

                                @error('phone_number')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-slate-700 mb-1">Email Address</label>
                                <p class="text-slate-600 text-sm">
                                    @if ($booking->user)
                                        {{ $booking->user->email }} (Registered User)
                                    @else
                                        Guest Booking (No account associated)
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Booking Details --}}
                    <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                        <h3 class="text-lg font-semibold text-slate-900 mb-4">Booking Details</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="md:col-span-2">
                                <label for="tour_type" class="block text-sm font-medium text-slate-700 mb-2">
                                    Tour Type (Reason) *
                                </label>

                                <input type="text" id="tour_type" name="tour_type"
                                    value="{{ old('tour_type', $booking->tour_type) }}" required
                                    placeholder="e.g., City Tour, Airport Transfer, Business Meeting"
                                    @class([
                                        'w-full px-3 py-2 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500',
                                        'border border-slate-300' => !$errors->has('tour_type'),
                                        'border border-red-500' => $errors->has('tour_type'),
                                    ])>

                                @error('tour_type')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="aircraft_id"
                                    class="block text-sm font-medium text-slate-700 mb-2">Aircraft</label>
                                <p class="text-slate-600 text-sm">
                                    @if ($booking->aircraft)
                                        {{ $booking->aircraft->name }} ({{ $booking->aircraft->passenger_seats }} seats)
                                    @else
                                        Aircraft not available
                                    @endif
                                </p>
                                <p class="text-xs text-slate-500 mt-1">Aircraft cannot be changed after booking</p>
                            </div>
                            <div></div>
                            <div>
                                <label for="booking_date" class="block text-sm font-medium text-slate-700 mb-2">
                                    Booking Date *
                                </label>

                                <input type="date" id="booking_date" name="booking_date"
                                    value="{{ old('booking_date', $booking->booking_date->format('Y-m-d')) }}" required
                                    min="{{ now()->addDays(1)->format('Y-m-d') }}" @class([
                                        'w-full px-3 py-2 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500',
                                        'border border-slate-300' => !$errors->has('booking_date'),
                                        'border border-red-500' => $errors->has('booking_date'),
                                    ])>

                                @error('booking_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="booking_time" class="block text-sm font-medium text-slate-700 mb-2">
                                    Booking Time *
                                </label>

                                <input type="time" id="booking_time" name="booking_time"
                                    value="{{ old('booking_time', $booking->booking_time->format('H:i')) }}" required
                                    @class([
                                        'w-full px-3 py-2 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500',
                                        'border border-slate-300' => !$errors->has('booking_time'),
                                        'border border-red-500' => $errors->has('booking_time'),
                                    ])>

                                @error('booking_time')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>
                    </div>

                    {{-- Passenger Details --}}
                    <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                        <h3 class="text-lg font-semibold text-slate-900 mb-4">Passenger Information</h3>
                        <div id="passengerContainer" class="space-y-4">
                            @foreach ($booking->passengers as $index => $passenger)
                                <div class="passenger-item border border-slate-200 rounded-lg p-4">
                                    <div class="flex items-center justify-between mb-3">
                                        <h4 class="font-medium text-slate-900">Passenger {{ $index + 1 }}</h4>
                                        @if ($index > 0)
                                            <button type="button" onclick="removePassenger(this)"
                                                class="text-red-600 hover:text-red-800 text-sm">
                                                Remove
                                            </button>
                                        @endif
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-slate-700 mb-2">Full Name *</label>
                                            <input type="text" name="passengers[{{ $index }}][name]"
                                                value="{{ old('passengers.' . $index . '.name', $passenger['name']) }}"
                                                required
                                                class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-slate-700 mb-2">NIC Number
                                                *</label>
                                            <input type="text" name="passengers[{{ $index }}][nic]"
                                                value="{{ old('passengers.' . $index . '.nic', $passenger['nic']) }}"
                                                required
                                                class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-4">
                            <button type="button" id="addPassengerBtn"
                                class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors">
                                Add Passenger
                            </button>
                            <p class="text-xs text-slate-500 mt-1">
                                Maximum passengers: {{ $booking->aircraft ? $booking->aircraft->passenger_seats : 'N/A' }}
                            </p>
                        </div>

                        @error('passengers')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Notes --}}
                    <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                        <h3 class="text-lg font-semibold text-slate-900 mb-4">Notes</h3>
                        <div>
                            <label for="notes" class="block text-sm font-medium text-slate-700 mb-2">Additional
                                Notes</label>
                            <textarea id="notes" name="notes" rows="4"
                                placeholder="Add any special requirements or notes about this booking..."
                                class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">{{ old('notes', $booking->notes) }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Sidebar --}}
                <div class="space-y-6">
                    {{-- Status & Actions --}}
                    <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                        <h3 class="text-lg font-semibold text-slate-900 mb-4">Status & Actions</h3>

                        {{-- Current Status --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-slate-700 mb-2">Current Status</label>
                            @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                    'confirmed' => 'bg-green-100 text-green-800 border-green-200',
                                    'cancelled' => 'bg-red-100 text-red-800 border-red-200',
                                    'completed' => 'bg-blue-100 text-blue-800 border-blue-200',
                                ];
                            @endphp
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium border {{ $statusColors[$booking->status] ?? 'bg-slate-100 text-slate-800 border-slate-200' }}">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </div>

                        {{-- Update Status --}}
                        <div class="mb-6">
                            <label for="status" class="block text-sm font-medium text-slate-700 mb-2">Update Status
                                *</label>
                            <select name="status" id="status" required
                                class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                                <option value="pending"
                                    {{ old('status', $booking->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed"
                                    {{ old('status', $booking->status) == 'confirmed' ? 'selected' : '' }}>Confirmed
                                </option>
                                <option value="cancelled"
                                    {{ old('status', $booking->status) == 'cancelled' ? 'selected' : '' }}>Cancelled
                                </option>
                                <option value="completed"
                                    {{ old('status', $booking->status) == 'completed' ? 'selected' : '' }}>Completed
                                </option>
                            </select>
                        </div>

                        {{-- Save Button --}}
                        <button type="submit"
                            class="w-full px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors font-medium">
                            Update Booking
                        </button>
                    </div>

                    {{-- Booking Info --}}
                    <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                        <h3 class="text-lg font-semibold text-slate-900 mb-4">Booking Information</h3>
                        <div class="space-y-3 text-sm">
                            <div>
                                <span class="font-medium text-slate-700">Created:</span>
                                <span class="text-slate-600">{{ $booking->created_at->format('M j, Y g:i A') }}</span>
                            </div>
                            <div>
                                <span class="font-medium text-slate-700">Last Updated:</span>
                                <span class="text-slate-600">{{ $booking->updated_at->format('M j, Y g:i A') }}</span>
                            </div>
                            @if ($booking->confirmed_at)
                                <div>
                                    <span class="font-medium text-slate-700">Confirmed:</span>
                                    <span
                                        class="text-slate-600">{{ $booking->confirmed_at->format('M j, Y g:i A') }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- JavaScript for Dynamic Passengers --}}
    <script>
        let passengerIndex = {{ count($booking->passengers) }};
        const maxPassengers = {{ $booking->aircraft ? $booking->aircraft->passenger_seats : 10 }};

        document.getElementById('addPassengerBtn').addEventListener('click', function() {
            if (document.querySelectorAll('.passenger-item').length >= maxPassengers) {
                alert(`Maximum ${maxPassengers} passengers allowed for this aircraft.`);
                return;
            }

            const container = document.getElementById('passengerContainer');
            const passengerHtml = `
        <div class="passenger-item border border-slate-200 rounded-lg p-4">
            <div class="flex items-center justify-between mb-3">
                <h4 class="font-medium text-slate-900">Passenger ${passengerIndex + 1}</h4>
                <button type="button" onclick="removePassenger(this)" class="text-red-600 hover:text-red-800 text-sm">
                    Remove
                </button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Full Name *</label>
                    <input type="text" name="passengers[${passengerIndex}][name]" required
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">NIC Number *</label>
                    <input type="text" name="passengers[${passengerIndex}][nic]" required
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                </div>
            </div>
        </div>
    `;

            container.insertAdjacentHTML('beforeend', passengerHtml);
            passengerIndex++;
            updatePassengerNumbers();
        });

        function removePassenger(button) {
            const passengerItem = button.closest('.passenger-item');
            passengerItem.remove();
            updatePassengerNumbers();
        }

        function updatePassengerNumbers() {
            const passengerItems = document.querySelectorAll('.passenger-item');
            passengerItems.forEach((item, index) => {
                const title = item.querySelector('h4');
                title.textContent = `Passenger ${index + 1}`;

                // Update input names to maintain proper indexing
                const inputs = item.querySelectorAll('input[name^="passengers"]');
                inputs.forEach(input => {
                    const name = input.getAttribute('name');
                    const field = name.includes('[name]') ? 'name' : 'nic';
                    input.setAttribute('name', `passengers[${index}][${field}]`);
                });
            });
        }
    </script>
@endsection
