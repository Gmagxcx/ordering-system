<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        // Get the cart from the session or database
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->back()->with('error', 'Your cart is empty!');
        }

        $order = Order::create([
            'user_id' => Auth::id(),
            'order_date' => now(),
            'total_price' => collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']),
            'order_status' => 'Pending',
        ]);

        foreach ($cart as $productId => $item) {
            OrderItem::create([
                'order_id' => $order->order_id,
                'product_id' => $productId,
                'quantity' => $item['quantity'],
                'item_price' => $item['price'],
            ]);
        }

        // Clear the cart
        session()->forget('cart');

        // Redirect to the orders page
        return redirect()->route('orders.index')->with('success', 'Order placed successfully!');
    }
}
