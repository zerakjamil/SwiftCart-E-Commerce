@props(['item'])
<tr>
    <td>
        <div class="shopping-cart__product-item">
            <img loading="lazy" src="{{asset('uploads/products/'. $item->model->image)}}" width="120" height="120" alt="{{$item->name}}" />
        </div>
    </td>
    <td>
        <div class="shopping-cart__product-item__detail">
            <h4>{{$item->name}}</h4>
            <ul class="shopping-cart__product-item__options">
                <li>Color: Yellow</li>
                <li>Size: L</li>
            </ul>
        </div>
    </td>
    <td>
        <div class="product-card__price d-flex">
            <div class="product-card__price d-flex">
                ${{$item->price}}
{{--                @if($item->isOnSale())--}}
{{--                    <div class="d-flex align-items-center mb-1">--}}
{{--                        <span class="text-muted text-decoration-line-through me-2">--}}
{{--                            ${{number_format($item->regular_price, 2)}}--}}
{{--                        </span>--}}
{{--                        <span class="fw-bold text-red">--}}
{{--                           ${{number_format($item->sale_price, 2)}}--}}
{{--                        </span>--}}
{{--                    </div>--}}
{{--                    @if($item->discount_percentage)--}}
{{--                        <div class="discount-badge">--}}
{{--                            <span class="discount-percentage">{{$item->discount_percentage}}%</span>--}}
{{--                            <span class="discount-label">OFF</span>--}}
{{--                        </div>--}}
{{--                    @endif--}}
{{--                @else--}}
{{--                    <span class="fw-bold fs-5">--}}
{{--                        ${{number_format($item->regular_price, 2)}}--}}
{{--                    </span>--}}
{{--                @endif--}}
            </div>
        </div>
    </td>
    <td>
        <div class="qty-control position-relative">
            <input type="number" name="quantity" value="{{$item->qty}}" min="1" class="qty-control__number text-center">
            <div class="qty-control__reduce">-</div>
            <div class="qty-control__increase">+</div>
        </div>
    </td>
    <td>
        <span class="shopping-cart__subtotal">${{$item->subtotal()}}</span>
    </td>
    <td>
        <a href="#" class="remove-cart">
            <svg width="10" height="10" viewBox="0 0 10 10" fill="#767676" xmlns="http://www.w3.org/2000/svg">
                <path d="M0.259435 8.85506L9.11449 0L10 0.885506L1.14494 9.74056L0.259435 8.85506Z" />
                <path d="M0.885506 0.0889838L9.74057 8.94404L8.85506 9.82955L0 0.97449L0.885506 0.0889838Z" />
            </svg>
        </a>
    </td>
</tr>
