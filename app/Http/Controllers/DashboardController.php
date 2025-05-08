<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Sale;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Calculate Daily Sales
        $dailySales = Sale::whereDate('created_at', Carbon::today())->sum('saleDetails.total_price');

        // Calculate Monthly Earnings
        $monthlyEarnings = Sale::whereMonth('created_at', Carbon::now()->month)->sum('saleDetails.total_price');

        // Calculate Yearly Earnings
        $yearlyEarnings = Sale::whereYear('created_at', Carbon::now()->year)->sum('saleDetails.total_price');

        // Count Pending Orders
        $pendingOrders = Order::where('order_status', 'pending')->count();

        return view('admin_index', [
            'dailySales' => $dailySales,
            'monthlyEarnings' => $monthlyEarnings,
            'yearlyEarnings' => $yearlyEarnings,
            'pendingOrders' => $pendingOrders,
        ]);
    }
}
