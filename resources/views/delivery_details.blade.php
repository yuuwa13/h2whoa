<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Delivery Details</title>
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins&display=swap">
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
    <script nonce="{{ csp_nonce() }}" src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key') }}&libraries=places"></script>
    <style nonce="{{ csp_nonce() }}">
        :root {
            --brand: #4ac9b0;
            --brand-dark: #35b39a;
            --brand-light: #e8f8f5;
            --dark: #1a1a2e;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f8fafc;
            margin: 0;
            padding: 0;
        }

        .delivery-page { padding: 6rem 0 4rem; display: flex; justify-content: center; }
        .delivery-container { width: 100%; max-width: 500px; padding: 0 1rem; }
        .page-title { font-family: 'Montserrat', sans-serif; font-size: 1.75rem; font-weight: 700; color: var(--dark); letter-spacing: .04em; margin-bottom: 2.5rem; text-align: center; }
        
        /* Delivery Card */
        .delivery-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 2rem; }
        .delivery-card-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
        .delivery-card-header h3 { font-family: 'Montserrat', sans-serif; font-size: .75rem; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; color: #64748b; border-bottom: 2px solid var(--brand); padding-bottom: .6rem; margin: 0; }
        
        /* Edit Button */
        .btn-edit-delivery { background: var(--brand-light); color: var(--brand); border: none; font-size: 1rem; cursor: pointer; transition: all .2s; padding: .5rem; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 8px; }
        .btn-edit-delivery:hover { background: var(--brand); color: #fff; }
        
        /* Delivery Info Section */
        .delivery-info { margin-bottom: 2rem; }
        .info-item { display: block; padding: 1rem; border: 1px solid #f1f5f9; border-radius: 8px; margin-bottom: .8rem; background: #f8fafc; }
        .info-label { font-family: 'Montserrat', sans-serif; font-size: .8rem; font-weight: 700; letter-spacing: .06em; text-transform: uppercase; color: #64748b; display: block; margin-bottom: .5rem; }
        .info-value { font-family: 'Montserrat', sans-serif; font-size: .95rem; font-weight: 600; color: var(--dark); letter-spacing: .02em; word-wrap: break-word; }
        
        /* Action Buttons */
        .action-buttons { display: flex; gap: 1rem; margin-top: 2rem; justify-content: flex-end; }
        .btn-back { background: #f1f5f9; color: var(--dark); border: none; font-family: 'Montserrat', sans-serif; font-weight: 600; font-size: .85rem; letter-spacing: .04em; padding: 1rem 1.5rem; border-radius: 8px; cursor: pointer; transition: all .2s; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: .5rem; white-space: nowrap; }
        .btn-back:hover { background: #e2e8f0; }
        .btn-confirm { flex: 1; background: var(--brand); color: #fff; border: none; font-family: 'Montserrat', sans-serif; font-weight: 600; font-size: .85rem; letter-spacing: .04em; padding: 1rem; border-radius: 8px; cursor: pointer; transition: background .2s; display: flex; align-items: center; justify-content: center; gap: .5rem; }
        .btn-confirm:hover { background: var(--brand-dark); }
        
        /* Modal Styling */
        .modal-content { border: 1px solid #e2e8f0; }
        .modal-header { border-bottom: 2px solid #e2e8f0; background: #f8fafc; }
        .modal-header h5 { font-family: 'Montserrat', sans-serif; font-weight: 700; color: var(--dark); }
        .modal-body { padding: 2rem; }
        .form-label { font-family: 'Montserrat', sans-serif; font-weight: 600; color: var(--dark); letter-spacing: .02em; margin-bottom: .5rem; }
        .form-control { border: 1.5px solid #e2e8f0; border-radius: 8px; padding: .75rem; font-family: 'Poppins', sans-serif; }
        .form-control:focus { border-color: var(--brand); outline: none; box-shadow: 0 0 0 3px rgba(74,201,176,.15); }
        .modal-footer { border-top: 1px solid #e2e8f0; }
        .btn-close-modal { background: #f1f5f9; color: var(--dark); border: none; font-weight: 600; padding: .6rem 1.2rem; border-radius: 6px; cursor: pointer; }
        .btn-close-modal:hover { background: #e2e8f0; }
        .btn-save-modal { background: var(--brand); color: #fff; border: none; font-weight: 600; padding: .6rem 1.2rem; border-radius: 6px; cursor: pointer; }
        .btn-save-modal:hover { background: var(--brand-dark); }
        .map-container { height: 300px; width: 100%; margin-top: 10px; border-radius: 8px; }
        .address-display { margin-top: 10px; background: #f1f5f9; color: #888; }
    </style>
</head>

<body>
    <main class="delivery-page">
        <div class="delivery-container">
            <h1 class="page-title">Delivery Details</h1>
            
            <div class="delivery-card">
                <div class="delivery-card-header">
                    <h3>Confirm Your Delivery</h3>
                    <button type="button" class="btn-edit-delivery" data-bs-toggle="modal" data-bs-target="#editDetailsModal" title="Edit Details">
                        <i class="fas fa-edit"></i>
                    </button>
                </div>

                <!-- Delivery Info Items -->
                <div class="delivery-info">
                    <div class="info-item">
                        <div class="info-label">Name</div>
                        <div class="info-value">{{ $customer->name }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Contact Number</div>
                        <div class="info-value">{{ $customer->phone }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Delivery Address</div>
                        <div class="info-value">{{ Auth::guard('customer')->user()->address }}</div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <a class="btn-back" href="{{ route('mode.payment') }}">
                        <i class="fas fa-arrow-left"></i>Back
                    </a>

                    <form id="confirm-delivery-form" action="{{ route('orders.confirm') }}" method="POST">
                        @csrf
                        <input type="hidden" name="payment_method_id" value="{{ session('payment_method_id', 1) }}">
                        <button type="submit" class="btn-confirm">
                            <i class="fas fa-check"></i>Confirm Delivery
                        </button>
                    </form>
                </div>
            </div>
            </div>
        </div>

        <!-- Edit Modal -->
        <div class="modal fade" id="editDetailsModal" tabindex="-1" aria-labelledby="editDetailsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('profile.update') }}" method="POST" id="edit-details-form">
                        @csrf
                        @method('PUT')

                        <div class="modal-header">
                            <h5 class="modal-title" id="editDetailsModalLabel">Edit Delivery Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $customer->name }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Contact Number</label>
                                <input type="text" class="form-control" id="phone" name="phone" minlength="11" maxlength="11" value="{{ $customer->phone }}" required placeholder="09XXXXXXXXX">
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Delivery Address</label>
                                <div id="map" class="map-container"></div>
                                <input type="text" class="form-control address-display" id="address-display" value="{{ $customer->address }}" disabled>
                                <input type="hidden" id="address" name="address" value="{{ $customer->address }}">
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn-close-modal" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn-save-modal">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    @if(session('payment_confirmed'))
        <script nonce="{{ csp_nonce() }}">
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Delivery Confirmed',
                    text: '{{ session('payment_confirmed') }}',
                    toast: true,
                    position: 'bottom-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });
            });
        </script>
    @endif

    <script nonce="{{ csp_nonce() }}" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script nonce="{{ csp_nonce() }}" src="{{ asset('h2whoa_user/assets/bootstrap/js/bootstrap.min.js') }}"></script>
    <script nonce="{{ csp_nonce() }}" src="{{ asset('h2whoa_user/assets/js/baguetteBox.min.js') }}"></script>
    <script nonce="{{ csp_nonce() }}" src="{{ asset('h2whoa_user/assets/js/vanilla-zoom.js') }}"></script>
    <script nonce="{{ csp_nonce() }}" src="{{ asset('h2whoa_user/assets/js/theme.js') }}"></script>
    <script nonce="{{ csp_nonce() }}" src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>