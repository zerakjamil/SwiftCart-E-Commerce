<?php

namespace App\Models\Admin\V1;

class Cart extends \Surfsidemedia\Shoppingcart\Facades\Cart
{
    public static function productAddedToCart($productId): bool
    {
        return \Surfsidemedia\Shoppingcart\Facades\Cart::instance('cart')->content()->where('id',$productId)->count() > 0;
    }
}
