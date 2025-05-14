<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Sign Up - H2WHOA</title>
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins&amp;display=swap">
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/css/baguetteBox.min.css') }}">
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
                    <p style="font-size: 36px;"><strong>CREATE ACCOUNT</strong></p>
                </div>
                <form method="POST" action="{{ route('signup.store') }}" id="signup-form">
                    @csrf

                    {{-- Display Validation Errors --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Full Name --}}
                    <div class="mb-3">
                        <label class="form-label" for="name">Full Name</label>
                        <input name="name" value="{{ old('name') }}"
                            class="form-control item @error('name') is-invalid @enderror" type="text" id="name"
                            required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Address --}}
                    <div class="mb-3">
                        <label class="form-label" for="address">Address</label>
                        <input name="address" value="{{ old('address') }}"
                            class="form-control item @error('address') is-invalid @enderror" type="text" id="address"
                            required>
                        @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Email --}}
                    <div class="mb-3">
                        <label class="form-label" for="email">Email Address</label>
                        <input name="email" value="{{ old('email') }}"
                            class="form-control item @error('email') is-invalid @enderror" type="email" id="email"
                            required>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Phone --}}
                    <div class="mb-3">
                        <label class="form-label" for="phone">Phone Number</label>
                        <input name="phone" value="{{ old('phone') }}"
                            class="form-control item @error('phone') is-invalid @enderror" type="text" id="phone"
                            maxlength="11" pattern="^\d{11}$" title="Phone number must be exactly 11 numeric digits!"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                        @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Password --}}
                    <div class="mb-3">
                        <label class="form-label" for="password">Password</label>
                        <input name="password" class="form-control @error('password') is-invalid @enderror"
                            type="password" id="password" required>
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="password_confirmation">Confirm Password</label>
                        <input name="password_confirmation" class="form-control" type="password"
                            id="password_confirmation" required>
                    </div>

                    {{-- Checkboxes --}}
                    <div class="form-check mb-2">
                        <input name="terms" class="form-check-input" type="checkbox" id="terms" required>
                        <label class="form-check-label" for="terms">I have read the Terms and Conditions</label>
                    </div>
                    <div class="form-check mb-3">
                        <input name="confirm_info" class="form-check-input" type="checkbox" id="confirm_info" required>
                        <label class="form-check-label" for="confirm_info">I confirm that the information provided is
                            accurate</label>
                    </div>

                    {{-- Sign Up Button --}}
                    <div class="position-relative">
                        <button id="signup-btn" class="btn btn-primary" type="button" disabled
                            style="background: #4ac9b0; width: 100%;" data-bs-toggle="modal"
                            data-bs-target="#humanConfirmationModal">
                            SIGN UP
                        </button>
                        <div id="hover-tooltip" class="position-absolute bg-white border px-2 py-1"
                            style="bottom: -40px; left: 0; display: none;">
                            You are required to fill all forms and check all boxes
                        </div>
                    </div>

                    <!-- Human Confirmation Modal -->
                    <div class="modal fade" id="humanConfirmationModal" tabindex="-1"
                        aria-labelledby="humanConfirmationModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="humanConfirmationModalLabel">Confirm You're Human</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-check">
                                        <input name="human" class="form-check-input" type="checkbox" id="human">
                                        <label class="form-check-label" for="human">I am human</label>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <button type="button" id="confirmHumanBtn" class="btn btn-primary"
                                        style="background: #4ac9b0;">Confirm</button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            const confirmHumanBtn = document.getElementById('confirmHumanBtn');
                            const humanCheckbox = document.getElementById('human');
                            const signupForm = document.getElementById('signup-form');
                            const signupButton = document.getElementById('signup-btn');
                            const hoverTooltip = document.getElementById('hover-tooltip');
                            const requiredFields = signupForm.querySelectorAll('input[required]');
                            const checkboxes = signupForm.querySelectorAll('input[type="checkbox"]:not(#human)'); // Exclude the "human" checkbox

                            // Function to validate the form (excluding the "human" checkbox)
                            function validateForm() {
                                let allFieldsFilled = true;

                                requiredFields.forEach(field => {
                                    if (!field.value.trim()) {
                                        allFieldsFilled = false;
                                    }
                                });

                                let allCheckboxesChecked = true;

                                checkboxes.forEach(checkbox => {
                                    if (!checkbox.checked) {
                                        allCheckboxesChecked = false;
                                    }
                                });

                                // Enable or disable the Sign Up button
                                signupButton.disabled = !(allFieldsFilled && allCheckboxesChecked);

                                // Hide the tooltip if the button is enabled
                                if (!signupButton.disabled) {
                                    hoverTooltip.style.display = 'none';
                                }
                            }

                            // Show tooltip only when hovering over the disabled button
                            signupButton.addEventListener('mouseenter', function () {
                                if (signupButton.disabled) {
                                    hoverTooltip.style.display = 'block';
                                }
                            });

                            signupButton.addEventListener('mouseleave', function () {
                                hoverTooltip.style.display = 'none';
                            });

                            // Add event listeners to required fields and checkboxes
                            requiredFields.forEach(field => {
                                field.addEventListener('input', validateForm);
                            });

                            checkboxes.forEach(checkbox => {
                                checkbox.addEventListener('change', validateForm);
                            });

                            // Initialize validation on page load
                            validateForm();

                            // Handle modal confirmation
                            confirmHumanBtn.addEventListener('click', function () {
                                if (humanCheckbox.checked) {
                                    // Submit the form if the "human" checkbox is checked
                                    signupForm.submit();
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Validation Error',
                                        text: 'Please confirm that you are human.',
                                        toast: true,
                                        position: 'bottom-end',
                                        showConfirmButton: false,
                                        timer: 3000,
                                        timerProgressBar: true,
                                    });
                                }
                            });
                        });
                    </script>
                </form>
            </div>
        </section>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>