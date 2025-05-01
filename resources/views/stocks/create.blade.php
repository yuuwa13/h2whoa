@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Add New Stock</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('stocks.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="product_name" class="form-label">Item Name</label>
            <input type="text"
                   class="form-control @error('product_name') is-invalid @enderror"
                   id="product_name"
                   name="product_name"
                   value="{{ old('product_name') }}">
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
                   value="{{ old('quantity', 0) }}">
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
                   value="{{ old('price_per_unit') }}">
            @error('price_per_unit')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <a href="{{ route('admin.stocks') }}" class="btn btn-secondary">Cancel</a>
        <button type="submit" class="btn btn-primary">Save Stock</button>
    </form>
</div>
@endsection