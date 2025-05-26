<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>GCASH</title>
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins&amp;display=swap">
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/css/baguetteBox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/css/Banner-Heading-Image-images.css') }}">
    <link rel="stylesheet"
        href="{{ asset('h2whoa_user/assets/css/Billing-Table-with-Add-Row--Fixed-Header-Feature.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/css/Bootstrap-Payment-Form-.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/css/bs-theme-overrides.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/css/Company-Invoice.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/css/Contact-Form-v2-Modal--Full-with-Google-Map.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/css/dh-row-titile-text-image-right-1.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/css/Features-Image-icons.css') }}">
    <link rel="stylesheet"
        href="{{ asset('h2whoa_user/assets/css/Ludens---1-Index-Table-with-Search--Sort-Filters-v20.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/css/Map-Location-5-styles.min.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/css/Sidebar-navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/css/Sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/css/vanilla-zoom.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background-color: #F8F9FA !important;
        }
    </style>
</head>

<body>
    <main class="page payment-page">
        <section class="clean-block payment-form dark">
            <div class="container" style="margin-top: 82px;">
                <div class="d-flex align-items-center justify-content-center mb-3">
                    <a href="{{ route('mode.payment') }}" class="btn btn-link p-0 me-2"
                        style="font-size: 1.5rem; text-decoration: none;">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <h3 class="title text-center mb-0" style="flex: 1;">GCASH Payment</h3>
                </div>
                <form id="gcash-payment-form" action="{{ route('gcash.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="products">
                        <h3 class="title" style="text-align: center;">
                            <img src="{{ asset('h2whoa_user/assets/img/tech/gcash.png') }}" style="margin-top: 0px;"
                                width="201" height="228">
                        </h3>
                        <div class="item d-flex justify-content-between">
                            <p class="item-name1">Subtotal</p>
                            <span class="price1 text-end">₱{{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="item d-flex justify-content-between">
                            <p class="item-name1">Delivery Fee</p>
                            <span class="price1 text-end">₱{{ number_format($deliveryFee, 2) }}</span>
                        </div>
                        <div class="total">
                            <span>Total</span>
                            <span class="price"><strong>₱{{ number_format($total, 2) }}</strong></span>
                        </div>
                    </div>
                    <div class="card-details">
                        <h3 class="title">Payment Details</h3>
                        <div class="row">
                            <div class="col-sm-7">
                                <div class="mb-3">
                                    <label class="form-label" for="name">Gcash Name</label>
                                    <input class="form-control" type="text" id="name" name="name"
                                        placeholder="K.... B... M...." required>
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="mb-3">
                                    <label class="form-label" for="image">Attach Receipt</label>
                                    <input class="form-control" type="file" id="image" name="image" accept="image/*">
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="mb-3">
                                    <label class="form-label" for="reference_number">Reference Number</label>
                                    <input class="form-control" type="text" id="reference_number"
                                        name="reference_number" placeholder="002asd32139323" required>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <button id="confirm-payment-button" class="btn btn-primary d-block w-100"
                                        type="button" style="background: #4ac9b0;">
                                        Confirm Payment
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const confirmButton = document.getElementById('confirm-payment-button');
                        const paymentForm = document.getElementById('gcash-payment-form');

                        confirmButton.addEventListener('click', function () {
                            // Validate form fields
                            const name = document.getElementById('name').value.trim();
                            const referenceNumber = document.getElementById('reference_number').value.trim();
                            const receipt = document.getElementById('image').files.length;

                            if (!name || !referenceNumber || receipt === 0) {
                                // Show error if any field is empty
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Invalid Payment Details',
                                    text: 'Please fill out all required fields before proceeding.',
                                    confirmButtonColor: '#d33',
                                });
                                return;
                            }

                            // Show confirmation modal if all fields are valid
                            Swal.fire({
                                title: 'Are you sure?',
                                text: 'Payments made are non-refundable. Please double-check the details you have entered.',
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#4ac9b0',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Yes, proceed with payment',
                                cancelButtonText: 'No, go back',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Show confirmation toast
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Processing Payment...',
                                        toast: true,
                                        position: 'bottom-end',
                                        showConfirmButton: false,
                                        timer: 2000,
                                        timerProgressBar: true,
                                    });

                                    // Submit the form programmatically after the toast
                                    setTimeout(() => {
                                        paymentForm.submit();
                                    }, 2000);
                                }
                            });
                        });
                    });
                </script>
            </div>
        </section>
    </main>

    <script src="{{ asset('h2whoa_user/assets/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('h2whoa_user/assets/js/baguetteBox.min.js') }}"></script>
    <script src="{{ asset('h2whoa_user/assets/js/vanilla-zoom.js') }}"></script>
    <script src="{{ asset('h2whoa_user/assets/js/theme.js') }}"></script>
    <script
        src="{{ asset('h2whoa_user/assets/js/Billing-Table-with-Add-Row--Fixed-Header-Feature-Billing-Table-with-Add-Row--Fixed-Header.js') }}"></script>
    <script src="{{ asset('h2whoa_user/assets/js/Contact-Form-v2-Modal--Full-with-Google-Map-scripts.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>