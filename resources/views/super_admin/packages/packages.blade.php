@extends('layouts.super_admin')

@section('content')

{{-- Page Header --}}
<div class="mb-8">
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
      <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">Package Management</h1>
      <p class="text-slate-600 mt-1">Manage all travel packages, categories, and their sub-services.</p>
    </div>
  </div>
</div>

{{-- Package Cards --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">

  {{-- Air Taxi Package --}}
  <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden hover:shadow-lg transition-all duration-300 group">
    <div class="relative h-48 bg-gradient-to-br from-blue-500 to-blue-700 overflow-hidden">
      <img src="https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?w=400&h=300&fit=crop"
           alt="Air Taxi"
           class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
      <div class="absolute inset-0 bg-black bg-opacity-30"></div>
      <div class="absolute top-4 left-4">
        <span class="bg-white bg-opacity-20 backdrop-blur-sm text-white px-3 py-1 rounded-full text-sm font-medium">
          Premium Service
        </span>
      </div>
    </div>
    <div class="p-6">
      <h3 class="text-xl font-bold text-slate-900 mb-2">Air Taxi</h3>
      <p class="text-slate-600 mb-4 text-sm">Premium helicopter and private jet services for quick and luxurious transportation.</p>
      <div class="flex items-center justify-between">
        <div class="text-sm text-slate-500">
          <span class="font-medium">Coming Soon</span>
        </div>
        <a href="{{ route('super_admin.packages.air_taxi') }}"
           class="inline-flex items-center px-4 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors duration-200 text-sm font-medium">
          View Details
          <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
          </svg>
        </a>
      </div>
    </div>
  </div>

  {{-- Rides Package --}}
  <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden hover:shadow-lg transition-all duration-300 group">
    <div class="relative h-48 bg-gradient-to-br from-green-500 to-green-700 overflow-hidden">
      <img src="https://images.unsplash.com/photo-1518709268805-4e9042af2176?w=400&h=300&fit=crop"
           alt="Helicopter Rides"
           class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
      <div class="absolute inset-0 bg-black bg-opacity-30"></div>
      <div class="absolute top-4 left-4">
        <span class="bg-white bg-opacity-20 backdrop-blur-sm text-white px-3 py-1 rounded-full text-sm font-medium">
          Active
        </span>
      </div>
    </div>
    <div class="p-6">
      <h3 class="text-xl font-bold text-slate-900 mb-2">Rides</h3>
      <p class="text-slate-600 mb-4 text-sm">Helicopter tours and rides offering spectacular aerial views and unforgettable experiences.</p>
      <div class="flex items-center justify-between">
        <div class="text-sm text-slate-500">
          <span class="font-medium">4 Categories</span>
        </div>
        <a href="{{ route('super_admin.packages.rides') }}"
           class="inline-flex items-center px-4 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors duration-200 text-sm font-medium">
          Manage
          <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
          </svg>
        </a>
      </div>
    </div>
  </div>

  {{-- Tours Package --}}
  <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden hover:shadow-lg transition-all duration-300 group">
    <div class="relative h-48 bg-gradient-to-br from-purple-500 to-purple-700 overflow-hidden">
      <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=400&h=300&fit=crop"
           alt="Tours"
           class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
      <div class="absolute inset-0 bg-black bg-opacity-30"></div>
      <div class="absolute top-4 left-4">
        <span class="bg-white bg-opacity-20 backdrop-blur-sm text-white px-3 py-1 rounded-full text-sm font-medium">
          Coming Soon
        </span>
      </div>
    </div>
    <div class="p-6">
      <h3 class="text-xl font-bold text-slate-900 mb-2">Tours</h3>
      <p class="text-slate-600 mb-4 text-sm">Comprehensive tour packages including cultural, adventure, and sightseeing experiences.</p>
      <div class="flex items-center justify-between">
        <div class="text-sm text-slate-500">
          <span class="font-medium">Coming Soon</span>
        </div>
        <a href="{{ route('super_admin.packages.tours') }}"
           class="inline-flex items-center px-4 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors duration-200 text-sm font-medium">
          View Details
          <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
          </svg>
        </a>
      </div>
    </div>
  </div>

</div>

{{-- Quick Stats --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
  <div class="bg-gradient-to-r from-blue-50 to-blue-100 border border-blue-200 rounded-xl p-6">
    <div class="flex items-center">
      <div class="p-3 bg-blue-500 text-white rounded-lg">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
        </svg>
      </div>
      <div class="ml-4">
        <h3 class="text-lg font-semibold text-slate-900">Air Taxi Services</h3>
        <p class="text-slate-600 text-sm">Premium aviation services</p>
      </div>
    </div>
  </div>

  <div class="bg-gradient-to-r from-green-50 to-green-100 border border-green-200 rounded-xl p-6">
    <div class="flex items-center">
      <div class="p-3 bg-green-500 text-white rounded-lg">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
        </svg>
      </div>
      <div class="ml-4">
        <h3 class="text-lg font-semibold text-slate-900">Helicopter Rides</h3>
        <p class="text-slate-600 text-sm">4 active categories</p>
      </div>
    </div>
  </div>

  <div class="bg-gradient-to-r from-purple-50 to-purple-100 border border-purple-200 rounded-xl p-6">
    <div class="flex items-center">
      <div class="p-3 bg-purple-500 text-white rounded-lg">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
        </svg>
      </div>
      <div class="ml-4">
        <h3 class="text-lg font-semibold text-slate-900">Tour Packages</h3>
        <p class="text-slate-600 text-sm">Comprehensive experiences</p>
      </div>
    </div>
  </div>
</div>

@endsection
