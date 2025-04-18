<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Login - H2WHOA</title>
    <link rel="stylesheet" href="{{ asset('h2whoa/assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins&amp;display=swap">
    <link rel="stylesheet" href="{{ asset('h2whoa/assets/css/baguetteBox.min.css')}}">
    <link rel="stylesheet" href="{{ asset('h2whoa/assets/css/Banner-Heading-Image-images.css')}}">
    <link rel="stylesheet" href="{{ asset('h2whoa/assets/css/Bootstrap-Payment-Form-.css')}}">
    <link rel="stylesheet" href="{{ asset('h2whoa/assets/css/bs-theme-overrides.css')}}">
    <link rel="stylesheet" href="{{ asset('h2whoa/assets/css/Company-Invoice.css')}}">
    <link rel="stylesheet" href="{{ asset('h2whoa/assets/css/Contact-Form-v2-Modal--Full-with-Google-Map.css')}}">
    <link rel="stylesheet" href="{{ asset('h2whoa/assets/css/dh-row-titile-text-image-right-1.css')}}">
    <link rel="stylesheet" href="{{ asset('h2whoa/assets/css/Features-Image-icons.css')}}">
    <link rel="stylesheet" href="{{ asset('h2whoa//assets/css/Map-Location-5-styles.min.css')}}">
    <link rel="stylesheet" href="{{ asset('h2whoa/assets/css/vanilla-zoom.min.css')}}">
</head>

<body>
    <main class="page login-page">
        <section class="clean-block clean-form dark">
            <div class="container">
                <div class="block-heading">
                    <h2 class="text-info"><img src="{{ asset('h2whoa/assets/img/assets/h2whoa_logo.png')}}">H2WHOA</h2>
                    <p style="font-size: 36px;"><strong>CREATE ACCOUNT</strong></p>
                </div>
                <!-- Edited to connect to backend -->
                <form method="POST" action="{{ route('users.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="name">Full Name</label>
                        <input class="form-control item" type="text" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="email">Email Address</label>
                        <input class="form-control item" type="email" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="phone">Phone Number</label>
                        <input class="form-control item" type="text" id="phone" name="phone" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="password">Password</label>
                        <input class="form-control" type="password" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="password_confirmation">Confirm Password</label>
                        <input class="form-control" type="password" id="password_confirmation" name="password_confirmation" required>
                    </div>
                    <button class="btn btn-primary" type="submit" style="background: #4ac9b0;width: 413.2812px;">SIGN UP</button>
                </form>                
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
    <script src="{{asset('h2whoa/assets/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('h2whoa/assets/js/baguetteBox.min.js')}}"></script>
    <script src="{{asset('h2whoa/assets/js/vanilla-zoom.js')}}"></script>
    <script src="{{asset('h2whoa/assets/js/theme.js')}}"></script>
    <script src="{{asset('h2whoa/assets/js/Contact-Form-v2-Modal--Full-with-Google-Map-scripts.js')}}"></script>
    <script src="{{asset('h2whoa/assets/js/Map-Location-5-script.min.js')}}"></script>

    <!-- Success/Error Message -->
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

</body>

</html>