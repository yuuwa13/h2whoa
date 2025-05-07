<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GcashDetail;

class GcashController extends Controller
{
    public function store(Request $request)
    {
        // Validate the form data
        $request->validate([
            'name' => 'required|string|max:255',
            'reference_number' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle file upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('gcash_receipts', 'public');
        }

        // Save GCash details to the database
        GcashDetail::create([
            'name' => $request->input('name'),
            'reference_number' => $request->input('reference_number'),
            'image' => $imagePath,
        ]);

        // Store the payment method in the session
        session(['payment_method_id' => 2]); // 2 for GCash

         // Add a flash message to the session
        session()->flash('payment_confirmed', 'Details are confirmed, and payment is processed.');

        // Redirect to the COD page to confirm delivery details
        return redirect()->route('delivery.details')->with('success', 'GCash details saved successfully! Please confirm your delivery details.');
    }
}
