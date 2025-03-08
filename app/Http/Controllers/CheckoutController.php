<?php

namespace App\Http\Controllers;

use App\Http\Requests\V1\OrderRequests\StoreOrderRequest;
use App\Models\Admin\V1\Order;
use App\Http\Services\{CheckoutService,OrderService};
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\{DB,Log};
use Illuminate\View\View;
use Surfsidemedia\Shoppingcart\Facades\Cart;

class CheckoutController extends Controller
{
    protected $checkoutService;
    protected $orderService;

    public function __construct(CheckoutService $checkoutService, OrderService $orderService)
    {
        $this->middleware('auth');
        $this->checkoutService = $checkoutService;
        $this->orderService = $orderService;
    }

    public function index(): View|RedirectResponse
    {
        $cartValidation = $this->checkoutService->validateCart();
        if (!$cartValidation['valid']) {
            return redirect()->route('cart.index')
                ->with('error', $cartValidation['message']);
        }

        $addressValidation = $this->checkoutService->validateAddress();
        if (!$addressValidation['valid']) {
            return redirect()->route('user.index', ['tab' => 'address'])
                ->with('error', $addressValidation['message']);
        }

        $address = $addressValidation['address'];
        $cartContent = Cart::instance('cart')->content();
        $cartTotal = Cart::instance('cart')->total();

        return view('guest.checkout.index', compact('address', 'cartContent', 'cartTotal'));
    }

public function store(StoreOrderRequest $request): RedirectResponse
{
    try {
        DB::beginTransaction();

        $address = $this->checkoutService->getAddress($request);

        $this->checkoutService->setCheckoutAmounts();

        $order = $this->orderService->createOrder($address);

        $this->orderService->createOrderItems($order->id);

        $this->checkoutService->processPayment($request->mode, $order->id);

        $this->checkoutService->clearCartAndSession();

        DB::commit();

        return redirect()->route('checkout.orderConfirmation', ['order' => $order->id])
            ->with('success', 'Your order has been placed successfully!');
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Order creation failed: ' . $e->getMessage());

        return redirect()->back()
            ->with('error', 'There was a problem processing your order. Please try again.');
    }
}

    public function orderConfirmation(Order $order): View
    {
        return view('guest.checkout.order-confirmation',compact('order'));
}
}
