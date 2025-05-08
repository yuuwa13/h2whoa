@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h3 class="text-dark mb-4">Sales Activity Log</h3>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Sale ID</th>
                    <th>Order ID</th>
                    <th>Sale Type</th>
                    <th>Total Items</th>
                    <th>Action Log</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sales as $sale)
                <tr>
                    <td>{{ $sale->sale_id }}</td>
                    <td>{{ $sale->order_id }}</td>
                    <td>{{ ucfirst($sale->sale_type) }}</td>
                    <td>{{ $sale->saleDetails->sum('quantity') }}</td>
                    <td><a href="{{ route('admin.activity-log.sales.actions', $sale->sale_id) }}" class="btn btn-primary btn-sm">View Log</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $sales->links() }}
</div>
@endsection