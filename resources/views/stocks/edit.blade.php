@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Edit Stock</h3>

    <form action="{{ route('stocks.update', $stock->stock_id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="product_name" class="form-label">Item Name</label>
            <input type="text"
                   class="form-control @error('product_name') is-invalid @enderror"
                   id="product_name"
                   name="product_name"
                   value="{{ old('product_name', $stock->product_name) }}">
            @error('product_name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="quantity" class="form-label">Quantity</label>
            <input type="number"
                   class="form-control @error('quantity') is-invalid @enderror"
                   id="quantity"
                   name="quantity"
                   value="{{ old('quantity', $stock->quantity) }}">
            @error('quantity')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="price_per_unit" class="form-label">Price per Unit (₱)</label>
            <input type="text"
                   class="form-control @error('price_per_unit') is-invalid @enderror"
                   id="price_per_unit"
                   name="price_per_unit"
                   value="{{ old('price_per_unit', $stock->price_per_unit) }}">
            @error('price_per_unit')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <a href="{{ route('admin.stocks') }}" class="btn btn-secondary">Cancel</a>
        <button type="submit" class="btn btn-primary">Update Stock</button>
    </form>
</div>
@endsection
