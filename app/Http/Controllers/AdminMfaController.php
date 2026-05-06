<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class AdminMfaController extends Controller
{
    public function show(Request $request)
    {
        if (!$request->session()->get('mfa_pending')) {
            return redirect()->route('admin.login');
        }

        return view('admin.admin_mfa');
    }

    public function verify(Request $request)
    {
        if (!$request->session()->get('mfa_pending')) {
            return redirect()->route('admin.login');
        }

        $request->validate(['otp' => 'required|digits:6']);

        $adminId = $request->session()->get('mfa_admin_id');
        $attempts = $request->session()->get('mfa_attempts', 0);

        // Too many wrong attempts — kill session and force re-login
        if ($attempts >= 5) {
            $request->session()->invalidate();
            return redirect()->route('admin.login')
                ->withErrors(['email' => 'Too many failed attempts. Please log in again.']);
        }

        $cachedOtp = Cache::get('admin_mfa:' . $adminId);

        if (!$cachedOtp) {
            $request->session()->invalidate();
            return redirect()->route('admin.login')
                ->withErrors(['email' => 'Your verification code has expired. Please log in again.']);
        }

        if (!hash_equals($cachedOtp, $request->otp)) {
            $request->session()->put('mfa_attempts', $attempts + 1);
            $remaining = 4 - $attempts;
            return back()->withErrors([
                'otp' => "Invalid code. {$remaining} attempt(s) remaining.",
            ]);
        }

        // OTP correct — complete the login
        Cache::forget('admin_mfa:' . $adminId);
        $request->session()->forget(['mfa_pending', 'mfa_admin_id', 'mfa_attempts']);

        Auth::guard('admin')->loginUsingId($adminId);
        $request->session()->regenerate();

        return redirect()->route('admin.dashboard');
    }
}
