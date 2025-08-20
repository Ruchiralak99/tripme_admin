{{-- Booking Modal (Complete Rebuild for Perfect Scrolling) --}}
<div id="bookingModal"
     class="fixed inset-0 z-[60] hidden"
     aria-hidden="true"
     role="dialog"
     aria-modal="true">
  {{-- Overlay --}}
  <div id="bookingOverlay" class="absolute inset-0 bg-black/60 opacity-0 transition-opacity duration-300"></div>

  {{-- Modal Container - Properly Centered and Scrollable --}}
  <div class="relative z-10 w-full h-full overflow-y-auto">
    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
      {{-- Dialog --}}
      <div id="bookingDialog"
           class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all w-full max-w-4xl opacity-0 scale-95 duration-300 ease-out">

        {{-- Header - Always Visible --}}
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 border-b border-gray-200">
          <div class="flex items-center justify-between">
            <div>
              <h3 class="text-lg font-medium leading-6 text-gray-900 sm:text-xl">Book Air Taxi Service</h3>
              <p class="mt-1 text-sm text-gray-500">Fill in the details below to book your helicopter experience.</p>
            </div>
            <button type="button" id="closeBookingBtn" class="ml-4 text-gray-400 hover:text-gray-600 transition-colors" aria-label="Close">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
              </svg>
            </button>
          </div>
        </div>

        {{-- Scrollable Form Content --}}
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

        {{-- Footer - Always Visible --}}
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
