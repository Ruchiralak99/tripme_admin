@extends('layouts.super_admin')

@section('content')

    {{-- Page Header --}}
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <a href="{{ route('super_admin.packages.rides.rides') }}"
                        class="text-slate-400 hover:text-slate-600 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                    </a>
                    <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">Book Helicopter Ride</h1>
                </div>
                <p class="text-slate-600 mt-1">Complete your booking for {{ $ride->name }}</p>
            </div>
        </div>
    </div>

    {{-- Alert Messages --}}
    @if (session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
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
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Left Column: Booking Form --}}
        <div class="lg:col-span-2">
            <form method="POST" action="{{ route('super_admin.packages.rides.book.store') }}" enctype="multipart/form-data"
                id="bookingForm">
                @csrf
                <input type="hidden" name="ride_id" value="{{ $ride->id }}">

                {{-- Selected Package Card --}}
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="bg-primary-100 text-primary-600 rounded-lg p-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-semibold text-slate-900">Selected Package</h2>
                    </div>

                    <div class="flex items-center gap-4 p-4 bg-slate-50 rounded-lg">
                        @if ($ride->image_path)
                            <img src="{{ asset('storage/' . $ride->image_path) }}" alt="{{ $ride->name }}"
                                class="w-16 h-16 rounded-lg object-cover">
                        @else
                            <div class="w-16 h-16 bg-slate-200 rounded-lg flex items-center justify-center">
                                <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                            </div>
                        @endif
                        <div class="flex-1">
                            <h3 class="font-semibold text-slate-900">{{ $ride->name }}</h3>
                            <p class="text-sm text-slate-600">{{ $ride->description }}</p>
                            <div class="flex items-center gap-4 mt-2 text-sm text-slate-500">
                                @if ($ride->duration)
                                    <span>{{ $ride->duration }}</span>
                                @endif
                                @if ($ride->passenger_capacity)
                                    <span>Max {{ $ride->passenger_capacity }} passengers</span>
                                @endif
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-lg font-bold text-primary-600">Rs. {{ number_format($ride->price_lkr, 2) }}
                            </div>
                            <div class="text-sm text-slate-500">per person</div>
                        </div>
                    </div>
                </div>

                {{-- Customer Information --}}
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-6">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="bg-blue-100 text-blue-600 rounded-lg p-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-semibold text-slate-900">Customer Information</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="full_name" class="block text-sm font-medium text-slate-700 mb-2">
                                Full Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="full_name" id="full_name" value="{{ old('full_name') }}"
                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                required>
                        </div>

                        <div>
                            <label for="phone_number" class="block text-sm font-medium text-slate-700 mb-2">
                                Phone Number <span class="text-red-500">*</span>
                            </label>
                            <input type="tel" name="phone_number" id="phone_number" value="{{ old('phone_number') }}"
                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                required>
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-slate-700 mb-2">
                                Email Address <span class="text-red-500">*</span>
                            </label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}"
                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                required>
                        </div>

                        <div>
                            <label for="city_id" class="block text-sm font-medium text-slate-700 mb-2">
                                City <span class="text-red-500">*</span>
                            </label>
                            <select name="city_id" id="city_id"
                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                required>
                                <option value="">Select City</option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}"
                                        {{ old('city_id') == $city->id ? 'selected' : '' }}>
                                        {{ $city->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Quantity & Passengers --}}
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-6">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="bg-green-100 text-green-600 rounded-lg p-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-semibold text-slate-900">Passengers Information</h2>
                    </div>

                    <div class="mb-6">
                        <label for="quantity" class="block text-sm font-medium text-slate-700 mb-2">
                            Number of Passengers <span class="text-red-500">*</span>
                            @if ($ride->passenger_capacity)
                                <span class="text-sm text-slate-500">(Max: {{ $ride->passenger_capacity }})</span>
                            @endif
                        </label>
                        <input type="number" name="quantity" id="quantity" value="{{ old('quantity', 1) }}"
                            min="1" @if ($ride->passenger_capacity) max="{{ $ride->passenger_capacity }}" @endif
                            class="w-32 px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                            required onchange="updatePassengerFields()">
                    </div>

                    <div id="passenger-fields">
                        {{-- Passenger fields will be generated by JavaScript --}}
                    </div>
                </div>

                {{-- Additional Notes --}}
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-6">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="bg-purple-100 text-purple-600 rounded-lg p-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                </path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-semibold text-slate-900">Additional Information</h2>
                    </div>

                    <div>
                        <label for="additional_notes" class="block text-sm font-medium text-slate-700 mb-2">
                            Special Requests or Notes (Optional)
                        </label>
                        <textarea name="additional_notes" id="additional_notes" rows="4"
                            class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                            placeholder="Any special requirements, dietary restrictions, or additional information...">{{ old('additional_notes') }}</textarea>
                    </div>
                </div>

                {{-- Promo Code --}}
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-6">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="bg-yellow-100 text-yellow-600 rounded-lg p-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                </path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-semibold text-slate-900">Promo Code</h2>
                    </div>

                    <div class="flex gap-3">
                        <input type="text" name="promo_code" id="promo_code" value="{{ old('promo_code') }}"
                            class="flex-1 px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                            placeholder="Enter promo code (optional)">
                        <button type="button" onclick="validatePromoCode()"
                            class="px-6 py-3 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-colors font-medium">
                            Apply
                        </button>
                    </div>
                    <div id="promo-message" class="mt-2 text-sm"></div>
                </div>

                {{-- Payment Options --}}
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-6">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="bg-indigo-100 text-indigo-600 rounded-lg p-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-3a2 2 0 00-2-2H9a2 2 0 00-2 2v3a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-semibold text-slate-900">Payment Options</h2>
                    </div>

                    <div class="space-y-4">
                        <label
                            class="flex items-start gap-3 p-4 border border-slate-300 rounded-lg cursor-pointer hover:bg-slate-50 transition-colors">
                            <input type="radio" name="payment_type" value="tentative" class="mt-1" checked
                                onchange="updatePaymentSection()">
                            <div class="flex-1">
                                <div class="font-medium text-slate-900">Tentative Booking</div>
                                <div class="text-sm text-slate-600">Reserve your spot without payment. Confirm later with
                                    the team.</div>
                                <div class="text-sm font-medium text-green-600 mt-1">No payment required</div>
                            </div>
                        </label>

                        <label
                            class="flex items-start gap-3 p-4 border border-slate-300 rounded-lg cursor-pointer hover:bg-slate-50 transition-colors">
                            <input type="radio" name="payment_type" value="partial" class="mt-1"
                                onchange="updatePaymentSection()">
                            <div class="flex-1">
                                <div class="font-medium text-slate-900">Partial Payment</div>
                                <div class="text-sm text-slate-600">Pay advance amount to secure your booking.</div>
                                <div class="text-sm font-medium text-blue-600 mt-1">Minimum Rs. 5,000</div>
                            </div>
                        </label>

                        <label
                            class="flex items-start gap-3 p-4 border border-slate-300 rounded-lg cursor-pointer hover:bg-slate-50 transition-colors">
                            <input type="radio" name="payment_type" value="full" class="mt-1"
                                onchange="updatePaymentSection()">
                            <div class="flex-1">
                                <div class="font-medium text-slate-900">Full Payment</div>
                                <div class="text-sm text-slate-600">Pay the complete amount and get 5% discount.</div>
                                <div class="text-sm font-medium text-green-600 mt-1">5% discount applied</div>
                            </div>
                        </label>
                    </div>

                    {{-- Payment Section --}}
                    <div id="payment-section" class="mt-6 hidden">
                        <div class="border-t border-slate-200 pt-6">
                            <h3 class="text-lg font-semibold text-slate-900 mb-4">Payment Details</h3>

                            {{-- Bank Details --}}
                            <div class="bg-slate-50 rounded-lg p-4 mb-4">
                                <h4 class="font-medium text-slate-900 mb-2">Bank Transfer Details</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <span class="text-slate-600">Bank Name:</span>
                                        <span class="font-medium ml-2">Commercial Bank of Ceylon</span>
                                    </div>
                                    <div>
                                        <span class="text-slate-600">Account Number:</span>
                                        <span class="font-medium ml-2">8001234567890</span>
                                    </div>
                                    <div>
                                        <span class="text-slate-600">Account Name:</span>
                                        <span class="font-medium ml-2">TripMe Lanka (Pvt) Ltd</span>
                                    </div>
                                    <div>
                                        <span class="text-slate-600">Branch:</span>
                                        <span class="font-medium ml-2">Colombo 03</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Partial Payment Amount --}}
                            <div id="partial-amount-section" class="hidden mb-4">
                                <label for="partial_amount" class="block text-sm font-medium text-slate-700 mb-2">
                                    Advance Amount <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="partial_amount" id="partial_amount" min="5000"
                                    step="0.01"
                                    class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                    placeholder="Minimum Rs. 5,000">
                            </div>

                            {{-- Payment Slip Upload --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="payment_slip" class="block text-sm font-medium text-slate-700 mb-2">
                                        Payment Slip <span class="text-red-500">*</span>
                                    </label>
                                    <input type="file" name="payment_slip" id="payment_slip" accept="image/*,.pdf"
                                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                    <p class="text-xs text-slate-500 mt-1">Upload bank slip (JPG, PNG, PDF)</p>
                                </div>

                                <div>
                                    <label for="reference_number" class="block text-sm font-medium text-slate-700 mb-2">
                                        Reference Number <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="reference_number" id="reference_number"
                                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                        placeholder="Transaction reference number">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Submit Button --}}
                <div class="flex items-center justify-between">
                    <a href="{{ route('super_admin.packages.rides.rides') }}"
                        class="px-6 py-3 border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50 transition-colors font-medium">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-8 py-3 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors font-medium">
                        Confirm Booking
                    </button>
                </div>
            </form>
        </div>

        {{-- Right Column: Price Summary --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 sticky top-6">
                <h3 class="text-lg font-semibold text-slate-900 mb-4">Booking Summary</h3>

                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-slate-600">Package:</span>
                        <span class="font-medium">{{ $ride->name }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-slate-600">Base Price:</span>
                        <span class="font-medium">Rs. <span
                                id="base-price">{{ number_format($ride->price_lkr, 2) }}</span></span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-slate-600">Quantity:</span>
                        <span class="font-medium"><span id="summary-quantity">1</span> passenger(s)</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-slate-600">Subtotal:</span>
                        <span class="font-medium">Rs. <span
                                id="subtotal">{{ number_format($ride->price_lkr, 2) }}</span></span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-slate-600">Tax ({{ $ride->tax_percentage }}%):</span>
                        <span class="font-medium">Rs. <span
                                id="tax-amount">{{ number_format(($ride->price_lkr * $ride->tax_percentage) / 100, 2) }}</span></span>
                    </div>

                    <div id="promo-discount-row" class="hidden justify-between">
                        <span class="text-slate-600">Promo Discount:</span>
                        <span class="font-medium text-green-600">- Rs. <span id="promo-discount">0.00</span></span>
                    </div>

                    <div id="full-payment-discount-row" class="hidden justify-between">
                        <span class="text-slate-600">Full Payment Discount (5%):</span>
                        <span class="font-medium text-green-600">- Rs. <span id="full-payment-discount">0.00</span></span>
                    </div>


                    <div class="border-t border-slate-200 pt-3">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-semibold text-slate-900">Total:</span>
                            <span class="text-xl font-bold text-primary-600">Rs. <span
                                    id="total-amount">{{ number_format($ride->price_lkr + ($ride->price_lkr * $ride->tax_percentage) / 100, 2) }}</span></span>
                        </div>
                    </div>

                    <div id="payment-amount-section" class="border-t border-slate-200 pt-3 hidden">
                        <div class="flex justify-between items-center">
                            <span class="font-medium text-slate-700">Amount to Pay:</span>
                            <span class="text-lg font-bold text-blue-600">Rs. <span id="payment-amount">0.00</span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Ride data for calculations
        const rideData = {
            basePrice: {{ $ride->price_lkr }},
            taxPercentage: {{ $ride->tax_percentage }},
            @if ($ride->passenger_capacity)
                maxPassengers: {{ $ride->passenger_capacity }}
            @endif
        };

        let appliedPromoCode = null;

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            updatePassengerFields();
            updatePriceSummary();
        });

        function updatePassengerFields() {
            const quantity = parseInt(document.getElementById('quantity').value) || 1;
            const container = document.getElementById('passenger-fields');

            container.innerHTML = '';

            for (let i = 1; i <= quantity; i++) {
                const passengerDiv = document.createElement('div');
                passengerDiv.className = 'border border-slate-300 rounded-lg p-4 mb-4';
                passengerDiv.innerHTML = `
            <h4 class="font-medium text-slate-900 mb-3">Passenger ${i}</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Full Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="passengers[${i-1}][name]"
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                           required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        NIC Number <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="passengers[${i-1}][nic]"
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                           required>
                </div>
            </div>
        `;
                container.appendChild(passengerDiv);
            }

            updatePriceSummary();
        }

        function updatePriceSummary() {
            const quantity = parseInt(document.getElementById('quantity').value) || 1;
            const basePrice = rideData.basePrice;
            const subtotal = basePrice * quantity;
            const taxAmount = (subtotal * rideData.taxPercentage) / 100;

            // Update basic calculations
            document.getElementById('summary-quantity').textContent = quantity;
            document.getElementById('subtotal').textContent = subtotal.toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
            document.getElementById('tax-amount').textContent = taxAmount.toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });

            // Calculate discounts
            let promoDiscount = 0;
            let fullPaymentDiscount = 0;

            if (appliedPromoCode) {
                promoDiscount = appliedPromoCode.discount;
                document.getElementById('promo-discount-row').classList.remove('hidden');
                document.getElementById('promo-discount').textContent = promoDiscount.toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            } else {
                document.getElementById('promo-discount-row').classList.add('hidden');
            }

            const paymentType = document.querySelector('input[name="payment_type"]:checked')?.value;
            if (paymentType === 'full') {
                fullPaymentDiscount = (subtotal + taxAmount - promoDiscount) * 0.05;
                document.getElementById('full-payment-discount-row').classList.remove('hidden');
                document.getElementById('full-payment-discount').textContent = fullPaymentDiscount.toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            } else {
                document.getElementById('full-payment-discount-row').classList.add('hidden');
            }

            // Calculate total
            const total = subtotal + taxAmount - promoDiscount - fullPaymentDiscount;
            document.getElementById('total-amount').textContent = total.toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });

            updatePaymentAmount(total);
        }

        function updatePaymentSection() {
            const paymentType = document.querySelector('input[name="payment_type"]:checked')?.value;
            const paymentSection = document.getElementById('payment-section');
            const partialAmountSection = document.getElementById('partial-amount-section');
            const paymentAmountSection = document.getElementById('payment-amount-section');

            if (paymentType === 'tentative') {
                paymentSection.classList.add('hidden');
                paymentAmountSection.classList.add('hidden');
            } else {
                paymentSection.classList.remove('hidden');
                paymentAmountSection.classList.remove('hidden');

                if (paymentType === 'partial') {
                    partialAmountSection.classList.remove('hidden');
                } else {
                    partialAmountSection.classList.add('hidden');
                }
            }

            updatePriceSummary();
        }

        function updatePaymentAmount(total) {
            const paymentType = document.querySelector('input[name="payment_type"]:checked')?.value;
            const paymentAmountSection = document.getElementById('payment-amount-section');

            if (paymentType === 'tentative') {
                paymentAmountSection.classList.add('hidden');
            } else if (paymentType === 'full') {
                paymentAmountSection.classList.remove('hidden');
                document.getElementById('payment-amount').textContent = total.toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            } else if (paymentType === 'partial') {
                paymentAmountSection.classList.remove('hidden');
                const partialAmount = parseFloat(document.getElementById('partial_amount')?.value) || 5000;
                document.getElementById('payment-amount').textContent = partialAmount.toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            }
        }

        function validatePromoCode() {
            const promoCode = document.getElementById('promo_code').value.trim();
            const messageDiv = document.getElementById('promo-message');

            if (!promoCode) {
                messageDiv.innerHTML = '<span class="text-red-600">Please enter a promo code</span>';
                return;
            }

            // AJAX call to validate promo code
            fetch('{{ route('super_admin.packages.rides.validate_promo') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        promo_code: promoCode,
                        amount: parseFloat(document.getElementById('total-amount').textContent.replace(/,/g,
                            ''))
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.valid) {
                        appliedPromoCode = data;
                        messageDiv.innerHTML =
                            `<span class="text-green-600">✓ Promo code applied! You save Rs. ${data.discount.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</span>`;
                        updatePriceSummary();
                    } else {
                        appliedPromoCode = null;
                        messageDiv.innerHTML = `<span class="text-red-600">✗ ${data.message}</span>`;
                        updatePriceSummary();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    messageDiv.innerHTML = '<span class="text-red-600">Error validating promo code</span>';
                });
        }

        // Listen for partial amount changes
        document.addEventListener('change', function(e) {
            if (e.target.id === 'partial_amount') {
                const total = parseFloat(document.getElementById('total-amount').textContent.replace(/,/g, ''));
                updatePaymentAmount(total);
            }
        });
    </script>

@endsection
