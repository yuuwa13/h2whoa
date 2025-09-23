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
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCQnsNJBV6gfQnNeURHNyDBgp79XK7eBAA&libraries=places"></script>
</head>

<body>
    <main class="page payment-page">
        <section class="clean-block payment-form dark">
            <div class="container" style="margin-top: 82px;">
                <div class="block-heading"></div>
                <div class="products">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="title">Delivery Details</h3>
                        <!-- Edit Button as Pencil Icon -->
                        <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                            data-bs-target="#editDetailsModal" style="background: #ffc107; color: #000; border: none;">
                            <i class="fas fa-pencil-alt"></i> <!-- Font Awesome Pencil Icon -->
                        </button>
                    </div>
                    <div class="item">
                        <p class="item-name">Name</p>
                        <p class="item-description">{{ $customer->name }}</p>
                    </div>
                    <div class="item">
                        <p class="item-name">Contact Number</p>
                        <p class="item-description">{{ $customer->phone }}</p>
                    </div>
                    <div class="item">
                        <p class="item-name">Delivery Address</p>
                        <p class="item-description">
                            {{ Auth::guard('customer')->user()->address }}
                        </p>
                    </div>
                    <div class="item"><span class="price"></span></div>
                    <div class="d-flex justify-content-between">
                        <a class="btn btn-secondary w-50 me-2" role="button" href="{{ route('mode.payment') }}"
                            style="background: #6c757d;">Back</a>
                        <form id="confirm-delivery-form" action="{{ route('orders.confirm') }}" method="POST"
                            class="w-50">
                            @csrf
                            <input type="hidden" name="payment_method_id" value="{{ session('payment_method_id', 1) }}">
                            <button type="submit" id="confirm-delivery-button" class="btn btn-primary w-100"
                                style="background: #4ac9b0;">
                                Confirm Delivery Details
                            </button>
                        </form>
                    </div>

                    <!-- Edit Details Modal -->
                    <div class="modal fade" id="editDetailsModal" tabindex="-1" aria-labelledby="editDetailsModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content p-0">
                                <form action="{{ route('customer.update', $customer->customer_id) }}" method="POST"
                                    id="edit-details-form" class="w-100">
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
                                            <input type="text" class="form-control" id="phone" name="phone"
                                                minlength="11" maxlength="11" value="{{ $customer->phone }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="address" class="form-label">Delivery Address</label>
                                            <div id="map" style="height: 400px; margin-top: 10px;"></div>
                                            <input type="hidden" id="address" name="address"
                                                value="{{ $customer->address }}">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary" id="save-changes-button"
                                            style="background: #4ac9b0;">Save Changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Toast Notification for Successful Updates -->
                    @if(session('success'))
                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: '{{ session('success') }}',
                                    toast: true,
                                    position: 'bottom-end', // Changed to bottom-right
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true,
                                });
                            });
                        </script>
                    @endif

                    <script>
                        let map, marker, geocoder;

                        function initMap() {
                            geocoder = new google.maps.Geocoder();

                            const customerAddress = document.getElementById("address").value;

                            geocoder.geocode({ address: customerAddress }, function (results, status) {
                                if (status === "OK" && results[0]) {
                                    const location = results[0].geometry.location;

                                    map = new google.maps.Map(document.getElementById("map"), {
                                        center: location,
                                        zoom: 15,
                                    });

                                    marker = new google.maps.Marker({
                                        map: map,
                                        position: location,
                                        draggable: false, // Disable dragging
                                    });
                                } else {
                                    alert("Geocode was not successful for the following reason: " + status);
                                }
                            });
                        }

                        document.getElementById('editDetailsModal').addEventListener('shown.bs.modal', function () {
                            initMap();
                        });
                    </script>
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