<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;


class AdminProductController extends Controller
{
    public function create()
    {
        if (!Auth::check() || (Auth::user()->access !== 'admin' && Auth::user()->access !== 'employee')) {
            Log::error('Access denied to Add Product page: User is not an admin or employee.', [
                'user_id' => Auth::id(),
                'user_access' => Auth::user()->access ?? 'none',
            ]);
            abort(404); 
        }

        return view('admin_add_products');
    }

    public function store(Request $request)
    {
        Log::info('Product creation request received', ['data' => $request->all()]);

        if (!Auth::check() || (Auth::user()->access !== 'admin' && Auth::user()->access !== 'employee')) {
            Log::error('Access denied to product creation: User is not an admin or employee.', [
                'user_id' => Auth::id(),
                'user_access' => Auth::user()->access ?? 'none',
            ]);
            abort(404); 
        }

        $request->validate([
            'product_name' => 'required|string|max:255',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'available_quantity' => 'required|integer|min:0',
            'category' => 'required|string',
            'image' => 'required|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        try {
            $imagePath = $request->file('image')->store('products', 'public');

            Product::create([
                'product_name' => $request->input('product_name'),
                'description' => $request->input('description'),
                'price' => $request->input('price'),
                'available_quantity' => $request->input('available_quantity'),
                'category' => $request->input('category'),
                'image' => $imagePath,
            ]);

            Log::info('Product added successfully', ['product_name' => $request->input('product_name')]);

            return redirect()->route('products.index')->with('success', 'Product added successfully!');
        } catch (\Exception $e) {
            Log::error('Error storing product', ['exception' => $e->getMessage()]);
            return back()->withErrors(['error' => 'There was an error adding the product. Please try again.']);
        }
    }

    public function edit($product_id)
    {
        $product = Product::findOrFail($product_id); // Use product_id
        return view('admin_edit_products', compact('product'));
    }

    public function update(Request $request, $product_id)
{
    $request->validate([
        'product_name' => 'required|string|max:255',
        'description' => 'required',
        'price' => 'required|numeric|min:0',
        'available_quantity' => 'required|integer|min:0',
        'category' => 'required|string',
        'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
    ]);

    $product = Product::findOrFail($product_id);

    $product->product_name = $request->input('product_name');
    $product->description = $request->input('description');
    $product->price = $request->input('price');
    $product->available_quantity = max(0, $request->input('available_quantity')); // Ensure non-negative
    $product->category = $request->input('category');

    if ($request->hasFile('image')) {
        if ($product->image) {
            Storage::delete('public/' . $product->image);
        }
        $imagePath = $request->file('image')->store('products', 'public');
        $product->image = $imagePath;
    }

    $product->save();

    return redirect()->route('products.index', $product->product_id)->with('updated', 'Product updated successfully!');
}

public function updateQuantity(Request $request, $product_id)
{
    $product = Product::findOrFail($product_id);

    if ($request->has('quantity_change')) {
        if ($request->input('quantity_change') === 'increase') {
            $product->available_quantity++;
        } elseif ($request->input('quantity_change') === 'decrease' && $product->available_quantity > 0) {
            $product->available_quantity = max(0, $product->available_quantity - 1); // Prevent negative
        }
    }

    $product->save();

    return redirect()->back()->with('updated', 'Product quantity updated.');
}


    //DELETE
    public function destroy($product_id)
{
    $product = Product::findOrFail($product_id);

    if ($product->image) {
        $deletedImage = Storage::delete('public/' . $product->image);
    } else {
        $deletedImage = true;
    }

    if (!$deletedImage) {
        return back()->withErrors(['error' => 'There was an error removing the product image.']);
    }

    $deletedProduct = $product->delete();

    if ($deletedProduct) {
        return redirect()->route('products.index')->with('updated', 'Product removed successfully.');
    } else {
        return back()->withErrors(['error' => 'There was an error removing the product.']);
    }
}



}
