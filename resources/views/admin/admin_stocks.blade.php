@extends('layouts.admin')

@section('title', 'Stocks')

@section('content')
<div class="card shadow">
    <div class="card-body">
        <div class="row mb-3 align-items-center">
            <div class="col-md-8 d-flex align-items-center flex-wrap gap-2">
                <input type="text" id="searchInput" class="form-control" placeholder="Search..." style="max-width:280px;">
                <div class="d-flex flex-wrap align-items-center gap-2">
                    <div class="form-check form-check-inline mb-0">
                        <input class="form-check-input search-column" type="checkbox" id="searchItem" value="1" checked>
                        <label class="form-check-label" for="searchItem">Item</label>
                    </div>
                    <div class="form-check form-check-inline mb-0">
                        <input class="form-check-input search-column" type="checkbox" id="searchPrice" value="2" checked>
                        <label class="form-check-label" for="searchPrice">Price</label>
                    </div>
                    <div class="form-check form-check-inline mb-0">
                        <input class="form-check-input search-column" type="checkbox" id="searchStock" value="3" checked>
                        <label class="form-check-label" for="searchStock">Stock Qty</label>
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-md-end mt-2 mt-md-0">
                <a href="{{ route('admin.stocks.create') }}" class="btn btn-primary btn-sm">
                    <i class="far fa-plus-square me-1"></i> Add Stock
                </a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table my-0 sortable" id="dataTable">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th class="sortable-column">Item</th>
                        <th class="sortable-column">Price</th>
                        <th class="sortable-column">Stock Qty</th>
                        <th class="sortable-column">Availability</th>
                        <th>Quantifiable</th>
                        <th class="sortable-column">Created At</th>
                        <th class="sortable-column">Last Updated</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($stocks as $stock)
                    <tr>
                        <td>
                            <img width="60" height="60" style="object-fit:contain;border-radius:6px;background:#f8fafc;padding:3px;"
                                src="{{ $stock->uploadedImage ? asset('storage/' . $stock->uploadedImage->file_path) : asset('h2whoa_admin/assets/img/no-image-placeholder.png') }}"
                                alt="{{ $stock->product_name }}">
                        </td>
                        <td>{{ $stock->product_name }}</td>
                        <td>₱{{ number_format($stock->price_per_unit, 2) }}</td>
                        <td>
                            @if ($stock->is_quantifiable)
                                {{ $stock->quantity }}
                            @else
                                <span class="text-muted">N/A</span><br>
                                <small>Max: {{ $stock->maximum_orders_allowed }}</small>
                            @endif
                        </td>
                        <td>
                            <span class="badge" style="background:{{ $stock->is_available ? '#1cc88a' : '#e74a3b' }};color:#fff;">
                                {{ $stock->is_available ? 'Available' : 'Unavailable' }}
                            </span>
                        </td>
                        <td><input type="checkbox" {{ $stock->is_quantifiable ? 'checked' : '' }} disabled></td>
                        <td>{{ $stock->created_at ? $stock->created_at->timezone('Asia/Manila')->format('M d, Y H:i') : 'N/A' }}</td>
                        <td>{{ $stock->updated_at ? $stock->updated_at->timezone('Asia/Manila')->format('M d, Y H:i') : 'N/A' }}</td>
                        <td>
                            <a href="{{ route('admin.stocks.edit', $stock->stock_id) }}" class="btn btn-sm btn-outline-secondary me-1" title="Edit">
                                <i class="far fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.stocks.destroy', $stock->stock_id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"
                                    onclick="return confirm('Delete this stock item?')">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="9" class="text-center">No stock data available</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="row mt-3">
            <div class="col-md-6 align-self-center">
                <p class="dataTables_info small text-muted">
                    Showing {{ $stocks->firstItem() }} to {{ $stocks->lastItem() }} of {{ $stocks->total() }}
                </p>
            </div>
            <div class="col-md-6">
                {{ $stocks->links('pagination::bootstrap-5') }}
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
        const successMessage = '{{ session('success') }}';
        if (successMessage) {
            Swal.fire({ icon:'success', title:'Success', text: successMessage,
                toast:true, position:'top-end', showConfirmButton:false, timer:3000 });
        }

        const searchInput = document.getElementById('searchInput');
        const checkboxes  = document.querySelectorAll('.search-column');
        const table       = document.getElementById('dataTable');
        const rows        = Array.from(table.querySelectorAll('tbody tr'));

        searchInput.addEventListener('input', function () {
            const query = this.value.toLowerCase();
            const activeCols = Array.from(checkboxes).filter(cb => cb.checked).map(cb => parseInt(cb.value));
            if (!query) { rows.forEach(r => r.style.display = ''); return; }
            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                const match = activeCols.some(i => cells[i] && cells[i].textContent.toLowerCase().includes(query));
                row.style.display = match ? '' : 'none';
            });
        });

        document.querySelectorAll('.sortable-column').forEach(header => {
            header.style.cursor = 'pointer';
            header.addEventListener('click', function () {
                const idx = Array.from(header.parentNode.children).indexOf(header);
                const asc = header.classList.toggle('ascending');
                Array.from(rows).sort((a, b) => {
                    const at = a.children[idx]?.textContent.trim() || '';
                    const bt = b.children[idx]?.textContent.trim() || '';
                    return asc ? at.localeCompare(bt) : bt.localeCompare(at);
                }).forEach(r => table.querySelector('tbody').appendChild(r));
            });
        });
    });
</script>
@endpush
