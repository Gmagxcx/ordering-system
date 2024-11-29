<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;

class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->get(); // Get all orders with user details
        return view('admin_order_page', compact('orders')); // Make sure to use the correct view name
    }

    public function edit($id)
    {
        $order = Order::with('items.product')->findOrFail($id); 
        return view('admin_order_page', compact('order')); 
    }


    public function update(Request $request, $id)
    {
        // Validate the order status input
        $validated = $request->validate([
            'order_status' => 'required|in:pending,processing,completed',
        ]);

        $order = Order::findOrFail($id);
        $order->update([
            'order_status' => $validated['order_status'],
        ]);

        return redirect()->route('orders.index')->with('success', 'Order status updated successfully.');
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Order deleted successfully.');
    }
}
