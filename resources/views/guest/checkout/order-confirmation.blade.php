@extends('layouts.app')
@section('content')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="shop-checkout container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="page-title">Order Received</h2>
                <button onclick="window.print()" class="btn btn-sm btn-outline-dark print-button">
                    <svg width="16" height="16" fill="currentColor" class="me-2" viewBox="0 0 16 16">
                        <path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z"/>
                        <path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                    </svg>
                    Print Order
                </button>
            </div>
            <div class="checkout-steps">
                <a href="{{ route('cart.index') }}" class="checkout-steps__item active">
                    <span class="checkout-steps__item-number">01</span>
                    <span class="checkout-steps__item-title">
                        <span>Shopping Bag</span>
                        <em>Manage Your Items List</em>
                    </span>
                </a>
                <a href="{{ route('checkout.index') }}" class="checkout-steps__item active">
                    <span class="checkout-steps__item-number">02</span>
                    <span class="checkout-steps__item-title">
                        <span>Shipping and Checkout</span>
                        <em>Checkout Your Items List</em>
                    </span>
                </a>
                <a href="javascript:void(0)" class="checkout-steps__item active">
                    <span class="checkout-steps__item-number">03</span>
                    <span class="checkout-steps__item-title">
                        <span>Confirmation</span>
                        <em>Review And Submit Your Order</em>
                    </span>
                </a>
            </div>
            <div class="order-complete">
                <div class="order-complete__message">
                    <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="40" cy="40" r="40" fill="#B9A16B" />
                        <path
                            d="M52.9743 35.7612C52.9743 35.3426 52.8069 34.9241 52.5056 34.6228L50.2288 32.346C49.9275 32.0446 49.5089 31.8772 49.0904 31.8772C48.6719 31.8772 48.2533 32.0446 47.952 32.346L36.9699 43.3449L32.048 38.4062C31.7467 38.1049 31.3281 37.9375 30.9096 37.9375C30.4911 37.9375 30.0725 38.1049 29.7712 38.4062L27.4944 40.683C27.1931 40.9844 27.0257 41.4029 27.0257 41.8214C27.0257 42.24 27.1931 42.6585 27.4944 42.9598L33.5547 49.0201L35.8315 51.2969C36.1328 51.5982 36.5513 51.7656 36.9699 51.7656C37.3884 51.7656 37.8069 51.5982 38.1083 51.2969L40.385 49.0201L52.5056 36.8996C52.8069 36.5982 52.9743 36.1797 52.9743 35.7612Z"
                            fill="white" />
                    </svg>
                    <h3>Your order is completed!</h3>
                    <p>Thank you. Your order has been received.</p>
                </div>
                <div class="order-info">
                    <div class="order-info__item">
                        <label>Order Number</label>
                        <span class="order-value">#{{$order->id}}</span>
                    </div>
                    <div class="order-info__item">
                        <label>Date</label>
                        <span class="order-value">{{$order->created_at->format('F j, Y - h:i A')}}</span>
                    </div>
                    <div class="order-info__item">
                        <label>Total</label>
                        <span class="order-value">${{number_format($order->total, 2)}}</span>
                    </div>
                    <div class="order-info__item">
                        <label>Payment Method</label>
                        <span class="order-value">{{ $order->getPaymentMethodLabel() }}</span>
                    </div>
                </div>
                <div class="checkout__totals-wrapper">
                    <div class="checkout__totals">
                        <h3>Order Details</h3>
                        <table class="checkout-cart-items">
                            <thead>
                            <tr>
                                <th>PRODUCT</th>
                                <th>SUBTOTAL</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($order->orderItems as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="product-name">{{$item->product->name}}</span>
                                            <span class="product-quantity ms-2">× {{$item->quantity}}</span>
                                        </div>
                                    </td>
                                    <td>
                                        ${{number_format($item->price, 2)}}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <table class="checkout-totals">
                            <tbody>
                            <tr>
                                <th>SUBTOTAL</th>
                                <td>${{number_format($order->subtotal, 2)}}</td>
                            </tr>
                            <tr>
                                <th>DISCOUNT</th>
                                <td>${{number_format($order->discount, 2)}}</td>
                            </tr>
                            <tr>
                                <th>SHIPPING</th>
                                <td>Free shipping</td>
                            </tr>
                            <tr>
                                <th>VAT</th>
                                <td>${{number_format($order->tax, 2)}}</td>
                            </tr>
                            <tr class="total-row">
                                <th>TOTAL</th>
                                <td>${{number_format($order->total, 2)}}</td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="text-center mt-4">
                            <a href="{{ route('shop.index') }}" class="btn btn-primary">Continue Shopping</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

@push('styles')
<style>
    .order-complete__message {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 30px;
        margin-bottom: 30px;
        text-align: center;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .order-info {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        margin-bottom: 40px;
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 20px;
    }

    .order-info__item {
        padding: 15px;
        border-radius: 6px;
        background-color: white;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        transition: transform 0.2s;
    }

    .order-info__item:hover {
        transform: translateY(-3px);
    }

    .order-info__item label {
        display: block;
        color: #6c757d;
        font-size: 14px;
        margin-bottom: 5px;
    }

    .order-value {
        font-weight: 600;
        font-size: 16px;
        color: #212529;
    }

    .checkout-cart-items, .checkout-totals {
        border-collapse: separate;
        border-spacing: 0;
        width: 100%;
        margin-bottom: 20px;
    }

    .checkout-cart-items th, .checkout-totals th {
        text-align: left;
        padding: 12px 15px;
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
    }

    .checkout-cart-items td, .checkout-totals td {
        padding: 12px 15px;
        border-bottom: 1px solid #dee2e6;
    }

    .checkout-cart-items tr:last-child td, .checkout-totals tr:last-child td {
        border-bottom: none;
    }

    .product-name {
        font-weight: 500;
    }

    .product-quantity {
        color: #6c757d;
    }

    .total-row {
        font-size: 18px;
        font-weight: 600;
        background-color: #f8f9fa;
    }

    .total-row th, .total-row td {
        padding-top: 15px;
        padding-bottom: 15px;
    }

    .print-button {
        display: flex;
        align-items: center;
    }

    @media print {
        .header, .footer, .header-mobile, .checkout-steps, .print-button {
            display: none !important;
        }

        .order-complete__message {
            box-shadow: none;
        }

        .order-info__item {
            box-shadow: none;
            border: 1px solid #dee2e6;
        }
    }
</style>
@endpush
@endsection
