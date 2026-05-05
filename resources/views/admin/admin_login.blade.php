<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Admin Login - H2WHOA</title>
    <link rel="stylesheet" href="{{ asset('h2whoa_admin/assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900&amp;display=swap">
    <link rel="stylesheet" href="{{ asset('h2whoa_admin/assets/css/bs-theme-overrides.css') }}">
</head>

<body>
    <main class="page login-page">
        <section class="clean-block clean-form dark">
            <div class="container">
                <div class="block-heading">
                    <h2 class="text-info">Admin Login</h2>
                    <p>Please enter your credentials to access the admin dashboard.</p>
                </div>
                <form action="{{ route('admin.login.submit') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="email">Email Address</label>
                        <input
                            name="email"
                            type="email"
                            id="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email') }}"
                            required
                        >
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="password">Password</label>
                        <input
                            name="password"
                            type="password"
                            id="password"
                            class="form-control @error('password') is-invalid @enderror"
                            required
                        >
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div id="lockoutMessage" class="alert alert-danger d-none"></div>
                    <button id="loginBtn" type="submit" class="btn btn-primary w-100">Login</button>
                </form>
            </div>
        </section>
    </main>

    <script src="{{ asset('h2whoa_admin/assets/bootstrap/js/bootstrap.min.js') }}"></script>
    <script>
        const email = document.getElementById('email');
        const password = document.getElementById('password');
        const loginBtn = document.getElementById('loginBtn');
        const lockoutMessage = document.getElementById('lockoutMessage');

        const lockout = @json(session('lockout'));
        let seconds = @json(session('seconds'));

        function validateForm() {
            if (lockout && seconds > 0) {
                loginBtn.disabled = true;
                return;
            }

            loginBtn.disabled = !(email.value.trim() && password.value.trim());
        }

        email.addEventListener('input', validateForm);
        password.addEventListener('input', validateForm);

        // Initial validation
        validateForm();

        // Lockout countdown
        if (lockout && seconds > 0) {
            loginBtn.disabled = true;
            lockoutMessage.classList.remove('d-none');

            const countdown = setInterval(() => {
                lockoutMessage.innerText =
                    `Too many login attempts. Try again in ${seconds}s`;

                seconds--;

                if (seconds < 0) {
                    clearInterval(countdown);
                    lockoutMessage.classList.add('d-none');
                    validateForm(); // re-enable if valid
                }
            }, 1000);
        }
    </script>
</body>

</html>
