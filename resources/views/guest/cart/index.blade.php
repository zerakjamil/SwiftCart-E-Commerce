@extends('layouts.app')
@section('content')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="shop-checkout container">
            <h2 class="page-title">Cart</h2>
            <div class="checkout-steps">
                <a href="javascript:void(0)" class="checkout-steps__item active">
                    <span class="checkout-steps__item-number">01</span>
                    <span class="checkout-steps__item-title">
            <span>Shopping Bag</span>
            <em>Manage Your Items List</em>
          </span>
                </a>
                <a href="javascript:void(0)" class="checkout-steps__item">
                    <span class="checkout-steps__item-number">02</span>
                    <span class="checkout-steps__item-title">
            <span>Shipping and Checkout</span>
            <em>Checkout Your Items List</em>
          </span>
                </a>
                <a href="javascript:void(0)" class="checkout-steps__item">
                    <span class="checkout-steps__item-number">03</span>
                    <span class="checkout-steps__item-title">
            <span>Confirmation</span>
            <em>Review And Submit Your Order</em>
          </span>
                </a>
            </div>
            <div class="shopping-cart">
                @if($items->count() > 0)
                <div class="cart-table__wrapper">
                    <table class="cart-table">
                        <thead>
                        <tr>
                            <th>Product</th>
                            <th></th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($items as $item)
                        <x-cart.cart-item :item="$item" />
                        @endforeach
                        </tbody>
                    </table>
                    <div class="cart-table-footer">
                        <form action="#" class="position-relative bg-body">
                            <input class="form-control" type="text" name="coupon_code" placeholder="Coupon Code">
                            <x-partials.button
                                tag="input"
                                type="submit"
                                value="APPLY COUPON"
                                class="btn-link fw-medium position-absolute top-0 end-0 h-100 px-4"
                            />
                        </form>
                        <x-partials.button
                            class="btn btn-light"
                        >
                            UPDATE CART
                        </x-partials.button>
                    </div>
                </div>
                <x-cart.cart-total />
                @else
                    <div class="empty-cart-container text-center py-5">
                        <div class="empty-cart-icon mb-4">
                            <svg width="120" height="120" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M3 3H5L5.4 5M7 13H17L21 5H5.4M7 13L5.4 5M7 13L4.70711 15.2929C4.07714 15.9229 4.52331 17 5.41421 17H17M17 17C15.8954 17 15 17.8954 15 19C15 20.1046 15.8954 21 17 21C18.1046 21 19 20.1046 19 19C19 17.8954 18.1046 17 17 17ZM9 19C9 20.1046 8.10457 21 7 21C5.89543 21 5 20.1046 5 19C5 17.8954 5.89543 17 7 17C8.10457 17 9 17.8954 9 19Z"
                                    stroke="#4A90E2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <h2 class="mb-3">Your Cart is Empty</h2>
                        <p class="text-muted mb-4">Looks like you haven't added any items to your cart yet.</p>
                        <
                        <x-partials.button
                            tag="a"
                            :route="'shop.index'"
                            class="btn btn-primary btn-lg"
                            icon="fa fa-shopping-bag"
                        >
                            Start Shopping
                        </x-partials.button>
                    </div>
                    <div class="suggested-products mt-5">
                        <h3 class="text-center mb-4">You Might Like</h3>
                        <div class="row">
                            @foreach($suggested_products as $product)
                                <div class="col-6 col-md-4 col-lg-3">
                                    <x-product-card :product="$product"/>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </main>
@endsection
