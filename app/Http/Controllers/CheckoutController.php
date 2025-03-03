<?php

namespace App\Http\Controllers;

use App\Http\Services\CheckoutService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
}
