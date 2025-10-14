<?php

namespace App\Actions\Shop;

use App\Models\Cart;

class MigrateSessionCart
{
    public function migrate(Cart $sessionCart, Cart $customerCart)
    {
        $sessionCart->items->each(fn ($item) => (new AddProductToCart)->add(
            productId: $item->product_id,
            quantity: $item->quantity,
            cart: $customerCart,
        ));

        $sessionCart->items()->delete();
        $sessionCart->delete();
    }
}
