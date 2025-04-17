<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>H2WHOA</title>
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
    <div class="row .payment-dialog-row" style="margin-top: 77px;">
        <div class="col-12 col-md-4 offset-md-4">
            <div class="card credit-card-box">
                <div class="card-header">
                    <h3><span class="panel-title-text">Payment Details </span><img class="img-fluid panel-title-image" src="{{ asset('h2whoa/assets/img/other/accepted_cards.png')}}"></h3>
                </div>
                <div class="card-body">
                    <div class="col-12">
                        <div class="form-group mb-3"><label class="form-label" for="couponCode">Card Holder Name</label><input type="text" id="couponCode"></div>
                        <div class="form-group mb-3"><label class="form-label" for="couponCode">Email</label><input type="text" id="couponCode-2"></div>
                    </div>
                    <form id="payment-form">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group mb-3"><label class="form-label" for="cardNumber">Card number </label>
                                    <div class="input-group"><input class="form-control" type="tel" id="cardNumber" required="" placeholder="Valid Card Number"><span class="input-group-text"><i class="fa fa-credit-card"></i></span></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group mb-3"><label class="form-label" for="couponCode">Total Amount</label><input class="form-control" type="text" id="couponCode-1"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-6"><button class="btn btn-success btn-lg d-block w-100" type="submit" style="background: #F87171;">Cancel&nbsp;</button></div>
                                        <div class="col-md-6"><button class="btn btn-success btn-lg d-block w-100" type="submit" style="background: #4ac9b0;">Confirm</button></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset('h2whoa/assets/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('h2whoa/assets/js/baguetteBox.min.js')}}"></script>
    <script src="{{asset('h2whoa/assets/js/vanilla-zoom.js')}}"></script>
    <script src="{{asset('h2whoa/assets/js/theme.js')}}"></script>
    <script src="{{asset('h2whoa/assets/js/Contact-Form-v2-Modal--Full-with-Google-Map-scripts.js')}}"></script>
    <script src="{{asset('h2whoa/assets/js/Map-Location-5-script.min.js')}}"></script>
</body>

</html>