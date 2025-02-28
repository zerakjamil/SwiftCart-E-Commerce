@extends('layouts.admin')
@section('content')
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Edit Coupon</h3>
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
                        <a href="{{ route('coupon.index') }}">
                            <div class="text-tiny">Coupons</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">Edit Coupon</div>
                    </li>
                </ul>
            </div>
            <div class="wg-box">
                <form class="form-new-product form-style-1" method="POST" action="{{ route('coupon.update', $coupon->id) }}">
                    @csrf
                    @method('PUT')
                    <fieldset class="name">
                        <div class="body-title">Coupon Code <span class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="text" placeholder="Coupon Code" name="code" tabindex="0" value="{{ old('code', $coupon->code) }}" aria-required="true" required="">
                    </fieldset>
                    @error('code')
                    <span class="alert alert-danger text-center">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    <fieldset class="category">
                        <div class="body-title">Coupon Type</div>
                        <div class="select flex-grow">
                            <select class="" name="type">
                                <option value="">Select</option>
                                <option value="fixed" {{ old('type', $coupon->type) == 'fixed' ? 'selected' : '' }}>Fixed</option>
                                <option value="percent" {{ old('type', $coupon->type) == 'percent' ? 'selected' : '' }}>Percent</option>
                            </select>
                        </div>
                    </fieldset>
                    @error('type')
                    <span class="alert alert-danger text-center">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    <fieldset class="name">
                        <div class="body-title">Value <span class="tf-color-1">*</span></div>
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            <input class="flex-grow" type="number" placeholder="Coupon Value" name="value" tabindex="0" value="{{ old('value', $coupon->value) }}" aria-required="true" required="">
                        </div>
                    </fieldset>
                    @error('value')
                    <span class="alert alert-danger text-center">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    <fieldset class="name">
                        <div class="body-title">Cart Value <span class="tf-color-1">*</span></div>
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                        <input class="flex-grow" type="number" placeholder="Cart Value" name="cart_value" tabindex="0" value="{{ old('cart_value', $coupon->cart_value) }}" aria-required="true" required="">
                        </div>
                    </fieldset>
                    @error('cart_value')
                    <span class="alert alert-danger text-center">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    <fieldset class="name">
                        <div class="body-title">Expiry Date and Time <span class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="datetime-local" placeholder="Expiry Date and Time" name="expiry_date" tabindex="0"
                               value="{{ old('expiry_date', $coupon->expiry_date ? date('Y-m-d\TH:i', strtotime($coupon->expiry_date)) : '') }}"
                               aria-required="true" required="">
                    </fieldset>
                    @error('expiry_date')
                    <span class="alert alert-danger text-center">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror

                    <div class="bot">
                        <div></div>
                        <x-partials.button class="tf-button w208" type="submit">Update Coupon</x-partials.button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
    .input-group {
        position: relative;
        display: flex;
        width: 100%;
    }
    .input-group-addon {
        padding: 6px 12px;
        font-size: 14px;
        font-weight: 400;
        line-height: 1;
        color: #555;
        text-align: center;
        background-color: #eee;
        border: 1px solid #ccc;
        border-radius: 4px 0 0 4px;
        display: flex;
        align-items: center;
    }
    .input-group input {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
        flex: 1;
    }
</style>
@endpush
