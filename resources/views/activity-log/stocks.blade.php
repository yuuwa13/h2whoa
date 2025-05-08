@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h3 class="text-dark mb-4">Stock Activity Log</h3>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price Per Unit</th>
                    <th>Availability</th>
                    <th>Action Log</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($stocks as $stock)
                <tr>
                    <td>{{ $stock->product_name }}</td>
                    <td>{{ $stock->quantity }}</td>
                    <td>₱{{ number_format($stock->price_per_unit, 2) }}</td>
                    <td>{{ $stock->is_available ? 'Available' : 'Unavailable' }}</td>
                    <td><a href="{{ route('admin.activity-log.stocks.actions', $stock->stock_id) }}" class="btn btn-primary btn-sm">View Log</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $stocks->links() }}
</div>
@endsection