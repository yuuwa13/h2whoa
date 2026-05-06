<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Customer;
use App\Models\LoginLockout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminMfaCode;
use App\Mail\LoginLockoutAlert;

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

            $log = LoginLockout::create([
                'ip_address' => $request->ip(),
                'attempts' => RateLimiter::attempts($throttleKey), // optional: real count
            ]);

            Mail::to(config('mail.admin_alert_email'))
                ->send(new LoginLockoutAlert($log));

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

        if (Auth::guard('admin')->validate($credentials)) {
            RateLimiter::clear($throttleKey);

            $admin = Admin::where('email', $request->email)->first();

            // Generate 6-digit OTP and cache it for 10 minutes
            $otp = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            Cache::put('admin_mfa:' . $admin->id, $otp, now()->addMinutes(10));

            // Store pending MFA state in session
            $request->session()->put('mfa_pending', true);
            $request->session()->put('mfa_admin_id', $admin->id);
            $request->session()->put('mfa_attempts', 0);

            // Send OTP to the configured security email
            Mail::to(config('auth.admin_mfa_email'))->send(new AdminMfaCode($otp));

            return redirect()->route('admin.mfa');
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
