<!DOCTYPE html>
<html data-bs-theme="light" lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - H2WHOA</title>

    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,700|Poppins&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/css/bs-theme-overrides.css') }}">
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        main {
            flex: 1;
        }
        .block-heading img {
            max-width: 100px;
            margin-bottom: 1rem;
        }
    </style>
</head>

<body>
    <main class="page login-page">
        <section class="clean-block clean-form dark">
            <div class="container">
                <div class="block-heading text-center">
                    <img src="{{ asset('h2whoa_user/assets/img/elements/h2whoa_logo.png') }}" alt="H2WHOA Logo">
                    <h2 class="text-info">H2WHOA</h2>
                    <p class="fs-3 fw-bold">LOG IN</p>
                </div>

                <div class="row justify-content-center">
                    <div class="col-12 col-sm-10 col-md-8 col-lg-6">
                        <form action="{{ route('login.submit') }}" method="POST" id="loginForm">
                            @csrf

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input name="email" type="email" id="email" value="{{ old('email') }}"
                                    class="form-control @error('email') is-invalid @enderror">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input name="password" type="password" id="password"
                                    class="form-control @error('password') is-invalid @enderror">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Remember Me -->
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="rememberMe">
                                <label class="form-check-label" for="rememberMe">Remember me</label>
                            </div>

                            <!-- Are you human? -->
                            <div class="form-check mb-4">
                                <input name="human" type="checkbox" id="humanCheckbox"
                                    class="form-check-input @error('human') is-invalid @enderror">
                                <label class="form-check-label" for="humanCheckbox">Are you human?</label>
                                @error('human')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Submit -->
                            <button id="loginBtn" type="submit" class="btn btn-primary w-100"
                                style="background: #4ac9b0;" disabled>
                                LOG IN
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="page-footer dark py-4 mt-auto">
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <h5>Get started</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">Home</a></li>
                        <li><a href="#">Sign up</a></li>
                        <li><a href="#">Downloads</a></li>
                    </ul>
                </div>
                <div class="col-sm-3">
                    <h5>About us</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">Company Information</a></li>
                        <li><a href="#">Contact us</a></li>
                        <li><a href="#">Reviews</a></li>
                    </ul>
                </div>
                <div class="col-sm-3">
                    <h5>Support</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Help desk</a></li>
                        <li><a href="#">Forums</a></li>
                    </ul>
                </div>
                <div class="col-sm-3">
                    <h5>Legal</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">Terms of Service</a></li>
                        <li><a href="#">Terms of Use</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>
            <div class="text-center mt-3">
                <p class="mb-0">© 2025 H2WHOA. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="{{ asset('h2whoa_user/assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- SweetAlert for flash messages --}}
    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ session('success') }}',
                toast: true,
                position: 'bottom-end',
                timer: 3000,
                showConfirmButton: false
            });
        </script>
    @endif
    @if(session('status'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Logged Out',
                text: '{{ session('status') }}',
                toast: true,
                position: 'top-end',
                timer: 3000,
                showConfirmButton: false
            });
        </script>
    @endif

    <!-- Enable submit button only if all fields are valid -->
    <script>
        const email = document.getElementById('email');
        const password = document.getElementById('password');
        const human = document.getElementById('humanCheckbox');
        const loginBtn = document.getElementById('loginBtn');

        function validateForm() {
            loginBtn.disabled = !(email.value.trim() && password.value.trim() && human.checked);
        }

        [email, password, human].forEach(input =>
            input.addEventListener('input', validateForm)
        );
    </script>
</body>
</html>
