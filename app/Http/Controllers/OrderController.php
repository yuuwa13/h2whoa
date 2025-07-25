<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Stock;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\Sale;
use App\Models\SaleDetail;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $products = Stock::with('uploadedImage')->get();
        $customer = Auth::guard('customer')->user();
        $selectedAddress = session('selected_address');

        // Do NOT redirect if address is not set, just pass everything to the view
        $cart = [];
        $subtotal = 0;
        foreach ($products as $product) {
            $quantity = 1;
            $itemTotal = $quantity * $product->price_per_unit;
            $cart[] = [
                'name' => $product->product_name,
                'quantity' => $quantity,
                'total_price' => $itemTotal,
            ];
            $subtotal += $itemTotal;
        }
        $tax = $subtotal * 0.12;
        $deliveryFee = session('delivery_fee', 20);
        $total = $subtotal + $tax + $deliveryFee;

        return view('orders.index', compact('products', 'cart', 'subtotal', 'tax', 'deliveryFee', 'total', 'selectedAddress'));
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

        // Store the order_id in the session for later use
        session(['order_id' => $order->order_id]);

        // Debugging: Log the session data after setting order_id
        Log::info('Session after setting order_id:', session()->all());

        // Debugging: Log session write confirmation
        Log::info('Session write check after setting order_id:', ['order_id' => session('order_id')]);

        // Debugging: Log the order_id value immediately after setting it in the session
        Log::info('Order ID set in session:', ['order_id' => session('order_id')]);

        // Add order details and calculate total price
        foreach ($validated['items'] as $item) {
            $stock = \App\Models\Stock::find($item['stock_id']);

            // Add to order details without decrementing stock
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

    public function modePayment(Request $request)
    {
        // Retrieve the cart and calculations from the session or initialize them
        $cart = $request->session()->get('cart', []);
        $subtotal = $request->session()->get('subtotal', 0);
        $tax = $request->session()->get('tax', 0);
        $deliveryFee = $request->session()->get('delivery_fee', 20); // Default to 20 if not set
        $total = $subtotal + $tax + $deliveryFee;

        // Pass data to the mode_payment view
        return view('mode_payment', compact('cart', 'subtotal', 'tax', 'deliveryFee', 'total'));
    }
    public function save(Request $request)
    {
        if (!session('selected_address')) {
            return redirect()->route('orders.index')->withErrors(['error' => 'Please select your delivery address before proceeding to payment.']);
        }

        try {
            $products = $request->input('products', []);

            // Filter out products with quantity 0
            $cart = [];
            $subtotal = 0;

            // Debugging: Log the entire products array to identify missing keys
            Log::info('Products array:', $products); // Debugging log

            // Debugging: Log the Stock data for each product
            foreach ($products as $product) {
                // Check if stock_id is present and valid
                if (empty($product['stock_id'])) {
                    Log::warning('Missing or invalid stock_id for product:', $product); // Debugging log
                    continue; // Skip this product
                }

                $stock = Stock::find($product['stock_id']);
                if (!$stock) {
                    Log::warning('Stock not found for stock_id:', ['stock_id' => $product['stock_id']]); // Debugging log
                    continue; // Skip this product
                }

                Log::info('Stock Data:', $stock->toArray()); // Debugging log

                // Ensure required keys exist and provide default values if missing
                $name = $stock->product_name ?? 'Unknown Product';
                $quantity = $product['quantity'] ?? 0;
                $price = $stock->price_per_unit ?? 0;

                if ($quantity > 0) {
                    $itemTotal = $quantity * $price;
                    $cart[] = [
                        'name' => $name,
                        'quantity' => $quantity,
                        'price' => $price,
                        'total_price' => $itemTotal,
                    ];
                    $subtotal += $itemTotal;
                }
            }

            // Calculate tax and total
            $tax = $subtotal * 0.12;
            $deliveryFee = session('delivery_fee', 20); // Default to 20 if not set
            $total = $subtotal + $tax + $deliveryFee;

            // Save to session
            session([
                'cart' => $cart,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'delivery_fee' => $deliveryFee,
                'total' => $total,
            ]);

            // Debugging: Log session data and redirection
            Log::info('Session Data:', session()->all()); // Debugging log
            Log::info('Redirecting to mode.payment'); // Debugging log

            // Redirect to the mode-payment page
            return redirect()->route('mode.payment');
        } catch (\Exception $e) {
            Log::error('Error saving cart: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'An error occurred while saving the cart.']);
        }
    }

    public function saveChanges(Request $request)
    {
        try {
            $products = $request->input('products', []);

            // Filter out products with quantity 0
            $cart = [];
            $subtotal = 0;

            foreach ($products as $product) {
                // Check if the 'price' key exists, and provide a default value if it doesn't
                $price = $product['price'] ?? ($product['total_price'] / $product['quantity'] ?? 0);

                if ($product['quantity'] > 0) {
                    $itemTotal = $product['quantity'] * $price;
                    $cart[] = [
                        'name' => $product['name'],
                        'quantity' => $product['quantity'],
                        'price' => $price, // Include the price in the cart
                        'total_price' => $itemTotal,
                    ];
                    $subtotal += $itemTotal;
                }
            }

            // Calculate tax and total
            $tax = $subtotal * 0.12;
            $deliveryFee = session('delivery_fee', 20); // Default to 20 if not set
            $total = $subtotal + $tax + $deliveryFee;

            // Save to session
            session([
                'cart' => $cart,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'delivery_fee' => $deliveryFee,
                'total' => $total,
            ]);

            // Return success response
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error saving changes: ' . $e->getMessage());

            // Return error response
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function confirmOrder(Request $request)
    {
        Log::info('Session Data:', $request->session()->all());
        try {
            // Retrieve the cart and customer details from the session
            $cart = $request->session()->get('cart', []);
            $subtotal = $request->session()->get('subtotal', 0);
            $tax = $request->session()->get('tax', 0);
            $deliveryFee = $request->session()->get('delivery_fee', 20); // Default to 20 if not set
            $total = $subtotal + $tax + $deliveryFee;
            $customer = Auth::guard('customer')->user();

            // Debugging logs
            Log::info('Customer:', $customer ? (is_object($customer) ? (array) $customer : $customer) : []);
            Log::info('Cart:', $cart);
            Log::info('Subtotal:', ['value' => $subtotal]); // Wrap in an array
            Log::info('Tax:', ['value' => $tax]); // Wrap in an array
            Log::info('Delivery Fee:', ['value' => $deliveryFee]); // Wrap in an array
            Log::info('Total:', ['value' => $total]); // Wrap in an array

            // Check if the customer is logged in
            if (!$customer) {
                Log::warning('Customer not logged in.');
                return redirect()->route('login.form')->withErrors(['error' => 'You must be logged in to place an order.']);
            }

            // Check if the cart is empty
            if (empty($cart)) {
                Log::warning('Cart is empty.');
                return redirect()->route('mode.payment')->withErrors(['error' => 'Your cart is empty.']);
            }

            // Get the payment method from the request
            $paymentMethodId = $request->input('payment_method_id', 1); // Default to COD
            $paymentMethodExists = DB::table('payment_methods')->where('payment_method_id', $paymentMethodId)->exists();
            Log::info('Payment Method ID:', ['value' => $paymentMethodId]); // Wrap in an array
            Log::info('Payment Method Exists:', ['exists' => $paymentMethodExists]);

            if (!$paymentMethodExists) {
                Log::warning('Invalid payment method ID.');
                return redirect()->route('mode.payment')->withErrors(['error' => 'Invalid payment method ID.']);
            }

            // Create the order
            $order = Order::create([
                'customer_id'      => $customer->customer_id,
                'amount_paid'      => $total,
                'order_datetime'   => now(),
                'order_status'     => 'Pending',
                'payment_method_id' => $paymentMethodId,
                // Snapshot fields:
                'customer_name'    => $customer->name,
                'customer_phone'   => $customer->phone,
                'customer_address' => session('selected_address') ?? $customer->address,
            ]);

            // Add order details
            foreach ($cart as $item) {
                $stockId = Stock::where('product_name', $item['name'])->value('stock_id');

                if (!$stockId) {
                    Log::warning("Stock not found for product: {$item['name']}");
                    return redirect()->route('mode.payment')->withErrors(['error' => "Stock not found for product: {$item['name']}"]);
                }

                OrderDetail::create([
                    'order_id' => $order->order_id,
                    'stock_id' => $stockId,
                    'quantity' => $item['quantity'],
                    'price_per_unit' => $item['price'], // Save the price per unit at order time
                    'total_price' => $item['total_price'],
                ]);
            }

            // Clear the session cart
            $request->session()->forget(['cart', 'subtotal', 'tax', 'delivery_fee', 'total', 'payment_method_id']);

            // Flash success message
            session()->flash('delivery_confirmed', 'Your delivery details have been confirmed successfully!');

            // Redirect to the track orders page
            return redirect()->route('track.orders')->with('success', 'Your order has been placed successfully!');
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Error confirming order: ' . $e->getMessage());

            // Redirect back to the mode payment page with an error message
            return redirect()->route('mode.payment')->withErrors(['error' => 'An error occurred while placing your order.']);
        }
    }

    public function cancelOrder(Request $request)
    {
        // Clear the session data related to the order
        $request->session()->forget(['cart', 'subtotal', 'tax', 'deliveryFee', 'total']);

        // Add a flash message to the session
        session()->flash('order_canceled', 'The order has been successfully canceled.');

        // Redirect back to the orders page
        return redirect()->route('orders.index')->with('success', 'Your order has been canceled.');
    }
    public function trackOrders()
    {
        $customer = Auth::guard('customer')->user();
        $orders = Order::with('orderDetails.stock')
            ->where('customer_id', $customer->customer_id)
            ->whereIn('order_status', ['Pending', 'Out for Delivery']) // Only fetch these statuses
            ->get();

        return view('online_track', compact('orders'));
    }

    public function historyOrders()
    {
        $customer = Auth::guard('customer')->user();
        $orders = Order::with('orderDetails.stock')
            ->where('customer_id', $customer->customer_id)
            ->whereIn('order_status', ['Delivered', 'Cancelled']) // Only fetch these statuses
            ->get();

        return view('online_history', compact('orders'));
    }
    public function saveAddress(Request $request)
    {
        $request->validate([
            'address' => 'required|string|max:255',
            'delivery_fee' => 'required|numeric|min:20', // Validate the delivery fee
        ]);

        // Save the selected address and delivery fee to the session
        session([
            'selected_address' => $request->input('address'),
            'delivery_fee' => $request->input('delivery_fee'),
        ]);

        // Check if the customer is authenticated
        $customer = \App\Models\Customer::find(Auth::guard('customer')->id());
        if ($customer) {
            $customer->address = $request->input('address');
            $customer->save();
        }

        // Set a success message
        return redirect()->route('orders.index')->with('address_confirmed', 'Your address has been successfully confirmed!');
    }
    public function updateStatus(Request $request, $orderId)
    {
        $validated = $request->validate([
            'order_status' => 'required|string|in:Pending,Out for Delivery,Delivered,Cancelled',
        ]);

        $order = Order::findOrFail($orderId);

        // Inside the updateStatus method, add logging
        Log::info('Updating order status', ['order_id' => $orderId, 'new_status' => $validated['order_status']]);

        // Check if the status is being updated to 'Delivered'
        if ($validated['order_status'] === 'Delivered' && $order->order_status !== 'Delivered') {
            Log::info('Order status set to Delivered', ['order_id' => $orderId]);

            // Automatically create a Sale record for web-based transactions
            $sale = Sale::create([
                'order_id' => $order->order_id,
                'sale_type' => 'web',
            ]);
            Log::info('Sale record created', ['order_id' => $orderId, 'sale_id' => $sale->sale_id]);

            foreach ($order->orderDetails as $detail) {
                $stock = $detail->stock;

                // Decrement stock quantity only when status is 'Delivered'
                if ($stock->is_quantifiable) {
                    $stock->decrement('quantity', $detail->quantity);
                    Log::info('Stock decremented', ['stock_id' => $stock->stock_id, 'quantity' => $detail->quantity]);
                }

                // Create SaleDetail for the web-based sale
                SaleDetail::create([
                    'sale_id' => $sale->sale_id, // Link to the corresponding sale
                    'product_name' => $stock->product_name,
                    'quantity' => $detail->quantity,
                    'price_per_unit' => $stock->price_per_unit,
                    'total_price' => $detail->total_price,
                ]);
            }
        }

        $order->order_status = $validated['order_status'];
        $order->save();
        Log::info('Order status updated successfully', ['order_id' => $orderId, 'final_status' => $order->order_status]);

        return redirect()->route('admin.orders')->with('success', 'Order status updated successfully.');
    }
    public function deliveryDetails()
    {
        $customer = Auth::guard('customer')->user();

        if (!$customer) {
            return redirect()->route('login.form')->withErrors(['error' => 'You must be logged in to view delivery details.']);
        }

        return view('delivery_details', compact('customer'));
    }
    public function invoice(Order $order)
{
    // Optionally, check if the user is allowed to view this invoice
    return view('invoice', compact('order'));
}
}
