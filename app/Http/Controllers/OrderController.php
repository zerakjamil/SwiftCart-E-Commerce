<?php

namespace App\Http\Controllers;

use App\Models\Admin\V1\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        $orders = Order::orderBy('created_at', 'DESC')->paginate(5);
        return view('admin.order.index',compact('orders'));
    }
}
