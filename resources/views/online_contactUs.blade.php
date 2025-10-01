<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Contact</title>
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

    <style>
        #map {
            height: 700px;
            width: 100%;
            margin-bottom: 30px;
        }

        .contact-form-container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            margin-bottom: 50px;
            /* Add margin below the contact form */
        }

        .contact-form-container h3 {
            margin-bottom: 20px;
            /* Add space below the heading */
            font-size: 24px;
            font-weight: bold;
            text-align: center;
        }

        .form-floating-label {
            position: relative;
            margin-bottom: 20px;
        }

        .form-floating-label input,
        .form-floating-label textarea {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            outline: none;
        }

        .form-floating-label label {
            position: absolute;
            top: 10px;
            left: 10px;
            font-size: 16px;
            color: #aaa;
            transition: all 0.2s ease-in-out;
            pointer-events: none;
        }

        .form-floating-label input:focus+label,
        .form-floating-label textarea:focus+label,
        .form-floating-label input:not(:placeholder-shown)+label,
        .form-floating-label textarea:not(:placeholder-shown)+label {
            top: -20px;
            left: 10px;
            font-size: 14px;
            color: #007bff;
        }

        .contact-form-container button {
            font-size: 18px;
        }
    </style>
</head>

<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg fixed-top bg-body clean-navbar navbar-light">
        <div class="container">
            <a class="navbar-brand logo" href="{{ route('contact.us') }}">
                <img width="100" height="80" src="{{ asset('h2whoa_user/assets/img/elements/h2whoa_logo.png') }}">H2WHOA
            </a>
            <button data-bs-target="#navcol-1" data-bs-toggle="collapse" class="navbar-toggler">
                <span class="visually-hidden">Toggle navigation</span>
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse text-start" id="navcol-1">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item text-center">
                        <a class="nav-link" href="{{ route('orders.index') }}" style="font-size: 22px;">ORDERS</a>
                    </li>
                    <li class="nav-item text-center">
                        <a class="nav-link" href="{{ route('track.orders') }}" style="font-size: 22px;">TRACK</a>
                    </li>
                    <li class="nav-item text-center">
                        <a class="nav-link" href="{{ route('orders.history') }}" style="font-size: 22px;">HISTORY</a>
                    </li>
                    <li class="nav-item text-center">
                        <a class="nav-link active" href="{{ route('contact.us') }}" style="font-size: 22px;">CONTACT</a>
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
        </div>
    </nav>

    <!-- Map Section -->
    <div id="map"></div>

    <!-- Contact Form Section -->
    <div class="contact-form-container">
        <h3>Contact Us</h3>
        <form method="POST" action="{{ route('contact.send') }}">
            @csrf
            <div class="form-floating-label">
                <input type="text" name="name" id="name" placeholder=" " required>
                <label for="name">Name</label>
            </div>
            <div class="form-floating-label">
                <input type="email" name="email" id="email" placeholder=" " required>
                <label for="email">Email</label>
            </div>
            <div class="form-floating-label">
                <textarea name="message" id="message" placeholder=" " rows="6" required></textarea>
                <label for="message">Message</label>
            </div>
            <button class="btn btn-primary w-100" type="submit">Send</button>
        </form>
    </div>

    <!-- Footer -->
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

    <script>
        function initMap() {
            const location = { lat: 6.41154, lng: 125.60835 }; // Shop's location

            // Initialize the map
            const map = new google.maps.Map(document.getElementById("map"), {
                center: location,
                zoom: 15,
            });

            // Custom blue pin icon
            const customIcon = {
                url: "https://maps.google.com/mapfiles/ms/icons/blue-dot.png", // URL for the blue pin icon
                scaledSize: new google.maps.Size(60, 60), // Resize the icon (width, height)
            };

            // Add a custom marker
            new google.maps.Marker({
                position: location,
                map: map,
                title: "H2WHOA Office",
                icon: customIcon, // Use the custom icon
            });
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key') }}&callback=initMap"
        async defer></script>
</body>

</html>