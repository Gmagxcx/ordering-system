@extends('app')

@section('content')
<link href="{{ asset('css/users.css') }}" rel="stylesheet">

<div class="container mt-5">

    <div class="table-container">
        
        <span class="top">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
        <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
        </svg> <h2 class="text-center">Order Items</h2></h1></span>

        <div class="report-container">
            <div class="report r-total">
                <h6 class="total">Total</h6>
                <h3 class="total">{{ $totalOrderItems }}</h3>
            </div>
        </div>

        <form action="{{ url('/order-items') }}" method="GET" class="searchGroup mb-0 d-flex justify-content align-items-center">
            <input type="search" name="search" class="form-control w-20 me-2" placeholder="Search product, orders etc. Hit enter to search" value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary">Search</button>
        </form>

        <div class="table-responsive">
            <table class="table table-hover custom-table">
                <thead>
                    <tr>
                        <th scope="col">Order Item ID</th>
                        <th scope="col">Order ID</th>
                        <th scope="col">Product Name</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Item Price</th>
                        <th scope="col">Total Price</th>
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
            <div class="pagination">
            {{ $orderItems->links() }} 
            </div>
        </div>
    </div>
</div>
@endsection
