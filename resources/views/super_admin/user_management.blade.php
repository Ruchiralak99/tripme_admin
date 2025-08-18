@extends('layouts.super_admin')

@section('content')

{{-- Page Header --}}
<div class="mb-8">
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
      <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">User Management</h1>
      <p class="text-slate-600 mt-1">Manage all users, their roles, and permissions in your system.</p>
    </div>
    <div class="flex flex-col sm:flex-row gap-2 sm:gap-3">
      <a href="{{ route('super_admin.user_create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-gradient-to-r from-primary-500 to-primary-600 text-white rounded-lg hover:from-primary-600 hover:to-primary-700 transition-all duration-200 text-sm font-medium shadow-lg shadow-primary-500/25">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
        </svg>
        Add New User
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
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        {{ session('error') }}
    </div>
@endif

{{-- Filters and Search --}}
<div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200 mb-6">
    <form method="GET" action="{{ route('super_admin.user_management') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        {{-- Search --}}
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-slate-700 mb-2">Search Users</label>
            <div class="relative">
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Search by name, email, or business..."
                       class="w-full pl-10 pr-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition">
                <svg class="absolute left-3 top-2.5 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
        </div>

        {{-- Role Filter --}}
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Filter by Role</label>
            <select name="role" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition">
                <option value="">All Roles</option>
                <option value="super_admin" {{ request('role') == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="vendor" {{ request('role') == 'vendor' ? 'selected' : '' }}>Vendor</option>
                <option value="affiliate" {{ request('role') == 'affiliate' ? 'selected' : '' }}>Affiliate</option>
                <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
            </select>
        </div>

        {{-- Status Filter --}}
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Filter by Status</label>
            <select name="status" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition">
                <option value="">All Status</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        {{-- Buttons --}}
        <div class="md:col-span-4 flex gap-3 pt-2">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors duration-200 text-sm font-medium">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z"></path>
                </svg>
                Apply Filters
            </button>
            <a href="{{ route('super_admin.user_management') }}" class="inline-flex items-center px-4 py-2 bg-slate-500 text-white rounded-lg hover:bg-slate-600 transition-colors duration-200 text-sm font-medium">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Clear Filters
            </a>
        </div>
    </form>
</div>

{{-- Users Table --}}
<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-200">
        <h3 class="text-lg font-semibold text-slate-900">Users ({{ $users->total() }} total)</h3>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">User</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Role</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Joined</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Last Login</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($users as $user)
                <tr class="hover:bg-slate-50 transition-colors duration-200">
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="flex items-center justify-center h-10 w-10 rounded-lg bg-gradient-to-br from-primary-500 to-primary-600 text-white font-semibold text-sm mr-4">
                                {{ substr($user->first_name, 0, 1) }}{{ substr($user->last_name, 0, 1) }}
                            </div>
                            <div>
                                <div class="text-sm font-medium text-slate-900">{{ $user->first_name }} {{ $user->last_name }}</div>
                                <div class="text-sm text-slate-500">{{ $user->email }}</div>
                                @if($user->business_name)
                                    <div class="text-xs text-slate-400">{{ $user->business_name }}</div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            @if($user->role == 'super_admin') bg-purple-100 text-purple-800
                            @elseif($user->role == 'admin') bg-blue-100 text-blue-800
                            @elseif($user->role == 'vendor') bg-green-100 text-green-800
                            @elseif($user->role == 'affiliate') bg-orange-100 text-orange-800
                            @else bg-slate-100 text-slate-800
                            @endif">
                            {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                        </span>
                        @if($user->vendor_type)
                            <div class="text-xs text-slate-500 mt-1">{{ $user->vendor_type }}</div>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if($user->is_active)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <div class="w-1.5 h-1.5 bg-green-400 rounded-full mr-1.5"></div>
                                Active
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                <div class="w-1.5 h-1.5 bg-red-400 rounded-full mr-1.5"></div>
                                Inactive
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-500">
                        {{ $user->created_at->format('M d, Y') }}
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-500">
                        {{ $user->last_login_at ? $user->last_login_at->format('M d, Y H:i') : 'Never' }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-2">
                            {{-- View Button --}}
                            <a href="{{ route('super_admin.user_show', $user->id) }}" class="inline-flex items-center justify-center h-8 w-8 rounded-lg bg-blue-100 text-blue-600 hover:bg-blue-200 transition-colors duration-200" title="View User">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </a>

                            {{-- Edit Button --}}
                            <a href="{{ route('super_admin.user_edit', $user->id) }}" class="inline-flex items-center justify-center h-8 w-8 rounded-lg bg-amber-100 text-amber-600 hover:bg-amber-200 transition-colors duration-200" title="Edit User">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>

                            {{-- Toggle Status Button --}}
                            @if($user->id !== Auth::id())
                                <form method="POST" action="{{ route('super_admin.user_toggle_status', $user->id) }}" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="inline-flex items-center justify-center h-8 w-8 rounded-lg {{ $user->is_active ? 'bg-orange-100 text-orange-600 hover:bg-orange-200' : 'bg-green-100 text-green-600 hover:bg-green-200' }} transition-colors duration-200"
                                            title="{{ $user->is_active ? 'Deactivate User' : 'Activate User' }}">
                                        @if($user->is_active)
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"></path>
                                            </svg>
                                        @else
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        @endif
                                    </button>
                                </form>

                                {{-- Delete Button --}}
                                <form method="POST" action="{{ route('super_admin.user_delete', $user->id) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center justify-center h-8 w-8 rounded-lg bg-red-100 text-red-600 hover:bg-red-200 transition-colors duration-200" title="Delete User">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center">
                            <svg class="w-12 h-12 text-slate-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                            <h3 class="text-lg font-medium text-slate-900 mb-1">No users found</h3>
                            <p class="text-slate-500">Try adjusting your search criteria or add a new user.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($users->hasPages())
        <div class="px-6 py-4 border-t border-slate-200">
            {{ $users->appends(request()->query())->links() }}
        </div>
    @endif
</div>

@endsection

