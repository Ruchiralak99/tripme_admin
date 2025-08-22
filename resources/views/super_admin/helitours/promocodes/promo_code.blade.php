@extends('layouts.super_admin')

@section('content')

<div class="p-6">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Promo Codes</h1>
            <p class="text-slate-600 mt-1">Manage discount codes for your customers</p>
        </div>
        <a href="{{ route('super_admin.promo_codes.create') }}"
           class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-orange-500 to-red-500 text-white rounded-lg hover:from-orange-600 hover:to-red-600 transition-all duration-200 font-medium shadow-lg">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Add New Promo Code
        </a>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-400 rounded-lg p-4 mb-6">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <p class="text-green-700 font-medium">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    {{-- Promo Codes Grid --}}
    @if($promoCodes->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($promoCodes as $promoCode)
                <div class="bg-white rounded-lg shadow-sm border border-slate-200 hover:shadow-lg transition-shadow duration-200">
                    {{-- Card Header --}}
                    <div class="p-6 border-b border-slate-200">
                        <div class="flex items-start justify-between">
                            <div>
                                <h3 class="text-lg font-bold text-slate-900 font-mono">{{ $promoCode->code }}</h3>
                                <p class="text-sm text-slate-600 mt-1">{{ Str::limit($promoCode->description, 60) }}</p>
                                @if($promoCode->author)
                                    <p class="text-xs text-slate-500 mt-1">
                                        <span class="inline-flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                            by {{ $promoCode->author }}
                                        </span>
                                    </p>
                                @endif
                            </div>
                            <div class="text-right">
                                @php
                                    $statusColors = [
                                        'active' => 'bg-green-100 text-green-800',
                                        'inactive' => 'bg-red-100 text-red-800'
                                    ];
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$promoCode->status] }}">
                                    {{ ucfirst($promoCode->status) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Card Body --}}
                    <div class="p-6">
                        {{-- Discount Info --}}
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div class="text-center bg-slate-50 rounded-lg p-3">
                                <div class="text-2xl font-bold text-orange-600">
                                    @if($promoCode->discount_type === 'percentage')
                                        {{ $promoCode->discount_value }}%
                                    @else
                                        LKR {{ number_format($promoCode->discount_value, 2) }}
                                    @endif
                                </div>
                                <div class="text-xs text-slate-600 uppercase tracking-wide">
                                    {{ ucfirst($promoCode->discount_type) }} Discount
                                </div>
                            </div>
                            <div class="text-center bg-slate-50 rounded-lg p-3">
                                <div class="text-2xl font-bold text-blue-600">
                                    {{ $promoCode->used_count }}
                                    @if($promoCode->usage_limit)
                                        / {{ $promoCode->usage_limit }}
                                    @endif
                                </div>
                                <div class="text-xs text-slate-600 uppercase tracking-wide">Used</div>
                            </div>
                        </div>

                        {{-- Additional Info --}}
                        <div class="space-y-2 text-sm text-slate-600">
                            @if($promoCode->minimum_amount)
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                    </svg>
                                    Min. order: LKR {{ number_format($promoCode->minimum_amount, 2) }}
                                </div>
                            @endif
                            @if($promoCode->maximum_discount)
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Max. discount: LKR {{ number_format($promoCode->maximum_discount, 2) }}
                                </div>
                            @endif
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Valid: {{ $promoCode->valid_from->format('M d') }} - {{ $promoCode->valid_until->format('M d, Y') }}
                            </div>
                        </div>

                        {{-- Validity Indicator --}}
                        <div class="mt-4">
                            @if($promoCode->isValid())
                                <div class="flex items-center text-green-600">
                                    <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                                    <span class="text-sm font-medium">Currently Valid</span>
                                </div>
                            @else
                                <div class="flex items-center text-red-600">
                                    <div class="w-2 h-2 bg-red-500 rounded-full mr-2"></div>
                                    <span class="text-sm font-medium">
                                        @if($promoCode->status === 'inactive')
                                            Inactive
                                        @elseif(now()->lt($promoCode->valid_from))
                                            Not yet active
                                        @elseif(now()->gt($promoCode->valid_until))
                                            Expired
                                        @elseif($promoCode->usage_limit && $promoCode->used_count >= $promoCode->usage_limit)
                                            Usage limit reached
                                        @else
                                            Invalid
                                        @endif
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Card Actions --}}
                    <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('super_admin.promo_codes.view', $promoCode->id) }}"
                               class="inline-flex items-center px-3 py-1.5 bg-blue-100 text-blue-700 rounded-md hover:bg-blue-200 transition-colors text-sm">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                View
                            </a>
                            <a href="{{ route('super_admin.promo_codes.edit', $promoCode->id) }}"
                               class="inline-flex items-center px-3 py-1.5 bg-orange-100 text-orange-700 rounded-md hover:bg-orange-200 transition-colors text-sm">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit
                            </a>
                        </div>
                        <form method="POST" action="{{ route('super_admin.promo_codes.delete', $promoCode->id) }}"
                              class="inline" onsubmit="return confirm('Are you sure you want to delete this promo code?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-100 text-red-700 rounded-md hover:bg-red-200 transition-colors text-sm">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($promoCodes->hasPages())
            <div class="mt-8">
                {{ $promoCodes->links() }}
            </div>
        @endif
    @else
        {{-- Empty State --}}
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.99 1.99 0 013 12V7a2 2 0 012-2z"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-slate-900">No promo codes found</h3>
            <p class="mt-1 text-sm text-slate-500">Get started by creating your first promo code.</p>
            <div class="mt-6">
                <a href="{{ route('super_admin.promo_codes.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add Your First Promo Code
                </a>
            </div>
        </div>
    @endif
</div>

@endsection
