<?php

namespace App\Http\Controllers\Admin\V1;

use App\Http\Controllers\Controller;
use App\Http\Services\OrderService;
use Illuminate\Http\Request;
use App\Models\Admin\V1\{Order,OrderItem,Transaction};
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;
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
    public function generateInvoice($orderId): Response
    {
        $order = Order::findOrFail($orderId);
        $pdf = PDF::loadView('admin.order.invoice', compact('order'));
        return $pdf->stream('invoice.pdf');
    }

    public function show(Order $order): View
    {
        $orderItems = OrderItem::where('order_id',$order->id,)->orderBy('id')->paginate(5);
        $transaction = Transaction::where('order_id',$order->id,)->first();
        return view('admin.order.show', compact('order', 'orderItems', 'transaction'));
    }

    public function edit(Order $order)
    {
        $order->load(['orderItems' => function ($query) {
            $query->paginate(7);
        }, 'transactions']);

        return view('admin.order.edit', compact('order'));

    }

    public function update(Order $order, Request $request)
    {
        $success = $this->orderService->updateOrderStatus($order, $request->order_status);

        if ($success) {
            return redirect()->back()->withSuccess('Status changed successfully');
        }

        return redirect()->back()->withError('Failed to update order status');
    }

}
