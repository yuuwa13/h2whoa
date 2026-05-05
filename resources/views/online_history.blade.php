@extends('layouts.app')

@section('title', 'Order History')

@push('styles')
    <style nonce="{{ csp_nonce() }}">
        .history-hero {
            background: linear-gradient(135deg, #4ac9b0 0%, #38b89e 100%);
            padding: 48px 0 32px;
            color: #fff;
            margin-bottom: 0;
        }
        .history-hero h1 {
            font-size: 1.9rem;
            font-weight: 700;
            margin-bottom: 6px;
        }
        .history-hero p {
            font-size: 0.9rem;
            opacity: 0.9;
            margin-bottom: 0;
        }

        /* Stats row */
        .stats-bar {
            background: #fff;
            border-bottom: 1px solid #e8edf2;
            padding: 14px 0;
        }
        .stat-chip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-right: 8px;
        }
        .stat-chip.all      { background: #f1f5f9; color: #475569; }
        .stat-chip.delivered { background: #d1faf3; color: #1a7c3e; }
        .stat-chip.cancelled { background: #fee2e2; color: #991b1b; }

        /* Filter bar */
        .filter-bar {
            background: #fff;
            border-bottom: 1px solid #e8edf2;
            padding: 16px 0;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        .filter-bar .form-control,
        .filter-bar .form-select {
            border-radius: 8px;
            border: 1.5px solid #e0e7ef;
            font-size: 0.875rem;
            padding: 8px 14px;
        }
        .filter-bar .form-control:focus,
        .filter-bar .form-select:focus {
            border-color: #4ac9b0;
            box-shadow: 0 0 0 3px rgba(74,201,176,0.15);
        }
        .search-icon-wrap {
            position: relative;
        }
        .search-icon-wrap .fa {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #aab4be;
            font-size: 0.85rem;
        }
        .search-icon-wrap .form-control {
            padding-left: 34px;
        }

        /* Page body */
        .history-body {
            background: #f0f4f8;
            min-height: 60vh;
            padding: 32px 0 48px;
        }

        /* Result count */
        .result-count {
            font-size: 0.82rem;
            color: #94a3b8;
            margin-bottom: 16px;
        }

        /* Order card */
        .order-card {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            border: 1px solid #e8edf2;
            margin-bottom: 20px;
            overflow: hidden;
            transition: box-shadow 0.2s, transform 0.2s;
        }
        .order-card:hover {
            box-shadow: 0 6px 24px rgba(74,201,176,0.12);
            transform: translateY(-2px);
        }
        .order-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 20px;
            border-bottom: 1px solid #f0f4f8;
            background: #fafcfe;
        }
        .order-id {
            font-weight: 700;
            font-size: 0.95rem;
            color: #2d3748;
        }
        .order-id span { color: #4ac9b0; }
        .order-date {
            font-size: 0.78rem;
            color: #94a3b8;
            margin-top: 2px;
        }

        /* Status badges */
        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .status-pill .dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
        }
        .status-delivered { background: #d1faf3; color: #1a7c3e; }
        .status-delivered .dot { background: #4ac9b0; }
        .status-cancelled { background: #fee2e2; color: #991b1b; }
        .status-cancelled .dot { background: #ef4444; }
        .status-other     { background: #f1f5f9; color: #64748b; }
        .status-other .dot { background: #94a3b8; }

        /* Card body */
        .order-card-body {
            padding: 16px 20px;
        }
        .order-products {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-bottom: 14px;
        }
        .product-tag {
            background: #f0faf8;
            color: #4ac9b0;
            border: 1px solid #c6f0e8;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 3px 10px;
        }
        .order-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            margin-bottom: 16px;
        }
        .order-meta-item {
            font-size: 0.8rem;
            color: #64748b;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .order-meta-item .fa { color: #4ac9b0; font-size: 0.75rem; }

        .card-actions {
            display: flex;
            gap: 8px;
        }
        .btn-view {
            background: transparent;
            color: #4ac9b0;
            border: 1.5px solid #4ac9b0;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 600;
            padding: 6px 14px;
            transition: all 0.2s;
            cursor: pointer;
        }
        .btn-view:hover {
            background: #4ac9b0;
            color: #fff;
        }
        .btn-invoice {
            background: #4ac9b0;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 600;
            padding: 6px 14px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: background 0.2s;
        }
        .btn-invoice:hover {
            background: #38b89e;
            color: #fff;
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #94a3b8;
        }
        .empty-state .empty-icon { font-size: 3rem; margin-bottom: 16px; opacity: 0.4; }
        .empty-state h5 { color: #64748b; margin-bottom: 8px; }

        /* Modal */
        .modal-content { border-radius: 14px; overflow: hidden; border: none; }
        .modal-header {
            background: linear-gradient(135deg, #4ac9b0, #38b89e);
            color: #fff;
            border-bottom: none;
            padding: 18px 24px;
        }
        .modal-header .btn-close { filter: brightness(0) invert(1); opacity: 0.8; }
        .modal-title { font-weight: 700; font-size: 1rem; }
        .modal-body  { padding: 24px; }

        .detail-section-title {
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #4ac9b0;
            margin: 0 0 10px;
        }
        .detail-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-bottom: 20px;
        }
        .detail-item label {
            display: block;
            font-size: 0.7rem;
            font-weight: 600;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 2px;
        }
        .detail-item span {
            font-size: 0.875rem;
            color: #2d3748;
            font-weight: 500;
        }
        .detail-item.full { grid-column: 1 / -1; }

        .items-mini-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
            font-size: 0.85rem;
        }
        .items-mini-table th {
            background: #f8fafc;
            padding: 8px 12px;
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            color: #64748b;
            letter-spacing: 0.5px;
        }
        .items-mini-table td {
            padding: 9px 12px;
            border-bottom: 1px solid #f1f5f9;
            color: #4a5568;
        }
        .items-mini-table tr:last-child td { border-bottom: none; }

        .totals-mini {
            background: #f8fafc;
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 16px;
        }
        .totals-mini-row {
            display: flex;
            justify-content: space-between;
            font-size: 0.82rem;
            color: #64748b;
            padding: 4px 0;
        }
        .totals-mini-row.total-line {
            border-top: 1px dashed #e2e8f0;
            margin-top: 6px;
            padding-top: 10px;
            font-weight: 700;
            font-size: 0.95rem;
            color: #2d3748;
        }
        .totals-mini-row.total-line span:last-child { color: #4ac9b0; }

        .modal-invoice-link {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 8px;
            padding-top: 8px;
        }
    </style>
@endpush

@section('content')
    @php
        $totalOrders    = $orders->count();
        $totalDelivered = $orders->where('order_status', 'Delivered')->count();
        $totalCancelled = $orders->where('order_status', 'Cancelled')->count();
    @endphp

    {{-- Hero --}}
    <div class="history-hero">
        <div class="container">
            <h1><i class="fa fa-history me-2"></i>Order History</h1>
            <p>A complete record of your past orders with H2WHOA.</p>
        </div>
    </div>

    {{-- Stats bar --}}
    <div class="stats-bar">
        <div class="container">
            <span class="stat-chip all"><i class="fa fa-list"></i> {{ $totalOrders }} Total</span>
            <span class="stat-chip delivered"><i class="fa fa-check-circle"></i> {{ $totalDelivered }} Delivered</span>
            <span class="stat-chip cancelled"><i class="fa fa-times-circle"></i> {{ $totalCancelled }} Cancelled</span>
        </div>
    </div>

    {{-- Filter bar --}}
    <div class="filter-bar">
        <div class="container">
            <div class="row g-2 align-items-center">
                <div class="col-12 col-sm-6 col-md-5">
                    <div class="search-icon-wrap">
                        <i class="fa fa-search"></i>
                        <input type="text" id="searchInput" class="form-control" placeholder="Search by order ID or product…">
                    </div>
                </div>
                <div class="col-6 col-sm-3 col-md-3">
                    <select id="statusFilter" class="form-select">
                        <option value="">All Statuses</option>
                        <option value="Delivered">Delivered</option>
                        <option value="Cancelled">Cancelled</option>
                    </select>
                </div>
                <div class="col-6 col-sm-3 col-md-4 text-end">
                    <button id="clearFilters" class="btn btn-sm btn-outline-secondary" style="border-radius:8px; font-size:0.8rem;">
                        <i class="fa fa-times me-1"></i>Clear
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Body --}}
    <div class="history-body">
        <div class="container">
            <p class="result-count" id="resultCount"></p>

            @if($orders->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon"><i class="fa fa-inbox"></i></div>
                    <h5>No order history yet</h5>
                    <p>Your completed and cancelled orders will appear here.</p>
                </div>
            @else
                <div class="row" id="orderGrid">
                    @foreach($orders as $order)
                        @php
                            $status = $order->order_status;
                            $statusClass = match($status) {
                                'Delivered' => 'status-delivered',
                                'Cancelled' => 'status-cancelled',
                                default     => 'status-other',
                            };
                            $subtotal = $order->orderDetails->sum('total_price');
                            $searchText = strtolower($order->order_id . ' ' . $order->orderDetails->pluck('stock.product_name')->join(' '));
                        @endphp

                        <div class="col-12 col-md-6 col-xl-4 order-item"
                             data-status="{{ $status }}"
                             data-search="{{ $searchText }}">
                            <div class="order-card">
                                <div class="order-card-header">
                                    <div>
                                        <div class="order-id">Order <span>#{{ $order->order_id }}</span></div>
                                        <div class="order-date">{{ \Carbon\Carbon::parse($order->order_datetime)->format('M d, Y · h:i A') }}</div>
                                    </div>
                                    <span class="status-pill {{ $statusClass }}">
                                        <span class="dot"></span>
                                        {{ $status }}
                                    </span>
                                </div>

                                <div class="order-card-body">
                                    {{-- Product tags --}}
                                    <div class="order-products">
                                        @foreach($order->orderDetails as $detail)
                                            <span class="product-tag">{{ $detail->quantity }}× {{ $detail->stock->product_name }}</span>
                                        @endforeach
                                    </div>

                                    <div class="order-meta">
                                        <div class="order-meta-item">
                                            <i class="fa fa-money"></i>
                                            ₱{{ number_format($order->amount_paid, 2) }}
                                        </div>
                                        <div class="order-meta-item">
                                            <i class="fa fa-credit-card"></i>
                                            {{ $order->payment_method_id == 1 ? 'COD' : 'GCash' }}
                                        </div>
                                    </div>

                                    <div class="card-actions">
                                        <button class="btn-view" data-bs-toggle="modal" data-bs-target="#historyModal{{ $order->order_id }}">
                                            <i class="fa fa-eye me-1"></i>View Details
                                        </button>
                                        @if($order->order_status === 'Delivered')
                                            <a href="{{ route('orders.invoice', $order->order_id) }}" target="_blank" class="btn-invoice">
                                                <i class="fa fa-file-text-o"></i> Invoice
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Modal --}}
                        <div class="modal fade" id="historyModal{{ $order->order_id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title"><i class="fa fa-history me-2"></i>Order #{{ $order->order_id }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p class="detail-section-title">Customer Info</p>
                                        <div class="detail-grid">
                                            <div class="detail-item">
                                                <label>Name</label>
                                                <span>{{ $order->customer_name }}</span>
                                            </div>
                                            <div class="detail-item">
                                                <label>Contact</label>
                                                <span>{{ $order->customer_phone }}</span>
                                            </div>
                                            <div class="detail-item full">
                                                <label>Address</label>
                                                <span>{{ $order->customer_address }}</span>
                                            </div>
                                            <div class="detail-item">
                                                <label>Order Date</label>
                                                <span>{{ \Carbon\Carbon::parse($order->order_datetime)->format('M d, Y h:i A') }}</span>
                                            </div>
                                            <div class="detail-item">
                                                <label>Payment</label>
                                                <span>{{ $order->payment_method_id == 1 ? 'Cash on Delivery' : 'GCash' }}</span>
                                            </div>
                                        </div>

                                        <p class="detail-section-title">Order Items</p>
                                        <table class="items-mini-table">
                                            <thead>
                                                <tr>
                                                    <th>Product</th>
                                                    <th style="text-align:center;">Qty</th>
                                                    <th style="text-align:right;">Unit Price</th>
                                                    <th style="text-align:right;">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($order->orderDetails as $detail)
                                                <tr>
                                                    <td>{{ $detail->stock->product_name }}</td>
                                                    <td style="text-align:center;">{{ $detail->quantity }}</td>
                                                    <td style="text-align:right;">₱{{ number_format($detail->price_per_unit, 2) }}</td>
                                                    <td style="text-align:right;">₱{{ number_format($detail->total_price, 2) }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                        <div class="totals-mini">
                                            <div class="totals-mini-row">
                                                <span>Subtotal</span>
                                                <span>₱{{ number_format($subtotal, 2) }}</span>
                                            </div>
                                            <div class="totals-mini-row">
                                                <span>Delivery Fee</span>
                                                <span>₱{{ number_format($order->delivery_fee ?? 50, 2) }}</span>
                                            </div>
                                            <div class="totals-mini-row">
                                                <span>Tax (12%)</span>
                                                <span>₱{{ number_format($subtotal * 0.12, 2) }}</span>
                                            </div>
                                            <div class="totals-mini-row total-line">
                                                <span>Total Paid</span>
                                                <span>₱{{ number_format($order->amount_paid, 2) }}</span>
                                            </div>
                                        </div>

                                        @if($order->order_status === 'Delivered')
                                            <div class="modal-invoice-link">
                                                <a href="{{ route('orders.invoice', $order->order_id) }}" target="_blank" class="btn-invoice">
                                                    <i class="fa fa-file-text-o"></i> View & Print Invoice
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="empty-state" id="noResults" style="display:none;">
                    <div class="empty-icon"><i class="fa fa-search"></i></div>
                    <h5>No matching orders</h5>
                    <p>Try adjusting your search or filter.</p>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script nonce="{{ csp_nonce() }}">
        (function () {
            var search  = document.getElementById('searchInput');
            var filter  = document.getElementById('statusFilter');
            var clear   = document.getElementById('clearFilters');
            var counter = document.getElementById('resultCount');
            var noRes   = document.getElementById('noResults');

            function applyFilters() {
                var q      = search ? search.value.toLowerCase().trim() : '';
                var status = filter ? filter.value : '';
                var items  = document.querySelectorAll('.order-item');
                var visible = 0;

                items.forEach(function (el) {
                    var matchQ = !q      || el.dataset.search.includes(q);
                    var matchS = !status || el.dataset.status === status;
                    var show   = matchQ && matchS;
                    el.style.display = show ? '' : 'none';
                    if (show) visible++;
                });

                if (counter) counter.textContent = visible + ' order(s) found';
                if (noRes)   noRes.style.display = (visible === 0) ? 'block' : 'none';
            }

            if (search) search.addEventListener('input', applyFilters);
            if (filter) filter.addEventListener('change', applyFilters);
            if (clear)  clear.addEventListener('click', function () {
                if (search) search.value = '';
                if (filter) filter.value = '';
                applyFilters();
            });

            applyFilters();
        })();
    </script>
@endpush
