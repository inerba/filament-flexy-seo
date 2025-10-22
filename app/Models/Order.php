<?php

namespace App\Models;

use App\Enums\Shop\OrderStatus;
use App\Traits\HasMoneyCasts;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasMoneyCasts;

    protected $guarded = ['id'];

    protected $casts = [
        'billing_address' => 'array',
        'shipping_address' => 'array',
        'status' => OrderStatus::class,
    ];

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    protected function amountShipping(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return $this->moneyCast();
    }

    protected function amountSubtotal(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return $this->moneyCast();
    }

    protected function amountTotal(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return $this->moneyCast();
    }
}
