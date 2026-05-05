<!DOCTYPE html>
<html data-bs-theme="light" lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>H2WHOA — L & A Water Refilling Station</title>
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins&display=swap">
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/css/bs-theme-overrides.css') }}">
    <style nonce="{{ csp_nonce() }}">
        :root {
            --brand: #4ac9b0;
            --brand-dark: #35b39a;
            --brand-light: #e8f8f5;
            --dark: #1a1a2e;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Poppins', sans-serif;
            background: #fff;
            margin: 0;
            padding: 0;
        }

        /* ── Navbar ── */
        .site-nav {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
            background: rgba(255,255,255,.96);
            backdrop-filter: blur(8px);
            border-bottom: 1px solid rgba(0,0,0,.07);
            padding: .75rem 0;
        }
        .site-nav .container {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .nav-brand {
            display: flex;
            align-items: center;
            gap: .6rem;
            text-decoration: none;
        }
        .nav-brand span {
            font-family: 'Montserrat', sans-serif;
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--dark);
            letter-spacing: .04em;
        }
        .nav-actions {
            display: flex;
            gap: .75rem;
            align-items: center;
        }
        .btn-nav-outline {
            font-family: 'Montserrat', sans-serif;
            font-size: .8rem;
            font-weight: 600;
            letter-spacing: .06em;
            color: var(--dark);
            border: 1.5px solid #d1d5db;
            background: #fff;
            padding: .45rem 1.1rem;
            border-radius: 8px;
            text-decoration: none;
            transition: border-color .2s, color .2s;
        }
        .btn-nav-outline:hover {
            border-color: var(--brand);
            color: var(--brand);
        }
        .btn-nav-fill {
            font-family: 'Montserrat', sans-serif;
            font-size: .8rem;
            font-weight: 600;
            letter-spacing: .06em;
            color: #fff;
            background: var(--brand);
            border: none;
            padding: .45rem 1.25rem;
            border-radius: 8px;
            text-decoration: none;
            transition: background .2s;
        }
        .btn-nav-fill:hover { background: var(--brand-dark); color: #fff; }

        /* ── Hero ── */
        .hero {
            padding-top: 96px;
            min-height: 100vh;
            display: flex;
            align-items: center;
            background: linear-gradient(135deg, #f0fdfb 0%, #e8f8f5 40%, #fff 100%);
            position: relative;
            overflow: hidden;
        }
        .hero::before {
            content: '';
            position: absolute;
            top: -80px;
            right: -120px;
            width: 520px;
            height: 520px;
            border-radius: 50%;
            background: rgba(74,201,176,.1);
            pointer-events: none;
        }
        .hero::after {
            content: '';
            position: absolute;
            bottom: -100px;
            left: -80px;
            width: 380px;
            height: 380px;
            border-radius: 50%;
            background: rgba(74,201,176,.07);
            pointer-events: none;
        }
        .hero-eyebrow {
            font-size: .72rem;
            font-weight: 700;
            letter-spacing: .18em;
            text-transform: uppercase;
            color: var(--brand);
            margin-bottom: .8rem;
        }
        .hero-title {
            font-family: 'Montserrat', sans-serif;
            font-size: clamp(2.4rem, 5.5vw, 4rem);
            font-weight: 700;
            line-height: 1.12;
            color: var(--dark);
            margin-bottom: 1rem;
        }
        .hero-title span {
            color: var(--brand);
        }
        .hero-sub {
            font-size: clamp(.9rem, 1.8vw, 1.05rem);
            color: #555;
            line-height: 1.7;
            max-width: 420px;
            margin-bottom: 2rem;
        }
        .hero-actions {
            display: flex;
            gap: .9rem;
            flex-wrap: wrap;
        }
        .btn-primary-cta {
            background: var(--brand);
            color: #fff;
            font-family: 'Montserrat', sans-serif;
            font-size: .85rem;
            font-weight: 700;
            letter-spacing: .06em;
            padding: .85rem 2rem;
            border-radius: 10px;
            text-decoration: none;
            transition: background .2s, transform .15s;
            display: inline-block;
        }
        .btn-primary-cta:hover {
            background: var(--brand-dark);
            color: #fff;
            transform: translateY(-1px);
        }
        .btn-secondary-cta {
            background: #fff;
            color: var(--dark);
            font-family: 'Montserrat', sans-serif;
            font-size: .85rem;
            font-weight: 600;
            letter-spacing: .04em;
            padding: .85rem 2rem;
            border-radius: 10px;
            text-decoration: none;
            border: 1.5px solid #d1d5db;
            transition: border-color .2s, color .2s;
            display: inline-block;
        }
        .btn-secondary-cta:hover {
            border-color: var(--brand);
            color: var(--brand);
        }
        .hero-image-wrap {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .hero-image-wrap::before {
            content: '';
            position: absolute;
            width: 380px;
            height: 380px;
            border-radius: 50%;
            background: rgba(74,201,176,.12);
        }
        .hero-image-wrap img {
            position: relative;
            z-index: 1;
            max-height: 440px;
            width: auto;
            filter: drop-shadow(0 20px 40px rgba(74,201,176,.25));
        }
        .hero-stats {
            display: flex;
            gap: 2rem;
            margin-top: 2.5rem;
            padding-top: 2rem;
            border-top: 1px solid #e5e7eb;
        }
        .stat-item .stat-num {
            font-family: 'Montserrat', sans-serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--dark);
        }
        .stat-item .stat-label {
            font-size: .78rem;
            color: #888;
            margin-top: .1rem;
        }

        /* ── Features ── */
        .features-section {
            padding: 5rem 0;
            background: #fff;
        }
        .section-eyebrow {
            font-size: .7rem;
            font-weight: 700;
            letter-spacing: .18em;
            text-transform: uppercase;
            color: var(--brand);
            text-align: center;
            margin-bottom: .6rem;
        }
        .section-title {
            font-family: 'Montserrat', sans-serif;
            font-size: clamp(1.5rem, 3vw, 2rem);
            font-weight: 700;
            color: var(--dark);
            text-align: center;
            margin-bottom: .6rem;
        }
        .section-sub {
            font-size: .9rem;
            color: #888;
            text-align: center;
            max-width: 480px;
            margin: 0 auto 3rem;
            line-height: 1.7;
        }
        .feature-card {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 2rem 1.5rem;
            text-align: center;
            transition: box-shadow .2s, transform .2s;
            height: 100%;
        }
        .feature-card:hover {
            box-shadow: 0 8px 32px rgba(74,201,176,.15);
            transform: translateY(-3px);
        }
        .feature-icon {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            background: var(--brand-light);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.25rem;
        }
        .feature-icon svg {
            width: 26px;
            height: 26px;
            stroke: var(--brand);
            fill: none;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }
        .feature-title {
            font-family: 'Montserrat', sans-serif;
            font-size: .95rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: .6rem;
        }
        .feature-text {
            font-size: .83rem;
            color: #666;
            line-height: 1.7;
            margin: 0;
        }

        /* ── How it works ── */
        .how-section {
            padding: 5rem 0;
            background: linear-gradient(135deg, #f0fdfb 0%, #e8f8f5 100%);
        }
        .step-card {
            display: flex;
            align-items: flex-start;
            gap: 1.25rem;
        }
        .step-number {
            flex-shrink: 0;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: var(--brand);
            color: #fff;
            font-family: 'Montserrat', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .step-title {
            font-family: 'Montserrat', sans-serif;
            font-size: .95rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: .35rem;
        }
        .step-text {
            font-size: .83rem;
            color: #666;
            line-height: 1.7;
            margin: 0;
        }
        .step-connector {
            width: 2px;
            height: 40px;
            background: linear-gradient(to bottom, var(--brand), transparent);
            margin: .4rem 0 .4rem 23px;
        }
        .how-left-eyebrow { text-align: left; }
        .how-left-title   { text-align: left; }
        .how-left-sub     { text-align: left; margin: 0 0 2.5rem; }

        /* Mock tracking card */
        .mock-card-wrap {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .mock-card-bg {
            max-width: 220px;
            opacity: .08;
            display: block;
            margin: 0 auto;
        }
        .mock-card {
            position: absolute;
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 1.75rem;
            width: 100%;
            max-width: 340px;
            box-shadow: 0 8px 32px rgba(0,0,0,.08);
        }
        .mock-card-label {
            font-size: .7rem;
            font-weight: 700;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: var(--brand);
            margin-bottom: .5rem;
        }
        .mock-card-title {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            color: var(--dark);
            font-size: .95rem;
            margin-bottom: 1.25rem;
        }
        .mock-track-list {
            display: flex;
            flex-direction: column;
            gap: .65rem;
        }
        .mock-track-row {
            display: flex;
            align-items: center;
            gap: .75rem;
        }
        .mock-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            flex-shrink: 0;
        }
        .mock-dot.done   { background: var(--brand); }
        .mock-dot.active { background: var(--brand); }
        .mock-dot.pending{ background: #e5e7eb; }
        .mock-track-label {
            font-size: .8rem;
            color: #555;
        }
        .mock-track-label.active {
            color: var(--dark);
            font-weight: 600;
        }
        .mock-track-label.pending { color: #bbb; }
        .mock-track-time {
            margin-left: auto;
            font-size: .75rem;
            color: #aaa;
        }
        .mock-track-time.pending { color: #ddd; }

        /* ── CTA Banner ── */
        .cta-section {
            padding: 5rem 0;
            background: var(--dark);
        }
        .cta-title {
            font-family: 'Montserrat', sans-serif;
            font-size: clamp(1.5rem, 3vw, 2.2rem);
            font-weight: 700;
            color: #fff;
            margin-bottom: .75rem;
        }
        .cta-sub {
            font-size: .9rem;
            color: #adb5bd;
            margin-bottom: 1.75rem;
            line-height: 1.7;
        }
        .btn-cta-dark {
            background: transparent;
            color: #d1d5db;
            border-color: #374151;
        }
        .btn-cta-dark:hover {
            border-color: var(--brand);
            color: var(--brand);
        }

        /* ── Footer ── */
        .site-footer {
            background: #111827;
            color: #9ca3af;
            padding: 3rem 0 1.5rem;
        }
        .footer-brand span {
            font-family: 'Montserrat', sans-serif;
            font-size: 1.1rem;
            font-weight: 700;
            color: #fff;
        }
        .footer-tagline {
            font-size: .82rem;
            color: #6b7280;
            margin-top: .4rem;
            line-height: 1.6;
            max-width: 220px;
        }
        .footer-col h6 {
            font-family: 'Montserrat', sans-serif;
            font-size: .72rem;
            font-weight: 700;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: #fff;
            margin-bottom: 1rem;
        }
        .footer-col ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .footer-col ul li { margin-bottom: .5rem; }
        .footer-col ul li a {
            font-size: .82rem;
            color: #9ca3af;
            text-decoration: none;
            transition: color .2s;
        }
        .footer-col ul li a:hover { color: var(--brand); }
        .footer-bottom {
            border-top: 1px solid #1f2937;
            margin-top: 2rem;
            padding-top: 1.25rem;
            text-align: center;
            font-size: .78rem;
            color: #4b5563;
        }
    </style>
</head>
<body>

    {{-- Navbar --}}
    <nav class="site-nav">
        <div class="container">
            <a class="nav-brand" href="#">
                <img src="{{ asset('h2whoa_user/assets/img/elements/h2whoa_logo.png') }}" alt="H2WHOA" width="40" height="40">
                <span>H2WHOA</span>
            </a>
            <div class="nav-actions">
                <a href="{{ route('login') }}" class="btn-nav-outline">Log In</a>
                <a href="{{ route('signup.form') }}" class="btn-nav-fill">Create Account</a>
            </div>
        </div>
    </nav>

    {{-- Hero --}}
    <section class="hero">
        <div class="container">
            <div class="row align-items-center gy-5">
                <div class="col-lg-6 order-2 order-lg-1">
                    <p class="hero-eyebrow">L & A Water Refilling Station</p>
                    <h1 class="hero-title">
                        Pure Water,<br>
                        Delivered to<br>
                        <span>Your Door</span>
                    </h1>
                    <p class="hero-sub">
                        Safe, clean, and refreshing drinking water on demand.
                        Order online and get it delivered straight to your home.
                    </p>
                    <div class="hero-actions">
                        <a href="{{ route('signup.form') }}" class="btn-primary-cta">Order Now</a>
                        <a href="{{ route('login') }}" class="btn-secondary-cta">Sign In</a>
                    </div>
                    <div class="hero-stats">
                        <div class="stat-item">
                            <div class="stat-num">Pure</div>
                            <div class="stat-label">Purified & Distilled</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-num">Fast</div>
                            <div class="stat-label">Same-Day Delivery</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-num">Safe</div>
                            <div class="stat-label">Quality Assured</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 order-1 order-lg-2">
                    <div class="hero-image-wrap">
                        <img src="{{ asset('h2whoa_user/assets/img/elements/Homepage_h2whoa.png') }}"
                             alt="H2WHOA Water Delivery">
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Features --}}
    <section class="features-section">
        <div class="container">
            <p class="section-eyebrow">Why H2WHOA</p>
            <h2 class="section-title">Quality You Can Taste</h2>
            <p class="section-sub">We use multi-stage filtration and strict quality controls to ensure every drop is safe for your family.</p>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                        </div>
                        <h3 class="feature-title">Multi-Stage Filtration</h3>
                        <p class="feature-text">Our water goes through sediment, carbon block, reverse osmosis, and UV sterilization filters before reaching you.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        </div>
                        <h3 class="feature-title">Prompt Delivery</h3>
                        <p class="feature-text">Place your order and track it in real time. We dispatch quickly and keep you updated every step of the way.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <svg viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                        </div>
                        <h3 class="feature-title">Trusted by Families</h3>
                        <p class="feature-text">Serving households and businesses in the community with consistent quality and reliable service you can count on.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- How it works --}}
    <section class="how-section">
        <div class="container">
            <div class="row align-items-center gy-5">
                <div class="col-lg-5">
                    <p class="section-eyebrow how-left-eyebrow">How It Works</p>
                    <h2 class="section-title how-left-title">Order in Three Steps</h2>
                    <p class="section-sub how-left-sub">Getting clean water delivered has never been easier.</p>

                    <div class="step-card">
                        <div class="step-number">1</div>
                        <div>
                            <div class="step-title">Create Your Account</div>
                            <p class="step-text">Sign up in under a minute. We just need your name and contact details.</p>
                        </div>
                    </div>
                    <div class="step-connector"></div>
                    <div class="step-card">
                        <div class="step-number">2</div>
                        <div>
                            <div class="step-title">Place Your Order</div>
                            <p class="step-text">Choose your products, set your delivery address on the map, and pick your payment method.</p>
                        </div>
                    </div>
                    <div class="step-connector"></div>
                    <div class="step-card">
                        <div class="step-number">3</div>
                        <div>
                            <div class="step-title">Track and Receive</div>
                            <p class="step-text">Follow your order live from dispatch to doorstep. No calls needed.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 offset-lg-1">
                    <div class="mock-card-wrap">
                        <img src="{{ asset('h2whoa_user/assets/img/elements/h2whoa_logo.png') }}"
                             alt="" class="mock-card-bg">
                        <div class="mock-card">
                            <div class="mock-card-label">Live Order</div>
                            <div class="mock-card-title">Order #2481 — In Transit</div>
                            <div class="mock-track-list">
                                <div class="mock-track-row">
                                    <div class="mock-dot done"></div>
                                    <span class="mock-track-label">Order confirmed</span>
                                    <span class="mock-track-time">09:12</span>
                                </div>
                                <div class="mock-track-row">
                                    <div class="mock-dot done"></div>
                                    <span class="mock-track-label">Preparing your order</span>
                                    <span class="mock-track-time">09:25</span>
                                </div>
                                <div class="mock-track-row">
                                    <div class="mock-dot active"></div>
                                    <span class="mock-track-label active">Out for delivery</span>
                                    <span class="mock-track-time">09:41</span>
                                </div>
                                <div class="mock-track-row">
                                    <div class="mock-dot pending"></div>
                                    <span class="mock-track-label pending">Delivered</span>
                                    <span class="mock-track-time pending">—</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA Banner --}}
    <section class="cta-section">
        <div class="container text-center">
            <h2 class="cta-title">Ready for Fresh, Clean Water?</h2>
            <p class="cta-sub">Create your account today and place your first order in minutes.</p>
            <div class="d-flex gap-3 justify-content-center flex-wrap">
                <a href="{{ route('signup.form') }}" class="btn-primary-cta">Get Started</a>
                <a href="{{ route('login') }}" class="btn-secondary-cta btn-cta-dark">Already have an account</a>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="site-footer">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-4 col-md-6">
                    <div class="nav-brand footer-brand mb-2">
                        <img src="{{ asset('h2whoa_user/assets/img/elements/h2whoa_logo.png') }}" alt="H2WHOA" width="36" height="36">
                        <span>H2WHOA</span>
                    </div>
                    <p class="footer-tagline">L & A Water Refilling Station — your trusted source for pure, clean, and refreshing drinking water.</p>
                </div>
                <div class="col-lg-2 col-md-3 col-6 footer-col">
                    <h6>Account</h6>
                    <ul>
                        <li><a href="{{ route('login') }}">Log In</a></li>
                        <li><a href="{{ route('signup.form') }}">Sign Up</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-3 col-6 footer-col">
                    <h6>Company</h6>
                    <ul>
                        <li><a href="{{ route('company.info') }}">About Us</a></li>
                        <li><a href="{{ route('contact.us') }}">Contact</a></li>
                        <li><a href="{{ route('reviews') }}">Reviews</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-3 col-6 footer-col">
                    <h6>Legal</h6>
                    <ul>
                        <li><a href="{{ route('legal.tos') }}">Terms of Service</a></li>
                        <li><a href="{{ route('legal.tou') }}">Terms of Use</a></li>
                        <li><a href="{{ route('legal.privacy') }}">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p style="margin:0;">© 2026 H2WHOA — L & A Water Refilling Station. All rights reserved.</p>
        </div>
    </footer>

    <script nonce="{{ csp_nonce() }}" src="{{ asset('h2whoa_user/assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
