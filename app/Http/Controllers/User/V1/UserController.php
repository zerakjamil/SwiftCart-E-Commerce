<?php

namespace App\Http\Controllers\User\V1;

use App\Http\Controllers\Controller;
use App\Models\Admin\V1\Order;
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
            return view('user.orders', compact('orders'));
        }
}
