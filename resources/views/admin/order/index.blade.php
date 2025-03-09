@extends('layouts.admin')
@section('content')
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Orders</h3>
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
                        <div class="text-tiny">Orders</div>
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
                </div>
                <div class="wg-table table-all-user">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th style="width:70px">OrderNo</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">Phone</th>
                                <th class="text-center">Subtotal</th>
                                <th class="text-center">Tax</th>
                                <th class="text-center">Total</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Order Date</th>
                                <th class="text-center">Total Items</th>
                                <th class="text-center">Delivered On</th>
                                <th class="text-center">Actions</th>
                            </tr>
                            </thead>
                           <tbody>
                            @if($orders->count() === 0)
                                    <tr>
                                        <td colspan="11" class="text-center">No Orders are Available at the Moment</td>
                                    </tr>
                            @endif
                            @foreach($orders as $order)
                            <tr>
                                <td class="text-center">{{$order->id}}</td>
                                <td class="text-center">{{$order->address->name}}</td>
                                <td class="text-center">{{$order->address->phone}}</td>
                                <td class="text-center">${{$order->subtotal}}</td>
                                <td class="text-center">${{$order->tax}}</td>
                                <td class="text-center">${{$order->total}}</td>
                                <td class="text-center">
                                    <span class="text-black status-{{ strtolower($order->status) }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="text-center">{{$order->created_at->format('F j, Y')}}</td>
                                <td class="text-center">{{$order->quantity}}</td>
                                <td class="text-center">
                                    @if($order->status === 'delivered')
                                        {{$order->updated_at->format('F j, Y')}}
                                    @else
                                        <span class="text-muted">Pending</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('order.show', ['order' => $order->id]) }}" class="btn btn-sm btn-info" title="View Order">
                                            <i class="icon-eye"></i>
                                        </a>
                                        <a
                                            href="{{ route('order.invoice', ['order' => $order->id]) }}"
                                            id="printInvoiceBtn-{{ $order->id }}"
                                            class="btn btn-sm btn-secondary float-end"
                                            data-order-id="{{ $order->id }}">
                                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" class="me-1">
                                                <path d="M4 6H12V4C12 2.89543 11.1046 2 10 2H6C4.89543 2 4 2.89543 4 4V6Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M4 10H2V6C2 4.89543 2.89543 4 4 4H12C13.1046 4 14 4.89543 14 6V10H12" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M4 8H12V13C12 13.5523 11.5523 14 11 14H5C4.44772 14 4 13.5523 4 13V8Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </a>
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
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const printButtons = document.querySelectorAll('[id^="printInvoiceBtn-"]');

        printButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const orderId = this.getAttribute('data-order-id');
                printInvoice(orderId);
            });
        });

        function printInvoice(orderId) {
            const printWindow = window.open(`{{ url('/admin/orders/invoice') }}/${orderId}`, '_blank');
            printWindow.onload = function() {
                printWindow.print();
            }
        }
    });
</script>
@endpush
