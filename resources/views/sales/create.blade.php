<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Sales</title>
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
    <h3 class="mb-4">Add Sale</h3>

    <form action="{{ route('sales.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="order_id" class="form-label">Order ID</label>
            <input type="number" class="form-control @error('order_id') is-invalid @enderror" id="order_id" name="order_id" required>
            @error('order_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="sale_type" class="form-label">Sale Type</label>
            <select class="form-select @error('sale_type') is-invalid @enderror" id="sale_type" name="sale_type" required>
                <option value="phone">Phone</option>
                <option value="on-site">On-Site</option>
            </select>
            @error('sale_type')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="sale_details" class="form-label">Sale Details</label>
            <table class="table table-bordered" id="saleDetailsTable">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Price Per Unit</th>
                        <th>Total Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="text" name="sale_details[0][product_name]" class="form-control" required></td>
                        <td><input type="number" name="sale_details[0][quantity]" class="form-control" required></td>
                        <td><input type="number" step="0.01" name="sale_details[0][price_per_unit]" class="form-control" required></td>
                        <td><input type="number" step="0.01" name="sale_details[0][total_price]" class="form-control" readonly></td>
                        <td><button type="button" class="btn btn-danger" onclick="removeRow(this)">Remove</button></td>
                    </tr>
                </tbody>
            </table>
            <button type="button" class="btn btn-secondary" onclick="addRow()">Add Row</button>
        </div>

        <a href="{{ route('sales.index') }}" class="btn btn-secondary">Cancel</a>
        <button type="submit" class="btn btn-primary">Save Sale</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function addRow() {
        const table = document.getElementById('saleDetailsTable').getElementsByTagName('tbody')[0];
        const rowCount = table.rows.length;
        const row = table.insertRow(rowCount);
        row.innerHTML = `
            <td><input type="text" name="sale_details[${rowCount}][product_name]" class="form-control" required></td>
            <td><input type="number" name="sale_details[${rowCount}][quantity]" class="form-control" required></td>
            <td><input type="number" step="0.01" name="sale_details[${rowCount}][price_per_unit]" class="form-control" required></td>
            <td><input type="number" step="0.01" name="sale_details[${rowCount}][total_price]" class="form-control" readonly></td>
            <td><button type="button" class="btn btn-danger" onclick="removeRow(this)">Remove</button></td>
        `;
    }

    function removeRow(button) {
        const row = button.parentNode.parentNode;
        row.parentNode.removeChild(row);
    }
</script>

</html>