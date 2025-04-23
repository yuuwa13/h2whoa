@extends('layouts.app')

@section('content')
<div class="container" style="padding-bottom: 100px;">
    <h1 style="font-size: 50px" style="padding-bottom: 40px">Orders</h1>
    <a href="{{ route('orders.create') }}" class="btn btn-primary">Create New Order</a>
    <table class="table mt-4">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Total Price</th>
                <th>Order Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->order_id }}</td>
                <td>{{ $order->customer->name }}</td>
                <td>₱{{ number_format($order->calculateTotalPrice(), 2) }}</td> <!-- Dynamically calculate total price -->
                <td>{{ $order->order_datetime }}</td>
                <td>
                    <a href="{{ route('orders.edit', $order->order_id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('orders.destroy', $order->order_id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection