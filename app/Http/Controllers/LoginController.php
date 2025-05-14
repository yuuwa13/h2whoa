<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

        // Attempt to log in the customer
        if (Auth::guard('customer')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/orders');
        }

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
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $adminEmail = config('auth.admin.email');
        $adminPasswordHash = config('auth.admin.password'); // This should already be a Bcrypt hash

        if ($request->email === $adminEmail && Hash::check($request->password, $adminPasswordHash)) {
            session(['is_admin' => true]); // Store admin session
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ])->withInput();
    }
}
