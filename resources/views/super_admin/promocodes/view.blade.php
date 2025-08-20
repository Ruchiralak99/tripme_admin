@extends('layouts.super_admin')

@section('content')

<div class="p-6">
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center space-x-4">
            <a href="{{ route('super_admin.promo_codes') }}"
               class="flex items-center text-gray-500 hover:text-gray-700 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Promo Codes
            </a>
            <div class="h-5 border-l border-gray-300"></div>
            <h1 class="text-2xl font-bold text-slate-900">Promo Code Details</h1>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('super_admin.promo_codes.edit', $promoCode->id) }}"
               class="inline-flex items-center px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit Promo Code
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Main Details --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Basic Information --}}
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                <h3 class="text-lg font-semibold text-slate-900 mb-4">Basic Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Promo Code</label>
                        <div class="bg-slate-50 rounded-lg p-3">
                            <span class="text-xl font-bold font-mono text-slate-900">{{ $promoCode->code }}</span>
                        </div>
                    </div>
                    @if($promoCode->author)
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Created By</label>
                            <div class="flex items-center text-slate-900">
                                <svg class="w-5 h-5 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                {{ $promoCode->author }}
                            </div>
                        </div>
                    @endif
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-2">Description</label>
                        <p class="text-slate-900 bg-slate-50 rounded-lg p-3">{{ $promoCode->description }}</p>
                    </div>
                </div>
            </div>

            {{-- Discount Settings --}}
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                <h3 class="text-lg font-semibold text-slate-900 mb-4">Discount Settings</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Discount Type</label>
                        <div class="flex items-center">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $promoCode->discount_type === 'percentage' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                {{ ucfirst($promoCode->discount_type) }}
                            </span>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Discount Value</label>
                        <div class="text-2xl font-bold text-orange-600">
                            @if($promoCode->discount_type === 'percentage')
                                {{ $promoCode->discount_value }}%
                            @else
                                LKR {{ number_format($promoCode->discount_value, 2) }}
                            @endif
                        </div>
                    </div>
                    @if($promoCode->minimum_amount)
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Minimum Order Amount</label>
                            <div class="text-lg font-semibold text-slate-900">
                                LKR {{ number_format($promoCode->minimum_amount, 2) }}
                            </div>
                        </div>
                    @endif
                    @if($promoCode->maximum_discount)
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Maximum Discount</label>
                            <div class="text-lg font-semibold text-slate-900">
                                LKR {{ number_format($promoCode->maximum_discount, 2) }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Usage & Validity --}}
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                <h3 class="text-lg font-semibold text-slate-900 mb-4">Usage & Validity</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Usage Statistics</label>
                        <div class="bg-slate-50 rounded-lg p-3 text-center">
                            <div class="text-2xl font-bold text-blue-600">
                                {{ $promoCode->used_count }}
                                @if($promoCode->usage_limit)
                                    <span class="text-lg text-slate-500">/ {{ $promoCode->usage_limit }}</span>
                                @endif
                            </div>
                            <div class="text-sm text-slate-600">
                                @if($promoCode->usage_limit)
                                    Times Used
                                @else
                                    Times Used (Unlimited)
                                @endif
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Valid From</label>
                        <div class="flex items-center text-slate-900">
                            <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            {{ $promoCode->valid_from->format('M d, Y') }}
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Valid Until</label>
                        <div class="flex items-center text-slate-900">
                            <svg class="w-5 h-5 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            {{ $promoCode->valid_until->format('M d, Y') }}
                        </div>
                    </div>
                </div>

                {{-- Progress Bar for Usage --}}
                @if($promoCode->usage_limit)
                    <div class="mt-4">
                        <div class="flex justify-between text-sm text-slate-600 mb-1">
                            <span>Usage Progress</span>
                            <span>{{ number_format(($promoCode->used_count / $promoCode->usage_limit) * 100, 1) }}%</span>
                        </div>
                        <div class="w-full bg-slate-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: {{ min(($promoCode->used_count / $promoCode->usage_limit) * 100, 100) }}%"></div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            {{-- Status Card --}}
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                <h3 class="text-lg font-semibold text-slate-900 mb-4">Status</h3>

                {{-- Current Status --}}
                <div class="mb-4">
                    @php
                        $statusColors = [
                            'active' => 'bg-green-100 text-green-800',
                            'inactive' => 'bg-red-100 text-red-800'
                        ];
                    @endphp
                    <span class="inline-flex items-center px-3 py-2 rounded-full text-sm font-medium {{ $statusColors[$promoCode->status] }}">
                        <div class="w-2 h-2 bg-current rounded-full mr-2"></div>
                        {{ ucfirst($promoCode->status) }}
                    </span>
                </div>

                {{-- Validity Status --}}
                <div class="border-t border-slate-200 pt-4">
                    <h4 class="text-sm font-medium text-slate-700 mb-2">Validity Status</h4>
                    @if($promoCode->isValid())
                        <div class="flex items-center text-green-600">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="font-medium">Currently Valid</span>
                        </div>
                        <p class="text-sm text-slate-600 mt-1">This promo code can be used by customers</p>
                    @else
                        <div class="flex items-center text-red-600">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="font-medium">
                                @if($promoCode->status === 'inactive')
                                    Inactive
                                @elseif(now()->lt($promoCode->valid_from))
                                    Not Yet Active
                                @elseif(now()->gt($promoCode->valid_until))
                                    Expired
                                @elseif($promoCode->usage_limit && $promoCode->used_count >= $promoCode->usage_limit)
                                    Usage Limit Reached
                                @else
                                    Invalid
                                @endif
                            </span>
                        </div>
                        <p class="text-sm text-slate-600 mt-1">This promo code cannot be used by customers</p>
                    @endif
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                <h3 class="text-lg font-semibold text-slate-900 mb-4">Quick Actions</h3>
                <div class="space-y-3">
                    <a href="{{ route('super_admin.promo_codes.edit', $promoCode->id) }}"
                       class="w-full inline-flex items-center justify-center px-4 py-2 bg-orange-100 text-orange-700 rounded-lg hover:bg-orange-200 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Promo Code
                    </a>

                    <form method="POST" action="{{ route('super_admin.promo_codes.delete', $promoCode->id) }}"
                          onsubmit="return confirm('Are you sure you want to delete this promo code? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Delete Promo Code
                        </button>
                    </form>
                </div>
            </div>

            {{-- Meta Information --}}
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                <h3 class="text-lg font-semibold text-slate-900 mb-4">Meta Information</h3>
                <div class="space-y-3 text-sm">
                    <div>
                        <span class="text-slate-600">Created:</span>
                        <span class="text-slate-900 font-medium">{{ $promoCode->created_at->format('M d, Y \a\t h:i A') }}</span>
                    </div>
                    <div>
                        <span class="text-slate-600">Last Updated:</span>
                        <span class="text-slate-900 font-medium">{{ $promoCode->updated_at->format('M d, Y \a\t h:i A') }}</span>
                    </div>
                    <div>
                        <span class="text-slate-600">Code ID:</span>
                        <span class="text-slate-900 font-medium">#{{ $promoCode->id }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
