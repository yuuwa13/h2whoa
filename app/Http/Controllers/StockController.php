<?php


namespace App\Http\Controllers;


use App\Models\Stock;
use Illuminate\Http\Request;


class StockController extends Controller
{
    // Show all stocks //
    public function index()
    {
        $stocks = Stock::paginate(10);


        // Ensure $stocks is always defined
        if ($stocks->isEmpty()) {
            $stocks = collect([]); // Fallback to an empty collection
        }


        return view('admin.admin_stocks', compact('stocks'));
    }


    // Show the “create stock” form //
    public function create()
    {
        return view('stocks.create');
    }


    // Handle the form POST and save new stock //
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'quantity' => $request->has('is_quantifiable') ? 'required|integer|min:0' : 'nullable|integer|min:0',
            'price_per_unit' => 'required|numeric|min:0',
            'is_available' => 'sometimes|boolean',
            'is_quantifiable' => 'sometimes|boolean',
            'maximum_orders_allowed' => 'required|integer|min:0',
        ]);

        if ($request->has('is_quantifiable') && $validated['maximum_orders_allowed'] > $validated['quantity']) {
            return redirect()->back()->withErrors(['maximum_orders_allowed' => 'Maximum orders allowed cannot exceed the quantity.'])->withInput();
        }

        // Adjust availability and quantity based on quantifiability
        if (!$request->has('is_quantifiable')) {
            $validated['is_available'] = true;
            $validated['quantity'] = $validated['maximum_orders_allowed']; // Map maximum_orders_allowed to quantity
        } else {
            $validated['maximum_orders_allowed'] = null; // Clear maximum_orders_allowed for quantifiable stocks
        }

        $validated['is_available'] = $request->has('is_available') ? true : false;
        $validated['is_quantifiable'] = $request->has('is_quantifiable');
        $validated['maximum_orders_allowed'] = $request->input('maximum_orders_allowed', 0); // Ensure maximum_orders_allowed is always set with a default value

        // Ensure maximum_orders_allowed is saved correctly
        if (!$request->has('is_quantifiable')) {
            $validated['quantity'] = $validated['maximum_orders_allowed']; // Map maximum_orders_allowed to quantity
        } else {
            $validated['maximum_orders_allowed'] = $request->input('maximum_orders_allowed', 0); // Save user-provided value
        }

        Stock::create($validated);

        return redirect()->route('admin.stocks')->with('success', 'Stock created successfully!');
    }


    public function edit(Stock $stock)
    {
        return view('stocks.edit', compact('stock'));
    }


    // Handle the form PUT and save updates //
    public function update(Request $request, $id)
    {
        $stock = Stock::findOrFail($id);

        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'quantity' => $request->has('is_quantifiable') ? 'required|integer|min:0' : 'nullable|integer|min:0',
            'price_per_unit' => 'required|numeric|min:0',
            'is_available' => 'sometimes|boolean',
            'is_quantifiable' => 'sometimes|boolean',
            'maximum_orders_allowed' => 'required|integer|min:0',
        ]);

        if ($request->has('is_quantifiable') && $validated['maximum_orders_allowed'] > $validated['quantity']) {
            return redirect()->back()->withErrors(['maximum_orders_allowed' => 'Maximum orders allowed cannot exceed the quantity.'])->withInput();
        }

        // Adjust availability and quantity based on quantifiability
        if (!$request->has('is_quantifiable')) {
            $validated['is_available'] = true;
            $validated['quantity'] = $validated['maximum_orders_allowed']; // Map maximum_orders_allowed to quantity
        } else {
            $validated['maximum_orders_allowed'] = null; // Clear maximum_orders_allowed for quantifiable stocks
        }

        $validated['is_available'] = $request->has('is_available'); // Explicitly set to false if unchecked
        $validated['is_quantifiable'] = $request->has('is_quantifiable');
        $validated['maximum_orders_allowed'] = $request->input('maximum_orders_allowed', 0); // Ensure maximum_orders_allowed is always set with a default value

        // Ensure maximum_orders_allowed is saved correctly
        if (!$request->has('is_quantifiable')) {
            $validated['quantity'] = $validated['maximum_orders_allowed']; // Map maximum_orders_allowed to quantity
        } else {
            $validated['maximum_orders_allowed'] = $request->input('maximum_orders_allowed', 0); // Save user-provided value
        }

        $stock->update($validated);

        return redirect()->route('admin.stocks')->with('success', 'Stock updated successfully!');
    }


    public function destroy(Stock $stock)
    {
        $stock->delete();


        return redirect()
            ->route('admin.stocks')
            ->with('success', 'Stock deleted successfully.');
    }
}
