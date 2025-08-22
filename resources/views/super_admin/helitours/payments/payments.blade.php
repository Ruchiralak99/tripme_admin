@extends('layouts.super_admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header Section -->
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Payment Management</h1>
                <p class="text-gray-600 mt-1">Manage all helitours payment transactions</p>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Error Message -->
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <!-- Search and Filter Section -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <form method="GET" action="{{ route('super_admin.payments') }}" class="space-y-4">
            <!-- Search Bar -->
            <div class="flex items-center space-x-4">
                <div class="flex-1">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                    <div class="relative">
                        <input type="text"
                               name="search"
                               id="search"
                               value="{{ request('search') }}"
                               placeholder="Search by payment reference, booking reference, customer name, phone..."
                               class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="flex space-x-2 mt-7">
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white px-6 py-2 rounded-lg">
                        Search
                    </button>
                    <a href="{{ route('super_admin.payments') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg">
                        Clear
                    </a>
                </div>
            </div>

            <!-- Filter Options -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Status Filter -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Payment Status</label>
                    <select name="status" id="status" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Statuses</option>
                        @foreach($statuses as $status)
                            <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Payment Method Filter -->
                <div>
                    <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-2">Payment Method</label>
                    <select name="payment_method" id="payment_method" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Methods</option>
                        @foreach($paymentMethods as $method)
                            <option value="{{ $method }}" {{ request('payment_method') == $method ? 'selected' : '' }}>
                                {{ ucwords(str_replace('_', ' ', $method)) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Payment Type Filter -->
                <div>
                    <label for="payment_type" class="block text-sm font-medium text-gray-700 mb-2">Payment Type</label>
                    <select name="payment_type" id="payment_type" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Types</option>
                        @foreach($paymentTypes as $type)
                            <option value="{{ $type }}" {{ request('payment_type') == $type ? 'selected' : '' }}>
                                {{ ucfirst($type) }} Payment
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Promo Code Usage Filter -->
                <div>
                    <label for="has_promo_code" class="block text-sm font-medium text-gray-700 mb-2">Promo Code Usage</label>
                    <select name="has_promo_code" id="has_promo_code" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Payments</option>
                        <option value="yes" {{ request('has_promo_code') == 'yes' ? 'selected' : '' }}>With Promo Code</option>
                        <option value="no" {{ request('has_promo_code') == 'no' ? 'selected' : '' }}>Without Promo Code</option>
                    </select>
                </div>
            </div>

            <!-- Advanced Filters -->
            <div class="border-t pt-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Specific Promo Code Filter -->
                    <div>
                        <label for="promo_code_id" class="block text-sm font-medium text-gray-700 mb-2">Specific Promo Code</label>
                        <select name="promo_code_id" id="promo_code_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">All Promo Codes</option>
                            @foreach($promoCodes as $promoCode)
                                <option value="{{ $promoCode->id }}" {{ request('promo_code_id') == $promoCode->id ? 'selected' : '' }}>
                                    {{ $promoCode->code }} -
                                    @if($promoCode->discount_type === 'percentage')
                                        {{ $promoCode->discount_value }}% off
                                    @else
                                        LKR {{ number_format($promoCode->discount_value, 2) }} off
                                    @endif
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Date Range Filters -->
                    <div>
                        <label for="date_from" class="block text-sm font-medium text-gray-700 mb-2">Date From</label>
                        <input type="date"
                               name="date_from"
                               id="date_from"
                               value="{{ request('date_from') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label for="date_to" class="block text-sm font-medium text-gray-700 mb-2">Date To</label>
                        <input type="date"
                               name="date_to"
                               id="date_to"
                               value="{{ request('date_to') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Amount Range Filters -->
                    <div>
                        <label for="amount_min" class="block text-sm font-medium text-gray-700 mb-2">Min Amount (LKR)</label>
                        <input type="number"
                               name="amount_min"
                               id="amount_min"
                               value="{{ request('amount_min') }}"
                               step="0.01"
                               min="0"
                               placeholder="0.00"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-4">
                    <div>
                        <label for="amount_max" class="block text-sm font-medium text-gray-700 mb-2">Max Amount (LKR)</label>
                        <input type="number"
                               name="amount_max"
                               id="amount_max"
                               value="{{ request('amount_max') }}"
                               step="0.01"
                               min="0"
                               placeholder="999999.99"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Filter Actions -->
                    <div class="flex items-end space-x-2">
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-lg">
                            Apply Filters
                        </button>
                        <a href="{{ route('super_admin.payments') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-2 rounded-lg">
                            Reset All
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Payments Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900">
                    Payment Transactions
                    <span class="text-sm text-gray-500">({{ $payments->total() }} total{{ request()->hasAny(['search', 'status', 'payment_method', 'payment_type', 'has_promo_code', 'promo_code_id', 'date_from', 'date_to', 'amount_min', 'amount_max']) ? ', filtered' : '' }})</span>
                </h3>

                @if(request()->hasAny(['search', 'status', 'payment_method', 'payment_type', 'has_promo_code', 'promo_code_id', 'date_from', 'date_to', 'amount_min', 'amount_max']))
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-600">Active filters:</span>
                        <div class="flex flex-wrap gap-1">
                            @if(request('search'))
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    Search: {{ request('search') }}
                                </span>
                            @endif
                            @if(request('status'))
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Status: {{ ucfirst(request('status')) }}
                                </span>
                            @endif
                            @if(request('payment_method'))
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                    Method: {{ ucwords(str_replace('_', ' ', request('payment_method'))) }}
                                </span>
                            @endif
                            @if(request('payment_type'))
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    Type: {{ ucfirst(request('payment_type')) }}
                                </span>
                            @endif
                            @if(request('has_promo_code'))
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                    Promo: {{ request('has_promo_code') === 'yes' ? 'With Code' : 'No Code' }}
                                </span>
                            @endif
                        </div>
                        <a href="{{ route('super_admin.payments') }}" class="text-sm text-red-600 hover:text-red-800">Clear all</a>
                    </div>
                @endif
            </div>
        </div>

        @if($payments->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Payment Reference
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Booking Details
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Amount & Method
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Date
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($payments as $payment)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $payment->payment_reference }}</div>
                                    @if($payment->reference_number)
                                        <div class="text-sm text-gray-500">Ref: {{ $payment->reference_number }}</div>
                                    @endif
                                    @if($payment->has_promo_code && $payment->promoCode)
                                        <div class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800 mt-1">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                                            </svg>
                                            {{ $payment->promoCode->code }}
                                        </div>
                                    @endif
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($payment->booking)
                                        <div class="text-sm font-medium text-gray-900">{{ $payment->booking->booking_reference }}</div>
                                        <div class="text-sm text-gray-500">{{ ucfirst($payment->booking_type) }}</div>
                                        @if($payment->booking->user)
                                            <div class="text-xs text-gray-400">{{ $payment->booking->user->name }}</div>
                                        @endif
                                    @else
                                        <div class="text-sm text-gray-500">No booking data</div>
                                    @endif
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">LKR {{ number_format($payment->amount, 2) }}</div>
                                    <div class="text-sm text-gray-500">{{ ucwords(str_replace('_', ' ', $payment->payment_method)) }}</div>
                                    <div class="text-xs text-gray-400">{{ ucfirst($payment->payment_type) }} Payment</div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $payment->status === 'verified' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $payment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $payment->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}
                                    {{ $payment->status === 'other' ? 'bg-gray-100 text-gray-800' : '' }}">
                                    {{ ucfirst($payment->status) }}
                                </span>
                                    @if($payment->verified_at && $payment->verifiedBy)
                                        <div class="text-xs text-gray-500 mt-1">
                                            by {{ $payment->verifiedBy->name }}
                                        </div>
                                    @endif
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div>{{ $payment->created_at->format('M d, Y') }}</div>
                                    <div class="text-xs">{{ $payment->created_at->format('h:i A') }}</div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        <!-- View Button -->
                                        <a href="{{ route('super_admin.payments.view', $payment->id) }}"
                                           class="text-blue-600 hover:text-blue-900" title="View Payment">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>

                                        <!-- Edit Button -->
                                        <a href="{{ route('super_admin.payments.edit', $payment->id) }}"
                                           class="text-green-600 hover:text-green-900" title="Edit Payment">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>

                                        <!-- Delete Button -->
                                        <form method="POST"
                                              action="{{ route('super_admin.payments.delete', $payment->id) }}"
                                              style="display: inline-block;"
                                              onsubmit="return confirm('Are you sure you want to delete this payment? This action cannot be undone.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="text-red-600 hover:text-red-900"
                                                    title="Delete Payment">
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

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $payments->appends(request()->query())->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No payments found</h3>
                <p class="mt-1 text-sm text-gray-500">No payment records available.</p>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
function deletePayment(paymentId) {
    if (confirm('Are you sure you want to delete this payment? This action cannot be undone.')) {
        // Create a form dynamically
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ url("super_admin/payments") }}/' + paymentId;
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
    console.log('Payment management page loaded');

    // Optional: Auto-submit form when filters change
    const filterSelects = document.querySelectorAll('#status, #payment_method, #payment_type, #has_promo_code');
    filterSelects.forEach(select => {
        select.addEventListener('change', function() {
            // Uncomment the line below to enable auto-submit on filter change
            // this.form.submit();
        });
    });
});
</script>
@endpush
@endsection
