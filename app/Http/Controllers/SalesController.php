<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    // Display all sales
    public function index()
    {
        $sales = Sale::paginate(10); // Fetch sales with pagination
        return view('admin.admin_sales', compact('sales')); // Return the correct view
    }

    // Show the form for creating a new sale
    public function create()
    {
        return view('sales.create');
    }

    // Store a newly created sale
    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'nullable|exists:orders,order_id',
            'sale_type' => 'required|in:web,phone,on-site',
        ]);

        $sale = Sale::create($validated);

        if ($request->has('sale_details') && is_array($request->input('sale_details'))) {
            foreach ($request->input('sale_details') as $detail) {
                SaleDetail::create([
                    'sale_id' => $sale->sale_id,
                    'product_name' => $detail['product_name'],
                    'quantity' => $detail['quantity'],
                    'price_per_unit' => $detail['price_per_unit'],
                    'total_price' => $detail['quantity'] * $detail['price_per_unit'],
                ]);
            }
        } else {
            // Handle the case where sale_details is null or not an array
            // Optionally log or notify about the missing details
        }

        // Reflect OrderDetail to SaleDetail for web-based sales
        if ($sale->sale_type === 'web') {
            $orderDetails = OrderDetail::where('order_id', $sale->order_id)->get();
            foreach ($orderDetails as $orderDetail) {
                SaleDetail::create([
                    'sale_id' => $sale->sale_id,
                    'product_name' => $orderDetail->stock->product_name,
                    'quantity' => $orderDetail->quantity,
                    'price_per_unit' => $orderDetail->stock->price_per_unit,
                    'total_price' => $orderDetail->total_price,
                ]);
            }
        }

        return redirect()->route('sales.index')->with('success', 'Sale created successfully!');
    }

    // Show the form for editing a sale
    public function edit(Sale $sale)
    {
        $sale->load('saleDetails'); // Ensure saleDetails relationship is loaded
        return view('sales.edit', compact('sale'));
    }

    // Update an existing sale
    public function update(Request $request, Sale $sale)
    {
        $validated = $request->validate([
            'order_id' => 'nullable|exists:orders,order_id',
            'sale_type' => 'required|in:web,phone,on-site',
        ]);

        $sale->update($validated);

        // Delete existing sale details
        $sale->saleDetails()->delete();

        if ($request->has('sale_details') && is_array($request->input('sale_details'))) {
            foreach ($request->input('sale_details') as $detail) {
                SaleDetail::create([
                    'sale_id' => $sale->sale_id,
                    'product_name' => $detail['product_name'],
                    'quantity' => $detail['quantity'],
                    'price_per_unit' => $detail['price_per_unit'],
                    'total_price' => $detail['quantity'] * $detail['price_per_unit'],
                ]);
            }
        } else {
            // Handle the case where sale_details is null or not an array
            // Optionally log or notify about the missing details
        }

        // Reflect OrderDetail to SaleDetail for web-based sales
        if ($sale->sale_type === 'web') {
            $orderDetails = OrderDetail::where('order_id', $sale->order_id)->get();
            foreach ($orderDetails as $orderDetail) {
                SaleDetail::create([
                    'sale_id' => $sale->sale_id,
                    'product_name' => $orderDetail->stock->product_name,
                    'quantity' => $orderDetail->quantity,
                    'price_per_unit' => $orderDetail->stock->price_per_unit,
                    'total_price' => $orderDetail->total_price,
                ]);
            }
        }

        return redirect()->route('sales.index')->with('success', 'Sale updated successfully!');
    }

    // Delete a sale
    public function destroy(Sale $sale)
    {
        $sale->delete();

        return redirect()->route('sales.index')->with('success', 'Sale deleted successfully!');
    }
}
