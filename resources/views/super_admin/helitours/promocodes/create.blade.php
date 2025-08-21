@extends('layouts.super_admin')

@section('content')

<div class="p-6">
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center space-x-4">
            <a href="{{ route('super_admin.promo_codes') }}"
               class="flex items-center text-gray-500 hover:text-gray-700 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Promo Codes
            </a>
            <div class="h-5 border-l border-gray-300"></div>
            <h1 class="text-2xl font-bold text-slate-900">Create New Promo Code</h1>
        </div>
    </div>

    {{-- Form --}}
    <div class="bg-white rounded-lg shadow-sm border border-slate-200">
        <form method="POST" action="{{ route('super_admin.promo_codes.store') }}">
            @csrf

            <div class="p-6">
                {{-- Basic Information --}}
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4">Basic Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="code" class="block text-sm font-medium text-slate-700 mb-2">
                                Promo Code *
                            </label>
                            <input type="text" id="code" name="code" value="{{ old('code') }}" required
                                   class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 uppercase"
                                   placeholder="e.g., SAVE20, WELCOME10">
                            @error('code')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-slate-500">Code will be automatically converted to uppercase</p>
                        </div>

                        <div>
                            <label for="author" class="block text-sm font-medium text-slate-700 mb-2">
                                Author
                            </label>
                            <input type="text" id="author" name="author" value="{{ old('author') }}"
                                   class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                                   placeholder="e.g., Marketing Team, John Doe">
                            @error('author')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-slate-500">Optional: Person or team who created this code</p>
                        </div>

                        <div class="md:col-span-2">
                            <label for="description" class="block text-sm font-medium text-slate-700 mb-2">
                                Description *
                            </label>
                            <textarea id="description" name="description" rows="3" required
                                      class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                                      placeholder="Describe what this promo code is for...">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Discount Settings --}}
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4">Discount Settings</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="discount_type" class="block text-sm font-medium text-slate-700 mb-2">
                                Discount Type *
                            </label>
                            <select id="discount_type" name="discount_type" required
                                    class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                                    onchange="toggleDiscountFields()">
                                <option value="">Select discount type...</option>
                                <option value="percentage" {{ old('discount_type') == 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
                                <option value="fixed" {{ old('discount_type') == 'fixed' ? 'selected' : '' }}>Fixed Amount (LKR)</option>
                            </select>
                            @error('discount_type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="discount_value" class="block text-sm font-medium text-slate-700 mb-2">
                                Discount Value *
                            </label>
                            <div class="relative">
                                <span id="discount_symbol" class="absolute left-3 top-2 text-slate-500"></span>
                                <input type="number" id="discount_value" name="discount_value" value="{{ old('discount_value') }}"
                                       step="0.01" min="0" required
                                       class="w-full pl-8 pr-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                                       placeholder="0.00">
                            </div>
                            @error('discount_value')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="minimum_amount" class="block text-sm font-medium text-slate-700 mb-2">
                                Minimum Order Amount
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-2 text-slate-500">LKR</span>
                                <input type="number" id="minimum_amount" name="minimum_amount" value="{{ old('minimum_amount') }}"
                                       step="0.01" min="0"
                                       class="w-full pl-8 pr-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                                       placeholder="0.00">
                            </div>
                            @error('minimum_amount')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-slate-500">Optional: Minimum order value to use this code</p>
                        </div>

                        <div id="maximum_discount_field" style="display: none;">
                            <label for="maximum_discount" class="block text-sm font-medium text-slate-700 mb-2">
                                Maximum Discount Amount
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-2 text-slate-500">LKR</span>
                                <input type="number" id="maximum_discount" name="maximum_discount" value="{{ old('maximum_discount') }}"
                                       step="0.01" min="0"
                                       class="w-full pl-8 pr-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                                       placeholder="0.00">
                            </div>
                            @error('maximum_discount')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-slate-500">Optional: Cap the maximum discount for percentage codes</p>
                        </div>
                    </div>
                </div>

                {{-- Usage & Validity Settings --}}
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4">Usage & Validity Settings</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="usage_limit" class="block text-sm font-medium text-slate-700 mb-2">
                                Usage Limit
                            </label>
                            <input type="number" id="usage_limit" name="usage_limit" value="{{ old('usage_limit') }}"
                                   min="1"
                                   class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                                   placeholder="Unlimited">
                            @error('usage_limit')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-slate-500">Optional: Leave empty for unlimited usage</p>
                        </div>

                        <div>
                            <label for="valid_from" class="block text-sm font-medium text-slate-700 mb-2">
                                Valid From *
                            </label>
                            <input type="date" id="valid_from" name="valid_from" value="{{ old('valid_from', date('Y-m-d')) }}"
                                   min="{{ date('Y-m-d') }}" required
                                   class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            @error('valid_from')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="valid_until" class="block text-sm font-medium text-slate-700 mb-2">
                                Valid Until *
                            </label>
                            <input type="date" id="valid_until" name="valid_until" value="{{ old('valid_until') }}"
                                   min="{{ date('Y-m-d', strtotime('+1 day')) }}" required
                                   class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            @error('valid_until')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Status --}}
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4">Status</h3>
                    <div>
                        <label for="status" class="block text-sm font-medium text-slate-700 mb-2">
                            Status *
                        </label>
                        <select id="status" name="status" required
                                class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 md:w-auto">
                            <option value="">Select status...</option>
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-slate-500">Inactive codes cannot be used by customers</p>
                    </div>
                </div>
            </div>

            {{-- Form Actions --}}
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 flex flex-col sm:flex-row gap-3 sm:justify-end">
                <a href="{{ route('super_admin.promo_codes') }}"
                   class="inline-flex items-center justify-center px-4 py-2 border border-slate-300 rounded-lg text-slate-700 bg-white hover:bg-slate-50 transition-colors">
                    Cancel
                </a>
                <button type="submit"
                        class="inline-flex items-center justify-center px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Create Promo Code
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function toggleDiscountFields() {
    const discountType = document.getElementById('discount_type').value;
    const discountSymbol = document.getElementById('discount_symbol');
    const maxDiscountField = document.getElementById('maximum_discount_field');

    if (discountType === 'percentage') {
        discountSymbol.textContent = '%';
        maxDiscountField.style.display = 'block';
    } else if (discountType === 'fixed') {
        discountSymbol.textContent = 'LKR';
        maxDiscountField.style.display = 'none';
    } else {
        discountSymbol.textContent = '';
        maxDiscountField.style.display = 'none';
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    toggleDiscountFields();

    // Update valid_until minimum when valid_from changes
    document.getElementById('valid_from').addEventListener('change', function() {
        const validFrom = new Date(this.value);
        const nextDay = new Date(validFrom);
        nextDay.setDate(nextDay.getDate() + 1);
        document.getElementById('valid_until').min = nextDay.toISOString().split('T')[0];
    });
});
</script>

@endsection
