@extends('app')

@section('content')
<div class="header-section d-flex justify-content-between align-items-center">
    <h2>Our Products</h2>
    <div>
    @if(Auth::check() && (Auth::user()->access === 'admin' || Auth::user()->access === 'employee'))
        <button id="cardViewBtn" class="btn btn-primary">Card View</button>
        
            <button id="tableViewBtn" class="btn btn-secondary">Table View</button>
        @endif
    </div>
</div>

@if ($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

@if($products->isEmpty())
<p class="text-center fs-4 mt-5">No products available at the moment.</p>
@else
<p class="lead">Explore our range of delicious offerings.</p>
@endif

{{-- Success Modals --}}

@if (session('updated'))
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Success</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{ session('updated') }}
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var successModal = new bootstrap.Modal(document.getElementById('successModal'));
        successModal.show();
        setTimeout(function () {
            successModal.hide();
        }, 1000);
    });
</script>
@endif

@if (session('success'))
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Success</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{ session('success') }}
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var successModal = new bootstrap.Modal(document.getElementById('successModal'));
        successModal.show();
        setTimeout(function () {
            successModal.hide();
        }, 2000);
    });
</script>
@endif
<div class="row">

<div id="cardView" class="row">
    @if(Auth::check() && (Auth::user()->access === 'admin' || Auth::user()->access === 'employee'))
    <div class="col-md-4 mb-4">
        <div class="card h-100 d-flex align-items-center justify-content-center border-dashed text-center">
            <a href="{{ route('admin.products.create') }}" class="text-decoration-none text-muted">
                <div class="card-body">
                    <h1 class="display-1 text-primary">+</h1>
                    <h5 class="card-title">Add New Product</h5>
                </div>
            </a>
        </div>
    </div>
    @endif

    @foreach ($products as $product)
    <div class="col-md-4 mb-4">
        <div class="card">
            <img src="{{ asset('storage/'.$product->image) }}" class="card-img-top product-img" alt="Product Image">
            <div class="card-body">
                <h5 class="card-title">{{ $product->product_name }}</h5>
                <p class="card-text">{{ $product->description }}</p>
                <p class="text-muted">₱{{ number_format($product->price, 2) }}</p>
                @if($product->available_quantity > 0)
                <p class="text-muted mb-3">Stock Remaining: {{ $product->available_quantity }}</p>
                @else
                <p class="text-muted mb-3">Out of Stock</p>
                @endif

                {{-- Display Product Category --}}
                <p class="badge custom-badge">{{ $product->category }}</p>

                @if(Auth::check() && Auth::user()->access === 'user')
                <div class="d-flex justify-content-between product-buttons" style="gap: 10px; flex-wrap: wrap;">
                    <form action="{{ route('cart.add') }}" method="POST" class="w-100 w-sm-auto">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                        <input type="hidden" name="product_name" value="{{ $product->product_name }}">
                        <input type="hidden" name="price" value="{{ $product->price }}">
                        <button type="submit" class="btn btn-primary w-100">Add to Cart</button>
                    </form>
                </div>
            @endif

            @if(Auth::check() && (Auth::user()->access === 'admin' || Auth::user()->access === 'employee'))
                <div class="d-flex justify-content-between product-buttons" style="gap: 10px; flex-wrap: wrap;">
                    <a href="{{ route('admin.products.edit', $product->product_id) }}" class="btn btn-primary w-100 w-sm-auto mt-5">Edit</a>
                    <form action="#" method="POST" class="d-inline w-100 w-sm-auto">
                        <button type="button" class="btn btn-danger product-remove-btn w-100" 
                            data-bs-toggle="modal" 
                            data-bs-target="#confirmDeleteModal" 
                            data-action="{{ route('admin.products.destroy', $product->product_id) }}">
                            Remove
                        </button>
                    </form>
                </div>
            @endif

            </div>
        </div>
    </div>
    @endforeach
</div>

<div id="tableView" class="d-none">
    <table class="table table-bordered text-center">
        <thead>
            <tr>
                @if(Auth::check() && (Auth::user()->access === 'admin' || Auth::user()->access === 'employee'))
                <th colspan="7" class="text-center">
                    <a href="{{ route('admin.products.create') }}" class="btn btn-success w-100">
                        <h5 class="m-0">+ Add New Product</h5>
                    </a>
                </th>
                @endif
            </tr>
            <tr>
                <th>Image</th>
                <th>Product Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Category</th>
                @if(Auth::check() && (Auth::user()->access === 'admin' || Auth::user()->access === 'employee'))
                <th>Actions</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
            <tr>
                <td><img src="{{ asset('storage/'.$product->image) }}" alt="Product Image" style="max-width: 100px; max-height: 100px;"></td>
                <td>{{ $product->product_name }}</td>
                <td>{{ $product->description }}</td>
                <td>₱{{ number_format($product->price, 2) }}</td>
                <td>
                    <form action="{{ route('admin.products.update_quantity', $product->product_id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="d-flex justify-content-center">
                            <button type="submit" name="quantity_change" value="increase" class="btn btn-warning">+</button>
                            <input type="number" name="quantity" value="{{ $product->available_quantity }}" class="form-control text-center mx-2" style="width: 80px;">
                            <button type="submit" name="quantity_change" value="decrease" class="btn btn-warning">-</button>
                        </div>
                    </form>
                </td>
                <td>{{ $product->category }}</td>
                @if(Auth::check() && (Auth::user()->access === 'admin' || Auth::user()->access === 'employee'))
                <td>
                    <a href="{{ route('admin.products.edit', $product->product_id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('admin.products.destroy', $product->product_id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Remove</button>
                    </form>
                </td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
</div>


{{-- Confirmation Modal --}}
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this product? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const cardViewBtn = document.getElementById('cardViewBtn');
    const tableViewBtn = document.getElementById('tableViewBtn');
    const cardView = document.getElementById('cardView');
    const tableView = document.getElementById('tableView');
    const userId = "{{ Auth::id() }}";

    const viewPreferenceKey = `viewPreference_${userId}`;

    const savedView = localStorage.getItem(viewPreferenceKey);
    if (savedView === 'table') {
        tableView.classList.remove('d-none');
        cardView.classList.add('d-none');
        tableViewBtn.classList.add('btn-primary');
        tableViewBtn.classList.remove('btn-secondary');
        cardViewBtn.classList.add('btn-secondary');
        cardViewBtn.classList.remove('btn-primary');
    } else {
        cardView.classList.remove('d-none');
        tableView.classList.add('d-none');
        cardViewBtn.classList.add('btn-primary');
        cardViewBtn.classList.remove('btn-secondary');
        tableViewBtn.classList.add('btn-secondary');
        tableViewBtn.classList.remove('btn-primary');
    }

    cardViewBtn.addEventListener('click', function () {
        cardView.classList.remove('d-none');
        tableView.classList.add('d-none');
        localStorage.setItem(viewPreferenceKey, 'card');
        cardViewBtn.classList.add('btn-primary');
        cardViewBtn.classList.remove('btn-secondary');
        tableViewBtn.classList.add('btn-secondary');
        tableViewBtn.classList.remove('btn-primary');
    });

    tableViewBtn.addEventListener('click', function () {
        tableView.classList.remove('d-none');
        cardView.classList.add('d-none');
        localStorage.setItem(viewPreferenceKey, 'table');
        tableViewBtn.classList.add('btn-primary');
        tableViewBtn.classList.remove('btn-secondary');
        cardViewBtn.classList.add('btn-secondary');
        cardViewBtn.classList.remove('btn-primary');
    });

    const removeButtons = document.querySelectorAll('.product-remove-btn');
    removeButtons.forEach(button => {
        button.addEventListener('click', function () {
            const actionUrl = this.getAttribute('data-action');
            document.getElementById('deleteForm').action = actionUrl;
        });
    });
});
</script>
@endsection