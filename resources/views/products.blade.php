@extends('app')

@section('content')
<div class="header-section">
    <h2>Our Products</h2>
    @if($products->isEmpty())
    <p class="text-center fs-4 mt-5">No products available at the moment.</p>
    @else
    <p class="lead">Explore our range of delicious offerings.</p>
</div>


    <div class="row">
        @foreach ($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <!-- Display product image if it exists -->
                    <img src="{{ asset('storage/'.$product->image) }}" class="card-img-top product-img" alt="Product Image">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->product_name }}</h5>
                        <p class="card-text">{{ $product->description }}</p>
                        <p class="text-muted">₱{{ number_format($product->price, 2) }}</p>
                        <div class="d-flex justify-content-between product-buttons">
                            <!-- Add to Cart Form -->
                            <form action="{{ route('cart.add', $product->product_id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary add-to-cart-btn">Add to Cart</button>
                            </form>
                            <!-- Edit and Remove Buttons -->
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

<!-- Confirmation Modal -->
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
