<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Sign Up - H2WHOA</title>
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins&amp;display=swap">
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
</head>

<body>
    <main class="page login-page">
        <section class="clean-block clean-form dark">
            <div class="container">
                <div class="block-heading">
                    <h2 class="text-info">
                        <img src="{{ asset('h2whoa_user/assets/img/elements/h2whoa_logo.png') }}" alt="H2WHOA Logo">
                        H2WHOA
                    </h2>
                    <p style="font-size: 36px;"><strong>CREATE ACCOUNT</strong></p>
                </div>
                <form method="POST" action="{{ route('signup.store') }}" id="signup-form">
                    @csrf

                    {{-- Full Name --}}
                    <div class="mb-3">
                        <label class="form-label" for="name">Full Name</label>
                        <input name="name" value="{{ old('name') }}" class="form-control item @error('name') is-invalid @enderror" type="text" id="name">
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Address --}}
                    <div class="mb-3">
                        <label class="form-label" for="address">Address</label>
                        <input
                          class="form-control item @error('address') is-invalid @enderror"
                          type="text"
                          name="address"
                          id="address"
                          value="{{ old('address') }}"
                          required
                        >
                        @error('address')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                      
                    {{-- Email --}}
                    <div class="mb-3">
                        <label class="form-label" for="email">Email Address</label>
                        <input name="email" value="{{ old('email') }}" class="form-control item @error('email') is-invalid @enderror" type="email" id="email-1">
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Phone --}}
                    <div class="mb-3">
                        <label class="form-label" for="phone">Phone Number</label>
                        <input name="phone" value="{{ old('phone') }}" 
                        class="form-control item @error('phone') is-invalid @enderror" 
                        type="text" id="phone" 
                        maxlength="11" pattern="^\d{11}$"
                        title="Phone number must be exactly 11 numeric digits!"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                        >
                        @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Password --}}
                    <div class="mb-3">
                        <label class="form-label" for="password">Password</label>
                        <input name="password" class="form-control @error('password') is-invalid @enderror" type="password" id="password">
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="password_confirmation">Confirm Password</label>
                        <input name="password_confirmation" class="form-control" type="password" id="password-1">
                    </div>

                    {{-- Checkboxes --}}
                    <div class="form-check mb-2">
                        <input name="terms" class="form-check-input" type="checkbox" id="terms">
                        <label class="form-check-label" for="terms">I have read the Terms and Conditions</label>
                    </div>
                    <div class="form-check mb-3">
                        <input name="confirm_info" class="form-check-input" type="checkbox" id="confirm_info">
                        <label class="form-check-label" for="confirm_info">I confirm that the information provided is accurate</label>
                    </div>

                    {{-- Sign Up Button --}}
                    <div class="position-relative">
                        <button id="signup-btn" class="btn btn-primary" type="button" disabled style="background: #4ac9b0; width: 100%;">SIGN UP</button>
                        <div id="hover-tooltip" class="position-absolute bg-white border px-2 py-1" style="bottom: -40px; left: 0; display: none;">You are required to fill all forms and check all boxes</div>
                    </div>

                    {{-- Human Check Modal --}}
                    <div class="modal fade" id="humanModal" tabindex="-1" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title">Are you human?</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <div class="form-check">
                              <input name="human" class="form-check-input" type="checkbox" id="human">
                              <label class="form-check-label" for="human">Check if you are human</label>
                            </div>
                            <p id="confidence-text" class="mt-2" style="display:none;">Please make sure you are confident with your details.</p>
                          </div>
                          <div class="modal-footer">
                            <button id="modal-signup-btn" class="btn btn-primary" type="button" disabled>SIGN UP</button>
                          </div>
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
    <script src="{{ asset('h2whoa_user/assets/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('h2whoa_user/assets/js/baguetteBox.min.js') }}"></script>
    <script src="{{ asset('h2whoa_user/assets/js/vanilla-zoom.js') }}"></script>
    <script src="{{ asset('h2whoa_user/assets/js/theme.js') }}"></script>
    <script src="{{ asset('h2whoa_user/assets/js/Contact-Form-v2-Modal--Full-with-Google-Map-scripts.js') }}"></script>
    <script src="{{ asset('h2whoa_user/assets/js/Map-Location-5-script.min.js') }}"></script>
</body>

</html>