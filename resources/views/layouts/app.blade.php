<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>@yield('title', 'H2WHOA')</title>
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i&amp;display=swap">
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
    <style nonce="{{ csp_nonce() }}">
        :root {
            --brand: #4ac9b0;
            --brand-dark: #35b39a;
        }

        /* ── Navbar ── */
        .clean-navbar {
            border-bottom: 1px solid #e9ecef;
            box-shadow: 0 2px 8px rgba(0,0,0,.06);
        }
        .navbar-brand span {
            font-family: 'Montserrat', sans-serif;
            font-size: 1.3rem;
            letter-spacing: .04em;
            color: #1a1a2e;
        }
        .navbar .nav-link {
            font-family: 'Montserrat', sans-serif;
            font-size: .8rem;
            font-weight: 600;
            letter-spacing: .08em;
            color: #444 !important;
            padding: .5rem .9rem;
            transition: color .2s;
        }
        .navbar .nav-link:hover {
            color: var(--brand) !important;
        }
        .navbar .nav-link.active {
            color: var(--brand) !important;
        }
        .nav-user strong {
            font-size: .9rem;
        }
        .nav-user small {
            font-size: .75rem;
            color: #888;
        }
        .nav-user .fa-user {
            font-size: 1.4rem;
            color: var(--brand);
        }

        /* ── Page body ── */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7fa;
        }
        .page-wrap {
            padding-top: 80px;
        }

        /* ── Footer ── */
        .page-footer {
            position: relative !important;
            background-color: #1a1a2e !important;
            color: #adb5bd;
            padding: 3rem 0 0;
        }
        .page-footer h5 {
            color: #fff;
            font-size: .85rem;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
            margin-bottom: 1rem;
        }
        .page-footer ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .page-footer ul li {
            margin-bottom: .5rem;
        }
        .page-footer ul li a {
            color: #adb5bd;
            text-decoration: none;
            font-size: .85rem;
            transition: color .2s;
        }
        .page-footer ul li a:hover {
            color: var(--brand);
        }
        .footer-copy {
            text-align: center;
            font-size: .78rem;
            color: #adb5bd;
            margin-top: 2rem;
            padding-top: 1.5rem;
            padding-bottom: 1.5rem;
            border-top: 1px solid #2d2d4e;
            margin-bottom: 0;
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">

    <nav class="navbar navbar-expand-lg fixed-top bg-white clean-navbar">
        <div class="container">
            <a class="navbar-brand logo d-flex align-items-center gap-2" href="{{ route('orders.index') }}">
                <img src="{{ asset('h2whoa_user/assets/img/elements/h2whoa_logo.png') }}" alt="H2WHOA Logo" width="48" height="48">
                <span>H2WHOA</span>
            </a>

            <button data-bs-target="#navcol-1" data-bs-toggle="collapse" class="navbar-toggler border-0">
                <span class="visually-hidden">Toggle navigation</span>
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('orders.index') ? 'active' : '' }}" href="{{ route('orders.index') }}">Orders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('track.orders') ? 'active' : '' }}" href="{{ route('track.orders') }}">Track</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('orders.history') ? 'active' : '' }}" href="{{ route('orders.history') }}">History</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('contact.us') ? 'active' : '' }}" href="{{ route('contact.us') }}">Contact</a>
                    </li>

                    @auth('customer')
                        <li class="nav-item ms-lg-3">
                            <a href="{{ route('profile.show') }}" class="d-flex align-items-center gap-2 text-decoration-none nav-user">
                                <i class="far fa-user"></i>
                                <div>
                                    <strong>{{ explode(' ', Auth::guard('customer')->user()->name)[0] }}</strong><br>
                                    <small>Customer</small>
                                </div>
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div class="page-wrap flex-grow-1">
        @yield('content')
    </div>

    <footer class="page-footer">
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <h5>Get Started</h5>
                    <ul>
                        <li><a href="{{ route('orders.index') }}">Home</a></li>
                        <li><a href="{{ route('signup.form') }}">Sign Up</a></li>
                    </ul>
                </div>
                <div class="col-sm-3">
                    <h5>About Us</h5>
                    <ul>
                        <li><a href="{{ route('company.info') }}">Company Information</a></li>
                        <li><a href="{{ route('contact.us') }}">Contact Us</a></li>
                        <li><a href="{{ route('reviews') }}">Reviews</a></li>
                    </ul>
                </div>
                <div class="col-sm-3">
                    <h5>Support</h5>
                    <ul>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Help Desk</a></li>
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
            <p class="footer-copy">© 2026 H2WHOA — L & A Water Refilling Station. All rights reserved.</p>
        </div>
    </footer>

    <script nonce="{{ csp_nonce() }}" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script nonce="{{ csp_nonce() }}" src="{{ asset('h2whoa_user/assets/bootstrap/js/bootstrap.min.js') }}"></script>
    <script nonce="{{ csp_nonce() }}" src="{{ asset('h2whoa_user/assets/js/baguetteBox.min.js') }}"></script>
    <script nonce="{{ csp_nonce() }}" src="{{ asset('h2whoa_user/assets/js/vanilla-zoom.js') }}"></script>
    <script nonce="{{ csp_nonce() }}" src="{{ asset('h2whoa_user/assets/js/theme.js') }}"></script>
    <script nonce="{{ csp_nonce() }}" src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('scripts')
</body>

</html>
