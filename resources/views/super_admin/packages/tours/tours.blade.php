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
        <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">Tour Packages</h1>
      </div>
      <p class="text-slate-600 mt-1">Comprehensive tour experiences including cultural, adventure, and sightseeing packages.</p>
    </div>
    <div class="flex gap-3">
      <span class="inline-flex items-center px-3 py-1 bg-orange-100 text-orange-700 rounded-full text-sm font-medium">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        Coming Soon
      </span>
    </div>
  </div>
</div>

{{-- Coming Soon Notice --}}
<div class="bg-gradient-to-r from-orange-50 to-orange-100 border border-orange-200 rounded-xl p-6 mb-8">
  <div class="flex items-center">
    <div class="p-3 bg-orange-500 text-white rounded-lg">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
      </svg>
    </div>
    <div class="ml-4">
      <h3 class="text-lg font-semibold text-slate-900 mb-1">Tour Packages - Under Development</h3>
      <p class="text-slate-600 text-sm">This section is currently being developed. Full management features will be available soon.</p>
    </div>
  </div>
</div>

{{-- Preview Tours --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
  @foreach($tourPackages as $tour)
  <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="relative h-56 overflow-hidden">
      <img src="{{ $tour['image'] }}"
           alt="{{ $tour['name'] }}"
           class="w-full h-full object-cover">
      <div class="absolute inset-0 bg-black bg-opacity-30"></div>
      <div class="absolute top-4 left-4">
        <span class="bg-white bg-opacity-20 backdrop-blur-sm text-white px-3 py-1 rounded-full text-sm font-medium">
          Preview
        </span>
      </div>
      <div class="absolute bottom-4 right-4">
        <span class="bg-white bg-opacity-90 text-slate-900 px-3 py-1 rounded-full text-sm font-bold">
          ${{ number_format($tour['price']) }}
        </span>
      </div>
    </div>

    <div class="p-6">
      <h3 class="text-xl font-bold text-slate-900 mb-2">{{ $tour['name'] }}</h3>
      <p class="text-slate-600 mb-4 text-sm">{{ $tour['description'] }}</p>

      <div class="flex items-center justify-between">
        <div class="flex items-center text-sm text-slate-500">
          <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
          </svg>
          {{ $tour['duration'] }}
        </div>
        <div class="flex gap-2">
          <button class="px-3 py-1 text-xs bg-slate-100 text-slate-600 rounded-lg cursor-not-allowed" disabled>
            Preview Only
          </button>
        </div>
      </div>
    </div>
  </div>
  @endforeach
</div>

{{-- Tour Categories --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
  <div class="bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-xl p-6">
    <div class="flex items-center mb-4">
      <div class="p-3 bg-blue-500 text-white rounded-lg">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
        </svg>
      </div>
      <div class="ml-4">
        <h3 class="font-semibold text-slate-900">Cultural Tours</h3>
        <p class="text-slate-600 text-sm">Heritage & traditions</p>
      </div>
    </div>
    <div class="space-y-2 text-sm">
      <div class="flex justify-between">
        <span class="text-slate-600">Temple Tours</span>
        <span class="text-slate-500">Coming Soon</span>
      </div>
      <div class="flex justify-between">
        <span class="text-slate-600">Historical Sites</span>
        <span class="text-slate-500">Coming Soon</span>
      </div>
      <div class="flex justify-between">
        <span class="text-slate-600">Local Culture</span>
        <span class="text-slate-500">Coming Soon</span>
      </div>
    </div>
  </div>

  <div class="bg-gradient-to-br from-green-50 to-green-100 border border-green-200 rounded-xl p-6">
    <div class="flex items-center mb-4">
      <div class="p-3 bg-green-500 text-white rounded-lg">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
        </svg>
      </div>
      <div class="ml-4">
        <h3 class="font-semibold text-slate-900">Adventure Tours</h3>
        <p class="text-slate-600 text-sm">Thrilling experiences</p>
      </div>
    </div>
    <div class="space-y-2 text-sm">
      <div class="flex justify-between">
        <span class="text-slate-600">Wildlife Safari</span>
        <span class="text-slate-500">Coming Soon</span>
      </div>
      <div class="flex justify-between">
        <span class="text-slate-600">Mountain Trekking</span>
        <span class="text-slate-500">Coming Soon</span>
      </div>
      <div class="flex justify-between">
        <span class="text-slate-600">Water Sports</span>
        <span class="text-slate-500">Coming Soon</span>
      </div>
    </div>
  </div>

  <div class="bg-gradient-to-br from-purple-50 to-purple-100 border border-purple-200 rounded-xl p-6">
    <div class="flex items-center mb-4">
      <div class="p-3 bg-purple-500 text-white rounded-lg">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
        </svg>
      </div>
      <div class="ml-4">
        <h3 class="font-semibold text-slate-900">Sightseeing Tours</h3>
        <p class="text-slate-600 text-sm">Scenic destinations</p>
      </div>
    </div>
    <div class="space-y-2 text-sm">
      <div class="flex justify-between">
        <span class="text-slate-600">City Highlights</span>
        <span class="text-slate-500">Coming Soon</span>
      </div>
      <div class="flex justify-between">
        <span class="text-slate-600">Scenic Routes</span>
        <span class="text-slate-500">Coming Soon</span>
      </div>
      <div class="flex justify-between">
        <span class="text-slate-600">Photography Tours</span>
        <span class="text-slate-500">Coming Soon</span>
      </div>
    </div>
  </div>
</div>

{{-- Features Info --}}
<div class="grid grid-cols-1 md:grid-cols-4 gap-6">
  <div class="bg-white rounded-xl border border-slate-200 p-6 text-center">
    <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-lg mx-auto mb-4 flex items-center justify-center">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
      </svg>
    </div>
    <h3 class="font-semibold text-slate-900 mb-2">Expert Guides</h3>
    <p class="text-sm text-slate-600">Professional local guides</p>
  </div>

  <div class="bg-white rounded-xl border border-slate-200 p-6 text-center">
    <div class="w-12 h-12 bg-green-100 text-green-600 rounded-lg mx-auto mb-4 flex items-center justify-center">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
      </svg>
    </div>
    <h3 class="font-semibold text-slate-900 mb-2">All Inclusive</h3>
    <p class="text-sm text-slate-600">No hidden costs</p>
  </div>

  <div class="bg-white rounded-xl border border-slate-200 p-6 text-center">
    <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-lg mx-auto mb-4 flex items-center justify-center">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
      </svg>
    </div>
    <h3 class="font-semibold text-slate-900 mb-2">Memorable</h3>
    <p class="text-sm text-slate-600">Unforgettable experiences</p>
  </div>

  <div class="bg-white rounded-xl border border-slate-200 p-6 text-center">
    <div class="w-12 h-12 bg-yellow-100 text-yellow-600 rounded-lg mx-auto mb-4 flex items-center justify-center">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
      </svg>
    </div>
    <h3 class="font-semibold text-slate-900 mb-2">Flexible</h3>
    <p class="text-sm text-slate-600">Customizable packages</p>
  </div>
</div>

@endsection
