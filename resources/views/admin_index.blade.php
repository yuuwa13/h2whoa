@extends('layouts.admin')

@section('title', 'Dashboard')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@section('content')
<div class="row">
    <div class="col-md-6 col-xl-3 mb-4">
        <div class="card shadow border-start-primary py-2">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-primary fw-bold text-xs mb-1">Daily Sales</div>
                        <div class="text-dark fw-bold h5 mb-0">₱ {{ number_format($dailySales, 2) }}</div>
                    </div>
                    <div class="col-auto"><i class="fas fa-calendar fa-2x text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3 mb-4">
        <div class="card shadow border-start-success py-2">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-success fw-bold text-xs mb-1">Earnings (Monthly)</div>
                        <div class="text-dark fw-bold h5 mb-0">₱ {{ number_format($monthlyEarnings, 2) }}</div>
                    </div>
                    <div class="col-auto"><i class="fas fa-dollar-sign fa-2x text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3 mb-4">
        <div class="card shadow border-start-success py-2">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-success fw-bold text-xs mb-1">Earnings (Annual)</div>
                        <div class="text-dark fw-bold h5 mb-0">₱ {{ number_format($yearlyEarnings, 2) }}</div>
                    </div>
                    <div class="col-auto"><i class="fas fa-dollar-sign fa-2x text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3 mb-4">
        <div class="card shadow border-start-warning py-2">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-warning fw-bold text-xs mb-1">Pending Orders</div>
                        <div class="text-dark fw-bold h5 mb-0">{{ $pendingOrders }}</div>
                    </div>
                    <div class="col-auto"><i class="fas fa-clipboard-list fa-2x text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-7 col-xl-8">
        <div class="card shadow mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="text-primary fw-bold m-0 earnings-header">Earnings Overview (Monthly)</h6>
                <div class="dropdown no-arrow">
                    <button class="btn btn-link btn-sm dropdown-toggle" data-bs-toggle="dropdown" type="button">
                        <i class="fas fa-ellipsis-v text-gray-400"></i>
                    </button>
                    <div class="dropdown-menu shadow dropdown-menu-end animated--fade-in">
                        <p class="text-center dropdown-header">Select Date Range:</p>
                        <a class="dropdown-item earnings-range-btn" href="#" data-range="year">Yearly</a>
                        <a class="dropdown-item earnings-range-btn" href="#" data-range="half-year">Half-Yearly</a>
                        <a class="dropdown-item earnings-range-btn" href="#" data-range="month">Monthly</a>
                        <a class="dropdown-item earnings-range-btn" href="#" data-range="week">Weekly</a>
                        <a class="dropdown-item" href="#" id="showCustomDatePickerBtn">Custom Range</a>
                    </div>
                </div>
            </div>
            <div id="customDatePicker" class="px-3 pt-2 pb-1 d-none">
                <div class="d-flex gap-2 flex-wrap align-items-center">
                    <input id="startDate" type="text" class="form-control form-control-sm" placeholder="Start Date">
                    <input id="endDate" type="text" class="form-control form-control-sm" placeholder="End Date">
                    <button class="btn btn-sm btn-primary" id="applyCustomDateRangeBtn">Apply</button>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-5 col-xl-4">
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="text-xs text-uppercase fw-bold text-muted mb-1">Current Date & Time</div>
                <h5 class="fw-bold text-dark mb-1" id="currentDate"></h5>
                <h6 class="text-primary mb-3" id="currentTime"></h6>
                <p class="text-muted small mb-0">Track orders, manage deliveries, and monitor sales — all in one dashboard.</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="text-primary fw-bold m-0 item-sales-header">Item Sales (Monthly)</h6>
                <div class="dropdown no-arrow">
                    <button class="btn btn-link btn-sm dropdown-toggle" data-bs-toggle="dropdown" type="button">
                        <i class="fas fa-ellipsis-v text-gray-400"></i>
                    </button>
                    <div class="dropdown-menu shadow dropdown-menu-end animated--fade-in">
                        <p class="text-center dropdown-header">Select Date Range:</p>
                        <a class="dropdown-item item-range-btn" href="#" data-range="year">Yearly</a>
                        <a class="dropdown-item item-range-btn" href="#" data-range="half-year">Half-Yearly</a>
                        <a class="dropdown-item item-range-btn" href="#" data-range="month">Monthly</a>
                        <a class="dropdown-item item-range-btn" href="#" data-range="week">Weekly</a>
                        <a class="dropdown-item item-range-btn" href="#" data-range="today">Today</a>
                        <a class="dropdown-item" href="#" id="showCustomItemSalesPickerBtn">Custom Range</a>
                    </div>
                </div>
            </div>
            <div id="customItemSalesPicker" class="px-3 pt-2 pb-1 d-none">
                <div class="d-flex gap-2 flex-wrap align-items-center">
                    <input id="itemSalesStartDate" type="text" class="form-control form-control-sm" placeholder="Start Date">
                    <input id="itemSalesEndDate" type="text" class="form-control form-control-sm" placeholder="End Date">
                    <button class="btn btn-sm btn-primary" id="applyCustomItemSalesRangeBtn">Apply</button>
                </div>
            </div>
            <div class="card-body" id="itemSalesContainer"></div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script nonce="{{ csp_nonce() }}" src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script nonce="{{ csp_nonce() }}" src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script nonce="{{ csp_nonce() }}">
    // ── Helpers ──────────────────────────────────────────────────────────────
    function dateRangeDates(range) {
        const today = new Date();
        let startDate, endDate, rangeLabel;
        if (range === 'year') {
            startDate  = new Date(today.getFullYear(), 0, 1).toISOString().split('T')[0];
            endDate    = new Date(today.getFullYear(), 11, 31).toISOString().split('T')[0];
            rangeLabel = 'Yearly';
        } else if (range === 'half-year') {
            const m    = today.getMonth() < 6 ? 0 : 6;
            startDate  = new Date(today.getFullYear(), m, 1).toISOString().split('T')[0];
            endDate    = new Date(today.getFullYear(), m + 5, 31).toISOString().split('T')[0];
            rangeLabel = 'Half-Yearly';
        } else if (range === 'month') {
            startDate  = new Date(today.getFullYear(), today.getMonth(), 1).toISOString().split('T')[0];
            endDate    = new Date(today.getFullYear(), today.getMonth() + 1, 0).toISOString().split('T')[0];
            rangeLabel = 'Monthly';
        } else if (range === 'week') {
            const first = new Date(today);
            first.setDate(today.getDate() - today.getDay());
            startDate  = first.toISOString().split('T')[0];
            const last = new Date(first);
            last.setDate(first.getDate() + 6);
            endDate    = last.toISOString().split('T')[0];
            rangeLabel = 'Weekly';
        } else if (range === 'today') {
            startDate  = endDate = today.toISOString().split('T')[0];
            rangeLabel = 'Today';
        }
        return { startDate, endDate, rangeLabel };
    }

    // ── Earnings chart ────────────────────────────────────────────────────────
    let salesChartInstance = null;

    function updateChart(labels, sales) {
        const container = document.querySelector('.chart-area');
        if (salesChartInstance) { salesChartInstance.destroy(); salesChartInstance = null; }
        let canvas = document.getElementById('salesChart');
        if (!canvas) { canvas = document.createElement('canvas'); canvas.id = 'salesChart'; container.appendChild(canvas); }
        salesChartInstance = new Chart(canvas.getContext('2d'), {
            type: 'line',
            data: {
                labels,
                datasets: [{ label: 'Sales (₱)', data: sales,
                    backgroundColor: 'rgba(74,201,176,.1)',
                    borderColor: '#4ac9b0', borderWidth: 2, pointRadius: 3, tension: 0.3 }]
            },
            options: { maintainAspectRatio: false,
                scales: { x: { grid: { display: false } }, y: { grid: { color: 'rgb(234,236,244)' },
                    ticks: { callback: v => '₱' + v.toLocaleString() } } } }
        });
    }

    function fetchGraphData(startDate, endDate, rangeLabel = '', groupBy = 'day') {
        fetch(`/admin/sales-data?start_date=${encodeURIComponent(startDate)}&end_date=${encodeURIComponent(endDate)}&group_by=${groupBy}`)
            .then(r => r.json())
            .then(data => {
                if (data.length === 0) {
                    updateChart(['No data'], [0]);
                } else {
                    updateChart(data.map(i => i.date), data.map(i => parseFloat(i.total_sales)));
                }
                document.querySelector('.earnings-header').textContent = `Earnings Overview (${rangeLabel})`;
            })
            .catch(() => updateChart(['Error'], [0]));
    }

    // ── Item sales ────────────────────────────────────────────────────────────
    const progressBarColors = ['bg-primary','bg-success','bg-danger','bg-warning','bg-info','bg-secondary'];

    function fetchItemSalesData(startDate, endDate, rangeLabel = '') {
        fetch(`/admin/item-sales-data?start_date=${encodeURIComponent(startDate)}&end_date=${encodeURIComponent(endDate)}`)
            .then(r => r.json())
            .then(data => {
                const container = document.getElementById('itemSalesContainer');
                container.innerHTML = '';

                if (!data.length) {
                    const msg = document.createElement('p');
                    msg.className = 'text-muted small';
                    msg.textContent = 'No sales data for this period.';
                    container.appendChild(msg);
                } else {
                    const totalQty = data.reduce((s, i) => s + Number(i.total_quantity), 0);

                    data.forEach((item, idx) => {
                        const qty = Number(item.total_quantity);
                        const pct = totalQty > 0 ? ((qty / totalQty) * 100).toFixed(1) : 0;

                        // Label row
                        const label = document.createElement('h4');
                        label.className = 'small fw-bold mb-1';
                        const labelText = document.createElement('span');
                        labelText.textContent = item.product_name;
                        const labelMeta = document.createElement('span');
                        labelMeta.className = 'float-end text-muted';
                        labelMeta.textContent = `${pct}% — ${qty} sold`;
                        label.appendChild(labelText);
                        label.appendChild(labelMeta);

                        // Progress bar wrapper
                        const progressWrap = document.createElement('div');
                        progressWrap.className = 'progress mb-3';

                        const bar = document.createElement('div');
                        bar.className = `progress-bar ${progressBarColors[idx % progressBarColors.length]}`;
                        bar.setAttribute('role', 'progressbar');
                        bar.setAttribute('aria-valuenow', pct);
                        bar.setAttribute('aria-valuemin', '0');
                        bar.setAttribute('aria-valuemax', '100');
                        // Set width via JS — not a CSP-blocked inline style attribute
                        bar.style.width = pct + '%';

                        progressWrap.appendChild(bar);
                        container.appendChild(label);
                        container.appendChild(progressWrap);
                    });
                }
                document.querySelector('.item-sales-header').textContent = `Item Sales (${rangeLabel})`;
            })
            .catch(() => {
                const err = document.createElement('p');
                err.className = 'text-danger small';
                err.textContent = 'Failed to load item sales.';
                document.getElementById('itemSalesContainer').appendChild(err);
            });
    }

    // ── Date/time clock ───────────────────────────────────────────────────────
    function updateDateTime() {
        const now  = new Date();
        const utc  = now.getTime() + now.getTimezoneOffset() * 60000;
        const gmt8 = new Date(utc + 8 * 3600000);
        document.getElementById('currentDate').textContent = gmt8.toLocaleDateString('en-US', { year:'numeric', month:'long', day:'numeric' });
        document.getElementById('currentTime').textContent = gmt8.toLocaleTimeString('en-US', { hour:'2-digit', minute:'2-digit', second:'2-digit', hour12:true });
    }
    setInterval(updateDateTime, 1000);

    // ── Wire up after DOM ready ───────────────────────────────────────────────
    document.addEventListener('DOMContentLoaded', function () {
        // Init flatpickr
        flatpickr('#startDate',         { dateFormat: 'Y-m-d' });
        flatpickr('#endDate',           { dateFormat: 'Y-m-d' });
        flatpickr('#itemSalesStartDate',{ dateFormat: 'Y-m-d' });
        flatpickr('#itemSalesEndDate',  { dateFormat: 'Y-m-d' });

        // Initial load — current month
        const today = new Date();
        const s = new Date(today.getFullYear(), today.getMonth(), 1).toISOString().split('T')[0];
        const e = new Date(today.getFullYear(), today.getMonth() + 1, 0).toISOString().split('T')[0];
        fetchGraphData(s, e, 'Monthly', 'day');
        fetchItemSalesData(s, e, 'Monthly');
        updateDateTime();

        // Earnings range dropdown
        document.querySelectorAll('.earnings-range-btn').forEach(function (btn) {
            btn.addEventListener('click', function (ev) {
                ev.preventDefault();
                const range = this.dataset.range;
                const { startDate, endDate, rangeLabel } = dateRangeDates(range);
                const groupBy = (range === 'year' || range === 'half-year') ? 'month' : 'day';
                fetchGraphData(startDate, endDate, rangeLabel, groupBy);
            });
        });

        // Show earnings custom date picker
        document.getElementById('showCustomDatePickerBtn').addEventListener('click', function (ev) {
            ev.preventDefault();
            document.getElementById('customDatePicker').classList.remove('d-none');
        });

        // Apply earnings custom date range
        document.getElementById('applyCustomDateRangeBtn').addEventListener('click', function () {
            const startDate = document.getElementById('startDate').value;
            const endDate   = document.getElementById('endDate').value;
            if (startDate && endDate) {
                // Use month grouping if range spans more than 60 days
                const diff = (new Date(endDate) - new Date(startDate)) / 86400000;
                const groupBy = diff > 60 ? 'month' : 'day';
                fetchGraphData(startDate, endDate, 'Custom', groupBy);
                document.getElementById('customDatePicker').classList.add('d-none');
            } else {
                alert('Please select both start and end dates.');
            }
        });

        // Item sales range dropdown
        document.querySelectorAll('.item-range-btn').forEach(function (btn) {
            btn.addEventListener('click', function (ev) {
                ev.preventDefault();
                const { startDate, endDate, rangeLabel } = dateRangeDates(this.dataset.range);
                fetchItemSalesData(startDate, endDate, rangeLabel);
            });
        });

        // Show item sales custom date picker
        document.getElementById('showCustomItemSalesPickerBtn').addEventListener('click', function (ev) {
            ev.preventDefault();
            document.getElementById('customItemSalesPicker').classList.remove('d-none');
        });

        // Apply item sales custom date range
        document.getElementById('applyCustomItemSalesRangeBtn').addEventListener('click', function () {
            const s = document.getElementById('itemSalesStartDate').value;
            const e = document.getElementById('itemSalesEndDate').value;
            if (s && e) {
                fetchItemSalesData(s, e, 'Custom');
                document.getElementById('customItemSalesPicker').classList.add('d-none');
            } else {
                alert('Please select both start and end dates.');
            }
        });
    });
</script>
@endpush
