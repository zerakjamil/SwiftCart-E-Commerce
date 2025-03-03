@extends('layouts.app')
@section('content')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="shop-checkout container">
            <h2 class="page-title">Shipping and Checkout</h2>
            <div class="checkout-steps">
                <a href="{{ route('cart.index') }}" class="checkout-steps__item active">
                    <span class="checkout-steps__item-number">01</span>
                    <span class="checkout-steps__item-title">
            <span>Shopping Bag</span>
            <em>Manage Your Items List</em>
          </span>
                </a>
                <a href="javascript:void(0)" class="checkout-steps__item active">
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
            <form name="checkout-form" action="">
                <div class="checkout-form">
                    <div class="billing-info__wrapper">
                        <div class="row">
                            <div class="col-6">
                                <h4>SHIPPING DETAILS</h4>
                            </div>
                            <div class="col-6">
                            </div>
                        </div>

                       @if(!$address)
                           <div class="row mt-3">
                               <div class="col-md-12">
                                   <div class="address-card">
                                       <div class="address-card__header">
                                           <div class="address-card__badge">
                                               <svg class="address-svg-icon" viewBox="0 0 24 24" fill="none">
                                                   <path d="M9 12L11 14L15 10M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                               </svg>
                                               Default Address
                                           </div>
                                           <h5 class="address-card__name">{{ $address->name }}</h5>
                                       </div>
                                       <div class="address-card__body">
                                           <div class="address-card__icon">
                                               <i class="fas fa-map-marker-alt"></i>
                                           </div>
                                           <div class="address-card__content">
                                               <div class="address-card__details">
                                                   <p class="address-card__line">{{ $address->address }}</p>
                                                   <p class="address-card__line">{{ $address->landmark }}</p>
                                                   <p class="address-card__line">{{ $address->city }}, {{ $address->state }}, {{ $address->country }}</p>
                                                   <p class="address-card__line">
                                                       <svg class="address-zip-icon" viewBox="0 0 24 24" fill="none">
                                                           <path d="M5 8H19M5 8C3.89543 8 3 7.10457 3 6C3 4.89543 3.89543 4 5 4H19C20.1046 4 21 4.89543 21 6C21 7.10457 20.1046 8 19 8M5 8L5 18C5 19.1046 5.89543 20 7 20H17C18.1046 20 19 19.1046 19 18V8M10 12H14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                       </svg>
                                                       <span class="zip-code">{{ $address->zip }}</span>
                                                   </p>
                                               </div>
                                               <div class="address-card__divider">
                                                   <svg class="divider-svg" viewBox="0 0 100 2" preserveAspectRatio="none">
                                                       <line x1="0" y1="1" x2="100" y2="1" vector-effect="non-scaling-stroke" />
                                                   </svg>
                                               </div>
                                               <div class="address-card__contact">
                                                   <svg class="address-phone-icon" viewBox="0 0 24 24" fill="none">
                                                       <path d="M3 5.5C3 14.0604 9.93959 21 18.5 21C18.8862 21 19.2691 20.9859 19.6483 20.9581C20.0834 20.9262 20.3009 20.9103 20.499 20.7963C20.663 20.7019 20.8185 20.5345 20.9007 20.364C21 20.1582 21 19.9181 21 19.438V16.6207C21 16.2169 21 16.015 20.9335 15.842C20.8749 15.6891 20.7795 15.553 20.6559 15.4456C20.516 15.324 20.3262 15.255 19.9468 15.117L16.74 13.9286C16.2985 13.7716 16.0777 13.6932 15.8683 13.7159C15.6836 13.7357 15.5059 13.8105 15.3549 13.9331C15.1837 14.0723 15.0629 14.3046 14.8212 14.7693L14 16C11.3501 14.7999 9.2019 12.6489 8 10L9.25 9.16667C9.71524 8.92430 9.94786 8.80312 10.087 8.63189C10.2093 8.48016 10.2842 8.30138 10.3041 8.11546C10.3269 7.90474 10.2476 7.68286 10.089 7.23907L8.90138 4.02316C8.76425 3.64421 8.69569 3.45473 8.57418 3.31481C8.46736 3.19204 8.33043 3.09683 8.17753 3.03865C8.00543 2.97314 7.80338 2.97314 7.39929 2.97314H4.56201C4.08183 2.97314 3.84174 2.97314 3.63648 3.07162C3.46538 3.15447 3.29934 3.30932 3.20487 3.47388C3.09084 3.67262 3.07542 3.88962 3.04458 4.32361C3.01509 4.70278 3 5.09575 3 5.5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                   </svg>
                                                   <span>{{ $address->phone }}</span>
                                               </div>
                                           </div>
                                       </div>
                                       <div class="address-card__footer">
                                           <a href="{{ route('user.index', ['tab' => 'address']) }}" class="address-edit-btn">
                                               <svg class="edit-icon" viewBox="0 0 24 24" fill="none">
                                                   <path d="M11 5H6C4.89543 5 4 5.89543 4 7V18C4 19.1046 4.89543 20 6 20H17C18.1046 20 19 19.1046 19 18V13M17.5858 3.58579C18.3668 2.80474 19.6332 2.80474 20.4142 3.58579C21.1953 4.36683 21.1953 5.63316 20.4142 6.41421L11.8284 15H9V12.1716L17.5858 3.58579Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                               </svg>
                                               Change Address
                                           </a>
                                       </div>
                                   </div>
                               </div>
                           </div>
                       @else
                            <div class="shipping-address-form">
                                <div class="form-section">
                                    <h4 class="section-title">
                                        <svg class="section-icon" viewBox="0 0 24 24" fill="none">
                                            <path d="M12 11C14.2091 11 16 9.20914 16 7C16 4.79086 14.2091 3 12 3C9.79086 3 8 4.79086 8 7C8 9.20914 9.79086 11 12 11Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M16 14H8C5.79086 14 4 15.7909 4 18C4 19.1046 4.89543 20 6 20H18C19.1046 20 20 19.1046 20 18C20 15.7909 18.2091 14 16 14Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        Personal Details
                                    </h4>
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <div class="input-container">
                                                <svg class="input-icon" viewBox="0 0 24 24" fill="none">
                                                    <path d="M16 7C16 9.20914 14.2091 11 12 11C9.79086 11 8 9.20914 8 7C8 4.79086 9.79086 3 12 3C14.2091 3 16 4.79086 16 7Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M12 14C8.13401 14 5 17.134 5 21H19C19 17.134 15.866 14 12 14Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                                <input type="text" class="form-control" name="name" required="" value="{{old('name')}}" placeholder="Full Name *">
                                                @error('name') <span class="error-message">{{$message}}</span> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-container">
                                                <svg class="input-icon" viewBox="0 0 24 24" fill="none">
                                                    <path d="M3 5.5C3 14.0604 9.93959 21 18.5 21C18.8862 21 19.2691 20.9859 19.6483 20.9581C20.0834 20.9262 20.3009 20.9103 20.499 20.7963C20.663 20.7019 20.8185 20.5345 20.9007 20.364C21 20.1582 21 19.9181 21 19.438V16.6207C21 16.2169 21 16.015 20.9335 15.842C20.8749 15.6891 20.7795 15.553 20.6559 15.4456C20.516 15.324 20.3262 15.255 19.9468 15.117L16.74 13.9286C16.2985 13.7716 16.0777 13.6932 15.8683 13.7159C15.6836 13.7357 15.5059 13.8105 15.3549 13.9331C15.1837 14.0723 15.0629 14.3046 14.8212 14.7693L14 16C11.3501 14.7999 9.2019 12.6489 8 10L9.25 9.16667C9.71524 8.92430 9.94786 8.80312 10.087 8.63189C10.2093 8.48016 10.2842 8.30138 10.3041 8.11546C10.3269 7.90474 10.2476 7.68286 10.089 7.23907L8.90138 4.02316C8.76425 3.64421 8.69569 3.45473 8.57418 3.31481C8.46736 3.19204 8.33043 3.09683 8.17753 3.03865C8.00543 2.97314 7.80338 2.97314 7.39929 2.97314H4.56201C4.08183 2.97314 3.84174 2.97314 3.63648 3.07162C3.46538 3.15447 3.29934 3.30932 3.20487 3.47388C3.09084 3.67262 3.07542 3.88962 3.04458 4.32361C3.01509 4.70278 3 5.09575 3 5.5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                                <input type="text" class="form-control" name="phone" required="" value="{{old('phone')}}" placeholder="Phone Number *">
                                                @error('phone') <span class="error-message">{{$message}}</span> @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-section">
                                    <h4 class="section-title">
                                        <svg class="section-icon" viewBox="0 0 24 24" fill="none">
                                            <path d="M17.6569 16.6569C16.7202 17.5935 14.7616 19.5521 13.4142 20.8995C12.6332 21.6805 11.3668 21.6805 10.5858 20.8995C9.26105 19.5748 7.34477 17.6585 6.34315 16.6569C3.21895 13.5327 3.21895 8.46734 6.34315 5.34315C9.46734 2.21895 14.5327 2.21895 17.6569 5.34315C20.781 8.46734 20.781 13.5327 17.6569 16.6569Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M15 11C15 12.6569 13.6569 14 12 14C10.3431 14 9 12.6569 9 11C9 9.34315 10.3431 8 12 8C13.6569 8 15 9.34315 15 11Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        Location Information
                                    </h4>
                                    <div class="row g-4">
                                        <div class="col-md-4">
                                            <div class="input-container">
                                                <svg class="input-icon" viewBox="0 0 24 24" fill="none">
                                                    <path d="M5 8H19M5 8C3.89543 8 3 7.10457 3 6C3 4.89543 3.89543 4 5 4H19C20.1046 4 21 4.89543 21 6C21 7.10457 20.1046 8 19 8M5 8L5 18C5 19.1046 5.89543 20 7 20H17C18.1046 20 19 19.1046 19 18V8M10 12H14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                                <input type="text" class="form-control" name="zip" required="" value="{{old('zip')}}" placeholder="Pincode *">
                                                @error('zip') <span class="error-message">{{$message}}</span> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-container">
                                                <svg class="input-icon" viewBox="0 0 24 24" fill="none">
                                                    <path d="M9 20L3 17V4L9 7M9 20L15 17M9 20V7M15 17L21 20V7L15 4M15 17V4M9 7L15 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                                <input type="text" class="form-control" name="state" required="" value="{{old('state')}}" placeholder="State *">
                                                @error('state') <span class="error-message">{{$message}}</span> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-container">
                                                <svg class="input-icon" viewBox="0 0 24 24" fill="none">
                                                    <path d="M2 20H22M4 20V12H6M18 20V12H20M14 20V12C14 10.8954 13.1046 10 12 10C10.8954 10 10 10.8954 10 12V20M8 20V12C8 9.79086 9.79086 8 12 8C14.2091 8 16 9.79086 16 12V20M7 8H17M9.5 8V6C9.5 4.89543 10.3954 4 11.5 4H12.5C13.6046 4 14.5 4.89543 14.5 6V8H9.5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                                </svg>
                                                <input type="text" class="form-control" name="city" required="" value="{{old('city')}}" placeholder="Town / City *">
                                                @error('city') <span class="error-message">{{$message}}</span> @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-section">
                                    <h4 class="section-title">
                                        <svg class="section-icon" viewBox="0 0 24 24" fill="none">
                                            <path d="M3 9L12 2L21 9V20C21 20.5523 20.5523 21 20 21H4C3.44772 21 3 20.5523 3 20V9Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M9 21V12H15V21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        Address Details
                                    </h4>
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <div class="input-container">
                                                <svg class="input-icon" viewBox="0 0 24 24" fill="none">
                                                    <path d="M3 10.25V20C3 20.5523 3.44772 21 4 21H20C20.5523 21 21 20.5523 21 20V10.25M3 10.25V6C3 5.44772 3.44772 5 4 5H20C20.5523 5 21 5.44772 21 6V10.25M3 10.25H21M7 15H8M12 15H13M17 15H18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                                </svg>
                                                <input type="text" class="form-control" name="address" required="" value="{{old('address')}}" placeholder="House no, Building Name *">
                                                @error('address') <span class="error-message">{{$message}}</span> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-container">
                                                <svg class="input-icon" viewBox="0 0 24 24" fill="none">
                                                    <path d="M11 19L6.5 14.5M6.5 14.5L2 10M6.5 14.5L11 10M6.5 14.5L15 14.5M11 5L15.5 9.5M15.5 9.5L20 14M15.5 9.5L11 14M15.5 9.5L7 9.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                                <input type="text" class="form-control" name="locality" required="" value="{{old('locality')}}" placeholder="Road Name, Area, Colony *">
                                                @error('locality') <span class="error-message">{{$message}}</span> @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="input-container">
                                                <svg class="input-icon" viewBox="0 0 24 24" fill="none">
                                                    <path d="M12 21C16.9706 21 21 16.9706 21 12C21 7.02944 16.9706 3 12 3C7.02944 3 3 7.02944 3 12C3 16.9706 7.02944 21 12 21Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M15 12L12 12M12 12L9 12M12 12L12 9M12 12L12 15" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                                </svg>
                                                <input type="text" class="form-control" name="landmark" required="" value="{{old('landmark')}}" placeholder="Landmark *">
                                                @error('landmark') <span class="error-message">{{$message}}</span> @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="checkout__totals-wrapper">
                        <div class="sticky-content">
                            <div class="checkout__totals">
                                <h3>Your Order</h3>
                                <table class="checkout-cart-items">
                                    <thead>
                                    <tr>
                                        <th>PRODUCT</th>
                                        <th align="right">SUBTOTAL</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach(Cart::instance('cart') as $item)
                                    <tr>
                                        <td>
                                            {{$item->name}} x {{$item->qty}}
                                        </td>
                                        <td align="right">
                                            ${{$item->subtotal()}}
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>

                                </table>

                                @if(Session::has('discounts'))
                                    <div class="order-summary">
                                        <div class="order-summary__header">
                                            <svg class="summary-icon" viewBox="0 0 24 24" fill="none">
                                                <path d="M3 6.5L12 2L21 6.5M3 6.5V17.5L12 22M3 6.5L12 11M12 22L21 17.5V6.5M12 22V11M21 6.5L12 11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                            <h3 class="summary-title">Order Summary</h3>
                                        </div>
                                        <div class="order-summary__content">
                                            <div class="summary-row">
                                                <span class="summary-label">Subtotal</span>
                                                <span class="summary-value">${{Cart::instance('cart')->subtotal()}}</span>
                                            </div>

                                            @if(Session::has('coupon') && Session::has('discounts'))
                                                <div class="summary-row discount-row">
                                                    <span class="summary-label">
                                                        <span class="discount-badge">
                                                            <svg class="discount-icon" viewBox="0 0 24 24" fill="none">
                                                                <path d="M9.5 14.5L14.5 9.5M9.5 9.5H9.51M14.5 14.5H14.51M19 21L18 20M19 21L21 21M19 21L19 19M5 21L6 20M5 21L3 21M5 21L5 19M19 3L18 4M19 3L21 3M19 3L19 5M5 3L6 4M5 3L3 3M5 3L5 5M12 7C12 7.93464 11.1841 8.71826 10.2468 8.92673C10.0832 8.96555 10 9.11681 10 9.28425V11.7157C10 11.8832 10.0832 12.0344 10.2468 12.0733C11.1841 12.2817 12 13.0654 12 14C12 15.1046 11.1046 16 10 16C8.89543 16 8 15.1046 8 14M9.5 9.5C9.5 9.77614 9.27614 10 9 10C8.72386 10 8.5 9.77614 8.5 9.5C8.5 9.22386 8.72386 9 9 9C9.27614 9 9.5 9.22386 9.5 9.5ZM14.5 14.5C14.5 14.7761 14.2761 15 14 15C13.7239 15 13.5 14.7761 13.5 14.5C13.5 14.2239 13.7239 14 14 14C14.2761 14 14.5 14.2239 14.5 14.5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                            </svg>
                                                            Discount
                                                        </span>
                                                        {{Session::get('coupon')['code']}}
                                                    </span>
                                                    <span class="summary-value discount-value">-${{Session::get('discounts')['discount']}}</span>
                                                </div>
                                                <div class="summary-row subtotal-after">
                                                    <span class="summary-label">Subtotal After Discount</span>
                                                    <span class="summary-value">${{Session::get('discounts')['subtotal']}}</span>
                                                </div>
                                            @endif

                                            <div class="summary-row">
                                                <span class="summary-label">
                                                    <svg class="shipping-icon" viewBox="0 0 24 24" fill="none">
                                                        <path d="M8 19C9.10457 19 10 18.1046 10 17C10 15.8954 9.10457 15 8 15C6.89543 15 6 15.8954 6 17C6 18.1046 6.89543 19 8 19Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                        <path d="M16 19C17.1046 19 18 18.1046 18 17C18 15.8954 17.1046 15 16 15C14.8954 15 14 15.8954 14 17C14 18.1046 14.8954 19 16 19Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                        <path d="M10.05 17H14V6.5C14 5.67157 13.3284 5 12.5 5H2.5M16.01 17H19.54C20.0789 17 20.5572 16.6246 20.6553 16.0953L21.4903 11.963C21.5079 11.8895 21.5079 11.8139 21.4903 11.7404M14 9H18.01L19 11.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>
                                                    Shipping
                                                </span>
                                                <span class="summary-value">
                                                    <label class="shipping-option">
                                                        <input type="radio" name="shipping_option" checked class="shipping-radio">
                                                        <span>Free shipping</span>
                                                    </label>
                                                </span>
                                            </div>

                                            <div class="summary-row">
                                                <span class="summary-label">VAT</span>
                                                <span class="summary-value">${{Session::get('discounts')['tax'] ?? Cart::instance('cart')->tax()}}</span>
                                            </div>

                                            <div class="summary-divider"></div>

                                            <div class="summary-row total-row">
                                                <span class="summary-label">Total</span>
                                                <span class="summary-value total-value">${{Session::get('discounts')['total'] ?? Cart::instance('cart')->total()}}</span>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="order-summary">
                                        <div class="order-summary__header">
                                            <svg class="summary-icon" viewBox="0 0 24 24" fill="none">
                                                <path d="M3 6.5L12 2L21 6.5M3 6.5V17.5L12 22M3 6.5L12 11M12 22L21 17.5V6.5M12 22V11M21 6.5L12 11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                            <h3 class="summary-title">Order Summary</h3>
                                        </div>
                                        <div class="order-summary__content">
                                            <div class="summary-row">
                                                <span class="summary-label">Subtotal</span>
                                                <span class="summary-value">${{Cart::instance('cart')->subtotal()}}</span>
                                            </div>

                                            <div class="summary-row">
                                                <span class="summary-label">
                                                    <svg class="shipping-icon" viewBox="0 0 24 24" fill="none">
                                                        <path d="M8 19C9.10457 19 10 18.1046 10 17C10 15.8954 9.10457 15 8 15C6.89543 15 6 15.8954 6 17C6 18.1046 6.89543 19 8 19Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                        <path d="M16 19C17.1046 19 18 18.1046 18 17C18 15.8954 17.1046 15 16 15C14.8954 15 14 15.8954 14 17C14 18.1046 14.8954 19 16 19Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                        <path d="M10.05 17H14V6.5C14 5.67157 13.3284 5 12.5 5H2.5M16.01 17H19.54C20.0789 17 20.5572 16.6246 20.6553 16.0953L21.4903 11.963C21.5079 11.8895 21.5079 11.8139 21.4903 11.7404M14 9H18.01L19 11.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>
                                                    Shipping
                                                </span>
                                                <span class="summary-value">Free shipping</span>
                                            </div>

                                            <div class="summary-row">
                                                <span class="summary-label">VAT</span>
                                                <span class="summary-value">${{Cart::instance('cart')->tax()}}</span>
                                            </div>

                                            <div class="summary-divider"></div>

                                            <div class="summary-row total-row">
                                                <span class="summary-label">Total</span>
                                                <span class="summary-value total-value">${{Cart::instance('cart')->total()}}</span>
                                            </div>
                                        </div>
                                    </div>
                                <table class="checkout-totals">
                                    <tbody>
                                    <tr>
                                        <th>SUBTOTAL</th>
                                        <td align="right">${{Cart::instance('cart')->subtotal()}}</td>
                                    </tr>
                                    <tr>
                                        <th>SHIPPING</th>
                                        <td align="right">Free shipping</td>
                                    </tr>
                                    <tr>
                                        <th>VAT</th>
                                        <td align="right">${{Cart::instance('cart')->tax()}}</td>
                                    </tr>
                                    <tr>
                                        <th>TOTAL</th>
                                        <td align="right">${{Cart::instance('cart')->total()}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                                @endif
                            </div>
                            <div class="checkout__payment-methods">
                                <div class="form-check">
                                    <input class="form-check-input form-check-input_fill" type="radio" name="checkout_payment_method"
                                           id="checkout_payment_method_1" checked>
                                    <label class="form-check-label" for="checkout_payment_method_1">
                                        Direct bank transfer
                                        <p class="option-detail">
                                            Make your payment directly into our bank account. Please use your Order ID as the payment
                                            reference.Your order will not be shipped until the funds have cleared in our account.
                                        </p>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input form-check-input_fill" type="radio" name="checkout_payment_method"
                                           id="checkout_payment_method_2">
                                    <label class="form-check-label" for="checkout_payment_method_2">
                                        Check payments
                                        <p class="option-detail">
                                            Phasellus sed volutpat orci. Fusce eget lore mauris vehicula elementum gravida nec dui. Aenean
                                            aliquam varius ipsum, non ultricies tellus sodales eu. Donec dignissim viverra nunc, ut aliquet
                                            magna posuere eget.
                                        </p>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input form-check-input_fill" type="radio" name="checkout_payment_method"
                                           id="checkout_payment_method_3">
                                    <label class="form-check-label" for="checkout_payment_method_3">
                                        Cash on delivery
                                        <p class="option-detail">
                                            Phasellus sed volutpat orci. Fusce eget lore mauris vehicula elementum gravida nec dui. Aenean
                                            aliquam varius ipsum, non ultricies tellus sodales eu. Donec dignissim viverra nunc, ut aliquet
                                            magna posuere eget.
                                        </p>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input form-check-input_fill" type="radio" name="checkout_payment_method"
                                           id="checkout_payment_method_4">
                                    <label class="form-check-label" for="checkout_payment_method_4">
                                        Paypal
                                        <p class="option-detail">
                                            Phasellus sed volutpat orci. Fusce eget lore mauris vehicula elementum gravida nec dui. Aenean
                                            aliquam varius ipsum, non ultricies tellus sodales eu. Donec dignissim viverra nunc, ut aliquet
                                            magna posuere eget.
                                        </p>
                                    </label>
                                </div>
                                <div class="policy-text">
                                    Your personal data will be used to process your order, support your experience throughout this
                                    website, and for other purposes described in our <a href="terms.html" target="_blank">privacy
                                        policy</a>.
                                </div>
                            </div>
                            <button class="btn btn-primary btn-checkout">PLACE ORDER</button>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </main>
@endsection

@push('styles')
    <style>
        .address-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            padding: 0;
            transition: all 0.3s ease;
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
            border: 1px solid #f0f0f0;
        }

        .address-card__header {
            padding: 20px 25px;
            border-bottom: 1px solid #f5f5f5;
            position: relative;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }

        .address-card__name {
            font-weight: 700;
            font-size: 20px;
            margin-bottom: 0;
            color: #333;
            letter-spacing: -0.5px;
        }

        .address-card__badge {
            position: absolute;
            right: 20px;
            top: 18px;
            font-size: 12px;
            background: #4361ee;
            color: white;
            padding: 5px 15px 5px 10px;
            border-radius: 30px;
            font-weight: 600;
            display: flex;
            align-items: center;
            box-shadow: 0 4px 10px rgba(67, 97, 238, 0.25);
        }

        .address-svg-icon {
            width: 16px;
            height: 16px;
            margin-right: 5px;
        }

        .address-card__body {
            padding: 25px;
            display: flex;
            position: relative;
            background: linear-gradient(135deg, #ffffff 0%, #f9fafc 100%);
        }

        .address-card__icon {
            margin-right: 20px;
            color: #4361ee;
            padding-top: 3px;
        }

        .address-location-icon {
            width: 28px;
            height: 28px;
            stroke: #4361ee;
            stroke-width: 2;
        }

        .address-phone-icon, .address-zip-icon {
            width: 16px;
            height: 16px;
            stroke: #4361ee;
            margin-right: 8px;
            vertical-align: middle;
        }

        .address-card__content {
            flex: 1;
        }

        .address-card__details {
            position: relative;
        }

        .address-card__line {
            margin-bottom: 8px;
            color: #555;
            line-height: 1.6;
            font-size: 15px;
        }

        .address-card__line:last-child {
            margin-bottom: 0;
        }

        .zip-code {
            font-weight: 500;
            background: rgba(67, 97, 238, 0.1);
            padding: 2px 8px;
            border-radius: 4px;
            display: inline-block;
            vertical-align: middle;
        }

        .address-card__divider {
            margin: 15px 0;
            position: relative;
            height: 20px;
            display: flex;
            align-items: center;
        }

        .divider-svg {
            width: 100%;
            height: 2px;
            stroke: #e0e0e0;
            stroke-width: 1;
            stroke-dasharray: 5, 5;
        }

        .address-card__contact {
            display: flex;
            align-items: center;
            font-weight: 500;
            color: #333;
            font-size: 16px;
            background: rgba(67, 97, 238, 0.05);
            padding: 10px 15px;
            border-radius: 8px;
        }

        .address-card__footer {
            border-top: 1px solid #f0f0f0;
            padding: 15px 25px;
            text-align: right;
            background: #f8f9fa;
        }

        .address-edit-btn {
            display: inline-flex;
            align-items: center;
            font-weight: 600;
            color: #4361ee;
            font-size: 14px;
            text-decoration: none;
            transition: all 0.2s;
        }

        .address-edit-btn:hover {
            color: #2c3eb7;
            text-decoration: none;
        }

        .edit-icon {
            width: 16px;
            height: 16px;
            stroke: currentColor;
            margin-right: 8px;
        }

        @media (max-width: 768px) {
            .address-card {
                margin-bottom: 20px;
                border-radius: 12px;
            }

            .address-card__header {
                padding: 15px 20px;
            }

            .address-card__body {
                padding: 15px 20px;
                flex-direction: column;
            }

            .address-card__icon {
                margin-right: 0;
                margin-bottom: 15px;
                text-align: center;
            }

            .address-location-icon {
                width: 32px;
                height: 32px;
            }

            .address-card__badge {
                font-size: 11px;
                padding: 4px 12px 4px 8px;
            }

            .address-card__name {
                font-size: 18px;
                margin-right: 90px;
            }
        }

        .order-summary {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.08);
            margin-bottom: 25px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid #f0f0f0;
        }

        .order-summary:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 30px rgba(67, 97, 238, 0.12);
        }

        .order-summary__header {
            display: flex;
            align-items: center;
            padding: 20px 25px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-bottom: 1px solid #f0f0f0;
        }

        .summary-icon {
            width: 24px;
            height: 24px;
            stroke: #4361ee;
            margin-right: 15px;
        }

        .summary-title {
            font-weight: 700;
            font-size: 20px;
            color: #333;
            margin: 0;
            letter-spacing: -0.5px;
        }

        .order-summary__content {
            padding: 20px 25px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px dashed rgba(0,0,0,0.07);
        }

        .summary-row:last-child {
            border-bottom: none;
        }

        .summary-label {
            font-weight: 500;
            color: #555;
            display: flex;
            align-items: center;
        }

        .summary-value {
            font-weight: 600;
            color: #333;
        }

        .discount-row {
            background-color: rgba(67, 97, 238, 0.05);
            margin: 0 -25px;
            padding: 12px 25px;
            border-radius: 0;
        }

        .discount-badge {
            display: inline-flex;
            align-items: center;
            background: rgba(255, 107, 107, 0.1);
            color: #ff6b6b;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 13px;
            margin-right: 8px;
        }

        .discount-icon {
            width: 14px;
            height: 14px;
            stroke: #ff6b6b;
            margin-right: 4px;
        }

        .discount-value {
            color: #ff6b6b;
        }

        .subtotal-after {
            background-color: rgba(67, 97, 238, 0.02);
            font-weight: 500;
        }

        .shipping-icon {
            width: 18px;
            height: 18px;
            stroke: #4361ee;
            margin-right: 8px;
        }

        .shipping-option {
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .shipping-radio {
            appearance: none;
            width: 18px;
            height: 18px;
            border: 2px solid #4361ee;
            border-radius: 50%;
            margin-right: 8px;
            position: relative;
            cursor: pointer;
        }

        .shipping-radio:checked::after {
            content: '';
            position: absolute;
            width: 10px;
            height: 10px;
            background: #4361ee;
            border-radius: 50%;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .summary-divider {
            height: 1px;
            background: linear-gradient(90deg, rgba(67, 97, 238, 0) 0%, rgba(67, 97, 238, 0.3) 50%, rgba(67, 97, 238, 0) 100%);
            margin: 8px 0;
        }

        .total-row {
            padding-top: 20px;
            border-bottom: none;
        }

        .total-row .summary-label {
            font-size: 18px;
            font-weight: 700;
            color: #333;
        }

        .total-value {
            font-size: 20px;
            font-weight: 700;
            color: #4361ee;
        }

        @media (max-width: 768px) {
            .order-summary {
                border-radius: 12px;
            }

            .order-summary__header {
                padding: 15px 20px;
            }

            .order-summary__content {
                padding: 15px 20px;
            }

            .discount-row {
                margin: 0 -20px;
                padding: 12px 20px;
            }

            .summary-row {
                padding: 10px 0;
            }

            .total-row .summary-label,
            .total-value {
                font-size: 16px;
            }
        }

        .shipping-address-form {
            background-color: #ffffff;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.03);
            margin-bottom: 2rem;
            border: 1px solid #f0f0f0;
        }

        .form-section {
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 1px solid #f5f5f5;
        }

        .form-section:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

        .section-title {
            font-size: 1rem;
            font-weight: 600;
            color: #333;
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            letter-spacing: 0.5px;
        }

        .section-icon {
            width: 20px;
            height: 20px;
            stroke: #4361ee;
            stroke-width: 2;
            margin-right: 10px;
            flex-shrink: 0;
        }

        .input-container {
            position: relative;
            margin-bottom: 10px;
        }

        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            width: 18px;
            height: 18px;
            stroke: #4361ee;
            stroke-width: 2;
            opacity: 0.7;
            pointer-events: none;
            z-index: 10;
        }

        .form-control {
            padding: 0.75rem 1rem 0.75rem 2.8rem;
            border-radius: 10px;
            border: 1px solid #e0e0e0;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background-color: #f9fafc;
            box-shadow: none;
            height: auto;
            color: #495057;
        }

        .form-control:focus {
            border-color: #4361ee;
            background-color: #fff;
            box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.1);
        }

        .form-control::placeholder {
            color: #adb5bd;
            opacity: 0.7;
        }

        .error-message {
            color: #dc3545;
            font-size: 0.8rem;
            margin-top: 5px;
            display: block;
            font-weight: 500;
            padding-left: 10px;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .shipping-address-form {
                padding: 20px;
                border-radius: 12px;
            }

            .section-title {
                font-size: 0.95rem;
            }

            .input-container {
                margin-bottom: 15px;
            }

            .form-control {
                font-size: 0.9rem;
                padding: 0.7rem 1rem 0.7rem 2.5rem;
            }

            .input-icon {
                left: 12px;
                width: 16px;
                height: 16px;
            }
        }

        /* Hover and focus effects */
        .input-container:hover .input-icon {
            opacity: 1;
        }

        .input-container:hover .form-control {
            border-color: #c1c9d6;
        }

        /* Required field indicator */
        .form-control[required] {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8' viewBox='0 0 8 8'%3E%3Ccircle cx='4' cy='4' r='3' fill='%23dc3545' opacity='0.7'/%3E%3C/svg%3E");
            background-position: right 10px top 50%;
            background-repeat: no-repeat;
        }

        /* Mobile row spacing */
        @media (max-width: 767px) {
            .row.g-4 {
                --bs-gutter-y: 1rem;
            }
        }

        /* Button styling */
        .btn-checkout {
            width: 100%;
            padding: 15px;
            font-weight: 600;
            letter-spacing: 1px;
            margin-top: 20px;
            transition: all 0.3s ease;
            border-radius: 8px;
        }

        .btn-checkout:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(67, 97, 238, 0.2);
        }
    </style>
@endpush
