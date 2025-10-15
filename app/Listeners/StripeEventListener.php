<?php

namespace App\Listeners;

use App\Actions\Shop\HandleCheckoutSessionCompleted;
use Laravel\Cashier\Events\WebhookReceived;

class StripeEventListener
{
    public function handle(WebhookReceived $event): void
    {
        if ($event->payload['type'] === 'checkout.session.completed') {
            (new HandleCheckoutSessionCompleted)->handle($event->payload['data']['object']['id']);
        }
    }
}
