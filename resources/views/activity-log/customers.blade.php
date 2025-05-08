@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h3 class="text-dark mb-4">Customer Activity Log</h3>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Account Created</th>
                    <th>Actions</th>
                    <th>Order History</th>
                    <th>Logs</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($customers as $customer)
                <tr>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ $customer->created_at->format('F d, Y h:i A') }}</td>
                    <td><a href="{{ route('admin.activity-log.customer-actions', $customer->customer_id) }}" class="btn btn-secondary btn-sm">View Actions</a></td>
                    <td><a href="{{ route('admin.activity-log.customer-details', $customer->customer_id) }}" class="btn btn-primary btn-sm">View Order History</a></td>
                    <td><a href="{{ route('admin.activity-log.customer-logs', $customer->customer_id) }}" class="btn btn-info btn-sm">View Logs</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $customers->links() }}
</div>
@endsection