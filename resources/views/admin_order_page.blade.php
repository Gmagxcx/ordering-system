@extends('app')

@section('content')
<div class="container mt-5">
    <h2 class="text-center">Orders</h2>

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <table class="table table-bordered text-center">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>User</th>
                <th>Order Date</th>
                <th>Total Price</th>
                <th>Order Status</th>
                <th>Actions</th>
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
</div>
@endsection
