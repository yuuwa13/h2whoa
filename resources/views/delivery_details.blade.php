<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>COD</title>
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
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/css/Sidebar-navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/css/Sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/css/vanilla-zoom.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key') }}&libraries=places"></script>
</head>

<body>
    <main class="page payment-page">
        <section class="clean-block payment-form dark">
            <div class="container py-5">
                <div class="row justify-content-center">
                    <div class="col-12 col-lg-8">

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h3 class="title">Delivery Details</h3>

                            <!-- Edit Button -->
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                data-bs-target="#editDetailsModal"
                                style="background: #ffc107; color: #000; border: none;">
                                <i class="fas fa-pencil-alt"></i>
                            </button>
                        </div>

                        <!-- Delivery Info -->
                        <div class="mb-3">
                            <p class="fw-bold mb-1">Name</p>
                            <p class="text-muted">{{ $customer->name }}</p>
                        </div>
                        <div class="mb-3">
                            <p class="fw-bold mb-1">Contact Number</p>
                            <p class="text-muted">{{ $customer->phone }}</p>
                        </div>
                        <div class="mb-3">
                            <p class="fw-bold mb-1">Delivery Address</p>
                            <p class="text-muted">{{ Auth::guard('customer')->user()->address }}</p>
                        </div>

                        <!-- Navigation Buttons -->
                        <div class="d-flex flex-column flex-md-row justify-content-between gap-3 mt-4">
                            <a class="btn btn-secondary w-100 w-md-50" href="{{ route('mode.payment') }}"
                                style="background: #6c757d;">
                                Back
                            </a>

                            <form id="confirm-delivery-form" action="{{ route('orders.confirm') }}" method="POST"
                                class="w-100 w-md-50">
                                @csrf
                                <input type="hidden" name="payment_method_id"
                                    value="{{ session('payment_method_id', 1) }}">
                                <button type="submit" class="btn btn-primary w-100" style="background: #4ac9b0;">
                                    Confirm Delivery Details
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Edit Modal -->
            <div class="modal fade" id="editDetailsModal" tabindex="-1" aria-labelledby="editDetailsModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <form action="{{ route('customer.update', $customer->customer_id) }}" method="POST"
                            id="edit-details-form">
                            @csrf
                            @method('PUT')

                            <div class="modal-header">
                                <h5 class="modal-title" id="editDetailsModalLabel">Edit Delivery Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ $customer->name }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Contact Number</label>
                                    <input type="text" class="form-control" id="phone" name="phone" minlength="11"
                                        maxlength="11" value="{{ $customer->phone }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="address" class="form-label">Delivery Address</label>
                                    <div id="map" style="height: 300px; width: 100%; margin-top: 10px;"></div>
                                    <input type="hidden" id="address" name="address" value="{{ $customer->address }}">
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary" style="background: #4ac9b0;">Save
                                    Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>


    @if(session('payment_confirmed'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Payment Confirmed',
                    text: '{{ session('payment_confirmed') }}',
                    toast: true,
                    position: 'bottom-end', // Changed to bottom-right
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });
            });
        </script>
    @endif

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="{{ asset('h2whoa_user/assets/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('h2whoa_user/assets/js/baguetteBox.min.js') }}"></script>
    <script src="{{ asset('h2whoa_user/assets/js/vanilla-zoom.js') }}"></script>
    <script src="{{ asset('h2whoa_user/assets/js/theme.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>