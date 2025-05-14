<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GcashDetail;
use Illuminate\Support\Facades\Log;

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

        // Retrieve the order ID from the session or request
        $orderId = $request->input('order_id') ?? session('order_id');

        // Debugging: Log the order ID and image path
        Log::info('Order ID:', ['order_id' => $orderId]);
        Log::info('Image Path:', ['image_path' => $imagePath]);

        // Debugging: Log the entire session to verify if order_id is present
        Log::info('Session Data:', session()->all());

        // Save GCash details to the database
        GcashDetail::create([
            'name' => $request->input('name'),
            'reference_number' => $request->input('reference_number'),
            'image' => $imagePath,
            'order_id' => $orderId, // Associate with the order
        ]);

        // Store the payment method in the session
        session(['payment_method_id' => 2]); // 2 for GCash

         // Add a flash message to the session
        session()->flash('payment_confirmed', 'Details are confirmed, and payment is processed.');

        // Redirect to the COD page to confirm delivery details
        return redirect()->route('delivery.details')->with('success', 'GCash details saved successfully! Please confirm your delivery details.');
    }
}
