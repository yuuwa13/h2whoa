<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Sales</title>
    <link rel="stylesheet" href="{{ asset('h2whoa_admin/assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins&amp;display=swap">
    <link rel="stylesheet" href="{{ asset('h2whoa_admin/assets/fonts/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa_admin/assets/css/bs-theme-overrides.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.2/css/theme.bootstrap_4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <link rel="stylesheet" href="{{ asset('h2whoa_admin/assets/css/Ludens---1-Index-Table-with-Search--Sort-Filters-v20.css') }}">
</head>

<body id="page-top">
    <div id="wrapper">
        <nav class="navbar align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0 navbar-dark" style="background: rgba(255, 255, 255, 0.04);font-size: 22px;color: rgba(133,135,150,0.04);">
            <div class="container-fluid d-flex flex-column p-0">
                <a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="{{ route('admin.stocks') }}">
                    <picture>
                        <img class="img-fluid" width="80" height="60" style="width: 85px;height: 87px;" src="{{ asset('h2whoa_admin/assets/img/elements/h2whoa_logo.png') }}">
                    </picture>
                    <div class="sidebar-brand-icon rotate-n-15"></div>
                    <div class="sidebar-brand-text mx-3"><span style="color: var(--bs-primary-text-emphasis);">H2WHOA</span></div>
                </a>
                <hr class="sidebar-divider my-0">
                <ul class="navbar-nav text-light" id="accordionSidebar">
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}" style="color: var(--bs-emphasis-color);"><i class="fas fa-tachometer-alt" style="--bs-primary: rgb(33,33,33);--bs-primary-rgb: 33,33,33;color: var(--bs-accordion-active-color);"></i><span>Dashboard</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.stocks') }}"><i class="fas fa-user" style="color: var(--bs-emphasis-color);"></i><span style="color: var(--bs-secondary-text-emphasis);">Stocks</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.orders') }}" style="color: var(--bs-secondary-text-emphasis);"><i class="fas fa-table" style="padding-left: -24px;color: var(--bs-accordion-active-color);"></i><span>Orders</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('sales.index') }}"><i class="fas fa-cash-register" style="color: var(--bs-accordion-active-color);"></i><span style="color: var(--bs-secondary-text-emphasis);">Sales</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.history') }}"><i class="fas fa-history" style="color: var(--bs-accordion-active-color);"></i><span style="color: var(--bs-secondary-text-emphasis);">History</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.activity-log') }}"><i class="fas fa-list" style="color: var(--bs-accordion-active-color);"></i><span style="color: var(--bs-secondary-text-emphasis);">Activity Log</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.upload-image') }}"><i class="fas fa-upload" style="color: var(--bs-accordion-active-color);"></i><span style="color: var(--bs-secondary-text-emphasis);">Upload Image</span></a></li>
                </ul>
                <div class="text-center d-none d-md-inline"><button class="btn rounded-circle border-0" id="sidebarToggle" type="button"></button></div>
            </div>
        </nav>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <nav class="navbar navbar-expand bg-white shadow mb-4 topbar static-top navbar-light">
                    <div class="container-fluid">
                        <button class="btn btn-link d-md-none rounded-circle me-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button>
                        <ul class="navbar-nav flex-nowrap ms-auto">
                            <li class="nav-item dropdown no-arrow">
                                <div class="nav-item dropdown no-arrow">
                                    <a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#"><i class="far fa-user" style="margin-right: 21px;font-size: 27px;"></i><span class="d-none d-lg-inline me-2 text-gray-600 small">Admin</span></a>
                                    <div class="dropdown-menu shadow dropdown-menu-end animated--grow-in">
                                        <a class="dropdown-item" href="#"><i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Profile</a>
                                        <a class="dropdown-item" href="#"><i class="fas fa-cogs fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Settings</a>
                                        <a class="dropdown-item" href="#"><i class="fas fa-list fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Activity log</a>
                                        <div class="dropdown-divider"></div>
                                        <form action="{{ route('admin.logout') }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="dropdown-item"><i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Logout</button>
                                        </form>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
                <div class="container-fluid">
                    <h3 class="text-dark mb-4">Sales</h3>
                    <div class="card shadow">
                        <div class="card-body">
                            <div class="row mb-3 align-items-center">
                                <div class="col-md-8 d-flex align-items-center flex-wrap">
                                    <input type="text" id="searchInput" class="form-control me-3 mb-2 mb-md-0" placeholder="Search..." style="max-width:320px;">

                                    <div class="d-flex flex-wrap align-items-center">
                                        <div class="form-check form-check-inline me-2">
                                            <input class="form-check-input search-column" type="checkbox" id="searchItem" value="1" checked>
                                            <label class="form-check-label" for="searchsale_id">Sale ID</label>
                                        </div>
                                        <div class="form-check form-check-inline me-2">
                                            <input class="form-check-input search-column" type="checkbox" id="searchPrice" value="2" checked>
                                            <label class="form-check-label" for="searchorder_id">Order ID</label>
                                        </div>
                                        <div class="form-check form-check-inline me-2">
                                            <input class="form-check-input search-column" type="checkbox" id="searchQuantity" value="3" checked>
                                            <label class="form-check-label" for="searchsale_type">Sale Type</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 text-md-end">
                                    <button class="btn btn-primary" type="button" style="height: 31px;" onclick="window.location='{{ route('sales.create') }}'">
                                        <i class="far fa-plus-square" style="margin-right: 8px;"></i><strong>Add Sale</strong>
                                    </button>
                                </div>
                            </div>
                            <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
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
                                            <td>{{ $sale->created_at ? $sale->created_at->timezone('Asia/Manila')->format('F d, Y; H:i:s e') : 'N/A' }}</td>
                                            <td>
                                                <a href="{{ route('sales.edit', $sale->sale_id) }}" class="btn btn-sm btn-outline-secondary me-2" title="Edit">
                                                    <i class="far fa-edit"></i>
                                                </a>
                                                <form action="{{ route('sales.destroy', $sale->sale_id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this sale?');">
                                                        <i class="far fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @if($sale->sale_type == 'web-based')
                                        <tr>
                                            <td colspan="5">
                                                <table class="table table-bordered">
                                                    <thead>
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
                                        <tr>
                                            <td colspan="5" class="text-center">No sales data available</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6 align-self-center">
                                    <p id="dataTable_info" class="dataTables_info" role="status" aria-live="polite">
                                        Showing {{ $sales->firstItem() }} to {{ $sales->lastItem() }} of {{ $sales->total() }}
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    {{ $sales->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="bg-white sticky-footer">
                <div class="container my-auto">
                    <div class="text-center my-auto copyright"></div>
                </div>
            </footer>
        </div>
        <a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>
    <script src="{{ asset('h2whoa_admin/assets/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('h2whoa_admin/assets/js/bs-init.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.2/js/jquery.tablesorter.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.2/js/widgets/widget-filter.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.2/js/widgets/widget-storage.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="{{ asset('h2whoa_admin/assets/js/Ludens---1-Index-Table-with-Search--Sort-Filters-v20-Ludens---1-Index-Table-with-Search--Sort-Filters.js') }}"></script>
    <script src="{{ asset('h2whoa_admin/assets/js/Ludens---1-Index-Table-with-Search--Sort-Filters-v20-Ludens---Material-UI-Actions.js') }}"></script>
    <script src="{{ asset('h2whoa_admin/assets/js/theme.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchInput');
            const table = document.getElementById('dataTable');
            const rows = Array.from(table.querySelectorAll('tbody tr'));

            // Helper to determine whether a row is a detail row (follows a main sale row)
            function isDetailRow(row) {
                // detail rows in this table are the ones with a single td colspan (we render them after a parent row)
                const tds = row.querySelectorAll('td');
                return tds.length === 1 && tds[0].hasAttribute('colspan');
            }

            // Search functionality for relevant columns (Sale ID, Order ID, Sale Type)
            searchInput.addEventListener('input', function () {
                const query = searchInput.value.trim().toLowerCase();

                // collect active column filters from checkboxes
                const checkboxEls = Array.from(document.querySelectorAll('.search-column'));
                let activeCols = checkboxEls.filter(cb => cb.checked).map(cb => parseInt(cb.value, 10));

                // If none checked, treat as all columns active
                if (activeCols.length === 0) {
                    activeCols = [1, 2, 3];
                }

                // convert to zero-based cell indexes (value 1 -> cell 0)
                const cellIndexes = activeCols.map(v => v - 1);

                // If empty query, show all rows
                if (!query) {
                    rows.forEach(r => r.style.display = '');
                    return;
                }

                rows.forEach((row, idx) => {
                    if (isDetailRow(row)) {
                        // detail rows visibility is handled together with their parent; hide by default here
                        row.style.display = 'none';
                        return;
                    }

                    const cells = row.querySelectorAll('td');

                    // check only the selected column indexes
                    const matches = cellIndexes.some(ci => {
                        const cell = cells[ci];
                        return cell && cell.textContent.toLowerCase().includes(query);
                    });

                    row.style.display = matches ? '' : 'none';

                    // If this main row has a following detail row, toggle it the same way
                    const nextRow = rows[idx + 1];
                    if (nextRow && isDetailRow(nextRow)) {
                        nextRow.style.display = matches ? '' : 'none';
                    }
                });
            });

            // Sorting functionality for table headers (excluding Actions column)
            const headers = table.querySelectorAll('thead th');
            headers.forEach((header, index) => {
                if (index === 4) return; // Skip Actions column

                header.classList.add('sortable-column');
                header.addEventListener('click', function () {
                    const isAscending = header.classList.toggle('ascending');
                    const direction = isAscending ? 1 : -1;

                    const sortedRows = Array.from(rows).sort((a, b) => {
                        const aText = a.children[index]?.textContent.trim().toLowerCase() || '';
                        const bText = b.children[index]?.textContent.trim().toLowerCase() || '';

                        return aText > bText ? direction : aText < bText ? -direction : 0;
                    });

                    sortedRows.forEach(row => table.querySelector('tbody').appendChild(row));
                });
            });
        });
    </script>
</body>

</html>