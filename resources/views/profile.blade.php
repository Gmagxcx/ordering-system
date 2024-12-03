@extends('app')

@section('content')

<div class="container">
    <h2>Your Profile</h2>
    <div class="profile-info">
        <h3>Order History</h3>

        @if($orders->isEmpty())
            <p>You have no past orders.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Order Date</th>
                        <th>Total Price</th>
                        <th>Status</th>
                        <th>Items</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->order_id }}</td>
                            <td>{{ $order->order_date->format('d-m-Y') }}</td>
                            <td>${{ number_format($order->total_price, 2) }}</td>
                            <td>{{ ucfirst($order->order_status) }}</td>
                            <td>
                                <ul>
                                    @foreach($order->items as $item)
                                        <li>
                                            {{ $item->product->product_name }} - 
                                            Quantity: {{ $item->quantity }} 
                                            @if($item->product->available_quantity <= 0)
                                                (Out of stock)
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>

@endsection
