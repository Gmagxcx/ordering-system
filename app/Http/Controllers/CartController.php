<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cookie;


class CartController extends Controller
{
    public function index()
    {
        $cart = json_decode(Cookie::get('cart', '[]'), true); 
        return view('cart', compact('cart'));
    }

    public function add(Request $request)
    {
        $cart = json_decode(Cookie::get('cart', '[]'), true); 

        $productId = $request->input('product_id');
        $product = Product::findOrFail($productId);

        // Check if the product is in stock
        if ($product->available_quantity <= 0) {
            return redirect()->back()->withErrors(['error' => 'Product is out of stock!']);
        }

        // Reduce stock by 1 when adding to cart (adjust as needed)
        $product->available_quantity -= 1;
        $product->save();

        // Check if product already in the cart
        if (isset($cart[$productId])) {
            // If it exists, increment the quantity
            $cart[$productId]['quantity']++;
        } else {
            // Add the product to the cart with quantity 1
            $cart[$productId] = [
                'product_name' => $product->product_name,
                'price' => $product->price,
                'quantity' => 1,
                'image' => $product->image,
            ];
        }

        // Store updated cart in the cookie (expires in 30 days)
        Cookie::queue('cart', json_encode($cart), 60 * 24 * 30);

        return redirect()->back()->with('success', 'Product added to cart!');
    }

    public function update(Request $request)
    {
        $cart = json_decode(Cookie::get('cart', '[]'), true);

        foreach ($request->input('cart') as $productId => $data) {
            if (isset($cart[$productId])) {
                $cart[$productId]['quantity'] = $data['quantity'];
            }
        }

        Cookie::queue('cart', json_encode($cart), 60 * 24 * 30);

        return redirect()->route('cart.index')->with('success', 'Cart updated!');
    }


    public function remove($productId)
    {
        // Retrieve the cart from the cookie
        $cart = json_decode(Cookie::get('cart', '[]'), true);

        // Check if the product exists in the cart
        if (isset($cart[$productId])) {
            unset($cart[$productId]); // Remove the product
        }

        // Update the cart in the cookie
        Cookie::queue('cart', json_encode($cart), 60 * 24 * 30); // Store updated cart for 30 days

        return redirect()->route('cart.index')->with('success', 'Product removed from cart.');
    }


    
}
