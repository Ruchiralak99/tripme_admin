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
        <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">Add New Aircraft</h1>
      </div>
      <p class="text-slate-600 mt-1">Add a new aircraft to your fleet with detailed information and images.</p>
    </div>
  </div>
</div>

{{-- Error Messages --}}
@if ($errors->any())
    <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
        <ul class="list-disc list-inside space-y-1">
            @foreach ($errors->all() as $error)
                <li class="text-sm">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- Create Form --}}
<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
        <h3 class="text-lg font-semibold text-slate-900">Aircraft Details</h3>
    </div>

    <form method="POST" action="{{ route('super_admin.aircrafts.store') }}" class="p-6" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Basic Information --}}
            <div class="lg:col-span-2">
                <h4 class="text-lg font-medium text-slate-900 mb-4">Basic Information</h4>
            </div>

            {{-- Aircraft Name --}}
            <div>
                <label for="name" class="block text-sm font-medium text-slate-700 mb-2">
                    Aircraft Name <span class="text-red-500">*</span>
                </label>
                <input type="text"
                       id="name"
                       name="name"
                       value="{{ old('name') }}"
                       class="block w-full px-3 py-3 border border-slate-300 rounded-lg shadow-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                       placeholder="Enter aircraft name"
                       required>
            </div>

            {{-- Passenger Seats --}}
            <div>
                <label for="passenger_seats" class="block text-sm font-medium text-slate-700 mb-2">
                    Number of Passenger Seats <span class="text-red-500">*</span>
                </label>
                <input type="number"
                       id="passenger_seats"
                       name="passenger_seats"
                       value="{{ old('passenger_seats') }}"
                       min="1"
                       class="block w-full px-3 py-3 border border-slate-300 rounded-lg shadow-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                       placeholder="Number of passenger seats"
                       required>
            </div>

            {{-- Overview --}}
            <div class="lg:col-span-2">
                <label for="overview" class="block text-sm font-medium text-slate-700 mb-2">
                    Overview <span class="text-red-500">*</span>
                </label>
                <textarea id="overview"
                          name="overview"
                          rows="4"
                          class="block w-full px-3 py-3 border border-slate-300 rounded-lg shadow-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                          placeholder="Enter detailed overview of the aircraft"
                          required>{{ old('overview') }}</textarea>
            </div>

            {{-- Status --}}
            <div>
                <label for="status" class="block text-sm font-medium text-slate-700 mb-2">
                    Status <span class="text-red-500">*</span>
                </label>
                <select id="status"
                        name="status"
                        class="block w-full px-3 py-3 border border-slate-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                        required>
                    <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            {{-- Aircraft Images --}}
            <div class="lg:col-span-2 border-t border-slate-200 pt-6 mt-6">
                <h4 class="text-lg font-medium text-slate-900 mb-4">Aircraft Images</h4>
            </div>

            <div class="lg:col-span-2">
                <label for="images" class="block text-sm font-medium text-slate-700 mb-2">
                    Upload Multiple Images
                </label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-300 border-dashed rounded-lg hover:border-slate-400 transition-colors">
                    <div class="space-y-1 text-center w-full">
                        <svg class="mx-auto h-12 w-12 text-slate-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-slate-600">
                            <label for="images" class="relative cursor-pointer bg-white rounded-md font-medium text-primary-600 hover:text-primary-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary-500">
                                <span>Upload files</span>
                                <input id="images" name="images[]" type="file" multiple accept="image/*" class="sr-only" onchange="previewImages(event)">
                            </label>
                            <p class="pl-1">or drag and drop</p>
                        </div>
                        <p class="text-xs text-slate-500">PNG, JPG, GIF up to 10MB each</p>
                        <p class="text-xs text-slate-500">You can select multiple images at once</p>
                    </div>
                </div>

                {{-- Image Previews --}}
                <div id="image-previews" class="mt-4 hidden"></div>
            </div>

            {{-- Action Buttons --}}
            <div class="lg:col-span-2 flex items-center justify-end gap-4 pt-6 border-t border-slate-200">
                <a href="{{ route('super_admin.aircrafts') }}"
                   class="px-6 py-3 border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-colors">
                    Cancel
                </a>
                <button type="submit"
                        class="px-6 py-3 bg-primary-500 text-white rounded-lg hover:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-colors">
                    Create Aircraft
                </button>
            </div>
        </div>
    </form>
</div>

<script>
function previewImages(event) {
    const files = event.target.files;
    const previewContainer = document.getElementById('image-previews');

    if (files.length > 0) {
        previewContainer.innerHTML = '';
        previewContainer.className = 'mt-4 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4';

        Array.from(files).forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'relative group';
                div.innerHTML = `
                    <img src="${e.target.result}" alt="Preview ${index + 1}" class="w-full h-24 object-cover rounded-lg border border-slate-200">
                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-200 rounded-lg flex items-center justify-center">
                        <span class="text-white text-xs opacity-0 group-hover:opacity-100">${file.name}</span>
                    </div>
                `;
                previewContainer.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    } else {
        previewContainer.className = 'mt-4 hidden';
    }
}
</script>

@endsection
