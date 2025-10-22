<?php

namespace App\Livewire\Shop;

use Livewire\Attributes\Computed;
use Livewire\Component;

class CheckoutStatus extends Component
{
    public $sessionId;

    public function mount()
    {
        $this->sessionId = request()->get('session_id');
    }

    #[Computed]
    public function order()
    {
        return auth('customer')->user()?->orders()->where('stripe_checkout_session_id', $this->sessionId)->first();
    }

    public function render()
    {
        return view('livewire.shop.checkout-status', [
            'sessionId' => $this->sessionId,
        ]);
    }
}
