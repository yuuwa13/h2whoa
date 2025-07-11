<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerEditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class CustomerController extends Controller
{
    public function create()
    {
        return view('online_signUp');
    }

    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'address'         => 'required|string|max:255',
            'email'           => 'required|email|unique:customers,email',
            'phone'           => 'required|string|size:11|regex:/^\d{11}$/',
            'password'        => 'required|confirmed|min:6',
            'terms'           => 'accepted',
            'confirm_info'    => 'accepted',
            'human'           => 'accepted',
        ]);

        // Create the customer
        Customer::create([
            'name'       => $validated['name'],
            'address'    => $validated['address'],
            'email'      => $validated['email'],
            'phone'      => $validated['phone'],
            'password'   => Hash::make($validated['password']),
            'is_deleted' => false,
        ]);

        // Redirect to the login page with a success message
        return redirect()->route('login.form')->with('success', 'Account created successfully! You can now log in.');
    }
    /** Display profile */
    public function show()
    {
        $customer = Customer::find(Auth::guard('customer')->id());
        return view('customer-profile.profile', [
            'customer' => Auth::guard('customer')->user(),
            // formatted for display
            'createdFormatted' => Carbon::parse($customer->created_at)
                ->timezone('Asia/Manila')
                ->format('F d, Y \a\t h:i A T'),
            'editLogs' => $customer->editLogs,
        ]);
    }

    /** Handle profile updates */
    public function update(Request $request, $id = null)
    {
        // Determine the customer to update
        $customer = $id ? Customer::findOrFail($id) : Auth::guard('customer')->user();

        // Validation rules
        $rules = [
            'name'     => 'required|string|max:255',
            'phone'    => 'required|string|max:20',
            'address'  => 'required|string|max:255',
        ];

        // Add email and password validation only for profile updates
        if (!$id) {
            $rules['email'] = 'required|email|unique:customers,email,' . $customer->customer_id . ',customer_id';
            $rules['password'] = 'nullable|min:6|confirmed';
        }

        // Validate the request
        $data = $request->validate($rules);

        // Track changes
        $changes = [];
        foreach (['name', 'email', 'phone', 'address'] as $field) {
            if (isset($data[$field]) && $data[$field] !== $customer->$field) {
                $changes[$field] = [
                    'old' => $customer->$field,
                    'new' => $data[$field],
                ];
                $customer->$field = $data[$field];
            }
        }

        // Update password if provided (only for profile updates)
        if (!$id && !empty($data['password'])) {
            $changes['password'] = [
                'old' => '••••••••',
                'new' => '••••••••',
            ];
            $customer->password = Hash::make($data['password']);
        }

        // Save changes if any
        if (!empty($changes)) {
            $customer->save();

            // Log changes (only for profile updates)
            if (!$id) {
                foreach ($changes as $field => $vals) {
                    CustomerEditLog::create([
                        'customer_id' => $customer->customer_id,
                        'field'       => $field,
                        'old_value'   => $vals['old'],
                        'new_value'   => $vals['new'],
                    ]);
                }
            }

            // Redirect based on context
            if ($id) {
                return redirect()->route('delivery.details')->with('success', 'Delivery details updated successfully!');
            } else {
                return back()->with('status', 'Profile updated successfully!');
            }
        }

        // No changes detected
        if ($id) {
            return redirect()->route('delivery.details')->with('status', 'No changes detected.');
        } else {
            return back()->with('status', 'No changes detected.');
        }
    }
    public function destroy(Request $request)
    {
        $customer = Customer::find(Auth::guard('customer')->id());

        // Validate inputs
        $request->validate([
            'password'        => 'required',
            'confirm_delete'  => 'accepted',
            'human'           => 'accepted',
        ], [
            'confirm_delete.accepted' => 'You must confirm you want to delete your account.',
            'human.accepted'          => 'Please confirm you are human.',
        ]);

        // Verify password
        if (!Hash::check($request->password, $customer->password)) {
            return back()->withErrors(['password' => 'Incorrect password.']);
        }

        // Soft delete: Set is_deleted to true
        $customer->is_deleted = true;
        $customer->save();

        // Log out and invalidate session
        Auth::guard('customer')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect to login page with a success message
        return redirect()->route('login.form')
            ->with('status1', 'Your account has been successfully deleted.');
    }
    public function logout(Request $request)
    {
        // Log out the customer
        Auth::guard('customer')->logout();

        // Invalidate the session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect to the login page with a success message
        return redirect()->route('login.form')->with('status', 'You have been logged out successfully.');
    }
}
