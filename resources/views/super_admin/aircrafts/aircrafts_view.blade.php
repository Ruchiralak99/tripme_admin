@extends('layouts.super_admin')

@section('content')

{{-- Page Header --}}
<div class="mb-8">
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
      <div class="flex items-center gap-3 mb-2">
        <a href="{{ route('super_admin.aircrafts') }}" class="text-slate-400 hover:text-slate-600 transition-colors">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
          </svg>
        </a>
        <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">{{ $aircraft->name }}</h1>
      </div>
      <p class="text-slate-600 mt-1">Detailed view of aircraft information and specifications.</p>
    </div>
    <div class="flex items-center gap-3">
      <a href="{{ route('super_admin.aircrafts.edit', $aircraft->id) }}" class="inline-flex items-center px-4 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-colors duration-200 font-medium">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
        </svg>
        Edit Aircraft
      </a>
    </div>
  </div>
</div>

{{-- Aircraft Details Card --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
  {{-- Main Content --}}
  <div class="lg:col-span-2">
    {{-- Aircraft Information --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden mb-6">
      <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
        <h3 class="text-lg font-semibold text-slate-900">Aircraft Information</h3>
      </div>
      <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Aircraft Name</label>
            <p class="text-lg font-semibold text-slate-900">{{ $aircraft->name }}</p>
          </div>
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Passenger Capacity</label>
            <p class="text-lg font-semibold text-slate-900">{{ $aircraft->passenger_seats }} passengers</p>
          </div>
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Status</label>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $aircraft->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
              <span class="w-2 h-2 rounded-full {{ $aircraft->status === 'active' ? 'bg-green-400' : 'bg-red-400' }} mr-2"></span>
              {{ ucfirst($aircraft->status) }}
            </span>
          </div>
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Created</label>
            <p class="text-lg font-semibold text-slate-900">{{ $aircraft->created_at->format('M d, Y') }}</p>
          </div>
        </div>

        <div class="mt-6">
          <label class="block text-sm font-medium text-slate-700 mb-2">Overview</label>
          <div class="bg-slate-50 rounded-lg p-4">
            <p class="text-slate-700 leading-relaxed">{{ $aircraft->overview }}</p>
          </div>
        </div>
      </div>
    </div>

    {{-- Aircraft Images --}}
    @if($aircraft->images && count($aircraft->images) > 0)
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
      <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
        <h3 class="text-lg font-semibold text-slate-900">Aircraft Images ({{ count($aircraft->images) }})</h3>
      </div>
      <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          @foreach($aircraft->images as $index => $image)
          <div class="relative group cursor-pointer" onclick="openImageModal('{{ asset('storage/' . $image) }}', '{{ $aircraft->name }} - Image {{ $index + 1 }}')">
            <img src="{{ asset('storage/' . $image) }}"
                 alt="{{ $aircraft->name }} - Image {{ $index + 1 }}"
                 class="w-full h-48 object-cover rounded-lg border border-slate-200 transition-transform duration-200 group-hover:scale-105">
            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-200 rounded-lg flex items-center justify-center">
              <svg class="w-8 h-8 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path>
              </svg>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
    @endif
  </div>

  {{-- Sidebar --}}
  <div class="lg:col-span-1">
    {{-- Quick Stats --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden mb-6">
      <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
        <h3 class="text-lg font-semibold text-slate-900">Quick Stats</h3>
      </div>
      <div class="p-6 space-y-4">
        <div class="flex items-center justify-between py-3 border-b border-slate-100 last:border-b-0">
          <div class="flex items-center">
            <div class="p-2 bg-blue-100 rounded-lg mr-3">
              <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
              </svg>
            </div>
            <span class="text-sm font-medium text-slate-700">Passengers</span>
          </div>
          <span class="text-lg font-bold text-slate-900">{{ $aircraft->passenger_seats }}</span>
        </div>

        <div class="flex items-center justify-between py-3 border-b border-slate-100 last:border-b-0">
          <div class="flex items-center">
            <div class="p-2 bg-green-100 rounded-lg mr-3">
              <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
              </svg>
            </div>
            <span class="text-sm font-medium text-slate-700">Images</span>
          </div>
          <span class="text-lg font-bold text-slate-900">{{ $aircraft->images ? count($aircraft->images) : 0 }}</span>
        </div>

        <div class="flex items-center justify-between py-3 border-b border-slate-100 last:border-b-0">
          <div class="flex items-center">
            <div class="p-2 bg-purple-100 rounded-lg mr-3">
              <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
            </div>
            <span class="text-sm font-medium text-slate-700">Last Updated</span>
          </div>
          <span class="text-sm font-bold text-slate-900">{{ $aircraft->updated_at->diffForHumans() }}</span>
        </div>
      </div>
    </div>

    {{-- Actions --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
      <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
        <h3 class="text-lg font-semibold text-slate-900">Actions</h3>
      </div>
      <div class="p-6 space-y-3">
        <a href="{{ route('super_admin.aircrafts.edit', $aircraft->id) }}"
           class="w-full inline-flex items-center justify-center px-4 py-2 bg-primary-500 text-white rounded-lg hover:bg-primary-600 transition-colors duration-200">
          <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
          </svg>
          Edit Aircraft
        </a>

        <form method="POST" action="{{ route('super_admin.aircrafts.delete', $aircraft->id) }}"
              onsubmit="return confirm('Are you sure you want to delete this aircraft? This action cannot be undone.')">
          @csrf
          @method('DELETE')
          <button type="submit"
                  class="w-full inline-flex items-center justify-center px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors duration-200">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
            </svg>
            Delete Aircraft
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

{{-- Image Modal --}}
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50" style="display: none;">
  <div class="relative max-w-4xl max-h-full p-4">
    <button onclick="closeImageModal()" class="absolute top-4 right-4 text-white hover:text-gray-300 z-10">
      <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
      </svg>
    </button>
    <img id="modalImage" src="" alt="" class="max-w-full max-h-full object-contain rounded-lg">
    <p id="modalTitle" class="text-white text-center mt-4 font-medium"></p>
  </div>
</div>

<script>
function openImageModal(src, title) {
  document.getElementById('modalImage').src = src;
  document.getElementById('modalTitle').textContent = title;
  document.getElementById('imageModal').style.display = 'flex';
  document.body.style.overflow = 'hidden';
}

function closeImageModal() {
  document.getElementById('imageModal').style.display = 'none';
  document.body.style.overflow = 'auto';
}

// Close modal when clicking outside the image
document.getElementById('imageModal').addEventListener('click', function(e) {
  if (e.target === this) {
    closeImageModal();
  }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape' && document.getElementById('imageModal').style.display === 'flex') {
    closeImageModal();
  }
});
</script>

@endsection
