<?php

namespace App\Actions\Shop;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Database\Eloquent\Collection;

class CreateStripeCheckoutSession
{
    public function createFromCart(Cart $cart)
    {
        return $cart->customer
            ->allowPromotionCodes()
            ->checkout(
                $this->formatCartItems($cart->items),
                array_merge(
                    $this->buildCheckoutOptions($cart),
                    [
                        'metadata' => [
                            'customer_id' => $cart->customer->id,
                            'cart_id' => $cart->id,
                        ],
                    ],
                )
            );
    }

    private function buildCheckoutOptions(Cart $cart): array
    {
        $shipping_options_config = db_config('shop.shipping_costs', []);

        $shipping_enabled = db_config('shop.enable_shipping', false);

        if (! $shipping_enabled) {
            return [];
        }

        $totalAmount = $cart->items->sum(fn ($item) => $item->product->price * $item->quantity);
        $freeShippingThreshold = db_config('shop.enable_free_shipping', false) ? db_config('shop.free_shipping_threshold', 0) : 0;

        $shippingOptions = [];

        if ($totalAmount >= $freeShippingThreshold && $freeShippingThreshold > 0) {
            // Spedizione gratuita per ordini >= 50€
            $shippingOptions[] = [
                'shipping_rate_data' => [
                    'display_name' => 'Spedizione gratuita',
                    'type' => 'fixed_amount',
                    'fixed_amount' => [
                        'amount' => 0,
                        'currency' => 'eur',
                    ],
                ],
            ];
        } else {
            // Aggiungi le opzioni di spedizione definite nella configurazione
            $shipping_options_config = db_config('shop.shipping_costs', []);

            foreach ($shipping_options_config as $option) {
                $shippingOption = [
                    'shipping_rate_data' => [
                        'display_name' => $option['display_name'] ?? 'Spedizione',
                        'type' => $option['type'] ?? 'fixed_amount',
                        'fixed_amount' => [
                            'amount' => isset($option['amount']) ? (int) ($option['amount'] * 100) : 0, // in cents
                            'currency' => $option['currency'] ?? 'eur',
                        ],
                    ],
                ];

                if (isset($option['minimum']) && isset($option['minimum']['value']) && isset($option['minimum']['unit'])) {
                    $shippingOption['shipping_rate_data']['delivery_estimate']['minimum'] = [
                        'unit' => $option['minimum']['unit'],
                        'value' => (int) $option['minimum']['value'],
                    ];
                }

                if (isset($option['maximum']) && isset($option['maximum']['value']) && isset($option['maximum']['unit'])) {
                    $shippingOption['shipping_rate_data']['delivery_estimate']['maximum'] = [
                        'unit' => $option['maximum']['unit'],
                        'value' => (int) $option['maximum']['value'],
                    ];
                }

                $shippingOptions[] = $shippingOption;
            }

        }

        return [
            // 'customer_update' => [
            //     'shipping' => 'auto',
            // ],
            // 'billing_address_collection' => 'required',
            'shipping_address_collection' => [
                'allowed_countries' => ['IT'],
            ],
            'shipping_options' => $shippingOptions,
        ];
    }

    private function formatCartItems(Collection $items): array
    {

        $cartItems = $items->loadMissing(['product', 'product.book', 'product.book.media'])
            ->map(function (CartItem $item) {
                return [
                    'price_data' => [
                        'currency' => 'EUR',
                        'unit_amount' => $item->product->price * 100, // in cents
                        'product_data' => [
                            'name' => $item->product->name,
                            'images' => [
                                $item->product->book?->media?->first()?->getUrl(),
                            ],
                            // 'description' => $item->product->description,
                            'metadata' => [
                                'product_id' => $item->product->id,
                            ],
                        ],
                    ],
                    'quantity' => $item->quantity,
                ];
            })->toArray();

        return $cartItems;
    }
}
