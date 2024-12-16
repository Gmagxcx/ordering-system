@extends('app')

@section('content')
<div class="header-section">
    <h1>Welcome to Kendy Corner</h1>
    <div class="d-flex justify-content-center">
        <div id="welcomeCarousel" class="carousel slide mt-5 w-75 border" data-bs-ride="carousel" style="border: 5px solid pink;">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#welcomeCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1" style="background-color: pink;"></button>
                <button type="button" data-bs-target="#welcomeCarousel" data-bs-slide-to="1" aria-label="Slide 2" style="background-color: pink;"></button>
                <button type="button" data-bs-target="#welcomeCarousel" data-bs-slide-to="2" aria-label="Slide 3" style="background-color: pink;"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="{{ asset('images/carousel1.jpg') }}" class="d-block w-100" alt="First Slide">
                    <div class="carousel-caption d-none d-md-block"></div>
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('images/carousel2.jpg') }}" class="d-block w-100" alt="Second Slide">
                    <div class="carousel-caption d-none d-md-block"></div>
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('images/carousel3.jpg') }}" class="d-block w-100" alt="Third Slide">
                    <div class="carousel-caption d-none d-md-block"></div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#welcomeCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#welcomeCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>

    <div class="mt-4 text-center">
        <div class="row g-3 justify-content-center">
            @if(Auth::user()->access === 'admin' || Auth::user()->access === 'employee')
                <div class="col-12 col-md-6">
                    <a href="{{ route('orders.index') }}" class="btn btn-primary btn-lg w-100 py-3 fs-4" style="border: 2px solid orange;">Orders</a>
                </div>
                <div class="col-12 col-md-6">
                    <a href="{{ route('order-items.index') }}" class="btn btn-primary btn-lg w-100 py-3 fs-4" style="border: 2px solid orange;">Order Items</a>
                </div>
            @endif

            @if(Auth::user()->access === 'admin')
                <div class="col-12 col-md-6">
                    <a href="{{ route('users.index') }}" class="btn btn-primary btn-lg w-100 py-3 fs-4" style="border: 2px solid orange;">Users</a>
                </div>
            @endif

            <div class="col-12 col-md-6">
                <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg w-100 py-3 fs-4" style="border: 2px solid orange;">Products</a>
            </div>
        </div>
    </div>
</div>


@endsection

@section('footer')

@endsection