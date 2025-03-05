@props(['item'])
<div class="shopping-cart__totals-wrapper">
    <div class="sticky-content">
        <div class="shopping-cart__totals">
            <h3>Cart Totals</h3>
                <table class="cart-totals">
                    <tbody>
                    <tr>
                        <th>Subtotal</th>
                        <td>${{Cart::instance('cart')->subtotal()}}</td>
                    </tr>
                    @if(Session::has('coupon') && Session::has('discounts'))
                        <tr>
                        <th>Discount {{Session::get('coupon')['code']}}</th>
                        <td>${{Session::get('discounts')['discount']}}</td>
                    </tr>
                    <tr>
                        <th>Subtotal After Discount</th>
                        <td>${{Session::get('discounts')['subtotal']}}</td>
                    </tr>
                    @endif
                    <tr>
                        <th>Shipping</th>
                        <td>
                            <div class="form-check">
                                <input class="form-check-input form-check-input_fill" type="checkbox" value=""
                                       id="free_shipping">
                                <label class="form-check-label" for="free_shipping">Free shipping</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input form-check-input_fill" type="checkbox" value="" id="flat_rate">
                                <label class="form-check-label" for="flat_rate">Flat rate: $49</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input form-check-input_fill" type="checkbox" value=""
                                       id="local_pickup">
                                <label class="form-check-label" for="local_pickup">Local pickup: $8</label>
                            </div>
                            <div>Shipping to AL.</div>
                            <div>
                                <a href="#" class="menu-link menu-link_us-s">CHANGE ADDRESS</a>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>VAT</th>
                        <td>${{Session::get('discounts')['tax'] ?? Cart::instance('cart')->tax()}}</td>
                    </tr>
                    <tr>
                        <th>Total</th>
                        <td>${{Session::get('discounts')['total'] ?? Cart::instance('cart')->total()}}</td>
                    </tr>
                    </tbody>
                </table>
        </div>
        <div class="mobile_fixed-btn_wrapper">
            <div class="button-wrapper container">
                <x-partials.button
                    tag="a"
                    route="checkout.index"
                    class="btn btn-primary btn-checkout"
                >
                    PROCEED TO CHECKOUT
                </x-partials.button>
            </div>
        </div>
    </div>
</div>
