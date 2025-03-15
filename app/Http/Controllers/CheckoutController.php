<?php

namespace App\Http\Controllers;

use App\Http\Requests\V1\OrderRequests\StoreOrderRequest;
use App\Models\Admin\V1\Order;
use App\Http\Services\{CheckoutService,OrderService};
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\{DB, Log, Session};
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

        Log::info('Address validation result:', $addressValidation);

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
            $address = $this->checkoutService->getAddress($request);

            if (!$address) {
                return redirect()->back()->with('error', 'No shipping address found. Please add an address.');
            }

            $order = $this->orderService->createOrder($address, $request->payment_mode);

            if (!$order) {
                return redirect()->back()->with('error', 'Failed to create order. Please try again.');
            }

            $this->checkoutService->processPayment($request->payment_mode, $order->id);

            Cart::instance('cart')->destroy();

            if (Session::has('coupon')) {
                Session::forget('coupon');
            }
            if (Session::has('discounts')) {
                Session::forget('discounts');
            }

            return redirect()->route('checkout.confirmation', ['order' => $order->id])
                ->with('success', 'Order placed successfully!');
        } catch (\Exception $e) {
            Log::error('Checkout error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function orderConfirmation(Order $order): View
    {
        return view('guest.checkout.order-confirmation',compact('order'));
}
}
