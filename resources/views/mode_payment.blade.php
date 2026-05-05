<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Checkout</title>
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins&display=swap">
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/css/baguetteBox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/css/Banner-Heading-Image-images.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/css/Bootstrap-Payment-Form-.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/css/bs-theme-overrides.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/css/Company-Invoice.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/css/Contact-Form-v2-Modal--Full-with-Google-Map.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/css/Features-Image-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/css/Map-Location-5-styles.min.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/css/Sidebar-navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/css/Sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/css/vanilla-zoom.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
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

        .checkout-page { padding: 6rem 0 4rem; }
        .page-title { font-family: 'Montserrat', sans-serif; font-size: 1.75rem; font-weight: 700; color: var(--dark); letter-spacing: .04em; margin-bottom: 2.5rem; text-align: center; }
        
        /* 2-Column Layout */
        .checkout-container { display: grid; grid-template-columns: 1fr 380px; gap: 2rem; }
        @media (max-width: 1024px) { .checkout-container { grid-template-columns: 1fr; } }
        
        /* Order Summary Card */
        .checkout-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 2rem; }
        .checkout-card-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; }
        .checkout-card-header h3 { font-family: 'Montserrat', sans-serif; font-size: .8rem; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; color: #64748b; border-bottom: 2px solid var(--brand); padding-bottom: .6rem; margin: 0; }
        
        /* Cancel button */
        .btn-cancel-order { background: none; border: none; color: #888; font-size: 1.3rem; cursor: pointer; transition: color .2s; padding: 0; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; }
        .btn-cancel-order:hover { color: #dc3545; }
        
        /* Order Items */
        .order-items { border: 1px solid #e2e8f0; border-radius: 10px; overflow: hidden; margin-bottom: 1.5rem; }
        .order-item { padding: 1.2rem; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: flex-start; gap: 1rem; }
        .order-item:last-child { border-bottom: none; }
        .item-info { flex: 1; }
        .item-name { font-family: 'Montserrat', sans-serif; font-weight: 700; font-size: .9rem; color: var(--dark); letter-spacing: .02em; margin-bottom: .25rem; }
        .item-meta { font-size: .8rem; color: #888; margin-bottom: .6rem; }
        .item-quantity-group { display: flex; align-items: center; gap: .5rem; }
        .item-quantity-group label { font-size: .75rem; font-weight: 600; letter-spacing: .04em; color: #555; margin: 0; }
        .item-quantity-group input { width: 70px; padding: .4rem .6rem; border: 1.5px solid #e2e8f0; border-radius: 6px; font-size: .9rem; text-align: center; font-family: 'Poppins', sans-serif; }
        .item-quantity-group input:focus { border-color: var(--brand); outline: none; box-shadow: 0 0 0 3px rgba(74,201,176,.15); }
        .item-actions { display: flex; flex-direction: column; align-items: flex-end; gap: .5rem; }
        .item-total { font-family: 'Montserrat', sans-serif; font-weight: 700; font-size: .95rem; color: var(--dark); white-space: nowrap; letter-spacing: .02em; }
        .btn-remove { background: #fee2e2; color: #dc2626; border: none; font-size: .75rem; font-weight: 600; letter-spacing: .04em; padding: .35rem .75rem; border-radius: 6px; cursor: pointer; transition: background .2s; display: none; }
        .btn-remove:hover { background: #fecaca; }
        .btn-remove:disabled { opacity: .5; cursor: not-allowed; }
        .btn-remove.visible { display: block; }
        
        /* Edit Order Button */
        .btn-edit-order { background: #f1f5f9; color: var(--dark); border: none; font-family: 'Montserrat', sans-serif; font-weight: 600; font-size: .85rem; letter-spacing: .04em; padding: .8rem 1.5rem; border-radius: 8px; cursor: pointer; transition: all .2s; width: 100%; margin-bottom: .8rem; }
        .btn-edit-order:hover { background: #e2e8f0; }
        .btn-save-changes { background: var(--brand); color: #fff; border: none; font-family: 'Montserrat', sans-serif; font-weight: 600; font-size: .85rem; letter-spacing: .04em; padding: .8rem 1.5rem; border-radius: 8px; cursor: pointer; transition: background .2s; width: 100%; display: none; }
        .btn-save-changes:hover:not(:disabled) { background: var(--brand-dark); }
        .btn-save-changes:disabled { opacity: .5; cursor: not-allowed; }
        
        /* Payment Summary Sidebar */
        .payment-summary { background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 1.5rem; position: sticky; top: 126px; }
        .payment-summary-header { font-family: 'Montserrat', sans-serif; font-size: .8rem; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; color: #64748b; border-bottom: 2px solid var(--brand); padding-bottom: .6rem; margin-bottom: 1.2rem; margin-top: 0; }
        .summary-row { display: flex; justify-content: space-between; align-items: center; font-size: .9rem; margin-bottom: .8rem; color: #555; }
        .summary-row-label { font-weight: 500; }
        .summary-row-value { font-family: 'Montserrat', sans-serif; font-weight: 600; color: var(--dark); letter-spacing: .02em; }
        .summary-divider { border: none; border-top: 1px solid #e2e8f0; margin: 1rem 0; }
        .summary-row.total { font-size: 1.05rem; font-weight: 700; color: var(--dark); padding-top: .8rem; border-top: 2px solid #e2e8f0; margin-top: .8rem; margin-bottom: 0; }
        .summary-row.total .summary-row-value { font-size: 1.2rem; color: var(--brand); }
        
        /* Payment Methods */
        .payment-methods { margin-top: 2rem; }
        .payment-methods-title { font-family: 'Montserrat', sans-serif; font-size: .8rem; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; color: #64748b; margin-bottom: 1rem; margin-top: 0; }
        .payment-method-btn { background: #fff; border: 2px solid #e2e8f0; border-radius: 10px; padding: 1rem; font-family: 'Montserrat', sans-serif; font-weight: 600; font-size: .85rem; letter-spacing: .04em; color: var(--dark); cursor: pointer; transition: all .2s; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: .6rem; margin-bottom: .8rem; text-decoration: none; }
        .payment-method-btn:hover { border-color: var(--brand); background: var(--brand-light); color: var(--brand); }
        .payment-method-btn i { font-size: 1.5rem; }
        .payment-method-btn.active { background: var(--brand); color: #fff; border-color: var(--brand); }
    </style>
</head>

<body>
    <main class="checkout-page">
        <div class="container" style="max-width: 1200px;">
            <h1 class="page-title">Checkout</h1>
            
            <div class="checkout-container">
                <!-- Left Column: Order Details -->
                <div>
                    <div class="checkout-card">
                        <div class="checkout-card-header">
                            <h3>Order Summary</h3>
                            <form action="{{ route('orders.cancel') }}" method="POST" style="margin: 0;">
                                @csrf
                                <button type="submit" class="btn-cancel-order" title="Cancel Order">
                                    <i class="fas fa-times"></i>
                                </button>
                            </form>
                        </div>
                        
                        <!-- Order Items -->
                        <div class="order-items" id="order-items">
                            @foreach($cart as $index => $item)
                                @php
                                    $availableStock = $stockMap[$index] ?? 0;
                                    $pricePerUnit = $item['quantity'] ? ($item['total_price'] / $item['quantity']) : 0;
                                @endphp
                                <div class="order-item">
                                    <div class="item-info">
                                        <div class="item-name">{{ $item['name'] }}</div>
                                        <div class="item-meta">In Stock: {{ $availableStock }}</div>
                                        @if($availableStock == 0)
                                            <div class="item-meta" style="color: #dc2626;">Out of stock</div>
                                        @endif
                                        <div class="item-quantity-group">
                                            <label for="quantity-{{ $index }}">Qty:</label>
                                            <input type="number" id="quantity-{{ $index }}"
                                                class="form-control quantity-input" value="{{ $item['quantity'] }}" min="0"
                                                max="{{ $availableStock }}"
                                                data-max="{{ $availableStock }}"
                                                data-index="{{ $index }}"
                                                data-price="{{ $pricePerUnit }}"
                                                {{ $availableStock == 0 ? 'disabled' : '' }}>
                                        </div>
                                    </div>
                                    <div class="item-actions">
                                        <div class="item-total">₱<span id="item-total-{{ $index }}">{{ number_format($item['total_price'], 2) }}</span></div>
                                        <button type="button" class="btn-remove remove-item"
                                            data-index="{{ $index }}" disabled>Remove</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- Edit Button -->
                        <button type="button" id="edit-order" class="btn-edit-order">
                            <i class="fas fa-edit me-2"></i>Edit Order
                        </button>
                        <button type="button" id="save-changes" class="btn-save-changes">
                            <i class="fas fa-check me-2"></i>Save Changes
                        </button>
                    </div>
                </div>
                
                <!-- Right Column: Payment Summary & Methods -->
                <div>
                    <!-- Payment Summary -->
                    <div class="payment-summary">
                        <h3 class="payment-summary-header">Total</h3>
                        
                        <div class="summary-row">
                            <span class="summary-row-label">Subtotal</span>
                            <span class="summary-row-value"><span id="subtotal-price">₱{{ number_format($subtotal, 2) }}</span></span>
                        </div>
                        <div class="summary-row">
                            <span class="summary-row-label">Tax (12%)</span>
                            <span class="summary-row-value"><span id="tax-price">₱{{ number_format($tax, 2) }}</span></span>
                        </div>
                        <div class="summary-row">
                            <span class="summary-row-label">Delivery Fee</span>
                            <span class="summary-row-value">₱{{ number_format(session('delivery_fee', 20), 2) }}</span>
                        </div>
                        <div class="summary-divider"></div>
                        <div class="summary-row total">
                            <span class="summary-row-label">Total Amount</span>
                            <span class="summary-row-value"><span id="total-price">₱{{ number_format($total, 2) }}</span></span>
                        </div>
                    </div>
                    
                    <!-- Payment Methods -->
                    <div class="payment-methods">
                        <h3 class="payment-methods-title">Payment Method</h3>
                        <a class="payment-method-btn" role="button" href="{{ route('delivery.details') }}"
                            onclick="event.preventDefault(); document.getElementById('delivery-details-form').submit();">
                            <i class="fas fa-money-bill-wave"></i>
                            Cash on Delivery
                        </a>
                        <form id="delivery-details-form" action="{{ route('delivery.details') }}" method="GET"
                            style="display: none;">
                            @csrf
                            @php session(['payment_method_id' => 1]); @endphp
                        </form>

                        <a class="payment-method-btn" role="button" href="{{ route('gcash.payment') }}">
                            <i class="fas fa-mobile-alt"></i>
                            GCash Payment
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script nonce="{{ csp_nonce() }}" src="{{ asset('h2whoa_user/assets/bootstrap/js/bootstrap.min.js') }}"></script>
    <script nonce="{{ csp_nonce() }}" src="{{ asset('h2whoa_user/assets/js/baguetteBox.min.js') }}"></script>
    <script nonce="{{ csp_nonce() }}" src="{{ asset('h2whoa_user/assets/js/vanilla-zoom.js') }}"></script>
    <script nonce="{{ csp_nonce() }}" src="{{ asset('h2whoa_user/assets/js/theme.js') }}"></script>
    <script nonce="{{ csp_nonce() }}" src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>
@if(session('error'))
    <script nonce="{{ csp_nonce() }}">
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}',
                toast: true,
                position: 'bottom-end',
                showConfirmButton: false,
                timer: 4000,
            });
        });
    </script>
@endif
<script nonce="{{ csp_nonce() }}">
    document.addEventListener('DOMContentLoaded', function () {
        const orderItems = document.getElementById('order-items');
        const subtotalElement = document.getElementById('subtotal-price');
        const taxElement = document.getElementById('tax-price');
        const totalPriceElement = document.getElementById('total-price');
        const editOrderButton = document.getElementById('edit-order');
        const saveChangesButton = document.getElementById('save-changes');

        let cart = @json($cart);
        let originalCart = JSON.parse(JSON.stringify(cart));
        let isEditing = false;

        function toggleEditing(enable) {
            const quantityInputs = document.querySelectorAll('.quantity-input');
            const removeButtons = document.querySelectorAll('.remove-item');

            quantityInputs.forEach(input => input.disabled = !enable);
            removeButtons.forEach(button => {
                button.disabled = !enable;
                if (enable) {
                    button.classList.add('visible');
                } else {
                    button.classList.remove('visible');
                }
            });

            saveChangesButton.style.display = enable ? 'block' : 'none';
            editOrderButton.innerHTML = enable ? '<i class="fas fa-times me-2"></i>Cancel' : '<i class="fas fa-edit me-2"></i>Edit Order';
            isEditing = enable;
        }

        toggleEditing(false);
        saveChangesButton.style.display = 'none';
        saveChangesButton.disabled = true;

        editOrderButton.addEventListener('click', function () {
            toggleEditing(!isEditing);
        });

        function updateTotals() {
            let subtotal = 0;

            cart.forEach((item, index) => {
                const quantityInput = document.getElementById(`quantity-${index}`);
                const quantity = parseInt(quantityInput.value) || 0;
                const pricePerUnit = parseFloat(quantityInput.dataset.price);

                const itemTotal = quantity * pricePerUnit;
                document.getElementById(`item-total-${index}`).textContent = itemTotal.toFixed(2);

                cart[index].price = pricePerUnit;
                cart[index].quantity = quantity;
                cart[index].total_price = itemTotal;

                subtotal += itemTotal;
            });

            subtotalElement.textContent = `₱${subtotal.toFixed(2)}`;
            const tax = subtotal * 0.12;
            taxElement.textContent = `₱${tax.toFixed(2)}`;
            const deliveryFee = {{ $deliveryFee }};
            const total = subtotal + tax + deliveryFee;
            totalPriceElement.textContent = `₱${total.toFixed(2)}`;

            checkForChanges();
        }

        orderItems.addEventListener('input', function (event) {
            if (event.target.classList.contains('quantity-input')) {
                updateTotals();
            }
        });

        function clampInputAndNotify(input) {
            const max = parseInt(input.getAttribute('data-max')) || parseInt(input.getAttribute('max')) || 0;
            let val = parseInt(input.value) || 0;
            if (max && val > max) {
                input.value = max;
                val = max;
                if (window.Swal) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Not enough stock',
                        text: `Only ${max} unit(s) available for ${input.closest('.order-item').querySelector('.item-name').textContent}.`,
                        toast: true,
                        position: 'bottom-end',
                        showConfirmButton: false,
                        timer: 2500,
                    });
                } else {
                    alert(`Only ${max} unit(s) available.`);
                }
            }
        }

        document.querySelectorAll('.quantity-input').forEach(input => {
            input.addEventListener('input', function () {
                clampInputAndNotify(this);
                updateTotals();
            });
        });

        document.querySelectorAll('.quantity-input').forEach(input => clampInputAndNotify(input));

        orderItems.addEventListener('click', function (event) {
            if (event.target.classList.contains('remove-item')) {
                const index = event.target.dataset.index;

                cart.splice(index, 1);

                const itemElement = document.getElementById(`quantity-${index}`).closest('.order-item');
                itemElement.remove();

                updateTotals();

                const remainingItems = orderItems.querySelectorAll('.order-item').length;
                if (remainingItems === 0) {
                    const cancelForm = document.querySelector('form[action="{{ route('orders.cancel') }}"]');
                    if (cancelForm) {
                        if (window.Swal) {
                            Swal.fire({
                                icon: 'info',
                                title: 'Order canceled',
                                text: 'All items removed. Returning to Orders page...',
                                toast: true,
                                position: 'bottom-end',
                                showConfirmButton: false,
                                timer: 1500,
                            }).then(() => {
                                cancelForm.submit();
                            });
                        } else {
                            cancelForm.submit();
                        }
                    } else {
                        window.location.href = '{{ route('orders.index') }}';
                    }
                }
            }
        });

        function checkForChanges() {
            const hasChanges = JSON.stringify(cart) !== JSON.stringify(originalCart);
            saveChangesButton.disabled = !hasChanges;
        }

        saveChangesButton.addEventListener('click', function () {
            fetch('{{ route('orders.saveChanges') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ products: cart })
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Changes Saved!',
                            text: 'Your changes have been saved successfully.',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 4000,
                            timerProgressBar: true,
                        }).then(() => {
                            location.reload();
                        });

                        toggleEditing(false);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Save Failed',
                            text: `Failed to save changes: ${data.message}`,
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 4000,
                            timerProgressBar: true,
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while saving changes. Please try again.',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                    });
                });
        });

        toggleEditing(false);
    });
</script>