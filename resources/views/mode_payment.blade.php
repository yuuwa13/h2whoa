<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Mode of Payment</title>
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
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/css/Features-Image-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/css/Map-Location-5-styles.min.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/css/Sidebar-navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/css/Sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa_user/assets/css/vanilla-zoom.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>

<body>
    <main class="page payment-page">
        <section class="clean-block payment-form dark">
            <div class="container" style="margin-top: 82px;">
                <div class="block-heading">
                    <h3 class="text-center">Order Summary</h3>
                </div>
                <div class="products">
                    <div class="card" style="position: relative;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="card-title">Your Order</h4>
                                <!-- Cancel Order Button as an X Icon -->
                                <form action="{{ route('orders.cancel') }}" method="POST"
                                    style="position: absolute; top: 10px; right: 10px; z-index: 1;">
                                    @csrf
                                    <button type="submit" class="btn1 btn-danger btn-sm"
                                        style="background: none; border: none; color: #dc3545; font-size: 1.2rem;">
                                        <i class="fas fa-times"></i> <!-- Font Awesome X Icon -->
                                    </button>
                                </form>
                            </div>
                            <ul class="list-group" id="order-items">
                                @foreach($cart as $index => $item)
                                    @php
                                        $availableStock = $stockMap[$index] ?? 0;
                                        $pricePerUnit = $item['quantity'] ? ($item['total_price'] / $item['quantity']) : 0;
                                    @endphp
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>{{ $item['name'] }}</strong>
                                            <br>
                                            <small class="text-muted">In Stock: {{ $availableStock }}</small>
                                            <br>
                                            <label for="quantity-{{ $index }}">Quantity:</label>
                                            <input type="number" id="quantity-{{ $index }}"
                                                class="form-control quantity-input" value="{{ $item['quantity'] }}" min="0"
                                                max="{{ $availableStock }}"
                                                data-max="{{ $availableStock }}"
                                                data-index="{{ $index }}"
                                                data-price="{{ $pricePerUnit }}"
                                                style="width: 80px; display: inline-block;" {{ $availableStock == 0 ? 'disabled' : '' }}>
                                            @if($availableStock == 0)
                                                <div class="small text-danger">This item is currently out of stock.</div>
                                            @endif
                                        </div>
                                        <div>
                                            <span id="item-total-{{ $index }}">₱{{ number_format($item['total_price'], 2) }}</span>
                                            <button type="button" class="btn btn-danger btn-sm remove-item"
                                                data-index="{{ $index }}" disabled>Remove</button>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <span><strong>Subtotal</strong></span>
                                <span id="subtotal-price">₱{{ number_format($subtotal, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span><strong>Tax (12%)</strong></span>
                                <span id="tax-price">₱{{ number_format($tax, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span><strong>Delivery Fee</strong></span>
                                <span>₱{{ number_format(session('delivery_fee', 20), 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span><strong>Total</strong></span>
                                <span id="total-price">₱{{ number_format($total, 2) }}</span>
                            </div>
                            <!-- Edit Order Button -->
                            <button type="button" id="edit-order" class="btn btn-secondary mt-3">Edit Order</button>
                            <!-- Save Changes Button (Initially Hidden) -->
                            <button type="button" id="save-changes" class="btn btn-primary mt-3"
                                style="display: none;">Save Changes</button>
                        </div>
                    </div>
                </div>

                <div class="block-heading mt-4">
                    <h3 class="text-center">Mode of Payment</h3>
                </div>
                <div class="products">
                    <a class="btn btn-primary d-block w-100" role="button" href="{{ route('delivery.details') }}"
                        onclick="event.preventDefault(); document.getElementById('delivery-details-form').submit();"
                        style="margin-top: 19px;background: #4ac9b0;">
                        Cash on Delivery (COD)
                    </a>
                    <form id="delivery-details-form" action="{{ route('delivery.details') }}" method="GET"
                        style="display: none;">
                        @csrf
                        @php session(['payment_method_id' => 1]); @endphp <!-- 1 for COD -->
                    </form>

                    <a class="btn btn-primary d-block w-100" role="button" href="{{ route('gcash.payment') }}"
                        style="margin-top: 19px;background: #4ac9b0;">
                        Online Payment (GCash)
                    </a>
                </div>
            </div>
        </section>
    </main>
    <script src="{{ asset('h2whoa_user/assets/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('h2whoa_user/assets/js/baguetteBox.min.js') }}"></script>
    <script src="{{ asset('h2whoa_user/assets/js/vanilla-zoom.js') }}"></script>
    <script src="{{ asset('h2whoa_user/assets/js/theme.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>
@if(session('error'))
    <script>
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
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const orderItems = document.getElementById('order-items');
        const subtotalElement = document.getElementById('subtotal-price');
        const taxElement = document.getElementById('tax-price');
        const totalPriceElement = document.getElementById('total-price');
        const editOrderButton = document.getElementById('edit-order');
        const saveChangesButton = document.getElementById('save-changes');

        let cart = @json($cart);
        let originalCart = JSON.parse(JSON.stringify(cart)); // Clone the original cart to track changes

        // Initially disable editing and hide the "Save Changes" button
        toggleEditing(false);
        saveChangesButton.style.display = 'none';
        saveChangesButton.disabled = true; // Disable the button initially

        // Function to toggle editing
        function toggleEditing(enable) {
            const quantityInputs = document.querySelectorAll('.quantity-input');
            const removeButtons = document.querySelectorAll('.remove-item');

            quantityInputs.forEach(input => input.disabled = !enable);
            removeButtons.forEach(button => button.disabled = !enable);

            // Show or hide the "Save Changes" button
            saveChangesButton.style.display = enable ? 'block' : 'none';
        }

        // Enable editing when "Edit Order" is clicked
        editOrderButton.addEventListener('click', function () {
            toggleEditing(true);
        });

        // Update totals dynamically
        function updateTotals() {
            let subtotal = 0;

            cart.forEach((item, index) => {
                const quantityInput = document.getElementById(`quantity-${index}`);
                const quantity = parseInt(quantityInput.value) || 0;
                const pricePerUnit = parseFloat(quantityInput.dataset.price);

                // Update item total
                const itemTotal = quantity * pricePerUnit;
                document.getElementById(`item-total-${index}`).textContent = `₱${itemTotal.toFixed(2)}`;

                // Update cart data
                cart[index].price = pricePerUnit; // Add the price key to the cart
                cart[index].quantity = quantity;
                cart[index].total_price = itemTotal;

                // Add to subtotal
                subtotal += itemTotal;
            });

            // Update subtotal, tax, and total
            subtotalElement.textContent = `₱${subtotal.toFixed(2)}`;
            const tax = subtotal * 0.12; // 12% tax
            taxElement.textContent = `₱${tax.toFixed(2)}`;
            const deliveryFee = {{ $deliveryFee }};
            const total = subtotal + tax + deliveryFee;
            totalPriceElement.textContent = `₱${total.toFixed(2)}`;

            // Check if changes have been made
            checkForChanges();
        }

        // Handle quantity changes
        orderItems.addEventListener('input', function (event) {
            if (event.target.classList.contains('quantity-input')) {
                updateTotals();
            }
        });

            // Enforce max stock and show toast when user tries to exceed
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
                                text: `Only ${max} unit(s) available for ${input.closest('li').querySelector('strong').textContent}.`,
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

                // Attach listener to inputs
                document.querySelectorAll('.quantity-input').forEach(input => {
                    input.addEventListener('input', function () {
                        clampInputAndNotify(this);
                        updateTotals();
                    });
                });

                // Clamp all inputs on load (in case session/cart values exceed current stock)
                document.querySelectorAll('.quantity-input').forEach(input => clampInputAndNotify(input));

        // Handle item removal
        orderItems.addEventListener('click', function (event) {
            if (event.target.classList.contains('remove-item')) {
                const index = event.target.dataset.index;

                // Remove item from cart
                cart.splice(index, 1);

                // Remove item from DOM
                const itemElement = document.getElementById(`quantity-${index}`).closest('li');
                itemElement.remove();

                // Update totals
                updateTotals();

                // If no items remain, auto-submit the cancel order form and return user to orders page
                const remainingItems = orderItems.querySelectorAll('li').length;
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
                            // Fallback: submit immediately
                            cancelForm.submit();
                        }
                    } else {
                        // As a fallback, redirect to orders index route
                        window.location.href = '{{ route('orders.index') }}';
                    }
                }
            }
        });

        // Check if changes have been made to the cart
        function checkForChanges() {
            const hasChanges = JSON.stringify(cart) !== JSON.stringify(originalCart);
            saveChangesButton.disabled = !hasChanges; // Enable or disable the button based on changes
        }

        // Save changes to the session
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
                        // Show success toast notification
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
                            // Reload the page after the toast finishes
                            location.reload();
                        });

                        toggleEditing(false); // Disable editing after saving
                    } else {
                        // Show error toast notification
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
                    // Show error toast notification
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

        // Disable editing by default
        toggleEditing(false);
    });
</script>