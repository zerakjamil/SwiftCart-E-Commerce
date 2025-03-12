@extends('layouts.app')
@section('content')
    <main class="pt-90" style="padding-top: 0px;">
        <div class="mb-4 pb-4"></div>
        <section class="my-account container">
            <h2 class="page-title">Orders</h2>
            <div class="row">
                <div class="col-lg-2">
                    <ul class="account-nav">
                        <li><a href="{{ route('user.index') }}" class="menu-link menu-link_us-s ">Dashboard</a></li>
                        <li><a href="{{ route('user.orders') }}" class="menu-link menu-link_us-s menu-link_active">Orders</a></li>
                        <li><a href="http://localhost:8000/account-addresses" class="menu-link menu-link_us-s ">Addresses</a></li>
                        <li><a href="http://localhost:8000/account-details" class="menu-link menu-link_us-s ">Account Details</a></li>
                        <li><a href="http://localhost:8000/account-wishlists" class="menu-link menu-link_us-s ">Wishlist</a></li>
                        <li>
                            <form method="POST" action="http://localhost:8000/logout" id="logout-form-1">
                                <input type="hidden" name="_token" value="3v611ELheIo6fqsgspMOk0eiSZjncEeubOwUa6YT" autocomplete="off">            <a href="http://localhost:8000/logout" class="menu-link menu-link_us-s" onclick="event.preventDefault(); document.getElementById('logout-form-1').submit();">Logout</a>
                            </form>
                        </li>
                    </ul>            </div>

                <div class="col-lg-10">
                    <div class="wg-table table-all-user">
                        @if($orders->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                    <tr>
                                        <th>Order #</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th class="text-end">Total</th>
                                        <th class="text-center">Items</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($orders as $order)
                                        <tr>
                                            <td class="align-middle">
                                                #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
                                            </td>
                                            <td class="align-middle">
                                                <div>{{ $order->created_at->format('M j, Y') }}</div>
                                                <small class="text-muted">{{ $order->created_at->format('g:i A') }}</small>
                                            </td>
                                            <td class="align-middle">
                                                @php
                                                    $statusClass = match(strtolower($order->status)) {
                                                        'pending' => 'warning',
                                                        'processing' => 'info',
                                                        'shipped' => 'primary',
                                                        'delivered' => 'success',
                                                        'cancelled' => 'danger',
                                                        default => 'secondary'
                                                    };
                                                @endphp
                                                <span class="badge bg-{{ $statusClass }}">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </td>
                                            <td class="text-end align-middle">
                                                <strong>${{ number_format($order->total, 2) }}</strong>
                                            </td>
                                            <td class="text-center align-middle">
                                                {{ $order->orderItems->count() }}
                                            </td>
                                            <td class="text-end align-middle">
                                                <a href="{{ route('user.orders.details', $order->id) }}"
                                                   class="btn btn-sm btn-outline-secondary">
                                                    View Details
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="px-3 py-3 border-top">
                                {{ $orders->links('pagination::bootstrap-5') }}
                            </div>
                        @else
                                <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th style="width: 80px">OrderNo</th>
                                    <th>Name</th>
                                    <th class="text-center">Phone</th>
                                    <th class="text-center">Subtotal</th>
                                    <th class="text-center">Tax</th>
                                    <th class="text-center">Total</th>

                                    <th class="text-center">Status</th>
                                    <th class="text-center">Order Date</th>
                                    <th class="text-center">Items</th>
                                    <th class="text-center">Delivered On</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td class="text-center">{{$order->id}}</td>
                                        <td class="text-center">{{$order->address->name}}</td>
                                        <td class="text-center">{{$order->address->phone}}</td>
                                        <td class="text-center">${{$order->subtotal}}</td>
                                        <td class="text-center">${{$order->tax}}</td>
                                        <td class="text-center">${{$order->total}}</td>

                                        <td class="text-center">
                                            <span class="badge bg-danger status-{{ strtolower($order->status) }}">{{ ucfirst($order->status) }}</span>
                                        </td>
                                        <td class="text-center">{{$order->created_at->format('F j, Y')}}</td>
                                        <td class="text-center">{{$order->orderItems->count()}}</td>
                                        <td>
                                            @if($order->status === 'delivered')
                                                {{$order->updated_at->format('F j, Y')}}
                                            @else
                                                <span class="text-muted">Pending</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('user.orders.details', $order->id) }}">
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
                        @endif
                    </div>
                    <div class="divider"></div>
                    <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                        {{$orders->links('pagination::bootstrap-5')}}
                    </div>
                </div>

            </div>
        </section>
    </main>
@endsection
