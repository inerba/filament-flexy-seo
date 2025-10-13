<?php

namespace App\Actions\Shop;

use App\Models\Product;
use Database\Factories\CartFactory;

class AddProductToCart
{
    /**
     * Aggiunge un prodotto al carrello dell'utente.
     *
     * Se l'utente non è autenticato, il carrello viene associato alla sessione corrente.
     * Se l'utente è autenticato, il carrello viene associato al suo account.
     * Se il carrello non esiste, ne viene creato uno nuovo.
     *
     * @param  Product  $product  Il prodotto da aggiungere al carrello.
     * @return void
     */
    public function add(Product $product)
    {
        $cart = CartFactory::make();

        $item = $cart->items()->firstOrCreate([
            'product_id' => $product->id,
        ], [
            'quantity' => 1,
        ]);

        // If the item already existed, aumentiamo la quantità
        if (! $item->wasRecentlyCreated) {
            $item->increment('quantity');
        }

    }
}
