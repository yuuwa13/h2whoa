<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Admin Login — H2WHOA</title>
    <link rel="stylesheet" href="{{ asset('h2whoa_admin/assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:400,600,700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins&display=swap">
    <link rel="stylesheet" href="{{ asset('h2whoa_admin/assets/fonts/fontawesome-all.min.css') }}">
    <style nonce="{{ csp_nonce() }}">
        :root {
            --brand: #4ac9b0;
            --brand-dark: #35b39a;
            --dark: #1a1a2e;
        }

        *, *::before, *::after { box-sizing: border-box; }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f4f6f9;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 1.5rem;
        }

        .login-wrap {
            display: flex;
            width: 100%;
            max-width: 900px;
            min-height: 520px;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 12px 48px rgba(0,0,0,.12);
        }

        /* Left panel */
        .login-panel-left {
            flex: 1;
            background: var(--dark);
            padding: 3rem 2.5rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
        }
        .login-panel-left .brand {
            display: flex;
            align-items: center;
            gap: .75rem;
            margin-bottom: 2.5rem;
        }
        .login-panel-left .brand span {
            font-family: 'Nunito', sans-serif;
            font-size: 1.3rem;
            font-weight: 700;
            color: #fff;
            letter-spacing: .04em;
        }
        .login-panel-left h2 {
            font-family: 'Nunito', sans-serif;
            font-size: 1.6rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: .6rem;
            line-height: 1.25;
        }
        .login-panel-left p {
            font-size: .85rem;
            color: rgba(255,255,255,.55);
            line-height: 1.7;
            margin: 0;
            max-width: 260px;
        }
        .panel-accent {
            width: 40px;
            height: 4px;
            background: var(--brand);
            border-radius: 2px;
            margin-bottom: 1.25rem;
        }

        /* Right panel */
        .login-panel-right {
            flex: 1;
            background: #fff;
            padding: 3rem 2.5rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .login-panel-right h3 {
            font-family: 'Nunito', sans-serif;
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: .3rem;
        }
        .login-panel-right .sub {
            font-size: .82rem;
            color: #aaa;
            margin-bottom: 2rem;
        }

        .form-label-custom {
            font-size: .78rem;
            font-weight: 600;
            color: #555;
            margin-bottom: .35rem;
            display: block;
        }
        .input-icon-wrap {
            position: relative;
        }
        .input-icon-wrap i {
            position: absolute;
            left: .9rem;
            top: 50%;
            transform: translateY(-50%);
            color: #bbb;
            font-size: .85rem;
            pointer-events: none;
        }
        .input-icon-wrap input {
            padding-left: 2.4rem;
            height: 44px;
            border: 1.5px solid #e2e8f0;
            border-radius: 9px;
            font-size: .88rem;
            font-family: 'Poppins', sans-serif;
            width: 100%;
            outline: none;
            transition: border-color .2s, box-shadow .2s;
            color: var(--dark);
            background: #fff;
        }
        .input-icon-wrap input:focus {
            border-color: var(--brand);
            box-shadow: 0 0 0 3px rgba(74,201,176,.15);
        }
        .input-icon-wrap input.is-invalid {
            border-color: #dc2626;
        }
        .input-icon-wrap input.is-invalid:focus {
            box-shadow: 0 0 0 3px rgba(220,38,38,.12);
        }
        .invalid-feedback {
            font-size: .75rem;
            color: #dc2626;
            margin-top: .3rem;
        }

        .form-group { margin-bottom: 1.25rem; }

        .btn-login {
            background: var(--brand);
            border: none;
            color: #fff;
            font-family: 'Nunito', sans-serif;
            font-size: .9rem;
            font-weight: 700;
            letter-spacing: .04em;
            padding: .75rem;
            border-radius: 9px;
            width: 100%;
            margin-top: .5rem;
            cursor: pointer;
            transition: background .2s, opacity .2s;
        }
        .btn-login:hover:not(:disabled) { background: var(--brand-dark); }
        .btn-login:disabled { opacity: .55; cursor: not-allowed; }

        .lockout-alert {
            background: #fee2e2;
            border: 1px solid #fca5a5;
            color: #dc2626;
            font-size: .8rem;
            padding: .65rem 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            display: none;
        }
        .lockout-alert.show { display: flex; align-items: center; gap: .5rem; }

        @media (max-width: 640px) {
            .login-panel-left { display: none; }
            .login-wrap { max-width: 420px; }
            .login-panel-right { padding: 2.5rem 1.75rem; }
        }
    </style>
</head>
<body>

    <div class="login-wrap">
        {{-- Left --}}
        <div class="login-panel-left">
            <div class="brand">
                <img src="{{ asset('h2whoa_admin/assets/img/elements/h2whoa_logo.png') }}" alt="H2WHOA" width="40" height="40">
                <span>H2WHOA</span>
            </div>
            <div class="panel-accent"></div>
            <h2>Admin<br>Dashboard</h2>
            <p>Manage orders, stocks, and deliveries for L & A Water Refilling Station.</p>
        </div>

        {{-- Right --}}
        <div class="login-panel-right">
            <h3>Welcome back</h3>
            <p class="sub">Sign in to your admin account</p>

            <div class="lockout-alert" id="lockoutMessage">
                <i class="fas fa-lock"></i>
                <span id="lockoutText"></span>
            </div>

            <form action="{{ route('admin.login.submit') }}" method="POST" novalidate>
                @csrf

                <div class="form-group">
                    <label class="form-label-custom" for="email">Email Address</label>
                    <div class="input-icon-wrap">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="email" id="email"
                            class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
                            value="{{ old('email') }}"
                            placeholder="admin@example.com"
                            autocomplete="email"
                            required>
                    </div>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label-custom" for="password">Password</label>
                    <div class="input-icon-wrap">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" id="password"
                            class="{{ $errors->has('password') ? 'is-invalid' : '' }}"
                            placeholder="••••••••"
                            autocomplete="current-password"
                            required>
                    </div>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" id="loginBtn" class="btn-login" disabled>
                    Sign In
                </button>
            </form>
        </div>
    </div>

    <script nonce="{{ csp_nonce() }}" src="{{ asset('h2whoa_admin/assets/bootstrap/js/bootstrap.min.js') }}"></script>
    <script nonce="{{ csp_nonce() }}">
        const emailInput    = document.getElementById('email');
        const passwordInput = document.getElementById('password');
        const loginBtn      = document.getElementById('loginBtn');
        const lockoutMsg    = document.getElementById('lockoutMessage');
        const lockoutText   = document.getElementById('lockoutText');

        const lockout = @json(session('lockout'));
        let seconds   = @json(session('seconds'));

        function validateForm() {
            if (lockout && seconds > 0) { loginBtn.disabled = true; return; }
            loginBtn.disabled = !(emailInput.value.trim() && passwordInput.value.trim());
        }

        emailInput.addEventListener('input', validateForm);
        passwordInput.addEventListener('input', validateForm);
        validateForm();

        if (lockout && seconds > 0) {
            loginBtn.disabled = true;
            lockoutMsg.classList.add('show');

            const countdown = setInterval(() => {
                lockoutText.textContent = `Too many login attempts. Try again in ${seconds}s`;
                seconds--;
                if (seconds < 0) {
                    clearInterval(countdown);
                    lockoutMsg.classList.remove('show');
                    validateForm();
                }
            }, 1000);
        }
    </script>
</body>
</html>
