@extends('layouts.super_admin')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header Section -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('super_admin.payments') }}"
                       class="text-gray-600 hover:text-gray-900 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Payment Details</h1>
                        <p class="text-gray-600 mt-1">Reference: {{ $payment->payment_reference }}</p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                        {{ $payment->status === 'verified' ? 'bg-green-100 text-green-800' :
                           ($payment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                        {{ ucfirst($payment->status) }}
                    </span>
                    <a href="{{ route('super_admin.payments.edit', $payment->id) }}"
                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                        Edit Payment
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if (session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ session('success') }}
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Payment Information -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Payment Overview -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Payment Overview</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Amount</label>
                                <div class="text-2xl font-bold text-gray-900">LKR {{ number_format($payment->amount, 2) }}</div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Payment Method</label>
                                <div class="text-sm text-gray-900">{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Payment Type</label>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium
                                    {{ $payment->payment_type === 'full' ? 'bg-green-100 text-green-800' :
                                       ($payment->payment_type === 'partial' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                    {{ ucfirst($payment->payment_type) }}
                                </span>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Created Date</label>
                                <div class="text-sm text-gray-900">{{ $payment->created_at->format('M d, Y H:i A') }}</div>
                            </div>
                            @if($payment->verified_at)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Verified Date</label>
                                    <div class="text-sm text-gray-900">{{ $payment->verified_at->format('M d, Y H:i A') }}</div>
                                </div>
                            @endif
                            @if($payment->reference_number)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Reference Number</label>
                                    <div class="text-sm text-gray-900">{{ $payment->reference_number }}</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Promo Code Information -->
                @if($payment->has_promo_code)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Promo Code Applied</h2>
                        @if($payment->promoCode)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Promo Code</label>
                                    <div class="text-sm font-medium text-gray-900">{{ $payment->promoCode->code }}</div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Discount Type</label>
                                    <div class="text-sm text-gray-900">{{ ucfirst($payment->promoCode->discount_type) }}</div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Discount Value</label>
                                    <div class="text-sm text-gray-900">
                                        @if($payment->promoCode->discount_type === 'percentage')
                                            {{ $payment->promoCode->discount_value }}%
                                        @else
                                            LKR {{ number_format($payment->promoCode->discount_value, 2) }}
                                        @endif
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Promo Status</label>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium
                                        {{ $payment->promoCode->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ ucfirst($payment->promoCode->status) }}
                                    </span>
                                </div>
                            </div>
                        @else
                            <div class="text-sm text-gray-600">
                                Promo code was applied but details are no longer available (possibly deleted).
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Payment Notes -->
                @if($payment->admin_notes)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Admin Notes</h2>
                        <div class="text-sm text-gray-700 leading-relaxed">{{ $payment->admin_notes }}</div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Quick Actions -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                    <div class="space-y-3">
                        <a href="{{ route('super_admin.payments') }}"
                           class="block w-full bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-medium transition-colors text-center">
                            Back to Payments
                        </a>
                        <a href="{{ route('super_admin.payments.edit', $payment->id) }}"
                           class="block w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors text-center">
                            Edit Payment
                        </a>
                        <form method="POST"
                              action="{{ route('super_admin.payments.delete', $payment->id) }}"
                              style="display: inline-block;"
                              onsubmit="return confirm('Are you sure you want to delete this payment? This action cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="block w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition-colors text-center">
                                Delete Payment
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Payment Summary -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Payment Summary</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Payment ID:</span>
                            <span class="text-sm font-medium text-gray-900">{{ $payment->id }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Status:</span>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                {{ $payment->status === 'verified' ? 'bg-green-100 text-green-800' :
                                   ($payment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ ucfirst($payment->status) }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Promo Applied:</span>
                            <span class="text-sm font-medium {{ $payment->has_promo_code ? 'text-green-600' : 'text-gray-600' }}">
                                {{ $payment->has_promo_code ? 'Yes' : 'No' }}
                            </span>
                        </div>
                        <hr class="border-gray-200">
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-gray-900">Total Amount:</span>
                            <span class="text-lg font-bold text-gray-900">LKR {{ number_format($payment->amount, 2) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Booking Information -->
                @if($payment->booking)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Related Booking</h3>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Booking Reference</label>
                                <div class="text-sm font-medium text-gray-900">{{ $payment->booking->booking_reference }}</div>
                            </div>
                            @if($payment->booking->customer_name)
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Customer Name</label>
                                <div class="text-sm text-gray-900">{{ $payment->booking->customer_name }}</div>
                            </div>
                            @endif
                            @if($payment->booking->customer_phone)
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Contact</label>
                                <div class="text-sm text-gray-900">{{ $payment->booking->customer_phone }}</div>
                            </div>
                            @endif
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Status</label>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                    {{ $payment->booking->status === 'confirmed' ? 'bg-green-100 text-green-800' :
                                       ($payment->booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    {{ ucfirst($payment->booking->status) }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Payment Slip -->
                @if($payment->payment_slip_path)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Payment Slip</h3>
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

                <!-- Verification Details -->
                @if($payment->verified_at && $payment->verifiedBy)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Verification Details</h3>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Verified By</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $payment->verifiedBy->name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Verified At</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $payment->verified_at->format('M d, Y h:i A') }}</p>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function deletePayment() {
    if (confirm('Are you sure you want to delete this payment? This action cannot be undone.')) {
        // Create a form dynamically
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ url("super_admin/payments/" . $payment->id) }}';
        form.style.display = 'none';

        // Add CSRF token
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';

        // Add method override for DELETE
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';

        // Append inputs to form
        form.appendChild(csrfToken);
        form.appendChild(methodField);

        // Append form to body and submit
        document.body.appendChild(form);
        form.submit();
    }
}

// Initialize page
document.addEventListener('DOMContentLoaded', function() {
    console.log('Payment view page loaded');
});
</script>
@endpush
@endsection
