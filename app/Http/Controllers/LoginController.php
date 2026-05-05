<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('online_logIn');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // Check if the customer exists and is deleted
        $customer = Customer::where('email', $request->email)->first();

        if ($customer && $customer->is_deleted) {
            return back()->withErrors(['email' => 'This account has been deactivated.']);
        }

        // Rate Limiting / Lockout Logic
        $throttleKey = Str::lower($request->input('email')) . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            return back()
                ->with('lockout', true)
                ->with('seconds', $seconds)
                ->withInput();
        }

        // Attempt to log in the customer
        if (Auth::guard('customer')->attempt($credentials)) {
            RateLimiter::clear($throttleKey);
            $request->session()->regenerate();
            return redirect()->intended('/orders');
        }

        RateLimiter::hit($throttleKey, 60); // Lock for 60 seconds after 5 failed attempts

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function showAdminLoginForm()
    {
        return view('admin.admin_login');
    }

    public function adminLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Rate Limiting / Lockout Logic
        $throttleKey = Str::lower($request->input('email')) . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            return back()
                ->with('lockout', true)
                ->with('seconds', $seconds)
                ->withInput();
        }

        if (Auth::guard('admin')->attempt($credentials)) {
            RateLimiter::clear($throttleKey);
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        RateLimiter::hit($throttleKey, 60); // Lock for 60 seconds after 5 failed attempts

        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ])->withInput();
    }

    public function adminLogout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}
