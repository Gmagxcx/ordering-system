<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;

class AdminOrderItemController extends Controller
{
    public function index()
    {
        $orderItems = OrderItem::with(['order', 'product'])->get();

        return view('admin_orderItems_page', compact('orderItems'));
    }
}
