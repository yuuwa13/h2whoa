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
        return view('admin.index', compact('stocks'));
    }

    // Show the “create stock” form //
    public function create()
    {
        return view('stocks.create');
    }

    // Handle the form POST and save new stock //
    public function store(Request $request)
    {
        $data = $request->validate([
            'product_name'    => 'required|string|max:255',
            'quantity'        => 'required|integer|min:0',
            'price_per_unit'  => 'required|numeric|min:0',
        ]);

        Stock::create($data);

        return redirect()
            ->route('admin.stocks')
            ->with('success', 'Stock added successfully.');
    }

        public function edit(Stock $stock)
    {
        return view('stocks.edit', compact('stock'));
    }

    // Handle the form PUT and save updates //
    public function update(Request $request, Stock $stock)
    {
        $data = $request->validate([
            'product_name'   => 'required|string|max:255',
            'quantity'       => 'required|integer|min:0',
            'price_per_unit' => 'required|numeric|min:0',
        ]);

        $stock->update($data);

        return redirect()
            ->route('admin.stocks')
            ->with('success', 'Stock updated successfully.');
    }

    public function destroy(Stock $stock)
    {
        $stock->delete();

        return redirect()
            ->route('admin.stocks')
            ->with('success', 'Stock deleted successfully.');
    }
}
