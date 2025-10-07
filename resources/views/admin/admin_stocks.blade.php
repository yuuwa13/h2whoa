<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Stocks</title>
    <link rel="stylesheet" href="{{ asset('h2whoa_admin/assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins&display=swap">
    <link rel="stylesheet" href="{{ asset('h2whoa_admin/assets/fonts/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa_admin/assets/css/bs-theme-overrides.css') }}">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.2/css/theme.bootstrap_4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <link rel="stylesheet"
        href="{{ asset('h2whoa_admin/assets/css/Ludens---1-Index-Table-with-Search--Sort-Filters-v20.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        /* ========= RESPONSIVENESS ========= */

        /* Sidebar (light color, default visible) */
        .sidebar {
            background-color: #f8f9fa !important;
            color: #212529;
            min-height: 100vh;
            width: 250px;
            flex-shrink: 0;
        }

        .sidebar .nav-link {
            color: #212529;
        }

        .sidebar .nav-link.active {
            background-color: #e9ecef;
            font-weight: 600;
        }

        .sidebar .nav-link:hover {
            background-color: #e2e6ea;
        }

        /* Hide sidebar only on small mobile (<768px) */
        @media (max-width: 767.98px) {
            .sidebar {
                position: fixed;
                top: 0;
                left: 0;
                width: 250px;
                height: 100vh;
                z-index: 1050;
                overflow-y: auto;
                transform: translateX(-100%);
                transition: transform 0.3s ease-in-out;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            #sidebarToggleTop {
                display: inline-block;
            }

            body.sidebar-open {
                overflow: hidden;
            }
        }

        /* Table + form responsiveness */
        .table-responsive {
            overflow-x: auto;
        }

        @media (max-width: 768px) {
            #searchInput {
                margin-bottom: 10px;
            }

            .dataTables_filter {
                text-align: left;
                margin-top: 10px;
            }

            .dataTables_filter .btn {
                width: 100%;
                margin-bottom: 8px;
            }

            .form-check-inline {
                display: block;
                margin-bottom: 5px;
            }
        }

        @media (max-width: 576px) {

            table td,
            table th {
                font-size: 13px;
                white-space: nowrap;
            }

            .btn {
                font-size: 13px;
                padding: 5px 8px;
            }
        }

        /* Navbar (default white) */
        .navbar-light {
            background-color: #fff !important;
        }

        /* Scroll-to-top */
        .scroll-to-top {
            position: fixed;
            right: 1rem;
            bottom: 1rem;
            z-index: 1030;
        }
    </style>

</head>

<body id="page-top">
    <div id="wrapper" class="d-flex">

        <!-- Sidebar (light version) -->
        <nav class="navbar align-items-start sidebar p-0 navbar-light border-end">
            <div class="container-fluid d-flex flex-column p-0">
                <a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0"
                    href="{{ route('admin.stocks') }}">
                    <picture>
                        <img class="img-fluid" width="80" height="60" style="width: 85px;height: 87px;"
                            src="{{ asset('h2whoa_admin/assets/img/elements/h2whoa_logo.png') }}">
                    </picture>
                    <div class="sidebar-brand-text mx-3"><span>H2WHOA</span></div>
                </a>
                <hr class="sidebar-divider my-0">
                <ul class="navbar-nav" id="accordionSidebar">
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}"><i
                                class="fas fa-tachometer-alt"></i><span>Dashboard</span></a></li>
                    <li class="nav-item"><a class="nav-link active" href="{{ route('admin.stocks') }}"><i
                                class="fas fa-user"></i><span>Stocks</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.orders') }}"><i
                                class="fas fa-table"></i><span>Orders</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('sales.index') }}"><i
                                class="fas fa-cash-register"></i><span>Sales</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.history') }}"><i
                                class="fas fa-history"></i><span>History</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.activity-log') }}"><i
                                class="fas fa-list"></i><span>Activity Log</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.upload-image') }}"><i
                                class="fas fa-upload"></i><span>Upload Image</span></a></li>
                </ul>
            </div>
        </nav>

        <!-- Content -->
        <div class="d-flex flex-column flex-grow-1" id="content-wrapper">
            <div id="content">

                <!-- Top Navbar (default white) -->
                <nav class="navbar navbar-expand shadow mb-4 topbar static-top navbar-light">
                    <div class="container-fluid">
                        <button class="btn btn-link d-md-none rounded-circle me-3" id="sidebarToggleTop" type="button">
                            <i class="fas fa-bars"></i>
                        </button>
                        <form class="d-none d-sm-inline-block me-auto ms-md-3 my-2 my-md-0 mw-100 navbar-search">
                            <div class="input-group">
                                <input class="bg-light form-control border-0 small" type="text"
                                    placeholder="Search for ...">
                                <button class="btn btn-primary py-0" type="button"><i
                                        class="fas fa-search"></i></button>
                            </div>
                        </form>
                        <ul class="navbar-nav flex-nowrap ms-auto">
                            <li class="nav-item dropdown no-arrow">
                                <a class="dropdown-toggle nav-link" data-bs-toggle="dropdown" href="#">
                                    <i class="far fa-user me-2" style="font-size: 22px;"></i>
                                    <span class="d-none d-lg-inline text-gray-600 small">Admin</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end shadow">
                                    <a class="dropdown-item" href="#"><i
                                            class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i>Profile</a>
                                    <a class="dropdown-item" href="#"><i
                                            class="fas fa-cogs fa-sm fa-fw me-2 text-gray-400"></i>Settings</a>
                                    <a class="dropdown-item" href="#"><i
                                            class="fas fa-list fa-sm fa-fw me-2 text-gray-400"></i>Activity Log</a>
                                    <div class="dropdown-divider"></div>
                                    <form action="{{ route('admin.logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item"><i
                                                class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i>Logout</button>
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>

                <!-- Main Content -->
                <div class="container-fluid">
                    <h3 class="text-dark mb-4">Stocks</h3>
                    <div class="card shadow">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-12 col-md-6 mb-2">
                                    <input type="text" id="searchInput" class="form-control" placeholder="Search...">
                                </div>
                                <div class="col-12 col-md-6 text-md-end text-start">
                                    <button class="btn btn-primary" type="button"
                                        onclick="window.location='{{ route('stocks.create') }}'">
                                        <i class="far fa-plus-square me-2"></i><strong>Add Stocks</strong>
                                    </button>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-12">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input search-column" type="checkbox" id="searchItem"
                                            value="1" checked>
                                        <label class="form-check-label" for="searchItem">Item</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input search-column" type="checkbox" id="searchPrice"
                                            value="2" checked>
                                        <label class="form-check-label" for="searchPrice">Price</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input search-column" type="checkbox" id="searchStock"
                                            value="3" checked>
                                        <label class="form-check-label" for="searchStock">Stock Quantity</label>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table my-0 sortable" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>Item</th>
                                            <th>Price</th>
                                            <th>Stock Quantity</th>
                                            <th>Availability</th>
                                            <th>Quantifiable</th>
                                            <th>Created At</th>
                                            <th>Last Updated At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($stocks as $stock)
                                            <tr>
                                                <td><img class="img-fluid" width="80" height="60"
                                                        style="width: 85px;height: 87px;"
                                                        src="{{ $stock->uploadedImage ? asset('storage/' . $stock->uploadedImage->file_path) : asset('h2whoa_admin/assets/img/no-image-placeholder.png') }}">
                                                </td>
                                                <td>{{ $stock->product_name }}</td>
                                                <td>₱ {{ number_format($stock->price_per_unit, 2) }}</td>
                                                <td>
                                                    @if ($stock->is_quantifiable)
                                                        {{ $stock->quantity }}
                                                    @else
                                                        <span class="text-muted">Not Applicable</span><br>
                                                        <small>Max Orders: {{ $stock->maximum_orders_allowed }}</small>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="badge"
                                                        style="background-color: {{ $stock->is_available ? 'green' : 'red' }}; color: white;">
                                                        {{ $stock->is_available ? 'Available' : 'Unavailable' }}
                                                    </span>
                                                </td>
                                                <td><input type="checkbox" {{ $stock->is_quantifiable ? 'checked' : '' }}
                                                        disabled></td>
                                                <td>{{ $stock->created_at ? $stock->created_at->timezone('Asia/Manila')->format('F d, Y; H:i:s e') : 'N/A' }}
                                                </td>
                                                <td>{{ $stock->updated_at ? $stock->updated_at->timezone('Asia/Manila')->format('F d, Y; H:i:s e') : 'N/A' }}
                                                </td>
                                                <td>
                                                    <a href="{{ route('stocks.edit', $stock->stock_id) }}"
                                                        class="btn btn-sm btn-outline-secondary me-2" title="Edit">
                                                        <i class="far fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('stocks.destroy', $stock->stock_id) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                                            title="Delete" onclick="return confirm('Are you sure?');">
                                                            <i class="far fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9" class="text-center">No stock data available</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <p>Showing {{ $stocks->firstItem() }} to {{ $stocks->lastItem() }} of
                                        {{ $stocks->total() }}</p>
                                </div>
                                <div class="col-md-6 text-md-end">
                                    {{ $stocks->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <footer class="bg-white sticky-footer">
                <div class="container my-auto text-center small text-muted">
                    © 2025 H2WHOA
                </div>
            </footer>
        </div>

        <a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>

    <script src="{{ asset('h2whoa_admin/assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.querySelector('.sidebar');
            const body = document.body;
            const toggleBtn = document.getElementById('sidebarToggleTop');

            toggleBtn.addEventListener('click', () => {
                sidebar.classList.toggle('show');
                body.classList.toggle('sidebar-open');
            });
        });
    </script>
</body>

</html>