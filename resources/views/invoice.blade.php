<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Invoice</title>
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins&amp;display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body {
            background: #f8f9fa;
        }

        .invoice-box {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
        }
        /* Hide print button when printing */
        @media print {
            .no-print { display: none !important; }
        }
        /* Themed print button */
        .btn-print-theme {
            background: #4ac9b0; /* light blue theme */
            color: #fff;
            border: none;
        }
        .btn-print-theme .fa-print {
            color: #fff;
        }
    </style>
</head>

<body>
    <div class="page-content container">
        <div class="page-header text-blue-d2">
            <h1 class="page-title text-secondary-d1">
                Invoice
                <small class="page-info">
                    <i class="fa fa-angle-double-right text-80"></i>
                    ID: #{{ $order->order_id }}
                </small>
            </h1>
            <div class="page-tools">
                <div class="action-buttons">
                    <!-- Print button: styled to match theme and hidden in printed/PDF view -->
                    <a class="btn btn-print-theme no-print mx-1px text-95" href="#" onclick="window.print()"
                        data-title="Print" role="button">
                        <i class="mr-1 fa fa-print text-120 w-2"></i>
                        Print
                    </a>
                </div>
            </div>
        </div>
        <div class="container px-0 invoice-box">
            <div class="row mt-4">
                <div class="col-12 col-lg-10 offset-lg-1">
                    <div class="row">
                        <div class="col-12">
                            <div class="text-center d-flex justify-content-center align-items-center mb-3">
                                <img src="{{ asset('h2whoa_user/assets/img/elements/h2whoa_logo.png') }}"
                                    alt="H2WHOA Logo" style="max-width: 60px; height: auto; margin-right: 10px;">
                                <span class="text-default-d3 text-150 font-weight-bold">H2WHOA</span>
                            </div>
                        </div>
                    </div>
                    <hr class="row brc-default-l1 mx-n1 mb-4" />
                    <div class="row">
                        <div class="col-sm-6">
                            <div>
                                <span class="text-sm text-grey-m2 align-middle">To:</span>
                                <span
                                    class="text-600 text-110 text-blue align-middle">{{ $order->customer_name }}</span>
                            </div>
                            <div class="text-grey-m2">
                                <div class="my-1">{{ $order->customer_address }}</div>
                                <div class="my-1"><i class="fa fa-phone fa-flip-horizontal text-secondary"></i> <b
                                        class="text-600">{{ $order->customer_phone }}</b></div>
                            </div>
                        </div>
                        <div class="text-95 col-sm-6 align-self-start d-sm-flex justify-content-end">
                            <hr class="d-sm-none" />
                            <div class="text-grey-m2">
                                <div class="mt-1 mb-2 text-secondary-m1 text-600 text-125">
                                    Invoice
                                </div>
                                <div class="my-2"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span
                                        class="text-600 text-90">ID:</span> #{{ $order->order_id }}</div>
                                <div class="my-2"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span
                                        class="text-600 text-90">Issue Date:</span>
                                    {{ \Carbon\Carbon::parse($order->order_datetime)->format('M d, Y') }}</div>
                                <div class="my-2"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span
                                        class="text-600 text-90">Status:</span>
                                    <span class="badge 
                                                @if($order->order_status === 'Delivered') bg-success
                                                @elseif($order->order_status === 'Cancelled') bg-danger
                                                     @else bg-warning text-dark
                                                 @endif
                                            ">
                                        {{ $order->order_status }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="row text-600 text-white bgc-default-tp1 py-25">
                            <div class="d-none d-sm-block col-1">#</div>
                            <div class="col-9 col-sm-5">Description</div>
                            <div class="d-none d-sm-block col-4 col-sm-2">Qty</div>
                            <div class="d-none d-sm-block col-sm-2">Unit Price</div>
                            <div class="col-2">Amount</div>
                        </div>
                        <div class="text-95 text-secondary-d3">
                            @foreach($order->orderDetails as $i => $detail)
                                <div class="row mb-2 mb-sm-0 py-25 {{ $i % 2 == 1 ? 'bgc-default-l4' : '' }}">
                                    <div class="d-none d-sm-block col-1">{{ $i + 1 }}</div>
                                    <div class="col-9 col-sm-5">{{ $detail->stock->product_name }}</div>
                                    <div class="d-none d-sm-block col-2">{{ $detail->quantity }}</div>
                                    <div class="d-none d-sm-block col-2 text-95">
                                        ₱{{ number_format($detail->price_per_unit, 2) }}
                                    </div>
                                    <div class="col-2 text-secondary-d2">
                                        ₱{{ number_format($detail->total_price, 2) }}
                                    </div>
                                </div>
                            @endforeach
                            <div class="row mb-2 mb-sm-0 py-25 bgc-default-l4">
                                <div class="d-none d-sm-block col-1"></div>
                                <div class="col-9 col-sm-5">Delivery Charge</div>
                                <div class="d-none d-sm-block col-2"></div>
                                <div class="d-none d-sm-block col-2 text-95"></div>
                                <div class="col-2 text-secondary-d2">₱{{ number_format($order->delivery_fee ?? 50, 2) }}
                                </div>
                            </div>
                        </div>
                        <div class="row border-b-2 brc-default-l2"></div>
                        <div class="row mt-3">
                            <div class="col-12 col-sm-7 text-grey-d2 text-95 mt-2 mt-lg-0">
                                Thank you for choosing H2WHOA!
                            </div>
                            <div class="col-12 col-sm-5 text-grey text-90 order-first order-sm-last">
                                @php
                                    $subtotal = $order->orderDetails->sum('total_price');
                                    $tax = $subtotal * 0.12; // 12% tax
                                @endphp

                                <div class="row my-2">
                                    <div class="col-7 text-right">SubTotal</div>
                                    <div class="col-5"><span
                                            class="text-120 text-secondary-d1">₱{{ number_format($subtotal, 2) }}</span>
                                    </div>
                                </div>
                                <div class="row my-2">
                                    <div class="col-7 text-right">Tax (12%)</div>
                                    <div class="col-5"><span
                                            class="text-120 text-secondary-d1">₱{{ number_format($tax, 2) }}</span>
                                    </div>
                                </div>

                                <div class="row my-2 align-items-center bgc-primary-l3 p-2">
                                    <div class="col-7 text-right">Total Amount</div>
                                    <div class="col-5"><span
                                            class="text-150 text-success-d3 opacity-2">₱{{ number_format($order->amount_paid, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr />
                        <div>
                            <span class="text-secondary-d1 text-105">Thank you for choosing H2WHOA!</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('h2whoa_user/assets/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('h2whoa_user/assets/js/baguetteBox.min.js') }}"></script>
    <script src="{{ asset('h2whoa_user/assets/js/vanilla-zoom.js') }}"></script>
    <script src="{{ asset('h2whoa_user/assets/js/theme.js') }}"></script>
    <script
        src="{{ asset('h2whoa_user/assets/js/Billing-Table-with-Add-Row--Fixed-Header-Feature-Billing-Table-with-Add-Row--Fixed-Header.js') }}"></script>
    <script src="{{ asset('h2whoa_user/assets/js/Contact-Form-v2-Modal--Full-with-Google-Map-scripts.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.2/js/jquery.tablesorter.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.2/js/widgets/widget-filter.min.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.2/js/widgets/widget-storage.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="{{ asset('h2whoa_user/assets/js/Map-Location-5-script.min.js') }}"></script>
</body>

</html>