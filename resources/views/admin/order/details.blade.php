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
                            <h5>Ordered Items</h5>
                        </div>
                        <a class="tf-button style-1 w208" href="orders.html">Back</a>
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
                            <tr>

                                <td class="pname">
                                    <div class="image">
                                        <img src="1718066538.html" alt="" class="image">
                                    </div>
                                    <div class="name">
                                        <a href="#" target="_blank"
                                           class="body-title-2">Product1</a>
                                    </div>
                                </td>
                                <td class="text-center">$71.00</td>
                                <td class="text-center">1</td>
                                <td class="text-center">SHT01245</td>
                                <td class="text-center">Category1</td>
                                <td class="text-center">Brand1</td>
                                <td class="text-center"></td>
                                <td class="text-center">No</td>
                                <td class="text-center">
                                    <div class="list-icon-function view-icon">
                                        <div class="item eye">
                                            <i class="icon-eye"></i>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>

                                <td class="pname">
                                    <div class="image">
                                        <img src="1718066673.html" alt="" class="image">
                                    </div>
                                    <div class="name">
                                        <a href="#" target="_blank"
                                           class="body-title-2">Product2</a>
                                    </div>
                                </td>
                                <td class="text-center">$101.00</td>
                                <td class="text-center">1</td>
                                <td class="text-center">SHT99890</td>
                                <td class="text-center">Category2</td>
                                <td class="text-center">Brand1</td>
                                <td class="text-center"></td>
                                <td class="text-center">No</td>
                                <td class="text-center">
                                    <div class="list-icon-function view-icon">
                                        <div class="item eye">
                                            <i class="icon-eye"></i>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            </tbody>
                        </table>
                    </div>

                    <div class="divider"></div>
                    <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">

                    </div>
                </div>

                <div class="wg-box mt-5">
                    <h5>Shipping Address</h5>
                    <div class="my-account__address-item col-md-6">
                        <div class="my-account__address-item__detail">
                            <p>Divyansh Kumar</p>
                            <p>Flat No - 13, R. K. Wing - B</p>
                            <p>ABC, DEF</p>
                            <p>GHT, </p>
                            <p>AAA</p>
                            <p>000000</p>
                            <br>
                            <p>Mobile : 1234567891</p>
                        </div>
                    </div>
                </div>

                <div class="wg-box mt-5">
                    <h5>Transactions</h5>
                    <table class="table table-striped table-bordered table-transaction">
                        <tbody>
                        <tr>
                            <th>Subtotal</th>
                            <td>172.00</td>
                            <th>Tax</th>
                            <td>36.12</td>
                            <th>Discount</th>
                            <td>0.00</td>
                        </tr>
                        <tr>
                            <th>Total</th>
                            <td>208.12</td>
                            <th>Payment Mode</th>
                            <td>cod</td>
                            <th>Status</th>
                            <td>pending</td>
                        </tr>
                        <tr>
                            <th>Order Date</th>
                            <td>2024-07-11 00:54:14</td>
                            <th>Delivered Date</th>
                            <td></td>
                            <th>Canceled Date</th>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
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
