@props(['product', 'showText' => true])

@if(Cart::instance('wishlist')->content()->where('id', $product->id)->count() > 0)
    <a href="javascript:void(0)" class="menu-link menu-link_us-s add-to-wishlist filled-heart">
        <svg width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
            <use href="#icon_heart" />
        </svg>
        @if($showText)
            <span>Remove from Wishlist</span>
        @endif
    </a>
@else
    <form name="addtowishlist-form-{{ $product->id }}" id="addtowishlist-form-{{ $product->id }}" method="POST" action="{{ route('wishlist.add') }}">
        @csrf
        <input type="hidden" name="id" value="{{ $product->id }}">
        <input type="hidden" name="name" value="{{ $product->name }}">
        <input type="hidden" name="price" value="{{ $product->sale_price ?? $product->regular_price }}">
        <input type="hidden" name="quantity" value="1">
        <a href="javascript:void(0)" class="menu-link menu-link_us-s add-to-wishlist"
           onclick="document.getElementById('addtowishlist-form-{{ $product->id }}').submit();">
            <svg width="16" height="16" viewBox="0 0 20 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <use href="#icon_heart"/>
            </svg>
            @if($showText)
                <span>Add to Wishlist</span>
            @endif
        </a>
    </form>
@endif
