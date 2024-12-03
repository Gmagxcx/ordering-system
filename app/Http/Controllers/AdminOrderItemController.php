<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use Illuminate\Http\Request;

class AdminOrderItemController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        if ($search) {
            // Search only order_id and item_price
            $orderItems = OrderItem::with(['order', 'product'])
                ->where('order_id', 'like', "%$search%") 
                ->orWhere('item_price', 'like', "%$search%") 
                ->orWhereHas('product', function($query) use ($search) {
                    $query->where('product_name', 'like', "%$search%"); // Search for product_name in related Product model
                })
                ->paginate(10); 
        } else {
            
            $orderItems = OrderItem::with(['order', 'product'])->paginate(10);
        }


        $totalOrderItems = OrderItem::count();

        return view('admin_orderItems_page', compact('orderItems', 'totalOrderItems'));
    }
}
