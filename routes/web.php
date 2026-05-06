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
use App\Http\Controllers\AdminMfaController;

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
    Route::get('/payment/gcash', [OrderController::class, 'gcashPayment'])->name('gcash.payment');
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

// ─── Admin MFA (session-gated, not guard-gated) ───────────────────────────────

Route::get('/admin/mfa', [AdminMfaController::class, 'show'])->name('admin.mfa');
Route::post('/admin/mfa', [AdminMfaController::class, 'verify'])->middleware('throttle:10,1')->name('admin.mfa.verify');

// ─── Admin authenticated routes ───────────────────────────────────────────────

Route::middleware(['auth:admin', 'ensure.admin.mfa'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        // Join sales → orders to sum amount_paid (includes product subtotal + tax + delivery fee).
        // sales.created_at is set when the order is marked Delivered, so it represents the delivery date.

        $dailySales = DB::table('sales')
            ->join('orders', 'sales.order_id', '=', 'orders.order_id')
            ->whereDate('sales.created_at', today())
            ->sum('orders.amount_paid');

        $monthlyEarnings = DB::table('sales')
            ->join('orders', 'sales.order_id', '=', 'orders.order_id')
            ->whereYear('sales.created_at', now()->year)
            ->whereMonth('sales.created_at', now()->month)
            ->sum('orders.amount_paid');

        $yearlyEarnings = DB::table('sales')
            ->join('orders', 'sales.order_id', '=', 'orders.order_id')
            ->whereYear('sales.created_at', now()->year)
            ->sum('orders.amount_paid');

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
        $groupBy   = $request->query('group_by', 'day'); // 'day' or 'month'

        // Keep in Manila time — matches how PHP/Eloquent writes datetimes to MySQL
        $start = \Carbon\Carbon::parse($startDate, 'Asia/Manila')->startOfDay();
        $end   = \Carbon\Carbon::parse($endDate,   'Asia/Manila')->endOfDay();

        if ($groupBy === 'month') {
            // Group by month — query
            $rows = DB::table('sales')
                ->join('orders', 'sales.order_id', '=', 'orders.order_id')
                ->whereBetween('sales.created_at', [$start, $end])
                ->select(
                    DB::raw("DATE_FORMAT(sales.created_at, '%Y-%m') as period"),
                    DB::raw('SUM(orders.amount_paid) as total_sales')
                )
                ->groupBy('period')->orderBy('period')->get()
                ->keyBy('period');

            // Zero-fill every month in the range — cursor starts at startDate's month
            $result = [];
            $cursor = \Carbon\Carbon::parse($startDate, 'Asia/Manila')->startOfMonth();
            $finish = \Carbon\Carbon::parse($endDate,   'Asia/Manila')->endOfMonth();
            while ($cursor->lte($finish)) {
                $key = $cursor->format('Y-m');
                $result[] = [
                    'date'        => $cursor->format('M Y'),
                    'total_sales' => isset($rows[$key]) ? (float) $rows[$key]->total_sales : 0,
                ];
                $cursor->addMonth();
            }
        } else {
            // Group by day — query
            $rows = DB::table('sales')
                ->join('orders', 'sales.order_id', '=', 'orders.order_id')
                ->whereBetween('sales.created_at', [$start, $end])
                ->select(
                    DB::raw('DATE(sales.created_at) as period'),
                    DB::raw('SUM(orders.amount_paid) as total_sales')
                )
                ->groupBy('period')->orderBy('period')->get()
                ->keyBy('period');

            // Zero-fill every day in the range — cursor starts at startDate exactly
            $result = [];
            $cursor = \Carbon\Carbon::parse($startDate, 'Asia/Manila')->startOfDay();
            $finish = \Carbon\Carbon::parse($endDate,   'Asia/Manila')->endOfDay();
            while ($cursor->lte($finish)) {
                $key = $cursor->toDateString();
                $result[] = [
                    'date'        => $cursor->format('M d'),
                    'total_sales' => isset($rows[$key]) ? (float) $rows[$key]->total_sales : 0,
                ];
                $cursor->addDay();
            }
        }

        return response()->json($result);
    })->name('sales-data');

    Route::get('/item-sales-data', function (Request $request) {
        $startDate = $request->query('start_date', now()->startOfMonth()->toDateString());
        $endDate   = $request->query('end_date',   now()->endOfMonth()->toDateString());

        // Aggregate sales for the period
        $itemStart = \Carbon\Carbon::parse($startDate, 'Asia/Manila')->startOfDay();
        $itemEnd   = \Carbon\Carbon::parse($endDate,   'Asia/Manila')->endOfDay();

        $salesMap = DB::table('sale_details')
            ->select('product_name', DB::raw('SUM(quantity) as total_quantity'), DB::raw('SUM(total_price) as total_sales'))
            ->whereBetween('created_at', [$itemStart, $itemEnd])
            ->groupBy('product_name')
            ->get()
            ->keyBy('product_name');

        // All products from stocks — zero-fill missing ones
        $itemSalesData = DB::table('stocks')
            ->orderBy('product_name')
            ->pluck('product_name')
            ->map(function ($name) use ($salesMap) {
                $row = $salesMap->get($name);
                return [
                    'product_name'   => $name,
                    'total_quantity' => $row ? (int)   $row->total_quantity : 0,
                    'total_sales'    => $row ? (float) $row->total_sales    : 0.0,
                ];
            })
            ->sortByDesc('total_quantity')
            ->values();

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
    Route::get('/activity-log/lockout', [ActivityLogController::class, 'lockoutLogs'])->name('activity-log.lockout');

    // Image Upload
    Route::get('/upload-image', [ImageUploadController::class, 'index'])->name('upload-image');
    Route::post('/upload-image', [ImageUploadController::class, 'upload'])->name('upload-image.store');
    Route::delete('/upload-image/{id}', [ImageUploadController::class, 'delete'])->name('upload-image.delete');
});
