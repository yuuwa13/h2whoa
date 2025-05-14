@extends('layouts.app')

@section('title', 'Orders')

@section('content')
    <main class="page shopping-cart-page">
        <section class="clean-block clean-cart dark">
            <div class="container" style="width: 1300px; margin-top: 150px;">
                <form action="{{ route('orders.save') }}" method="POST">
                    @csrf
                    <div class="row">
                        <!-- Address Section -->
                        <div class="col-md-6">
                            <h4 style="width: 500px;">Your Address</h4>
                            <p style="width: 500px;">
                                @if(Auth::guard('customer')->check())
                                    @if(Auth::guard('customer')->user()->address)
                                        {{ Auth::guard('customer')->user()->address }}
                                    @else
                                        <span class="text-warning">No address is set. Please <a
                                                href="{{ route('locate.address') }}">set your address</a>.</span>
                                    @endif
                                @else
                                    <span class="text-danger">You are not logged in. Please <a
                                            href="{{ route('login.form') }}">log in</a> to view your address.</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <a class="btn btn-primary btn-lg d-block w-100" role="button"
                                href="{{ route('locate.address') }}"
                                style="background: #4ac9b0; width: 300px; margin-top: 37px;">
                                <i class="fas fa-map-marker" style="font-size: 24px; margin-right: 33px;"></i>Locate Address
                            </a>
                        </div>
                        
                        <!-- Please fix -->
                        @if(!session('selected_address') && !Auth::guard('customer')->user()->address)
                            <div class="alert alert-warning mt-3" role="alert">
                                Please select your delivery address before proceeding to payment.
                            </div>
                        @endif

                        <!-- Products Table -->
                        <div class="container">
                            <div class="card"></div>
                            <div class="content">
                                <div class="row g-0">
                                    <div class="col-md-12 col-lg-8">
                                        <div class="items">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th><strong>Items</strong></th>
                                                            <th><strong>Quantity</strong></th>
                                                            <th><strong>Total Price</strong></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($products as $product)
                                                            <tr>
                                                                <td>
                                                                    <img class="img-fluid d-block mx-auto image"
                                                                        src="{{ asset('h2whoa_user/assets/img/elements/Water.png') }}">
                                                                    <a class="product-name">
                                                                        <br><strong>{{ strtoupper($product->product_name) }}</strong><br><br>
                                                                        <span>Amount:
                                                                            ₱{{ number_format($product->price_per_unit, 2) }}<br>In
                                                                            Stock: {{ $product->quantity }}</span>
                                                                    </a>
                                                                </td>
                                                                <td>
                                                                    @if ($product->is_available)
                                                                        <input type="number"
                                                                            name="products[{{ $product->stock_id }}][quantity]"
                                                                            id="quantity-{{ $product->stock_id }}"
                                                                            class="form-control quantity-input" value="" min="0"
                                                                            placeholder="0" max="{{ $product->quantity }}"
                                                                            data-id="{{ $product->stock_id }}"
                                                                            data-name="{{ $product->product_name }}"
                                                                            data-price="{{ $product->price_per_unit }}">
                                                                        <input type="hidden"
                                                                            name="products[{{ $product->stock_id }}][stock_id]"
                                                                            value="{{ $product->stock_id }}">
                                                                    @else
                                                                        <div style="position: relative;">
                                                                            <div
                                                                                style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(128, 128, 128, 0.5); z-index: 1;">
                                                                                <span
                                                                                    style="color: red; font-weight: bold; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">Product
                                                                                    Unavailable</span>
                                                                            </div>
                                                                            <input type="number" class="form-control" disabled>
                                                                        </div>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <span id="total-price-{{ $product->stock_id }}">₱0.00</span>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Summary Section -->
                                    <div class="col-md-12 col-lg-4">
                                        <div class="bg-body-tertiary summary">
                                            <h3>Summary</h3>
                                            <div id="summary-items">
                                                <!-- Summary items will be dynamically added here -->
                                            </div>
                                            <h4 class="border-primary-subtle"
                                                style="border-color: var(--bs-primary-border-subtle); margin-top: 20px;">
                                                <span class="text">Subtotal</span>
                                                <span id="subtotal-price" class="price">₱0.00</span>
                                                <!-- Initialize as ₱0.00 -->
                                            </h4>
                                            <h4 class="border-primary-subtle"
                                                style="border-color: var(--bs-primary-border-subtle);">
                                                <span class="text">Tax (12%)</span>
                                                <span id="tax-price" class="price">₱0.00</span> <!-- Initialize as ₱0.00 -->
                                            </h4>
                                            <h4 class="border-primary-subtle"
                                                style="border-color: var(--bs-primary-border-subtle);">
                                                <span class="text">Delivery Fee</span>
                                                <span id="delivery-fee"
                                                    class="price">₱{{ number_format(session('delivery_fee', 20), 2) }}</span>
                                            </h4>
                                            <h4 class="border-primary-subtle"
                                                style="border-color: var(--bs-primary-border-subtle);">
                                                <span class="text">Total</span>
                                                <span id="total-price" class="price">₱0.00</span>
                                            </h4>
                                            <button type="submit" id="proceed-to-payment"
                                                class="btn btn-primary btn-lg d-block w-100"
                                                style="background: #4ac9b0; margin-top: 40px;" disabled>
                                                <i class="fas fa-arrow-circle-right"
                                                    style="font-size: 24px; margin-right: 33px;"></i>Proceed to Payment
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </form>
            </div>
        </section>
    </main>

    <!-- SweetAlert2 Toast Notification -->
    @if(session('order_canceled'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Order Canceled',
                    text: '{{ session('order_canceled') }}',
                    toast: true,
                    position: 'bottom-end', // Changed to bottom-right
                    showConfirmButton: false,
                    timer: 4000,
                    timerProgressBar: true,
                });
            });
        </script>
    @endif
    @if(session('address_confirmed'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Address Confirmed',
                    text: '{{ session('address_confirmed') }}',
                    toast: true,
                    position: 'bottom-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });
            });
        </script>
    @endif
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const proceedButton = document.getElementById('proceed-to-payment');
            const form = document.querySelector('form[action="{{ route('orders.save') }}"]');

            proceedButton.addEventListener('click', function (event) {
                event.preventDefault(); // Prevent the default form submission

                Swal.fire({
                    title: 'Are you sure?',
                    html: 'The set location will be used as the <strong style="color: #007bff;">delivery address</strong>. Please confirm before proceeding.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#4ac9b0',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, proceed',
                    cancelButtonText: 'Cancel',
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Submit the form if the user confirms
                    }
                });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const quantityInputs = document.querySelectorAll('.quantity-input');
            const subtotalElement = document.getElementById('subtotal-price');
            const taxElement = document.getElementById('tax-price');
            const proceedButton = document.getElementById('proceed-to-payment');
            const summaryItemsContainer = document.getElementById('summary-items');
            const totalPriceElement = document.getElementById('total-price');

            let subtotal = 0;

            quantityInputs.forEach(input => {
                input.addEventListener('input', function () {
                    const id = this.dataset.id;
                    const price = parseFloat(this.dataset.price);
                    const quantity = parseInt(this.value) || 0;

                    // Update the total price for the product
                    const totalPrice = quantity * price;
                    document.getElementById(`total-price-${id}`).textContent = `₱${totalPrice.toFixed(2)}`;

                    // Update the subtotal
                    updateSubtotal();
                });
            });

            function updateSubtotal() {
                subtotal = 0;
                summaryItemsContainer.innerHTML = ''; // Clear the summary items container

                let hasItems = false; // Track if there are items in the summary

                // Calculate the subtotal from the total prices and update the summary
                document.querySelectorAll('.quantity-input').forEach(input => {
                    const price = parseFloat(input.dataset.price);
                    const quantity = parseInt(input.value) || 0;

                    if (quantity > 0) {
                        hasItems = true; // Mark that there are items in the summary

                        // Add the item to the summary
                        const itemName = input.dataset.name;
                        const itemTotal = price * quantity;

                        const summaryItem = document.createElement('div');
                        summaryItem.classList.add('d-flex', 'justify-content-between', 'align-items-center', 'mb-2');
                        summaryItem.innerHTML = `
                                        <span>
                                            <strong>${itemName}</strong><br>
                                            Quantity: ${quantity}
                                        </span>
                                        <span>₱${itemTotal.toFixed(2)}</span>
                                    `;
                        summaryItemsContainer.appendChild(summaryItem);

                        // Add to the subtotal
                        subtotal += itemTotal;
                    }
                });

                // Update the subtotal element
                subtotalElement.textContent = `₱${subtotal.toFixed(2)}`;

                // Calculate the tax (12% of subtotal)
                const tax = subtotal * 0.12;
                taxElement.textContent = `₱${tax.toFixed(2)}`;

                // Retrieve the delivery fee from the DOM
                const deliveryFeeElement = document.getElementById('delivery-fee'); // Select the delivery fee element by id
                const deliveryFee = parseFloat(deliveryFeeElement.textContent.replace('₱', '')) || 20; // Default to 20 if not set

                // Calculate the total (subtotal + tax + delivery fee)
                const total = subtotal + tax + deliveryFee;
                totalPriceElement.textContent = `₱${total.toFixed(2)}`;

                // Enable or disable the proceed button based on whether there are items
                proceedButton.disabled = !hasItems;
            }

            // Initial check on page load
            updateSubtotal();
        });
    </script>
@endsection