<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;

class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->get(); // Get all orders with user detail
        return view('admin.orders.index', compact('orders'));
    }

    public function edit($id)
    {
        $order = Order::with('orderItems.product')->findOrFail($id);
        return view('admin.orders.edit', compact('order'));
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update([
            'order_status' => $request->input('order_status'),
        ]);

        return redirect()->route('admin.orders.index')->with('success', 'Order updated successfully.');
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->route('admin.orders.index')->with('success', 'Order deleted successfully.');
    }
}
