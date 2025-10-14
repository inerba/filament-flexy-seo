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
    public function add($productId, $quantity = 1, $cart = null)
    {
        ($cart ?: CartFactory::make())->items()->firstOrCreate([
            'product_id' => $productId,
        ], [
            'quantity' => 0,
        ])->increment('quantity', $quantity);

    }
}
