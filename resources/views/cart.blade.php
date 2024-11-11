@extends('app')

@section('content')
<div class="header-section">
    <h2>Your Cart</h2>
    <p class="lead">Review your items before checkout.</p>
</div>
<div class="card mb-4">
    <div class="card-body d-flex justify-content-between align-items-center">
        <div>
            <h5 class="card-title">Product Name</h5>
            <p class="card-text">Quantity: 1</p>
        </div>
        <p class="text-muted">Price: ₱400.00</p>
    </div>
</div>
<div class="text-center">
    <a href="#" class="btn btn-primary">Proceed to Checkout</a>
</div>
@endsection