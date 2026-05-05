@extends('layouts.admin')

@section('title', 'Orders')

@section('content')
<div class="card shadow">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table my-0" id="dataTable">
                <thead>
                    <tr>
                        <th>Order</th>
                        <th>Customer</th>
                        <th>Delivery Details</th>
                        <th>Order Summary</th>
                        <th>Payment Information</th>
                        <th>Status</th>
                    </tr>
                </thead>
                @php
                    use App\Models\Order;
                    $orders = Order::with(['customer', 'orderDetails.stock', 'paymentMethod', 'gcashDetail'])
                        ->whereNotIn('order_status', ['Delivered', 'Cancelled'])
                        ->orderByDesc('order_datetime')
                        ->paginate(10);
                @endphp
                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td>
                                @if ($order->order_datetime)
                                    {{ $order->order_datetime->timezone('Asia/Manila')->format('F d, Y') }}<br>
                                    {{ $order->order_datetime->timezone('Asia/Manila')->format('h:i A') }}
                                @else
                                    <span class="text-danger">Invalid Date</span>
                                @endif
                            </td>
                            <td>{{ $order->customer->name }}</td>
                            <td>{{ $order->customer->address }}<br>{{ $order->customer->phone }}</td>
                            <td>
                                @foreach ($order->orderDetails as $detail)
                                    {{ $detail->quantity }} x {{ $detail->stock->product_name }}<br>
                                @endforeach
                                <strong>Subtotal:</strong> ₱{{ number_format($order->calculateTotalPrice(), 2) }}<br>
                                <strong>Delivery Fee:</strong> ₱{{ number_format($order->delivery_fee ?? 0, 2) }}<br>
                                <strong>Total:</strong> ₱{{ number_format($order->amount_paid, 2) }}
                            </td>
                            <td>
                                <strong>Payment Method:</strong> {{ $order->paymentMethod->method_name ?? 'N/A' }}<br>
                                <strong>Transaction Ref:</strong>
                                @if ($order->payment_method_id === 2)
                                    @if ($order->gcashDetail && $order->gcashDetail->image)
                                        <a href="{{ asset('storage/' . $order->gcashDetail->image) }}" target="_blank">View GCash Receipt</a>
                                    @else
                                        N/A
                                    @endif
                                @else
                                    {{ $order->transaction_reference ?? 'N/A' }}
                                @endif
                            </td>
                            <td>
                                @php
                                    $badgeColor = match($order->order_status) {
                                        'Pending'          => '#f6c23e',
                                        'Out for Delivery' => '#4ac9b0',
                                        'Delivered'        => '#1cc88a',
                                        'Cancelled'        => '#e74a3b',
                                        default            => '#aaa',
                                    };
                                @endphp
                                <span class="badge mb-2 d-inline-block"
                                    style="background:{{ $badgeColor }};color:#fff;font-size:.72rem;padding:.35rem .7rem;border-radius:20px;">
                                    {{ $order->order_status }}
                                </span>
                                <form method="POST" action="{{ route('admin.orders.updateStatus', $order->order_id) }}">
                                    @csrf
                                    @method('PUT')
                                    <select name="order_status" class="form-select form-select-sm status-select">
                                        <option value="Pending"          {{ $order->order_status == 'Pending'          ? 'selected' : '' }}>Pending</option>
                                        <option value="Out for Delivery" {{ $order->order_status == 'Out for Delivery' ? 'selected' : '' }}>Out for Delivery</option>
                                        <option value="Delivered"        {{ $order->order_status == 'Delivered'        ? 'selected' : '' }}>Delivered</option>
                                        <option value="Cancelled"        {{ $order->order_status == 'Cancelled'        ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center">No orders found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center mt-3">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script nonce="{{ csp_nonce() }}">
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.status-select').forEach(function (select) {
            select.addEventListener('change', function () {
                this.closest('form').submit();
            });
        });
    });
</script>
<script nonce="{{ csp_nonce() }}" src="{{ asset('h2whoa_admin/assets/js/theme.js') }}"></script>
@endpush
