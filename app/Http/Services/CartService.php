<?php

namespace App\Http\Services;

use App\Models\Admin\V1\Product;
use Illuminate\Support\Facades\Log;
use Surfsidemedia\Shoppingcart\Facades\Cart;

class CartService extends Service
{
    public function __construct(Product $product)
    {
        parent::__construct($product);
    }
    /**
     * Remove a product from all carts by product ID
     *
     * @param int $productId
     * @return bool
     */
    public function removeProductFromCart(int $productId): bool
    {
        try {
            $cartItems = Cart::instance('cart')->content();
            $found = false;

            foreach ($cartItems as $cartItem) {
                if ($cartItem->id == $productId) {
                    Cart::instance('cart')->remove($cartItem->rowId);
                    $found = true;
                }
            }

            if (!$found) {
                Log::info("Product {$productId} wasn't in any cart when deleted");
            }

            return true;
        } catch (\Exception $e) {
            Log::error("Error removing product from cart: " . $e->getMessage());
            return false;
        }
    }
}
