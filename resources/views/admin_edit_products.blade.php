@extends('app')

@section('content')
<div class="container mt-5">
    <h2>Edit Product</h2>
    <form action="{{ route('admin.products.update', $product->product_id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="product_name" class="form-label">Product Name</label>
            <input type="text" name="product_name" id="product_name" class="form-control" value="{{ old('product_name', $product->product_name) }}" required>
            @error('product_name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control" rows="4" required>{{ old('description', $product->description) }}</textarea>
            @error('description') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" name="price" id="price" class="form-control" value="{{ old('price', $product->price) }}" required>
            @error('price') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="available_quantity" class="form-label">Available Quantity</label>
            <input type="number" name="available_quantity" id="available_quantity" class="form-control" value="{{ old('available_quantity', $product->available_quantity) }}" required>
            @error('available_quantity') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <input type="text" name="category" id="category" class="form-control" value="{{ old('category', $product->category) }}" required>
            @error('category') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Product Image</label>
            <input type="file" name="image" id="image" class="form-control">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="Current Image" class="mt-2" width="100">
            @endif
            @error('image') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update Product</button>
    </form>
</div>
@endsection
