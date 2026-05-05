@extends('layouts.admin')

@section('title', 'History')

@section('content')
<div class="card shadow">
    <div class="card-body">
        <div class="table-responsive">
            @php
                use App\Models\Order;
                $orders = Order::whereIn('order_status', ['Delivered', 'Cancelled'])
                    ->orderByDesc('order_datetime')
                    ->paginate(10);
            @endphp
            <table class="table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Delivery Details</th>
                        <th>Order Summary</th>
                        <th>Payment Information</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td>
                                {{ $order->order_id }}<br>
                                @if ($order->order_datetime)
                                    {{ $order->order_datetime->timezone('Asia/Manila')->format('F d, Y') }}<br>
                                    {{ $order->order_datetime->timezone('Asia/Manila')->format('h:i A') }}
                                @else
                                    <span class="text-danger">Invalid Date</span>
                                @endif
                            </td>
                            <td>{{ $order->customer->name }}<br>{{ $order->customer->phone }}<br>{{ $order->customer->address }}</td>
                            <td>{{ $order->delivery_details ?? 'N/A' }}</td>
                            <td>
                                @foreach ($order->orderDetails as $detail)
                                    {{ $detail->quantity }} x {{ $detail->stock->product_name }}<br>
                                @endforeach
                                <strong>Subtotal:</strong> ₱{{ number_format($order->calculateTotalPrice(), 2) }}<br>
                                <strong>Delivery Fee:</strong> ₱{{ number_format($order->delivery_fee ?? 0, 2) }}<br>
                                <strong>Total:</strong> ₱{{ number_format($order->amount_paid, 2) }}
                            </td>
                            <td>
                                <strong>Payment Method:</strong> {{ $order->payment_method->method_name ?? 'N/A' }}<br>
                                <strong>Transaction Ref:</strong> {{ $order->transaction_reference ?? 'N/A' }}
                            </td>
                            <td>
                                <strong>{{ $order->order_status }}</strong><br>
                                @if ($order->updated_at)
                                    <small>{{ $order->updated_at->timezone('Asia/Manila')->format('F d, Y h:i A') }}</small>
                                @else
                                    <small class="text-danger">No Update Time</small>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center">No orders found.</td></tr>
                    @endforelse
                </tbody>
            </table>
            <div class="d-flex justify-content-center mt-3">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script nonce="{{ csp_nonce() }}" src="{{ asset('h2whoa_admin/assets/js/theme.js') }}"></script>
@endpush
