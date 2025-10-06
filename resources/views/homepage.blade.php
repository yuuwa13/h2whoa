<!DOCTYPE html>
<html data-bs-theme="light" lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomePage</title>
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins&display=swap">
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/css/bs-theme-overrides.css') }}">
    <style>
        /* Additional responsive tweaks */
        .hero-title {
            font-size: clamp(2.5rem, 6vw, 5rem);
        }
        .hero-subtitle {
            font-size: clamp(1.5rem, 4vw, 2.5rem);
        }
        .hero-text {
            font-size: clamp(1rem, 2.5vw, 1.25rem);
        }
        .btn-home {
            min-width: 140px;
        }
    </style>
</head>
<body>
    <main class="page blog-post">
        <section class="clean-block clean-post dark">
            <div class="container py-4 py-xl-5">
                {{-- Logo --}}
                <div class="text-center mb-4">
                    <img src="{{ asset('h2whoa_user/assets/img/elements/h2whoa_logo.png') }}" alt="H2Whoa Logo"
                         style="max-width: 120px; height: auto;">
                </div>

                <div class="row align-items-center">
                    <div class="col-12 col-md-6 order-2 order-md-1 px-3 px-md-0">
                        <div class="text-center text-md-start">
                            <h4 class="hero-title mb-3 text-dark">HW2WHOA</h4>
                            <p class="hero-subtitle mb-3">L & A WATER REFILLING STATION</p>
                            <p class="hero-text mb-4">Pure. Clean. Refreshing. Your trusted source for safe drinking water.</p>
                            <div class="d-flex justify-content-center justify-content-md-start gap-3">
                                <a class="btn btn-primary btn-home" style="background: #4ac9b0;"
                                   href="{{ route('login.form') }}">LOG IN</a>
                                <a class="btn btn-primary btn-home" style="background: #4ac9b0;"
                                   href="{{ route('signup.form') }}">CREATE ACCOUNT</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 order-1 order-md-2 text-center">
                        <img src="{{ asset('h2whoa_user/assets/img/elements/Homepage_h2whoa.png') }}"
                             alt="Homepage Visual"
                             class="img-fluid rounded"
                             style="max-height: 600px;">
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script src="{{ asset('h2whoa_user/assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
