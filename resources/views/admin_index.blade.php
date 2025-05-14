<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Dashboard - H2whoa</title>
    <link rel="stylesheet" href="{{ asset('h2whoa_admin/assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins&amp;display=swap">
    <link rel="stylesheet" href="{{ asset('h2whoa_admin/assets/fonts/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa_admin/assets/css/bs-theme-overrides.css') }}">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.2/css/theme.bootstrap_4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <link rel="stylesheet"
        href="{{ asset('h2whoa_admin/assets/css/Ludens---1-Index-Table-with-Search--Sort-Filters-v20.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>

<body id="page-top">
    <div id="wrapper">
        <nav class="navbar align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0 navbar-dark"
            style="background: rgba(255, 255, 255, 0.04);font-size: 22px;color: rgba(133,135,150,0.04);">
            <div class="container-fluid d-flex flex-column p-0"><a
            class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0"
            href="{{ route('admin.dashboard') }}">
            <picture><img class="img-fluid" width="80" height="60" style="width: 85px;height: 87px;"
                src="{{ asset('h2whoa_admin/assets/img/elements/h2whoa_logo.png') }}"></picture>
            <div class="sidebar-brand-icon rotate-n-15"></div>
            <div class="sidebar-brand-text mx-3"><span
                style="color: var(--bs-primary-text-emphasis);">H2WHOA</span></div>
            </a>
            <hr class="sidebar-divider my-0">
            <ul class="navbar-nav text-light" id="accordionSidebar">
            <li class="nav-item"><a class="nav-link active" href="{{ route('admin.dashboard') }}"
                style="color: var(--bs-emphasis-color);"><i class="fas fa-tachometer-alt"
                style="--bs-primary: rgb(33,33,33);--bs-primary-rgb: 33,33,33;color: var(--bs-accordion-active-color);"></i><span>Dashboard</span></a>
            </li>
            <li class="nav-item"><a class="nav-link" href="{{ route('admin.stocks') }}"><i class="fas fa-user"
                style="color: var(--bs-emphasis-color);"></i><span
                style="color: var(--bs-secondary-text-emphasis);">Stocks</span></a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('admin.orders') }}" style="color: var(--bs-secondary-text-emphasis);"><i
                class="fas fa-table"
                style="padding-left: -24px;color: var(--bs-accordion-active-color);"></i><span>Orders</span></a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('sales.index') }}"><i class="fas fa-cash-register"
                style="color: var(--bs-accordion-active-color);"></i><span
                style="color: var(--bs-secondary-text-emphasis);">Sales</span></a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('admin.history') }}"><i class="fas fa-history"
                style="color: var(--bs-accordion-active-color);"></i><span
                style="color: var(--bs-secondary-text-emphasis);">History</span></a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('admin.activity-log') }}"><i class="fas fa-list"
                style="color: var(--bs-accordion-active-color);"></i><span
                style="color: var(--bs-secondary-text-emphasis);">Activity Log</span></a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('admin.upload-image') }}"><i class="fas fa-upload"
                style="color: var(--bs-accordion-active-color);"></i><span
                style="color: var(--bs-secondary-text-emphasis);">Upload Image</span></a></li>
            </ul>
            <div class="text-center d-none d-md-inline"><button class="btn rounded-circle border-0"
            id="sidebarToggle" type="button"></button></div>
            </div>
        </nav>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <nav class="navbar navbar-expand bg-white shadow mb-4 topbar static-top navbar-light">
                    <div class="container-fluid"><button class="btn btn-link d-md-none rounded-circle me-3"
                            id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button>
                        <form class="d-none d-sm-inline-block me-auto ms-md-3 my-2 my-md-0 mw-100 navbar-search">
                            <div class="input-group"><input class="bg-light form-control border-0 small" type="text"
                                    placeholder="Search for ..."><button class="btn btn-primary py-0" type="button"><i
                                        class="fas fa-search"></i></button></div>
                        </form>
                        <ul class="navbar-nav flex-nowrap ms-auto">
                            <li class="nav-item dropdown d-sm-none no-arrow"><a class="dropdown-toggle nav-link"
                                    aria-expanded="false" data-bs-toggle="dropdown" href="#"><i
                                        class="fas fa-search"></i></a>
                                <div class="dropdown-menu dropdown-menu-end p-3 animated--grow-in"
                                    aria-labelledby="searchDropdown">
                                    <form class="me-auto navbar-search w-100">
                                        <div class="input-group"><input class="bg-light form-control border-0 small"
                                                type="text" placeholder="Search for ...">
                                            <div class="input-group-append"><button class="btn btn-primary py-0"
                                                    type="button"><i class="fas fa-search"></i></button></div>
                                        </div>
                                    </form>
                                </div>
                            </li>
                            <li class="nav-item dropdown no-arrow mx-1">
                                <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link"
                                        aria-expanded="false" data-bs-toggle="dropdown" href="#"></a>
                                    <div class="dropdown-menu dropdown-menu-end dropdown-list animated--grow-in">
                                        <h6 class="dropdown-header">alerts center</h6><a
                                            class="dropdown-item d-flex align-items-center" href="#">
                                            <div class="me-3">
                                                <div class="bg-primary icon-circle"><i
                                                        class="fas fa-file-alt text-white"></i></div>
                                            </div>
                                            <div><span class="small text-gray-500">December 12, 2019</span>
                                                <p>A new monthly report is ready to download!</p>
                                            </div>
                                        </a><a class="dropdown-item d-flex align-items-center" href="#">
                                            <div class="me-3">
                                                <div class="bg-success icon-circle"><i
                                                        class="fas fa-donate text-white"></i></div>
                                            </div>
                                            <div><span class="small text-gray-500">December 7, 2019</span>
                                                <p>$290.29 has been deposited into your account!</p>
                                            </div>
                                        </a><a class="dropdown-item d-flex align-items-center" href="#">
                                            <div class="me-3">
                                                <div class="bg-warning icon-circle"><i
                                                        class="fas fa-exclamation-triangle text-white"></i></div>
                                            </div>
                                            <div><span class="small text-gray-500">December 2, 2019</span>
                                                <p>Spending Alert: We've noticed unusually high spending for your
                                                    account.</p>
                                            </div>
                                        </a><a class="dropdown-item text-center small text-gray-500" href="#">Show All
                                            Alerts</a>
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item dropdown no-arrow mx-1">
                                <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link"
                                        aria-expanded="false" data-bs-toggle="dropdown" href="#"></a>
                                    <div class="dropdown-menu dropdown-menu-end dropdown-list animated--grow-in">
                                        <h6 class="dropdown-header">alerts center</h6><a
                                            class="dropdown-item d-flex align-items-center" href="#">
                                            <div class="dropdown-list-image me-3"><img class="rounded-circle"
                                                    src="avatars/avatar4.jpeg">
                                                <div class="bg-success status-indicator"></div>
                                            </div>
                                            <div class="fw-bold">
                                                <div class="text-truncate"><span>Hi there! I am wondering if you can
                                                        help me with a problem I've been having.</span></div>
                                                <p class="small text-gray-500 mb-0">Emily Fowler - 58m</p>
                                            </div>
                                        </a><a class="dropdown-item d-flex align-items-center" href="#">
                                            <div class="dropdown-list-image me-3"><img class="rounded-circle"
                                                    src="avatars/avatar2.jpeg">
                                                <div class="status-indicator"></div>
                                            </div>
                                            <div class="fw-bold">
                                                <div class="text-truncate"><span>I have the photos that you ordered last
                                                        month!</span></div>
                                                <p class="small text-gray-500 mb-0">Jae Chun - 1d</p>
                                            </div>
                                        </a><a class="dropdown-item d-flex align-items-center" href="#">
                                            <div class="dropdown-list-image me-3"><img class="rounded-circle"
                                                    src="avatars/avatar3.jpeg">
                                                <div class="bg-warning status-indicator"></div>
                                            </div>
                                            <div class="fw-bold">
                                                <div class="text-truncate"><span>Last month's report looks great, I am
                                                        very happy with the progress so far, keep up the good
                                                        work!</span></div>
                                                <p class="small text-gray-500 mb-0">Morgan Alvarez - 2d</p>
                                            </div>
                                        </a><a class="dropdown-item d-flex align-items-center" href="#">
                                            <div class="dropdown-list-image me-3"><img class="rounded-circle"
                                                    src="avatars/avatar5.jpeg">
                                                <div class="bg-success status-indicator"></div>
                                            </div>
                                            <div class="fw-bold">
                                                <div class="text-truncate"><span>Am I a good boy? The reason I ask is
                                                        because someone told me that people say this to all dogs, even
                                                        if they aren't good...</span></div>
                                                <p class="small text-gray-500 mb-0">Chicken the Dog · 2w</p>
                                            </div>
                                        </a><a class="dropdown-item text-center small text-gray-500" href="#">Show All
                                            Alerts</a>
                                    </div>
                                </div>
                                <div class="shadow dropdown-list dropdown-menu dropdown-menu-end"
                                    aria-labelledby="alertsDropdown"></div>
                            </li>
                            <div class="d-none d-sm-block topbar-divider"></div>
                            <li class="nav-item dropdown no-arrow">
                                <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link"
                                        aria-expanded="false" data-bs-toggle="dropdown" href="#"><i class="far fa-user"
                                            style="margin-right: 21px;font-size: 27px;"></i><span
                                            class="d-none d-lg-inline me-2 text-gray-600 small">Admin</span></a>
                                    <div class="dropdown-menu shadow dropdown-menu-end animated--grow-in"><a
                                            class="dropdown-item" href="#"><i
                                                class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Profile</a><a
                                            class="dropdown-item" href="#"><i
                                                class="fas fa-cogs fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Settings</a><a
                                            class="dropdown-item" href="#"><i
                                                class="fas fa-list fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Activity
                                            log</a>
                                        <div class="dropdown-divider"></div><a class="dropdown-item" href="#"><i
                                                class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Logout</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
                <div class="container-fluid">
                    <div class="d-sm-flex justify-content-between align-items-center mb-4">
                        <h3 class="text-dark mb-0">Dashboard</h3><a
                            class="btn btn-primary btn-sm d-none d-sm-inline-block" role="button" href="#"><i
                                class="fas fa-download fa-sm text-white-50"></i>&nbsp;Generate Report</a>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-xl-3 mb-4">
                            <div class="card shadow border-start-primary py-2">
                                <div class="card-body">
                                    <div class="row align-items-center no-gutters">
                                        <div class="col me-2">
                                            <div class="text-uppercase text-primary fw-bold text-xs mb-1"><span>Daily
                                                    Sales</span></div>
                                            <div class="text-dark fw-bold h5 mb-0"><span>₱ {{ number_format($dailySales, 2) }}</span></div>
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
                                            <div class="text-uppercase text-success fw-bold text-xs mb-1"><span
                                                    style="color: var(--bs-primary-text-emphasis);">Earnings
                                                    (monthly)</span></div>
                                            <div class="text-dark fw-bold h5 mb-0"><span>₱ {{ number_format($monthlyEarnings, 2) }}</span></div>
                                        </div>
                                        <div class="col-auto"><i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-3 mb-4">
                            <div class="card shadow border-start-success py-2">
                                <div class="card-body">
                                    <div class="row align-items-center no-gutters">
                                        <div class="col me-2">
                                            <div class="text-uppercase text-success fw-bold text-xs mb-1"><span
                                                    style="color: var(--bs-primary-text-emphasis);">Earnings
                                                    (annual)</span></div>
                                            <div class="text-dark fw-bold h5 mb-0"><span>₱ {{ number_format($yearlyEarnings, 2) }}</span></div>
                                        </div>
                                        <div class="col-auto"><i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-3 mb-4">
                            <div class="card shadow border-start-warning py-2">
                                <div class="card-body">
                                    <div class="row align-items-center no-gutters">
                                        <div class="col me-2">
                                            <div class="text-uppercase text-warning fw-bold text-xs mb-1"><span
                                                    style="color: var(--bs-navbar-active-color);">Pending Orders</span>
                                            </div>
                                            <div class="text-dark fw-bold h5 mb-0"><span>{{ $pendingOrders }}</span></div>
                                        </div>
                                        <div class="col-auto"><i class="fas fa-comments fa-2x text-gray-300"></i></div>
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
                                        <button class="btn btn-link btn-sm dropdown-toggle" aria-expanded="false" data-bs-toggle="dropdown" type="button">
                                            <i class="fas fa-ellipsis-v text-gray-400"></i>
                                        </button>
                                        <div class="dropdown-menu shadow dropdown-menu-end animated--fade-in">
                                            <p class="text-center dropdown-header">Select Date Range:</p>
                                            <a class="dropdown-item" href="#" onclick="updateGraph('year')">Yearly</a>
                                            <a class="dropdown-item" href="#" onclick="updateGraph('half-year')">Half-Yearly</a>
                                            <a class="dropdown-item" href="#" onclick="updateGraph('month')">Monthly</a>
                                            <a class="dropdown-item" href="#" onclick="updateGraph('week')">Weekly</a>
                                            <a class="dropdown-item" href="#" onclick="showCustomDatePicker()">Custom Range</a>
                                        </div>
                                    </div>
                                </div>
                                <div id="customDatePicker" style="display: none;">
                                    <input id="startDate" type="text" placeholder="Start Date">
                                    <input id="endDate" type="text" placeholder="End Date">
                                    <button onclick="applyCustomDateRange()">Apply</button>
                                </div>
                                <div class="card-body">
                                    <div class="chart-area">
                                        <canvas id="salesChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">
                                        <span id="currentDate" style="color: rgba(var(--bs-dark-rgb), var(--bs-text-opacity)); background-color: rgb(248, 249, 252);">Date: </span>
                                        <br><br>
                                        <span id="currentTime" style="color: rgba(var(--bs-dark-rgb), var(--bs-text-opacity)); background-color: rgb(248, 249, 252);"></span>
                                    </h4>
                                    <h6 class="text-muted card-subtitle mb-2">Every Drop Counts, Every Order
                                        Matters<br><br></h6>
                                    <p class="card-text">Track orders, manage deliveries, and stay hydrated – all in one
                                        dashboard. Welcome to H2Whoah, your ultimate water station management
                                        system.<br><br></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 mb-4">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="text-primary fw-bold m-0 item-sales-header">Item Sales (Monthly)</h6>
                                    <div class="dropdown no-arrow">
                                        <button class="btn btn-link btn-sm dropdown-toggle" aria-expanded="false" data-bs-toggle="dropdown" type="button">
                                            <i class="fas fa-ellipsis-v text-gray-400"></i>
                                        </button>
                                        <div class="dropdown-menu shadow dropdown-menu-end animated--fade-in">
                                            <p class="text-center dropdown-header">Select Date Range:</p>
                                            <a class="dropdown-item" href="#" onclick="updateItemSales('year')">Yearly</a>
                                            <a class="dropdown-item" href="#" onclick="updateItemSales('half-year')">Half-Yearly</a>
                                            <a class="dropdown-item" href="#" onclick="updateItemSales('month')">Monthly</a>
                                            <a class="dropdown-item" href="#" onclick="updateItemSales('week')">Weekly</a>
                                            <a class="dropdown-item" href="#" onclick="updateItemSales('today')">Today</a>
                                            <a class="dropdown-item" href="#" onclick="showCustomItemSalesPicker()">Custom Range</a>
                                        </div>
                                    </div>
                                </div>
                                <div id="customItemSalesPicker" style="display: none;">
                                    <input id="itemSalesStartDate" type="text" placeholder="Start Date">
                                    <input id="itemSalesEndDate" type="text" placeholder="End Date">
                                    <button onclick="applyCustomItemSalesRange()">Apply</button>
                                </div>
                                <div class="card-body" id="itemSalesContainer">
                                </div>
                            </div>
                            <div class="card shadow mb-4"></div>
                        </div>
                        <div class="col">
                            <div class="carousel slide" data-bs-ride="false" id="carousel-1">
                                <div class="carousel-inner">
                                    <div class="carousel-item active"><img class="w-100 d-block"
                                            src="https://cdn.bootstrapstudio.io/placeholders/1400x800.png"
                                            alt="Slide Image"></div>
                                    <div class="carousel-item"><img class="w-100 d-block"
                                            src="https://cdn.bootstrapstudio.io/placeholders/1400x800.png"
                                            alt="Slide Image"></div>
                                    <div class="carousel-item"><img class="w-100 d-block"
                                            src="https://cdn.bootstrapstudio.io/placeholders/1400x800.png"
                                            alt="Slide Image"></div>
                                </div>
                                <div><a class="carousel-control-prev" href="#carousel-1" role="button"
                                        data-bs-slide="prev"><span class="carousel-control-prev-icon"></span><span
                                            class="visually-hidden">Previous</span></a><a class="carousel-control-next"
                                        href="#carousel-1" role="button" data-bs-slide="next"><span
                                            class="carousel-control-next-icon"></span><span
                                            class="visually-hidden">Next</span></a></div>
                                <div class="carousel-indicators"><button type="button" data-bs-target="#carousel-1"
                                        data-bs-slide-to="0" class="active"></button> <button type="button"
                                        data-bs-target="#carousel-1" data-bs-slide-to="1"></button> <button
                                        type="button" data-bs-target="#carousel-1" data-bs-slide-to="2"></button></div>
                            </div>
                            <div class="carousel slide" data-bs-ride="false" id="carousel-2">
                                <div class="carousel-inner">
                                    <div class="carousel-item active"><img class="w-100 d-block"
                                            src="https://cdn.bootstrapstudio.io/placeholders/1400x800.png"
                                            alt="Slide Image"></div>
                                    <div class="carousel-item"><img class="w-100 d-block"
                                            src="https://cdn.bootstrapstudio.io/placeholders/1400x800.png"
                                            alt="Slide Image"></div>
                                    <div class="carousel-item"><img class="w-100 d-block"
                                            src="https://cdn.bootstrapstudio.io/placeholders/1400x800.png"
                                            alt="Slide Image"></div>
                                </div>
                                <div><a class="carousel-control-prev" href="#carousel-2" role="button"
                                        data-bs-slide="prev"><span class="carousel-control-prev-icon"></span><span
                                            class="visually-hidden">Previous</span></a><a class="carousel-control-next"
                                        href="#carousel-2" role="button" data-bs-slide="next"><span
                                            class="carousel-control-next-icon"></span><span
                                            class="visually-hidden">Next</span></a></div>
                                <div class="carousel-indicators"><button type="button" data-bs-target="#carousel-2"
                                        data-bs-slide-to="0" class="active"></button> <button type="button"
                                        data-bs-target="#carousel-2" data-bs-slide-to="1"></button> <button
                                        type="button" data-bs-target="#carousel-2" data-bs-slide-to="2"></button></div>
                            </div>
                            <div></div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="bg-white sticky-footer">
                <div class="container my-auto">
                    <div class="text-center my-auto copyright"></div>
                </div>
            </footer>
        </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="{{ asset('h2whoa_admin/assets/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('h2whoa_admin/assets/js/chart.min.js') }}"></script>
    <script src="{{ asset('h2whoa_admin/assets/js/bs-init.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.2/js/jquery.tablesorter.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.2/js/widgets/widget-filter.min.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.2/js/widgets/widget-storage.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        flatpickr("#startDate", { dateFormat: "Y-m-d" });
        flatpickr("#endDate", { dateFormat: "Y-m-d" });

        function showCustomDatePicker() {
            document.getElementById('customDatePicker').style.display = 'block';
        }

        function applyCustomDateRange() {
            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;

            if (startDate && endDate) {
                fetch(`/admin/sales-data?start_date=${startDate}&end_date=${endDate}`)
                    .then(response => response.json())
                    .then(data => {
                        const labels = data.map(item => item.date);
                        const sales = data.map(item => item.total_sales);

                        updateChart(labels, sales);
                    });

                document.getElementById('customDatePicker').style.display = 'none';
            } else {
                alert('Please select both start and end dates.');
            }
        }

        function updateGraph(range) {
            let startDate, endDate, rangeLabel;
            const today = new Date();

            if (range === 'year') {
                startDate = new Date(today.getFullYear(), 0, 1).toISOString().split('T')[0];
                endDate = new Date(today.getFullYear(), 11, 31).toISOString().split('T')[0];
                rangeLabel = 'Yearly';
            } else if (range === 'half-year') {
                const midYear = today.getMonth() < 6 ? 0 : 6;
                startDate = new Date(today.getFullYear(), midYear, 1).toISOString().split('T')[0];
                endDate = new Date(today.getFullYear(), midYear + 5, 31).toISOString().split('T')[0];
                rangeLabel = 'Half-Yearly';
            } else if (range === 'month') {
                startDate = new Date(today.getFullYear(), today.getMonth(), 1).toISOString().split('T')[0];
                endDate = new Date(today.getFullYear(), today.getMonth() + 1, 0).toISOString().split('T')[0];
                rangeLabel = 'Monthly';
            } else if (range === 'week') {
                const firstDayOfWeek = new Date(today.setDate(today.getDate() - today.getDay()));
                startDate = firstDayOfWeek.toISOString().split('T')[0];
                endDate = new Date(firstDayOfWeek.setDate(firstDayOfWeek.getDate() + 6)).toISOString().split('T')[0];
                rangeLabel = 'Weekly';
            } else if (range === 'today') {
                startDate = endDate = today.toISOString().split('T')[0];
                rangeLabel = 'Today';
            }

            fetchGraphData(startDate, endDate, rangeLabel);
        }

        function updateChart(labels, sales) {
            const chartContainer = document.querySelector('.chart-area');

            // Remove the existing canvas element
            const oldCanvas = document.getElementById('salesChart');
            if (oldCanvas) {
                console.log('Removing old canvas element.');
                oldCanvas.remove();
            }

            // Create a new canvas element
            const newCanvas = document.createElement('canvas');
            newCanvas.id = 'salesChart';
            chartContainer.appendChild(newCanvas);

            const ctx = newCanvas.getContext('2d');

            // Initialize the chart
            console.log('Initializing new chart instance.');
            window.salesChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Sales',
                        data: sales,
                        backgroundColor: 'rgba(78, 115, 223, 0.05)',
                        borderColor: 'rgba(78, 115, 223, 1)',
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    scales: {
                        x: { grid: { display: false } },
                        y: { grid: { color: 'rgb(234, 236, 244)' } }
                    }
                }
            });
        }

        function fetchGraphData(startDate, endDate, rangeLabel = '') {
            console.log(`Fetching data for range: ${startDate} to ${endDate}`);
            fetch(`/admin/sales-data?start_date=${startDate}&end_date=${endDate}`)
                .then(response => {
                    console.log('Response received:', response);
                    return response.json();
                })
                .then(data => {
                    console.log('Data fetched:', data);
                    const labels = data.map(item => item.date);
                    const sales = data.map(item => item.total_sales);

                    updateChart(labels, sales);

                    // Update the header with the selected range label
                    const earningsHeader = document.querySelector('.earnings-header');
                    earningsHeader.textContent = `Earnings Overview (${rangeLabel})`;
                })
                .catch(error => console.error('Error fetching graph data:', error));
        }

        // Example: Fetch data for the current month on page load
        document.addEventListener('DOMContentLoaded', () => {
            const today = new Date();
            const startDate = new Date(today.getFullYear(), today.getMonth(), 1).toISOString().split('T')[0];
            const endDate = new Date(today.getFullYear(), today.getMonth() + 1, 0).toISOString().split('T')[0];

            fetchGraphData(startDate, endDate);
        });

        function updateDateTime() {
            const now = new Date();

            // Calculate GMT+8 time
            const utc = now.getTime() + now.getTimezoneOffset() * 60000; // Convert to UTC
            const gmt8 = new Date(utc + 8 * 3600000); // Add 8 hours for GMT+8

            const options = { year: 'numeric', month: 'long', day: 'numeric' };
            const dateString = gmt8.toLocaleDateString('en-US', options);

            const timeString = gmt8.toLocaleTimeString('en-US', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: true
            });

            document.getElementById('currentDate').textContent = `Date: ${dateString}`;
            document.getElementById('currentTime').textContent = timeString;
        }

        // Update the date and time every second
        setInterval(updateDateTime, 1000);
        document.addEventListener('DOMContentLoaded', updateDateTime);

        flatpickr("#itemSalesStartDate", { dateFormat: "Y-m-d" });
        flatpickr("#itemSalesEndDate", { dateFormat: "Y-m-d" });

        function showCustomItemSalesPicker() {
            document.getElementById('customItemSalesPicker').style.display = 'block';
        }

        function applyCustomItemSalesRange() {
            const startDate = document.getElementById('itemSalesStartDate').value;
            const endDate = document.getElementById('itemSalesEndDate').value;

            if (startDate && endDate) {
                fetchItemSalesData(startDate, endDate);
                document.getElementById('customItemSalesPicker').style.display = 'none';
            } else {
                alert('Please select both start and end dates.');
            }
        }

        function updateItemSales(range) {
            let startDate, endDate, rangeLabel;
            const today = new Date();

            if (range === 'year') {
                startDate = new Date(today.getFullYear(), 0, 1).toISOString().split('T')[0];
                endDate = new Date(today.getFullYear(), 11, 31).toISOString().split('T')[0];
                rangeLabel = 'Yearly';
            } else if (range === 'half-year') {
                const midYear = today.getMonth() < 6 ? 0 : 6;
                startDate = new Date(today.getFullYear(), midYear, 1).toISOString().split('T')[0];
                endDate = new Date(today.getFullYear(), midYear + 5, 31).toISOString().split('T')[0];
                rangeLabel = 'Half-Yearly';
            } else if (range === 'month') {
                startDate = new Date(today.getFullYear(), today.getMonth(), 1).toISOString().split('T')[0];
                endDate = new Date(today.getFullYear(), today.getMonth() + 1, 0).toISOString().split('T')[0];
                rangeLabel = 'Monthly';
            } else if (range === 'week') {
                const firstDayOfWeek = new Date(today.setDate(today.getDate() - today.getDay()));
                startDate = firstDayOfWeek.toISOString().split('T')[0];
                endDate = new Date(firstDayOfWeek.setDate(firstDayOfWeek.getDate() + 6)).toISOString().split('T')[0];
                rangeLabel = 'Weekly';
            } else if (range === 'today') {
                startDate = endDate = today.toISOString().split('T')[0];
                rangeLabel = 'Today';
            }

            fetchItemSalesData(startDate, endDate, rangeLabel);
        }

        const progressBarColors = [
            'bg-primary', 'bg-success', 'bg-danger', 'bg-warning', 'bg-info',
            'bg-secondary', 'bg-dark', 'bg-light', 'bg-purple', 'bg-teal'
        ];

        function fetchItemSalesData(startDate, endDate, rangeLabel = '') {
            fetch(`/admin/item-sales-data?start_date=${startDate}&end_date=${endDate}`)
                .then(response => response.json())
                .then(data => {
                    const container = document.getElementById('itemSalesContainer');
                    container.innerHTML = '';

                    const totalSales = data.reduce((sum, item) => sum + item.total_quantity, 0);

                    data.forEach((item, index) => {
                        const colorClass = progressBarColors[index % progressBarColors.length];
                        const percentage = ((item.total_quantity / totalSales) * 100).toFixed(2);
                        const progressBar = `
                            <h4 class="small fw-bold">${item.product_name}<span class="float-end">${percentage}% - ${item.total_quantity} sold</span></h4>
                            <div class="progress mb-4">
                                <div class="progress-bar ${colorClass}" aria-valuenow="${percentage}" aria-valuemin="0" aria-valuemax="100" style="width: ${percentage}%;">
                                    <span class="visually-hidden">${percentage}%</span>
                                </div>
                            </div>
                        `;
                        container.innerHTML += progressBar;
                    });

                    // Update the header with the selected range label
                    const itemSalesHeader = document.querySelector('.item-sales-header');
                    itemSalesHeader.textContent = `Item Sales (${rangeLabel})`;
                })
                .catch(error => console.error('Error fetching item sales data:', error));
        }

        // Fetch data for the current month on page load
        document.addEventListener('DOMContentLoaded', () => {
            const today = new Date();
            const startDate = new Date(today.getFullYear(), today.getMonth(), 1).toISOString().split('T')[0];
            const endDate = new Date(today.getFullYear(), today.getMonth() + 1, 0).toISOString().split('T')[0];

            fetchItemSalesData(startDate, endDate);
        });
    </script>
</body>

</html>