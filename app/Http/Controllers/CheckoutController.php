<?php

namespace App\Http\Controllers;

use App\Http\Services\CheckoutService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    protected $checkoutService;

    public function __construct(CheckoutService $checkoutService)
    {
        $this->checkoutService = $checkoutService;
    }

    public function index(): View|RedirectResponse
    {
        $cartValidation = $this->checkoutService->validateCart();
        if (!$cartValidation['valid']) {
            return redirect()->route('cart.index')->withError($cartValidation['message']);
        }

        $addressValidation = $this->checkoutService->validateAddress();
        if (!$addressValidation['valid']) {
//            return redirect()->route('address.create')->withError($addressValidation['message']);
        }

        $address = $addressValidation['address'];
        return view('guest.checkout.index', compact('address'));
    }
}
