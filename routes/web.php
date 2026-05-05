<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\ActivityLogController;
use App\Models\Stock;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\Sale;
use Illuminate\Http\Request;
use App\Http\Controllers\GcashController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\ContactController;

// ─── Public routes ────────────────────────────────────────────────────────────

Route::get('/', function () {
    return view('homepage');
});

Route::get('/contact-us', function () {
    return view('online_contactUs');
})->name('contact.us');

Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');

Route::get('/locate-address', function () {
    return view('locate_address');
})->name('locate.address');

// Placeholder footer routes
Route::get('/company-information', fn() => 'Company Info — Coming Soon')->name('company.info');
Route::get('/reviews', fn() => 'Reviews — Coming Soon')->name('reviews');
Route::get('/terms-of-service', fn() => 'Terms of Service — Coming Soon')->name('legal.tos');
Route::get('/terms-of-use', fn() => 'Terms of Use — Coming Soon')->name('legal.tou');
Route::get('/privacy-policy', fn() => 'Privacy Policy — Coming Soon')->name('legal.privacy');
Route::get('/forgot-password', fn() => 'Forgot Password — Coming Soon')->name('password.request');

// ─── Customer auth (guest only) ───────────────────────────────────────────────

Route::middleware('guest:customer')->group(function () {
    Route::get('/signup', [CustomerController::class, 'create'])->name('signup.form');
    Route::post('/signup', [CustomerController::class, 'store'])->name('signup.store')->middleware('throttle:5,1');
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
});

// ─── Customer authenticated routes ────────────────────────────────────────────

Route::middleware('auth:customer')->group(function () {
    Route::post('/logout', [CustomerController::class, 'logout'])->name('logout');

    // Profile
    Route::get('/profile', [CustomerController::class, 'show'])->name('profile.show');
    Route::put('/profile', [CustomerController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [CustomerController::class, 'destroy'])->name('profile.destroy');

    // Orders
    Route::get('/order-history', [OrderController::class, 'historyOrders'])->name('orders.history');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::delete('/orders/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');
    Route::get('/orders/{id}/edit', [OrderController::class, 'edit'])->name('orders.edit');
    Route::put('/orders/{id}', [OrderController::class, 'update'])->name('orders.update');
    Route::post('/orders/update-quantities', [OrderController::class, 'updateQuantities'])->name('orders.updateQuantities');
    Route::post('/orders/save-changes', [OrderController::class, 'saveChanges'])->name('orders.saveChanges');
    Route::post('/orders/save', [OrderController::class, 'save'])->name('orders.save');
    Route::post('/orders/confirm', [OrderController::class, 'confirmOrder'])->name('orders.confirm');
    Route::post('/orders/cancel', [OrderController::class, 'cancelOrder'])->name('orders.cancel');
    Route::post('/orders/save-address', [OrderController::class, 'saveAddress'])->name('orders.saveAddress');
    Route::get('/track-orders', [OrderController::class, 'trackOrders'])->name('track.orders');

    // Payment flow
    Route::get('/mode-payment', [OrderController::class, 'modePayment'])->name('mode.payment');
    Route::get('/delivery-details', [OrderController::class, 'deliveryDetails'])->name('delivery.details');
    Route::get('/payment/gcash', function () {
        $subtotal    = session('subtotal', 0);
        $deliveryFee = session('deliveryFee', 50);
        $total       = session('total', $subtotal + $deliveryFee);
        return view('gcash', compact('subtotal', 'deliveryFee', 'total'));
    })->name('gcash.payment');
    Route::post('/gcash/store', [GcashController::class, 'store'])->name('gcash.store');

    // Invoice — auth:customer + ownership check enforced in controller
    Route::get('/invoice/{order}', [OrderController::class, 'invoice'])->name('orders.invoice');
});

// ─── Admin login (guest only) ─────────────────────────────────────────────────

Route::middleware('guest:admin')->group(function () {
    Route::get('/admin-login', [LoginController::class, 'showAdminLoginForm'])->name('admin.login');
    Route::post('/admin-login', [LoginController::class, 'adminLogin'])->name('admin.login.submit');
});

Route::post('/admin/logout', [LoginController::class, 'adminLogout'])->name('admin.logout');

// ─── Admin authenticated routes ───────────────────────────────────────────────

Route::middleware('auth:admin')->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        $dailySales = Sale::whereDate('created_at', today())
            ->with('saleDetails')->get()
            ->flatMap(fn($sale) => $sale->saleDetails)->sum('total_price');

        $monthlyEarnings = Sale::whereMonth('created_at', today()->month)
            ->with('saleDetails')->get()
            ->flatMap(fn($sale) => $sale->saleDetails)->sum('total_price');

        $yearlyEarnings = Sale::whereYear('created_at', today()->year)
            ->with('saleDetails')->get()
            ->flatMap(fn($sale) => $sale->saleDetails)->sum('total_price');

        $pendingOrders = Order::where('order_status', 'Pending')->count();

        return view('admin_index', compact('dailySales', 'monthlyEarnings', 'yearlyEarnings', 'pendingOrders'));
    })->name('dashboard');

    Route::get('/history', fn() => view('admin_history'))->name('history');

    // Orders
    Route::get('/orders', fn() => view('admin_orders'))->name('orders');
    Route::put('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');

    // Stocks (view + full CRUD)
    Route::get('/stocks', function () {
        $stocks = Stock::paginate(10);
        return view('admin.admin_stocks', compact('stocks'));
    })->name('stocks');
    Route::resource('stocks', StockController::class)
        ->only(['create', 'store', 'edit', 'update', 'destroy']);

    // Sales CRUD
    Route::resource('sales', SalesController::class);

    // Sales chart data
    Route::get('/sales-data', function (Request $request) {
        $startDate = $request->query('start_date', now()->startOfMonth()->toDateString());
        $endDate   = $request->query('end_date',   now()->endOfMonth()->toDateString());

        $salesData = DB::table('sales')
            ->join('sale_details', 'sales.sale_id', '=', 'sale_details.sale_id')
            ->whereBetween('sales.created_at', [$startDate, $endDate])
            ->select(DB::raw('DATE(sales.created_at) as date'), DB::raw('SUM(sale_details.total_price) as total_sales'))
            ->groupBy('date')->orderBy('date')->get();

        return response()->json($salesData);
    })->name('sales-data');

    Route::get('/item-sales-data', function (Request $request) {
        $startDate = $request->query('start_date', now()->startOfMonth()->toDateString());
        $endDate   = $request->query('end_date',   now()->endOfMonth()->toDateString());

        $itemSalesData = DB::table('sale_details')
            ->select('product_name', DB::raw('SUM(quantity) as total_quantity'), DB::raw('SUM(total_price) as total_sales'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('product_name')->orderBy('total_sales', 'desc')->get();

        return response()->json($itemSalesData);
    })->name('item-sales-data');

    // Customers (admin management)
    Route::get('/customers', [CustomerController::class, 'index_admin'])->name('customers.index');
    Route::get('/customers/{id}/edit', [CustomerController::class, 'edit_admin'])->name('customers.edit');
    Route::put('/customers/{id}', [CustomerController::class, 'update_admin'])->name('customers.update');

    // Activity Log
    Route::get('/activity-log', [ActivityLogController::class, 'index'])->name('activity-log');
    Route::get('/activity-log/customers', [ActivityLogController::class, 'customers'])->name('activity-log.customers');
    Route::get('/activity-log/customers/{customer}', [ActivityLogController::class, 'customerDetails'])->name('activity-log.customer-details');
    Route::get('/activity-log/customers/{customer}/actions', [ActivityLogController::class, 'customerActions'])->name('activity-log.customer-actions');
    Route::get('/activity-log/orders', [ActivityLogController::class, 'orders'])->name('activity-log.orders');
    Route::get('/activity-log/stocks', [ActivityLogController::class, 'stocks'])->name('activity-log.stocks');
    Route::get('/activity-log/sales', [ActivityLogController::class, 'sales'])->name('activity-log.sales');
    Route::get('/activity-log/stocks/{stock}/actions', [ActivityLogController::class, 'stockActions'])->name('activity-log.stocks.actions');
    Route::get('/activity-log/sales/{sale}/actions', [ActivityLogController::class, 'saleActions'])->name('activity-log.sales.actions');

    // Image Upload
    Route::get('/upload-image', [ImageUploadController::class, 'index'])->name('upload-image');
    Route::post('/upload-image', [ImageUploadController::class, 'upload'])->name('upload-image.store');
    Route::delete('/upload-image/{id}', [ImageUploadController::class, 'delete'])->name('upload-image.delete');
});
<<<<<<< Updated upstream

// Admin Login Routes
Route::get('/admin-login', [LoginController::class, 'showAdminLoginForm'])->name('admin.login')->middleware('guest:admin');
Route::post('/admin-login', [LoginController::class, 'adminLogin'])->name('admin.login.submit');
// Admin logout
Route::post('/admin/logout', [LoginController::class, 'adminLogout'])->name('admin.logout');

Route::get('/', function () {
     return view('homepage');
});
Route::get('/invoice', function () {
     return view('invoice');
});
Route::get('/invoice/{order}', [OrderController::class, 'invoice'])->name('orders.invoice');
Route::get('/contact-us', function () {
     return view('online_contactUs');
})->name('contact.us');

Route::get('/order-history', [OrderController::class, 'historyOrders'])->name('orders.history');


Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::delete('/orders/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');
Route::get('/orders/{id}/edit', [OrderController::class, 'edit'])->name('orders.edit');
Route::put('/orders/{id}', [OrderController::class, 'update'])->name('orders.update');
Route::post('/orders/update-quantities', [OrderController::class, 'updateQuantities'])->name('orders.updateQuantities');
Route::post('/orders/save-changes', [OrderController::class, 'saveChanges'])->name('orders.saveChanges');
Route::post('/orders/save', [OrderController::class, 'save'])->name('orders.save');

Route::post('/orders/confirm', [OrderController::class, 'confirmOrder'])->name('orders.confirm');
Route::post('/orders/cancel', [OrderController::class, 'cancelOrder'])->name('orders.cancel');
Route::post('/orders/save-address', [OrderController::class, 'saveAddress'])->name('orders.saveAddress');

Route::get('/track-orders', [OrderController::class, 'trackOrders'])->name('track.orders');


Route::get('/locate-address', function () {
     return view('locate_address');
})->name('locate.address');

Route::get('/mode-payment', [OrderController::class, 'modePayment'])->name('mode.payment');

Route::get('/delivery-details', [OrderController::class, 'deliveryDetails'])->name('delivery.details');

Route::get('/payment/gcash', function () {
     $subtotal = session('subtotal', 0);
     $deliveryFee = session('deliveryFee', 50);
     $total = session('total', $subtotal + $deliveryFee);

     return view('gcash', compact('subtotal', 'deliveryFee', 'total'));
})->name('gcash.payment');

Route::post('/gcash/store', [GcashController::class, 'store'])->name('gcash.store');
Route::put('/customer/{id}', [CustomerController::class, 'update'])->name('customer.update');



Route::get('/admin/orders', function () {
     return view('admin_orders');
})->name('admin.orders');

Route::put('/admin/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');

// Temporary route to check for null order_datetime values
Route::get('/debug/orders-null-datetime', function () {
     $nullOrders = DB::table('orders')->whereNull('order_datetime')->get();
     return response()->json($nullOrders);
});

// Temporary route to check for Delivered orders
Route::get('/check-delivered-orders', function () {
     $deliveredOrders = Order::where('order_status', 'Delivered')->get();
     return response()->json($deliveredOrders);
});

// Sales routes
Route::resource('sales', SalesController::class);

Route::get('/admin/sales-data', function (Request $request) {
     $startDate = $request->query('start_date');
     $endDate = $request->query('end_date');

     // Default to the current month if no dates are provided
     if (!$startDate || !$endDate) {
          $startDate = now()->startOfMonth()->toDateString();
          $endDate = now()->endOfMonth()->toDateString();
     }

     // Fetch sales data grouped by day
     $salesData = DB::table('sales')
          ->join('sale_details', 'sales.sale_id', '=', 'sale_details.sale_id')
          ->whereBetween('sales.created_at', [$startDate, $endDate])
          ->select(DB::raw('DATE(sales.created_at) as date'), DB::raw('SUM(sale_details.total_price) as total_sales'))
          ->groupBy('date')
          ->orderBy('date')
          ->get();

     return response()->json($salesData);
})->name('admin.sales-data');

Route::get('/admin/item-sales-data', function (Request $request) {
     $startDate = $request->query('start_date');
     $endDate = $request->query('end_date');

     // Default to the current month if no dates are provided
     if (!$startDate || !$endDate) {
          $startDate = now()->startOfMonth()->toDateString();
          $endDate = now()->endOfMonth()->toDateString();
     }

     // Fetch item sales data grouped by product name
     $itemSalesData = DB::table('sale_details')
          ->select('product_name', DB::raw('SUM(quantity) as total_quantity'), DB::raw('SUM(total_price) as total_sales'))
          ->whereBetween('created_at', [$startDate, $endDate])
          ->groupBy('product_name')
          ->orderBy('total_sales', 'desc')
          ->get();

     return response()->json($itemSalesData);
})->name('admin.item-sales-data');

// Activity Log Routes
Route::get('/admin/activity-log', [ActivityLogController::class, 'index'])->name('admin.activity-log');
Route::get('/admin/activity-log/customers', [ActivityLogController::class, 'customers'])->name('admin.activity-log.customers');
Route::get('/admin/activity-log/customers/{customer}', [ActivityLogController::class, 'customerDetails'])->name('admin.activity-log.customer-details');
Route::get('/admin/activity-log/customers/{customer}/actions', [ActivityLogController::class, 'customerActions'])->name('admin.activity-log.customer-actions');
Route::get('/admin/activity-log/orders', [ActivityLogController::class, 'orders'])->name('admin.activity-log.orders');
Route::get('/admin/activity-log/stocks', [ActivityLogController::class, 'stocks'])->name('admin.activity-log.stocks');
Route::get('/admin/activity-log/sales', [ActivityLogController::class, 'sales'])->name('admin.activity-log.sales');
Route::get('/admin/activity-log/lockout', [ActivityLogController::class, 'lockoutLogs'])->name('admin.activity-log.lockout');
Route::get('/admin/activity-log/stocks/{stock}/actions', [ActivityLogController::class, 'stockActions'])->name('admin.activity-log.stocks.actions');
Route::get('/admin/activity-log/sales/{sale}/actions', [ActivityLogController::class, 'saleActions'])->name('admin.activity-log.sales.actions');


// Image Upload Routes
Route::get('/admin/upload-image', [ImageUploadController::class, 'index'])->name('admin.upload-image');
Route::post('/admin/upload-image', [ImageUploadController::class, 'upload'])->name('admin.upload-image.store');
Route::delete('/admin/upload-image/{id}', [ImageUploadController::class, 'delete'])->name('admin.upload-image.delete');

//Placeholder routes for some of those footer navigation stuff

Route::get('/company-information', fn() => 'Company Info — Coming Soon')
     ->name('company.info');

Route::get('/reviews', fn() => 'Reviews — Coming Soon')
     ->name('reviews');

Route::get('/terms-of-service', fn() => 'Terms of Service — Coming Soon')
     ->name('legal.tos');

Route::get('/terms-of-use', fn() => 'Terms of Use — Coming Soon')
     ->name('legal.tou');

Route::get('/privacy-policy', fn() => 'Privacy Policy — Coming Soon')
     ->name('legal.privacy');


Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');
=======
>>>>>>> Stashed changes
