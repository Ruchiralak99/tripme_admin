@extends('layouts.super_admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header Section -->
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Edit Payment</h1>
                <p class="text-gray-600 mt-1">Update payment information and details</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('super_admin.payments.view', $payment->id) }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    View Payment
                </a>
                <a href="{{ route('super_admin.payments') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Payments
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Edit Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-6">Payment Information</h3>

                <form method="POST" action="{{ route('super_admin.payments.update', $payment->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Payment Reference (Read-only) -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Payment Reference
                            </label>
                            <input type="text" value="{{ $payment->payment_reference }}"
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-50 cursor-not-allowed"
                                   readonly>
                            <p class="mt-1 text-xs text-gray-500">Payment reference cannot be changed</p>
                        </div>

                        <!-- Amount -->
                        <div>
                            <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">
                                Amount <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-2 text-gray-500">$</span>
                                <input type="number" name="amount" id="amount"
                                       value="{{ old('amount', $payment->amount) }}"
                                       step="0.01" min="0" required
                                       class="w-full border border-gray-300 rounded-md pl-8 pr-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('amount') border-red-500 @enderror">
                            </div>
                            @error('amount')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Payment Method -->
                        <div>
                            <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-2">
                                Payment Method <span class="text-red-500">*</span>
                            </label>
                            <select name="payment_method" id="payment_method" required
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('payment_method') border-red-500 @enderror">
                                <option value="">Select Payment Method</option>
                                <option value="bank_transfer" {{ old('payment_method', $payment->payment_method) == 'bank_transfer' ? 'selected' : '' }}>
                                    Bank Transfer
                                </option>
                                <option value="credit_card" {{ old('payment_method', $payment->payment_method) == 'credit_card' ? 'selected' : '' }}>
                                    Credit Card
                                </option>
                                <option value="cash" {{ old('payment_method', $payment->payment_method) == 'cash' ? 'selected' : '' }}>
                                    Cash
                                </option>
                                <option value="online" {{ old('payment_method', $payment->payment_method) == 'online' ? 'selected' : '' }}>
                                    Online Payment
                                </option>
                            </select>
                            @error('payment_method')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Payment Type -->
                        <div>
                            <label for="payment_type" class="block text-sm font-medium text-gray-700 mb-2">
                                Payment Type <span class="text-red-500">*</span>
                            </label>
                            <select name="payment_type" id="payment_type" required
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('payment_type') border-red-500 @enderror">
                                <option value="">Select Payment Type</option>
                                <option value="full" {{ old('payment_type', $payment->payment_type) == 'full' ? 'selected' : '' }}>
                                    Full Payment
                                </option>
                                <option value="partial" {{ old('payment_type', $payment->payment_type) == 'partial' ? 'selected' : '' }}>
                                    Partial Payment
                                </option>
                            </select>
                            @error('payment_type')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Reference Number -->
                        <div>
                            <label for="reference_number" class="block text-sm font-medium text-gray-700 mb-2">
                                Reference Number
                            </label>
                            <input type="text" name="reference_number" id="reference_number"
                                   value="{{ old('reference_number', $payment->reference_number) }}"
                                   maxlength="255"
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('reference_number') border-red-500 @enderror"
                                   placeholder="Enter transaction reference number">
                            @error('reference_number')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Promo Code -->
                        <div>
                            <label for="promo_code_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Promo Code Applied
                            </label>
                            <select name="promo_code_id" id="promo_code_id"
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('promo_code_id') border-red-500 @enderror">
                                <option value="">No Promo Code</option>
                                @foreach($promoCodes as $promoCode)
                                    <option value="{{ $promoCode->id }}"
                                            {{ old('promo_code_id', $payment->promo_code_id) == $promoCode->id ? 'selected' : '' }}>
                                        {{ $promoCode->code }} -
                                        @if($promoCode->discount_type === 'percentage')
                                            {{ $promoCode->discount_value }}% off
                                        @else
                                            ${{ number_format($promoCode->discount_value, 2) }} off
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('promo_code_id')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Admin Notes -->
                    <div class="mt-6">
                        <label for="admin_notes" class="block text-sm font-medium text-gray-700 mb-2">
                            Admin Notes
                        </label>
                        <textarea name="admin_notes" id="admin_notes" rows="4"
                                  class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('admin_notes') border-red-500 @enderror"
                                  placeholder="Add any administrative notes about this payment...">{{ old('admin_notes', $payment->admin_notes) }}</textarea>
                        @error('admin_notes')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Form Actions -->
                    <div class="mt-8 flex justify-end space-x-4">
                        <a href="{{ route('super_admin.payments.view', $payment->id) }}"
                           class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-2 rounded-lg">
                            Cancel
                        </a>
                        <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Update Payment
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Payment Summary & Info -->
        <div class="lg:col-span-1">
            <!-- Current Payment Info -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Current Payment Info</h3>

                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Status</label>
                        <span class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            @if($payment->status === 'verified') bg-green-100 text-green-800
                            @elseif($payment->status === 'pending') bg-yellow-100 text-yellow-800
                            @elseif($payment->status === 'rejected') bg-red-100 text-red-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ ucfirst($payment->status) }}
                        </span>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Created Date</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $payment->created_at->format('M d, Y h:i A') }}</p>
                    </div>

                    @if($payment->verified_at)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Verified Date</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $payment->verified_at->format('M d, Y h:i A') }}</p>
                    </div>
                    @endif

                    @if($payment->verifiedBy)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Verified By</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $payment->verifiedBy->name }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Associated Booking -->
            @if($payment->booking)
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Associated Booking</h3>

                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Booking Reference</label>
                        <p class="mt-1 text-sm text-gray-900 font-mono">{{ $payment->booking->booking_reference }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Booking Type</label>
                        <p class="mt-1 text-sm text-gray-900">{{ ucfirst($payment->booking_type) }}</p>
                    </div>

                    @if($payment->booking->user)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Customer</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $payment->booking->user->name }}</p>
                        <p class="text-xs text-gray-500">{{ $payment->booking->user->email }}</p>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Payment Slip -->
            @if($payment->payment_slip_path)
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Payment Slip</h3>

                <div class="text-center">
                    <img src="{{ asset('storage/' . $payment->payment_slip_path) }}"
                         alt="Payment Slip"
                         class="w-full rounded-lg shadow-md mb-4">

                    <a href="{{ asset('storage/' . $payment->payment_slip_path) }}"
                       target="_blank"
                       class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                        View Full Size
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
// Auto-format amount input
document.getElementById('amount').addEventListener('input', function(e) {
    let value = e.target.value;
    if (value && !isNaN(value)) {
        e.target.value = parseFloat(value).toFixed(2);
    }
});

// Form validation
document.querySelector('form').addEventListener('submit', function(e) {
    const amount = document.getElementById('amount').value;
    const paymentMethod = document.getElementById('payment_method').value;
    const paymentType = document.getElementById('payment_type').value;

    if (!amount || parseFloat(amount) <= 0) {
        alert('Please enter a valid amount greater than 0');
        e.preventDefault();
        return;
    }

    if (!paymentMethod) {
        alert('Please select a payment method');
        e.preventDefault();
        return;
    }

    if (!paymentType) {
        alert('Please select a payment type (Full or Partial)');
        e.preventDefault();
        return;
    }
});
</script>
@endpush
@endsection
