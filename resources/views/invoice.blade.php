<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Invoice #{{ $order->order_id }}</title>
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style nonce="{{ csp_nonce() }}">
        * { font-family: 'Poppins', sans-serif; }

        body { background: #eef2f7; }

        .invoice-wrapper {
            max-width: 820px;
            margin: 40px auto;
        }

        /* Action bar above the invoice card */
        .action-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }

        .action-bar .invoice-label {
            font-size: 1.1rem;
            font-weight: 600;
            color: #555;
        }

        /* Main invoice card */
        .invoice-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
            overflow: hidden;
        }

        /* Teal header band */
        .invoice-header {
            background: linear-gradient(135deg, #4ac9b0 0%, #38b89e 100%);
            padding: 32px 40px;
            color: #fff;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .invoice-header .brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .invoice-header .brand img {
            width: 52px;
            height: 52px;
            object-fit: contain;
            background: rgba(255,255,255,0.2);
            border-radius: 10px;
            padding: 4px;
        }

        .invoice-header .brand-name {
            font-size: 1.6rem;
            font-weight: 700;
            letter-spacing: 1px;
        }

        .invoice-header .brand-tagline {
            font-size: 0.78rem;
            opacity: 0.85;
            margin-top: 2px;
        }

        .invoice-header .invoice-meta {
            text-align: right;
        }

        .invoice-header .invoice-meta .inv-title {
            font-size: 1.8rem;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .invoice-header .invoice-meta .inv-id {
            font-size: 0.85rem;
            opacity: 0.85;
            margin-top: 4px;
        }

        /* Body padding */
        .invoice-body {
            padding: 36px 40px;
        }

        /* Bill to / Invoice info row */
        .info-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 32px;
            gap: 20px;
        }

        .bill-to-label {
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #4ac9b0;
            margin-bottom: 6px;
        }

        .bill-to-name {
            font-size: 1.05rem;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 4px;
        }

        .bill-to-detail {
            font-size: 0.85rem;
            color: #718096;
            margin-bottom: 3px;
        }

        .inv-info-table td {
            font-size: 0.85rem;
            padding: 3px 0;
            color: #718096;
        }

        .inv-info-table td:first-child {
            font-weight: 600;
            color: #4a5568;
            padding-right: 16px;
            white-space: nowrap;
        }

        /* Status badge */
        .status-badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .status-delivered { background: #d4edda; color: #1a7c3e; }
        .status-cancelled { background: #f8d7da; color: #842029; }
        .status-pending   { background: #fff3cd; color: #856404; }

        /* Items table */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }

        .items-table thead tr {
            background: #4ac9b0;
            color: #fff;
        }

        .items-table thead th {
            padding: 12px 16px;
            font-size: 0.78rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .items-table tbody tr {
            border-bottom: 1px solid #f0f0f0;
        }

        .items-table tbody tr:last-child {
            border-bottom: none;
        }

        .items-table tbody tr:nth-child(even) {
            background: #f9fafb;
        }

        .items-table tbody td {
            padding: 13px 16px;
            font-size: 0.875rem;
            color: #4a5568;
        }

        .items-table tfoot tr {
            border-top: 2px solid #e2e8f0;
        }

        .items-table tfoot td {
            padding: 12px 16px;
            font-size: 0.875rem;
            color: #718096;
            font-style: italic;
        }

        /* Totals */
        .totals-section {
            display: flex;
            justify-content: flex-end;
            margin-top: 8px;
        }

        .totals-box {
            width: 280px;
        }

        .totals-row {
            display: flex;
            justify-content: space-between;
            padding: 7px 0;
            font-size: 0.875rem;
            color: #718096;
            border-bottom: 1px dashed #e8e8e8;
        }

        .totals-row:last-child {
            border-bottom: none;
        }

        .totals-row.total-final {
            background: #f0faf8;
            border: 1px solid #4ac9b0;
            border-radius: 8px;
            padding: 10px 14px;
            margin-top: 8px;
            color: #2d3748;
            font-weight: 700;
            font-size: 1rem;
        }

        .totals-row.total-final .total-amount {
            color: #4ac9b0;
            font-size: 1.15rem;
        }

        /* Footer */
        .invoice-footer {
            margin-top: 36px;
            padding-top: 20px;
            border-top: 1px dashed #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .invoice-footer .thank-you {
            font-size: 0.9rem;
            color: #718096;
        }

        .invoice-footer .thank-you strong {
            color: #4ac9b0;
        }

        /* Buttons */
        .btn-invoice {
            background: #4ac9b0;
            color: #fff;
            border: none;
            padding: 8px 18px;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 500;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: background 0.2s;
        }

        .btn-invoice:hover { background: #38b89e; }

        .btn-invoice-outline {
            background: #fff;
            color: #4ac9b0;
            border: 1.5px solid #4ac9b0;
            padding: 8px 18px;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 500;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s;
        }

        .btn-invoice-outline:hover { background: #f0faf8; }

        @media print {
            body { background: #fff; }
            .no-print { display: none !important; }
            .invoice-wrapper { margin: 0; max-width: 100%; }
            .invoice-card { box-shadow: none; border-radius: 0; }
        }

        @media (max-width: 600px) {
            .invoice-header { flex-direction: column; gap: 16px; text-align: center; padding: 24px 20px; }
            .invoice-header .invoice-meta { text-align: center; }
            .invoice-body { padding: 24px 20px; }
            .info-section { flex-direction: column; }
            .totals-box { width: 100%; }
            .invoice-footer { flex-direction: column; gap: 12px; text-align: center; }
        }
    </style>
</head>

<body>
    <div class="invoice-wrapper">

        <!-- Action bar (hidden on print) -->
        <div class="action-bar no-print">
            <span class="invoice-label">
                <i class="fa fa-file-text-o"></i> Invoice #{{ $order->order_id }}
            </span>
            <div style="display:flex; gap:10px;">
                <button id="btn-print" class="btn-invoice-outline">
                    <i class="fa fa-print"></i> Print
                </button>
                <button id="btn-download" class="btn-invoice">
                    <i class="fa fa-download"></i> Download PDF
                </button>
            </div>
        </div>

        <!-- Invoice card -->
        <div class="invoice-card">

            <!-- Header -->
            <div class="invoice-header">
                <div class="brand">
                    <img src="{{ asset('h2whoa_user/assets/img/elements/h2whoa_logo.png') }}" alt="H2WHOA Logo">
                    <div>
                        <div class="brand-name">H2WHOA</div>
                        <div class="brand-tagline">Pure Water Delivery Service</div>
                    </div>
                </div>
                <div class="invoice-meta">
                    <div class="inv-title">Invoice</div>
                    <div class="inv-id"># {{ $order->order_id }}</div>
                </div>
            </div>

            <!-- Body -->
            <div class="invoice-body">

                <!-- Bill To / Invoice Info -->
                <div class="info-section">
                    <div>
                        <div class="bill-to-label">Bill To</div>
                        <div class="bill-to-name">{{ $order->customer_name }}</div>
                        <div class="bill-to-detail"><i class="fa fa-map-marker" style="width:14px;"></i> {{ $order->customer_address }}</div>
                        <div class="bill-to-detail"><i class="fa fa-phone" style="width:14px;"></i> {{ $order->customer_phone }}</div>
                    </div>
                    <div>
                        <div class="bill-to-label">Invoice Details</div>
                        <table class="inv-info-table">
                            <tr>
                                <td>Invoice No.</td>
                                <td># {{ $order->order_id }}</td>
                            </tr>
                            <tr>
                                <td>Issue Date</td>
                                <td>{{ \Carbon\Carbon::parse($order->order_datetime)->format('M d, Y') }}</td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td>
                                    @if($order->order_status === 'Delivered')
                                        <span class="status-badge status-delivered">Delivered</span>
                                    @elseif($order->order_status === 'Cancelled')
                                        <span class="status-badge status-cancelled">Cancelled</span>
                                    @else
                                        <span class="status-badge status-pending">{{ $order->order_status }}</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Items Table -->
                <table class="items-table">
                    <thead>
                        <tr>
                            <th style="width:40px;">#</th>
                            <th>Description</th>
                            <th style="text-align:center;">Qty</th>
                            <th style="text-align:right;">Unit Price</th>
                            <th style="text-align:right;">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->orderDetails as $i => $detail)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $detail->stock->product_name }}</td>
                            <td style="text-align:center;">{{ $detail->quantity }}</td>
                            <td style="text-align:right;">₱{{ number_format($detail->price_per_unit, 2) }}</td>
                            <td style="text-align:right; font-weight:600;">₱{{ number_format($detail->total_price, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" style="text-align:right; color:#4a5568;">Delivery Charge</td>
                            <td style="text-align:right; font-weight:600; color:#4a5568;">₱{{ number_format($order->delivery_fee ?? 50, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>

                <!-- Totals -->
                @php
                    $subtotal = $order->orderDetails->sum('total_price');
                    $tax = $subtotal * 0.12;
                @endphp
                <div class="totals-section">
                    <div class="totals-box">
                        <div class="totals-row">
                            <span>Subtotal</span>
                            <span>₱{{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="totals-row">
                            <span>Delivery Fee</span>
                            <span>₱{{ number_format($order->delivery_fee ?? 50, 2) }}</span>
                        </div>
                        <div class="totals-row">
                            <span>Tax (12%)</span>
                            <span>₱{{ number_format($tax, 2) }}</span>
                        </div>
                        <div class="totals-row total-final">
                            <span>Total Amount</span>
                            <span class="total-amount">₱{{ number_format($order->amount_paid, 2) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="invoice-footer">
                    <div class="thank-you">
                        Thank you for choosing <strong>H2WHOA</strong>!<br>
                        <span style="font-size:0.78rem;">We appreciate your business.</span>
                    </div>
                    <div style="text-align:right; font-size:0.78rem; color:#b0b0b0;">
                        Generated {{ \Carbon\Carbon::now()->format('M d, Y') }}
                    </div>
                </div>

            </div><!-- /.invoice-body -->
        </div><!-- /.invoice-card -->
    </div><!-- /.invoice-wrapper -->

    <script nonce="{{ csp_nonce() }}" src="{{ asset('h2whoa_user/assets/bootstrap/js/bootstrap.min.js') }}"></script>
    <script nonce="{{ csp_nonce() }}" src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script nonce="{{ csp_nonce() }}">
        document.getElementById('btn-print').addEventListener('click', function () {
            window.print();
        });

        document.getElementById('btn-download').addEventListener('click', function () {
            document.querySelectorAll('.no-print').forEach(function (el) { el.style.display = 'none'; });

            var element = document.querySelector('.invoice-wrapper');
            var opt = {
                margin:      0.4,
                filename:    'invoice-{{ $order->order_id }}.pdf',
                image:       { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2, useCORS: true },
                jsPDF:       { unit: 'in', format: 'letter', orientation: 'portrait' }
            };

            html2pdf().set(opt).from(element).save().then(function () {
                document.querySelectorAll('.no-print').forEach(function (el) { el.style.display = ''; });
            });
        });
    </script>
</body>

</html>
