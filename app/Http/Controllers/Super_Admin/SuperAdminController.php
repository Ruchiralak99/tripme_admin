<?php

namespace App\Http\Controllers\Super_Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Ride;
use App\Models\RideCity;
use App\Models\RideBooking;
use App\Models\Payment;
use App\Models\PromoCode;
use App\Models\Aircraft;
use App\Models\AirTaxiBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;

class SuperAdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();
        $activeUsers = User::where('is_active', true)->count();
        $vendorUsers = User::where('role', 'vendor')->count();
        $affiliateUsers = User::where('role', 'affiliate')->count();

        return view('super_admin.index', compact('totalUsers', 'activeUsers', 'vendorUsers', 'affiliateUsers'));
    }

    public function userManagement(Request $request)
    {
        $query = User::query();

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('business_name', 'like', "%{$search}%");
            });
        }

        // Filter by role
        if ($request->has('role') && $request->role != '') {
            $query->where('role', $request->role);
        }

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('is_active', $request->status == 'active');
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('super_admin.user_management.user_management', compact('users'));
    }

    // Show user details
    public function userShow($id)
    {
        $user = User::findOrFail($id);
        return view('super_admin.user_management.user_show', compact('user'));
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('super_admin.user_management.user_edit', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $id,
            'business_name' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:20',
            'role' => 'required|in:super_admin,admin,affiliate,payment_officer,booking_officer,vendor,user',
            'vendor_type' => 'required_if:role,vendor|nullable|in:Hotel Partner,Activity Partner,Travel Guide',
            'is_active' => 'required|boolean',
            'password' => 'nullable|string|min:8',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $userData = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'business_name' => $request->business_name,
            'contact_number' => $request->contact_number,
            'role' => $request->role,
            'vendor_type' => $request->role === 'vendor' ? $request->vendor_type : null,
            'is_active' => $request->is_active,
        ];

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData);

        return redirect()->route('super_admin.user_management.user_management')
            ->with('success', 'User updated successfully!');
    }

    public function createUser()
    {
        return view('super_admin.user_management.user_create');
    }

    public function storeUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'business_name' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:20',
            'role' => 'required|in:super_admin,admin,affiliate,payment_officer,booking_officer,vendor,user',
            'vendor_type' => 'required_if:role,vendor|nullable|in:Hotel Partner,Activity Partner,Travel Guide',
            'password' => ['required', 'string', Password::min(8)],
            'is_active' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'business_name' => $request->business_name,
            'contact_number' => $request->contact_number,
            'role' => $request->role,
            'vendor_type' => $request->role === 'vendor' ? $request->vendor_type : null,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('super_admin.user_management.user_management')
            ->with('success', 'User created successfully!');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        // Prevent deleting current user
        if ($user->id === Auth::id()) {
            return redirect()->back()
                ->with('error', 'You cannot delete your own account!');
        }

        $user->delete();

        return redirect()->route('super_admin.user_management.user_management')
            ->with('success', 'User deleted successfully!');
    }

    public function toggleUserStatus($id)
    {
        $user = User::findOrFail($id);

        // Prevent deactivating current user
        if ($user->id === Auth::id()) {
            return redirect()->back()
                ->with('error', 'You cannot deactivate your own account!');
        }

        $user->update(['is_active' => !$user->is_active]);

        $status = $user->is_active ? 'activated' : 'deactivated';
        return redirect()->back()
            ->with('success', "User {$status} successfully!");
    }

    public function showPackages()
    {
        return view('super_admin.packages.packages');
    }

    // Air Taxi Package Management
    public function airTaxi()
    {
        // Get all aircrafts for booking form
        $aircrafts = Aircraft::where('status', 'active')->get();

        // Dummy data for Air Taxi with real images
        $airTaxiServices = [
            [
                'id' => 1,
                'name' => 'Helicopter City Tour',
                'description' => 'Experience breathtaking aerial views of the city with our premium helicopter tours. Perfect for sightseeing and photography.',
                'price' => 450,
                'duration' => '30 minutes',
                'image' => 'https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?w=400&h=250&fit=crop'
            ],
            [
                'id' => 2,
                'name' => 'Airport VIP Transfer',
                'description' => 'Skip the traffic with our luxury helicopter transfer service. Fast, comfortable, and exclusive transportation.',
                'price' => 850,
                'duration' => '15 minutes',
                'image' => 'https://images.unsplash.com/photo-1540962351504-03099e0a754b?w=400&h=250&fit=crop'
            ],
            [
                'id' => 3,
                'name' => 'Scenic Mountain Flight',
                'description' => 'Discover stunning mountain landscapes and remote destinations only accessible by helicopter.',
                'price' => 1200,
                'duration' => '45 minutes',
                'image' => 'https://images.unsplash.com/photo-1469474968028-56623f02e42e?w=400&h=250&fit=crop'
            ],
            [
                'id' => 4,
                'name' => 'Private Charter Service',
                'description' => 'Exclusive helicopter charter for business trips, special events, or luxury travel experiences.',
                'price' => 2500,
                'duration' => '2-4 hours',
                'image' => 'https://images.unsplash.com/photo-1568515023450-21dffc50d045?w=400&h=250&fit=crop'
            ]
        ];

        return view('super_admin.packages.air_taxi.air_taxi', compact('airTaxiServices', 'aircrafts'));
    }

    public function storeAirTaxiBooking(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'aircraft_id' => 'required|exists:aircrafts,id',
            'tour_type' => 'required|string|max:255',
            'start_point' => 'required|string|max:255',
            'end_point' => 'required|string|max:255',
            'booking_date' => 'required|date|after:' . now()->addDays(3)->format('Y-m-d'),
            'booking_time' => 'required',
            'passengers' => 'required|array|min:1',
            'passengers.*.name' => 'required|string|max:255',
            'passengers.*.nic' => 'required|string|max:20',
        ]);

        $booking = AirTaxiBooking::create([
            'user_id' => Auth::id(),
            'aircraft_id' => $request->aircraft_id,
            'full_name' => $request->full_name,
            'phone_number' => $request->phone_number,
            'tour_type' => $request->tour_type,
            'start_point' => $request->start_point,
            'end_point' => $request->end_point,
            'booking_date' => $request->booking_date,
            'booking_time' => $request->booking_time,
            'passengers' => $request->passengers,
            'status' => 'pending'
        ]);

        return redirect()->back()->with('success', 'Air taxi booking has been created successfully!');
    }

    public function getAircraftDetails($id)
    {
        $aircraft = Aircraft::findOrFail($id);
        return response()->json([
            'name' => $aircraft->name,
            'passenger_seats' => $aircraft->passenger_seats
        ]);
    }

    // Rides Package Management
    public function rides()
    {
        $ridesCategories = Ride::orderBy('created_at', 'desc')->get();
        return view('super_admin.packages.rides.rides', compact('ridesCategories'));
    }

    // Create new ride category
    public function createRideCategory()
    {
        return view('super_admin.packages.rides.rides_create');
    }

    // Store ride category
    public function storeRideCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price_lkr' => 'required|numeric|min:0',
            'tax_percentage' => 'required|numeric|min:0|max:100',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'duration' => 'nullable|string|max:100',
            'passenger_capacity' => 'nullable|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,inactive'
        ]);

        // Calculate regular value
        $price = $validated['price_lkr'];
        $taxAmount = ($price * $validated['tax_percentage']) / 100;
        $regularValue = $price + $taxAmount;

        // Apply discount if provided
        if (!empty($validated['discount_percentage'])) {
            $discountAmount = ($regularValue * $validated['discount_percentage']) / 100;
            $regularValue = $regularValue - $discountAmount;
        }

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('rides', 'public');
        }

        // Create the ride
        Ride::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price_lkr' => $validated['price_lkr'],
            'tax_percentage' => $validated['tax_percentage'],
            'discount_percentage' => $validated['discount_percentage'],
            'regular_value' => $regularValue,
            'duration' => $validated['duration'],
            'passenger_capacity' => $validated['passenger_capacity'],
            'image_path' => $imagePath,
            'status' => $validated['status']
        ]);

        return redirect()->route('super_admin.packages.rides.rides')
                         ->with('success', 'Ride category created successfully!');
    }

    // Edit ride category
    public function editRideCategory($id)
    {
        $ride = Ride::findOrFail($id);
        return view('super_admin.packages.rides.rides_edit', compact('ride'));
    }

    // Update ride category
    public function updateRideCategory(Request $request, $id)
    {
        $ride = Ride::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price_lkr' => 'required|numeric|min:0',
            'tax_percentage' => 'required|numeric|min:0|max:100',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'duration' => 'nullable|string|max:100',
            'passenger_capacity' => 'nullable|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,inactive'
        ]);

        // Calculate regular value
        $price = $validated['price_lkr'];
        $taxAmount = ($price * $validated['tax_percentage']) / 100;
        $regularValue = $price + $taxAmount;

        // Apply discount if provided
        if (!empty($validated['discount_percentage'])) {
            $discountAmount = ($regularValue * $validated['discount_percentage']) / 100;
            $regularValue = $regularValue - $discountAmount;
        }

        // Handle image upload
        $imagePath = $ride->image_path; // Keep existing image path
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($ride->image_path && Storage::disk('public')->exists($ride->image_path)) {
                Storage::disk('public')->delete($ride->image_path);
            }
            $imagePath = $request->file('image')->store('rides', 'public');
        }

        // Update the ride
        $ride->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price_lkr' => $validated['price_lkr'],
            'tax_percentage' => $validated['tax_percentage'],
            'discount_percentage' => $validated['discount_percentage'],
            'regular_value' => $regularValue,
            'duration' => $validated['duration'],
            'passenger_capacity' => $validated['passenger_capacity'],
            'image_path' => $imagePath,
            'status' => $validated['status']
        ]);

        return redirect()->route('super_admin.packages.rides.rides')
                         ->with('success', 'Ride category updated successfully!');
    }

    // Delete ride category
    public function deleteRideCategory($id)
    {
        $ride = Ride::findOrFail($id);

        // Delete image if exists
        if ($ride->image_path && Storage::disk('public')->exists($ride->image_path)) {
            Storage::disk('public')->delete($ride->image_path);
        }

        $ride->delete();

        return redirect()->route('super_admin.packages.rides.rides')
                         ->with('success', 'Ride category deleted successfully!');
    }

    // Ride Cities Management
    public function rideCities()
    {
        $cities = RideCity::orderBy('created_at', 'desc')->get();
        return view('super_admin.packages.rides.cities', compact('cities'));
    }

    public function rideCitiesStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:ride_cities,name',
            'description' => 'nullable|string|max:1000',
            'status' => 'required|in:active,inactive'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        RideCity::create([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status ?? 'active'
        ]);

        return redirect()->route('super_admin.packages.rides.cities')
                         ->with('success', 'City added successfully!');
    }

    public function rideCitiesDelete(RideCity $city)
    {
        $city->delete();

        return redirect()->route('super_admin.packages.rides.cities')
                         ->with('success', 'City deleted successfully!');
    }

    // Ride Booking Management
    public function showBookingForm(Ride $ride)
    {
        $cities = RideCity::where('status', 'active')->orderBy('name')->get();
        return view('super_admin.packages.rides.book', compact('ride', 'cities'));
    }

    public function validatePromoCode(Request $request)
    {
        $promoCode = PromoCode::where('code', $request->promo_code)
                              ->where('status', 'active')
                              ->first();

        if (!$promoCode) {
            return response()->json([
                'valid' => false,
                'message' => 'Invalid promo code'
            ]);
        }

        if (!$promoCode->isValid($request->amount)) {
            return response()->json([
                'valid' => false,
                'message' => 'Promo code is not valid or has expired'
            ]);
        }

        $discount = $promoCode->calculateDiscount($request->amount);

        return response()->json([
            'valid' => true,
            'discount' => $discount,
            'message' => 'Promo code applied successfully!'
        ]);
    }

    public function storeRideBooking(Request $request)
    {
        // Debug: Log all request data
        Log::info('Booking form submitted', [
            'all_data' => $request->all(),
            'files' => $request->hasFile('payment_slip') ? 'Payment slip uploaded' : 'No payment slip'
        ]);

        $validator = Validator::make($request->all(), [
            'ride_id' => 'required|exists:rides,id',
            'city_id' => 'required|exists:ride_cities,id',
            'full_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'quantity' => 'required|integer|min:1',
            'passengers' => 'required|array|min:1',
            'passengers.*.name' => 'required|string|max:255',
            'passengers.*.nic' => 'required|string|max:20',
            'payment_type' => 'required|in:tentative,partial,full',
            'additional_notes' => 'nullable|string|max:1000',
            'promo_code' => 'nullable|string|exists:promo_codes,code',
            'partial_amount' => 'required_if:payment_type,partial|nullable|numeric|min:5000',
            'payment_slip' => 'required_if:payment_type,partial,full|nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'reference_number' => 'required_if:payment_type,partial,full|nullable|string|max:100'
        ]);

        if ($validator->fails()) {
            Log::info('Validation failed', ['errors' => $validator->errors()->toArray()]);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Log::info('Validation passed, starting booking creation');

        $ride = Ride::findOrFail($request->ride_id);

        // Check passenger capacity if set
        if ($ride->passenger_capacity && $request->quantity > $ride->passenger_capacity) {
            return redirect()->back()->withErrors(['quantity' => 'Quantity exceeds passenger capacity for this ride.'])->withInput();
        }

        // Calculate pricing
        $basePrice = $ride->price_lkr;
        $subtotal = $basePrice * $request->quantity;
        $taxAmount = ($subtotal * $ride->tax_percentage) / 100;

        // Apply promo code discount
        $promoDiscount = 0;
        $promoCode = null;
        if ($request->promo_code) {
            $promoCode = PromoCode::where('code', $request->promo_code)->first();
            if ($promoCode && $promoCode->isValid($subtotal + $taxAmount)) {
                $promoDiscount = $promoCode->calculateDiscount($subtotal + $taxAmount);
            }
        }

        // Apply full payment discount (5%)
        $fullPaymentDiscount = 0;
        if ($request->payment_type === 'full') {
            $fullPaymentDiscount = ($subtotal + $taxAmount - $promoDiscount) * 0.05;
        }

        $totalAmount = $subtotal + $taxAmount - $promoDiscount - $fullPaymentDiscount;

        // Determine payment amounts
        $paidAmount = 0;
        $remainingAmount = $totalAmount;

        if ($request->payment_type === 'partial') {
            $paidAmount = $request->partial_amount;
            $remainingAmount = $totalAmount - $paidAmount;
        } elseif ($request->payment_type === 'full') {
            $paidAmount = $totalAmount;
            $remainingAmount = 0;
        }

        try {
            DB::beginTransaction();

            // Create booking
            $booking = RideBooking::create([
                'ride_id' => $request->ride_id,
                'city_id' => $request->city_id,
                'user_id' => Auth::id(),
                'full_name' => $request->full_name,
                'phone_number' => $request->phone_number,
                'email' => $request->email,
                'quantity' => $request->quantity,
                'passengers' => $request->passengers,
                'base_price' => $basePrice,
                'tax_amount' => $taxAmount,
                'subtotal' => $subtotal,
                'promo_discount' => $promoDiscount,
                'full_payment_discount' => $fullPaymentDiscount,
                'total_amount' => $totalAmount,
                'payment_type' => $request->payment_type,
                'paid_amount' => $paidAmount,
                'remaining_amount' => $remainingAmount,
                'promo_code' => $request->promo_code,
                'additional_notes' => $request->additional_notes,
                'status' => 'pending'
            ]);

            // Handle payment if not tentative
            if ($request->payment_type !== 'tentative' && $request->hasFile('payment_slip')) {
                $paymentSlipPath = $request->file('payment_slip')->store('payment_slips', 'public');

                Payment::create([
                    'booking_id' => $booking->id,
                    'booking_type' => 'ride',
                    'amount' => $paidAmount,
                    'payment_method' => 'bank_transfer',
                    'payment_type' => $request->payment_type,
                    'reference_number' => $request->reference_number,
                    'payment_slip_path' => $paymentSlipPath,
                    'status' => 'pending',
                    'has_promo_code' => $promoCode ? true : false,
                    'promo_code_id' => $promoCode ? $promoCode->id : null
                ]);
            }

            // Increment promo code usage if applied
            if ($promoCode) {
                $promoCode->incrementUsage();
            }

            DB::commit();

            // Send email notification (you can implement this later)
            $this->sendBookingConfirmationEmail($booking);

            return redirect()->route('super_admin.packages.rides.rides')
                           ->with('success', 'Booking created successfully! Booking Reference: ' . $booking->booking_reference);

        } catch (\Exception $e) {
            DB::rollBack();

            // Log the actual error for debugging
            Log::error('Booking creation failed', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()->withErrors(['error' => 'An error occurred while processing your booking: ' . $e->getMessage()])->withInput();
        }
    }

    private function sendBookingConfirmationEmail($booking)
    {
        // TODO: Implement email notification
        // You can use Laravel's Mail facade to send emails
        // Mail::to($booking->email)->send(new BookingConfirmationMail($booking));

        // For now, just log the booking for reference
        Log::info('Booking created', [
            'booking_reference' => $booking->booking_reference,
            'customer_email' => $booking->email,
            'ride_name' => $booking->ride->name,
            'total_amount' => $booking->total_amount,
            'payment_type' => $booking->payment_type
        ]);
    }

    // Tours Package Management
    public function tours()
    {
        // Dummy data for Tours
        $tourPackages = [
            [
                'id' => 1,
                'name' => 'Cultural Heritage Tour',
                'description' => 'Explore ancient temples and cultural sites',
                'price' => 75,
                'duration' => 'Full Day',
                'image' => 'https://images.unsplash.com/photo-1539650116574-75c0c6d8d5d9?w=300&h=200&fit=crop'
            ],
            [
                'id' => 2,
                'name' => 'Nature & Wildlife Safari',
                'description' => 'Adventure through national parks and wildlife reserves',
                'price' => 120,
                'duration' => '2 Days',
                'image' => 'https://images.unsplash.com/photo-1516426122078-c23e76319801?w=300&h=200&fit=crop'
            ]
        ];

        return view('super_admin.packages.tours.tours', compact('tourPackages'));
    }

    public function showAirCrafts()
    {
        $aircrafts = Aircraft::latest()->get();
        return view('super_admin.aircrafts.aircrafts', compact('aircrafts'));
    }

    // Create aircraft form
    public function createAircraft()
    {
        return view('super_admin.aircrafts.aircrafts_create');
    }

    // Store aircraft
    public function storeAircraft(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'overview' => 'required|string',
            'passenger_seats' => 'required|integer|min:1',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,inactive'
        ]);

        // Handle multiple image uploads
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('aircrafts', 'public');
            }
        }

        Aircraft::create([
            'name' => $validated['name'],
            'overview' => $validated['overview'],
            'passenger_seats' => $validated['passenger_seats'],
            'images' => $imagePaths,
            'status' => $validated['status']
        ]);

        return redirect()->route('super_admin.aircrafts')
                         ->with('success', 'Aircraft created successfully!');
    }

    // Edit aircraft
    public function editAircraft($id)
    {
        $aircraft = Aircraft::findOrFail($id);
        return view('super_admin.aircrafts.aircrafts_edit', compact('aircraft'));
    }

    // Update aircraft
    public function updateAircraft(Request $request, $id)
    {
        $aircraft = Aircraft::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'overview' => 'required|string',
            'passenger_seats' => 'required|integer|min:1',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,inactive'
        ]);

        // Handle multiple image uploads
        $imagePaths = $aircraft->images ?? []; // Keep existing images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('aircrafts', 'public');
            }
        }

        $aircraft->update([
            'name' => $validated['name'],
            'overview' => $validated['overview'],
            'passenger_seats' => $validated['passenger_seats'],
            'images' => $imagePaths,
            'status' => $validated['status']
        ]);

        return redirect()->route('super_admin.aircrafts')
                         ->with('success', 'Aircraft updated successfully!');
    }

    // View aircraft details
    public function viewAircraft($id)
    {
        $aircraft = Aircraft::findOrFail($id);
        return view('super_admin.aircrafts.aircrafts_view', compact('aircraft'));
    }

    // Delete aircraft
    public function deleteAircraft($id)
    {
        $aircraft = Aircraft::findOrFail($id);

        // Delete images if they exist
        if ($aircraft->images) {
            foreach ($aircraft->images as $imagePath) {
                if (Storage::disk('public')->exists($imagePath)) {
                    Storage::disk('public')->delete($imagePath);
                }
            }
        }

        $aircraft->delete();

        return redirect()->route('super_admin.aircrafts')
                         ->with('success', 'Aircraft deleted successfully!');
    }

    // Cut From below Here to add Admin Functions
    public function showAirTaxiBookings(Request $request)
    {
        $query = AirTaxiBooking::with(['user', 'aircraft']);

        // Filter by date range
        if ($request->has('filter') && $request->filter) {
            switch ($request->filter) {
                case 'today':
                    $query->whereDate('created_at', now());
                    break;
                case 'week':
                    $query->where('created_at', '>=', now()->subWeek());
                    break;
                case 'month':
                    $query->where('created_at', '>=', now()->subMonth());
                    break;
            }
        }

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('full_name', 'LIKE', "%{$search}%")
                  ->orWhere('phone_number', 'LIKE', "%{$search}%")
                  ->orWhere('tour_type', 'LIKE', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('email', 'LIKE', "%{$search}%");
                  });
            });
        }

        $airTaxiBookings = $query->latest()->paginate(15);
        return view('super_admin.bookings.air_taxi.air_taxi_bookings', compact('airTaxiBookings'));
    }

    public function viewAirTaxiBooking($id)
    {
        $booking = AirTaxiBooking::with(['user', 'aircraft'])->findOrFail($id);
        return view('super_admin.bookings.air_taxi.view', compact('booking'));
    }

    public function editAirTaxiBooking($id)
    {
        $booking = AirTaxiBooking::with(['user', 'aircraft'])->findOrFail($id);
        $aircrafts = Aircraft::where('status', true)->get();
        return view('super_admin.bookings.air_taxi.edit', compact('booking', 'aircrafts'));
    }

    public function updateAirTaxiBooking(Request $request, $id)
    {
        $booking = AirTaxiBooking::findOrFail($id);

        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'tour_type' => 'required|string|max:255',
            'start_point' => 'required|string|max:255',
            'end_point' => 'required|string|max:255',
            'booking_date' => 'required|date|after_or_equal:' . now()->addDays(1)->format('Y-m-d'),
            'booking_time' => 'required',
            'status' => 'required|in:pending,confirmed,cancelled,completed',
            'passengers' => 'required|array|min:1',
            'passengers.*.name' => 'required|string|max:255',
            'passengers.*.nic' => 'required|string|max:20',
            'notes' => 'nullable|string'
        ]);

        $booking->update([
            'full_name' => $request->full_name,
            'phone_number' => $request->phone_number,
            'tour_type' => $request->tour_type,
            'start_point' => $request->start_point,
            'end_point' => $request->end_point,
            'booking_date' => $request->booking_date,
            'booking_time' => $request->booking_time,
            'passengers' => $request->passengers,
            'status' => $request->status,
            'notes' => $request->notes,
            'confirmed_at' => $request->status === 'confirmed' ? now() : null
        ]);

        return redirect()->route('super_admin.bookings.air_taxi.bookings')
                        ->with('success', 'Booking updated successfully!');
    }

    public function updateAirTaxiBookingStatus(Request $request, $id)
    {
        $booking = AirTaxiBooking::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,completed'
        ]);

        $booking->update([
            'status' => $request->status,
            'confirmed_at' => $request->status === 'confirmed' ? now() : null
        ]);

        // Return JSON for AJAX requests
        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Booking status updated successfully!']);
        }

        return redirect()->back()->with('success', 'Booking status updated successfully!');
    }

    public function deleteAirTaxiBooking($id)
    {
        $booking = AirTaxiBooking::findOrFail($id);
        $booking->delete();

        return redirect()->route('super_admin.bookings.air_taxi.bookings')
                        ->with('success', 'Booking deleted successfully!');
    }

    // Promo Code Routes

    public function promoCodes()
    {
        $promoCodes = PromoCode::latest()->paginate(15);
        return view('super_admin.promocodes.promo_code', compact('promoCodes'));
    }

    public function createPromoCode()
    {
        return view('super_admin.promocodes.create');
    }

    public function storePromoCode(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:50|unique:promo_codes,code',
            'description' => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'minimum_amount' => 'nullable|numeric|min:0',
            'maximum_discount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'valid_from' => 'required|date|after_or_equal:today',
            'valid_until' => 'required|date|after:valid_from',
            'status' => 'required|in:active,inactive',
        ]);

        PromoCode::create([
            'code' => strtoupper($request->code),
            'description' => $request->description,
            'author' => $request->author,
            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value,
            'minimum_amount' => $request->minimum_amount,
            'maximum_discount' => $request->maximum_discount,
            'usage_limit' => $request->usage_limit,
            'valid_from' => $request->valid_from,
            'valid_until' => $request->valid_until,
            'status' => $request->status,
        ]);

        return redirect()->route('super_admin.promo_codes')
                        ->with('success', 'Promo code created successfully!');
    }

    public function viewPromoCode($id)
    {
        $promoCode = PromoCode::findOrFail($id);
        return view('super_admin.promocodes.view', compact('promoCode'));
    }

    public function editPromoCode($id)
    {
        $promoCode = PromoCode::findOrFail($id);
        return view('super_admin.promocodes.edit', compact('promoCode'));
    }

    public function updatePromoCode(Request $request, $id)
    {
        $promoCode = PromoCode::findOrFail($id);

        $request->validate([
            'code' => 'required|string|max:50|unique:promo_codes,code,' . $id,
            'description' => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'minimum_amount' => 'nullable|numeric|min:0',
            'maximum_discount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'valid_from' => 'required|date',
            'valid_until' => 'required|date|after:valid_from',
            'status' => 'required|in:active,inactive',
        ]);

        $promoCode->update([
            'code' => strtoupper($request->code),
            'description' => $request->description,
            'author' => $request->author,
            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value,
            'minimum_amount' => $request->minimum_amount,
            'maximum_discount' => $request->maximum_discount,
            'usage_limit' => $request->usage_limit,
            'valid_from' => $request->valid_from,
            'valid_until' => $request->valid_until,
            'status' => $request->status,
        ]);

        return redirect()->route('super_admin.promo_codes')
                        ->with('success', 'Promo code updated successfully!');
    }

    public function deletePromoCode($id)
    {
        $promoCode = PromoCode::findOrFail($id);
        $promoCode->delete();

        return redirect()->route('super_admin.promo_codes')
                        ->with('success', 'Promo code deleted successfully!');
    }

}
