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
        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'address'         => 'required|string|max:255',
            'email'           => 'required|email|unique:customers,email',
            'phone'           => 'required|string|max:11',
            'password'        => 'required|confirmed|min:6',
            'terms'           => 'accepted',
            'confirm_info'    => 'accepted',
            'human'           => 'accepted',
        ]);

        Customer::create([
            'name'       => $validated['name'],
            'address'    => $validated['address'],
            'email'      => $validated['email'],
            'phone'      => $validated['phone'],
            'password'   => Hash::make($validated['password']),
            'is_deleted' => false,
        ]);

        return redirect()->route('login.form')->with('success', 'Account created successfully!');
    }
    /** Display profile */
    public function show()
    {
        $customer = Auth::guard('customer')->user();
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
    public function update(Request $request)
    {
        $customer = Auth::guard('customer')->user();

        // validate only the fields that were edited
        $rules = [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:customers,email,'.$customer->customer_id.',customer_id',
            'phone'    => 'required|string|max:20',
            'address'  => 'required|string|max:255',
            'password' => 'nullable|min:6|confirmed',
            'human'    => 'accepted',
        ];
        $data = $request->validate($rules, [
            'human.accepted' => 'Please confirm you are human before saving.',
        ]);

        $changes = [];
        foreach (['name','email','phone','address'] as $field) {
            if ($data[$field] !== $customer->$field) {
                $changes[$field] = [
                    'old' => $customer->$field,
                    'new' => $data[$field],
                ];
                $customer->$field = $data[$field];
            }
        }
        if (!empty($data['password'])) {
            $changes['password'] = [
                'old' => '••••••••',
                'new' => '••••••••',
            ];
            $customer->password = Hash::make($data['password']);
        }

        if (empty($changes)) {
            return back()->with('status','No changes detected.');
        }

        // save the customer
        $customer->save();

        // log each change
        foreach ($changes as $field => $vals) {
            CustomerEditLog::create([
                'customer_id' => $customer->customer_id,
                'field'       => $field,
                'old_value'   => $vals['old'],
                'new_value'   => $vals['new'],
            ]);
        }

        return back()->with('status','Profile updated successfully.');
    }
    public function destroy(Request $request)
    {
        $customer = Auth::guard('customer')->user();

        // 1) Validate inputs
        $request->validate([
            'password'        => 'required',
            'confirm_delete'  => 'accepted',
            'human'           => 'accepted',
        ], [
            'confirm_delete.accepted' => 'You must confirm you want to delete your account.',
            'human.accepted'          => 'Please confirm you are human.',
        ]);

        // 2) Verify password
        if (! Hash::check($request->password, $customer->password)) {
            return back()->withErrors(['password' => 'Incorrect password.']);
        }

        // 3) Log out and delete
        Auth::guard('customer')->logout();
        $customer->delete();  // permanent since no soft-deletes

        // 4) Invalidate session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // 5) Redirect home
        return redirect('/')
               ->with('status', 'Your account has been permanently deleted.');
    }
}
