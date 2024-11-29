<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    private function getCartBadgeCount()
    {
        $userId = Auth::id();
        return OrderItem::whereHas('order', function ($query) use ($userId) {
            $query->where('user_id', $userId)->where('order_status', 'cart');
        })->sum('quantity');
    }

    public function index()
    {
        $order = Order::with('items.product')
            ->where('user_id', Auth::id())
            ->where('order_status', 'cart')
            ->first();

        $totalQuantity = $this->getCartBadgeCount();

        return view('cart', compact('order', 'totalQuantity'));
    }

    public function add(Request $request)
    {
        $userId = Auth::id();
        $productId = $request->input('product_id');
        $product = Product::findOrFail($productId);

        if ($product->available_quantity <= 0) {
            return redirect()->back()->withErrors(['error' => 'Product is out of stock!']);
        }

        $order = Order::firstOrCreate(
            ['user_id' => $userId, 'order_status' => 'cart'],
            ['order_date' => now(), 'total_price' => 0]
        );

        $orderItem = $order->items()->firstOrNew(['product_id' => $productId]);

        if ($orderItem->exists) {
            $orderItem->quantity += 1;
        } else {
            $orderItem->quantity = 1;
            $orderItem->item_price = $product->price;
            $orderItem->image = $product->image;
            $orderItem->order_id = $order->order_id;
        }

        $orderItem->save();

        $product->available_quantity -= 1;
        $product->save();

        $order->total_price = $order->items->sum(fn($item) => $item->item_price * $item->quantity);
        $order->save();

        $totalQuantity = $this->getCartBadgeCount();

        return redirect()->back()->with('success', 'Product added to cart!')->with('totalQuantity', $totalQuantity);
    }

    public function update(Request $request)
    {
        $order = Order::where('user_id', Auth::id())
            ->where('order_status', 'cart')
            ->first();

        if (!$order) {
            return redirect()->route('cart.index')->withErrors(['error' => 'No active cart found.']);
        }

        foreach ($request->input('cart') as $itemId => $data) {
            $orderItem = $order->items()->find($itemId);
            if ($orderItem) {
                $product = $orderItem->product;

                $stockChange = $orderItem->quantity - $data['quantity'];
                $product->available_quantity += $stockChange;
                $product->save();

                $orderItem->quantity = $data['quantity'];
                $orderItem->save();
            }
        }

        $order->total_price = $order->items->sum(fn($item) => $item->item_price * $item->quantity);
        $order->save();

        $totalQuantity = $this->getCartBadgeCount();

        return redirect()->route('cart.index')->with('success', 'Cart updated!')->with('totalQuantity', $totalQuantity);
    }

    public function remove($productId)
    {
        try {
            $orderItem = OrderItem::where('product_id', $productId)
                ->whereHas('order', function ($query) {
                    $query->where('order_status', 'cart');
                })
                ->firstOrFail();
    
            $order = $orderItem->order;
            $product = $orderItem->product;
    
            $product->available_quantity += $orderItem->quantity;
            $product->save();
    
            $orderItem->delete();
    
            $order->total_price = $order->items->sum(fn($item) => $item->item_price * $item->quantity);
            $order->save();
    
            if ($order->items->count() === 0) {
                $order->delete();
            }
    
            $totalQuantity = $this->getCartBadgeCount();
    
            return redirect()->route('cart.index')->with('success', 'Product removed from cart!')->with('totalQuantity', $totalQuantity);
        } catch (\Exception $e) {
            Log::error('Error removing product from cart', ['exception' => $e->getMessage()]);
            return redirect()->route('cart.index')->withErrors(['error' => 'Error removing product from cart.']);
        }
    }

    public function checkout()
    {
        $order = Order::where('user_id', Auth::id())
            ->where('order_status', 'cart')
            ->first();

        if (!$order || $order->items->isEmpty()) {
            return redirect()->route('cart.index')->withErrors(['error' => 'Your cart is empty.']);
        }

        $order->order_status = 'pending';
        $order->order_date = now();
        $order->save();

        foreach ($order->items as $orderItem) {
            $product = $orderItem->product;
            $product->available_quantity -= $orderItem->quantity;
            $product->save();
        }

        $totalQuantity = $this->getCartBadgeCount();

        return redirect()->route('cart.index')->with('success', 'Checkout successful!')->with('totalQuantity', $totalQuantity);
    }
}
