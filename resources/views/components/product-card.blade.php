@props(['product'])

    <div class="product-card-wrapper">
        <div class="product-card mb-3 mb-md-4 mb-xxl-5">
            <div class="pc__img-wrapper">
                <div class="swiper-container background-img js-swiper-slider"
                     data-settings='{"resizeObserver": true}'>
                    <div class="swiper-wrapper">
                        @if($product->images)
                            @foreach($product->images as $image)
                                <div class="swiper-slide">
                                    <a href="{{ route('shop.show', $product->slug) }}">
                                        <img loading="lazy"
                                             src="{{ asset('uploads/products/'. $image['full']) }}"
                                             width="330"
                                             height="400"
                                             alt="{{ $product->name }}"
                                             class="pc__img">
                                    </a>
                                </div>
                            @endforeach
                        @else
                            <div class="swiper-slide">
                                <a href="{{ route('shop.show', $product->slug) }}">
                                    <img loading="lazy"
                                         src="{{ asset('uploads/products/' . $product->image) }}"
                                         width="330"
                                         height="400"
                                         alt="{{ $product->name }}"
                                         class="pc__img">
                                </a>
                            </div>
                        @endif
                    </div>
                    <span class="pc__img-prev">
                                            <svg width="7" height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_prev_sm"/>
                                            </svg>
                                        </span>
                    <span class="pc__img-next">
                                            <svg width="7" height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_next_sm"/>
                                            </svg>
                                        </span>
                </div>
                @if(\App\Models\Admin\V1\Cart::productAddedToCart($product->id))
                    <x-partials.button
                        type="a"
                        href="{{ route('cart.index')}}"
                        class="pc__atc  anim_appear-bottom btn btn-warning position-absolute border-0 text-uppercase fw-medium "
                        data-aside="cartDrawer"
                        title="Go To Cart"
                    >
                        Go to Cart
                    </x-partials.button>
                @else
                    <form name="addtocart-form-{{ $product->id }}" method="post" action="{{route('cart.add')}}">
                        @csrf
                        <x-partials.button
                        type="submit"
                        class="pc__atc btn anim_appear-bottom btn position-absolute border-0 text-uppercase fw-medium "
                        data-aside="cartDrawer"
                        title="Add To Cart"
                        id="add-to-cart-{{ $product->id }}"
                        >
                            Add To Cart
                        </x-partials.button>

                        <input type="hidden" name="id" value="{{$product->id}}">
                        <input type="hidden" name="name" value="{{$product->name}}">
                        <input type="hidden" name="price" value="{{$product->sale_price ?? $product->regular_price}}">
                        <input type="hidden" name="quantity" value="1">
                    </form>
                @endif
            </div>

            <div class="pc__info position-relative">
                <p class="pc__category">{{$product->category->name}}</p>
                <h6 class="pc__title"><a href="{{ route('shop.show',$product->slug) }}">{{$product->name}}</a></h6>
                <div class="product-card__price d-flex">
                        <span class="money price">
                            <div class="product-card__price d-flex flex-column align-items-start">
                                @if($product->isOnSale())
                                    <div class="d-flex align-items-center mb-1">
                                        <span class="text-muted text-decoration-line-through me-2">
                                            ${{number_format($product->regular_price, 2)}}
                                        </span>
                                        <span class="fw-bold text-red">
                                            ${{number_format($product->sale_price, 2)}}
                                        </span>
                                    </div>
                                    @if($product->discount_percentage)
                                        <div class="badge bg-red rounded-pill">
                                            {{$product->discount_percentage}}% OFF
                                        </div>
                                    @endif
                                @else
                                    <span class="fw-bold fs-5">
                                        ${{number_format($product->regular_price, 2)}}
                                    </span>
                                @endif
                            </div>
                        </span>
                </div>
                <div class="product-card__review d-flex align-items-center">
                    <div class="reviews-group d-flex">
                        <svg class="review-star" viewBox="0 0 9 9"
                             xmlns="http://www.w3.org/2000/svg">
                            <use href="#icon_star"/>
                        </svg>
                        <svg class="review-star" viewBox="0 0 9 9"
                             xmlns="http://www.w3.org/2000/svg">
                            <use href="#icon_star"/>
                        </svg>
                        <svg class="review-star" viewBox="0 0 9 9"
                             xmlns="http://www.w3.org/2000/svg">
                            <use href="#icon_star"/>
                        </svg>
                        <svg class="review-star" viewBox="0 0 9 9"
                             xmlns="http://www.w3.org/2000/svg">
                            <use href="#icon_star"/>
                        </svg>
                        <svg class="review-star" viewBox="0 0 9 9"
                             xmlns="http://www.w3.org/2000/svg">
                            <use href="#icon_star"/>
                        </svg>
                    </div>
                    <span class="reviews-note text-lowercase text-secondary ms-1">8k+ reviews</span>
                </div>
           <x-wishlistButton :product="$product" :showText="false"/>

            </div>
        </div>
    </div>
