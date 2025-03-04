<?php

namespace App\Http\Controllers;

use App\Http\Requests\V1\OrderRequests\StoreOrderRequest;
use App\Http\Services\CheckoutService;
use App\Models\Admin\V1\Address;
use App\Models\Admin\V1\Order;
use App\Models\Admin\V1\OrderItem;
use App\Models\Admin\V1\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Surfsidemedia\Shoppingcart\Facades\Cart;

class CheckoutController extends Controller
{
    protected CheckoutService $checkoutService;

    public function __construct(CheckoutService $checkoutService)
    {
        $this->middleware('auth');
        $this->checkoutService = $checkoutService;
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

        $address = $this->checkoutService->getOrCreateAddress($request->validated());

        $this->checkoutService->setCheckoutAmounts();

        $order = $this->checkoutService->createOrder($address);

        $this->checkoutService->createOrderItems($order->id);

        $this->checkoutService->processPayment($request->mode, $order->id);

        $this->checkoutService->clearCartAndSession();

        DB::commit();

        return redirect()->route('checkout.orderConfirmation',compact('order'))
            ->with('success', 'Your order has been placed successfully!');
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Order creation failed: ' . $e->getMessage());

        return redirect()->back()
            ->with('error', 'There was a problem processing your order. Please try again.');
    }
}

    public function orderConfirmation()
    {
        return view('guest.checkout.order-confirmation');
}
}
