{{-- filepath: resources/views/online_track.blade.php --}}
<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Track</title>
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins&amp;display=swap">
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/fonts/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/css/baguetteBox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/css/Banner-Heading-Image-images.css') }}">
    <link rel="stylesheet"
        href="{{ asset('h2whoa_user/assets/css/Billing-Table-with-Add-Row--Fixed-Header-Feature.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/css/Bootstrap-Payment-Form-.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/css/bs-theme-overrides.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/css/Company-Invoice.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/css/Contact-Form-v2-Modal--Full-with-Google-Map.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/css/dh-row-titile-text-image-right-1.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/css/Features-Image-icons.css') }}">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.2/css/theme.bootstrap_4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <link rel="stylesheet"
        href="{{ asset('h2whoa_user/assets/css/Ludens---1-Index-Table-with-Search--Sort-Filters-v20.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/css/Map-Location-5-styles.min.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/css/Sidebar-navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/css/Sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/css/vanilla-zoom.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    @if(session('delivery_confirmed'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Delivery Confirmed',
                    text: '{{ session('delivery_confirmed') }}',
                    toast: true,
                    position: 'bottom-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });
            });
        </script>
    @endif

    <main class="page service-page">
        <section class="clean-block clean-services dark">
            <div class="container" style="margin-top: 115px;">
                <div class="block-heading">
                    <h2 class="text-info">Delivery Status</h2>
                    <p><strong>Note:</strong> Once your order status is marked as <strong>"Out for Delivery,"</strong>
                        any changes or modifications to your order will no longer be accepted.</p>
                </div>
                <div class="row">
                    @foreach($orders as $order)
                        @php
                            $snapshot = session("order_snapshot_{$order->order_id}");
                        @endphp
                        <div class="col-md-6 col-lg-4">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h4 class="card-title">Order Number: {{ $order->order_id }}</h4>
                                    <p class="card-text" style="font-size: 1rem; font-weight: bold; margin-bottom: 1rem;">
                                        Order Status:
                                        <span style="color: #4ac9b0;">{{ $order->order_status }}</span>
                                    </p>
                                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                        data-bs-target="#orderModal{{ $order->order_id }}">
                                        View Order
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="orderModal{{ $order->order_id }}" tabindex="-1"
                            aria-labelledby="orderModalLabel{{ $order->order_id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="orderModalLabel{{ $order->order_id }}">Order Details -
                                            #{{ $order->order_id }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>
                                            <strong>Customer Name:</strong> {{ $order->customer_name }}<br>
                                            <strong>Contact Number:</strong> {{ $order->customer_phone }}<br>
                                            <strong>Delivery Address:</strong> {{ $order->customer_address }}<br>
                                            <strong>Order Date:</strong> {{ $order->order_datetime }}<br>
                                            <strong>Mode of Payment:</strong>
                                            @if($order->payment_method_id == 1)
                                                Cash on Delivery (COD)
                                            @elseif($order->payment_method_id == 2)
                                                Online Payment (GCash)
                                            @endif
                                            <br>
                                            <strong>Order Details:</strong><br>
                                            @foreach($order->orderDetails as $detail)
                                                {{ $detail->quantity }} x {{ $detail->stock->product_name }}<br>
                                            @endforeach
                                            <strong>Subtotal:</strong>
                                            ₱{{ number_format($order->orderDetails->sum('total_price'), 2) }}<br>
                                            <strong>Delivery Fee:</strong> ₱50.00<br>
                                            <strong>Total Amount:</strong> ₱{{ number_format($order->amount_paid, 2) }}<br>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    </main>
    <footer class="page-footer dark">
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <h5>Get started</h5>
                    <ul>
                        <li><a href="#">Home</a></li>
                        <li><a href="#">Sign up</a></li>
                        <li><a href="#">Downloads</a></li>
                    </ul>
                </div>
                <div class="col-sm-3">
                    <h5>About us</h5>
                    <ul>
                        <li><a href="#">Company Information</a></li>
                        <li><a href="#">Contact us</a></li>
                        <li><a href="#">Reviews</a></li>
                    </ul>
                </div>
                <div class="col-sm-3">
                    <h5>Support</h5>
                    <ul>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Help desk</a></li>
                        <li><a href="#">Forums</a></li>
                    </ul>
                </div>
                <div class="col-sm-3">
                    <h5>Legal</h5>
                    <ul>
                        <li><a href="#">Terms of Service</a></li>
                        <li><a href="#">Terms of Use</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-copyright">
            <p>© 2025 Copyright Text</p>
        </div>
    </footer>
    <nav class="navbar navbar-expand-lg fixed-top bg-body clean-navbar navbar-light">
        <div class="container">
            <a class="navbar-brand logo" href="{{ route('track.orders') }}">
                <img width="100" height="80" src="{{ asset('h2whoa_user/assets/img/elements/h2whoa_logo.png') }}">H2WHOA
            </a>
            <div class="collapse navbar-collapse text-start" id="navcol-3"
                style="margin-left: 242px;margin-right: 318px;">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item text-center" style="padding-right: 33px;">
                        <a class="nav-link text-end" href="{{ route('orders.index') }}"
                            style="width: 99px;height: 32px;text-align: center;font-size: 22px;">Order&nbsp;</a>
                    </li>
                    <li class="nav-item text-center" style="padding-right: 33px;">
                        <a class="nav-link text-end active" href="{{ route('track.orders') }}"
                            style="width: 99px;height: 32px;text-align: center;font-size: 22px;">Track</a>
                    </li>
                    <li class="nav-item" style="padding-right: 33px;">
                        <a class="nav-link" href="{{ route('orders.history') }}"
                            style="width: 99px;height: 32px;text-align: center;font-size: 22px;">History</a>
                    </li>
                    <li class="nav-item" style="padding-right: 33px;">
                        <a class="nav-link" href="{{ route('contact.us') }}"
                            style="width: 99px;height: 32px;text-align: center;font-size: 22px;">Contact</a>
                    </li>
                    @auth('customer')
                        <li class="nav-item px-3" style="margin-left: 128px;">
                            <a href="{{ route('profile.show') }}" class="d-flex align-items-center text-decoration-none">
                                <i class="far fa-user me-2" style="font-size:1.8rem;"></i>
                                <div style="max-width:10rem;
                                            font-size:calc(1rem + 0.5vw); 
                                            white-space:nowrap;
                                            overflow:hidden;
                                            text-overflow:ellipsis;">
                                    <strong>{{ explode(' ', auth('customer')->user()->name)[0] }}</strong><br>
                                    <small>Customer</small>
                                </div>
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
            <button data-bs-target="#navcol-1" data-bs-toggle="collapse" class="navbar-toggler">
                <span class="visually-hidden">Toggle navigation</span>
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="{{ asset('h2whoa_user/assets/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('h2whoa_user/assets/js/baguetteBox.min.js') }}"></script>
    <script src="{{ asset('h2whoa_user/assets/js/vanilla-zoom.js') }}"></script>
    <script src="{{ asset('h2whoa_user/assets/js/theme.js') }}"></script>
    <script
        src="{{ asset('h2whoa_user/assets/js/Billing-Table-with-Add-Row--Fixed-Header-Feature-Billing-Table-with-Add-Row--Fixed-Header.js') }}"></script>
    <script src="{{ asset('h2whoa_user/assets/js/Contact-Form-v2-Modal--Full-with-Google-Map-scripts.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.2/js/jquery.tablesorter.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.2/js/widgets/widget-filter.min.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.2/js/widgets/widget-storage.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="{{ asset('h2whoa_user/assets/js/Map-Location-5-script.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>