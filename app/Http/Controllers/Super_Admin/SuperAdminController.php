<?php

namespace App\Http\Controllers\Super_Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Ride;
use App\Models\Aircraft;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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
        // Dummy data for Air Taxi
        $airTaxiServices = [
            [
                'id' => 1,
                'name' => 'Airport Transfer - Premium',
                'description' => 'Luxury helicopter transfer from airport to city center',
                'price' => 500,
                'duration' => '15 minutes',
                'image' => 'https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?w=300&h=200&fit=crop'
            ],
            [
                'id' => 2,
                'name' => 'Private Jet Charter',
                'description' => 'Exclusive private jet services for long-distance travel',
                'price' => 2500,
                'duration' => '2-4 hours',
                'image' => 'https://images.unsplash.com/photo-1540962351504-03099e0a754b?w=300&h=200&fit=crop'
            ]
        ];

        return view('super_admin.packages.air_taxi', compact('airTaxiServices'));
    }

    // Rides Package Management
    public function rides()
    {
        $ridesCategories = Ride::orderBy('created_at', 'desc')->get();
        return view('super_admin.packages.rides', compact('ridesCategories'));
    }

    // Create new ride category
    public function createRideCategory()
    {
        return view('super_admin.packages.rides_create');
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

        return redirect()->route('super_admin.packages.rides')
                         ->with('success', 'Ride category created successfully!');
    }

    // Edit ride category
    public function editRideCategory($id)
    {
        $ride = Ride::findOrFail($id);
        return view('super_admin.packages.rides_edit', compact('ride'));
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

        return redirect()->route('super_admin.packages.rides')
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

        return redirect()->route('super_admin.packages.rides')
                         ->with('success', 'Ride category deleted successfully!');
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

        return view('super_admin.packages.tours', compact('tourPackages'));
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


}
