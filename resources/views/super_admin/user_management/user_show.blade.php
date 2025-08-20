@extends('layouts.super_admin')

@section('content')

{{-- Page Header --}}
<div class="mb-8">
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
      <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">User Details</h1>
      <p class="text-slate-600 mt-1">View detailed information about {{ $user->first_name }} {{ $user->last_name }}</p>
    </div>
    <div class="flex gap-3">
      <a href="{{ route('super_admin.user_management') }}" class="inline-flex items-center px-4 py-2 bg-slate-500 text-white rounded-lg hover:bg-slate-600 transition-colors duration-200 text-sm font-medium">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Back to Users
      </a>
      <a href="{{ route('super_admin.user_edit', $user->id) }}" class="inline-flex items-center px-4 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors duration-200 text-sm font-medium">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
        </svg>
        Edit User
      </a>
    </div>
  </div>
</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
  {{-- Main User Information --}}
  <div class="xl:col-span-2 space-y-6">
    {{-- Basic Information --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
      <h3 class="text-lg font-semibold text-slate-900 mb-6">Basic Information</h3>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">First Name</label>
          <div class="text-slate-900 font-medium">{{ $user->first_name }}</div>
        </div>

        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">Last Name</label>
          <div class="text-slate-900 font-medium">{{ $user->last_name }}</div>
        </div>

        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">Email Address</label>
          <div class="text-slate-900 font-medium">{{ $user->email }}</div>
        </div>

        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">Phone Number</label>
          <div class="text-slate-900 font-medium">{{ $user->contact_number ?: 'Not provided' }}</div>
        </div>

        @if($user->business_name)
        <div class="md:col-span-2">
          <label class="block text-sm font-medium text-slate-700 mb-2">Business Name</label>
          <div class="text-slate-900 font-medium">{{ $user->business_name }}</div>
        </div>
        @endif
      </div>
    </div>

    {{-- Role & Status Information --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
      <h3 class="text-lg font-semibold text-slate-900 mb-6">Role & Status</h3>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">User Role</label>
          <span @class([
            'inline-flex items-center px-3 py-1 rounded-full text-sm font-medium',
            'bg-purple-100 text-purple-800' => $user->role === 'super_admin',
            'bg-blue-100 text-blue-800' => $user->role === 'admin',
            'bg-green-100 text-green-800' => $user->role === 'vendor',
            'bg-orange-100 text-orange-800' => $user->role === 'affiliate',
            'bg-slate-100 text-slate-800' => !in_array($user->role, ['super_admin','admin','vendor','affiliate']),
        ])>
            {{ ucfirst(str_replace('_', ' ', $user->role)) }}
        </span>
        </div>

        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">Account Status</label>
          @if($user->is_active)
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
              <div class="w-2 h-2 bg-green-400 rounded-full mr-2"></div>
              Active
            </span>
          @else
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
              <div class="w-2 h-2 bg-red-400 rounded-full mr-2"></div>
              Inactive
            </span>
          @endif
        </div>

        @if($user->vendor_type)
        <div class="md:col-span-2">
          <label class="block text-sm font-medium text-slate-700 mb-2">Vendor Type</label>
          <div class="text-slate-900 font-medium">{{ $user->vendor_type }}</div>
        </div>
        @endif
      </div>
    </div>

    {{-- Additional Information --}}
    @if($user->address || $user->city || $user->country)
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
      <h3 class="text-lg font-semibold text-slate-900 mb-6">Location Information</h3>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @if($user->address)
        <div class="md:col-span-2">
          <label class="block text-sm font-medium text-slate-700 mb-2">Address</label>
          <div class="text-slate-900 font-medium">{{ $user->address }}</div>
        </div>
        @endif

        @if($user->city)
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">City</label>
          <div class="text-slate-900 font-medium">{{ $user->city }}</div>
        </div>
        @endif

        @if($user->country)
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">Country</label>
          <div class="text-slate-900 font-medium">{{ $user->country }}</div>
        </div>
        @endif
      </div>
    </div>
    @endif
  </div>

  {{-- Sidebar --}}
  <div class="space-y-6">
    {{-- Profile Card --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
      <div class="text-center">
        <div class="flex items-center justify-center h-20 w-20 rounded-2xl bg-gradient-to-br from-primary-500 to-primary-600 text-white font-bold text-2xl mx-auto mb-4">
          {{ substr($user->first_name, 0, 1) }}{{ substr($user->last_name, 0, 1) }}
        </div>
        <h3 class="text-xl font-semibold text-slate-900">{{ $user->first_name }} {{ $user->last_name }}</h3>
        <p class="text-slate-600 mt-1">{{ $user->email }}</p>
      </div>
    </div>

    {{-- Account Statistics --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
      <h3 class="text-lg font-semibold text-slate-900 mb-4">Account Statistics</h3>

      <div class="space-y-4">
        <div class="flex items-center justify-between">
          <span class="text-sm text-slate-600">Member Since</span>
          <span class="text-sm font-medium text-slate-900">{{ $user->created_at->format('M d, Y') }}</span>
        </div>

        <div class="flex items-center justify-between">
          <span class="text-sm text-slate-600">Last Login</span>
          <span class="text-sm font-medium text-slate-900">{{ $user->last_login_at ? $user->last_login_at->format('M d, Y H:i') : 'Never' }}</span>
        </div>

        <div class="flex items-center justify-between">
          <span class="text-sm text-slate-600">Email Verified</span>
          <span class="text-sm font-medium text-slate-900">{{ $user->email_verified_at ? 'Yes' : 'No' }}</span>
        </div>

        <div class="flex items-center justify-between">
          <span class="text-sm text-slate-600">Account Age</span>
          <span class="text-sm font-medium text-slate-900">{{ $user->created_at->diffForHumans() }}</span>
        </div>
      </div>
    </div>

    {{-- Quick Actions --}}
    @if($user->id !== Auth::id())
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
      <h3 class="text-lg font-semibold text-slate-900 mb-4">Quick Actions</h3>

      <div class="space-y-3">
        <a href="{{ route('super_admin.user_edit', $user->id) }}" class="w-full flex items-center justify-center px-4 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors duration-200 text-sm font-medium">
          <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
          </svg>
          Edit User
        </a>

        <form method="POST" action="{{ route('super_admin.user_toggle_status', $user->id) }}">
          @csrf
          @method('PATCH')
          <button type="submit" class="w-full flex items-center justify-center px-4 py-2 {{ $user->is_active ? 'bg-orange-500 hover:bg-orange-600' : 'bg-green-500 hover:bg-green-600' }} text-white rounded-lg transition-colors duration-200 text-sm font-medium">
            @if($user->is_active)
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"></path>
              </svg>
              Deactivate User
            @else
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              Activate User
            @endif
          </button>
        </form>

        <form method="POST" action="{{ route('super_admin.user_delete', $user->id) }}" onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
          @csrf
          @method('DELETE')
          <button type="submit" class="w-full flex items-center justify-center px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors duration-200 text-sm font-medium">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
            </svg>
            Delete User
          </button>
        </form>
      </div>
    </div>
    @endif
  </div>
</div>

@endsection
