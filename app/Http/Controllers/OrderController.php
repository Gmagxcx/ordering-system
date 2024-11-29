<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $cart = json_decode($request->cookie('cart', '[]'), true);
        if (empty($cart)) {
            return redirect()->route('cart.index')->withErrors(['error' => 'Your cart is empty.']);
        }

        $totalPrice = collect($cart)->sum(fn($item) => $item['quantity'] * $item['price']);

        // Create the order
        $order = Order::create([
            'user_id' => Auth::id(),
            'order_date' => now(),
            'total_price' => $totalPrice,
            'order_status' => 'pending',
        ]);

        // Add items to the order
        foreach ($cart as $productId => $item) {
            OrderItem::create([
                'order_id' => $order->order_id,
                'product_id' => $productId,
                'quantity' => $item['quantity'],
                'item_price' => $item['price'], // Corrected field name
            ]);
        }

        // Clear the cart (session or cookie-based)
        Cookie::queue(Cookie::forget('cart'));

        return redirect()->route('cart.index')->with('success', 'Your order has been placed!');
    }

    public function cancel($orderId)
{
    // Find the order by ID
    $order = Order::findOrFail($orderId);

    // Check if the order has items
    if ($order->orderItems && $order->orderItems->isNotEmpty()) {
        // Loop through order items and return the quantity to the inventory
        foreach ($order->orderItems as $item) {
            $product = $item->product; // Assuming you have a 'product' relationship on orderItem
            if ($product) {
                $product->quantity += $item->quantity; // Increase the product quantity
                $product->save(); // Save the updated product
            }
        }
    }

    // Delete the order
    $order->delete();

    // Return a success message
    return redirect()->route('orders.index')->with('success', 'Order has been canceled and inventory updated.');
}


}
