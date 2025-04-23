@extends('layouts.app')

@section('title', 'Edit Order')

@section('content')
<div class="container" style="padding-bottom: 100px;">  
    <h1>Edit Order</h1>
    <form action="{{ route('orders.update', $order->order_id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="customer_id" class="form-label">Customer</label>
            <select name="customer_id" id="customer_id" class="form-control" required>
                @foreach($customers as $customer)
                <option value="{{ $customer->customer_id }}" {{ $order->customer_id == $customer->customer_id ? 'selected' : '' }}>
                    {{ $customer->name }}
                </option>
                @endforeach
            </select>
        </div>

        <h3>Items</h3>
        <div id="items">
            @foreach($order->orderDetails as $index => $detail)
            <div class="item mb-3">
                <select name="items[{{ $index }}][stock_id]" class="form-control mb-2" required>
                    @foreach($stocks as $stock)
                    <option value="{{ $stock->stock_id }}" {{ $detail->stock_id == $stock->stock_id ? 'selected' : '' }}>
                        {{ $stock->product_name }} (₱{{ $stock->price_per_unit }})
                    </option>
                    @endforeach
                </select>
                <input type="number" name="items[{{ $index }}][quantity]" class="form-control" placeholder="Quantity" value="{{ $detail->quantity }}" required>
            </div>
            @endforeach
        </div>
        <button type="button" id="add-item" class="btn btn-secondary">Add Item</button>

        <div class="mb-3 mt-4">
            <label for="amount_paid" class="form-label">Amount Paid</label>
            <input type="number" name="amount_paid" id="amount_paid" class="form-control" placeholder="Enter amount paid" step="0.01" value="{{ $order->amount_paid }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Order</button>
    </form>
</div>

<script>
    let itemIndex = {{ $order->orderDetails->count() }};
    document.getElementById('add-item').addEventListener('click', function() {
        const itemsDiv = document.getElementById('items');
        const newItem = document.createElement('div');
        newItem.classList.add('item', 'mb-3');
        newItem.innerHTML = `
            <select name="items[${itemIndex}][stock_id]" class="form-control mb-2" required>
                @foreach($stocks as $stock)
                <option value="{{ $stock->stock_id }}">{{ $stock->product_name }} (₱{{ $stock->price_per_unit }})</option>
                @endforeach
            </select>
            <input type="number" name="items[${itemIndex}][quantity]" class="form-control" placeholder="Quantity" required>
        `;
        itemsDiv.appendChild(newItem);
        itemIndex++;
    });
</script>
@endsection