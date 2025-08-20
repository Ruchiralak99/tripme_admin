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
        <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">Create Ride Category</h1>
      </div>
      <p class="text-slate-600 mt-1">Add a new helicopter tour category with all necessary details.</p>
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

{{-- Create Form --}}
<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
        <h3 class="text-lg font-semibold text-slate-900">Helicopter Tour Details</h3>
    </div>

    <form method="POST" action="{{ route('super_admin.packages.rides_store') }}" enctype="multipart/form-data" class="p-6">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Basic Information --}}
            <div class="lg:col-span-2">
                <h4 class="text-lg font-medium text-slate-900 mb-4">Basic Information</h4>
            </div>

            {{-- Category Name --}}
            <div>
                <label for="name" class="block text-sm font-medium text-slate-700 mb-2">Category Name *</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                       class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition"
                       placeholder="e.g., City Ride 15 minutes">
            </div>

            {{-- Status --}}
            <div>
                <label for="status" class="block text-sm font-medium text-slate-700 mb-2">Status *</label>
                <select name="status" id="status" required
                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition">
                    <option value="">Select Status</option>
                    <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            {{-- Description --}}
            <div class="lg:col-span-2">
                <label for="description" class="block text-sm font-medium text-slate-700 mb-2">Description *</label>
                <textarea name="description" id="description" rows="4" required
                          class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition"
                          placeholder="Detailed description of the helicopter tour experience...">{{ old('description') }}</textarea>
            </div>

            {{-- Pricing & Duration --}}
            <div class="lg:col-span-2 pt-6 border-t border-slate-200">
                <h4 class="text-lg font-medium text-slate-900 mb-4">Pricing & Duration</h4>
            </div>

            {{-- Price in LKR --}}
            <div>
                <label for="price_lkr" class="block text-sm font-medium text-slate-700 mb-2">Price (LKR) *</label>
                <div class="relative">
                    <span class="absolute left-3 top-3.5 text-slate-500">Rs.</span>
                    <input type="number" name="price_lkr" id="price_lkr" value="{{ old('price_lkr') }}" required min="0" step="0.01"
                           class="w-full pl-12 pr-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition"
                           placeholder="0.00">
                </div>
            </div>

            {{-- Tax Percentage --}}
            <div>
                <label for="tax_percentage" class="block text-sm font-medium text-slate-700 mb-2">Tax (%) *</label>
                <div class="relative">
                    <input type="number" name="tax_percentage" id="tax_percentage" value="{{ old('tax_percentage') }}" required min="0" max="100" step="0.01"
                           class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition pr-8"
                           placeholder="0.00">
                    <span class="absolute right-3 top-3.5 text-slate-500">%</span>
                </div>
            </div>

            {{-- Discount Percentage (Optional) --}}
            <div>
                <label for="discount_percentage" class="block text-sm font-medium text-slate-700 mb-2">Discount (%)</label>
                <div class="relative">
                    <input type="number" name="discount_percentage" id="discount_percentage" value="{{ old('discount_percentage') }}" min="0" max="100" step="0.01"
                           class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition pr-8"
                           placeholder="0.00">
                    <span class="absolute right-3 top-3.5 text-slate-500">%</span>
                </div>
                <p class="text-xs text-slate-500 mt-1">Optional - Leave empty if no discount applies.</p>
            </div>

            {{-- Regular Value (Auto-calculated) --}}
            <div>
                <label for="regular_value" class="block text-sm font-medium text-slate-700 mb-2">Final Price (LKR)</label>
                <div class="relative">
                    <span class="absolute left-3 top-3.5 text-slate-500">Rs.</span>
                    <input type="number" id="regular_value_display" readonly
                           class="w-full pl-12 pr-4 py-3 border border-slate-300 rounded-lg bg-slate-50 text-slate-700"
                           placeholder="0.00">
                </div>
                <p class="text-xs text-slate-500 mt-1">Auto-calculated: Price + Tax - Discount</p>
            </div>

            {{-- Duration (Optional) --}}
            <div>
                <label for="duration" class="block text-sm font-medium text-slate-700 mb-2">Duration</label>
                <input type="text" name="duration" id="duration" value="{{ old('duration') }}"
                       class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition"
                       placeholder="e.g., 15 minutes, 30 minutes, 1 hour">
                <p class="text-xs text-slate-500 mt-1">Optional - Leave empty if not applicable.</p>
            </div>

            {{-- Passenger Capacity (Optional) --}}
            <div>
                <label for="passenger_capacity" class="block text-sm font-medium text-slate-700 mb-2">Passenger Capacity</label>
                <input type="number" name="passenger_capacity" id="passenger_capacity" value="{{ old('passenger_capacity') }}" min="1" max="20"
                       class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition"
                       placeholder="Number of passengers">
                <p class="text-xs text-slate-500 mt-1">Optional - Leave empty if not applicable.</p>
            </div>

            {{-- Media --}}
            <div class="lg:col-span-2 pt-6 border-t border-slate-200">
                <h4 class="text-lg font-medium text-slate-900 mb-4">Media</h4>
            </div>

            {{-- Image Upload --}}
            <div class="lg:col-span-2">
                <label for="image" class="block text-sm font-medium text-slate-700 mb-2">Cover Image</label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-300 border-dashed rounded-lg hover:border-primary-400 transition-colors">
                    <div class="space-y-1 text-center">
                        <div class="mx-auto h-16 w-16 text-slate-400">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                        <div class="flex text-sm text-slate-600">
                            <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-primary-600 hover:text-primary-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary-500">
                                <span>Upload a file</span>
                                <input id="image" name="image" type="file" accept="image/*" class="sr-only" onchange="previewImage(event)">
                            </label>
                            <p class="pl-1">or drag and drop</p>
                        </div>
                        <p class="text-xs text-slate-500">PNG, JPG, GIF up to 2MB</p>
                    </div>
                </div>

                {{-- Image Preview --}}
                <div id="image-preview-container" class="mt-4 hidden">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Image Preview</label>
                    <div class="relative">
                        <img id="image-preview" class="w-full max-w-sm h-48 object-cover rounded-lg border border-slate-200" alt="Preview">
                        <button type="button" onclick="removeImage()" class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Live Preview Section --}}
            <div class="lg:col-span-2 pt-6 border-t border-slate-200">
                <h4 class="text-lg font-medium text-slate-900 mb-4">Live Preview</h4>
                <div class="bg-slate-50 rounded-lg p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h5 class="font-medium text-slate-900 mb-3">Pricing Breakdown</h5>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-slate-600">Base Price:</span>
                                    <span class="font-medium">Rs. <span id="preview-price">0.00</span></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-slate-600">Tax (<span id="preview-tax-rate">0</span>%):</span>
                                    <span class="font-medium">Rs. <span id="preview-tax-amount">0.00</span></span>
                                </div>
                                <div class="flex justify-between" id="discount-row" style="display: none;">
                                    <span class="text-slate-600">Discount (<span id="preview-discount-rate">0</span>%):</span>
                                    <span class="font-medium text-green-600">- Rs. <span id="preview-discount-amount">0.00</span></span>
                                </div>
                                <div class="border-t pt-2 mt-2">
                                    <div class="flex justify-between">
                                        <span class="font-semibold text-slate-900">Final Price:</span>
                                        <span class="font-bold text-primary-600 text-lg">Rs. <span id="preview-final">0.00</span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h5 class="font-medium text-slate-900 mb-3">Tour Details</h5>
                            <div class="space-y-2 text-sm text-slate-600">
                                <div><span class="font-medium">Duration:</span> <span id="preview-duration">Not specified</span></div>
                                <div><span class="font-medium">Capacity:</span> <span id="preview-capacity">Not specified</span></div>
                                <div><span class="font-medium">Status:</span> <span id="preview-status">Active</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Form Actions --}}
        <div class="flex flex-col sm:flex-row gap-3 pt-8 border-t border-slate-200 mt-8">
            <button type="submit" class="inline-flex items-center justify-center px-6 py-3 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors duration-200 font-medium">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Create Category
            </button>
            <a href="{{ route('super_admin.packages.rides.rides') }}" class="inline-flex items-center justify-center px-6 py-3 bg-slate-500 text-white rounded-lg hover:bg-slate-600 transition-colors duration-200 font-medium">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                Cancel
            </a>
        </div>
    </form>
</div>

<script>
    // Image preview functionality
    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('image-preview').src = e.target.result;
                document.getElementById('image-preview-container').classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        }
    }

    function removeImage() {
        document.getElementById('image').value = '';
        document.getElementById('image-preview-container').classList.add('hidden');
    }

    // Live pricing calculation
    function updatePreview() {
        const price = parseFloat(document.getElementById('price_lkr').value) || 0;
        const taxPercentage = parseFloat(document.getElementById('tax_percentage').value) || 0;
        const discountPercentage = parseFloat(document.getElementById('discount_percentage').value) || 0;
        const duration = document.getElementById('duration').value || 'Not specified';
        const capacity = document.getElementById('passenger_capacity').value || 'Not specified';
        const status = document.getElementById('status').value || 'active';

        // Calculate tax amount
        const taxAmount = (price * taxPercentage) / 100;

        // Calculate price after tax
        const priceAfterTax = price + taxAmount;

        // Calculate discount amount and final price
        let discountAmount = 0;
        let finalPrice = priceAfterTax;

        if (discountPercentage > 0) {
            discountAmount = (priceAfterTax * discountPercentage) / 100;
            finalPrice = priceAfterTax - discountAmount;
            document.getElementById('discount-row').style.display = 'flex';
        } else {
            document.getElementById('discount-row').style.display = 'none';
        }

        // Update preview display
        document.getElementById('preview-price').textContent = price.toFixed(2);
        document.getElementById('preview-tax-rate').textContent = taxPercentage.toFixed(1);
        document.getElementById('preview-tax-amount').textContent = taxAmount.toFixed(2);
        document.getElementById('preview-discount-rate').textContent = discountPercentage.toFixed(1);
        document.getElementById('preview-discount-amount').textContent = discountAmount.toFixed(2);
        document.getElementById('preview-final').textContent = finalPrice.toFixed(2);
        document.getElementById('preview-duration').textContent = duration;
        document.getElementById('preview-capacity').textContent = capacity === 'Not specified' ? capacity : capacity + ' passengers';
        document.getElementById('preview-status').textContent = status.charAt(0).toUpperCase() + status.slice(1);

        // Update the regular value display field
        document.getElementById('regular_value_display').value = finalPrice.toFixed(2);
    }

    // Add event listeners
    document.getElementById('price_lkr').addEventListener('input', updatePreview);
    document.getElementById('tax_percentage').addEventListener('input', updatePreview);
    document.getElementById('discount_percentage').addEventListener('input', updatePreview);
    document.getElementById('duration').addEventListener('input', updatePreview);
    document.getElementById('passenger_capacity').addEventListener('input', updatePreview);
    document.getElementById('status').addEventListener('change', updatePreview);

    // Initialize preview
    updatePreview();
</script>

@endsection
