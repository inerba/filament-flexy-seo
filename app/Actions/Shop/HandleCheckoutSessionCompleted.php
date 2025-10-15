<?php

namespace App\Actions\Shop;

use App\Models\Cart;
use App\Models\Customer;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Laravel\Cashier\Cashier;
use Stripe\LineItem;

class HandleCheckoutSessionCompleted
{
    public function handle($sessionId)
    {
        DB::transaction(function () use ($sessionId) {
            $session = Cashier::stripe()->checkout->sessions->retrieve($sessionId);

            $customer = Customer::find($session->metadata->customer_id);

            $cart = Cart::where('id', $session->metadata->cart_id)->first();

            $order = $customer->orders()->create([
                'stripe_checkout_session_id' => $session->id,
                'amount_shipping' => $session->total_details->amount_shipping,
                'amount_discount' => $session->total_details->amount_discount,
                'amount_tax' => $session->total_details->amount_tax,
                'amount_subtotal' => $session->amount_subtotal,
                'amount_total' => $session->amount_total,
                'billing_address' => [
                    'name' => $session->customer_details->name,
                    'city' => $session->customer_details->address->city,
                    'country' => $session->customer_details->address->country,
                    'line1' => $session->customer_details->address->line1,
                    'line2' => $session->customer_details->address->line2,
                    'postal_code' => $session->customer_details->address->postal_code,
                    'state' => $session->customer_details->address->state,
                ],
                'shipping_address' => [
                    'name' => $session->collected_information->shipping_details->name,
                    'city' => $session->collected_information->shipping_details->address->city,
                    'country' => $session->collected_information->shipping_details->address->country,
                    'line1' => $session->collected_information->shipping_details->address->line1,
                    'line2' => $session->collected_information->shipping_details->address->line2,
                    'postal_code' => $session->collected_information->shipping_details->address->postal_code,
                    'state' => $session->collected_information->shipping_details->address->state,
                ],
            ]);

            $lineItems = Cashier::stripe()->checkout->sessions->allLineItems($session->id);

            $orderItems = collect($lineItems->all())->map(function (LineItem $line) {

                $product = Cashier::stripe()->products->retrieve($line->price->product);

                return new OrderItem([
                    'product_id' => $product->metadata->product_id,
                    'name' => $product->name,
                    'description' => $product->description,
                    'price' => $line->price->unit_amount,
                    'quantity' => $line->quantity,
                    'amount_discount' => $line->amount_discount,
                    'amount_subtotal' => $line->amount_subtotal,
                    'amount_tax' => $line->amount_tax,
                    'amount_total' => $line->amount_total,

                ]);
            });

            $order->items()->saveMany($orderItems);

            // Elimina il carrello solo se esiste
            if ($cart) {
                $cart->items()->delete();
                $cart->delete();
            }
        });
    }
}
