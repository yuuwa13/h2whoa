<?php


namespace App\Http\Controllers;


use App\Models\Stock;
use App\Models\UploadedImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB; // Add this import


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
        $uploadedImages = UploadedImage::all();
        return view('stocks.create', compact('uploadedImages'));
    }


    // Handle the form POST and save new stock //
    public function store(Request $request)
    {
        // Log the incoming request data
        Log::info('Store method called with request data:', $request->all());

        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'quantity' => $request->has('is_quantifiable') ? 'required|integer|min:0' : 'nullable',
            'price_per_unit' => 'required|numeric|min:0',
            'is_available' => 'sometimes|boolean',
            'is_quantifiable' => 'sometimes|boolean',
            'maximum_orders_allowed' => !$request->has('is_quantifiable') ? 'required|integer|min:0' : 'nullable',
            'uploaded_image_id' => 'nullable|exists:uploaded_images,id',
        ]);

        // Log the validated data
        Log::info('Validated data for store:', $validated);

        // Ensure default values for undefined keys
        $validated['maximum_orders_allowed'] = $request->input('maximum_orders_allowed', 0);
        $validated['quantity'] = $request->input('quantity', 0);

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

        $validated['uploaded_image_id'] = $request->input('uploaded_image_id');

        // Log the created stock
        $stock = Stock::create($validated);
        Log::info('Stock created:', $stock->toArray());

        // Log the action in stock_logs table
        DB::table('stock_logs')->insert([
            'stock_id' => $stock->stock_id,
            'action' => 'create',
            'new_values' => json_encode($stock->toArray()),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.stocks')->with('success', 'Stock created successfully!');
    }


    public function edit(Stock $stock)
    {
        $uploadedImages = UploadedImage::all();
        return view('stocks.edit', compact('stock', 'uploadedImages'));
    }


    // Handle the form PUT and save updates //
    public function update(Request $request, $id)
    {
        // Log the incoming request data
        Log::info('Update method called with request data:', $request->all());

        $stock = Stock::findOrFail($id);

        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'quantity' => $request->has('is_quantifiable') ? 'required|integer|min:0' : 'nullable|integer|min:0',
            'price_per_unit' => 'required|numeric|min:0',
            'is_available' => 'sometimes|boolean',
            'is_quantifiable' => 'sometimes|boolean',
            'maximum_orders_allowed' => !$request->has('is_quantifiable') ? 'required|integer|min:0' : 'nullable|integer|min:0',
            'uploaded_image_id' => 'nullable|exists:uploaded_images,id',
        ]);

        // Log the validated data
        Log::info('Validated data for update:', $validated);

        // Ensure default values for undefined keys
        $validated['maximum_orders_allowed'] = $request->input('maximum_orders_allowed', 0);
        $validated['quantity'] = $request->input('quantity', 0);

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

        $validated['uploaded_image_id'] = $request->input('uploaded_image_id');

        // Log the old values before updating
        $oldValues = $stock->toArray();

        // Log the updated stock
        $stock->update($validated);
        Log::info('Stock updated:', $stock->toArray());

        // Log the action in stock_logs table
        DB::table('stock_logs')->insert([
            'stock_id' => $stock->stock_id,
            'action' => 'update',
            'old_values' => json_encode($oldValues),
            'new_values' => json_encode($stock->toArray()),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.stocks')->with('success', 'Stock updated successfully!');
    }


    public function destroy(Stock $stock)
    {
        // Log the old values before deleting
        $oldValues = $stock->toArray();

        // Log the action in stock_logs table before deleting the stock
        DB::table('stock_logs')->insert([
            'stock_id' => $stock->stock_id,
            'action' => 'delete',
            'old_values' => json_encode($oldValues),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $stock->delete();

        return redirect()
            ->route('admin.stocks')
            ->with('success', 'Stock deleted successfully.');
    }
}
