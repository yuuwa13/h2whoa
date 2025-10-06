<!-- filepath: c:\xampp\htdocs\H2WHOA\h2whoa\resources\views\layouts\app.blade.php -->
<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>@yield('title', 'H2WHOA')</title>
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins&amp;display=swap">
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/fonts/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/css/baguetteBox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/css/Banner-Heading-Image-images.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/css/Bootstrap-Payment-Form-.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/css/bs-theme-overrides.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/css/Company-Invoice.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/css/Contact-Form-v2-Modal--Full-with-Google-Map.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/css/dh-row-titile-text-image-right-1.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/css/Features-Image-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/css/Map-Location-5-styles.min.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/css/vanilla-zoom.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>

<body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg fixed-top bg-body clean-navbar navbar-light">
        <div class="container">
            <a class="navbar-brand logo d-flex align-items-center" href="{{ route('orders.index') }}">
                <img src="{{ asset('h2whoa_user/assets/img/elements/h2whoa_logo.png') }}" alt="H2WHOA Logo" width="100"
                    height="80" class="me-2">
                <span class="fw-bold">H2WHOA</span>
            </a>
            <div class="collapse navbar-collapse text-start" id="navcol-1" style="">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item text-center" style="padding-right: 33px;">
                        <a class="nav-link text-end" href="{{ route('orders.index') }}"
                            style="width: 99px; height: 32px; text-align: center; font-size: 22px;">ORDERS</a>
                    </li>
                    <li class="nav-item text-center" style="padding-right: 33px;">
                        <a class="nav-link text-end" href="{{ route('track.orders') }}"
                            style="width: 99px; height: 32px; text-align: center; font-size: 22px;">TRACK</a>
                    </li>
                    <li class="nav-item" style="padding-right: 33px;">
                        <a class="nav-link" href="{{ route('orders.history') }}"
                            style="width: 99px; height: 32px; text-align: center; font-size: 22px;">HISTORY</a>
                    </li>
                    <li class="nav-item" style="padding-right: 50px;">
                        <a class="nav-link" href="{{ route('contact.us') }}"
                            style="width: 99px; height: 32px; text-align: center; font-size: 22px;">CONTACT</a>
                    </li>

                    @auth('customer')
                        <li class="nav-item mt-2 mt-lg-0">
                            <a href="{{ route('profile.show') }}" class="d-flex align-items-center text-decoration-none">
                                <i class="far fa-user me-2" style="font-size:2rem;"></i>
                                <div class="text-truncate" style="max-width: 10rem; font-size: 18px;">
                                    <strong>{{ explode(' ', Auth::guard('customer')->user()->name)[0] }}</strong><br>
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

    <main class="page flex-grow-1" style="padding-top: 150px;">
        @yield('content')
    </main>


    <footer class="page-footer dark mt-auto">
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <h5>Get started</h5>
                    <ul>
                        <li><a href="{{ route('orders.index') }}">Home</a></li>
                        <li><a href="{{ route('signup.form') }}">Sign up</a></li>
                        <li><a href="#">Downloads</a></li>
                    </ul>
                </div>
                <div class="col-sm-3">
                    <h5>About us</h5>
                    <ul>
                        <li><a href="{{ route('company.info') }}">Company Information</a></li>
                        <li><a href="{{ route('contact.us') }}">Contact us</a></li>
                        <li><a href="{{ route('reviews') }}">Reviews</a></li>
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
                        <li><a href="{{ route('legal.tos') }}">Terms of Service</a></li>
                        <li><a href="{{ route('legal.tou') }}">Terms of Use</a></li>
                        <li><a href="{{ route('legal.privacy') }}">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-copyright">
            <p>© 2025 Copyright Text</p>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="{{ asset('h2whoa_user/assets/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('h2whoa_user/assets/js/baguetteBox.min.js') }}"></script>
    <script src="{{ asset('h2whoa_user/assets/js/vanilla-zoom.js') }}"></script>
    <script src="{{ asset('h2whoa_user/assets/js/theme.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('scripts')
</body>

</html>