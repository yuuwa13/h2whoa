<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Online Orders - H2WHOA</title>
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
    <link rel="stylesheet" href="{{ asset('h2whoa/assets/fonts/font-awesome.min.css')}}">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top py-3 shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="orders">
                <img src="{{ asset('h2whoa/assets/img/assets/h2whoa_logo.png')}}" alt="H2WHOA Logo" width="80" height="60" class="me-2">
                <strong class="fs-4">H2WHOA</strong>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item px-2">
                        <a class="nav-link active" href="orders" style="font-size: 22px;">ORDERS</a>
                    </li>
                    <li class="nav-item px-2">
                        <a class="nav-link" href="history" style="font-size: 22px;">HISTORY</a>
                    </li>
                    <li class="nav-item px-2">
                        <a class="nav-link" href="contact-us" style="font-size: 22px;">CONTACTS</a>
                    </li>
                    <li class="nav-item d-flex align-items-center px-3">
                        <i class="far fa-user me-2" style="font-size: 31px;"></i>
                    </li>
                        <div>
                            <strong>KRISTOFFE</strong><br>
                            <small>Customer</small>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <main class="page shopping-cart-page">
        <section class="clean-block clean-cart dark">
            <div class="container">
                <div class="row"></div>
            </div>
            <div class="container" style="padding-top: 143px;">
                <div class="row">
                    <div class="col-md-6">
                        <h4 style="width: 500px;">Your Address</h4>
                        <p style="width: 500px;">Apo ni Lola, San Antonio<br>Matina, Davao City</p>
                    </div>
                    <div class="col-md-6"><button class="btn btn-primary btn-lg d-block w-100" type="button" style="background: #4ac9b0;width: 350.3px;margin-top: 37px;"><i class="fas fa-map-marker" style="font-size: 24px;margin-right: 33px;"></i>Locate Me</button></div>
                </div>
            </div>
            <div class="container">
                <div class="card"></div>
                <div class="content">
                    <div class="row g-0">
                        <div class="col-md-12 col-lg-8">
                            <div class="items">
                                <div class="product">
                                    <div class="row justify-content-center align-items-center" style="border-style: none;">
                                        <div class="col-md-3">
                                            <div class="product-image"><img class="img-fluid d-block mx-auto image" src="{{ asset('h2whoa/assets/img/assets/Gallon.png')}}"></div>
                                        </div>
                                        <div class="col-md-5 product-info"><a class="product-name">WATER GALLON</a>
                                            <div class="product-specs">
                                                <div><span>Amount:&nbsp;</span><span class="value">150.00</span></div>
                                                <div><span>In Stock:&nbsp;</span><span class="value">30</span></div>
                                                <div></div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-2 quantity"><label class="form-label d-none d-md-block" for="quantity">Quantity</label><input type="number" id="number" class="form-control quantity-input" value="1"></div>
                                        <div class="col-6 col-md-2 price"><span><br>₱ 150.00<br><br></span></div>
                                    </div>
                                </div>
                                <div class="product">
                                    <div class="row justify-content-center align-items-center">
                                        <div class="col-md-3">
                                            <div class="product-image"><img class="img-fluid d-block mx-auto image" src="{{ asset('h2whoa/assets/img/assets/Caps.png')}}"></div>
                                        </div>
                                        <div class="col-md-5 product-info"><a class="product-name" href="#">GALLON CAPS</a>
                                            <div class="product-specs">
                                                <div><span>Amount:&nbsp;</span><span class="value">30.00</span></div>
                                                <div><span>In stock:&nbsp;</span><span class="value">40</span></div>
                                                <div></div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-2 quantity"><label class="form-label d-none d-md-block" for="quantity">Quantity</label><input type="number" id="number" class="form-control quantity-input" value="1"></div>
                                        <div class="col-6 col-md-2 price"><span><br>₱ 30.00<br><br></span></div>
                                    </div>
                                </div>
                                <div class="product">
                                    <div class="row justify-content-center align-items-center">
                                        <div class="col-md-3">
                                            <div class="product-image"><img class="img-fluid d-block mx-auto image" src="{{ asset('h2whoa/assets/img/assets/Water.png')}}"></div>
                                        </div>
                                        <div class="col-md-5 product-info"><a class="product-name" href="#">REFILL WATER</a>
                                            <div class="product-specs">
                                                <div><span>Amount:&nbsp;</span><span class="value">40.00</span></div>
                                                <div><span>In Stock:&nbsp;</span><span class="value">N/A</span></div>
                                                <div></div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-2 quantity"><label class="form-label d-none d-md-block" for="quantity">Quantity</label><input type="number" id="number" class="form-control quantity-input" value="1"></div>
                                        <div class="col-6 col-md-2 price"><span><br>₱ 40.00<br><br></span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-4">
                            <div class="bg-body-tertiary summary">
                                <h3>Summary</h3>
                                <h4 class="border-primary-subtle" style="border-color: var(--bs-primary-border-subtle);"><span class="text">Subtotal</span><span class="price"><br>₱360.00</span></h4>
                                <h4 class="border-primary-subtle" style="border-color: var(--bs-primary-border-subtle);"><span class="text">Subtotal</span><span class="price"><br>₱360.00</span></h4>
                                <h4 class="border-primary-subtle" style="border-color: var(--bs-primary-border-subtle);"><span class="text">Subtotal</span><span class="price"><br>₱360.00</span></h4>
                                <h4 class="border-primary-subtle" style="border-color: var(--bs-primary-border-subtle);"><span class="text">Subtotal</span><span class="price"><br>₱360.00</span></h4>
                                <h4><span class="text">Delivery Fee</span><span class="price">₱0.00</span></h4>
                                <h4><span class="text">Total</span><span class="price">₱360.00</span></h4><button class="btn btn-primary btn-lg d-block w-100" type="submit" style="background: #4ac9b0;"><i class="fas fa-arrow-circle-right" style="font-size: 24px;margin-right: 33px;"></i>Check out</button>
                            </div>  
                        </div>
                    </div>
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
    <script src="{{asset('h2whoa/assets/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('h2whoa/assets/js/baguetteBox.min.js')}}"></script>
    <script src="{{asset('h2whoa/assets/js/vanilla-zoom.js')}}"></script>
    <script src="{{asset('h2whoa/assets/js/theme.js')}}"></script>
    <script src="{{asset('h2whoa/assets/js/Contact-Form-v2-Modal--Full-with-Google-Map-scripts.js')}}"></script>
    <script src="{{asset('h2whoa/assets/js/Map-Location-5-script.min.js')}}"></script>
</body>

</html>