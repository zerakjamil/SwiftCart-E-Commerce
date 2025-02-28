@extends('layouts.admin')
@section('content')
        <div class="main-content-inner">
            <div class="main-content-wrap">
                <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                    <h3>Coupons</h3>
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
                            <div class="text-tiny">Coupons</div>
                        </li>
                    </ul>
                </div>

                <div class="wg-box">
                    <div class="flex items-center justify-between gap10 flex-wrap">
                        <div class="wg-filter flex-grow">
                            <form class="form-search">
                                <fieldset class="name">
                                    <input type="text" placeholder="Search here..." class="" name="name"
                                           tabindex="2" value="" aria-required="true" required="">
                                </fieldset>
                                <div class="button-submit">
                                    <button class="" type="submit"><i class="icon-search"></i></button>
                                </div>
                            </form>
                        </div>
                        <a class="tf-button style-1 w208" href="{{ route('coupon.create') }}"><i
                                class="icon-plus"></i>Add new</a>
                    </div>
                    <div class="wg-table table-all-user">
                        <div class="table-responsive">
                            @if(Session::has('success'))
                                <div class="alert alert-success">{{Session::get('success')}}</div>
                            @elseif(Session::has('error'))
                                <div class="alert alert-danger">{{Session::get('error')}}</div>
                            @endif
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Code</th>
                                    <th>Type</th>
                                    <th>Value</th>
                                    <th>Cart Value</th>
                                    <th>Expiry Date</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($coupons->count() == 0)
                                    <tr>
                                        <td colspan="7" class="text-center">No Coupons Found</td>
                                    </tr>
                                @endif
                                @foreach($coupons as $coupon)
                                    <tr>
                                        <td>{{$coupon->id}}</td>
                                        <td>{{$coupon->code}}</td>
                                        <td>{{$coupon->type}}</td>
                                        <td>{{$coupon->value}}</td>
                                        <td>${{$coupon->cart_value}}</td>
                                        <td>{{ $coupon->expiry_date ? $coupon->expiry_date->format('Y-m-d H:i:s') : 'N/A' }}</td>                                        <td>
                                            <div class="list-icon-function">
                                                <a href="{{ route('coupon.edit', $coupon->id) }}">
                                                    <div class="item edit">
                                                        <i class="icon-edit-3"></i>
                                                    </div>
                                                </a>
                                                <form action="{{ route('coupon.destroy', $coupon->id) }}" method="POST"
                                                      class="delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="item text-danger delete delete-confirmation">
                                                        <i class="icon-trash-2"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                        {{$coupons->links('pagination::bootstrap-5')}}
                    </div>
                </div>
            </div>
        </div>

        <x-confirmation-script
            title="Delete Coupon"
            text="Once deleted, you will not be able to recover this record!">
        </x-confirmation-script>
@endsection
