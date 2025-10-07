<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Admin Login - H2WHOA</title>
    <link rel="stylesheet" href="{{ asset('h2whoa_admin/assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900&amp;display=swap">
    <link rel="stylesheet" href="{{ asset('h2whoa_admin/assets/css/bs-theme-overrides.css') }}">
    <style>
        body,
        html {
            height: 100%;
            margin: 0;
        }

        .login-wrapper {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            max-width: 400px;
            width: 100%;
        }
    </style>

</head>

<body>
    <main class="page login-page">
        <div class="login-wrapper">
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
                            <input name="email" type="email" id="email"
                                class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                                required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="password">Password</label>
                            <input name="password" type="password" id="password"
                                class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>
                </div>
            </section>
        </div>
    </main>


    <script src="{{ asset('h2whoa_admin/assets/bootstrap/js/bootstrap.min.js') }}"></script>
</body>

</html>