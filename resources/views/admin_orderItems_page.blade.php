@extends('app')

@section('content')
<div class="container mt-5">
    <h2 class="text-center">Order Items</h2>

    <table class="table table-bordered text-center">
        <thead>
            <tr>
                <th>Order Item ID</th>
                <th>Order ID</th>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Item Price</th>
                <th>Total Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orderItems as $orderItem)
            <tr>
                <td class="align-middle">{{ $orderItem->order_item_id }}</td>
                <td class="align-middle">{{ $orderItem->order->order_id }}</td>
                <td class="align-middle">{{ $orderItem->product->product_name }}</td>
                <td class="align-middle">{{ $orderItem->quantity }}</td>
                <td class="align-middle">₱{{ number_format($orderItem->item_price, 2) }}</td>
                <td class="align-middle">₱{{ number_format($orderItem->item_price * $orderItem->quantity, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
