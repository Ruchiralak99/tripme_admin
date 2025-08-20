{{-- resources/views/super_admin/packages/air_taxi/air_taxi.blade.php --}}
@extends('layouts.super_admin')

@section('content')

<div class="min-h-screen bg-gray-50">
  {{-- Header Section --}}
  <div class="bg-white shadow-sm border-b">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-16">
        <div class="flex items-center space-x-4">
          <a href="{{ route('super_admin.packages') }}"
             class="flex items-center text-gray-500 hover:text-gray-700 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Packages
          </a>
          <div class="h-5 border-l border-gray-300"></div>
          <h1 class="text-xl font-semibold text-gray-900">Air Taxi Services</h1>
        </div>
        <button type="button" id="openBookingBtn"
                class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-orange-500 to-red-500 text-white rounded-lg hover:from-orange-600 hover:to-red-600 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition-all duration-200 font-medium shadow-lg">
          <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
          </svg>
          Book Now
        </button>
      </div>
    </div>
  </div>

  {{-- Success Message --}}
  @if(session('success'))
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6">
    <div class="bg-green-50 border-l-4 border-green-400 rounded-lg p-4 mb-6">
      <div class="flex items-center">
        <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
        <p class="text-green-700 font-medium">{{ session('success') }}</p>
      </div>
    </div>
  </div>
  @endif

  {{-- Hero Section --}}
  <div class="relative bg-gradient-to-br from-blue-900 via-blue-800 to-indigo-900 overflow-hidden">
    <div class="absolute inset-0">
      <img src="https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?w=1920&h=800&fit=crop&crop=center"
           alt="Helicopter"
           class="w-full h-full object-cover opacity-30">
      <div class="absolute inset-0 bg-gradient-to-r from-blue-900/80 to-indigo-900/60"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
        <div class="text-white">
          <h2 class="text-4xl lg:text-5xl font-bold mb-6 leading-tight">
            Experience the Sky Like
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-red-400">Never Before</span>
          </h2>
          <p class="text-xl text-blue-100 mb-8 leading-relaxed">
            Our premium helicopter services offer unparalleled views and luxury transportation across stunning landscapes.
            From city tours to airport transfers, we make every journey extraordinary.
          </p>

          <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
            <div class="flex items-center bg-white/10 backdrop-blur-sm rounded-lg p-4">
              <div class="flex-shrink-0 w-10 h-10 bg-green-500 rounded-full flex items-center justify-center mr-3">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
              </div>
              <span class="font-medium">Certified Pilots</span>
            </div>
            <div class="flex items-center bg-white/10 backdrop-blur-sm rounded-lg p-4">
              <div class="flex-shrink-0 w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center mr-3">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
              </div>
              <span class="font-medium">Modern Fleet</span>
            </div>
            <div class="flex items-center bg-white/10 backdrop-blur-sm rounded-lg p-4">
              <div class="flex-shrink-0 w-10 h-10 bg-orange-500 rounded-full flex items-center justify-center mr-3">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
              </div>
              <span class="font-medium">Safety First</span>
            </div>
          </div>

          <button type="button" data-open-booking
                  class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-orange-500 to-red-500 text-white rounded-xl hover:from-orange-600 hover:to-red-600 focus:outline-none focus:ring-4 focus:ring-orange-500/50 transition-all duration-300 font-semibold text-lg shadow-2xl transform hover:scale-105">
            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            Book Your Flight Today
          </button>
        </div>

        <div class="relative lg:block hidden">
          <div class="absolute -inset-4 bg-gradient-to-r from-orange-500 to-red-500 rounded-3xl blur opacity-30"></div>
          <img src="https://images.unsplash.com/photo-1570710891163-6d3b5c47248b?w=600&h=400&fit=crop"
               alt="Luxury Helicopter"
               class="relative rounded-2xl shadow-2xl w-full h-80 object-cover">
        </div>
      </div>
    </div>
  </div>
      </div>
    </div>
  </div>
</div>


  {{-- Services & Features Section --}}


  {{-- Services Types Section --}}




{{-- Booking Modal (Clean & Simple) --}}
<div id="bookingModal"
     class="fixed inset-0 z-[60] hidden"
     aria-hidden="true"
     role="dialog"
     aria-modal="true">
  {{-- Overlay --}}
  <div id="bookingOverlay" class="absolute inset-0 bg-black/60 opacity-0 transition-opacity duration-300"></div>

  {{-- Modal Container --}}
  <div class="relative z-10 w-full h-full overflow-y-auto">
    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
      {{-- Dialog --}}
      <div id="bookingDialog"
           class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all w-full max-w-4xl opacity-0 scale-95 duration-300 ease-out">

        {{-- Header --}}
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 border-b border-gray-200">
          <div class="flex items-center justify-between">
            <div>
              <h3 class="text-lg font-medium leading-6 text-gray-900 sm:text-xl">Book Air Taxi Service</h3>
              <p class="mt-1 text-sm text-gray-500">Fill in the details below to book your helicopter experience.</p>
              <p class="mt-1 text-sm font-medium text-red-500">You must enter passenger details equal to the available seats — Fewer passengers cannot book a Air Taxi</p>
            </div>
            <button type="button" id="closeBookingBtn" class="ml-4 text-gray-400 hover:text-gray-600 transition-colors" aria-label="Close">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
              </svg>
            </button>
          </div>
        </div>

        {{-- Form Content --}}
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 max-h-[60vh] overflow-y-auto">
          <form id="bookingForm" action="{{ route('super_admin.packages.air_taxi.book') }}" method="POST">
            @csrf

            {{-- Basic Information --}}
            <div class="mb-6">
              <h4 class="text-base font-semibold text-gray-900 mb-4">Basic Information</h4>
              <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                  <label for="full_name" class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                  <input type="text" id="full_name" name="full_name" required
                         class="block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm"
                         placeholder="Enter your full name">
                </div>
                <div>
                  <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-2">Phone Number *</label>
                  <input type="tel" id="phone_number" name="phone_number" required
                         class="block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm"
                         placeholder="Enter your phone number">
                </div>
              </div>
            </div>

            {{-- Aircraft Selection --}}
            <div class="mb-6">
              <h4 class="text-base font-semibold text-gray-900 mb-4">Aircraft Selection</h4>
              <div>
                <label for="aircraft_id" class="block text-sm font-medium text-gray-700 mb-2">Select Aircraft *</label>
                <select id="aircraft_id" name="aircraft_id" required onchange="updatePassengerFields()"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm">
                  <option value="">Choose an aircraft...</option>
                  @foreach($aircrafts as $aircraft)
                  <option value="{{ $aircraft->id }}" data-seats="{{ (int) $aircraft->passenger_seats }}">
                    {{ $aircraft->name }} ({{ (int) $aircraft->passenger_seats }} seats available)
                  </option>
                  @endforeach
                </select>
              </div>
            </div>

            {{-- Booking Details --}}
            <div class="mb-6">
              <h4 class="text-base font-semibold text-gray-900 mb-4">Booking Details</h4>
              <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <div class="sm:col-span-1">
                  <label for="tour_type" class="block text-sm font-medium text-gray-700 mb-2">Tour Type (Reason) *</label>
                  <input type="text" id="tour_type" name="tour_type" required
                         placeholder="e.g., City Tour, Airport Transfer"
                         class="block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm">
                  <p class="mt-1 text-xs text-gray-500">Describe the purpose of your helicopter trip</p>
                </div>
                <div>
                  <label for="start_point" class="block text-sm font-medium text-gray-700 mb-2">Start Point *</label>
                  <input type="text" id="start_point" name="start_point" required
                         placeholder="e.g., Colombo Airport, Hotel, etc."
                         class="block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm">
                  <p class="mt-1 text-xs text-gray-500">Where your journey begins</p>
                </div>
                <div>
                  <label for="end_point" class="block text-sm font-medium text-gray-700 mb-2">End Point *</label>
                  <input type="text" id="end_point" name="end_point" required
                         placeholder="e.g., Kandy, Galle, Hotel, etc."
                         class="block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm">
                  <p class="mt-1 text-xs text-gray-500">Your destination</p>
                </div>
              </div>

              {{-- Date and Time Row --}}
              <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 mt-4">
                <div>
                  <label for="booking_date" class="block text-sm font-medium text-gray-700 mb-2">Date *</label>
                  <input type="date" id="booking_date" name="booking_date" required
                         min="{{ now()->addDays(3)->format('Y-m-d') }}"
                         class="block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm">
                  <p class="mt-1 text-xs text-gray-500">Minimum 3 days advance booking required</p>
                </div>
                <div>
                  <label for="booking_time" class="block text-sm font-medium text-gray-700 mb-2">Time *</label>
                  <input type="time" id="booking_time" name="booking_time" required
                         class="block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm">
                </div>
              </div>
            </div>

            {{-- Passenger Information --}}
            <div id="passengerSection" class="mb-6 hidden">
              <h4 class="text-base font-semibold text-gray-900 mb-4">Passenger Information</h4>
              <div id="passengerFields" class="space-y-4"></div>
            </div>
          </form>
        </div>

        {{-- Footer --}}
        <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
          <button type="submit" form="bookingForm"
                  class="inline-flex w-full justify-center rounded-md border border-transparent bg-orange-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm">
            Book Air Taxi
          </button>
          <button type="button" id="cancelBookingBtn"
                  class="mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
            Cancel
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Close the page container --}}
</div>

{{-- Enhanced JavaScript for Beautiful Modal --}}
<script>
(function () {
  // Cache elements safely
  const modal      = document.getElementById('bookingModal');
  const overlay    = document.getElementById('bookingOverlay');
  const dialog     = document.getElementById('bookingDialog');
  const openBtn    = document.getElementById('openBookingBtn');
  const closeBtn   = document.getElementById('closeBookingBtn');
  const cancelBtn  = document.getElementById('cancelBookingBtn');
  const form       = document.getElementById('bookingForm');
  const aircraftEl = document.getElementById('aircraft_id');
  const paxSec     = document.getElementById('passengerSection');
  const paxFields  = document.getElementById('passengerFields');

  // ---- Guard: if required nodes are missing, don't bind anything
  if (!modal || !overlay || !dialog || !form) return;

  // Enable all booking buttons (global + specific)
  document.querySelectorAll('[data-open-booking], #openBookingBtn').forEach((btn) => {
    btn?.addEventListener('click', openModal);
  });

  closeBtn?.addEventListener('click', closeModal);
  cancelBtn?.addEventListener('click', closeModal);
  overlay?.addEventListener('click', closeModal);

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && !modal.classList.contains('hidden')) closeModal();
  });

  aircraftEl?.addEventListener('change', updatePassengerFields);

  function openModal() {
    modal.classList.remove('hidden');
    modal.setAttribute('aria-hidden', 'false');

    // animate in
    requestAnimationFrame(() => {
      overlay.classList.remove('opacity-0');
      dialog.classList.remove('opacity-0', 'scale-95');
    });

    // lock scroll
    document.documentElement.style.overflow = 'hidden';
    document.body.style.overflow = 'hidden';

    // focus first input
    setTimeout(() => {
      document.getElementById('full_name')?.focus();
    }, 300);
  }

  function closeModal() {
    // animate out
    overlay.classList.add('opacity-0');
    dialog.classList.add('opacity-0', 'scale-95');

    // hide after animation
    setTimeout(() => {
      modal.classList.add('hidden');
      modal.setAttribute('aria-hidden', 'true');
      form.reset();
      paxSec?.classList.add('hidden');
      if (paxFields) paxFields.innerHTML = '';

      // unlock scroll
      document.documentElement.style.overflow = '';
      document.body.style.overflow = '';
    }, 300);
  }

  function updatePassengerFields() {
    if (!aircraftEl || !paxSec || !paxFields) return;

    const selectedOption = aircraftEl.options[aircraftEl.selectedIndex];
    const seats = selectedOption?.dataset?.seats ? parseInt(selectedOption.dataset.seats, 10) : 0;

    paxFields.innerHTML = '';

    if (Number.isFinite(seats) && seats > 0) {
      paxSec.classList.remove('hidden');

      for (let i = 1; i <= seats; i++) {
        const passengerDiv = document.createElement('div');
        passengerDiv.className =
          'bg-white rounded-xl p-6 border-2 border-blue-100 hover:border-blue-200 shadow-lg hover:shadow-xl transition-all duration-200';

        passengerDiv.innerHTML = `
          <div class="flex items-center mb-4">
            <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-500 text-white rounded-full flex items-center justify-center font-bold text-sm mr-3">
              ${i}
            </div>
            <h5 class="text-lg font-semibold text-gray-900">Passenger ${i} Details</h5>
          </div>
          <div class="space-y-4">
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">
                <svg class="w-4 h-4 inline mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                Full Name *
              </label>
              <input type="text" name="passenger_names[]" required
                     class="block w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-0 transition-colors duration-200 text-gray-900 placeholder-gray-400"
                     placeholder="Enter passenger full name">
            </div>
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">
                <svg class="w-4 h-4 inline mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                NIC Number *
              </label>
              <input type="text" name="passenger_nics[]" required
                     class="block w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-0 transition-colors duration-200 text-gray-900 placeholder-gray-400"
                     placeholder="Enter NIC number (e.g., 200012345678)"
                     pattern="[0-9]{9}[vVxX]|[0-9]{12}"
                     title="Enter valid NIC number">
              <p class="text-xs text-gray-500 mt-1">
                <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Old format: 123456789V or New format: 200012345678
              </p>
            </div>
          </div>
        `;
        paxFields.appendChild(passengerDiv);
      }
    } else {
      paxSec.classList.add('hidden');
    }
  }

  // Form enhancement with passenger data processing
  form.addEventListener('submit', function (e) {
    e.preventDefault();

    // Collect flat arrays
    const passengerNames = Array.from(form.querySelectorAll('input[name="passenger_names[]"]'));
    const passengerNics  = Array.from(form.querySelectorAll('input[name="passenger_nics[]"]'));

    // Build structured passengers array
    const passengers = passengerNames.map((nameInput, index) => ({
      name: nameInput.value?.trim() || '',
      nic:  passengerNics[index]?.value?.trim() || '',
    }));

    // Remove previously added hidden inputs (if any)
    form.querySelectorAll('input[name^="passengers["]').forEach((el) => el.remove());

    // Append hidden structured inputs
    passengers.forEach((p, i) => {
      const nameHidden = document.createElement('input');
      nameHidden.type = 'hidden';
      nameHidden.name = `passengers[${i}][name]`;
      nameHidden.value = p.name;
      form.appendChild(nameHidden);

      const nicHidden = document.createElement('input');
      nicHidden.type = 'hidden';
      nicHidden.name = `passengers[${i}][nic]`;
      nicHidden.value = p.nic;
      form.appendChild(nicHidden);
    });

    // Loading state
    const submitBtn = form.querySelector('button[type="submit"]');
    if (submitBtn) {
      submitBtn.disabled = true;
      submitBtn.innerHTML = `
        <svg class="animate-spin w-5 h-5 mr-2 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
        </svg>
        Processing Booking...
      `;
    }

    // Submit the form
    form.submit();
  });

  // Focus ring enhancement (safe)
  document.querySelectorAll('input, select, textarea').forEach((input) => {
    input.addEventListener('focus', function () {
      this.parentElement?.classList.add('ring-2', 'ring-blue-200');
    });
    input.addEventListener('blur', function () {
      this.parentElement?.classList.remove('ring-2', 'ring-blue-200');
    });
  });
})();
</script>


@endsection
