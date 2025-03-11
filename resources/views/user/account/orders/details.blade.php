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
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-transaction">
                                <tbody>
                                <tr>
                                    <th>Order No</th>
                                    <td class="text-black">{{$order->id}}</td>
                                    <th>Mobile</th>
                                    <td>{{$order->address->phone}}</td>
                                    <th>Pin/Zip Code</th>
                                    <td>{{$order->address->zip}}</td>
                                </tr>
                                <tr>
                                    <th>Order Date</th>
                                    <td>{{$order->created_at}}</td>
                                    <th>Delivered Date</th>
                                    <td>{{$order->develivered_date}}</td>
                                    <th>Canceled Date</th>
                                    <td>{{$order->canceled_date}}</td>
                                </tr>
                                <tr>
                                    <th>Order Status</th>
                                    <td colspan="5">
                                        <span class="badge bg-danger">
                                            {!! $order->checkStatus() !!}
                                        </span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="wg-box wg-table table-all-user">
                        <div class="row">
                            <div class="col-6">
                                <h5>Ordered Items</h5>
                            </div>
                            <div class="col-6 text-right">

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
                                @foreach($order->orderItems as $item)
                                    <tr>

                                        <td class="pname">
                                            <div class="image">
                                                <img src="{{asset('uploads/products/'.$item->product->image)}}" alt="{{$item->product->name}}" class="image">
                                            </div>
                                            <div class="name">
                                                <a href="{{ route('shop.show', ['product' => $item->product->id]) }}" target="_blank" class="body-title-2">{{$item->product->name}}</a>
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
                                            <a href="{{ route('shop.show', ['product' => $item->product->id]) }}" target="_blank">
                                                <div class="list-icon-function view-icon">
                                                    <div class="item eye">
                                                        <i class="fa fa-eye"></i>
                                                    </div>
                                                </div>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
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

                    <div class="wg-box mt-5 text-right">
                        <form action="http://localhost:8000/account-order/cancel-order" method="POST">
                            <input type="hidden" name="_token" value="3v611ELheIo6fqsgspMOk0eiSZjncEeubOwUa6YT" autocomplete="off">
                            <input type="hidden" name="_method" value="PUT"> <input type="hidden" name="order_id" value="1">
                            <button type="submit" class="btn btn-danger">Cancel Order</button>
                        </form>
                    </div>
                </div>

            </div>
        </section>
    </main>
@endsection
