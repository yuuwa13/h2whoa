<!-- filepath: c:\xampp\htdocs\H2WHOA\h2whoa\resources\views\layouts\app.blade.php -->
<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>@yield('title', 'H2WHOA')</title>
    <link rel="stylesheet" href="{{ asset('h2whoa/assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins&amp;display=swap">
    <link rel="stylesheet" href="{{ asset('h2whoa/assets/css/baguetteBox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa/assets/css/Banner-Heading-Image-images.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa/assets/css/Bootstrap-Payment-Form-.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa/assets/css/bs-theme-overrides.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa/assets/css/Company-Invoice.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa/assets/css/Contact-Form-v2-Modal--Full-with-Google-Map.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa/assets/css/dh-row-titile-text-image-right-1.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa/assets/css/Features-Image-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa/assets/css/Map-Location-5-styles.min.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa/assets/css/vanilla-zoom.min.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa/assets/fonts/font-awesome.min.css') }}">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top py-3 shadow-sm">
      <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('orders.index') }}">
          <img src="{{ asset('h2whoa/assets/img/assets/h2whoa_logo.png') }}"
               alt="H2WHOA Logo" width="80" height="60" class="me-2">
          <strong class="fs-4">H2WHOA</strong>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav"><span class="navbar-toggler-icon"></span></button>
  
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
          <ul class="navbar-nav align-items-center">
            <li class="nav-item px-2">
              <a class="nav-link active fs-5" href="{{ route('orders.index') }}">ORDERS</a>
            </li>
            <li class="nav-item px-2">
              <a class="nav-link fs-5" href="{{ route('orders.index') }}">HISTORY</a>
            </li>
            <li class="nav-item px-2">
              <a class="nav-link fs-5" href="{{ route('contact.us') }}">CONTACTS</a>
            </li>
  
            @auth('customer')
                <li class="nav-item px-3">
                <a href="{{ route('profile.show') }}"
                    class="d-flex align-items-center text-decoration-none">
                    <i class="far fa-user me-2" style="font-size:1.8rem;"></i>
                    <div style="max-width:10rem;
                                font-size:calc(1rem + 0.5vw);
                                white-space:nowrap;
                                overflow:hidden;
                                text-overflow:ellipsis;">
                    <strong>{{ Auth::guard('customer')->user()->name }}</strong><br>
                    <small>Customer</small>
                    </div>
                </a>
                </li>
                @endauth
          </ul>
        </div>
      </div>
    </nav>
  
    <main class="page" style="padding-top: 180px;">
      @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
      @endif
      
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

    <script src="{{ asset('h2whoa/assets/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('h2whoa/assets/js/baguetteBox.min.js') }}"></script>
    <script src="{{ asset('h2whoa/assets/js/vanilla-zoom.js') }}"></script>
    <script src="{{ asset('h2whoa/assets/js/theme.js') }}"></script>
    <script src="{{ asset('h2whoa/assets/js/Contact-Form-v2-Modal--Full-with-Google-Map-scripts.js') }}"></script>
    <script src="{{ asset('h2whoa/assets/js/Map-Location-5-script.min.js') }}"></script>
    @stack('scripts')
</body>

</html>