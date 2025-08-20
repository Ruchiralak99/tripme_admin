@extends('layouts.super_admin')

@section('content')

{{-- Page Header --}}
<div class="mb-8">
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
      <div class="flex items-center gap-3 mb-2">
        <a href="{{ route('super_admin.packages') }}" class="text-slate-400 hover:text-slate-600 transition-colors">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
          </svg>
        </a>
        <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">Helicopter Rides</h1>
      </div>
      <p class="text-slate-600 mt-1">Manage helicopter tour categories and their details.</p>
    </div>
    <div class="flex gap-3">
      <a href="{{ route('super_admin.packages.rides.cities') }}" class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors duration-200 text-sm font-medium">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
        </svg>
        Add Available City
      </a>
      <a href="{{ route('super_admin.packages.rides_create') }}" class="inline-flex items-center px-4 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors duration-200 text-sm font-medium">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
        </svg>
        Add New Category
      </a>
    </div>
  </div>
</div>

{{-- Alert Messages --}}
@if (session('success'))
    <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg flex items-center">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16c-.77.833.192 2.5 1.732 2.5z"></path>
        </svg>
        {{ session('error') }}
    </div>
@endif

{{-- Categories Grid --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
  @forelse($ridesCategories as $category)
  <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden hover:shadow-lg transition-all duration-300">
    <div class="relative h-48 overflow-hidden">
      @if($category->image_path)
        <img src="{{ asset('storage/' . $category->image_path) }}"
             alt="{{ $category->name }}"
             class="w-full h-full object-cover">
      @else
        <div class="w-full h-full bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center">
          <svg class="w-16 h-16 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
          </svg>
        </div>
      @endif
      <div class="absolute inset-0 bg-black bg-opacity-30"></div>

      {{-- Status Badge --}}
      <div class="absolute top-4 left-4">
        <span class="bg-white bg-opacity-20 backdrop-blur-sm text-white px-3 py-1 rounded-full text-sm font-medium">
          {{ ucfirst($category->status) }}
        </span>
      </div>

      {{-- Price Badge --}}
      <div class="absolute top-4 right-4">
        <span class="bg-white bg-opacity-90 text-slate-900 px-3 py-1 rounded-full text-sm font-bold">
          Rs. {{ number_format($category->regular_value, 2) }}
        </span>
      </div>

      {{-- Discount Badge (if applicable) --}}
      @if($category->discount_percentage > 0)
      <div class="absolute top-16 right-4">
        <span class="bg-red-500 text-white px-2 py-1 rounded-full text-xs font-medium">
          {{ $category->discount_percentage }}% OFF
        </span>
      </div>
      @endif

      {{-- Action Buttons Overlay --}}
      <div class="absolute bottom-4 right-4 flex gap-2">
        <a href="{{ route('super_admin.packages.rides_edit', $category->id) }}"
           class="p-2 bg-white bg-opacity-90 text-slate-700 rounded-lg hover:bg-white transition-colors text-sm">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
          </svg>
        </a>
        <form method="POST" action="{{ route('super_admin.packages.rides_delete', $category->id) }}" class="inline"
              onsubmit="return confirm('Are you sure you want to delete this category?')">
          @csrf
          @method('DELETE')
          <button type="submit" class="p-2 bg-red-500 bg-opacity-90 text-white rounded-lg hover:bg-red-600 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
            </svg>
          </button>
        </form>
      </div>
    </div>

    <div class="p-6">
      <h3 class="text-xl font-bold text-slate-900 mb-2">{{ $category->name }}</h3>
      <p class="text-slate-600 mb-4 text-sm">{{ $category->description }}</p>

      <div class="grid grid-cols-2 gap-4 mb-4">
        @if($category->duration)
        <div class="flex items-center text-sm text-slate-500">
          <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
          {{ $category->duration }}
        </div>
        @endif
        @if($category->passenger_capacity)
        <div class="flex items-center text-sm text-slate-500">
          <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
          </svg>
          {{ $category->passenger_capacity }} seats
        </div>
        @endif
      </div>

      <div class="space-y-2 text-sm mb-4">
        <div class="flex justify-between">
          <span class="text-slate-500">Base Price:</span>
          <span class="font-medium">Rs. {{ number_format($category->price_lkr, 2) }}</span>
        </div>
        <div class="flex justify-between">
          <span class="text-slate-500">Tax ({{ $category->tax_percentage }}%):</span>
          <span class="font-medium">Rs. {{ number_format(($category->price_lkr * $category->tax_percentage) / 100, 2) }}</span>
        </div>
        @if($category->discount_percentage > 0)
        <div class="flex justify-between">
          <span class="text-slate-500">Discount ({{ $category->discount_percentage }}%):</span>
          <span class="font-medium text-green-600">- Rs. {{ number_format((($category->price_lkr + ($category->price_lkr * $category->tax_percentage) / 100) * $category->discount_percentage) / 100, 2) }}</span>
        </div>
        @endif
      </div>

      <div class="flex items-center justify-between pt-4 border-t border-slate-200">
        <div class="text-lg font-bold text-primary-600">
          Rs. {{ number_format($category->regular_value, 2) }}
        </div>
        <div class="flex items-center gap-2">
          <span class="w-2 h-2 bg-{{ $category->status === 'active' ? 'green' : 'red' }}-500 rounded-full"></span>
          <span class="text-sm text-slate-600 capitalize">{{ $category->status }}</span>
        </div>
      </div>
    </div>
  </div>
  @empty
  <div class="lg:col-span-2">
    <div class="text-center py-12">
      <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v11a2 2 0 002 2h2m0-13h10a2 2 0 012 2v11a2 2 0 01-2 2H9m0-13v13"></path>
      </svg>
      <h3 class="mt-2 text-sm font-medium text-slate-900">No ride categories</h3>
      <p class="mt-1 text-sm text-slate-500">Get started by creating a new helicopter tour category.</p>
      <div class="mt-6">
        <a href="{{ route('super_admin.packages.rides_create') }}" class="inline-flex items-center px-4 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors duration-200 text-sm font-medium">
          <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
          </svg>
          Create First Category
        </a>
      </div>
    </div>
  </div>
  @endforelse
</div>

{{-- Statistics Cards --}}
<div class="grid grid-cols-1 md:grid-cols-4 gap-6">
  <div class="bg-gradient-to-r from-blue-50 to-blue-100 border border-blue-200 rounded-xl p-6">
    <div class="flex items-center">
      <div class="p-3 bg-blue-500 text-white rounded-lg">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
        </svg>
      </div>
      <div class="ml-4">
        <h3 class="text-lg font-semibold text-slate-900">{{ $ridesCategories->count() }}</h3>
        <p class="text-slate-600 text-sm">Total Categories</p>
      </div>
    </div>
  </div>

  <div class="bg-gradient-to-r from-green-50 to-green-100 border border-green-200 rounded-xl p-6">
    <div class="flex items-center">
      <div class="p-3 bg-green-500 text-white rounded-lg">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
      </div>
      <div class="ml-4">
        <h3 class="text-lg font-semibold text-slate-900">{{ $ridesCategories->where('status', 'active')->count() }}</h3>
        <p class="text-slate-600 text-sm">Active Categories</p>
      </div>
    </div>
  </div>

  <div class="bg-gradient-to-r from-yellow-50 to-yellow-100 border border-yellow-200 rounded-xl p-6">
    <div class="flex items-center">
      <div class="p-3 bg-yellow-500 text-white rounded-lg">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
        </svg>
      </div>
      <div class="ml-4">
        <h3 class="text-lg font-semibold text-slate-900">Rs. {{ number_format($ridesCategories->sum('regular_value'), 2) }}</h3>
        <p class="text-slate-600 text-sm">Total Value</p>
      </div>
    </div>
  </div>

  <div class="bg-gradient-to-r from-purple-50 to-purple-100 border border-purple-200 rounded-xl p-6">
    <div class="flex items-center">
      <div class="p-3 bg-purple-500 text-white rounded-lg">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
        </svg>
      </div>
      <div class="ml-4">
        <h3 class="text-lg font-semibold text-slate-900">{{ $ridesCategories->sum('passenger_capacity') ?? 0 }}</h3>
        <p class="text-slate-600 text-sm">Total Capacity</p>
      </div>
    </div>
  </div>
</div>

@endsection
