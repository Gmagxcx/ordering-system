<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;

class AdminOrderController extends Controller
{
    public function index(Request $request)
    {

        $search = $request->input('search');

        $ordersQuery = Order::with('user');
        
        if ($search) {
            $ordersQuery->where(function ($query) use ($search) {
                $query->where('order_status', 'like', "%$search%")
                    ->orWhere('total_price', 'like', "%$search%")
                    ->orWhere('order_date', 'like', "%$search%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('first_name', 'like', "%$search%")
                                  ->orWhere('last_name', 'like', "%$search%");
                    });
            });
        }
        $orders = $ordersQuery->paginate(10);

        $totalOrders = Order::count();
        $pendingCount = Order::where('order_status', 'Pending')->count();
        $processedCount = Order::where('order_status', 'Processing')->count();
        $completedCount = Order::where('order_status', 'Completed')->count();

        return view('admin_order_page', compact(
            'totalOrders',
            'pendingCount',
            'processedCount',
            'completedCount',
            'orders'
        ));
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
