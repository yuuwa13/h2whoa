<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>History</title>
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
                <a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="{{ route('admin.history') }}">
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
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.history') }}"><i class="fas fa-history" style="color: var(--bs-accordion-active-color);"></i><span style="color: var(--bs-primary-text-emphasis);">History</span></a></li>
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
                        <form class="d-none d-sm-inline-block me-auto ms-md-3 my-2 my-md-0 mw-100 navbar-search">
                            <div class="input-group">
                                <input class="bg-light form-control border-0 small" type="text" placeholder="Search for ...">
                                <button class="btn btn-primary py-0" type="button"><i class="fas fa-search"></i></button>
                            </div>
                        </form>
                        <ul class="navbar-nav flex-nowrap ms-auto">
                            <li class="nav-item dropdown no-arrow">
                                <div class="nav-item dropdown no-arrow">
                                    <a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#"><i class="far fa-user" style="margin-right: 21px;font-size: 27px;"></i><span class="d-none d-lg-inline me-2 text-gray-600 small">Admin</span></a>
                                    <div class="dropdown-menu shadow dropdown-menu-end animated--grow-in">
                                        <a class="dropdown-item" href="#"><i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Profile</a>
                                        <a class="dropdown-item" href="#"><i class="fas fa-cogs fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Settings</a>
                                        <a class="dropdown-item" href="#"><i class="fas fa-list fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Activity log</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#"><i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Logout</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
                <div class="container-fluid">
                    <h3 class="text-dark mb-4">History</h3>
                    <div class="card shadow">
                        <div class="card-body">
                            <div class="table-responsive">
                                @php
                                    use App\Models\Order;

                                    $orders = Order::whereIn('order_status', ['Delivered', 'Cancelled'])
                                        ->orderByDesc('order_datetime')
                                        ->paginate(10);
                                @endphp

                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Customer</th>
                                            <th>Delivery Details</th>
                                            <th>Order Summary</th>
                                            <th>Payment Information</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($orders as $order)
                                            <tr>
                                                <td>{{ $order->order_id }}<br>
                                                    @if ($order->order_datetime)
                                                        {{ $order->order_datetime->timezone('Asia/Manila')->format('F d, Y') }}<br>
                                                        {{ $order->order_datetime->timezone('Asia/Manila')->format('h:i A') }}<br>
                                                    @else
                                                        <span class="text-danger">Invalid Date</span><br>
                                                    @endif
                                                </td>
                                                <td>{{ $order->customer->name }}<br>{{ $order->customer->phone }}<br>{{ $order->customer->address }}</td>
                                                <td>{{ $order->delivery_details ?? 'N/A' }}</td>
                                                <td>
                                                    @foreach ($order->orderDetails as $detail)
                                                        {{ $detail->quantity }} x {{ $detail->stock->product_name }}<br>
                                                    @endforeach
                                                    <strong>Subtotal:</strong> ₱{{ number_format($order->calculateTotalPrice(), 2) }}<br>
                                                    <strong>Delivery Fee:</strong> ₱{{ number_format($order->delivery_fee ?? 0, 2) }}<br>
                                                    <strong>Total:</strong> ₱{{ number_format($order->amount_paid, 2) }}
                                                </td>
                                                <td><strong>Payment Method:</strong> {{ $order->payment_method->method_name ?? 'N/A' }}<br><strong>Transaction Ref:</strong> {{ $order->transaction_reference ?? 'N/A' }}</td>
                                                <td>
                                                    <strong>{{ $order->order_status }}</strong><br>
                                                    @if ($order->updated_at)
                                                        <small>{{ $order->updated_at->timezone('Asia/Manila')->format('F d, Y h:i A') }}</small>
                                                    @else
                                                        <small class="text-danger">No Update Time</small>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">No orders found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>

                                <div class="d-flex justify-content-center mt-3">
                                    {{ $orders->links() }}
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
</body>

</html>