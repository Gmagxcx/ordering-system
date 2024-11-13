@extends('app')

@section('content')
<div class="header-section">
    <h2>Our Products</h2>
    <p class="lead">Explore our range of delicious offerings.</p>
</div>
<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card">
            <img src="{{ asset('images/products/burger.jpg') }}" class="card-img-top product-img" alt="Product Image">
            <div class="card-body">
                <h5 class="card-title">Little Cheddar</h5>
                <p class="card-text">A bite-sized delight! Our Little Cheddar mini burger packs a punch with a juicy
                    beef patty, melted cheddar cheese, and a touch of tangy sauce, all in a soft, toasted mini bun.
                    Perfect for snacking!</p>
                <a href="#" class="btn btn-primary">Add to Cart</a>
            </div>
        </div>
    </div>
</div>
@endsection