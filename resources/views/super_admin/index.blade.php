@extends('layouts.super_admin')

@section('content')

{{-- Page Header --}}
<div class="mb-8">
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
      <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">Welcome back, {{ Auth::user()->first_name }}! 👋</h1>
      <p class="text-slate-600 mt-1">Here's what's happening with your travel business today.</p>
    </div>
    <div class="flex flex-col sm:flex-row gap-2 sm:gap-3">
      <button class="inline-flex items-center justify-center px-4 py-2 bg-white border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50 transition-colors duration-200 text-sm font-medium">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
        Export Report
      </button>
      <button class="inline-flex items-center justify-center px-4 py-2 bg-[#EC5526] text-white rounded-lg hover:from-primary-600 hover:to-primary-700 transition-all duration-200 text-sm font-medium shadow-lg shadow-primary-500/25">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
        </svg>
        Add New Package
      </button>
    </div>
  </div>
</div>

{{-- Stats Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 sm:gap-6 mb-8">
  {{-- Active Bookings Card --}}
  <div class="group relative overflow-hidden rounded-2xl bg-white p-6 shadow-sm border border-slate-200 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
    <div class="absolute inset-0 bg-gradient-to-br from-blue-50 to-blue-100/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
    <div class="relative">
      <div class="flex items-center justify-between mb-4">
        <div class="flex items-center justify-center h-12 w-12 rounded-xl bg-blue-100 text-blue-600 group-hover:bg-blue-200 transition-colors duration-300">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
          </svg>
        </div>
        <span class="text-xs font-medium text-slate-500 bg-slate-100 px-2 py-1 rounded-full">Today</span>
      </div>
      <div class="text-3xl font-bold text-slate-900 mb-1">24</div>
      <div class="text-sm text-slate-600">Active Bookings</div>
      <div class="flex items-center mt-3 text-xs">
        <span class="text-green-600 font-medium">+12%</span>
        <span class="text-slate-500 ml-1">from yesterday</span>
      </div>
    </div>
  </div>

  {{-- Total Users Card --}}
  <div class="group relative overflow-hidden rounded-2xl bg-white p-6 shadow-sm border border-slate-200 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
    <div class="absolute inset-0 bg-gradient-to-br from-emerald-50 to-emerald-100/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
    <div class="relative">
      <div class="flex items-center justify-between mb-4">
        <div class="flex items-center justify-center h-12 w-12 rounded-xl bg-emerald-100 text-emerald-600 group-hover:bg-emerald-200 transition-colors duration-300">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
          </svg>
        </div>
        <span class="text-xs font-medium text-slate-500 bg-slate-100 px-2 py-1 rounded-full">All time</span>
      </div>
      <div class="text-3xl font-bold text-slate-900 mb-1">1,482</div>
      <div class="text-sm text-slate-600">Total Users</div>
      <div class="flex items-center mt-3 text-xs">
        <span class="text-green-600 font-medium">+23%</span>
        <span class="text-slate-500 ml-1">this month</span>
      </div>
    </div>
  </div>

  {{-- Package Utilization Card --}}
  <div class="group relative overflow-hidden rounded-2xl bg-white p-6 shadow-sm border border-slate-200 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
    <div class="absolute inset-0 bg-gradient-to-br from-amber-50 to-amber-100/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
    <div class="relative">
      <div class="flex items-center justify-between mb-4">
        <div class="flex items-center justify-center h-12 w-12 rounded-xl bg-amber-100 text-amber-600 group-hover:bg-amber-200 transition-colors duration-300">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M9 5v.01M15 5v.01"></path>
          </svg>
        </div>
        <span class="text-xs font-medium text-slate-500 bg-slate-100 px-2 py-1 rounded-full">This week</span>
      </div>
      <div class="text-3xl font-bold text-slate-900 mb-1">78%</div>
      <div class="text-sm text-slate-600">Package Utilization</div>
      <div class="flex items-center mt-3 text-xs">
        <span class="text-green-600 font-medium">+5%</span>
        <span class="text-slate-500 ml-1">from last week</span>
      </div>
    </div>
  </div>

  {{-- Revenue Card --}}
  <div class="group relative overflow-hidden rounded-2xl bg-white p-6 shadow-sm border border-slate-200 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
    <div class="absolute inset-0 bg-gradient-to-br from-primary-50 to-primary-100/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
    <div class="relative">
      <div class="flex items-center justify-between mb-4">
        <div class="flex items-center justify-center h-12 w-12 rounded-xl bg-primary-100 text-primary-600 group-hover:bg-primary-200 transition-colors duration-300">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
          </svg>
        </div>
        <span class="text-xs font-medium text-slate-500 bg-slate-100 px-2 py-1 rounded-full">This month</span>
      </div>
      <div class="text-3xl font-bold text-slate-900 mb-1">LKR 8.2M</div>
      <div class="text-sm text-slate-600">Revenue</div>
      <div class="flex items-center mt-3 text-xs">
        <span class="text-green-600 font-medium">+18%</span>
        <span class="text-slate-500 ml-1">from last month</span>
      </div>
    </div>
  </div>
</div>

{{-- Welcome Section --}}
<div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mb-8">
  {{-- Main Welcome Card --}}
  <div class="xl:col-span-2">
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-primary-500 via-primary-600 to-primary-700 p-8 text-white shadow-2xl">
      <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.05"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-30"></div>
      <div class="relative">
        <div class="flex items-center gap-4 mb-6">
          <div class="flex items-center justify-center h-16 w-16 rounded-2xl bg-white/20 backdrop-blur-sm">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
          </div>
          <div>
            <h2 class="text-2xl sm:text-3xl font-bold">Welcome to TripMe! ✈️</h2>
            <p class="text-primary-100 text-lg">Your travel business command center</p>
          </div>
        </div>

        <div class="space-y-4">
          <p class="text-primary-100 text-lg leading-relaxed">
            Manage your travel business with ease. Track bookings, manage users, and monitor your
            <span class="font-semibold text-white">revenue growth</span> all in one place.
          </p>

          <div class="flex flex-col sm:flex-row gap-3 pt-4">
            <button class="inline-flex items-center justify-center px-6 py-3 bg-white text-primary-600 rounded-xl font-semibold hover:bg-primary-50 transition-colors duration-200">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
              </svg>
              Create New Package
            </button>
            <button class="inline-flex items-center justify-center px-6 py-3 bg-white/20 text-white rounded-xl font-semibold hover:bg-white/30 transition-colors duration-200 backdrop-blur-sm">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
              </svg>
              View Analytics
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Quick Actions Card --}}
  <div class="space-y-6">
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
      <h3 class="text-lg font-semibold text-slate-900 mb-4">Quick Actions</h3>
      <div class="space-y-3">
        <button class="w-full flex items-center gap-3 px-4 py-3 text-left bg-slate-50 hover:bg-slate-100 rounded-xl transition-colors duration-200 group">
          <div class="flex items-center justify-center h-10 w-10 rounded-lg bg-blue-100 text-blue-600 group-hover:bg-blue-200 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
            </svg>
          </div>
          <div>
            <div class="font-medium text-slate-900">Manage Users</div>
            <div class="text-sm text-slate-500">View and edit user accounts</div>
          </div>
        </button>

        <button class="w-full flex items-center gap-3 px-4 py-3 text-left bg-slate-50 hover:bg-slate-100 rounded-xl transition-colors duration-200 group">
          <div class="flex items-center justify-center h-10 w-10 rounded-lg bg-emerald-100 text-emerald-600 group-hover:bg-emerald-200 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M9 5v.01M15 5v.01"></path>
            </svg>
          </div>
          <div>
            <div class="font-medium text-slate-900">Tour Packages</div>
            <div class="text-sm text-slate-500">Create and manage packages</div>
          </div>
        </button>

        <button class="w-full flex items-center gap-3 px-4 py-3 text-left bg-slate-50 hover:bg-slate-100 rounded-xl transition-colors duration-200 group">
          <div class="flex items-center justify-center h-10 w-10 rounded-lg bg-amber-100 text-amber-600 group-hover:bg-amber-200 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
            </svg>
          </div>
          <div>
            <div class="font-medium text-slate-900">View Reports</div>
            <div class="text-sm text-slate-500">Analytics and insights</div>
          </div>
        </button>
      </div>
    </div>

    {{-- Status Card --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
      <h3 class="text-lg font-semibold text-slate-900 mb-4">System Status</h3>
      <div class="space-y-3">
        <div class="flex items-center justify-between">
          <span class="text-sm text-slate-600">Server Status</span>
          <div class="flex items-center gap-2">
            <div class="h-2 w-2 rounded-full bg-green-500 animate-pulse"></div>
            <span class="text-sm font-medium text-green-600">Online</span>
          </div>
        </div>
        <div class="flex items-center justify-between">
          <span class="text-sm text-slate-600">Database</span>
          <div class="flex items-center gap-2">
            <div class="h-2 w-2 rounded-full bg-green-500"></div>
            <span class="text-sm font-medium text-green-600">Connected</span>
          </div>
        </div>
        <div class="flex items-center justify-between">
          <span class="text-sm text-slate-600">Last Backup</span>
          <span class="text-sm font-medium text-slate-600">2 hours ago</span>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
