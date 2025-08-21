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
                        <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">Booking Details</h1>
                    </div>
                    <p class="text-slate-600 mt-1">{{ $booking->booking_reference }}</p>
                </div>
                <div class="flex items-center gap-3">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                        {{ $booking->status === 'confirmed' ? 'bg-green-100 text-green-800' :
                           ($booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                            ($booking->status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800')) }}">
                        {{ ucfirst($booking->status) }}
                    </span>
                    <a href="{{ route('super_admin.bookings.rides.edit', $booking->id) }}"
                       class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                        Edit Booking
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 py-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Main Information --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Booking Information --}}
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                    <h2 class="text-lg font-semibold text-slate-900 mb-4">Booking Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Booking Reference</label>
                            <p class="text-slate-900 font-mono">{{ $booking->booking_reference }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Booking Date</label>
                            <p class="text-slate-900">{{ $booking->created_at->format('F d, Y') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Preferred Date</label>
                            <p class="text-slate-900">{{ $booking->preferred_date ? $booking->preferred_date->format('F d, Y') : 'Not specified' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Confirmed Date</label>
                            <p class="text-slate-900">{{ $booking->confirmed_date ? $booking->confirmed_date->format('F d, Y') : 'Not confirmed' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Ride</label>
                            <p class="text-slate-900">{{ $booking->ride->name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">City</label>
                            <p class="text-slate-900">{{ $booking->city->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Quantity</label>
                            <p class="text-slate-900">{{ $booking->quantity }} {{ $booking->quantity == 1 ? 'passenger' : 'passengers' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Status</label>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $booking->status === 'confirmed' ? 'bg-green-100 text-green-800' :
                                   ($booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                    ($booking->status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800')) }}">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </div>
                    </div>
                    @if($booking->additional_notes)
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-slate-700 mb-1">Additional Notes</label>
                            <p class="text-slate-900 bg-slate-50 rounded-lg p-3">{{ $booking->additional_notes }}</p>
                        </div>
                    @endif
                </div>

                {{-- Customer Information --}}
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                    <h2 class="text-lg font-semibold text-slate-900 mb-4">Customer Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Full Name</label>
                            <p class="text-slate-900">{{ $booking->full_name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Phone Number</label>
                            <p class="text-slate-900">{{ $booking->phone_number }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                            <p class="text-slate-900">{{ $booking->email }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">User Account</label>
                            <p class="text-slate-900">{{ $booking->user->name ?? 'Guest User' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Passenger Details --}}
                @if($booking->passengers && count($booking->passengers) > 0)
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                    <h2 class="text-lg font-semibold text-slate-900 mb-4">Passenger Details</h2>
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

                {{-- Payment History --}}
                @if($booking->payments->count() > 0)
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                    <h2 class="text-lg font-semibold text-slate-900 mb-4">Payment History</h2>
                    <div class="space-y-4">
                        @foreach($booking->payments as $payment)
                            <div class="border border-slate-200 rounded-lg p-4">
                                <div class="flex items-center justify-between mb-3">
                                    <div>
                                        <h3 class="font-medium text-slate-900">{{ $payment->payment_reference }}</h3>
                                        <p class="text-sm text-slate-600">{{ $payment->created_at->format('F d, Y H:i') }}</p>
                                    </div>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $payment->status === 'verified' ? 'bg-green-100 text-green-800' :
                                           ($payment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                        {{ ucfirst($payment->status) }}
                                    </span>
                                </div>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-sm">
                                    <div>
                                        <label class="block text-xs font-medium text-slate-600">Amount</label>
                                        <p class="text-slate-900">LKR {{ number_format($payment->amount, 2) }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-slate-600">Payment Type</label>
                                        <p class="text-slate-900">{{ ucfirst($payment->payment_type) }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-slate-600">Method</label>
                                        <p class="text-slate-900">{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-slate-600">Promo Code Used</label>
                                        @if($payment->has_promo_code && $payment->promoCode)
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                {{ $payment->promoCode->code }}
                                            </span>
                                        @else
                                            <p class="text-slate-500">No</p>
                                        @endif
                                    </div>
                                </div>
                                @if($payment->reference_number)
                                    <div class="mt-2">
                                        <label class="block text-xs font-medium text-slate-600">Reference Number</label>
                                        <p class="text-slate-900">{{ $payment->reference_number }}</p>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            {{-- Sidebar --}}
            <div class="space-y-6">
                {{-- Pricing Summary --}}
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                    <h2 class="text-lg font-semibold text-slate-900 mb-4">Pricing Summary</h2>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-slate-600">Base Price</span>
                            <span class="text-slate-900">LKR {{ number_format($booking->base_price, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-600">Quantity ({{ $booking->quantity }})</span>
                            <span class="text-slate-900">LKR {{ number_format($booking->subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-600">Tax</span>
                            <span class="text-slate-900">LKR {{ number_format($booking->tax_amount, 2) }}</span>
                        </div>
                        @if($booking->promo_discount > 0)
                        <div class="flex justify-between text-green-600">
                            <span>Promo Discount
                                @if($booking->promo_code)
                                    <span class="text-xs">({{ $booking->promo_code }})</span>
                                @endif
                            </span>
                            <span>-LKR {{ number_format($booking->promo_discount, 2) }}</span>
                        </div>
                        @endif
                        @if($booking->full_payment_discount > 0)
                        <div class="flex justify-between text-blue-600">
                            <span>Full Payment Discount (5%)</span>
                            <span>-LKR {{ number_format($booking->full_payment_discount, 2) }}</span>
                        </div>
                        @endif
                        <hr class="border-slate-200">
                        <div class="flex justify-between font-semibold text-lg">
                            <span class="text-slate-900">Total Amount</span>
                            <span class="text-slate-900">LKR {{ number_format($booking->total_amount, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-600">Paid Amount</span>
                            <span class="text-slate-900">LKR {{ number_format($booking->paid_amount, 2) }}</span>
                        </div>
                        @if($booking->remaining_amount > 0)
                        <div class="flex justify-between text-red-600 font-medium">
                            <span>Remaining Amount</span>
                            <span>LKR {{ number_format($booking->remaining_amount, 2) }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Payment Status --}}
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                    <h2 class="text-lg font-semibold text-slate-900 mb-4">Payment Status</h2>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Payment Type</label>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-sm font-medium
                                {{ $booking->payment_type === 'full' ? 'bg-green-100 text-green-800' :
                                   ($booking->payment_type === 'partial' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800') }}">
                                {{ ucfirst($booking->payment_type) }}
                            </span>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Payment Status</label>
                            <p class="text-slate-900">{{ $booking->payment_status }}</p>
                        </div>
                        @if($booking->promo_code)
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Promo Code Applied</label>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                                {{ $booking->promo_code }}
                            </span>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Quick Actions --}}
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                    <h2 class="text-lg font-semibold text-slate-900 mb-4">Quick Actions</h2>
                    <div class="space-y-3">
                        <a href="{{ route('super_admin.bookings.rides.edit', $booking->id) }}"
                           class="w-full bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-lg font-medium transition-colors text-center block">
                            Edit Booking
                        </a>
                        <form method="POST" action="{{ route('super_admin.bookings.rides.destroy', $booking->id) }}"
                              onsubmit="return confirm('Are you sure you want to delete this booking?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                                Delete Booking
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
