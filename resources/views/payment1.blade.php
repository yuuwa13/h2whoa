<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Payment - H2WHOA</title>
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
    <nav class="navbar navbar-expand-lg fixed-top bg-body clean-navbar navbar-light" style="width: 1335px;height: 163px;margin-left: 32px;margin-top: 30px;border-radius: 42px;">
        <div class="container"><a class="navbar-brand logo" href="#index.html"><img width="100" height="80" src="{{ asset('h2whoa/assets/img/assets/h2whoa_logo.png')}}">H2WHOA</a><button data-bs-toggle="collapse" data-bs-target="#navcol-1" class="navbar-toggler"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse text-start" id="navcol-1" style="margin-left: 242px;margin-right: 318px;">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item text-center" style="padding-right: 33px;"><a class="nav-link text-end" href="online_orders.html" style="width: 99px;height: 32px;text-align: center;font-size: 22px;">ORDERS</a></li>
                    <li class="nav-item"><a class="nav-link" href="online_history.html" style="width: 99px;height: 32px;text-align: center;font-size: 22px;">HISTORY</a></li>
                    <li class="nav-item"><a class="nav-link" href="online_contactUs.html" style="width: 99px;height: 32px;text-align: center;font-size: 22px;">contacts</a></li>
                    <li class="nav-item" style="margin-left: 128px;"><i class="far fa-user" style="font-size: 31px;"></i></li>
                </ul><a style="font-size: 22px;"><strong>KRISTOFFE</strong><br>Customer</a>
                <div class="collapse navbar-collapse text-start" id="navcol-2" style="margin-left: 119px;margin-right: 316px;">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <main class="page payment-page">
        <section class="clean-block payment-form dark">
            <div class="container" style="margin-top: 82px;">
                <div class="block-heading"></div>
                <form>
                    <div class="products">
                        <h3 class="title">Checkout</h3>
                        <div class="item"><span class="price">$200</span>
                            <p class="item-name">Product 1</p>
                            <p class="item-description">Lorem ipsum dolor sit amet</p>
                        </div>
                        <div class="item"><span class="price">$120</span>
                            <p class="item-name">Product 2</p>
                            <p class="item-description">Lorem ipsum dolor sit amet</p>
                        </div>
                        <div class="total"><span>Total</span><span class="price">$320</span></div><button class="btn btn-primary d-block w-100" type="submit" style="margin-top: 19px;background: #4ac9b0;">Pay Cash</button>
                    </div>
                    <div class="card-details">
                        <h3 class="title">Credit Card Details</h3>
                        <div class="row">
                            <div class="col-sm-7">
                                <div class="mb-3"><label class="form-label" for="card_holder">Card Holder</label><input class="form-control" type="text" id="card_holder" placeholder="Card Holder" name="card_holder" data-bs-theme="light"></div>
                            </div>
                            <div class="col-sm-5">
                                <div class="mb-3"><label class="form-label">Card Holder Name</label>
                                    <div class="input-group expiration-date" data-bs-theme="light"><input class="form-control" type="text" placeholder="Card Holder Name" name="expiration_year"></div>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="mb-3"><label class="form-label" for="card_number">Card Number</label><input class="form-control" type="text" id="card_number" placeholder="Card Number" name="card_number" data-bs-theme="light"></div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-3"><label class="form-label" for="cvc">CVC</label><input class="form-control" type="text" id="cvc" placeholder="CVC" name="cvc" data-bs-theme="light"></div>
                            </div>
                            <div class="col-sm-12">
                                <div class="mb-3"><button class="btn btn-primary d-block w-100" type="submit" style="background: #4ac9b0;">Proceed</button></div>
                            </div>
                        </div>
                    </div>
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
</body>

</html>