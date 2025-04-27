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
            'human'    => 'accepted',
        ], [
            'human.accepted' => 'Please confirm you are human.',
        ]);

        $customer = Customer::where('email', $credentials['email'])->first();

        if (! $customer || ! Hash::check($credentials['password'], $customer->password)) {
            return back()
                ->withErrors(['email' => 'Invalid credentials.'])
                ->withInput();
        }

        // ← Here’s the key line:
        Auth::guard('customer')->login($customer);

        // Now Auth::guard('customer')->user() is $customer
        return redirect()->route('orders.index');
    }
}
