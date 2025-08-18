<?php

namespace App\Http\Controllers\Super_Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
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

        return view('super_admin.user_management', compact('users'));
    }

    // Show user details
    public function userShow($id)
    {
        $user = User::findOrFail($id);
        return view('super_admin.user_show', compact('user'));
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('super_admin.user_edit', compact('user'));
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

        return redirect()->route('super_admin.user_management')
            ->with('success', 'User updated successfully!');
    }

    public function createUser()
    {
        return view('super_admin.user_create');
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

        return redirect()->route('super_admin.user_management')
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

        return redirect()->route('super_admin.user_management')
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
}
