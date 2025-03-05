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
                        <svg class="order-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19 3H5C3.89543 3 3 3.89543 3 5V19C3 20.1046 3.89543 21 5 21H19C20.1046 21 21 20.1046 21 19V5C21 3.89543 20.1046 3 19 3Z" stroke="#B9A16B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M3 9H21" stroke="#B9A16B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M9 21V9" stroke="#B9A16B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <label>Order Number</label>
                        <span class="order-value">#{{$order->id}}</span>
                    </div>
                    <div class="order-info__item">
                        <svg class="order-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19 4H5C3.89543 4 3 4.89543 3 6V20C3 21.1046 3.89543 22 5 22H19C20.1046 22 21 21.1046 21 20V6C21 4.89543 20.1046 4 19 4Z" stroke="#B9A16B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M16 2V6" stroke="#B9A16B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M8 2V6" stroke="#B9A16B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M3 10H21" stroke="#B9A16B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <label>Date</label>
                        <span class="order-value">{{$order->created_at->format('F j, Y - h:i A')}}</span>
                    </div>
                    <div class="order-info__item">
                        <svg class="order-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 1V23" stroke="#B9A16B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M17 5H9.5C8.57174 5 7.6815 5.36875 7.02513 6.02513C6.36875 6.6815 6 7.57174 6 8.5C6 9.42826 6.36875 10.3185 7.02513 10.9749C7.6815 11.6313 8.57174 12 9.5 12H14.5C15.4283 12 16.3185 12.3687 16.9749 13.0251C17.6313 13.6815 18 14.5717 18 15.5C18 16.4283 17.6313 17.3185 16.9749 17.9749C16.3185 18.6313 15.4283 19 14.5 19H6" stroke="#B9A16B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <label>Total</label>
                        <span class="order-value">${{number_format($order->total, 2, '.', ',')}}</span>
                    </div>
                    <div class="order-info__item">
                        <svg class="order-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M21 4H3C1.89543 4 1 4.89543 1 6V18C1 19.1046 1.89543 20 3 20H21C22.1046 20 23 19.1046 23 18V6C23 4.89543 22.1046 4 21 4Z" stroke="#B9A16B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M1 10H23" stroke="#B9A16B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <label>Payment Method</label>
                        <span class="order-value">{{ $order->getPaymentMethodLabel() }}</span>
                    </div>
                </div>
                <div class="checkout__totals-wrapper">
                    <div class="checkout__totals order-details-card print-section">
                        <div class="print-header" style="display: none;">
                            <h2>INVOICE</h2>
                            <p>Order #{{$order->id}} - {{$order->created_at->format('F j, Y')}}</p>
                        </div>

                        <svg class="me-2 no-print" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20 7H4C2.89543 7 2 7.89543 2 9V19C2 20.1046 2.89543 21 4 21H20C21.1046 21 22 20.1046 22 19V9C22 7.89543 21.1046 7 20 7Z" stroke="#333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M16 21V5C16 4.46957 15.7893 3.96086 15.4142 3.58579C15.0391 3.21071 14.5304 3 14 3H10C9.46957 3 8.96086 3.21071 8.58579 3.58579C8.21071 3.96086 8 4.46957 8 5V21" stroke="#333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <!-- Add this button after the order details title -->
                        <h3 class="order-details-title no-print">Order Details
                            <button id="printInvoiceBtn" class="btn btn-sm btn-secondary float-end">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" class="me-1">
                                    <path d="M4 6H12V4C12 2.89543 11.1046 2 10 2H6C4.89543 2 4 2.89543 4 4V6Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M4 10H2V6C2 4.89543 2.89543 4 4 4H12C13.1046 4 14 4.89543 14 6V10H12" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M4 8H12V13C12 13.5523 11.5523 14 11 14H5C4.44772 14 4 13.5523 4 13V8Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                Print Invoice
                            </button>
                        </h3>
                        <!-- Customer information - print only -->
                        <div class="customer-info print-only" style="display: none; margin-bottom: 20px;">
                            <div class="row">
                                <div class="col-6">
                                    <h4>BILLING INFORMATION</h4>
                                    <p>{{$order->address->name}}<br>
                                    {{$order->address->address}}<br>
                                    {{$order->address->city}}, {{$order->address->state}} {{$order->address->zip}}<br>
                                    {{$order->address->country}}<br>
                                    {{$order->address->phone}}</p>
                                </div>
                                <div class="col-6 text-end">
                                    <h4>ORDER INFORMATION</h4>
                                    <p>Order #: {{$order->id}}<br>
                                    Date: {{$order->created_at->format('F j, Y')}}<br>
                                    Payment Method: {{ $order->getPaymentMethodLabel() }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="order-products-table">
                            <div class="order-table-header">
                                <div class="product-col">PRODUCT</div>
                                <div class="subtotal-col">SUBTOTAL</div>
                            </div>
                            <div class="order-table-body">
                                @foreach($order->orderItems as $item)
                                    <div class="order-table-row">
                                        <div class="product-col">
                                            <div class="product-info">
                                                <span class="product-name">{{$item->product->name}}</span>
                                                <span class="product-quantity">× {{$item->quantity}}</span>
                                            </div>
                                        </div>
                                        <div class="subtotal-col">${{number_format($item->price * $item->quantity, 2, '.', ',')}}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="order-summary-table">
                            <div class="summary-row">
                                <div class="summary-label">SUBTOTAL</div>
                                <div class="summary-value">${{number_format($order->subtotal, 2, '.', ',')}}</div>
                            </div>
                            <div class="summary-row">
                                <div class="summary-label">DISCOUNT</div>
                                <div class="summary-value">${{number_format($order->discount, 2, '.', ',')}}</div>
                            </div>
                            <div class="summary-row">
                                <div class="summary-label">SHIPPING</div>
                                <div class="summary-value">Free shipping</div>
                            </div>
                            <div class="summary-row">
                                <div class="summary-label">VAT</div>
                                <div class="summary-value">${{number_format($order->tax, 2, '.', ',')}}</div>
                            </div>
                            <div class="summary-row total">
                                <div class="summary-label">TOTAL</div>
                                <div class="summary-value">${{number_format($order->total, 2, '.', ',')}}</div>
                            </div>
                        </div>

                        <div class="print-footer" style="display: none; margin-top: 30px; text-align: center;">
                            <p>Thank you for your purchase!</p>
                            <p>If you have any questions, please contact our customer support.</p>
                        </div>

                        <div class="text-center mt-4 no-print">
                            <a href="{{ route('shop.index') }}" class="btn btn-primary me-3">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" class="me-2">
                                    <path d="M8.33333 15.8333L2.5 10M2.5 10L8.33333 4.16667M2.5 10H17.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                Continue Shopping
                            </a>
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
        border-radius: 12px;
        padding: 40px 30px;
        margin-bottom: 30px;
        text-align: center;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    }

    .order-complete__message h3 {
        margin-top: 20px;
        font-size: 24px;
        font-weight: 600;
        color: #333;
    }

    .order-complete__message {
        background-color: #f8f9fa;
        border-radius: 12px;
        padding: 40px 30px;
        margin-bottom: 30px;
        text-align: center;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    }

    .order-info {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 40px;
        background-color: #f8f9fa;
        border-radius: 12px;
        padding: 25px;
    }

    .order-info__item {
        padding: 20px;
        border-radius: 10px;
        background-color: white;
        box-shadow: 0 4px 12px rgba(0,0,0,0.04);
        transition: all 0.3s ease;
        border-left: 4px solid #B9A16B;
    }

    .order-info__item:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.08);
    }

    .order-info__item label {
        display: block;
        color: #6c757d;
        font-size: 14px;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .order-value {
        font-weight: 600;
        font-size: 18px;
        color: #212529;
    }

    /* New table styles */
    .order-details-card {
        background-color: white;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        padding: 30px;
        margin-bottom: 40px;
    }

    .order-details-title {
        font-size: 22px;
        font-weight: 600;
        margin-bottom: 25px;
        color: #333;
        border-bottom: 2px solid #f0f0f0;
        padding-bottom: 15px;
    }

    .order-products-table {
        margin-bottom: 30px;
    }

    .order-table-header {
        display: flex;
        background-color: #f8f9fa;
        padding: 15px 20px;
        border-radius: 8px 8px 0 0;
        font-weight: 600;
        color: #495057;
        border-bottom: 2px solid #eee;
    }

    .order-table-body {
        border: 1px solid #eee;
        border-top: none;
        border-radius: 0 0 8px 8px;
    }

    .order-table-row {
        display: flex;
        padding: 15px 20px;
        border-bottom: 1px solid #eee;
    }

    .order-table-row:last-child {
        border-bottom: none;
    }

    .product-col {
        flex: 3;
    }

    .subtotal-col {
        flex: 1;
        text-align: right;
        font-weight: 600;
    }

    .product-info {
        display: flex;
        flex-direction: column;
    }

    .product-name {
        font-weight: 500;
        margin-bottom: 5px;
    }

    .product-quantity {
        color: #6c757d;
        font-size: 14px;
    }

    .order-summary-table {
        margin-top: 30px;
        border-top: 2px solid #f0f0f0;
        padding-top: 20px;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        color: #495057;
    }

    .summary-row.total {
        border-top: 2px solid #f0f0f0;
        margin-top: 10px;
        padding-top: 15px;
        font-weight: 700;
        font-size: 18px;
        color: #212529;
    }

    .print-button {
        display: flex;
        align-items: center;
        padding: 8px 16px;
    }

    @media print {
        body * {
            visibility: hidden;
        }
        .print-section, .print-section * {
            visibility: visible;
        }
        .no-print {
            display: none !important;
        }
        .print-only {
            display: block !important;
        }
        .print-section {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            padding: 20px;
        }
        .print-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .print-header h2 {
            font-size: 24px;
            margin-bottom: 5px;
        }
        .customer-info {
            margin-bottom: 20px;
        }
        .customer-info h4 {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .customer-info p {
            margin-bottom: 0;
        }
    }
</style>
@endpush

@push('scripts')
    <script>
        document.getElementById('printInvoiceBtn').addEventListener('click', function() {
            window.print();
        });
    </script>
@endpush
@endsection
