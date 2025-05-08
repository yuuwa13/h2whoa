@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h3 class="text-dark mb-4">Activity Log</h3>
    <div class="row">
        <div class="col-lg-3">
            <div class="list-group">
                <a href="{{ route('admin.activity-log.customers') }}" class="list-group-item list-group-item-action">Customers</a>
                <a href="{{ route('admin.activity-log.orders') }}" class="list-group-item list-group-item-action">Orders</a>
                <a href="{{ route('admin.activity-log.stocks') }}" class="list-group-item list-group-item-action">Stocks</a>
                <a href="{{ route('admin.activity-log.sales') }}" class="list-group-item list-group-item-action">Sales</a>
            </div>
        </div>
        <div class="col-lg-9">
            <p>Select a category from the left to view activity logs.</p>
        </div>
    </div>
</div>
@endsection