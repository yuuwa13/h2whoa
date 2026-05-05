<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // All boundaries in Manila time — matches how PHP stores datetimes to MySQL
        $manila = Carbon::now('Asia/Manila');

        $dayStart   = $manila->copy()->startOfDay()->toDateTimeString();
        $dayEnd     = $manila->copy()->endOfDay()->toDateTimeString();

        $monthStart = $manila->copy()->startOfMonth()->startOfDay()->toDateTimeString();
        $monthEnd   = $manila->copy()->endOfMonth()->endOfDay()->toDateTimeString();

        $yearStart  = $manila->copy()->startOfYear()->startOfDay()->toDateTimeString();
        $yearEnd    = $manila->copy()->endOfYear()->endOfDay()->toDateTimeString();

        // Daily: today in Manila time only
        $dailySales = DB::table('sales')
            ->join('orders', 'sales.order_id', '=', 'orders.order_id')
            ->whereBetween('sales.created_at', [$dayStart, $dayEnd])
            ->sum('orders.amount_paid');

        // Monthly: current month in Manila time only
        $monthlyEarnings = DB::table('sales')
            ->join('orders', 'sales.order_id', '=', 'orders.order_id')
            ->whereBetween('sales.created_at', [$monthStart, $monthEnd])
            ->sum('orders.amount_paid');

        // Annual: current year in Manila time only
        $yearlyEarnings = DB::table('sales')
            ->join('orders', 'sales.order_id', '=', 'orders.order_id')
            ->whereBetween('sales.created_at', [$yearStart, $yearEnd])
            ->sum('orders.amount_paid');

        // Count Pending Orders
        $pendingOrders = Order::where('order_status', 'Pending')->count();

        return view('admin_index', [
            'dailySales' => $dailySales,
            'monthlyEarnings' => $monthlyEarnings,
            'yearlyEarnings' => $yearlyEarnings,
            'pendingOrders' => $pendingOrders,
        ]);
    }
}
