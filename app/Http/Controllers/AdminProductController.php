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

            return redirect()->route('admin.products.create')->with('success', 'Product added successfully!');
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

        $product = Product::findOrFail($product_id); // Use product_id

        $product->product_name = $request->input('product_name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->available_quantity = $request->input('available_quantity');
        $product->category = $request->input('category');

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::delete('public/' . $product->image);
            }

            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        }

        $product->save();

        return redirect()->route('admin.products.edit', $product->product_id)->with('success', 'Product updated successfully!');
    }

    //DELETE
    public function destroy($product_id)
    {
        try {
            $product = Product::findOrFail($product_id);

            // Delete associated image
            if ($product->image) {
                Storage::delete('public/' . $product->image);
            }

            $product->delete();

            return redirect()->route('admin.products.index')->with('success', 'Product removed successfully.');
        } catch (\Exception $e) {
            Log::error('Error removing product', ['exception' => $e->getMessage()]);
            return back()->withErrors(['error' => 'There was an error removing the product.']);
        }
    }

}
