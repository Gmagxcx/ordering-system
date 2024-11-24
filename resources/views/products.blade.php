@extends('app')

@section('content')
<div class="header-section">
    <h2>Our Products</h2>
    @if($products->isEmpty())
    <p class="text-center fs-4 mt-5">No products available at the moment.</p>
    @else
    <p class="lead">Explore our range of delicious offerings.</p>

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

</div>
    <div class="row">
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
                        @if(Auth::check() && (Auth::user()->access === 'admin' || Auth::user()->access === 'employee'))
                            <div class="mb-3">
                                <p class="text-secondary">Available Quantity: <strong>{{ $product->available_quantity }}</strong></p>
                                
                                <div class="d-flex justify-content-center align-items-center">
                                    <form action="{{ route('admin.products.update_quantity', $product->product_id) }}" method="POST" class="d-flex align-items-center">
                                        @csrf
                                        @method('PUT')

                                        <button type="submit" name="quantity_change" value="decrease" class="btn btn-danger btn-sm">-</button>
                                        
                                        <input type="text" class="form-control w-auto text-center mx-2" value="{{ $product->available_quantity }}" disabled style="max-width: 60px;">

                                        <button type="submit" name="quantity_change" value="increase" class="btn btn-success btn-sm">+</button>
                                    </form>
                                </div>
                            </div>
                        @endif

                        <div class="d-flex justify-content-between product-buttons">
                        <form action="{{ route('cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                            <input type="hidden" name="product_name" value="{{ $product->product_name }}">
                            <input type="hidden" name="price" value="{{ $product->price }}">
                            
                            <button type="submit" class="btn btn-primary">Add to Cart</button>
                        </form>
                        @if(Auth::check() && (Auth::user()->access === 'admin' || Auth::user()->access === 'employee'))
                            <a href="{{ route('admin.products.edit', $product->product_id) }}" class="btn btn-warning product-edit-btn">Edit</a>
                            <form action="#" method="POST" class="d-inline">
                                <button type="button" class="btn btn-danger product-remove-btn" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#confirmDeleteModal" 
                                    data-action="{{ route('admin.products.destroy', $product->product_id) }}">
                                    Remove
                                </button>
                            </form>
                        @endif
                    </div>

                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

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
        const deleteModal = document.getElementById('confirmDeleteModal');
        const deleteForm = document.getElementById('deleteForm');

        deleteModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const actionUrl = button.getAttribute('data-action');
            deleteForm.setAttribute('action', actionUrl);
        });
    });
</script>
@endsection
