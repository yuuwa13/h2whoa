<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{   //Create function
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->back()->with('success', 'Account created successfully!');
    }
    //User viewing their own profile
    public function profile()
    {
        $user = Auth::user(); // Gets the currently logged in user
        return view('users.profile', compact('user'));
    }
    //Change password function
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('password_success', 'Your password has been updated successfully.');
    }
    //Edit function basically for the user to edit their profile
    public function edit()
    {
        $user = Auth::user();
        return view('users.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->save();

        return redirect()->route('users.profile')->with('success', 'Profile updated successfully.');
    }
    //Delete functionality 
    public function destroy(Request $request)
    {
        $user = Auth::user();

        // Optionally, you can perform checks or soft delete here
        Auth::logout();

        // Hard delete
        $user->delete();

        return redirect('/')->with('success', 'Your account has been deleted.');
    }


}
