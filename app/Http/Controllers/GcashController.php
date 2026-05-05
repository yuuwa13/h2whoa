<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GcashDetail;
use Illuminate\Support\Facades\Auth;

class GcashController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name'             => 'required|string|max:255',
            'reference_number' => 'required|string|max:255',
            'image'            => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Always resolve order_id from the session — never from user input
        $orderId = session('order_id');
        if (!$orderId) {
            return redirect()->route('orders.index')
                ->withErrors(['error' => 'No active order found.']);
        }

        // Verify the order belongs to the authenticated customer
        $customer = Auth::guard('customer')->user();
        $order = \App\Models\Order::where('order_id', $orderId)
            ->where('customer_id', $customer->customer_id)
            ->firstOrFail();

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('gcash_receipts', 'public');
        }

        GcashDetail::create([
            'name'             => $request->input('name'),
            'reference_number' => $request->input('reference_number'),
            'image'            => $imagePath,
            'order_id'         => $order->order_id,
        ]);

        session(['payment_method_id' => 2]);
        session()->flash('payment_confirmed', 'Details are confirmed, and payment is processed.');

        return redirect()->route('track.orders')
            ->with('success', 'GCash details saved successfully! Your order is now being processed.');
    }
}
