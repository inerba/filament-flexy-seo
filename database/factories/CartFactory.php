<?php

namespace Database\Factories;

use App\Models\Cart;

class CartFactory
{
    public static function make(): Cart
    {
        return match (auth('customer')->guest()) {
            true => Cart::firstOrCreate(['session_id' => session()->getId()]),
            false => auth('customer')->user()->cart ?: auth('customer')->user()->cart()->create(),
        };
    }
}
