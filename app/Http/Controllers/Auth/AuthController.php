<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    /**
     * Show the login form
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Show the registration form
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Handle user login
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember-me');
        $user = User::where('email', $credentials['email'])->first();

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // Update last login time
            User::where('id', Auth::id())->update(['last_login_at' => now()]);

             if ($user->role === 'vendor') {
                return redirect('/vendor/dashboard')->with('success', 'Account created successfully! Welcome to TripMe!');
            }elseif($user->role === 'affiliate') {
                return redirect('/affiliate/dashboard')->with('success', 'Account created successfully! Welcome to TripMe!');
            }elseif($user->role === 'super_admin') {
                return redirect('/super_admin/dashboard')->with('success', 'Account created successfully! Welcome to TripMe!');
            }
        }

        return redirect()->back()
            ->withErrors(['email' => 'Invalid credentials'])
            ->withInput();
    }

    /**
     * Handle user registration
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'business_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'password' => ['required', 'string', Password::min(8)],
            'confirm_password' => 'required|same:password',
            'partner_type' => 'required|in:affiliate,vendor',
            'vendor_type' => 'required_if:partner_type,vendor|nullable|in:Hotel Partner,Activity Partner,Travel Guide',
        ], [
            'partner_type.required' => 'Please select a partner type.',
            'partner_type.in' => 'Invalid partner type selected.',
            'vendor_type.required_if' => 'Please select a vendor type when choosing vendor as partner type.',
            'vendor_type.in' => 'Invalid vendor type selected.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Determine the role based on partner type
            $partnerType = $request->partner_type;
            $role = $partnerType; // Use the selected partner type as the role

            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'business_name' => $request->business_name,
                'contact_number' => $request->phone,
                'role' => $role,
                'vendor_type' => $partnerType === 'vendor' ? $request->vendor_type : null,
                'is_active' => true,
            ]);            // Auto login after successful registration
            Auth::login($user);

            if ($user->role === 'vendor') {
                return redirect('/vendor/dashboard')->with('success', 'Account created successfully! Welcome to TripMe!');
            }elseif($user->role === 'affiliate') {
                return redirect('/affiliate/dashboard')->with('success', 'Account created successfully! Welcome to TripMe!');
            }elseif($user->role === 'super_admin') {
                return redirect('/super_admin/dashboard')->with('success', 'Account created successfully! Welcome to TripMe!');
            }

        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['general' => 'Registration failed. Please try again.'])
                ->withInput();
        }
    }

    /**
     * Handle user logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'You have been logged out successfully.');
    }

    /**
     * Show dashboard (protected route)
     */
    public function dashboard()
    {
        return view('dashboard.index');
    }
}
