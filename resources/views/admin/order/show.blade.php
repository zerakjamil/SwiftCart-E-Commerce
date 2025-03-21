@extends('layouts.admin')
@section('content')
        <div class="main-content-inner">
            <div class="main-content-wrap">
                <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                    <h3>Order Details</h3>
                    <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                        <li>
                            <a href="{{ route('admin.dashboard') }}">
                                <div class="text-tiny">Dashboard</div>
                            </a>
                        </li>
                        <li>
                            <i class="icon-chevron-right"></i>
                        </li>
                        <li>
                            <div class="text-tiny">Order Items</div>
                        </li>
                    </ul>
                </div>

                <div class="wg-box">
                    <div class="flex items-center justify-between gap10 flex-wrap">
                        <div class="wg-filter flex-grow">
                            <h5>Ordered Details</h5>
                        </div>
                        <a class="tf-button style-1 w208" href="{{ route('order.index') }}">Back</a>
                    </div>
                    <div class="table-responsive">
                         @if(Session::has('success'))
                            <div class="alert alert-success">{{Session::get('success')}}</div>
                          @elseif(Session::has('error'))
                            <div class="alert alert-danger">{{Session::get('error')}}</div>
                          @endif
                        <table class="table table-striped table-bordered">
                            <tr>
                                <th>Order No</th>
                                <td>{{$order->id}}</td>
                                <th>Mobile</th>
                                <td>{{$order->phone}}</td>
                                <th>Zip Code</th>
                                <td>{{$order->zip}}</td>
                            </tr>
                            <tr>
                                <th>Ordered At</th>
                                <td>{{$order->created_at}}</td>
                                <th>Delivered Date</th>
                                <td>{{$order->develivered_date}}</td>
                                <th>Canceled Date</th>
                                <td>{{$order->canceled_date}}</td>
                            </tr>
                            <tr>
                                <th>Order Status</th>
                                <td colspan="5">
                                        {!! $order->checkStatus() !!}
                                </td>
                            </tr>
                        </table>
                    </div>
                    </div>
                </div>

                <div class="wg-box">
                    <div class="flex items-center justify-between gap10 flex-wrap">
                        <div class="wg-filter flex-grow">
                            <h5>Ordered Items</h5>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th class="text-center">Price</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">SKU</th>
                                <th class="text-center">Category</th>
                                <th class="text-center">Brand</th>
                                <th class="text-center">Options</th>
                                <th class="text-center">Return Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orderItems as $item)
                            <tr>
                                <td class="pname">
                                    <div class="image">
                                        <img src="{{asset('uploads/products/'.$item->product->image)}}" alt="{{$item->product->name}}" class="image">
                                    </div>
                                    <div class="name">
                                        <a href="#" target="_blank"
                                           class="body-title-2">{{$item->product->name}}</a>
                                    </div>
                                </td>
                                <td class="text-center">${{$item->price}}</td>
                                <td class="text-center">{{$item->quantity}}</td>
                                <td class="text-center">{{$item->product->SKU}}</td>
                                <td class="text-center">{{$item->product->category->name}}</td>
                                <td class="text-center">{{$item->product->brand->name}}</td>
                                <td class="text-center">{{$item->options}}</td>
                                <td class="text-center">{{$item->rstatus === 0 ? 'No' : 'Yes'}}</td>
                                <td class="text-center">
                                    <div class="list-icon-function view-icon">
                                        <div class="item eye">
                                            <i class="icon-eye"></i>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="divider"></div>
                    <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                        {{$orderItems->links()}}
                    </div>
                </div>
                <div class="wg-box mt-5">
    <h5 class="mb-4">Shipping Address</h5>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <strong>Name:</strong>
                            <span class="float-end">{{$order->address->name}}</span>
                        </li>
                        <li class="list-group-item">
                            <strong>Address:</strong>
                            <span class="float-end">{{$order->address->address}}</span>
                        </li>
                        <li class="list-group-item">
                            <strong>Locality:</strong>
                            <span class="float-end">{{$order->address->locality}}</span>
                        </li>
                        <li class="list-group-item">
                            <strong>City:</strong>
                            <span class="float-end">{{$order->address->city}}</span>
                        </li>
                        <li class="list-group-item">
                            <strong>Landmark:</strong>
                            <span class="float-end">{{$order->address->landmark}}</span>
                        </li>
                        <li class="list-group-item">
                            <strong>Zip:</strong>
                            <span class="float-end">{{$order->address->zip}}</span>
                        </li>
                        <li class="list-group-item">
                            <strong>Mobile:</strong>
                            <span class="float-end">{{$order->address->phone}}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

                <div class="wg-box mt-5">
                    <h5>Transactions</h5>
                    <table class="table table-striped table-bordered table-transaction">
                        <tbody>
                        <tr>
                            <th>Subtotal</th>
                            <td>{{$order->subtotal}}</td>
                            <th>Tax</th>
                            <td>{{$order->tax}}</td>
                            <th>Discount</th>
                            <td>{{$order->discount}}</td>
                        </tr>
                        <tr>
                            <th>Total</th>
                            <td>{{$order->total}}</td>
                            <th>Payment Mode</th>
                            <td>{{$transaction->mode}}</td>
                            <th>Status</th>
                            <td>{!! $transaction->checkStatus() !!}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            <div class="wg-box mt-5">
                <h5>Update Order Status</h5>
                <form action="{{ route('order.update', $order->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="order_status" class="form-label">Order Status</label>
                                <select name="order_status" id="order_status" class="form-select">
                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                    <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                    <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                    <option value="canceled" {{ $order->status == 'canceled' ? 'selected' : '' }}>Canceled</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <button type="submit" class="tf-button style-1">Update Status</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
@endsection

@push('styles')
    <style>
        .table-transaction>tbody>tr:nth-of-type(odd) {
            --bs-table-accent-bg: #fff !important;
        }
    </style>
@endpush
