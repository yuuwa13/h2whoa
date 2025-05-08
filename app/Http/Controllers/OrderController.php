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

class OrderController extends Controller
{
    // Display all orders
    public function index()
    {
        // Fetch all available stocks
        $products = Stock::all(); // Fetch all stocks from the database

        // Simulate a cart by initializing an empty array
        $cart = [];

        // Calculate the subtotal dynamically
        $subtotal = 0; // Initialize subtotal
        foreach ($products as $product) {
            // Example: Assume each stock has a default quantity of 1 for demonstration
            $quantity = 1; // Replace this with actual logic if needed
            $itemTotal = $quantity * $product->price_per_unit;

            // Add to the cart array
            $cart[] = [
                'name' => $product->product_name,
                'quantity' => $quantity,
                'total_price' => $itemTotal,
            ];

            // Add to the subtotal
            $subtotal += $itemTotal;
        }

        // Calculate tax (20% of subtotal)
        $tax = $subtotal * 0.20;

        // Add delivery fee
        $deliveryFee = 50;

        // Calculate the total price
        $total = $subtotal + $tax + $deliveryFee;

        // Pass data to the view
        return view('orders.index', compact('products', 'cart', 'subtotal', 'tax', 'deliveryFee', 'total'));
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
        $deliveryFee = $request->session()->get('deliveryFee', 50);
        $total = $request->session()->get('total', $subtotal + $tax + $deliveryFee);

        // Pass data to the mode_payment view
        return view('mode_payment', compact('cart', 'subtotal', 'tax', 'deliveryFee', 'total'));
    }
    public function save(Request $request)
    {
        try {
            $products = $request->input('products', []);

            // Filter out products with quantity 0
            $cart = [];
            $subtotal = 0;

            foreach ($products as $product) {
                $price = $product['price'] ?? ($product['total_price'] / $product['quantity'] ?? 0);

                if ($product['quantity'] > 0) {
                    $itemTotal = $product['quantity'] * $price;
                    $cart[] = [
                        'name' => $product['name'],
                        'quantity' => $product['quantity'],
                        'price' => $price,
                        'total_price' => $itemTotal,
                    ];
                    $subtotal += $itemTotal;
                }
            }

            // Calculate tax and total
            $tax = $subtotal * 0.20;
            $deliveryFee = 50;
            $total = $subtotal + $tax + $deliveryFee;

            // Save to session
            session([
                'cart' => $cart,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'deliveryFee' => $deliveryFee,
                'total' => $total,
            ]);

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
            $tax = $subtotal * 0.20;
            $deliveryFee = 50;
            $total = $subtotal + $tax + $deliveryFee;

            // Save to session
            session([
                'cart' => $cart,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'deliveryFee' => $deliveryFee,
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
        try {
            // Retrieve the cart and customer details from the session
            $cart = $request->session()->get('cart', []);
            $subtotal = $request->session()->get('subtotal', 0);
            $tax = $request->session()->get('tax', 0);
            $deliveryFee = $request->session()->get('deliveryFee', 50);
            $total = $request->session()->get('total', $subtotal + $tax + $deliveryFee);
            $customer = Auth::guard('customer')->user();

            if (!$customer) {
                return redirect()->route('login.form')->withErrors(['error' => 'You must be logged in to place an order.']);
            }

            if (empty($cart)) {
                return redirect()->route('mode.payment')->withErrors(['error' => 'Your cart is empty.']);
            }

            // Get the payment method from the request
            $paymentMethodId = $request->input('payment_method_id', 1); // Default to COD (1)

            // Create the order
            $order = Order::create([
                'customer_id' => $customer->customer_id,
                'amount_paid' => $total,
                'order_datetime' => now(),
                'order_status' => 'Pending', // Default status
                'payment_method_id' => $paymentMethodId,
            ]);

            // Add order details
            foreach ($cart as $item) {
                $stockId = Stock::where('product_name', $item['name'])->value('stock_id');

                if (!$stockId) {
                    return redirect()->route('mode.payment')->withErrors(['error' => "Stock not found for product: {$item['name']}"]);
                }

                OrderDetail::create([
                    'order_id' => $order->order_id,
                    'stock_id' => $stockId,
                    'quantity' => $item['quantity'],
                    'total_price' => $item['total_price'],
                ]);

                // Deduct stock quantity
                $stock = Stock::where('product_name', $item['name'])->first();
                if ($stock) {
                    $stock->quantity -= $item['quantity'];
                    $stock->save();
                }
            }

            // Clear the session cart
            $request->session()->forget(['cart', 'subtotal', 'tax', 'deliveryFee', 'total']);

            // Redirect to the track orders page
            return redirect()->route('track.orders')->with('success', 'Your order has been placed successfully!');
        } catch (\Exception $e) {
            Log::error('Error confirming order: ' . $e->getMessage());
            return redirect()->route('mode.payment')->withErrors(['error' => 'An error occurred while placing your order.']);
        }
    }

    public function cancelOrder(Request $request)
    {
        // Clear the session data related to the order
        $request->session()->forget(['cart', 'subtotal', 'tax', 'deliveryFee', 'total']);

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
}
