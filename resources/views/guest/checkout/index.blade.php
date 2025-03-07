@extends('layouts.app')
@section('content')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="shop-checkout container">
            <h2 class="page-title">Shipping and Checkout</h2>
            <x-checkout.steps />
            <form name="checkout-form" action="{{ route('checkout.store') }}" method="post">
                @csrf
                <div class="checkout-form">
                    <div class="billing-info__wrapper">
                        <div class="row">
                            <div class="col-6">
                                <h4>SHIPPING DETAILS</h4>
                            </div>
                            <div class="col-6">
                            </div>
                        </div>

                       @if($address)
                           <x-checkout.address :address="$address"/>
                       @else
                           <x-checkout.address-form />
                        @endif
                    </div>
                    <div class="checkout__totals-wrapper">
                        <div class="sticky-content">
                            <div class="checkout__totals">
                                <h3>Your Order</h3>
                                <table class="checkout-cart-items">
                                    <thead>
                                    <tr>
                                        <th>PRODUCT</th>
                                        <th align="right">SUBTOTAL</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach(Cart::instance('cart') as $item)
                                    <tr>
                                        <td>
                                            {{$item->name}} x {{$item->qty}}
                                        </td>
                                        <td align="right">
                                            ${{$item->subtotal()}}
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>

                                </table>

                                @if(Session::has('discounts'))
                                    <div class="order-summary">
                                        <div class="order-summary__header">
                                            <svg class="summary-icon" viewBox="0 0 24 24" fill="none">
                                                <path d="M3 6.5L12 2L21 6.5M3 6.5V17.5L12 22M3 6.5L12 11M12 22L21 17.5V6.5M12 22V11M21 6.5L12 11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                            <h3 class="summary-title">Order Summary</h3>
                                        </div>
                                        <div class="order-summary__content">
                                            <div class="summary-row">
                                                <span class="summary-label">Subtotal</span>
                                                <span class="summary-value">${{Cart::instance('cart')->subtotal()}}</span>
                                            </div>

                                            @if(Session::has('coupon') && Session::has('discounts'))
                                                <div class="summary-row discount-row">
                                                    <span class="summary-label">
                                                        <span class="discount-badge">
                                                            <svg class="discount-icon" viewBox="0 0 24 24" fill="none">
                                                                <path d="M9.5 14.5L14.5 9.5M9.5 9.5H9.51M14.5 14.5H14.51M19 21L18 20M19 21L21 21M19 21L19 19M5 21L6 20M5 21L3 21M5 21L5 19M19 3L18 4M19 3L21 3M19 3L19 5M5 3L6 4M5 3L3 3M5 3L5 5M12 7C12 7.93464 11.1841 8.71826 10.2468 8.92673C10.0832 8.96555 10 9.11681 10 9.28425V11.7157C10 11.8832 10.0832 12.0344 10.2468 12.0733C11.1841 12.2817 12 13.0654 12 14C12 15.1046 11.1046 16 10 16C8.89543 16 8 15.1046 8 14M9.5 9.5C9.5 9.77614 9.27614 10 9 10C8.72386 10 8.5 9.77614 8.5 9.5C8.5 9.22386 8.72386 9 9 9C9.27614 9 9.5 9.22386 9.5 9.5ZM14.5 14.5C14.5 14.7761 14.2761 15 14 15C13.7239 15 13.5 14.7761 13.5 14.5C13.5 14.2239 13.7239 14 14 14C14.2761 14 14.5 14.2239 14.5 14.5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                            </svg>
                                                            Discount
                                                        </span>
                                                        {{Session::get('coupon')['code']}}
                                                    </span>
                                                    <span class="summary-value discount-value">-${{Session::get('discounts')['discount']}}</span>
                                                </div>
                                                <div class="summary-row subtotal-after">
                                                    <span class="summary-label">Subtotal After Discount</span>
                                                    <span class="summary-value">${{Session::get('discounts')['subtotal']}}</span>
                                                </div>
                                            @endif

                                            <div class="summary-row">
                                                <span class="summary-label">
                                                    <svg class="shipping-icon" viewBox="0 0 24 24" fill="none">
                                                        <path d="M8 19C9.10457 19 10 18.1046 10 17C10 15.8954 9.10457 15 8 15C6.89543 15 6 15.8954 6 17C6 18.1046 6.89543 19 8 19Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                        <path d="M16 19C17.1046 19 18 18.1046 18 17C18 15.8954 17.1046 15 16 15C14.8954 15 14 15.8954 14 17C14 18.1046 14.8954 19 16 19Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                        <path d="M10.05 17H14V6.5C14 5.67157 13.3284 5 12.5 5H2.5M16.01 17H19.54C20.0789 17 20.5572 16.6246 20.6553 16.0953L21.4903 11.963C21.5079 11.8895 21.5079 11.8139 21.4903 11.7404M14 9H18.01L19 11.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>
                                                    Shipping
                                                </span>
                                                <span class="summary-value">
                                                    <label class="shipping-option">
                                                        <input type="radio" name="shipping_option" checked class="shipping-radio">
                                                        <span>Free shipping</span>
                                                    </label>
                                                </span>
                                            </div>

                                            <div class="summary-row">
                                                <span class="summary-label">VAT</span>
                                                <span class="summary-value">${{Session::get('discounts')['tax'] ?? Cart::instance('cart')->tax()}}</span>
                                            </div>

                                            <div class="summary-divider"></div>

                                            <div class="summary-row total-row">
                                                <span class="summary-label">Total</span>
                                                <span class="summary-value total-value">${{Session::get('discounts')['total'] ?? Cart::instance('cart')->total()}}</span>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="order-summary">
                                        <div class="order-summary__header">
                                            <svg class="summary-icon" viewBox="0 0 24 24" fill="none">
                                                <path d="M3 6.5L12 2L21 6.5M3 6.5V17.5L12 22M3 6.5L12 11M12 22L21 17.5V6.5M12 22V11M21 6.5L12 11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                            <h3 class="summary-title">Order Summary</h3>
                                        </div>
                                        <div class="order-summary__content">
                                            <div class="summary-row">
                                                <span class="summary-label">Subtotal</span>
                                                <span class="summary-value">${{Cart::instance('cart')->subtotal()}}</span>
                                            </div>

                                            <div class="summary-row">
                                                <span class="summary-label">
                                                    <svg class="shipping-icon" viewBox="0 0 24 24" fill="none">
                                                        <path d="M8 19C9.10457 19 10 18.1046 10 17C10 15.8954 9.10457 15 8 15C6.89543 15 6 15.8954 6 17C6 18.1046 6.89543 19 8 19Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                        <path d="M16 19C17.1046 19 18 18.1046 18 17C18 15.8954 17.1046 15 16 15C14.8954 15 14 15.8954 14 17C14 18.1046 14.8954 19 16 19Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                        <path d="M10.05 17H14V6.5C14 5.67157 13.3284 5 12.5 5H2.5M16.01 17H19.54C20.0789 17 20.5572 16.6246 20.6553 16.0953L21.4903 11.963C21.5079 11.8895 21.5079 11.8139 21.4903 11.7404M14 9H18.01L19 11.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>
                                                    Shipping
                                                </span>
                                                <span class="summary-value">Free shipping</span>
                                            </div>

                                            <div class="summary-row">
                                                <span class="summary-label">VAT</span>
                                                <span class="summary-value">${{Cart::instance('cart')->tax()}}</span>
                                            </div>

                                            <div class="summary-divider"></div>

                                            <div class="summary-row total-row">
                                                <span class="summary-label">Total</span>
                                                <span class="summary-value total-value">${{Cart::instance('cart')->total()}}</span>
                                            </div>
                                        </div>
                                    </div>
                                <table class="checkout-totals">
                                    <tbody>
                                    <tr>
                                        <th>SUBTOTAL</th>
                                        <td align="right">${{Cart::instance('cart')->subtotal()}}</td>
                                    </tr>
                                    <tr>
                                        <th>SHIPPING</th>
                                        <td align="right">Free shipping</td>
                                    </tr>
                                    <tr>
                                        <th>VAT</th>
                                        <td align="right">${{Cart::instance('cart')->tax()}}</td>
                                    </tr>
                                    <tr>
                                        <th>TOTAL</th>
                                        <td align="right">${{Cart::instance('cart')->total()}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                                @endif
                            </div>
                            <div class="checkout__payment-methods">
                                <div class="form-check">
                                    <input class="form-check-input form-check-input_fill" type="radio" name="mode" value="card"
                                           id="mode1">
                                    <label class="form-check-label" for="mode1">
                                        Debt or Credit Card
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input form-check-input_fill" type="radio" name="mode" value="paypal"
                                           id="mode2">
                                    <label class="form-check-label" for="mode2">
                                        Paypal
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input form-check-input_fill" type="radio" name="mode" value="cash"
                                           id="mode3">
                                    <label class="form-check-label" for="mode3">
                                        Cash on delivery
                                    </label>
                                </div>
                                <div class="policy-text">
                                    Your personal data will be used to process your order, support your experience throughout this
                                    website, and for other purposes described in our <a href="terms.html" target="_blank">privacy
                                        policy</a>.
                                </div>
                            </div>
                            <button class="btn btn-primary btn-checkout">PLACE ORDER</button>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </main>
@endsection
