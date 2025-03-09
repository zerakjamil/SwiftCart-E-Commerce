@props(['order'])
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
