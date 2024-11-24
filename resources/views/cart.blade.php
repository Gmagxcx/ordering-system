@extends('app')

@section('content')
<div class="header-section">
    <h2>Your Bag</h2>
    <p class="lead">Review your items before checkout.</p>
</div>

@if (!empty($cart))
    @foreach ($cart as $productId => $item)
    <div class="card mb-4">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center w-75">
                    <!-- Product Image -->
                    <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['product_name'] }}" class="product-img" 
                         style="width: 60px; height: 60px; object-fit: cover; margin-right: 15px; border-radius: 5px;">
                    <!-- Product Information -->
                    <div>
                        <h5 class="card-title mb-1">{{ $item['product_name'] }}</h5>
                        <p class="card-text mb-1 text-muted">Quantity: {{ $item['quantity'] }}</p>
                        <p class="text-muted mb-0">Price: ₱{{ number_format($item['price'] * $item['quantity'], 2) }}</p>
                    </div>
                </div>
                <div class="text-end">
                    <form action="{{ route('cart.remove', $productId) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                    </form>
                </div>
            </div>
        </div>

    @endforeach

    <div class="text-center">
        <form action="{{ route('checkout.store') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary">Proceed to Checkout</button>
        </form>
    </div>

@else
    <p>Your cart is empty.</p>
@endif

@endsection
