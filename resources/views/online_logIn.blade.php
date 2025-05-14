<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Login - H2WHOA</title>
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i&amp;display=swap">
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
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
                    <p style="font-size: 36px;"><strong>LOG IN</strong></p>
                </div>
                <form action="{{ route('login.submit') }}" method="POST" id="loginForm">
                    @csrf
                    {{-- Email --}}
                    <div class="mb-3">
                        <label class="form-label" for="email">Email Address</label>
                        <input name="email" type="email" id="email" value="{{ old('email') }}"
                            class="form-control item @error('email') is-invalid @enderror">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="mb-3">
                        <label class="form-label" for="password">Password</label>
                        <input name="password" type="password" id="password"
                            class="form-control @error('password') is-invalid @enderror">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Remember Me --}}
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="checkbox" data-bs-theme="light">
                            <label class="form-check-label" for="checkbox">Remember me</label>
                        </div>
                    </div>

                    {{-- Are you human? --}}
                    <div class="mb-3">
                        <div class="form-check">
                            <input name="human" type="checkbox" id="humanCheckbox"
                                class="form-check-input @error('human') is-invalid @enderror">
                            <label class="form-check-label" for="humanCheckbox">Are you human?</label>
                            @error('human')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Submit --}}
                    <button id="loginBtn" type="submit" class="btn btn-primary"
                        style="background: #4ac9b0; width: 413px;" disabled>
                        LOG IN
                    </button>

                    {{-- Forgot password --}}
                    <div class="mt-2">
                        <a href="{{ route('password.request') }}">Forgot Password?</a>
                    </div>

                    {{-- Admin login stub --}}
                    <div class="mt-3">
                        <a href="{{ route('admin.login') }}">Admin Login</a>
                    </div>
                </form>
            </div>
        </section>
    </main>

    {{-- SweetAlert for Success Message --}}
    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Sign Up Successful',
                    text: '{{ session('success') }}',
                    toast: true,
                    position: 'bottom-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });
            });
        </script>
    @endif
    @if(session('status'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Logged Out',
                    text: '{{ session('status') }}',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });
            });
        </script>
    @endif
    @if(session('status1'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'success',
                title: 'Account Deleted',
                text: '{{ session('status') }}',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
        });
    </script>
@endif

    {{-- Small JS to enable/disable the button --}}
    <script>
        const email = document.getElementById('email');
        const password = document.getElementById('password');
        const human = document.getElementById('humanCheckbox');
        const btn = document.getElementById('loginBtn');

        function toggleButton() {
            btn.disabled = !(email.value.trim() && password.value.trim() && human.checked);
        }

        [email, password, human].forEach(el =>
            el.addEventListener('input', toggleButton)
        );
    </script>

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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>