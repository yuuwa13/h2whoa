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
                            <p style="width: 500px;">Apo ni Lola, San Antonio<br>Matina, Davao City</p>
                        </div>
                        <div class="col-md-6">
                            <a class="btn btn-primary btn-lg d-block w-100" role="button"
                                href="{{ route('locate.address') }}"
                                style="background: #4ac9b0; width: 300px; margin-top: 37px;">
                                <i class="fas fa-map-marker" style="font-size: 24px; margin-right: 33px;"></i>Locate Address
                            </a>
                        </div>
                    </div>

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
                                                                    src="{{ asset('h2whoa_user/assets/img/elements/default.png') }}">
                                                                <a class="product-name">
                                                                    <br><strong>{{ strtoupper($product->product_name) }}</strong><br><br>
                                                                    <span>Amount:
                                                                        ₱{{ number_format($product->price_per_unit, 2) }}<br>In
                                                                        Stock: {{ $product->quantity }}</span>
                                                                </a>
                                                            </td>
                                                            <td>
                                                                <input type="number"
                                                                    name="products[{{ $product->stock_id }}][quantity]"
                                                                    id="quantity-{{ $product->stock_id }}"
                                                                    class="form-control quantity-input" value="" min="0"
                                                                    placeholder="0" max="{{ $product->quantity }}"
                                                                    data-id="{{ $product->stock_id }}"
                                                                    data-name="{{ $product->product_name }}"
                                                                    data-price="{{ $product->price_per_unit }}">
                                                                <input type="hidden"
                                                                    name="products[{{ $product->stock_id }}][name]"
                                                                    value="{{ $product->product_name }}">
                                                                <input type="hidden"
                                                                    name="products[{{ $product->stock_id }}][price]"
                                                                    value="{{ $product->price_per_unit }}">
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
                                            <span class="text">Tax (20%)</span>
                                            <span id="tax-price" class="price">₱0.00</span> <!-- Initialize as ₱0.00 -->
                                        </h4>
                                        <h4 class="border-primary-subtle"
                                            style="border-color: var(--bs-primary-border-subtle);">
                                            <span class="text">Delivery Fee</span>
                                            <span class="price">₱50.00</span> <!-- Delivery fee is static -->
                                        </h4>
                                        <h4 class="border-primary-subtle"
                                            style="border-color: var(--bs-primary-border-subtle);">
                                            <span class="text">Total</span>
                                            <span id="total-price" class="price">₱50.00</span>
                                            <!-- Initialize as ₱50.00 (delivery fee only) -->
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
                    icon: 'success',
                    title: 'Order Canceled',
                    text: '{{ session('order_canceled') }}',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 4000,
                    timerProgressBar: true,
                });
            });
        </script>
    @endif
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

                // Update the tax (20% of subtotal)
                const tax = subtotal * 0.20;
                taxElement.textContent = `₱${tax.toFixed(2)}`;

                // Update the total price (subtotal + tax + delivery fee)
                const deliveryFee = 50;
                const total = subtotal + tax + deliveryFee;
                totalPriceElement.textContent = `₱${total.toFixed(2)}`;

                // Enable or disable the proceed button based on whether there are items
                proceedButton.disabled = !hasItems;
            }
        });
    </script>
@endsection