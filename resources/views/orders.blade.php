@extends('app')

@section('content')
<div class="header-section">
    <h2>Your Orders</h2>
    <p class="lead">Track your order status.</p>
</div>
@foreach ($orders as $order)
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Order #{{ $order->order_id }}</h5>
            <p>Order Date: {{ $order->order_date }}</p>
            <p>Total Price: ${{ $order->total_price }}</p>
            <p>Status: {{ $order->order_status }}</p>
            <ul>
                @foreach ($order->orderItems as $item)
                    <li>{{ $item->product->product_name }} - {{ $item->quantity }} x ${{ $item->item_price }}</li>
                @endforeach
            </ul>
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif            
        </div>
    </div>
@endforeach
@endsection
