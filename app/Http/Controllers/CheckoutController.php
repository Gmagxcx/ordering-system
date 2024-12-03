<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\Order;

class CheckoutController extends Controller
{
    public function checkout()
    {
        // Set the Stripe API key
        Stripe::setApiKey(env('STRIPE_SK'));

        // Fetch the user's cart order
        $order = Order::with('items.product')
            ->where('user_id', Auth::id())
            ->where('order_status', 'cart')
            ->first();

        // Check if the cart is empty
        if (!$order || $order->items->isEmpty()) {
            return redirect()->route('cart.index')->withErrors(['error' => 'Your cart is empty.']);
        }

        // Prepare line items for Stripe
        $lineItems = [];
        foreach ($order->items as $orderItem) {
            $product = $orderItem->product;

            // Ensure the product exists and has all required data
            if (!$product || !$product->product_name || !$product->price) {
                return redirect()->route('cart.index')->withErrors(['error' => 'Invalid product in cart.']);
            }

            $lineItems[] = [
                'price_data' => [
                    'currency' => 'php', // Change to your desired currency
                    'product_data' => [
                        'name' => $product->product_name, // Using 'product_name' from your model
                        'description' => $product->description, // Optional, but good for Stripe
                    ],
                    'unit_amount' => $product->price * 100, // Convert price to cents
                ],
                'quantity' => $orderItem->quantity,
            ];
        }

        // Create a Stripe Checkout Session
        $checkoutSession = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('checkout.success'),
            'cancel_url' => route('checkout.cancel'),
        ]);

        return redirect($checkoutSession->url);
    }

    public function success()
    {
        // Clear the user's cart
        $order = Order::where('user_id', Auth::id())
            ->where('order_status', 'cart')
            ->first();

        if ($order) {
            $order->order_status = 'processing';
            $order->save();
        }

        return redirect()->route('products.index')->with('success', 'Checkout completed successfully!');
    }

    public function cancel()
    {
        return redirect()->route('cart.index')->withErrors(['error' => 'Payment was canceled.']);
    }
}
