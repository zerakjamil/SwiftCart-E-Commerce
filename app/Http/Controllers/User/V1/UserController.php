<?php

namespace App\Http\Controllers\User\V1;

use App\Http\Controllers\Controller;
use App\Models\Admin\V1\Order;
use App\Models\Admin\V1\OrderItem;
use App\Models\Admin\V1\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index()
    {
        return view('user.index');
    }

        public function orders(): View
        {
            $orders = Order::whereUserId(Auth::id())->latest()->paginate(7);
            return view('user.account.orders.index', compact('orders'));
        }

    public function orderDetail(Order $order): View
    {
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $order->load(['orderItems' => function ($query) {
            $query->paginate(7);
        }, 'transactions']);

        return view('user.account.orders.details', compact('order'));
    }
}
