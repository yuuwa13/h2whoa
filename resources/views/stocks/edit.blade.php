<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, shrink-to-fit=no">
    <title>Stocks</title>
    <link rel="stylesheet" href="{{ asset('h2whoa_admin/assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins&amp;display=swap">
    <link rel="stylesheet" href="{{ asset('h2whoa_admin/assets/fonts/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('h2whoa_admin/assets/css/bs-theme-overrides.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.2/css/theme.bootstrap_4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <link rel="stylesheet" href="{{ asset('h2whoa_admin/assets/css/Ludens---1-Index-Table-with-Search--Sort-Filters-v20.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>

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
            <input
                type="number"
                id="quantity"
                name="quantity"
                class="form-control @error('quantity') is-invalid @enderror"
                value="{{ old('quantity', $stock->quantity) }}"
            >
            <input type="hidden" id="hidden_quantity" name="quantity" value="{{ old('quantity', $stock->quantity) }}">
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

        <div class="mb-3">
            <label for="is_available" class="form-label">Available</label>
            <input type="checkbox" id="is_available" name="is_available" value="1" {{ old('is_available', $stock->is_available) ? 'checked' : '' }}>
        </div>

        <div class="mb-3">
            <label for="is_quantifiable" class="form-label">Quantifiable</label>
            <input type="checkbox" id="is_quantifiable" name="is_quantifiable" value="1" {{ old('is_quantifiable', $stock->is_quantifiable) ? 'checked' : '' }}>
            <small class="form-text text-muted">Quantifiable means the stock can be measured in units (e.g., bottles, pieces).</small>
        </div>

        <div class="mb-3">
            <label for="maximum_orders_allowed" class="form-label">Maximum Orders Allowed</label>
            <input
                type="number"
                id="maximum_orders_allowed"
                name="maximum_orders_allowed"
                class="form-control @error('maximum_orders_allowed') is-invalid @enderror"
                value="{{ old('maximum_orders_allowed', $stock->maximum_orders_allowed) }}"
            >
            @error('maximum_orders_allowed')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="form-text text-muted">Maximum orders allowed should not exceed the quantity if quantifiable.</small>
        </div>


        <a href="{{ route('admin.stocks') }}" class="btn btn-secondary">Cancel</a>
        <button type="submit" class="btn btn-primary">Update Stock</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const successMessage = '{{ session('success') }}';
        const errorMessage = '{{ session('error') }}';

        if (successMessage) {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: successMessage,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
        }

        if (errorMessage) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: errorMessage,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
        }

        const isQuantifiableCheckbox = document.getElementById('is_quantifiable');
        const quantityField = document.getElementById('quantity');
        const maxOrdersField = document.getElementById('maximum_orders_allowed');

        function toggleFields() {
            if (isQuantifiableCheckbox.checked) {
                quantityField.disabled = false;
                quantityField.required = true;
                maxOrdersField.disabled = true;
                maxOrdersField.required = false;
            } else {
                quantityField.disabled = true;
                quantityField.required = false;
                maxOrdersField.disabled = false;
                maxOrdersField.required = true;
            }
        }

        isQuantifiableCheckbox.addEventListener('change', toggleFields);
        toggleFields(); // Initialize on page load
    });
</script>

</html>