@extends('layouts.admin')

@section('title', 'Sales')

@section('content')
<div class="card shadow">
    <div class="card-body">
        <div class="row mb-3 align-items-center">
            <div class="col-md-8 d-flex align-items-center flex-wrap gap-2">
                <input type="text" id="searchInput" class="form-control" placeholder="Search..." style="max-width:280px;">
                <div class="d-flex flex-wrap align-items-center gap-2">
                    <div class="form-check form-check-inline mb-0">
                        <input class="form-check-input search-column" type="checkbox" id="searchSaleId" value="1" checked>
                        <label class="form-check-label" for="searchSaleId">Sale ID</label>
                    </div>
                    <div class="form-check form-check-inline mb-0">
                        <input class="form-check-input search-column" type="checkbox" id="searchOrderId" value="2" checked>
                        <label class="form-check-label" for="searchOrderId">Order ID</label>
                    </div>
                    <div class="form-check form-check-inline mb-0">
                        <input class="form-check-input search-column" type="checkbox" id="searchSaleType" value="3" checked>
                        <label class="form-check-label" for="searchSaleType">Sale Type</label>
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-md-end mt-2 mt-md-0">
                <a href="{{ route('admin.sales.create') }}" class="btn btn-primary btn-sm">
                    <i class="far fa-plus-square me-1"></i> Add Sale
                </a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table my-0" id="dataTable">
                <thead>
                    <tr>
                        <th>Sale ID</th>
                        <th>Order ID</th>
                        <th>Sale Type</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sales as $sale)
                    <tr>
                        <td>{{ $sale->sale_id }}</td>
                        <td>{{ $sale->order_id }}</td>
                        <td>{{ ucfirst($sale->sale_type) }}</td>
                        <td>{{ $sale->created_at ? $sale->created_at->timezone('Asia/Manila')->format('M d, Y H:i') : 'N/A' }}</td>
                        <td>
                            <a href="{{ route('admin.sales.edit', $sale->sale_id) }}" class="btn btn-sm btn-outline-secondary me-1" title="Edit">
                                <i class="far fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.sales.destroy', $sale->sale_id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"
                                    onclick="return confirm('Delete this sale?')">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @if($sale->sale_type == 'web-based')
                    <tr>
                        <td colspan="5" class="bg-light">
                            <table class="table table-bordered table-sm mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Quantity</th>
                                        <th>Price Per Unit</th>
                                        <th>Total Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sale->order->orderDetails as $detail)
                                    <tr>
                                        <td>{{ $detail->stock->product_name }}</td>
                                        <td>{{ $detail->quantity }}</td>
                                        <td>₱{{ number_format($detail->stock->price_per_unit, 2) }}</td>
                                        <td>₱{{ number_format($detail->total_price, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    @endif
                    @empty
                    <tr><td colspan="5" class="text-center">No sales data available</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="row mt-3">
            <div class="col-md-6 align-self-center">
                <p class="dataTables_info small text-muted">
                    Showing {{ $sales->firstItem() }} to {{ $sales->lastItem() }} of {{ $sales->total() }}
                </p>
            </div>
            <div class="col-md-6">
                {{ $sales->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script nonce="{{ csp_nonce() }}" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.2/js/jquery.tablesorter.js"></script>
<script nonce="{{ csp_nonce() }}" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.2/js/widgets/widget-filter.min.js"></script>
<script nonce="{{ csp_nonce() }}" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.2/js/widgets/widget-storage.min.js"></script>
<script nonce="{{ csp_nonce() }}" src="{{ asset('h2whoa_admin/assets/js/Ludens---1-Index-Table-with-Search--Sort-Filters-v20-Ludens---1-Index-Table-with-Search--Sort-Filters.js') }}"></script>
<script nonce="{{ csp_nonce() }}" src="{{ asset('h2whoa_admin/assets/js/Ludens---1-Index-Table-with-Search--Sort-Filters-v20-Ludens---Material-UI-Actions.js') }}"></script>
<script nonce="{{ csp_nonce() }}" src="{{ asset('h2whoa_admin/assets/js/theme.js') }}"></script>
<script nonce="{{ csp_nonce() }}">
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchInput');
        const table = document.getElementById('dataTable');
        const rows  = Array.from(table.querySelectorAll('tbody tr'));

        function isDetailRow(row) {
            const tds = row.querySelectorAll('td');
            return tds.length === 1 && tds[0].hasAttribute('colspan');
        }

        searchInput.addEventListener('input', function () {
            const query = this.value.trim().toLowerCase();
            const checkboxEls = Array.from(document.querySelectorAll('.search-column'));
            let activeCols = checkboxEls.filter(cb => cb.checked).map(cb => parseInt(cb.value, 10));
            if (activeCols.length === 0) activeCols = [1, 2, 3];
            const cellIndexes = activeCols.map(v => v - 1);

            if (!query) { rows.forEach(r => r.style.display = ''); return; }

            rows.forEach((row, idx) => {
                if (isDetailRow(row)) { row.style.display = 'none'; return; }
                const cells = row.querySelectorAll('td');
                const match = cellIndexes.some(ci => cells[ci] && cells[ci].textContent.toLowerCase().includes(query));
                row.style.display = match ? '' : 'none';
                const next = rows[idx + 1];
                if (next && isDetailRow(next)) next.style.display = match ? '' : 'none';
            });
        });

        const headers = table.querySelectorAll('thead th');
        headers.forEach((header, index) => {
            if (index === 4) return;
            header.style.cursor = 'pointer';
            header.addEventListener('click', function () {
                const asc = header.classList.toggle('ascending');
                Array.from(rows).sort((a, b) => {
                    const at = a.children[index]?.textContent.trim().toLowerCase() || '';
                    const bt = b.children[index]?.textContent.trim().toLowerCase() || '';
                    return at > bt ? (asc ? 1 : -1) : at < bt ? (asc ? -1 : 1) : 0;
                }).forEach(r => table.querySelector('tbody').appendChild(r));
            });
        });
    });
</script>
@endpush
