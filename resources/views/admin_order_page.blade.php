@extends('app')

@section('content')

<link href="{{ asset('css/users.css') }}" rel="stylesheet">


@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="table-container">

    <span class="top">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-fill" viewBox="0 0 16 16">
    <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
    </svg> <h2 class="text-center">Orders</h2></h1></span>

    <div class="report-container">
            <div class="report r-total">
                <h6 class="total">Total</h6>
                <h3 class="total">{{ $totalOrders }}</h3>
            </div>

            <div class="report">
                <h6>Pending</h6>
                <h3>{{ $pendingCount }}</h3>
            </div>

            <div class="report">
                <h6>Processing</h6>
                <h3>{{ $processedCount }}</h3>
            </div>

            <div class="report">
                <h6>Completed</h6>
                <h3>{{ $completedCount }}</h3>
            </div>
    </div>

    <form action="{{ url('/orders') }}" method="GET" class="searchGroup mb-0 d-flex justify-content align-items-center">
            <input type="search" name="search" class="form-control w-20 me-2" placeholder="Search orders, order status and users. Hit enter to search" value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary">Search</button>
    </form>

    <div class="table-responsive">
        <table class="table table-hover custom-table">
        <thead>
            <tr>
                <th scope="col">Order ID</th>
                <th scope="col">User</th>
                <th scope="col">Order Date</th>
                <th scope="col">Total Price</th>
                <th scope="col">Order Status</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
            <tr>
                <td class="align-middle">{{ $order->order_id }}</td>
                <td class="align-middle">{{ $order->user->first_name }} {{ $order->user->last_name }}</td>
                <td class="align-middle">{{ $order->order_date }}</td>
                <td class="align-middle">₱{{ number_format($order->total_price, 2) }}</td>
                <td class="align-middle">
                    <form action="{{ route('admin.orders.update', $order->order_id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <select name="order_status" class="form-control text-center" onchange="this.form.submit()">
                            <option value="pending" {{ $order->order_status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ $order->order_status == 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="completed" {{ $order->order_status == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </form>
                </td>
                <td class="align-middle">
                    <form action="{{ route('orders.cancel', $order->order_id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" {{ $order->order_status == 'completed' ? 'disabled' : '' }}>
                            Cancel Order
                        </button>
                    </form>
                </td>
            @endforeach
        </tbody>
    </table>
    <div class="pagination">
    {{ $orders->links() }} 
    </div>
</div>
@endsection
