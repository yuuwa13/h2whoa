<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Stock;

class OrderController extends Controller
{
    // Display all orders
    public function index()
{
    $orders = Order::with('orderDetails.stock')
        ->orderBy('order_datetime', 'desc') // Sort by order_datetime in descending order
        ->get();

    return view('orders.index', compact('orders'));
}

    // Show the form to create a new order
    public function create()
{
    $stocks = Stock::all(); // Fetch all inventory items
    $customers = \App\Models\Customer::all(); // Fetch all customers
    return view('orders.create', compact('stocks', 'customers'));
}

    // Store a new order
    public function store(Request $request)
{
    $validated = $request->validate([
        'customer_id' => 'required|exists:customers,customer_id',
        'items' => 'required|array',
        'items.*.stock_id' => 'required|exists:stocks,stock_id',
        'items.*.quantity' => 'required|integer|min:1',
        'amount_paid' => 'required|numeric|min:0',
    ]);

    // Create the order
    $order = Order::create([
        'customer_id' => $validated['customer_id'], // Pass customer_id
        'amount_paid' => $validated['amount_paid'],
        'order_datetime' => now(),
    ]);

    // Add order details and calculate total price
    foreach ($validated['items'] as $item) {
        $stock = \App\Models\Stock::find($item['stock_id']);
        if ($stock->quantity < $item['quantity']) {
            return redirect()->back()->withErrors(['error' => 'Not enough stock for ' . $stock->product_name]);
        }

        // Deduct stock
        $stock->quantity -= $item['quantity'];
        $stock->save();

        // Add to order details
        \App\Models\OrderDetail::create([
            'order_id' => $order->order_id,
            'stock_id' => $item['stock_id'],
            'quantity' => $item['quantity'],
            'total_price' => $item['quantity'] * $stock->price_per_unit,
        ]);
    }

    // Update the total price in the order
    $order->update(['total_price' => $order->calculateTotalPrice()]);

    return redirect()->route('orders.index')->with('success', 'Order created successfully!');
}

    // Delete an order
    public function destroy($id)
    {
        $order = Order::findOrFail($id);

        // Restore stock quantities
        foreach ($order->orderDetails as $detail) {
            $stock = Stock::find($detail->stock_id);
            $stock->quantity += $detail->quantity;
            $stock->save();
        }

        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Order deleted successfully!');
    }

    public function edit($id)
{
    $order = Order::with('orderDetails.stock')->findOrFail($id); // Fetch the order with its details
    $stocks = Stock::all(); // Fetch all inventory items
    $customers = \App\Models\Customer::all(); // Fetch all customers
    return view('orders.edit', compact('order', 'stocks', 'customers'));
}

public function update(Request $request, $id)
{
    $validated = $request->validate([
        'customer_id' => 'required|exists:customers,customer_id',
        'items' => 'required|array',
        'items.*.stock_id' => 'required|exists:stocks,stock_id',
        'items.*.quantity' => 'required|integer|min:1',
        'amount_paid' => 'required|numeric|min:0',
    ]);

    $order = Order::findOrFail($id);

    // Restore stock quantities for the current order details
    foreach ($order->orderDetails as $detail) {
        $stock = Stock::find($detail->stock_id);
        $stock->quantity += $detail->quantity;
        $stock->save();
    }

    // Delete existing order details
    $order->orderDetails()->delete();

    // Update the order
    $order->update([
        'customer_id' => $validated['customer_id'],
        'amount_paid' => $validated['amount_paid'],
        'order_datetime' => now(),
    ]);

    $totalPrice = 0;

    // Add updated order details and calculate total price
    foreach ($validated['items'] as $item) {
        $stock = \App\Models\Stock::find($item['stock_id']);
        if ($stock->quantity < $item['quantity']) {
            return redirect()->back()->withErrors(['error' => 'Not enough stock for ' . $stock->product_name]);
        }

        // Deduct stock
        $stock->quantity -= $item['quantity'];
        $stock->save();

        // Calculate total price for this item
        $itemTotalPrice = $item['quantity'] * $stock->price_per_unit;

        // Add to order details
        \App\Models\OrderDetail::create([
            'order_id' => $order->order_id,
            'stock_id' => $item['stock_id'],
            'quantity' => $item['quantity'],
            'total_price' => $itemTotalPrice,
        ]);

        $totalPrice += $itemTotalPrice;
    }

    // Update the total price in the order
    $order->update(['total_price' => $totalPrice]);

    return redirect()->route('orders.index')->with('success', 'Order updated successfully!');
}
}