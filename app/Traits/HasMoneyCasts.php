<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasMoneyCasts
{
    /**
     * Return a reusable Attribute cast for money values stored as integer cents.
     */
    protected function moneyCast(): Attribute
    {
        return new Attribute(
            get: fn ($value) => $value / 100,
        );
    }
}
