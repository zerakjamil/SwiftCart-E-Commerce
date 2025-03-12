@extends('layouts.app')
@section('content')
    <main class="pt-90" style="padding-top: 0px;">
        <div class="mb-4 pb-4"></div>
        <section class="my-account container">
            <h2 class="page-title">Order's Details</h2>
            <div class="row">
                <div class="col-lg-2">
                    <ul class="account-nav">
                        <li><a href="{{ route('user.index') }}" class="menu-link menu-link_us-s ">Dashboard</a></li>
                        <li><a href="{{ route('user.orders') }}" class="menu-link menu-link_us-s ">Orders</a></li>
                        <li><a href="http://localhost:8000/account-addresses" class="menu-link menu-link_us-s ">Addresses</a></li>
                        <li><a href="http://localhost:8000/account-details" class="menu-link menu-link_us-s ">Account Details</a>
                        </li>
                        <li><a href="http://localhost:8000/account-wishlists" class="menu-link menu-link_us-s ">Wishlist</a></li>
                        <li>
                            <form method="POST" action="http://localhost:8000/logout" id="logout-form-1">
                                <input type="hidden" name="_token" value="3v611ELheIo6fqsgspMOk0eiSZjncEeubOwUa6YT" autocomplete="off">
                                <a href="http://localhost:8000/logout" class="menu-link menu-link_us-s"
                                   onclick="event.preventDefault(); document.getElementById('logout-form-1').submit();">Logout</a>
                            </form>
                        </li>
                    </ul>
                </div>

                <div class="col-lg-10">
                    <div class="wg-box mt-5 mb-5">
                        <div class="row">
                            <div class="col-6">
                                <h5>Ordered Details</h5>
                            </div>
                            <div class="col-6 text-right">
                                <a class="btn btn-sm btn-danger" href="{{ route('user.orders') }}">Back</a>
                            </div>
                        </div>
                        <div class="order-details-container">
                            <div class="card mb-4 border-0 shadow-sm">
                                <div class="card-header bg-white">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">Order #{{$order->id}}</h5>
                                        <span
                                            class="badge rounded-pill {{$order->checkStatus() == 'Delivered' ? 'bg-success' : ($order->checkStatus() == 'Canceled' ? 'bg-danger' : 'bg-warning')}}">
                    {!! $order->checkStatus() !!}
                </span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row g-4">
                                        <div class="col-md-4">
                                            <div class="order-info-card p-3 border rounded">
                                                <h6 class="text-muted mb-3">Order Information</h6>
                                                <div class="d-flex justify-content-between mb-2">
                                                    <span class="text-muted">Order Date:</span>
                                                    <span
                                                        class="fw-medium">{{$order->created_at->format('M d, Y')}}</span>
                                                </div>
                                                @if($order->develivered_date)
                                                    <div class="d-flex justify-content-between mb-2">
                                                        <span class="text-muted">Delivered Date:</span>
                                                        <span class="fw-medium">{{$order->develivered_date}}</span>
                                                    </div>
                                                @endif
                                                @if($order->canceled_date)
                                                    <div class="d-flex justify-content-between">
                                                        <span class="text-muted">Canceled Date:</span>
                                                        <span class="fw-medium">{{$order->canceled_date}}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="order-info-card p-3 border rounded">
                                                <h6 class="text-muted mb-3">Contact Information</h6>
                                                <div class="d-flex justify-content-between mb-2">
                                                    <span class="text-muted">Name:</span>
                                                    <span class="fw-medium">{{$order->address->name}}</span>
                                                </div>
                                                <div class="d-flex justify-content-between mb-2">
                                                    <span class="text-muted">Mobile:</span>
                                                    <span class="fw-medium">{{$order->address->phone}}</span>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <span class="text-muted">Pin/Zip Code:</span>
                                                    <span class="fw-medium">{{$order->address->zip}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="order-info-card p-3 border rounded">
                                                <h6 class="text-muted mb-3">Shipping Address</h6>
                                                <p class="mb-2">{{$order->address->address}}</p>
                                                <p class="mb-2">{{$order->address->locality}}
                                                    , {{$order->address->city}}</p>
                                                @if($order->address->landmark)
                                                    <p class="mb-0">Near: {{$order->address->landmark}}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="wg-box mb-5">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="mb-0">Ordered Items</h5>
                        </div>
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-0">
                                <div class="ordered-items">
                                    @foreach($order->orderItems as $item)
                                    <div class="ordered-item p-4 border-bottom">
                                        <div class="row align-items-center">
                                            <div class="col-lg-6 mb-3 mb-lg-0">
                                                <div class="d-flex align-items-center">
                                                    <div class="product-image me-3">
                                                        <img src="{{asset('uploads/products/'.$item->product->image)}}"
                                                             alt="{{$item->product->name}}"
                                                             class="rounded"
                                                             style="width: 80px; height: 80px; object-fit: cover;">
                                                    </div>
                                                    <div class="product-info">
                                                        <h6 class="mb-1">
                                                            <a href="{{ route('shop.show', ['product' => $item->product->slug]) }}"
                                                               class="text-decoration-none text-dark">
                                                                {{$item->product->name}}
                                                            </a>
                                                        </h6>
                                                        <div class="d-flex flex-wrap">
                                                            <span class="badge bg-light text-dark me-2 mb-1">SKU: {{$item->product->SKU}}</span>
                                                            <span class="badge bg-light text-dark me-2 mb-1">{{$item->product->category->name}}</span>
                                                            <span class="badge bg-light text-dark me-2 mb-1">{{$item->product->brand->name}}</span>
                                                            @if($item->options)
                                                            <span class="badge bg-light text-dark mb-1">Options: {{$item->options}}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 mb-3 mb-lg-0">
                                                <div class="row">
                                                    <div class="col-6 col-lg-4">
                                                        <div class="text-muted small">Price</div>
                                                        <div class="fw-medium">${{$item->price}}</div>
                                                    </div>
                                                    <div class="col-6 col-lg-4">
                                                        <div class="text-muted small">Quantity</div>
                                                        <div class="fw-medium">{{$item->quantity}}</div>
                                                    </div>
                                                    <div class="col-6 col-lg-4">
                                                        <div class="text-muted small">Total</div>
                                                        <div class="fw-medium">${{$item->price * $item->quantity}}</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <div class="text-muted small">Return Status</div>
                                                        <span class="badge {{$item->rstatus === 0 ? 'bg-secondary' : 'bg-success'}}">
                                                            {{$item->rstatus === 0 ? 'No' : 'Yes'}}
                                                        </span>
                                                    </div>
                                                    <a href="{{ route('shop.show', ['product' => $item->product->slug]) }}"
                                                       class="btn btn-sm btn-outline-primary rounded-circle"
                                                       title="View Product"
                                                       target="_blank">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                    </div>

                    <div class="wg-box mt-5">
                        <h5 class="mb-4">Order Summary</h5>
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mx-auto">
                                        <div class="table-responsive">
                                            <table class="table table-borderless">
                                                <tbody>
                                                    <tr>
                                                        <td class="text-muted">Subtotal</td>
                                                        <td class="text-end fw-medium">${{$order->subtotal}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted">Tax</td>
                                                        <td class="text-end fw-medium">${{$order->tax}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted">Shipping</td>
                                                        <td class="text-end fw-medium">${{$order->shipping_cost}}</td>
                                                    </tr>
                                                    @if($order->discount > 0)
                                                    <tr>
                                                        <td class="text-muted">Discount</td>
                                                        <td class="text-end fw-medium text-success">-${{$order->discount}}</td>
                                                    </tr>
                                                    @endif
                                                    <tr>
                                                        <td colspan="2"><hr class="my-2"></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="h6">Total</td>
                                                        <td class="text-end h6">${{$order->total}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted">Payment Method</td>
                                                        <td class="text-end fw-medium">
                                                            <span class="badge bg-light text-dark">
                                                                {{ $order->getPaymentMethodLabel() }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted">Payment Status</td>
                                                        <td class="text-end">
                                                            <span class="badge {{$order->payment_status ? 'bg-success' : 'bg-warning'}}">
                                                                {{$order->payment_status ? 'Paid' : 'Pending'}}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="wg-box mt-5">
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('user.orders') }}" class="btn btn-outline-secondary">
                                <i class="fa fa-arrow-left me-2"></i>Back to Orders
                            </a>

                            @if($order->status != 'canceled' && $order->status != 'delivered')
                                <form action="http://localhost:8000/account-order/cancel-order" method="POST"
                                      onsubmit="return confirm('Are you sure you want to cancel this order?');">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="order_id" value="{{$order->id}}">
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fa fa-times-circle me-2"></i>Cancel Order
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </main>
@endsection

@push('styles')
    <style>
    .order-details-container .order-info-card {
    background-color: #f9f9f9;
    transition: all 0.3s ease;
    height: 100%;
}

.order-details-container .order-info-card:hover {
    background-color: #f5f5f5;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
}

.order-details-container .fw-medium {
    font-weight: 500;
}

.order-details-container .badge {
    padding: 8px 12px;
    font-weight: 500;
}

.order-details-container .text-muted {
    color: #6c757d;
}

.order-details-container .card-header {
    border-bottom: 1px solid rgba(0,0,0,.05);
}
    </style>
 @endpush
