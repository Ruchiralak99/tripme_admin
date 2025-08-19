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
        <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">Air Taxi Services</h1>
      </div>
      <p class="text-slate-600 mt-1">Premium helicopter and private jet transportation services.</p>
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
      <h3 class="text-lg font-semibold text-slate-900 mb-1">Air Taxi Services - Under Development</h3>
      <p class="text-slate-600 text-sm">This section is currently being developed. Full management features will be available soon.</p>
    </div>
  </div>
</div>

{{-- Preview Services --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
  @foreach($airTaxiServices as $service)
  <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="relative h-48 overflow-hidden">
      <img src="{{ $service['image'] }}"
           alt="{{ $service['name'] }}"
           class="w-full h-full object-cover">
      <div class="absolute inset-0 bg-black bg-opacity-30"></div>
      <div class="absolute top-4 left-4">
        <span class="bg-white bg-opacity-20 backdrop-blur-sm text-white px-3 py-1 rounded-full text-sm font-medium">
          Premium
        </span>
      </div>
      <div class="absolute bottom-4 right-4">
        <span class="bg-white bg-opacity-90 text-slate-900 px-3 py-1 rounded-full text-sm font-bold">
          ${{ number_format($service['price']) }}
        </span>
      </div>
    </div>

    <div class="p-6">
      <h3 class="text-xl font-bold text-slate-900 mb-2">{{ $service['name'] }}</h3>
      <p class="text-slate-600 mb-4 text-sm">{{ $service['description'] }}</p>

      <div class="flex items-center justify-between">
        <div class="flex items-center text-sm text-slate-500">
          <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
          {{ $service['duration'] }}
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

{{-- Features Info --}}
<div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
  <div class="bg-white rounded-xl border border-slate-200 p-6 text-center">
    <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-lg mx-auto mb-4 flex items-center justify-center">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
      </svg>
    </div>
    <h3 class="font-semibold text-slate-900 mb-2">Premium Aircraft</h3>
    <p class="text-sm text-slate-600">Modern helicopters and private jets with luxury amenities</p>
  </div>

  <div class="bg-white rounded-xl border border-slate-200 p-6 text-center">
    <div class="w-12 h-12 bg-green-100 text-green-600 rounded-lg mx-auto mb-4 flex items-center justify-center">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
      </svg>
    </div>
    <h3 class="font-semibold text-slate-900 mb-2">Safety First</h3>
    <p class="text-sm text-slate-600">Certified pilots and maintained aircraft for maximum safety</p>
  </div>

  <div class="bg-white rounded-xl border border-slate-200 p-6 text-center">
    <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-lg mx-auto mb-4 flex items-center justify-center">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
      </svg>
    </div>
    <h3 class="font-semibold text-slate-900 mb-2">24/7 Service</h3>
    <p class="text-sm text-slate-600">Round-the-clock availability for urgent transportation needs</p>
  </div>
</div>

@endsection
