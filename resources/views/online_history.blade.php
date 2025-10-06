@extends('layouts.app')

@section('title', 'History')

@push('styles')
    {{-- Any additional styles specific to history page --}}
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/css/Billing-Table-with-Add-Row--Fixed-Header-Feature.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/css/Ludens---1-Index-Table-with-Search--Sort-Filters-v20.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.2/css/theme.bootstrap_4.min.css">
@endpush

@section('content')
<main class="page faq-page">
    <section class="clean-block clean-faq dark">
        <div class="container">
            <div class="block-heading"></div>
            <div class="row">
                @foreach($orders as $order)
                    <div class="col-md-6 col-lg-4">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h4 class="card-title">Order Number: {{ $order->order_id }}</h4>
                                <p class="card-text fw-bold mb-3">
                                    Order Status:
                                    @if($order->order_status === 'Delivered')
                                        <span class="text-primary">{{ $order->order_status }}</span>
                                    @elseif($order->order_status === 'Cancelled')
                                        <span class="text-danger">{{ $order->order_status }}</span>
                                    @else
                                        <span class="text-muted">{{ $order->order_status }}</span>
                                    @endif
                                </p>
                                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                    data-bs-target="#orderModal{{ $order->order_id }}">
                                    View Order
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="orderModal{{ $order->order_id }}" tabindex="-1"
                        aria-labelledby="orderModalLabel{{ $order->order_id }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Order Details - #{{ $order->order_id }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>
                                        <strong>Customer Name:</strong> {{ $order->customer_name }}<br>
                                        <strong>Contact Number:</strong> {{ $order->customer_phone }}<br>
                                        <strong>Delivery Address:</strong> {{ $order->customer_address }}<br>
                                        <strong>Order Date:</strong> {{ $order->order_datetime }}<br>
                                        <strong>Mode of Payment:</strong>
                                        @if($order->payment_method_id == 1)
                                            Cash on Delivery (COD)
                                        @elseif($order->payment_method_id == 2)
                                            Online Payment (GCash)
                                        @endif
                                        <br>
                                        <strong>Order Details:</strong><br>
                                        @foreach($order->orderDetails as $detail)
                                            {{ $detail->quantity }} x {{ $detail->stock->product_name }}<br>
                                        @endforeach
                                        <strong>Subtotal:</strong>
                                        ₱{{ number_format($order->orderDetails->sum('total_price'), 2) }}<br>
                                        <strong>Delivery Fee:</strong> ₱50.00<br>
                                        <strong>Total Amount:</strong> ₱{{ number_format($order->amount_paid, 2) }}<br>
                                    </p>
                                    <a href="{{ route('orders.invoice', $order->order_id) }}" target="_blank"
                                        class="btn btn-secondary mb-2">
                                        <i class="fa fa-print"></i> Print Invoice
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</main>
@endsection

@push('scripts')
    {{-- Page-specific scripts --}}
    <script src="{{ asset('h2whoa_user/assets/js/Billing-Table-with-Add-Row--Fixed-Header-Feature-Billing-Table-with-Add-Row--Fixed-Header.js') }}"></script>
    <script src="{{ asset('h2whoa_user/assets/js/Map-Location-5-script.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.2/js/jquery.tablesorter.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.2/js/widgets/widget-filter.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.2/js/widgets/widget-storage.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
@endpush
