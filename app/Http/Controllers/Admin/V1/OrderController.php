<?php

namespace App\Http\Controllers\Admin\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CancelOrderRequest;
use App\Http\Services\OrderService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
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

    /**
     * Cancel an order
     *
     * @param CancelOrderRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancelOrder(CancelOrderRequest $request): RedirectResponse
    {
        $order = Order::findOrFail($request->order_id);

        if ($order->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'You are not authorized to cancel this order.');
        }

        if ($order->status === 'canceled' || $order->status === 'delivered') {
            return redirect()->back()->with('error', 'This order cannot be canceled.');
        }

        $success = $this->orderService->cancelOrder($order);

        if ($success) {
            return redirect()->route('user.orders.details', ['order' => $order->id])
                ->with('success', 'Order has been successfully canceled.');
        }

        return redirect()->back()->with('error', 'Failed to cancel the order. Please try again.');
    }

}
