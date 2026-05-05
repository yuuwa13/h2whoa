@extends('layouts.app')

@section('title', 'Place Order')

@section('content')
<style nonce="{{ csp_nonce() }}">
    .order-page { padding: 2rem 0 8rem; }

    /* Address bar */
    .address-bar {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
    }
    .address-bar .address-label {
        font-size: .75rem;
        font-weight: 700;
        letter-spacing: .08em;
        text-transform: uppercase;
        color: #888;
        margin-bottom: .2rem;
    }
    .address-bar .address-value {
        font-size: .95rem;
        font-weight: 500;
        color: #1a1a2e;
    }
    .btn-locate {
        background: #4ac9b0;
        border: none;
        color: #fff;
        font-size: .85rem;
        font-weight: 600;
        letter-spacing: .04em;
        padding: .5rem 1.25rem;
        border-radius: 8px;
        white-space: nowrap;
        transition: background .2s;
        text-decoration: none;
    }
    .btn-locate:hover { background: #35b39a; color: #fff; }

    /* Products card */
    .products-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        overflow: hidden;
    }
    .products-card .table { margin-bottom: 0; }
    .products-card .table thead th {
        background: #f8fafc;
        font-size: .75rem;
        font-weight: 700;
        letter-spacing: .08em;
        text-transform: uppercase;
        color: #64748b;
        border-bottom: 2px solid #e2e8f0;
        padding: 1rem 1.25rem;
    }
    .products-card .table tbody td {
        padding: 1.1rem 1.25rem;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
    }
    .products-card .table tbody tr:last-child td { border-bottom: none; }

    .product-img {
        width: 72px;
        height: 72px;
        object-fit: contain;
        border-radius: 8px;
        background: #f8fafc;
        padding: 4px;
    }
    .product-name {
        font-weight: 700;
        font-size: .9rem;
        color: #1a1a2e;
        display: block;
        margin-top: .4rem;
    }
    .product-meta {
        font-size: .78rem;
        color: #888;
        margin-top: .2rem;
    }
    .unavailable-badge {
        display: inline-block;
        background: #fee2e2;
        color: #dc2626;
        font-size: .72rem;
        font-weight: 700;
        padding: .25rem .6rem;
        border-radius: 20px;
        letter-spacing: .04em;
    }
    .quantity-input {
        width: 90px;
        text-align: center;
        border: 1.5px solid #e2e8f0;
        border-radius: 8px;
        padding: .4rem .6rem;
        font-size: .9rem;
        font-weight: 600;
        transition: border-color .2s;
    }
    .quantity-input:focus {
        border-color: #4ac9b0;
        outline: none;
        box-shadow: 0 0 0 3px rgba(74,201,176,.15);
    }
    .item-total {
        font-weight: 700;
        font-size: .95rem;
        color: #1a1a2e;
    }

    /* Summary card */
    .summary-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1.5rem;
        position: sticky;
        top: 126px;
        max-height: calc(100vh - 150px);
        overflow-y: auto;
    }
    .summary-card h5 {
        font-size: .75rem;
        font-weight: 700;
        letter-spacing: .1em;
        text-transform: uppercase;
        color: #64748b;
        border-bottom: 2px solid #4ac9b0;
        padding-bottom: .6rem;
        margin-bottom: 1.2rem;
    }
    .summary-items { margin-bottom: 1rem; min-height: 1rem; }
    .summary-item {
        display: flex;
        justify-content: space-between;
        font-size: .85rem;
        margin-bottom: .5rem;
        color: #444;
    }
    .summary-divider {
        border: none;
        border-top: 1px solid #e2e8f0;
        margin: .8rem 0;
    }
    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: .9rem;
        margin-bottom: .5rem;
        color: #555;
    }
    .summary-row.total {
        font-weight: 700;
        font-size: 1.05rem;
        color: #1a1a2e;
        margin-top: .6rem;
        padding-top: .6rem;
        border-top: 2px solid #e2e8f0;
    }
    .btn-proceed {
        background: #4ac9b0;
        border: none;
        color: #fff;
        font-weight: 700;
        font-size: .9rem;
        letter-spacing: .04em;
        padding: .85rem 1.5rem;
        border-radius: 10px;
        width: 100%;
        margin-top: 1.25rem;
        transition: background .2s, opacity .2s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: .6rem;
    }
    .btn-proceed:hover:not(:disabled) { background: #35b39a; }
    .btn-proceed:disabled { opacity: .55; cursor: not-allowed; }
</style>

<section class="order-page">
    <div class="container">

        <form action="{{ route('orders.save') }}" method="POST">
            @csrf

            {{-- Address bar --}}
            <div class="address-bar">
                <div>
                    <div class="address-label">Delivery Address</div>
                    @if(session('selected_address'))
                        <div class="address-value">
                            <i class="fas fa-map-marker-alt me-1" style="color:#4ac9b0;"></i>
                            {{ session('selected_address') }}
                        </div>
                    @else
                        <div class="address-value text-warning">
                            <i class="fas fa-exclamation-triangle me-1"></i>
                            No address set — please locate your address before ordering.
                        </div>
                    @endif
                </div>
                <a href="{{ route('locate.address') }}" class="btn-locate">
                    <i class="fas fa-map-marker-alt me-1"></i> Locate Address
                </a>
            </div>

            <div class="row g-4">
                {{-- Products --}}
                <div class="col-lg-8">
                    <div class="products-card">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th style="width:120px;">Quantity</th>
                                        <th style="width:120px;">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-start gap-3">
                                                <img class="product-img"
                                                    src="{{ $product->uploadedImage
                                                        ? asset('storage/' . ltrim($product->uploadedImage->file_path, '/'))
                                                        : asset('h2whoa_user/assets/img/elements/Water.png') }}"
                                                    alt="{{ $product->product_name }}">
                                                <div>
                                                    <span class="product-name">{{ $product->product_name }}</span>
                                                    <div class="product-meta">
                                                        ₱{{ number_format($product->price_per_unit, 2) }} per unit &nbsp;·&nbsp;
                                                        {{ $product->quantity }} in stock
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if($product->is_available)
                                                <input type="number"
                                                    name="products[{{ $product->stock_id }}][quantity]"
                                                    id="quantity-{{ $product->stock_id }}"
                                                    class="quantity-input"
                                                    value="" min="0"
                                                    placeholder="0"
                                                    max="{{ $product->quantity }}"
                                                    data-id="{{ $product->stock_id }}"
                                                    data-name="{{ $product->product_name }}"
                                                    data-price="{{ $product->price_per_unit }}">
                                                <input type="hidden"
                                                    name="products[{{ $product->stock_id }}][stock_id]"
                                                    value="{{ $product->stock_id }}">
                                            @else
                                                <span class="unavailable-badge">Unavailable</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span id="total-price-{{ $product->stock_id }}" class="item-total">₱0.00</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Summary --}}
                <div class="col-lg-4">
                    <div class="summary-card">
                        <h5>Order Summary</h5>

                        <div class="summary-items" id="summary-items"></div>

                        <hr class="summary-divider">

                        <div class="summary-row">
                            <span>Subtotal</span>
                            <span id="subtotal-price">₱0.00</span>
                        </div>
                        <div class="summary-row">
                            <span>Tax (12%)</span>
                            <span id="tax-price">₱0.00</span>
                        </div>
                        <div class="summary-row">
                            <span>Delivery Fee</span>
                            <span id="delivery-fee">₱{{ number_format(session('delivery_fee', 20), 2) }}</span>
                        </div>
                        <div class="summary-row total">
                            <span>Total</span>
                            <span id="total-price">₱0.00</span>
                        </div>

                        <button type="submit" id="proceed-to-payment" class="btn-proceed"
                            @if(!session('selected_address')) disabled @endif>
                            <i class="fas fa-arrow-right"></i>
                            Proceed to Payment
                        </button>
                    </div>
                </div>
            </div>
        </form>

    </div>
</section>

{{-- Toast notifications --}}
@if(session('order_canceled'))
    <script nonce="{{ csp_nonce() }}">
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({ icon: 'error', title: 'Order Canceled', text: '{{ session('order_canceled') }}',
                toast: true, position: 'bottom-end', showConfirmButton: false, timer: 4000, timerProgressBar: true });
        });
    </script>
@endif
@if(session('address_confirmed'))
    <script nonce="{{ csp_nonce() }}">
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({ icon: 'success', title: 'Address Confirmed', text: '{{ session('address_confirmed') }}',
                toast: true, position: 'bottom-end', showConfirmButton: false, timer: 3000, timerProgressBar: true });
        });
    </script>
@endif

<script nonce="{{ csp_nonce() }}">
    document.addEventListener('DOMContentLoaded', function () {
        const proceedButton = document.getElementById('proceed-to-payment');
        const form = document.querySelector('form[action="{{ route('orders.save') }}"]');
        const hasAddress = @json(session('selected_address') ? true : false);

        form.addEventListener('submit', function (e) {
            if (!hasAddress) {
                e.preventDefault();
                Swal.fire({ icon: 'warning', title: 'Address required',
                    text: 'Please set your delivery address before proceeding to payment.',
                    toast: true, position: 'bottom-end', showConfirmButton: false, timer: 3000 });
            }
        });

        proceedButton.addEventListener('click', function (event) {
            if (!hasAddress) {
                event.preventDefault();
                Swal.fire({ icon: 'warning', title: 'Address required',
                    text: 'Please set your delivery address before proceeding to payment.',
                    toast: true, position: 'bottom-end', showConfirmButton: false, timer: 3000 });
                return;
            }

            event.preventDefault();
            Swal.fire({
                title: 'Confirm Order',
                html: 'The set location will be used as the <strong style="color:#4ac9b0;">delivery address</strong>. Proceed?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#4ac9b0',
                cancelButtonColor: '#e2e8f0',
                confirmButtonText: 'Yes, proceed',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) form.submit();
            });
        });
    });
</script>

<script nonce="{{ csp_nonce() }}">
    document.addEventListener('DOMContentLoaded', function () {
        const quantityInputs = document.querySelectorAll('.quantity-input');
        const subtotalElement = document.getElementById('subtotal-price');
        const taxElement      = document.getElementById('tax-price');
        const totalElement    = document.getElementById('total-price');
        const proceedButton   = document.getElementById('proceed-to-payment');
        const summaryContainer = document.getElementById('summary-items');

        quantityInputs.forEach(input => {
            input.addEventListener('keydown', function (e) {
                if (['e', 'E', '-', '+', '.'].includes(e.key)) e.preventDefault();
            });

            input.addEventListener('input', function () {
                // Strip any non-integer characters that slipped through (e.g. via paste)
                this.value = this.value.replace(/[^0-9]/g, '');
                if (this.value === '') { this.value = ''; }
                const max = parseInt(this.getAttribute('max'));
                let quantity = parseInt(this.value) || 0;

                if (!isNaN(max) && quantity > max) {
                    this.value = max;
                    quantity = max;
                    Swal.fire({ icon: 'warning', title: 'Not enough stock',
                        text: `Only ${max} unit(s) available for ${this.dataset.name}.`,
                        toast: true, position: 'bottom-end', showConfirmButton: false, timer: 2500 });
                }

                const price = parseFloat(this.dataset.price);
                document.getElementById(`total-price-${this.dataset.id}`).textContent = `₱${(quantity * price).toFixed(2)}`;
                updateSubtotal();
            });
        });

        function updateSubtotal() {
            let subtotal = 0;
            let hasItems = false;
            let exceededStock = false;
            summaryContainer.innerHTML = '';

            document.querySelectorAll('.quantity-input').forEach(input => {
                const price    = parseFloat(input.dataset.price);
                const quantity = parseInt(input.value) || 0;
                const max      = parseInt(input.getAttribute('max'));

                if (!isNaN(max) && quantity > max) exceededStock = true;

                if (quantity > 0) {
                    hasItems = true;
                    const itemTotal = price * quantity;
                    subtotal += itemTotal;

                    const row = document.createElement('div');
                    row.className = 'summary-item';
                    row.innerHTML = `<span><strong>${input.dataset.name}</strong> &times; ${quantity}</span><span>₱${itemTotal.toFixed(2)}</span>`;
                    summaryContainer.appendChild(row);
                }
            });

            subtotalElement.textContent = `₱${subtotal.toFixed(2)}`;
            const tax = subtotal * 0.12;
            taxElement.textContent = `₱${tax.toFixed(2)}`;
            const deliveryFee = parseFloat(document.getElementById('delivery-fee').textContent.replace('₱', '').replace(',', '')) || 20;
            totalElement.textContent = `₱${(subtotal + tax + deliveryFee).toFixed(2)}`;

            if (exceededStock) {
                proceedButton.disabled = true;
            } else {
                proceedButton.disabled = !hasItems;
            }
        }

        updateSubtotal();
    });
</script>
@endsection
