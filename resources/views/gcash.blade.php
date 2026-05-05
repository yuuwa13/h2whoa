<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>GCash Payment</title>
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

        .payment-page { padding: 6rem 0 4rem; display: flex; justify-content: center; align-items: center; min-height: 100vh; }
        .page-title { font-family: 'Montserrat', sans-serif; font-size: 1.75rem; font-weight: 700; color: var(--dark); letter-spacing: .04em; margin-bottom: 2.5rem; text-align: center; }
        
        /* Back Button */
        .btn-back-gcash { background: none; border: none; color: var(--brand); font-size: 1.5rem; cursor: pointer; padding: 0; margin-bottom: 1rem; transition: color .2s; }
        .btn-back-gcash:hover { color: var(--brand-dark); }
        
        /* Payment Card */
        .payment-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 2rem; max-width: 500px; margin: 0 auto; }
        .gcash-logo { text-align: center; margin-bottom: 2rem; }
        .gcash-logo img { max-width: 120px; height: auto; }
        
        /* Summary Section */
        .summary-section { background: #f8fafc; border-radius: 10px; padding: 1.5rem; margin-bottom: 2rem; }
        .summary-item { display: flex; justify-content: space-between; align-items: center; padding: .8rem 0; border-bottom: 1px solid #e2e8f0; font-size: .9rem; }
        .summary-item:last-child { border-bottom: none; }
        .summary-label { color: #555; }
        .summary-value { font-family: 'Montserrat', sans-serif; font-weight: 600; color: var(--dark); }
        .summary-total { padding-top: 1rem; border-top: 2px solid #e2e8f0; margin-top: 1rem; display: flex; justify-content: space-between; align-items: center; font-weight: 700; font-size: 1.1rem; }
        .summary-total .summary-value { color: var(--brand); font-size: 1.3rem; }
        
        /* Form Section */
        .form-section h3 { font-family: 'Montserrat', sans-serif; font-size: .8rem; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; color: #64748b; border-bottom: 2px solid var(--brand); padding-bottom: .6rem; margin-bottom: 1.5rem; }
        .form-group { margin-bottom: 1.5rem; }
        .form-label { font-family: 'Montserrat', sans-serif; font-weight: 600; font-size: .85rem; letter-spacing: .04em; color: var(--dark); margin-bottom: .5rem; display: block; }
        .form-control { border: 1.5px solid #e2e8f0; border-radius: 8px; padding: .75rem; font-family: 'Poppins', sans-serif; font-size: .9rem; transition: border-color .2s; }
        .form-control:focus { border-color: var(--brand); outline: none; box-shadow: 0 0 0 3px rgba(74,201,176,.15); }
        .form-helper-text { font-size: .75rem; color: #888; margin-top: .3rem; }
        
        /* File Upload */
        .file-input-wrapper { position: relative; }
        .file-input-label { display: flex; align-items: center; justify-content: center; gap: .5rem; border: 2px dashed #e2e8f0; border-radius: 8px; padding: 1.5rem; cursor: pointer; transition: all .2s; background: #f8fafc; }
        .file-input-label:hover { border-color: var(--brand); background: var(--brand-light); }
        .file-input-label i { font-size: 1.5rem; color: var(--brand); }
        .file-input-label span { font-family: 'Montserrat', sans-serif; font-weight: 600; color: var(--dark); }
        input[type="file"] { display: none; }
        
        /* Button */
        .btn-confirm-payment { background: var(--brand); color: #fff; border: none; font-family: 'Montserrat', sans-serif; font-weight: 600; font-size: .9rem; letter-spacing: .04em; padding: 1rem; border-radius: 8px; cursor: pointer; transition: background .2s; width: 100%; display: flex; align-items: center; justify-content: center; gap: .6rem; margin-top: 2rem; }
        .btn-confirm-payment:hover { background: var(--brand-dark); }
        .btn-confirm-payment:disabled { opacity: .6; cursor: not-allowed; }
    </style>
</head>

<body>
    <main class="payment-page">
        <div style="width: 100%; max-width: 500px; padding: 0 1rem;">
            <a href="{{ route('mode.payment') }}" class="btn-back-gcash" title="Go back">
                <i class="fas fa-arrow-left"></i>
            </a>
            
            <div class="payment-card">
                <h1 class="page-title">GCash Payment</h1>
                
                <!-- GCash Logo -->
                <div class="gcash-logo">
                    <img src="{{ asset('h2whoa_user/assets/img/tech/gcash.png') }}" alt="GCash">
                </div>

                <!-- Order Summary -->
                <div class="summary-section">
                    <div class="summary-item">
                        <span class="summary-label">Subtotal</span>
                        <span class="summary-value">₱{{ number_format($subtotal, 2) }}</span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Tax (12%)</span>
                        <span class="summary-value">₱{{ number_format($subtotal * 0.12, 2) }}</span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Delivery Fee</span>
                        <span class="summary-value">₱{{ number_format(session('delivery_fee', 20), 2) }}</span>
                    </div>
                    <div class="summary-total">
                        <span>Total Amount</span>
                        <span class="summary-value">₱{{ number_format($subtotal + ($subtotal * 0.12) + session('delivery_fee', 20), 2) }}</span>
                    </div>
                </div>

                <!-- Payment Form -->
                <form id="gcash-payment-form" action="{{ route('gcash.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="form-section">
                        <h3>Payment Details</h3>
                        
                        <div class="form-group">
                            <label class="form-label" for="name">GCash Account Name</label>
                            <input class="form-control" type="text" id="name" name="name" placeholder="e.g., Juan D. Cruz" required>
                            <div class="form-helper-text">The name registered on your GCash account</div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="reference_number">Reference Number</label>
                            <input class="form-control" type="text" id="reference_number" name="reference_number" placeholder="e.g., 002asd32139323" required>
                            <div class="form-helper-text">Found in your GCash transaction receipt</div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Payment Receipt</label>
                            <div class="file-input-wrapper">
                                <div class="file-input-label" id="file-upload-label">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <span>Click to upload receipt</span>
                                </div>
                                <input class="form-control" type="file" id="image" name="image" accept="image/*" required style="display: none;">
                            </div>
                            <div class="form-helper-text">Upload a screenshot or photo of your GCash receipt</div>
                        </div>
                        
                        <button id="confirm-payment-button" class="btn-confirm-payment" type="button">
                            <i class="fas fa-lock"></i>Confirm Payment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script nonce="{{ csp_nonce() }}" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script nonce="{{ csp_nonce() }}" src="{{ asset('h2whoa_user/assets/bootstrap/js/bootstrap.min.js') }}"></script>
    <script nonce="{{ csp_nonce() }}" src="{{ asset('h2whoa_user/assets/js/baguetteBox.min.js') }}"></script>
    <script nonce="{{ csp_nonce() }}" src="{{ asset('h2whoa_user/assets/js/vanilla-zoom.js') }}"></script>
    <script nonce="{{ csp_nonce() }}" src="{{ asset('h2whoa_user/assets/js/theme.js') }}"></script>
    <script nonce="{{ csp_nonce() }}" src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script nonce="{{ csp_nonce() }}">
        document.addEventListener('DOMContentLoaded', function () {
            const fileInput = document.getElementById('image');
            const fileUploadLabel = document.getElementById('file-upload-label');
            const confirmButton = document.getElementById('confirm-payment-button');
            const paymentForm = document.getElementById('gcash-payment-form');

            // File input click handler
            fileUploadLabel.addEventListener('click', () => fileInput.click());
            
            // File selected feedback
            fileInput.addEventListener('change', function() {
                if (this.files.length > 0) {
                    fileUploadLabel.innerHTML = `<i class="fas fa-check" style="color: var(--brand);"></i><span>${this.files[0].name}</span>`;
                }
            });

            confirmButton.addEventListener('click', function () {
                const name = document.getElementById('name').value.trim();
                const referenceNumber = document.getElementById('reference_number').value.trim();
                const receipt = document.getElementById('image').files.length;

                if (!name || !referenceNumber || receipt === 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Missing Information',
                        text: 'Please fill out all required fields: GCash account name, reference number, and receipt.',
                        confirmButtonColor: '#4ac9b0',
                    });
                    return;
                }

                Swal.fire({
                    title: 'Confirm Payment',
                    text: 'Payments made are non-refundable. Please verify all details before proceeding.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#4ac9b0',
                    cancelButtonColor: '#cbd5e1',
                    confirmButtonText: 'Yes, proceed',
                    cancelButtonText: 'Cancel',
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Processing Payment...',
                            toast: true,
                            position: 'bottom-end',
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true,
                        });

                        setTimeout(() => {
                            paymentForm.submit();
                        }, 2000);
                    }
                });
            });
        });
    </script>
</body>

</html>