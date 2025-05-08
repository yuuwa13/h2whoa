<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Stock;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActivityLogController extends Controller
{
    public function index()
    {
        return view('activity-log.index');
    }

    public function customers()
    {
        $customers = Customer::paginate(10);
        return view('activity-log.customers', compact('customers'));
    }

    public function customerDetails(Customer $customer)
    {
        $orders = $customer->orders()->with('orderDetails.stock')->paginate(10);
        return view('activity-log.customer-details', compact('customer', 'orders'));
    }

    public function customerActions(Customer $customer)
    {
        $actions = $customer->editLogs;
        return view('activity-log.customer-actions', compact('customer', 'actions'));
    }

    public function orders()
    {
        $orders = Order::with('customer')->paginate(10);
        return view('activity-log.orders', compact('orders'));
    }

    public function stocks()
    {
        $stocks = Stock::paginate(10);
        return view('activity-log.stocks', compact('stocks'));
    }

    public function sales()
    {
        $sales = Sale::with('saleDetails')->paginate(10);
        return view('activity-log.sales', compact('sales'));
    }

    public function stockActions($stockId)
    {
        $logs = DB::table('activity_logs')
            ->where('model_type', 'Stock')
            ->where('model_id', $stockId)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('activity-log.stock-actions', compact('logs'));
    }

    public function saleActions($saleId)
    {
        $logs = DB::table('activity_logs')
            ->where('model_type', 'Sale')
            ->where('model_id', $saleId)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('activity-log.sale-actions', compact('logs'));
    }
}