@extends('app')

@section('content')
<div class="header-section">
    <h1>Welcome to Kendy Corner</h1>

    <div class="mt-4 text-center">
        @if(Auth::user()->access === 'admin' || Auth::user()->access === 'employee')
            <a href="{{ route('orders.index') }}" class="btn btn-primary btn-lg mx-2">Orders</a>
            <a href="{{ route('order-items.index') }}" class="btn btn-primary btn-lg mx-2">Order Items</a>
        @endif

        @if(Auth::user()->access === 'admin')
            <a href="{{ route('users.index') }}" class="btn btn-primary btn-lg mx-2">Users</a>
        @endif

        <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg mx-2">Products</a>

    </div>
</div>
</div>
@endsection