@extends('layouts.super_admin')

@section('content')
<div class="min-h-screen bg-slate-50">
    {{-- Page Header --}}
    <div class="bg-white border-b border-slate-200 px-6 py-4">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <a href="{{ route('super_admin.bookings.rides.bookings') }}"
                           class="text-slate-400 hover:text-slate-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                        </a>
                        <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">Edit Booking</h1>
                    </div>
                    <p class="text-slate-600 mt-1">{{ $booking->booking_reference }}</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('super_admin.bookings.rides.view', $booking->id) }}"
                       class="bg-slate-600 hover:bg-slate-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                        View Details
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Alert Messages --}}
    @if (session('success'))
        <div class="max-w-4xl mx-auto px-6 py-4">
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if ($errors->any())
        <div class="max-w-4xl mx-auto px-6 py-4">
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                <div class="flex items-center mb-2">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16c-.77.833.192 2.5 1.732 2.5z">
                        </path>
                    </svg>
                    <strong>Please fix the following errors:</strong>
                </div>
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="max-w-4xl mx-auto px-6 py-6">
        <form method="POST" action="{{ route('super_admin.bookings.rides.update', $booking->id) }}">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                {{-- Booking Information (Read-only) --}}
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                    <h2 class="text-lg font-semibold text-slate-900 mb-4">Booking Information (Read-only)</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Booking Reference</label>
                            <p class="text-slate-900 font-mono bg-slate-50 rounded-lg px-3 py-2">{{ $booking->booking_reference }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Customer</label>
                            <p class="text-slate-900 bg-slate-50 rounded-lg px-3 py-2">{{ $booking->full_name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Ride</label>
                            <p class="text-slate-900 bg-slate-50 rounded-lg px-3 py-2">{{ $booking->ride->name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Total Amount</label>
                            <p class="text-slate-900 bg-slate-50 rounded-lg px-3 py-2">LKR {{ number_format($booking->total_amount, 2) }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Payment Type</label>
                            <p class="text-slate-900 bg-slate-50 rounded-lg px-3 py-2">{{ ucfirst($booking->payment_type) }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Booking Date</label>
                            <p class="text-slate-900 bg-slate-50 rounded-lg px-3 py-2">{{ $booking->created_at->format('F d, Y H:i') }}</p>
                        </div>
                    </div>
                </div>

                {{-- Editable Fields --}}
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                    <h2 class="text-lg font-semibold text-slate-900 mb-4">Update Booking Status</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Status --}}
                        <div>
                            <label for="status" class="block text-sm font-medium text-slate-700 mb-2">
                                Booking Status *
                            </label>
                            <select id="status" name="status" required
                                    class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                                <option value="pending" {{ old('status', $booking->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ old('status', $booking->status) == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="cancelled" {{ old('status', $booking->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                <option value="completed" {{ old('status', $booking->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-slate-500">Change the booking status</p>
                        </div>

                        {{-- Confirmed Date --}}
                        <div>
                            <label for="confirmed_date" class="block text-sm font-medium text-slate-700 mb-2">
                                Confirmed Date
                            </label>
                            <input type="datetime-local" id="confirmed_date" name="confirmed_date"
                                   value="{{ old('confirmed_date', $booking->confirmed_date ? $booking->confirmed_date->format('Y-m-d\TH:i') : '') }}"
                                   class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            @error('confirmed_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-slate-500">Set the confirmed date and time for the ride</p>
                        </div>
                    </div>

                    {{-- Additional Notes --}}
                    <div class="mt-6">
                        <label for="additional_notes" class="block text-sm font-medium text-slate-700 mb-2">
                            Additional Notes
                        </label>
                        <textarea id="additional_notes" name="additional_notes" rows="4"
                                  class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                                  placeholder="Add any additional notes about this booking...">{{ old('additional_notes', $booking->additional_notes) }}</textarea>
                        @error('additional_notes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-slate-500">Add internal notes or special instructions</p>
                    </div>
                </div>

                {{-- Current Passenger Details (Read-only) --}}
                @if($booking->passengers && count($booking->passengers) > 0)
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                    <h2 class="text-lg font-semibold text-slate-900 mb-4">Passenger Details (Read-only)</h2>
                    <div class="space-y-3">
                        @foreach($booking->passengers as $index => $passenger)
                            <div class="bg-slate-50 rounded-lg p-4">
                                <h3 class="font-medium text-slate-900 mb-2">Passenger {{ $index + 1 }}</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-xs font-medium text-slate-600">Name</label>
                                        <p class="text-slate-900">{{ $passenger['name'] ?? 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-slate-600">NIC</label>
                                        <p class="text-slate-900">{{ $passenger['nic'] ?? 'N/A' }}</p>
                                    </div>
                                    @if(isset($passenger['age']))
                                    <div>
                                        <label class="block text-xs font-medium text-slate-600">Age</label>
                                        <p class="text-slate-900">{{ $passenger['age'] }}</p>
                                    </div>
                                    @endif
                                    @if(isset($passenger['phone']))
                                    <div>
                                        <label class="block text-xs font-medium text-slate-600">Phone</label>
                                        <p class="text-slate-900">{{ $passenger['phone'] }}</p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Action Buttons --}}
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                    <div class="flex flex-col sm:flex-row gap-4 justify-end">
                        <a href="{{ route('super_admin.bookings.rides.bookings') }}"
                           class="px-6 py-2 border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50 transition-colors text-center">
                            Cancel
                        </a>
                        <a href="{{ route('super_admin.bookings.rides.view', $booking->id) }}"
                           class="px-6 py-2 bg-slate-600 hover:bg-slate-700 text-white rounded-lg transition-colors text-center">
                            View Details
                        </a>
                        <button type="submit"
                                class="px-6 py-2 bg-orange-600 hover:bg-orange-700 text-white rounded-lg transition-colors">
                            Update Booking
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-fill confirmed date when status changes to confirmed
    const statusSelect = document.getElementById('status');
    const confirmedDateInput = document.getElementById('confirmed_date');

    statusSelect.addEventListener('change', function() {
        if (this.value === 'confirmed' && !confirmedDateInput.value) {
            const now = new Date();
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');

            confirmedDateInput.value = `${year}-${month}-${day}T${hours}:${minutes}`;
        }
    });
});
</script>
@endsection
