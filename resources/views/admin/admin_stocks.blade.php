<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Stocks</title>
    <link rel="stylesheet" href="{{ asset('h2whoa/assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins&amp;display=swap">
    <link rel="stylesheet" href="{{ asset('h2whoa/assets/fonts/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa/assets/css/bs-theme-overrides.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.2/css/theme.bootstrap_4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <link rel="stylesheet" href="{{ asset('h2whoa/assets/css/Ludens---1-Index-Table-with-Search--Sort-Filters-v20.css') }}">
</head>

<body id="page-top">
    <div id="wrapper">
        <nav class="navbar align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0 navbar-dark" style="background: rgba(255, 255, 255, 0.04);font-size: 22px;color: rgba(133,135,150,0.04);">
            <div class="container-fluid d-flex flex-column p-0"><a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="#">
                    <picture><img class="img-fluid" width="80" height="60" style="width: 85px;height: 87px;" src="assets/img/elements/h2whoa%20logo.png"></picture>
                    <div class="sidebar-brand-icon rotate-n-15"></div>
                    <div class="sidebar-brand-text mx-3"><span style="color: var(--bs-primary-text-emphasis);">H2WHOA</span></div>
                </a>
                <hr class="sidebar-divider my-0">
                <ul class="navbar-nav text-light" id="accordionSidebar">
                    <li class="nav-item"><a class="nav-link" href="index.html" style="color: var(--bs-emphasis-color);"><i class="fas fa-tachometer-alt" style="--bs-primary: rgb(33,33,33);--bs-primary-rgb: 33,33,33;color: var(--bs-accordion-active-color);"></i><span>Dashboard</span></a></li>
                    <li class="nav-item"><a class="nav-link active" href="admin_stocks.html"><i class="fas fa-user" style="color: var(--bs-emphasis-color);"></i><span style="color: var(--bs-secondary-text-emphasis);">Stocks</span></a><a class="nav-link" href="admin_orders.html" style="color: var(--bs-secondary-text-emphasis);"><i class="fas fa-table" style="padding-left: -24px;color: var(--bs-accordion-active-color);"></i><span>Orders</span></a><a class="nav-link" href="admin_history.html"><i class="fas fa-history" style="color: var(--bs-accordion-active-color);"></i><span style="color: var(--bs-secondary-text-emphasis);">History</span></a></li>
                    <li class="nav-item"></li>
                    <li class="nav-item"></li>
                    <li class="nav-item"></li>
                </ul>
                <div class="text-center d-none d-md-inline"><button class="btn rounded-circle border-0" id="sidebarToggle" type="button"></button></div>
            </div>
        </nav>
        <div class="container-fluid">
            <h3 class="text-dark mb-4">Stocks</h3>
            <div class="card shadow">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6 text-nowrap">
                            <div id="dataTable_length" class="dataTables_length" aria-controls="dataTable"></div>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <!-- Create button linking to stocks.create route -->
                            <a href="{{ route('stocks.create') }}" class="btn btn-primary me-3">
                                <i class="far fa-plus-square me-1"></i><strong>Add Stock</strong>
                            </a>
                            <!-- search field -->
                            <label class="form-label">
                                <input type="search" class="form-control form-control-sm" aria-controls="dataTable" placeholder="Search">
                            </label>
                        </div>
                    </div>
                    <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                        <table class="table my-0" id="dataTable">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Item</th>
                                    <th>Price</th>
                                    <th>Stock Quantity</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stocks as $stock)
                                <tr>
                                    <td>
                                        <img class="rounded-circle me-2" width="30" height="30" src="{{ asset($stock->image_path ?? 'assets/img/elements/default.png') }}" alt="{{ $stock->product_name }}">
                                    </td>
                                    <td>{{ $stock->product_name }}</td>
                                    <td>₱ {{ number_format($stock->price_per_unit, 2) }}</td>
                                    <td>{{ $stock->quantity }}</td>
                                    <td>
                                        <!-- Edit Button Route -->
                                        <a href="{{ route('stocks.edit', $stock->stock_id) }}" class="btn btn-sm btn-outline-secondary me-2" title="Edit">
                                            <i class="far fa-edit"></i>
                                        </a>
                                        <!-- Delete Button Route -->
                                        <form action="{{ route('stocks.destroy', $stock->stock_id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn btn-sm btn-outline-danger"
                                                    title="Delete"
                                                    onclick="return confirm('Are you sure you want to delete this stock item?');">
                                                <i class="far fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6 align-self-center">
                            <p id="dataTable_info" class="dataTables_info" role="status" aria-live="polite">
                                Showing {{ $stocks->firstItem() }} to {{ $stocks->lastItem() }} of {{ $stocks->total() }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            {{ $stocks->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
                </nav>
                
            <footer class="bg-white sticky-footer">
                <div class="container my-auto">
                    <div class="text-center my-auto copyright"></div>
                </div>
            </footer>
        </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>
    <script src="{{ asset('h2whoa/assets/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('h2whoa/assets/js/bs-init.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.2/js/jquery.tablesorter.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.2/js/widgets/widget-filter.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.2/js/widgets/widget-storage.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="{{ asset('h2whoa/assets/js/Ludens---1-Index-Table-with-Search--Sort-Filters-v20-Ludens---1-Index-Table-with-Search--Sort-Filters.js') }}"></script>
    <script src="{{ asset('h2whoa/assets/js/Ludens---1-Index-Table-with-Search--Sort-Filters-v20-Ludens---Material-UI-Actions.js') }}"></script>
    <script src="{{ asset('h2whoa/assets/js/theme.js') }}"></script>
</body>

</html>