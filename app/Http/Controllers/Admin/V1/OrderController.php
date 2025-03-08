<?php

namespace App\Http\Controllers\Admin\V1;

use App\Http\Controllers\Controller;
use App\Http\Services\OrderService;
use App\Models\Admin\V1\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\View\View;

class OrderController extends Controller
{
    protected OrderService $orderService;
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }
    public function index(): View
    {
        $orders = Order::orderBy('created_at', 'DESC')->paginate(5);
        return view('admin.order.index',compact('orders'));
    }
    public function generateInvoice($orderId)
    {
        $order = Order::findOrFail($orderId);
        $pdf = PDF::loadView('admin.order.invoice', compact('order'));
        return $pdf->stream('invoice.pdf');
    }

    public function details(Order $order): View
    {
        return view('admin.order.details', compact('order'));
    }

}
