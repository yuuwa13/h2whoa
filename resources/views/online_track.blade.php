{{-- resources/views/online_track.blade.php --}}
@extends('layouts.app')

@section('title', 'Track')

@push('styles')
    {{-- Only include styles specific to this page --}}
    <link rel="stylesheet"
        href="{{ asset('h2whoa_user/assets/css/Billing-Table-with-Add-Row--Fixed-Header-Feature.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/css/Company-Invoice.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/css/Map-Location-5-styles.min.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/css/vanilla-zoom.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endpush

@section('content')
    @if(session('delivery_confirmed'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Delivery Confirmed',
                    text: '{{ session('delivery_confirmed') }}',
                    toast: true,
                    position: 'bottom-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });
            });
        </script>
    @endif

    <div class="flex-grow-1"> {{-- This helps push footer down --}}
        <main class="page service-page">
            <section class="clean-block clean-services dark">
                <div class="container" style="margin-top: 100px;">
                    {{-- Centered Header --}}
                    <div class="block-heading text-center">
                        <h2 class="text-info">Delivery Status</h2>
                        <p><strong>Note:</strong> Once your order status is marked as <strong>"Out for Delivery,"</strong>
                            any changes or modifications to your order will no longer be accepted.</p>
                    </div>

                    <div class="row">
                        @foreach($orders as $order)
                            @php
                                $snapshot = session("order_snapshot_{$order->order_id}");
                            @endphp
                            <div class="col-md-6 col-lg-4">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <h4 class="card-title">Order Number: {{ $order->order_id }}</h4>
                                        <p class="card-text" style="font-size: 1rem; font-weight: bold; margin-bottom: 1rem;">
                                            Order Status:
                                            <span style="color: #4ac9b0;">{{ $order->order_status }}</span>
                                        </p>
                                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                            data-bs-target="#orderModal{{ $order->order_id }}">
                                            View Order
                                        </button>
                                    </div>
                                </div>
                            </div>

                            {{-- Modal --}}
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
                                                <strong>Delivery Fee:</strong> ₱{{ number_format($order->delivery_fee ?? 20, 2) }}<br>
                                                <strong>Total Amount:</strong> ₱{{ number_format($order->amount_paid, 2) }}<br>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        </main>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('h2whoa_user/assets/js/Map-Location-5-script.min.js') }}"></script>
    <script src="{{ asset('h2whoa_user/assets/js/vanilla-zoom.js') }}"></script>
@endpush