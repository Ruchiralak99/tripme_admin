@extends('layouts.super_admin')

@section('content')

{{-- Page Header --}}
<div class="mb-8">
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
      <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">Edit User</h1>
      <p class="text-slate-600 mt-1">Update user information and permissions</p>
    </div>
    <div class="flex gap-3">
      <a href="{{ route('super_admin.user_management') }}" class="inline-flex items-center px-4 py-2 bg-slate-500 text-white rounded-lg hover:bg-slate-600 transition-colors duration-200 text-sm font-medium">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Back to Users
      </a>
      <a href="{{ route('super_admin.user_show', $user->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors duration-200 text-sm font-medium">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
        </svg>
        View User
      </a>
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
        <h3 class="text-lg font-semibold text-slate-900">User Information</h3>
    </div>

    <form method="POST" action="{{ route('super_admin.user_update', $user->id) }}" class="p-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Basic Information --}}
            <div class="lg:col-span-2">
                <h4 class="text-lg font-medium text-slate-900 mb-4">Basic Information</h4>
            </div>

            {{-- First Name --}}
            <div>
                <label for="first_name" class="block text-sm font-medium text-slate-700 mb-2">First Name *</label>
                <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $user->first_name) }}" required
                       class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition">
            </div>

            {{-- Last Name --}}
            <div>
                <label for="last_name" class="block text-sm font-medium text-slate-700 mb-2">Last Name *</label>
                <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $user->last_name) }}" required
                       class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition">
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="block text-sm font-medium text-slate-700 mb-2">Email Address *</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                       class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition">
            </div>

            {{-- Phone --}}
            <div>
                <label for="contact_number" class="block text-sm font-medium text-slate-700 mb-2">Phone Number</label>
                <input type="tel" name="contact_number" id="contact_number" value="{{ old('contact_number', $user->contact_number) }}"
                       class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition">
            </div>

            {{-- Business Name --}}
            <div class="lg:col-span-2">
                <label for="business_name" class="block text-sm font-medium text-slate-700 mb-2">Business Name</label>
                <input type="text" name="business_name" id="business_name" value="{{ old('business_name', $user->business_name) }}"
                       class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition">
            </div>

            {{-- Role & Permissions --}}
            <div class="lg:col-span-2 pt-6 border-t border-slate-200">
                <h4 class="text-lg font-medium text-slate-900 mb-4">Role & Permissions</h4>
            </div>

            {{-- Role --}}
            <div>
                <label for="role" class="block text-sm font-medium text-slate-700 mb-2">User Role *</label>
                <select name="role" id="role" required onchange="toggleVendorType()"
                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition">
                    <option value="">Select Role</option>
                    <option value="super_admin" {{ old('role', $user->role) == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="vendor" {{ old('role', $user->role) == 'vendor' ? 'selected' : '' }}>Vendor</option>
                    <option value="affiliate" {{ old('role', $user->role) == 'affiliate' ? 'selected' : '' }}>Affiliate</option>
                    <option value="payment_officer" {{ old('role', $user->role) == 'payment_officer' ? 'selected' : '' }}>Payment Officer</option>
                    <option value="booking_officer" {{ old('role', $user->role) == 'booking_officer' ? 'selected' : '' }}>Booking Officer</option>
                    <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User</option>
                </select>
            </div>

            {{-- Vendor Type --}}
            <div id="vendorTypeContainer" style="display: {{ old('role', $user->role) == 'vendor' ? 'block' : 'none' }};">
                <label for="vendor_type" class="block text-sm font-medium text-slate-700 mb-2">Vendor Type</label>
                <select name="vendor_type" id="vendor_type"
                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition">
                    <option value="">Select Vendor Type</option>
                    <option value="Hotel Partner" {{ old('vendor_type', $user->vendor_type) == 'Hotel Partner' ? 'selected' : '' }}>Hotel Partner</option>
                    <option value="Activity Partner" {{ old('vendor_type', $user->vendor_type) == 'Activity Partner' ? 'selected' : '' }}>Activity Partner</option>
                    <option value="Travel Guide" {{ old('vendor_type', $user->vendor_type) == 'Travel Guide' ? 'selected' : '' }}>Travel Guide</option>
                </select>
            </div>

            {{-- Account Status --}}
            <div>
                <label for="is_active" class="block text-sm font-medium text-slate-700 mb-2">Account Status *</label>
                <select name="is_active" id="is_active" required
                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition">
                    <option value="1" {{ old('is_active', $user->is_active) == '1' ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('is_active', $user->is_active) == '0' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            {{-- Password Section --}}
            <div class="lg:col-span-2 pt-6 border-t border-slate-200">
                <h4 class="text-lg font-medium text-slate-900 mb-2">Change Password</h4>
                <p class="text-sm text-slate-600 mb-4">Leave blank to keep current password</p>
            </div>

            {{-- New Password --}}
            <div class="lg:col-span-2">
                <label for="password" class="block text-sm font-medium text-slate-700 mb-2">New Password</label>
                <div class="relative">
                    <input type="password" name="password" id="password"
                           class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition pr-12"
                           placeholder="Enter new password (optional)">
                    <button type="button" onclick="togglePasswordVisibility('password')"
                            class="absolute right-3 top-3.5 text-slate-400 hover:text-slate-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </button>
                </div>
                <p class="text-xs text-slate-500 mt-1">Password must be at least 8 characters long.</p>
            </div>
        </div>

        {{-- Form Actions --}}
        <div class="flex flex-col sm:flex-row gap-3 pt-8 border-t border-slate-200 mt-8">
            <button type="submit" class="inline-flex items-center justify-center px-6 py-3 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors duration-200 font-medium">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Update User
            </button>
            <a href="{{ route('super_admin.user_show', $user->id) }}" class="inline-flex items-center justify-center px-6 py-3 bg-slate-500 text-white rounded-lg hover:bg-slate-600 transition-colors duration-200 font-medium">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                Cancel
            </a>
        </div>
    </form>
</div>

<script>
    function toggleVendorType() {
        const roleSelect = document.getElementById('role');
        const vendorTypeContainer = document.getElementById('vendorTypeContainer');

        if (roleSelect.value === 'vendor') {
            vendorTypeContainer.style.display = 'block';
        } else {
            vendorTypeContainer.style.display = 'none';
        }
    }

    function togglePasswordVisibility(fieldId) {
        const passwordInput = document.getElementById(fieldId);
        const eyeIcon = passwordInput.nextElementSibling.querySelector('svg');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
            `;
        } else {
            passwordInput.type = 'password';
            eyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
            `;
        }
    }
</script>

@endsection
