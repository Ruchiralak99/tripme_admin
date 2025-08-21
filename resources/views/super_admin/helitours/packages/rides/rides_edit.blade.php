@extends('layouts.super_admin')

@section('content')

{{-- Page Header --}}
<div class="mb-8">
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
      <div class="flex items-center gap-3 mb-2">
        <a href="{{ route('super_admin.packages.rides.rides') }}" class="text-slate-400 hover:text-slate-600 transition-colors">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
          </svg>
        </a>
        <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">Edit Ride Category</h1>
      </div>
      <p class="text-slate-600 mt-1">Update helicopter tour category details and settings.</p>
    </div>
  </div>
</div>

{{-- Error Messages --}}
@if ($errors->any())
    <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
        <ul class="list-disc list-inside space-y-1">
            @foreach ($errors->all() as $error)
                <li class="text-sm">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- Edit Form --}}
<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
        <h3 class="text-lg font-semibold text-slate-900">Helicopter Tour Details</h3>
    </div>

    <form method="POST" action="{{ route('super_admin.packages.rides_update', $ride->id) }}" class="p-6" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Basic Information --}}
            <div class="lg:col-span-2">
                <h4 class="text-lg font-medium text-slate-900 mb-4">Basic Information</h4>
            </div>

            {{-- Category Name --}}
            <div>
                <label for="name" class="block text-sm font-medium text-slate-700 mb-2">
                    Category Name <span class="text-red-500">*</span>
                </label>
                <input type="text"
                       id="name"
                       name="name"
                       value="{{ old('name', $ride->name) }}"
                       class="block w-full px-3 py-3 border border-slate-300 rounded-lg shadow-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                       placeholder="Enter category name"
                       required>
            </div>

            {{-- Description --}}
            <div>
                <label for="description" class="block text-sm font-medium text-slate-700 mb-2">
                    Description <span class="text-red-500">*</span>
                </label>
                <textarea id="description"
                          name="description"
                          rows="3"
                          class="block w-full px-3 py-3 border border-slate-300 rounded-lg shadow-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                          placeholder="Enter category description"
                          required>{{ old('description', $ride->description) }}</textarea>
            </div>

            {{-- Pricing Section --}}
            <div class="lg:col-span-2 border-t border-slate-200 pt-6 mt-6">
                <h4 class="text-lg font-medium text-slate-900 mb-4">Pricing Information</h4>
            </div>

            {{-- Base Price --}}
            <div>
                <label for="price_lkr" class="block text-sm font-medium text-slate-700 mb-2">
                    Base Price (LKR) <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-slate-500 sm:text-sm">Rs.</span>
                    </div>
                    <input type="number"
                           id="price_lkr"
                           name="price_lkr"
                           value="{{ old('price_lkr', $ride->price_lkr) }}"
                           step="0.01"
                           min="0"
                           class="block w-full pl-10 pr-12 py-3 border border-slate-300 rounded-lg shadow-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                           placeholder="0.00"
                           required
                           onchange="updateFinalPrice()">
                </div>
            </div>

            {{-- Tax Percentage --}}
            <div>
                <label for="tax_percentage" class="block text-sm font-medium text-slate-700 mb-2">
                    Tax (%) <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <input type="number"
                           id="tax_percentage"
                           name="tax_percentage"
                           value="{{ old('tax_percentage', $ride->tax_percentage) }}"
                           step="0.01"
                           min="0"
                           max="100"
                           class="block w-full pr-12 py-3 border border-slate-300 rounded-lg shadow-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                           placeholder="0.00"
                           required
                           onchange="updateFinalPrice()">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <span class="text-slate-500 sm:text-sm">%</span>
                    </div>
                </div>
            </div>

            {{-- Discount Percentage --}}
            <div>
                <label for="discount_percentage" class="block text-sm font-medium text-slate-700 mb-2">
                    Discount (%)
                </label>
                <div class="relative">
                    <input type="number"
                           id="discount_percentage"
                           name="discount_percentage"
                           value="{{ old('discount_percentage', $ride->discount_percentage) }}"
                           step="0.01"
                           min="0"
                           max="100"
                           class="block w-full pr-12 py-3 border border-slate-300 rounded-lg shadow-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                           placeholder="0.00"
                           onchange="updateFinalPrice()">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <span class="text-slate-500 sm:text-sm">%</span>
                    </div>
                </div>
            </div>

            {{-- Regular Value (Final Price) --}}
            <div>
                <label for="regular_value" class="block text-sm font-medium text-slate-700 mb-2">
                    Final Price (LKR) <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-slate-500 sm:text-sm">Rs.</span>
                    </div>
                    <input type="number"
                           id="regular_value"
                           name="regular_value"
                           value="{{ old('regular_value', $ride->regular_value) }}"
                           step="0.01"
                           min="0"
                           class="block w-full pl-10 pr-12 py-3 border border-slate-300 rounded-lg shadow-sm bg-slate-50 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                           readonly
                           required>
                </div>
                <p class="mt-1 text-sm text-slate-500">This value is automatically calculated based on base price, tax, and discount.</p>
            </div>

            {{-- Additional Details Section --}}
            <div class="lg:col-span-2 border-t border-slate-200 pt-6 mt-6">
                <h4 class="text-lg font-medium text-slate-900 mb-4">Additional Details</h4>
            </div>

            {{-- Duration --}}
            <div>
                <label for="duration" class="block text-sm font-medium text-slate-700 mb-2">
                    Duration
                </label>
                <input type="text"
                       id="duration"
                       name="duration"
                       value="{{ old('duration', $ride->duration) }}"
                       class="block w-full px-3 py-3 border border-slate-300 rounded-lg shadow-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                       placeholder="e.g., 45 minutes, 1 hour">
            </div>

            {{-- Passenger Capacity --}}
            <div>
                <label for="passenger_capacity" class="block text-sm font-medium text-slate-700 mb-2">
                    Passenger Capacity
                </label>
                <input type="number"
                       id="passenger_capacity"
                       name="passenger_capacity"
                       value="{{ old('passenger_capacity', $ride->passenger_capacity) }}"
                       min="1"
                       class="block w-full px-3 py-3 border border-slate-300 rounded-lg shadow-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                       placeholder="Number of passengers">
            </div>

            {{-- Status --}}
            <div>
                <label for="status" class="block text-sm font-medium text-slate-700 mb-2">
                    Status <span class="text-red-500">*</span>
                </label>
                <select id="status"
                        name="status"
                        class="block w-full px-3 py-3 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                        required>
                    <option value="active" {{ old('status', $ride->status) === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status', $ride->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            {{-- Image Upload --}}
            <div class="lg:col-span-2">
                <label for="image" class="block text-sm font-medium text-slate-700 mb-2">
                    Category Image
                </label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-300 border-dashed rounded-lg hover:border-slate-400 transition-colors">
                    <div class="space-y-1 text-center">
                        <div id="image-preview" class="mb-4 {{ $ride->image_path ? '' : 'hidden' }}">
                            @if($ride->image_path)
                                <img src="{{ asset('storage/' . $ride->image_path) }}" alt="Current image" class="mx-auto h-32 w-auto rounded-lg">
                                <p class="text-xs text-slate-500 mt-2">Current image</p>
                            @endif
                        </div>
                        <svg class="mx-auto h-12 w-12 text-slate-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-slate-600">
                            <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-primary-600 hover:text-primary-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary-500">
                                <span>Upload a file</span>
                                <input id="image" name="image" type="file" accept="image/*" class="sr-only" onchange="previewEditImage(event)">
                            </label>
                            <p class="pl-1">or drag and drop</p>
                        </div>
                        <p class="text-xs text-slate-500">PNG, JPG, GIF up to 10MB</p>
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="lg:col-span-2 flex items-center justify-end gap-4 pt-6 border-t border-slate-200">
                <a href="{{ route('super_admin.packages.rides.rides') }}"
                   class="px-6 py-3 border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-colors">
                    Cancel
                </a>
                <button type="submit"
                        class="px-6 py-3 bg-primary-500 text-white rounded-lg hover:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-colors">
                    Update Category
                </button>
            </div>
        </div>
    </form>
</div>

<script>
function updateFinalPrice() {
    const basePrice = parseFloat(document.getElementById('price_lkr').value) || 0;
    const taxPercentage = parseFloat(document.getElementById('tax_percentage').value) || 0;
    const discountPercentage = parseFloat(document.getElementById('discount_percentage').value) || 0;

    // Calculate tax amount
    const taxAmount = (basePrice * taxPercentage) / 100;

    // Calculate price after tax
    const priceAfterTax = basePrice + taxAmount;

    // Calculate discount amount
    const discountAmount = (priceAfterTax * discountPercentage) / 100;

    // Calculate final price
    const finalPrice = priceAfterTax - discountAmount;

    // Update the regular_value field
    document.getElementById('regular_value').value = finalPrice.toFixed(2);
}

function previewEditImage(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('image-preview');

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `
                <img src="${e.target.result}" alt="Preview" class="mx-auto h-32 w-auto rounded-lg">
                <p class="text-xs text-slate-500 mt-2">New image preview</p>
            `;
            preview.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }
}

// Initialize the final price calculation on page load
document.addEventListener('DOMContentLoaded', function() {
    updateFinalPrice();
});
</script>

@endsection
